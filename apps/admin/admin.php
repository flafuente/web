<?php
//No direct access
defined('_EXE') or die('Restricted access');

class adminController extends Controller {

	public function init(){
		$url = Registry::getUrl();
		$config = Registry::getConfig();
		$config->set("template", "admin");
		$user = Registry::getUser();
		if($user->roleId<2){
			redirect(Url::site());
		}else{
			if(!$user->checkPermisos($url->action) && $url->action!="index"){
				redirect(Url::site());
			}
		}
	}

	public function index(){
		$user = Registry::getUser();
		if($user->checkPermisos("usuarios")){
			$this->users();
		}elseif($user->checkPermisos("cortos")){
			$this->videos();
		}else{
			redirect(Url::site());
		}
	}

	public function users(){
		$config = Registry::getConfig();
		$pag['total'] = 0;
		$pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
		$pag['limitStart'] = $_REQUEST['limitStart'];
		$this->setData("results", User::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
		$this->setData("pag", $pag);
		$html = $this->view("views.usersList");
		$this->render($html);
	}

	public function usersEdit(){
		$url = Registry::getUrl();
		$user = new User($url->vars[0]);
		$this->setData("user", $user);
		$html = $this->view("views.usersEdit");
		$this->render($html);
	}

	public function usersSave(){
		$user = new User($_REQUEST['id']);
		if($user->id){
			$res = $user->update($_REQUEST);
			if($res){
				Registry::addMessage("Usuario actualizado satisfactoriamente", "success", "", Url::site("admin/users"));
			}
		}else{
			$res = $user->insert($_REQUEST);
			if($res){
				Registry::addMessage("Usuario creado satisfactoriamente", "success", "", Url::site("admin/users"));
			}
		}
		$this->ajax();
	}

	public function usersDelete(){
		$url = Registry::getUrl();
		$user = new User($_REQUEST['id']);
		if($user->id){
			if($user->delete()){
				Registry::addMessage("Usuario eliminado satisfactoriamente", "success", "", Url::site("admin/users"));
			}
		}
		$this->ajax();
	}

	public function videos(){
		$config = Registry::getConfig();
		$pag['total'] = 0;
		$pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
		$pag['limitStart'] = $_REQUEST['limitStart'];
		$this->setData("results", Video::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
		$this->setData("pag", $pag);
		$html = $this->view("views.videosList");
		$this->render($html);
	}

	public function videosEdit(){
		$url = Registry::getUrl();
		$this->setData("video", new Video($url->vars[0]));
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
		$html = $this->view("views.videosEdit");
		$this->render($html);
	}

	public function videosSave(){
		$video = new Video($_REQUEST['id']);
		if($video->id){
			$res = $video->update($_REQUEST);
			if($res){
				Registry::addMessage("Video actualizado satisfactoriamente", "success", "", Url::site("admin/videos"));
			}
		}else{
			$res = $video->insert($_REQUEST);
			if($res){
				Registry::addMessage("Video creado satisfactoriamente", "success", "", Url::site("admin/videos"));
			}
		}
		$this->ajax();
	}

	public function videosDelete(){
		$url = Registry::getUrl();
		$video = new Video($_REQUEST['id']);
		if($video->id){
			if($video->delete()){
				Registry::addMessage("Video eliminado satisfactoriamente", "success", "", Url::site("admin/videos"));
			}
		}
		$this->ajax();
	}

	public function categorias(){
		$config = Registry::getConfig();
		$pag['total'] = 0;
		$pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
		$pag['limitStart'] = $_REQUEST['limitStart'];
		$this->setData("results", Categoria::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
		$this->setData("pag", $pag);
		$html = $this->view("views.categoriasList");
		$this->render($html);
	}

	public function categoriasEdit(){
		$url = Registry::getUrl();
		$categoria = new Categoria($url->vars[0]);
		$this->setData("categoria", $categoria);
		$html = $this->view("views.categoriasEdit");
		$this->render($html);
	}

	public function categoriasSave(){
		$categoria = new Categoria($_REQUEST['id']);
		if($categoria->id){
			$res = $categoria->update($_REQUEST);
			if($res){
				Registry::addMessage("Categoría actualizada satisfactoriamente", "success", "", Url::site("admin/categorias"));
			}
		}else{
			$res = $categoria->insert($_REQUEST);
			if($res){
				Registry::addMessage("Categoría creada satisfactoriamente", "success", "", Url::site("admin/categorias"));
			}
		}
		$this->ajax();
	}

	public function categoriasDelete(){
		$url = Registry::getUrl();
		$categoria = new Categoria($_REQUEST['id']);
		if($categoria->id){
			if($categoria->delete()){
				Registry::addMessage("Categoría eliminada satisfactoriamente", "success", "", Url::site("admin/categorias"));
			}
		}
		$this->ajax();
	}

	public function tags(){
		$config = Registry::getConfig();
		$pag['total'] = 0;
		$pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
		$pag['limitStart'] = $_REQUEST['limitStart'];
		$this->setData("results", Tag::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
		$this->setData("pag", $pag);
		$html = $this->view("views.tagsList");
		$this->render($html);
	}

	public function tagsEdit(){
		$url = Registry::getUrl();
		$tag = new Tag($url->vars[0]);
		$this->setData("tag", $tag);
		$html = $this->view("views.tagsEdit");
		$this->render($html);
	}

	public function tagsSave(){
		$tag = new Tag($_REQUEST['id']);
		if($tag->id){
			$res = $tag->update($_REQUEST);
			if($res){
				Registry::addMessage("Tag actualizado satisfactoriamente", "success", "", Url::site("admin/tags"));
			}
		}else{
			$res = $tag->insert($_REQUEST);
			if($res){
				Registry::addMessage("Tag creado satisfactoriamente", "success", "", Url::site("admin/tags"));
			}
		}
		$this->ajax();
	}

	public function tagsDelete(){
		$url = Registry::getUrl();
		$tag = new Tag($_REQUEST['id']);
		if($tag->id){
			if($tag->delete()){
				Registry::addMessage("Tag eliminado satisfactoriamente", "success", "", Url::site("admin/tags"));
			}
		}
		$this->ajax();
	}
}
