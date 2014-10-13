<?php
//No direct access
defined('_EXE') or die('Restricted access');

class perfilController extends Controller
{
    public function init()
    {
        $user = Registry::getUser();
        if (!$user->id) {
            Url::redirect(Url::site("login"));
        }
    }

    public function index()
    {
        $this->edit();
    }

    public function edit()
    {
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $user = Registry::getUser();
        //Prevent role escalation
        $_REQUEST['roleId'] = $user->roleId;
        //Change password
        if ($_REQUEST["password"]) {
            if ($user->password != $user->encrypt($_REQUEST["passwordCurrent"])) {
                Registry::addMessage(Language::translate("CTRL_PERFIL_SAVE_PASSWORD_ERROR"), "error", "passwordCurrent");
                unset($_REQUEST["password"]);
                unset($_REQUEST["password2"]);
            } else {
                if (strlen($_REQUEST["password"])<6) {
                    Registry::addMessage(Language::translate("CTRL_PERFIL_SAVE_PASSWORD_SHORT_ERROR"), "error", "password");
                } elseif ($_REQUEST["password"]!=$_REQUEST["password2"]) {
                    Registry::addMessage(Language::translate("CTRL_PERFIL_SAVE_PASSWORD2_ERROR"), "error", "password");
                }
            }
        }
        //Prevent status change
        $_REQUEST['statusId'] = $user->statusId;
        if ($user->update($_REQUEST)) {
            Registry::addMessage(Language::translate("CTRL_PERFIL_SAVE_OK"), "success", "", Url::site("perfil"));
        }
        $this->ajax();
    }
}
