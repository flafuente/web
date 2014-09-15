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
        //Categoría?
        if ($_REQUEST["seccionId"]) {
            $seccion = new Seccion($_REQUEST["seccionId"]);
            if ($seccion->id) {
                if ($seccion->sendEmail($_REQUEST)) {
                    Registry::addMessage("Email enviado", "success", "", Url::site());
                }
            } else {
                Registry::addMessage("Sección incorrecta", "error", "seccionId");
            }
        } else {
            if ($_REQUEST["contactoId"]) {
                $contacto = new Contacto($_REQUEST["contactoId"]);
                if ($contacto->id) {
                    if ($contacto->sendEmail($_REQUEST)) {
                        Registry::addMessage("Email enviado", "success", "", Url::site());
                    }
                } else {
                    Registry::addMessage("Contacto incorrecto", "error", "contactoId");
                }
            }
        }
        $this->ajax();
    }
}
