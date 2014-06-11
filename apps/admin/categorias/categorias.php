<?php
//No direct access
defined('_EXE') or die('Restricted access');

class categoriasController extends Controller
{
    public function init()
    {
        $url = Registry::getUrl();
        $config = Registry::getConfig();
        $config->set("template", "admin");
        $user = Registry::getUser();
        if ($user->roleId<2) {
            redirect(Url::site());
        } else {
            if (!$user->checkPermisos($url->action)) {
                redirect(Url::site());
            }
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
        $categoria = new Categoria($_REQUEST['id']);
        if ($categoria->id) {
            if ($categoria->delete()) {
                Registry::addMessage("Categoría eliminada satisfactoriamente", "success", "", Url::site("admin/categorias"));
            }
        }
        $this->ajax();
    }
}