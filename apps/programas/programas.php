<?php
//No direct access
defined('_EXE') or die('Restricted access');

class programasController extends Controller
{
    public function init() {}

    public function index()
    {
        $this->setData("programas", Programa::select(array("estadoId"=>1)));
        $html = $this->view("views.programas");
        $this->render($html);
    }

    public function ver()
    {
        $url = Registry::getUrl();
        $programa = Programa::getProgramaBySlug($url->vars[0]);
        if ($programa->id) {
            //Programa
            $this->setData("programa", $programa);
            //Episodios
            $this->setData("capitulos", Capitulo::select(array("programaId"=>$programa->id)));
            //View
            $html = $this->view("views.programa");
            $this->render($html);
        } else {
            Helper::redirect(Url::site("programas"), "Programa no encontrado", "danger");
        }
    }
}
