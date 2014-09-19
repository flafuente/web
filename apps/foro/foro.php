<?php
//No direct access
defined('_EXE') or die('Restricted access');

class foroController extends Controller
{
    public function init() {
    	$user = Registry::getUser();
        if (!$user->id) {
            Url::redirect(Url::site("login"));
        }
        $this->setData("user", $user);
        
    }

    public function index() {
        $html = $this->view("views.foro");
        $this->render($html);
    }

    public function tema(){
        $user = Registry::getUser();
        $seccionEjemplo = new stdClass();
        $seccionEjemplo->icono = Url::template("img/weirdicon.png");
        $seccionEjemplo->tema = "Funcionamiento del foro";
        $seccionEjemplo->titulo = "No sé como crear un post y no encuentro como borrarlos";
        $seccionEjemplo->descripcion = "Normas de utilización del Foro triber";
        $seccionEjemplo->thumb = $user->getFotoUrl();
        $seccionEjemplo->lastpost = "Ultimo post";
        $seccionEjemplo->tiempo = "2 meses";
        $seccionEjemplo->creador = $user->username;
        $seccionEjemplo->ntemas = rand(5, 500);
        $seccionEjemplo->nactua = rand(1, 10);
        $this->setData("seccion", $seccionEjemplo);

        $foros = Array();
        $this->setData("foros", $foros);

        $html = $this->view("views.tema");
        $this->render($html);

    }
    public function comentario(){
        $user = Registry::getUser();
        $comentarioEjemplo = new stdClass();
        $comentarioEjemplo->icono = Url::template("img/weirdicon.png");
        $comentarioEjemplo->titulo = "Funcionamiento del foro";
        $comentarioEjemplo->descripcion = "Normas de utilización del Foro triber";
        $comentarioEjemplo->thumb = $user->getFotoUrl();
        $comentarioEjemplo->lastpost = "Ultimo post";
        $comentarioEjemplo->lastpost_desc = "hace x tiempo por ".$user->username;
        $comentarioEjemplo->ntemas = rand(5, 500);
        $comentarioEjemplo->nactua = rand(1, 10);
        $this->setData("comentario", $comentarioEjemplo);

        $html = $this->view("views.comentario");
        $this->render($html);

    }

}
