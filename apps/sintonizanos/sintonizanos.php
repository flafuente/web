<?php
//No direct access
defined('_EXE') or die('Restricted access');

class sintonizanosController extends Controller
{
    public function init() {}

    public function index(){
        $html = $this->view("views.sintonizanos");
        $this->render($html);
    }

}
