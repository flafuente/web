<?php
//No direct access
defined('_EXE') or die('Restricted access');

class episodiosController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.secciones");
		$this->render($html);
	}
}
