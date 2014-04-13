<?php
//No direct access
defined('_EXE') or die('Restricted access');

set_time_limit(0);

class apiController extends Controller {

	public function init(){}

	public function index(){}

	public function upload(){
		//Clear error messages
		Registry::getMessages();
		//Custom upload handler
		$options = array(
			"maxNumberOfFiles" => 1,
			"accept_file_types" => "/\.(mp4|mpg|flv|mpeg|avi)$/i",
		);
		$upload_handler = new UploadHandler($options);
	}
}
