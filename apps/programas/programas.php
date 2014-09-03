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
        $data = array("estadoId"=>1);
        //Categoría?
        if ($url->vars[0]) {
            $categoria = @current(Categoria::getBy("slug", $url->vars[0]));
            if ($categoria->id) {
                //Categoria (Twitter hashtag)
                $categoria->setConfigHashtag();
                //Categoria Id
                $data["categoriaId"] = $categoria->id;
            } else {
                Url::redirect(Url::site("programas"), "Programa no encontrado", "danger");
            }
        } else {
            Url::redirect(Url::site("programas"), "Programa no encontrado", "danger");
        }
        $this->setData("categoria",$categoria);
        $this->setData("programas", Programa::select($data));
        $html = $this->view("views.programas");
        $this->render($html);
    }

    public function ver()
    {
        $url = Registry::getUrl();
        $programa = @current(Programa::getBy("slug", $url->vars[0]));
        if ($programa->id) {
            //Categoria (Twitter hashtag)
            $categoria = new Categoria($programa->categoriaId);
            $categoria->setConfigHashtag();
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
