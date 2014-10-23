<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);

// Libs
include 'vendor/autoload.php';
// Config
include 'config.php';

$config = Registry::getConfig();

// Args
$parameters = Cli::getArgs($argv);
if (!in_array($parameters["a"], array("fixMedias", "searchWistia", "fixEntradas", "deleteWistias")) || isset($parameters["h"]) || isset($parameters["help"])) {
    // Help
    Cli::output("Usage: ".$argv[0]." [options]\n", "help");
    Cli::output("   -a: <fixMedias | fixEntradas | searchWistia | deleteWistias>", "help");
    Cli::finish("   -v: Verbosity level", "help");
} else {
    // Debug
    if ($parameters["v"] > 0) {
        define("DEBUG", true);
    } else {
        define("DEBUG", false);
    }
}

switch ($parameters["a"]) {

    /**
     * Fix Medias
     */
    case 'fixMedias':
        Cli::output("Fix Medias", "title");

        //Wistia init
        Wistia::init();

        //Capitulos
        $capitulos = Capitulo::select();
        foreach ($capitulos as $capitulo) {
            Cli::output($capitulo->titulo, "notice");
            //Check media status by cdnid
            if ($capitulo->cdnId) {
                $res = Wistia::status($capitulo->cdnId);
            } else {
                $res = null;
            }
            if (!$res->hashed_id || $res->project->name == 'Uploads360' && $res->status != 'ready') {
                Cli::output('Error CDN', 'error');
                $capitulo->cndId = '';
                //Try to search by houseNumber
                $houseNumber = $capitulo->getHouseNumber();
                if ($houseNumber) {
                    $res = Wistia::searchMedia($houseNumber.".mxf");
                    if (!empty($res)) {
                        $fixed = false;
                        foreach ($res as $r) {
                            if ($r->project->name != 'Uploads360' && $r->status == 'ready') {
                                $capitulo->cdnId = $r->hashed_id;
                                $capitulo->estadoId = 1;
                                $capitulo->update();
                                $fixed = true;
                                Cli::output('CND vinculado ('.$capitulo->cdnId.')!', 'success');
                                break;
                            }
                        }
                        if (!$fixed) {
                            Cli::output('Los archivos encontrados no cumplen los requisitos (Uploads 360 / Status ready', 'error');
                            $capitulo->estadoId = 0;
                            $capitulo->update();
                        }
                        continue;
                    } else {
                        Cli::output('CDN no localizado', 'error');
                    }
                } else {
                    Cli::output('Sin HouseNumber', 'error');
                }
                $capitulo->estadoId = 0;
                $capitulo->update();
                continue;
            } else {
                Cli::output('CDN Ok!', 'success');
            }
        }
    break;

    /**
     * Fix Entradas
     *
     * Recorrer los capitulos con EntradaID y comprobar que esta vinculada (Volcar el 2x01).
     */
    case 'fixEntradas':
        Cli::output("Fix Entradas", "title");

        // Capitulos
        $capitulos = Capitulo::select(array('hasEntradaId' => 1));
        foreach ($capitulos as $capitulo) {
            Cli::output($capitulo->titulo, "notice");
            $programa = new Programa($capitulo->programaId);
            $data = array(
                "id" => $capitulo->entradaId,
                "programaId" => $capitulo->programaId,
                "programa" => $programa->titulo,
                "capitulo" => $capitulo->getNumero(),
                "titulo" => $capitulo->getFullTitulo($programa),
            );
            $result = curl($config->get("parrillasUrl")."/external/updateEntrada/", $data);
            $json = json_decode($result);
            if (isset($json->data->status) && $json->data->status == ok) {
                Cli::output("Entrada actualizada!", "success");
            } else {
                Cli::output("Error: ".$json->data->error, "error");
            }
        }
    break;

    /**
     * Fix Search Wistia
     *
     * Primero que saque todos los capitulos en la web que tengan HOUSENUMBER y sin CDN de Wistia.
     * Busque en wistia si esta su HOUSENUMBER y los empareje.
     */
    case 'searchWistia':
        Cli::output("Fix Search Wistia", "title");

        //Wistia init
        Wistia::init();

        //Capitulos con Entrada y sin wistia
        $capitulos = Capitulo::select(array('hasEntradaId' => 1, 'hasCdnId' => 0));
        foreach ($capitulos as $capitulo) {
            Cli::output($capitulo->titulo, "notice");
            // Leemos su HouseNumber
            $houseNumber = $capitulo->getHouseNumber();
            if ($houseNumber) {
                //Buscamos el HouseNumber en Wistia
                $res = Wistia::searchMedia($houseNumber.".mxf");
                if (!empty($res)) {
                    $fixed = false;
                    foreach ($res as $r) {
                        if ($r->status == 'ready') {
                            $capitulo->cdnId = $r->hashed_id;
                            $capitulo->estadoId = 1;
                            if ($r->project->name == 'Uploads360') {
                                // Movemos
                                $capitulo->moveWistia360();
                                Cli::output('Video movido fuera de 360!', 'success');
                            }
                            $capitulo->update();
                            $fixed = true;
                            Cli::output('CND vinculado ('.$capitulo->cdnId.')!', 'success');
                            break;
                        } else {
                            Cli::output('Status: '.$r->status, 'warning');
                        }
                    }
                    if (!$fixed) {
                        Cli::output('Capitulo no fixeado', 'error');
                        $capitulo->estadoId = 0;
                        $capitulo->update();
                    }
                    continue;
                } else {
                    Cli::output('CDN no localizado ('.$houseNumber.')', 'error');
                }
            } else {
                Cli::output('Sin HouseNumber', 'error');
            }
        }
    break;

    /**
     * Fix Delete wistias
     *
     * Luego que se folle todos los archivos que tenemos en Wistia y no estan como CDN ID en la web
     * (Con excepcion de los videos que estan en los proyectos:
     *     https://tribo.wistia.com/projects/ereel7jcqh
     *     https://tribo.wistia.com/projects/cy8k4iha9x)
     * Cuando digo CDN en la web revisar "Tanto en Videos como en Capitulos"
     */
    case 'deleteWistias':
        $db = Registry::getDb();

        Cli::output("Fix Delete Wistias", "title");

        //Wistia init
        Wistia::init();

        $projects = Wistia::listProjects();
        foreach ($projects as $project) {
            Cli::output($project->name, 'title');
            $medias = Wistia::listMedias($project->hashedId);
            if (count($medias)) {
                foreach ($medias as $media) {
                    Cli::output("Media: ".$media->hashed_id, 'notice');
                    //Capitulo asociado?
                    if ($db->query("SELECT * FROM `capitulos` WHERE cdnId = :cdnId LIMIT 1", array(':cdnId' => $media->hashed_id))) {
                        continue;
                    }
                    //Video asociado?
                    if ($db->query("SELECT * FROM `videos` WHERE cdnId = :cdnId LIMIT 1", array(':cdnId' => $media->hashed_id))) {
                        continue;
                    }
                    //Borramos
                    Cli::output('Eliminando vídeo...', 'warning');
                    if ($parameters['d']) {
                        Wistia::delete($media->hashed_id);
                        Cli::output('Video eliminado!', 'success');
                    }
                }
            } else {
                Cli::output('Proyecto sin medias', 'notice');
            }
        }
    break;

}
