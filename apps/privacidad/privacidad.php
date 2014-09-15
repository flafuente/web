<?php
//No direct access
defined('_EXE') or die('Restricted access');

class privacidadController extends Controller
{
    public function init() {}

    public function index()
    {
        $html = $this->view("views.privacidad");
        $this->render($html);
    }
}
