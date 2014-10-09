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
        $_REQUEST["estadoId"] = 1;
        $this->setData("menciones", Mencion::select($_REQUEST));
        $html = $this->view("views.listado");
        $this->render($html);
    }
}
