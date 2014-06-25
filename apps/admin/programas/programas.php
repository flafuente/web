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
            redirect(Url::site());
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
        $this->setData("categorias", Categoria::select());
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $user = Registry::getUser();
        $url = Registry::getUrl();
        $this->setData("programa", new Programa($url->vars[0]));
        //Limitamos las categorías de los validadores
        $selectCategorias = array(
            "order" => "nombre",
            "orderDir" => "ASC"
        );
        if ($user->roleId==3) {
            $categoriasIds = $user->getCategoriasIds();
            if (is_array($categoriasIds) && count($categoriasIds)) {
                $selectCategorias["categoriasIds"] = $categoriasIds;
            }
        }
        $this->setData("categorias", Categoria::select($selectCategorias));
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
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
        $programa = new Programa($_REQUEST['id']);
        if ($programa->id) {
            if ($programa->delete()) {
                Registry::addMessage("Programa eliminado satisfactoriamente", "success", "", Url::site("admin/programas"));
            }
        }
        $this->ajax();
    }
}
