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

    public function seccion()
    {
        $url = Registry::getUrl();

        //Redirección news -> tribonews
        if ($url->vars[0] == "news") {
            Url::redirect(Url::site("tribonews"));
        }

        $data = array("estadoId" => 1);
        //Sección?
        if ($url->vars[0]) {
            $seccion = @current(Seccion::getBy("slug", $url->vars[0]));
            if ($seccion->id) {
                //Categoria (Twitter hashtag)
                $seccion->setConfigHashtag();
                //Categoria Id
                $data["seccionId"] = $seccion->id;
            } else {
                Url::redirect(Url::site("programas"), "Sección no encontrada", "danger");
            }
        } else {
            Url::redirect(Url::site("programas"), "Sección no encontrada", "danger");
        }
        $this->setData("seccion",$seccion);
        $this->setData("programas", Programa::select($data));
        $html = $this->view("views.programas");
        $this->render($html);
    }

    public function ver()
    {
        $url = Registry::getUrl();
        $programa = @current(Programa::getBy("slug", $url->vars[0]));
        if ($programa->id) {
            //Sección (Twitter hashtag)
            $seccion = new Seccion($programa->seccionId);
            $seccion->setConfigHashtag();
            //Programa
            $this->setData("programa", $programa);
            //Capítulos
            $this->setData("temporadas", Capitulo::groupByTemporadas(Capitulo::select(array("programaId"=>$programa->id))));
            //View
            $html = $this->view("views.programa");
            $this->render($html);
        } else {
            Url::redirect(Url::site("programas"), "Programa no encontrado", "danger");
        }
    }
}
