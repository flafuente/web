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
                //Marcamos el archivo de vídeo como "conversión en curso"
                $videoArchivo->estadoConversionId = 1;
                $videoArchivo->update();
                //Enviamos el archivo de vídeo
                $result[] = $videoArchivo->getWsApi();
            }
            WS::addData("videosArchivos", $result);
        }
        WS::output();
    }

    /**
     * Videos to be uploaded at wistia
     */
    public function toUpload()
    {
        //Videos con estadoCdnId a 0 y con archivos de video publicados
        $videosArchivos = VideoArchivo::select(array(
            "pendienteWistia" => true,
        ), 1);
        if (count($videosArchivos)) {
            $result = array();
            foreach ($videosArchivos as $videoArchivo) {
                //Marcamos el video como "subida en curso"
                $video = new Video($videoArchivo->videoId);
                //$video->estadoCdnId = 1;
                //$video->update();
                //Enviamos el archivo de vídeo
                $result[] = $videoArchivo->getWsApi();
            }
            WS::addData("videosArchivos", $result);
        }
        WS::output();
    }

    /**
     * Uploading videos (to Wistia)
     */
    public function uploading()
    {
        //Videos con estadoCdnId a en conversion
        $videos = Video::select(array(
            "estadoCdnId" => 2,
        ), 1);
        if (count($videos)) {
            $result = array();
            foreach ($videos as $video) {
                //Enviamos el archivo de vídeo
                $result[] = $video->getWsApi();
            }
            WS::addData("videos", $result);
        }
        WS::output();
    }

    public function updateVideo()
    {
        $video = new Video($_REQUEST["id"]);
        if (!$video->update($_REQUEST)) {
            //Response
            WS::setCode(1005);
        }
        WS::output();
    }

    public function updateVideoArchivo()
    {
        $videoArchivo = new VideoArchivo($_REQUEST["id"]);
        if (!$videoArchivo->update($_REQUEST)) {
            //Response
            WS::setCode(1005);
            //Borrar el vídeo original del servidor
            $videoArchivo->deleteFile();
        }
        WS::output();
    }
}
