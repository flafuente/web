<?php
//No direct access
defined('_EXE') or die('Restricted access');

class contactoController extends Controller
{
    public function init() {}

    public function index()
    {
        Url::redirect();
    }

    public function enviar()
    {
        $categoria = new Categoria($_REQUEST["categoriaId"]);
        if ($categoria->id) {
            if ($categoria->sendEmail($_REQUEST)) {
                Registry::addMessage("Email enviado", "success", "", Url::site());
            }
        } else {
            Registry::addMessage("Sección incorrecta", "error", "seccionId");
        }
        $this->ajax();
    }
}
