<?php
//No direct access
defined('_EXE') or die('Restricted access');

class misvideosController extends Controller
{
    public function init() {
    	$user = Registry::getUser();
        if (!$user->id) {
            Url::redirect(Url::site("login"));
        }
    }

    public function index(){
        $html = $this->view("views.misvideos");
        $this->render($html);
    }

}
