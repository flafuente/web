<?php
//No direct access
defined('_EXE') or die('Restricted access');

class usersController extends Controller
{
    public function init()
    {
        //Revisamos si tiene permisos para acceder a esta sección
        $url = Registry::getUrl();
        $user = Registry::getUser();
        if (!$user->checkPermisos($url->action)) {
            redirect(Url::site());
        }
    }

    public function index()
    {
        $config = Registry::getConfig();
        $pag['total'] = 0;
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];
        $this->setData("results", User::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $user = new User($url->vars[0]);
        $this->setData("user", $user);
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $user = new User($_REQUEST['id']);
        if ($user->id) {
            $res = $user->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Usuario actualizado satisfactoriamente", "success", "", Url::site("admin/users"));
            }
        } else {
            $res = $user->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Usuario creado satisfactoriamente", "success", "", Url::site("admin/users"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $user = new User($_REQUEST['id']);
        if ($user->id) {
            if ($user->delete()) {
                Registry::addMessage("Usuario eliminado satisfactoriamente", "success", "", Url::site("admin/users"));
            }
        }
        $this->ajax();
    }
}
