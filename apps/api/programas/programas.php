<?php
//No direct access
defined('_EXE') or die('Restricted access');

class programasController extends Controller
{
    public function init()
    {
        //Headers
        WS::setHeaders();
    }

    public function index() {}

    public function entradas()
    {
        $programas = Programa::select(
            array(
                "search" => $_REQUEST["q"],
            ), 30
        );
        $this->ajax(array("programas" => $programas));
    }

    public function syncParrillas()
    {
        $tmp = explode("x", strtolower($_REQUEST["capitulo"]));
        $temporada = $tmp[0];
        $episodio = (int) $tmp[1];
        $capitulo = Capitulo::getCapituloByTemporadaEpisodio($_REQUEST["programaId"], $temporada, $episodio);
        if ($capitulo->id) {
            $capitulo->entradaId = $_REQUEST["id"];
            $capitulo->update();
        } else {
            $capitulo = new Capitulo();
            $capitulo->entradaId = $_REQUEST["id"];
            $capitulo->programaId = $_REQUEST["programaId"];
            $capitulo->temporada = $temporada;
            $capitulo->episodio = $episodio;
            $capitulo->titulo = $_REQUEST["titulo"];
            $capitulo->estadoId = 0;
            $capitulo->insert();
        }
        $this->ajax(array("status" => "ok"));
    }
}
