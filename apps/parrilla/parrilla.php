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
        $fechaInicio = $_REQUEST["fecha"]." 00:00:00";
        $fechaFin = $_REQUEST["fecha"]." 24:00:00";
        $this->setData("eventos", Evento::select(array("fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin, "order" => "fechaInicio")));
        $data = array();
        $data["html"] = $this->view("views.today");
        $this->ajax($data);
    }

    public function ahora()
    {
        //Seleccionamos los 3 siguientes eventos
        $this->setData("eventos", Evento::select(array(
            'fechaInicio' => date('Y-m-d H:i:s', strtotime("now -30minutes")),
            'order' => 'fechaInicio',
            'orderDir' => 'ASC',
        ), 3));
        $data = array();
        $data["html"] = $this->view("views.ahora");
        $this->ajax($data);
    }
}
