<?php
//No direct access
defined('_EXE') or die('Restricted access');

class parrillaController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.parrilla");
		$this->render($html);
	}
}
