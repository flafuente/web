<?php
//No direct access
defined('_EXE') or die('Restricted access');

class colaboradoresController extends Controller {

	public function init(){}

	public function index(){
		$this->setData("secciones", Seccion::select());
		$html = $this->view("views.colaboradores");
        $this->render($html);
	}

	public function contacto(){
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
