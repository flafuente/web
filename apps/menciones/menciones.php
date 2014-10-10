<?php
//No direct access
defined('_EXE') or die('Restricted access');

class mencionesController extends Controller
{
    public function init()
    {
    }

    public function index()
    {
        $config = Registry::getConfig();

        $_REQUEST["estadoId"] = 1;

        // Pagination
        $pag = array();

        // Total
        $pag['total'] = 0;

        // Limit
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];

        // List Select
        $this->setData("menciones", Mencion::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));

        // Setting data to View
        $this->setData("pag", $pag);

        $html = $this->view("views.listado");
        $this->render($html);
    }
}
