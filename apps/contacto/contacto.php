<?php
//No direct access
defined('_EXE') or die('Restricted access');

class contactoController extends Controller {

	public function init(){}

	public function index(){
		Url::redirect();
	}

	public function enviar(){
		$seccion = new Seccion($_REQUEST["seccionId"]);
		if($seccion->id){
			if($seccion->sendEmail($_REQUEST)){
				Registry::addMessage("Email enviado", "success", "", Url::site());
			}
		}else{
			Registry::addMessage("Sección incorrecta", "error", "seccionId");
		}
		$this->ajax();
	}
}