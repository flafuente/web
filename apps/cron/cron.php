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

    public function updateTweets(){
        $hashtags = array("#TriboTv", "#TriboDirecto", "#TriboLike");
        foreach($hashtags as $hashtag){
            $arrayTweets = Tweet::getTweetAPI($hashtag);
            if(count($arrayTweets)){
                foreach($arrayTweets as $arrayTweet){
                    $tweet = new Tweet();
                    $tweet->parseAPI($arrayTweet);
                    if(!Tweet::getBy("tweet_id", $tweet->tweet_id)){
                        $tweet->insert();
                    }
                }
            }
        }
    }
}
