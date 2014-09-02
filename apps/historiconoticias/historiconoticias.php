<?php
//No direct access
defined('_EXE') or die('Restricted access');

class historiconoticiasController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.historiconoticias");
		$this->render($html);
	}
}
