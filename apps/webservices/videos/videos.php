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
        //User logged?
        $user = WS::getUser();
        if (!$user->id) {
            WS::setCode(1003);
            WS::output();
        }
    }

    /**
     * Default
     */
    public function index()
    {
        die("Tribo WS: Videos");
    }

    /**
     * User videos list
     */
    public function my()
    {
        //Get user videos
        $user = WS::getUser();
        WS::addData("videos", Video::select(array(
            "userId" => $user->id,
        )));
        WS::output();
    }

    /**
     * Upload
     */
    public function upload()
    {
        $video = new Video();
        $video->insert($_REQUEST);
        WS::output();
    }
}
