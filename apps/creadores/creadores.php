<?php
//No direct access
defined('_EXE') or die('Restricted access');

class creadoresController extends Controller
{
    public function init() {}

    public function index()
    {
        $this->setData("secciones", Seccion::select());
        $html = $this->view("views.colaboradores");
        $this->render($html);
    }
}
