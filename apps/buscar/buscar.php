<?php
//No direct access
defined('_EXE') or die('Restricted access');

class buscarController extends Controller
{
    public function init() {}

    public function index()
    {
        //Url::redirect(Url::site());
    }

    public function byAjax()
    {
        $search = $_REQUEST["search"];
        //Programas
        $this->setData("programas", Programa::select(array("search" => $search)), 3);
        //Capitulos
        $this->setData("capitulos" ,Capitulo::select(array("search" => $search)), 3);
        //View
        echo $this->view("views.ajax");
    }
}
