<?php
//No direct access
defined('_EXE') or die('Restricted access');

class cronRouter extends Controller
{
    public function init() {}

    public function index()
    {
        Url::redirect(Url::site());
    }

    /**
     * Borra los archivos de vídeo convertidos
     */
    public function deleteVideos()
    {
        $videoArchivos = VideoArchivo::select(array("estadoConversionId" => 2));
        if (count($videoArchivos)) {
            foreach ($videoArchivos as $videoArchivo) {
                $videoArchivo->deleteFile();
            }
        }
    }
}
