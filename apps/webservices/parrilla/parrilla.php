<?php
//No direct access
defined('_EXE') or die('Restricted access');

class parrillaController extends Controller
{

    /**
     * Init
     */
    public function init() {}

    /**
     * Default
     */
    public function index()
    {
        if (!$_REQUEST["fecha"]) {
            $_REQUEST["fecha"] = date("Y-m-d");
        }
        $fechaInicio = $_REQUEST["fecha"]." 00:00:00";
        $fechaFin = $_REQUEST["fecha"]." 24:00:00";
        $eventos = Evento::select(array("fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin, "order" => "fechaInicio"));
        $eventosJson = array();
        if (count($eventos)) {
            foreach ($eventos as $evento) {
                $eventosJson[] = $evento->getWs();
            }
        }
        WS::addData("eventos", $eventosJson);
        WS::output();
    }
}
