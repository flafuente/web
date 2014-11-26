<?php
//No direct access
defined('_EXE') or die('Restricted access');

class slideshowController extends Controller
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
        $this->setData("results", Slide::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $this->setData("slide", new Slide($url->vars[0]));
        $this->setData("slides", Slide::select());
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $_REQUEST["form"] = true;
        $slide = new Slide($_REQUEST['id']);
        if ($slide->id) {
            $res = $slide->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Slide actualizada satisfactoriamente", "success", "", Url::site("admin/slideshow"));
            }
        } else {
            $res = $slide->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Slide creada satisfactoriamente", "success", "", Url::site("admin/slideshow"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $slide = new Slide($id);
        if ($slide->id) {
            if ($slide->delete()) {
                Registry::addMessage("Slide eliminada satisfactoriamente", "success");
            }
        }
        Url::redirect(Url::site("admin/slideshow"));
    }
}
