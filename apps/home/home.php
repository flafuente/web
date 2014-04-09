<?php
//No direct access
defined('_EXE') or die('Restricted access');

class homeController extends Controller {

	public function init(){}

	public function index(){
		$user = Registry::getUser();
		if($user->id){
			redirect(Url::site("home/tu_haces_tribo"));
		}else{
			$this->render($html, "landing");
		}
	}

	public function inicio(){
		$html = $this->view("views.home");
		$this->render($html);
	}

	public function sintonizanos(){
		$html = $this->view("views.sintonizanos");
		$this->render($html);
	}
	public function tu_haces_tribo(){
		$html = $this->view("views.tu_haces_tribo");
		$this->render($html);
	}
	public function programa(){
		$html = $this->view("views.programa");
		$this->render($html);
	}
}
