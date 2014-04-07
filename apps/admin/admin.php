<?php
//No direct access
defined('_EXE') or die('Restricted access');

class adminController extends Controller {

	public function init(){
		$config = Registry::getConfig();
		$config->set("template", "admin");
		$user = Registry::getUser();
		if($user->roleId<2){
			redirect(Url::site());
		}
	}

	public function index(){
		$this->users();
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
		$video = new Video($url->vars[0]);
		$this->setData("video", $video);
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
}
