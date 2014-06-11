<?php
//No direct access
defined('_EXE') or die('Restricted access');

class adminControllerRouter extends Controller
{
    public function init()
    {
        $user = Registry::getUser();
        $url = Registry::getUrl();
        if (!$user->checkPermisos($url->action)) {
            redirect(Url::site());
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
