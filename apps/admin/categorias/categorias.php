<?php
//No direct access
defined('_EXE') or die('Restricted access');

class categoriasController extends Controller
{
    public function init()
    {
        //Revisamos si tiene permisos para acceder a esta sección
        $url = Registry::getUrl();
        $user = Registry::getUser();
        if (!$user->checkPermisos($url->app)) {
            Helper::redirect(Url::site());
        }
    }

    public function index()
    {
        $config = Registry::getConfig();
        $pag['total'] = 0;
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];
        $this->setData("results", Categoria::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();
        $this->setData("categoria", new Categoria($url->vars[0]));
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $categoria = new Categoria($_REQUEST['id']);
        if ($categoria->id) {
            $res = $categoria->update($_REQUEST);
            if ($res) {
                Registry::addMessage("Categoría actualizada satisfactoriamente", "success", "", Url::site("admin/categorias"));
            }
        } else {
            $res = $categoria->insert($_REQUEST);
            if ($res) {
                Registry::addMessage("Categoría creada satisfactoriamente", "success", "", Url::site("admin/categorias"));
            }
        }
        $this->ajax();
    }

    public function delete()
    {
        $url = Registry::getUrl();
        $id = $_REQUEST["id"] ? $_REQUEST["id"] : $url->vars[0];
        $categoria = new Categoria($id);
        if ($categoria->id) {
            if ($categoria->delete()) {
                Registry::addMessage("Categoría eliminada satisfactoriamente", "success");
            }
        }
        Helper::redirect(Url::site("admin/categorias"));
    }
}
