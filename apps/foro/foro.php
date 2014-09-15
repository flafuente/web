<?php
//No direct access
defined('_EXE') or die('Restricted access');

class foroController extends Controller
{
    public function init() {
    	$user = Registry::getUser();
        if (!$user->id) {
            Url::redirect(Url::site("login"));
        }
        $this->setData("user", $user);
        $html = $this->view("views.foro");
        $this->render($html);
    }

    public function index() {}

}
