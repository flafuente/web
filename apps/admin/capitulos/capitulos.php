<?php
//No direct access
defined('_EXE') or die('Restricted access');

class capitulosController extends Controller
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
        $this->setData("results", Capitulo::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);

        //Programas
        $this->setData("programas", Programa::select(array("order" => "titulo")));

        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $this->setData("capitulo", new Capitulo($url->vars[0]));
        $this->setData("programas", Programa::select());
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $capitulo = new Capitulo($_REQUEST['id']);
        if ($capitulo->id) {
            $res = $capitulo->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Capítulo actualizado satisfactoriamente", "success", "", Url::site("admin/capitulos"));
            }
        } else {
            $res = $capitulo->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Capítulo creado satisfactoriamente", "success", "", Url::site("admin/capitulos"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $capitulo = new Capitulo($id);
        if ($capitulo->id) {
            if ($capitulo->delete()) {
                Registry::addMessage("Capítulo eliminado satisfactoriamente", "success");
            }
        }
        Url::redirect(Url::site("admin/capitulos"));
    }
}
