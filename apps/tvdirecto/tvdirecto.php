<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tvdirectoController extends Controller
{
    public function init() {}

    public function index(){
        $html = $this->view("views.tvdirecto");
        $this->render($html);
    }

}
