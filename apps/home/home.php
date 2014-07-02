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
			Helper::redirect(Url::site("home/home"));
		}else{
			$this->render($html, "landing");
		}
	}

	public function home(){
		$this->render("");
	}
}
