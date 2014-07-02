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
            if ($user->roleId<=USER_ROLE_VALIDADOR) {
                Helper::redirect(Url::site());
            }
        } else {
            Helper::redirect(Url::site("login"));
        }
    }

    public function index()
    {
        $user = Registry::getUser();
        if ($user->checkPermisos("usuarios")) {
            Helper::redirect(Url::site("admin/users"));
        } elseif ($user->checkPermisos("cortos")) {
            Helper::redirect(Url::site("admin/videos"));
        } else {
            Helper::redirect(Url::site());
        }
    }
}
