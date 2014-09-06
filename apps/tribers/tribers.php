<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tribersController extends Controller
{
    public function init() {
    	$triber = Registry::getTriber();
    }

    public function index(){
        $html = $this->view("views.tribers");
        $this->render($html);
    }

}
