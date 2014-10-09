<?php
//No direct access
defined('_EXE') or die('Restricted access');

class prensaController extends Controller
{
    public function init()
    {
    }

    public function index()
    {
        $this->setData("notas", Nota::select(array("estadoId" => 1, "order" => "fecha", "orderDir" => "DESC")));
        $html = $this->view("views.prensa");
        $this->render($html);
    }

    public function nota()
    {
        $url = Registry::getUrl();
        $nota = new Nota($url->vars[0]);
        if ($nota->id) {
            $this->setData("nota", $nota);
            $html = $this->view("views.nota");
            $this->render($html);
        } else {
            Url::redirect(Url::site("prensa"));
        }

    }
}
