<?php
//No direct access
defined('_EXE') or die('Restricted access');

class parrillaController extends Controller
{
    public function init()
    {
        //Revisamos si tiene permisos para acceder a esta sección
        $url = Registry::getUrl();
        $user = Registry::getUser();
        if (!$user->checkPermisos($url->app)) {
            Helper::redirect(Url::site());
        }
    }

    public function index()
    {
        //Programas
        $this->setData("programas", Programa::select());
        //Vista
        $html = $this->view("views.edit");
        $this->render($html);
    }
}
