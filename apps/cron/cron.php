<?php
//No direct access
defined('_EXE') or die('Restricted access');

class cronController extends Controller
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

    public function updateTweets()
    {
        $hashtags = array("#TriboTv", "#TriboDirecto", "#TriboLike");
        foreach ($hashtags as $hashtag) {
            $arrayTweets = Tweet::getTweetAPI($hashtag);
            if (count($arrayTweets)) {
                foreach ($arrayTweets as $arrayTweet) {
                    $tweet = new Tweet();
                    $tweet->parseAPI($arrayTweet);
                    if (!Tweet::getBy("tweet_id", $tweet->tweet_id)) {
                        $tweet->insert();
                    }
                }
            }
        }
    }

    public function importParrilla()
    {
        $config = Registry::getConfig();
        $fecha = date("Y-m-d", strtotime("yesterday"));
        $result = curl($config->get("parrillasUrl")."/external/parrilla/", array("fecha" => $fecha));
        $json = json_decode($result);
        if (is_object($json)) {
            Evento::importar($json->data->eventos, $fecha);
        }
    }
}
