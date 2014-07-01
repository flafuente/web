<?php
//No direct access
defined('_EXE') or die('Restricted access');

class haztetriberController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.haztetriber");
		$this->render($html);
	}
}
