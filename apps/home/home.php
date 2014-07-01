<?php
//No direct access
defined('_EXE') or die('Restricted access');

class homeController extends Controller {

	public function init(){}

/*
	public function index(){
		$html = $this->view("views.secciones");
		$this->render($html);
	}
*/
	public function index(){
		$user = Registry::getUser();
		if($user->id){
			redirect(Url::site("home/tu_haces_tribo"));
		}else{
			$this->render($html, "landing");
		}
	}
}
