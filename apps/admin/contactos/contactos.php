<?php
//No direct access
defined('_EXE') or die('Restricted access');

class contactosController extends Controller
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
        $this->setData("results", Contacto::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $this->setData("contacto", new Contacto($url->vars[0]));
        $this->setData("secciones", Seccion::select());
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $contacto = new Contacto($_REQUEST['id']);
        if ($contacto->id) {
            $res = $contacto->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Contacto actualizada satisfactoriamente", "success", "", Url::site("admin/contactos"));
            }
        } else {
            $res = $contacto->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Contacto creada satisfactoriamente", "success", "", Url::site("admin/contactos"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $contacto = new Contacto($id);
        if ($contacto->id) {
            if ($contacto->delete()) {
                Registry::addMessage("Contacto eliminada satisfactoriamente", "success");
            }
        }
        Url::redirect(Url::site("admin/contactos"));
    }
}
