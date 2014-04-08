<?php
//No direct access
defined('_EXE') or die('Restricted access');

class videosController extends Controller {

	public function init(){
		$user = Registry::getUser();
		if(!$user->id){
			redirect(Url::site("login"));
		}
	}

	public function index(){
		$config = Registry::getConfig();
		$pag['total'] = 0;
		$pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
		$pag['limitStart'] = $_REQUEST['limitStart'];
		//Forzamos a mostrar sólo los videos publicados
		$_REQUEST["estadoId"] = 1;
		$this->setData("results", Video::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
		$this->setData("pag", $pag);
		$html = $this->view("views.list");
		$this->render($html);
	}

	public function nuevo(){
		$this->setData("video", new Video());
		$this->setData("categorias", Categoria::select(
			array(
				"order" => "nombre",
				"orderDir" => "ASC"
			)
		));
		$this->setData("tags", Tag::select(
			array(
				"order" => "nombre",
				"orderDir" => "ASC"
			)
		));
		$html = $this->view("views.nuevo");
		$this->render($html);
	}

	public function save(){
		$video = new Video();
		$res = $video->insert($_REQUEST);
		if($res){
			Registry::addMessage("Video enviado satisfactoriamente", "success", "", Url::site("videos"));
		}
		$this->ajax();
	}
}
