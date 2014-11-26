<?php
//No direct access
defined('_EXE') or die('Restricted access');

class articulosController extends Controller
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
        $this->setData("results", Articulo::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $articulo = new Articulo($url->vars[0]);
        $this->setData("articulo", $articulo);
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $articulo = new Articulo($_REQUEST['id']);
        if ($articulo->id) {
            $res = $articulo->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Artículo actualizado satisfactoriamente", "success", "", Url::site("admin/articulos"));
            }
        } else {
            $res = $articulo->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Artículo creado satisfactoriamente", "success", "", Url::site("admin/articulos"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $articulo = new Articulo($id);
        if ($articulo->id) {
            if ($articulo->delete()) {
                Registry::addMessage("Artículo eliminado satisfactoriamente", "success");
            }
        }
        Url::redirect(Url::site("admin/articulos"));
    }
}
