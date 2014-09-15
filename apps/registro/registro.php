<?php
//No direct access
defined('_EXE') or die('Restricted access');

class registroController extends Controller
{
    public function init() {}

    public function index()
    {
        $html = $this->view("views.registro");
        $this->render($html);
    }
}
