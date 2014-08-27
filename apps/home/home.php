<?php
//No direct access
defined('_EXE') or die('Restricted access');

class homeController extends Controller
{
    public function init() {}

    public function index()
    {
        $this->setData("programas", Programa::select(array("destacado" => true),4));
        $html = $this->view("views.programas");
        $this->render($html, "landing");
    }
}
