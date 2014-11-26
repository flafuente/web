<?php
//No direct access
defined('_EXE') or die('Restricted access');

class quienessomosController extends Controller
{
    public function init() {}

    public function index(){
        $html = $this->view("views.quienessomos");
        $this->render($html);
    }

}
