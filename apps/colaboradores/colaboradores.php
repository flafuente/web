<?php
//No direct access
defined('_EXE') or die('Restricted access');

class colaboradoresController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.colaboradores");
		$this->render($html);
	}
}
