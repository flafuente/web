<?php
//No direct access
defined('_EXE') or die('Restricted access');

class apiController extends Controller {

	public function init(){}

	public function index(){}

	public function upload(){
		//Clear error messages
		Registry::getMessages();
		//Custom upload handler
		$options = array(
			"maxNumberOfFiles" => 1,
			"accept_file_types" => "/\.(mp4|mpg|flv|mpeg)$/i",
		);
		$upload_handler = new UploadHandler($options);
	}
}
