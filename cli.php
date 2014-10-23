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
if (!in_array($parameters["a"], array("fixMedias", "fixEntradas")) || isset($parameters["h"]) || isset($parameters["help"])) {
    // Help
    Cli::output("Usage: ".$argv[0]." [options]\n", "help");
    Cli::output("   -a: <fixMedias | fixEntradas>", "help");
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
                    if (is_array($res)) {
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
     */
    case 'fixEntradas':
        Cli::output("Fix Entradas", "title");

        // Capitulos
        $capitulos = Capitulo::select(array('hasEntradaId' => true));
        foreach ($capitulos as $capitulo) {
            Cli::output($capitulo->titulo, "notice");
            $programa = new Programa($capitulo->programaId);
            $result = curl($config->get("parrillasUrl")."/external/updateEntrada/", array(
                "id" => $capitulo->id,
                "programaId" => $capitulo->programaId,
                "programa" => $programa->titulo,
                "capitulo" => $capitulo->getNumero(),
                "titulo" => $capitulo->getFullTitulo($programa),
            ));
            $json = json_decode($result);
            if (isset($json->data->status) && $json->data->status == ok) {
                Cli::output("Entrada actualizada!", "success");
            } else {
                Cli::output("Error: ".$json->data->error, "error");
            }
        }
    break;

}
