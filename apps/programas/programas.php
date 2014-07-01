<?php
//No direct access
defined('_EXE') or die('Restricted access');

class programasController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.programas");
		$this->render($html);
	}
}
