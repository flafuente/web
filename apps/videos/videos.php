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
		//Forzamos a mostrar sólo los videos publicados
		$_REQUEST["estadoId"] = 1;
		$this->setData("videosNovedades", Video::select(
			array(
				"order" => "dateInsert",
				"orderDir" => "DESC"
			), 5));
		$html = $this->view("views.list");
		$this->setData("videosRankingSemanal", Video::getRankingSemanal(5));
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

	public function ver(){
		$url = Registry::getUrl();
		$video = new Video($url->vars[0]);
		if($video->id){
			//Creamos la visita
			$video->addVisita();
			$this->setData("video", $video);
			$html = $this->view("views.ver");
			$this->render($html);
		}else{
			redirect(Url::site(), "Video incorrecto", "error");
		}
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
