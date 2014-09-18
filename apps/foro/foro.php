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
        $seccionEjemplo->titulo = "Funcionamiento del foro";
        $seccionEjemplo->descripcion = "Normas de utilización del Foro triber";
        $seccionEjemplo->thumb = $user->getFotoUrl();
        $seccionEjemplo->lastpost = "Ultimo post";
        $seccionEjemplo->lastpost_desc = "hace x tiempo por ".$user->username;
        $seccionEjemplo->ntemas = rand(5, 500);
        $seccionEjemplo->nactua = rand(1, 10);
        $this->setData("seccion", $seccionEjemplo);

        $html = $this->view("views.tema");
        $this->render($html);

    }

}
