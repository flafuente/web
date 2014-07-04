<?php
//No direct access
defined('_EXE') or die('Restricted access');

class reproductorController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.reproductor");
		$this->render($html);
	}
}
