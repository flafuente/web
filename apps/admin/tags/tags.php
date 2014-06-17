<?php
//No direct access
defined('_EXE') or die('Restricted access');

class tagsController extends Controller
{
    public function init()
    {
        //Revisamos si tiene permisos para acceder a esta sección
        $url = Registry::getUrl();
        $user = Registry::getUser();
        if (!$user->checkPermisos($url->app)) {
            redirect(Url::site());
        }
    }

    public function index()
    {
        $config = Registry::getConfig();
        $pag['total'] = 0;
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];
        $this->setData("results", Tag::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $tag = new Tag($url->vars[0]);
        $this->setData("tag", $tag);
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $tag = new Tag($_REQUEST['id']);
        if ($tag->id) {
            $res = $tag->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Tag actualizado satisfactoriamente", "success", "", Url::site("admin/tags"));
            }
        } else {
            $res = $tag->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Tag creado satisfactoriamente", "success", "", Url::site("admin/tags"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $tag = new Tag($_REQUEST['id']);
        if ($tag->id) {
            if ($tag->delete()) {
                Registry::addMessage("Tag eliminado satisfactoriamente", "success", "", Url::site("admin/tags"));
            }
        }
        $this->ajax();
    }
}
