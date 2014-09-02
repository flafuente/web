<?php
//No direct access
defined('_EXE') or die('Restricted access');

class colaboradoresController extends Controller
{
    public function init() {}

    public function index()
    {
        $this->setData("categorias", Categoria::select(array("tipoId" => 2)));
        $html = $this->view("views.colaboradores");
        $this->render($html);
    }
}
