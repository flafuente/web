<?php
//No direct access
defined('_EXE') or die('Restricted access');

class homeController extends Controller
{
    public function init() {}

    public function index()
    {
        $this->setData("categorias", Categoria::select(array(),4));
        $html = $this->view("views.secciones");
        $this->render($html, "landing");
    }
}
