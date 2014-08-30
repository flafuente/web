<?php
//No direct access
defined('_EXE') or die('Restricted access');

class videosController extends Controller
{

    /**
     * Init
     */
    public function init()
    {
        // User logged?
        $user = WS::getUser();
        if (!$user->id) {
            WS::setCode(1003);
            WS::output();
        // Admin?
        } elseif ($user->roleId<USER_ROLE_ADMIN) {
            WS::setCode(1006);
            WS::output();
        }
    }

    /**
     * Default
     */
    public function index()
    {
        die("Tribo API: Videos");
    }

    /**
     * Videos to be converted
     */
    public function toConvert()
    {
        //Archivos de video pendientes de conversión
        $videosArchivos = VideoArchivo::select(array(
            "estadoConversionId" => 0,
        ), 1);
        if (count($videosArchivos)) {
            $result = array();
            foreach ($videosArchivos as $videoArchivo) {
                //Marcamos como "conversión en curso"
                $videoArchivo->estadoConversionId = 1;
                $videoArchivo->update();
                $result[] = $videoArchivo->getWsApi();
            }
            WS::addData("videosArchivos", $result);
        }
        WS::output();
    }

    public function update()
    {
        $videoArchivo = new VideoArchivo($_REQUEST["id"]);
        if (!$videoArchivo->update($_REQUEST)) {
            //Response
            WS::setCode(1005);
            //TODO: Borrar el vídeo original del servidor
            $videoArchivo->deleteFile();
        }
        WS::output();
    }
}
