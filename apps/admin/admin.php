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
            if ($user->roleId<USER_ROLE_VALIDADOR) {
                Url::redirect(Url::site());
            }
        } else {
            Url::redirect(Url::site("login"));
        }
    }

    public function index()
    {
        $user = Registry::getUser();
        if ($user->checkPermisos("usuarios")) {
            Url::redirect(Url::site("admin/users"));
        } elseif ($user->checkPermisos("cortos")) {
            Url::redirect(Url::site("admin/videos"));
        } else {
            Url::redirect(Url::site());
        }
    }
}
