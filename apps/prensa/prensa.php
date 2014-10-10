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
        $config = Registry::getConfig();

        $_REQUEST["estadoId"] = 1;
        $_REQUEST["order"] = "fecha";
        $_REQUEST["orderDir"] = "DESC";

        // Pagination
        $pag = array();

        // Total
        $pag['total'] = 0;

        // Limit
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];

        // List Select
        $this->setData("notas", Nota::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        // Setting data to View
        $this->setData("pag", $pag);

        $this->setData("notasFecha", Nota::totalMeses());
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
