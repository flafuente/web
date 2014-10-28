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
        //Sección?
        if ($_REQUEST["seccionId"]) {
            $seccion = new Seccion($_REQUEST["seccionId"]);
            if ($seccion->id) {
                if ($seccion->sendEmail($_REQUEST)) {
                    Registry::addMessage(Language::translate("CTRL_CONTACTO_EMAIL_SENT"), "success", "", Url::site());
                }
            } else {
                Registry::addMessage(Language::translate("CTRL_CONTACTO_SECCION_ERROR"), "error", "seccionId");
            }
        } else {
            if ($_REQUEST["contactoId"]) {
                $contacto = new Contacto($_REQUEST["contactoId"]);
                if ($contacto->id) {
                    if (!$contacto->validateSend($_REQUEST)) {
                        if ($contacto->sendEmail($_REQUEST)) {
                            Registry::addMessage("Email enviado", "success", "", Url::site());
                        }
                    }
                } else {
                    Registry::addMessage(Language::translate("CTRL_CONTACTO_CONTACTO_ERROR"), "error", "contactoId");
                }
            }
        }
        $this->ajax();
    }
}
