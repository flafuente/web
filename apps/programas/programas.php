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

        $data = array("estadoId" => 1, "order" => "order", "orderDir" => "ASC");
        //Sección?
        if ($url->vars[0]) {
            $seccion = @current(Seccion::getBy("slug", $url->vars[0]));
            if ($seccion->id) {
                //Sección (Twitter hashtag)
                $seccion->setConfigHashtag();
                //Sección Id
                $data["seccionId"] = $seccion->id;
            } else {
                Url::redirect(Url::site("programas"), Language::translate("CTRL_PROGRAMAS_SECCION_NOTFOUND"), "danger");
            }
        } else {
            Url::redirect(Url::site("programas"), Language::translate("CTRL_PROGRAMAS_SECCION_NOTFOUND"), "danger");
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
            $this->setData("temporadas", Capitulo::groupByTemporadas(Capitulo::select(array("programaId" => $programa->id, "estadoId" => 1, 'order' => 'temporadas'))));
            //View
            $html = $this->view("views.programa");
            $this->render($html);
        } else {
            Url::redirect(Url::site("programas"), Language::translate("CTRL_PROGRAMAS_PROGRAMA_NOTFOUND"), "danger");
        }
    }
}
