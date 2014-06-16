<?php
//No direct access
defined('_EXE') or die('Restricted access');

set_time_limit(0);

class apiController extends Controller
{
    public function init() {}

    public function index() {}

    public function upload()
    {
        //Clear error messages
        Registry::getMessages();
        //Config
        $config = Registry::getConfig();
        //Custom upload handler
        $options = array(
            'upload_dir' => $config->get("path")."/files/videos/",
            'upload_url' => Url::site("files/videos"),
            "maxNumberOfFiles" => 1,
            "accept_file_types" => "/\.(mp4|mpg|flv|mpeg|avi)$/i",
        );
        $upload_handler = new UploadHandler($options);
    }
}
