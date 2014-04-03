<?php
//No direct access
defined('_EXE') or die('Restricted access');

class homeController extends Controller {

	public function init(){}

	public function index(){
		$html = $this->view("views.home");
		$this->render($html);
	}

	public function sintoniza(){
		$html = $this->view("views.sintoniza");
		$this->render($html);
	}
}
