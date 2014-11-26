<?php
//No direct access
defined('_EXE') or die('Restricted access');

class traduccionesController extends Controller
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
        $this->setData("results", Location::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        $this->setData("pag", $pag);
        $html = $this->view("views.list");
        $this->render($html);
    }

    public function edit()
    {
        $url = Registry::getUrl();

        $langId = $url->vars[0];
        $item = $url->vars[1];
        $itemId = $url->vars[2];

        $this->setData("langId", $langId);
        $this->setData("item", $item);
        $this->setData("itemId", $itemId);

        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $item = $_REQUEST['item'];
        $langId = $_REQUEST['langId'];
        $itemId = $_REQUEST['itemId'];
        $fields = $_REQUEST['field'];
        if (count($fields)) {
            foreach ($fields as $field => $value) {
                Location::save($langId, $item, $itemId, $field, $value);
            }
            Registry::addMessage("Traducción guardada satisfactoriamente", "success", "", Url::site("admin/traducciones"));
        } else {
            Registry::addMessage("No se han encontrado campos", "error");
        }
        $this->ajax();
    }

    public function delete()
    {
        $item = $_REQUEST['item'];
        $langId = $_REQUEST['langId'];
        $itemId = $_REQUEST['itemId'];
        Location::delete($langId, $item, $itemId);
        Registry::addMessage("Traducción eliminada satisfactoriamente", "success");
        Url::redirect(Url::site("admin/traducciones"));
    }

    public function getItems()
    {
        $data = array();
        $class = ucfirst($_REQUEST['item']);
        if (class_exists($class) && isset(Location::$items[$_REQUEST['item']])) {
            $items = $class::select();
            if (count($items)) {
                foreach ($items as $item) {
                    $data['items'][$item->id] = Location::itemToString($item);
                }
            }
        }

        $this->ajax($data);
    }

    public function getItem()
    {
        $data = array();
        $class = ucfirst($_REQUEST['item']);
        if (class_exists($class) && isset(Location::$items[$_REQUEST['item']])) {
            $item = new $class($_REQUEST['itemId']);
            $data['fields'] = Location::getItemFields($item);
            //Traducciones existentes?
            if (count($data['fields'])) {
                foreach ($data['fields'] as $name => &$field) {
                    $location = Location::translate($item, $name, $_REQUEST['langId']);
                    if ($location) {
                        $field['value'] = $location;
                    }
                }
            }
        }

        $this->ajax($data);
    }
}
