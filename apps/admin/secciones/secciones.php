<?php
//No direct access
defined('_EXE') or die('Restricted access');

class seccionesController extends Controller
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
        $this->setData("results", Seccion::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $this->setData("seccion", new Seccion($url->vars[0]));
        $this->setData("contactos", Contacto::select());
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $seccion = new Seccion($_REQUEST['id']);
        if ($seccion->id) {
            $res = $seccion->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Sección actualizada satisfactoriamente", "success", "", Url::site("admin/secciones"));
            }
        } else {
            $res = $seccion->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Sección creada satisfactoriamente", "success", "", Url::site("admin/secciones"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $seccion = new Seccion($id);
        if ($seccion->id) {
            if ($seccion->delete()) {
                Registry::addMessage("Sección eliminada satisfactoriamente", "success");
            }
        }
        Url::redirect(Url::site("admin/secciones"));
    }
}
