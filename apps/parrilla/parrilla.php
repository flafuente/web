<?php
//No direct access
defined('_EXE') or die('Restricted access');

class parrillaController extends Controller
{
    public function init() {}

    public function index()
    {
        $html = $this->view("views.parrilla");
        $this->render($html);
    }

    public function today()
    {
        $fechaInicio = $_REQUEST["fecha"];
        $fechaFin = $_REQUEST["fecha"];
        $this->setData("eventos", Evento::select(array("fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin, "order" => "fechaInicio")));
        $data = array();
        $data["html"] = $this->view("views.today");
        $this->ajax($data);
    }
}
