<?php
//No direct access
defined('_EXE') or die('Restricted access');

class adminControllerRouter extends Controller
{
    public function init()
    {
        //Usamos el template Admin
        $config = Registry::getConfig();
        $config->set("template", "admin");
        //Nos aseguramos de que es admin
        $user = Registry::getUser();
        if ($user->id) {
            if ($user->roleId<3) {
                redirect(Url::site());
            }
        } else {
            redirect(Url::site("login"));
        }
    }

    public function index()
    {
        $user = Registry::getUser();
        if ($user->checkPermisos("usuarios")) {
            redirect(Url::site("admin/users"));
        } elseif ($user->checkPermisos("cortos")) {
            redirect(Url::site("admin/videos"));
        } else {
            redirect(Url::site());
        }
    }
}
