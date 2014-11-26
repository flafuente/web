<?php
//No direct access
defined('_EXE') or die('Restricted access');

class parrillaController extends Controller
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
        //Programas
        $this->setData("programas", Programa::select());
        //Eventos
        $this->setData("eventos", Evento::select(array("fechaInicio" => $_REQUEST["date"], "fechaFin" => date("Y-m-d", strtotime($_REQUEST["date"]." + 7 days")))));
        //Vista
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $data["result"] = "error";
        $evento = new Evento($_REQUEST['id']);
        if ($evento->id) {
            if ($evento->update($_REQUEST)) {
                $data["result"] = "ok";
                $data["evento"] = $evento;
            }
        } else {
            if ($evento->insert($_REQUEST)) {
                $data["result"] = "ok";
                $data["evento"] = $evento;
            }
        }
        $this->ajax($data);
    }

    public function delete()
    {
        $data["result"] = "error";
        $evento = new Evento($_REQUEST['id']);
        if ($evento->id) {
            if ($evento->delete()) {
                $data["result"] = "ok";
            }
        }
        $this->ajax($data);
    }

    public function importar()
    {
        $config = Registry::getConfig();

        $result = curl($config->get("parrillasUrl")."/external/parrilla/", array("fecha" => $_REQUEST["date"]));
        $json = json_decode($result);
        if (is_object($json)) {
            Evento::importar($json->data->eventos, $_REQUEST["date"]);
            Url::redirect(Url::site("admin/parrilla/?date=".$_REQUEST["date"]));
        }
    }
}
