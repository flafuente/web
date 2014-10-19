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
        WS::addData("eventos", Evento::select(array("fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin, "order" => "fechaInicio")));
        WS::output();
    }
}
