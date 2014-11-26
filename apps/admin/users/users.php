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
        if (!$user->checkPermisos($url->app)) {
            Url::redirect(Url::site());
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
        $this->setData("user", new User($url->vars[0]));
        $this->setData("categorias", Categoria::select());
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
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $user = new User($id);
        if ($user->id) {
            if ($user->delete()) {
                Registry::addMessage("Usuario eliminado satisfactoriamente", "success");
            }
        }
        Url::redirect(Url::site("admin/users"));
    }
}
