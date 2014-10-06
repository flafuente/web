<?php
//No direct access
defined('_EXE') or die('Restricted access');

class programasController extends Controller
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
        $this->setData("results", Programa::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $this->setData("secciones", Seccion::select());
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $programa = new Programa($url->vars[0]);
        $this->setData("programa", $programa);
        $this->setData("programas", Programa::select(array("seccionId" => $programa->seccionId)));
        $this->setData("secciones", Seccion::select());
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $_REQUEST["form"] = true;
        $programa = new Programa($_REQUEST['id']);
        if ($programa->id) {
            $res = $programa->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Programa actualizado satisfactoriamente", "success", "", Url::site("admin/programas"));
            }
        } else {
            $res = $programa->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Programa creado satisfactoriamente", "success", "", Url::site("admin/programas"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $programa = new Programa($id);
        if ($programa->id) {
            if ($programa->delete()) {
                Registry::addMessage("Programa eliminado satisfactoriamente", "success");
            }
        }
        Url::redirect(Url::site("admin/programas"));
    }
}
