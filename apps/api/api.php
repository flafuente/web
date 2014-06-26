<?php
//No direct access
defined('_EXE') or die('Restricted access');

set_time_limit(0);

class apiController extends Controller
{
    public function init()
    {
        $user = Registry::getUser();
        if (!$user->id) {
            redirect(Url::site("login"));
        }
    }

    public function index() {}

    public function uploadVideo()
    {
        //Clear error messages
        Registry::getMessages();
        //Config
        $config = Registry::getConfig();
        //Upload Handler
        new UploadHandler(
            array(
                'upload_dir' => $config->get("path")."/files/videos/",
                'upload_url' => Url::site("files/videos")."/",
                "maxNumberOfFiles" => 1,
                "accept_file_types" => "/\.(mp4|mpg|flv|mpeg|avi)$/i",
            )
        );
    }
}
