<?php
//No direct access
defined('_EXE') or die('Restricted access');

class loginController extends Controller
{
    public function init() {}

    public function index()
    {
        Url::redirect(Url::site());
    }

    public function recovery()
    {
        $html = $this->view("views.recovery");
        $this->render($html);
    }

    public function sendRecovery()
    {
        $user = current(User::getBy("email", $_REQUEST['email']));
        if ($user->id) {
            $user->sendRecovery();
            Registry::addMessage("Te hemos mandado un email con los detalles para la recuperación de tu cuenta.", "success");
        }
        Url::redirect(Url::site());
    }

    public function restore()
    {
        $url = Registry::getUrl();
        $user = current(User::getBY("recoveryHash", $url->vars[0]));
        if ($user->id) {
            $this->setData("user", $user);
            $html = $this->view("views.restore");
            $this->render($html);
        } else {
            Url::redirect(Url::site());
        }
    }

    public function verify()
    {
        /*$url = Registry::getUrl();
        $user = User::getUserByVerificationHash($url->vars[0]);
        if ($user->id) {
            print_pre($user);
            $user->verified = 1;
            $user->verificationHash = "";
            $user->update();
            $_SESSION["userId"] = $user->id;
            Registry::addMessage("Cuenta activada satisfactoriamente", "success");
        } else {
            Registry::addMessage("Link de activación incorrecto", "error");
        }
        Url::redirect(Url::site());*/
    }

    public function changePassword()
    {
        $user = current(User::getBY("recoveryHash", $_REQUEST["recoveryHash"]));
        if ($user->id) {
            if ($_REQUEST['password']==$_REQUEST['password2']) {
                $user->recoveryHash = "";
                $user->update($_REQUEST);
                $user->login($user->email, $_REQUEST['password']);
                Registry::addMessage("Contraseña guardada satisfactoriamente", "success", "", Url::site());
            } else {
                Registry::addMessage("Las contraseñas no coinciden", "error", "password");
            }
        }
        $this->ajax();
    }

    public function doLogin()
    {
        $user = new User();
        $expiration = 7200;
        if ($_REQUEST["remember"]) {
            $expiration = 60*60*24*7*4*3;
        }
        if ($user->login($_REQUEST['login'], $_REQUEST['password'], $expiration)) {
            $user = Registry::getUser();
            if ($user->roleId < USER_ROLE_VALIDADOR) {
                Registry::addMessage("", "", "", Url::site("?a=true"));
            } else {
                if ($user->tfaStatus) {
                    Registry::addMessage("", "", "", Url::site("login/tfa"));
                } else {
                    Registry::addMessage("", "", "", Url::site("admin"));
                }
            }
        } else {
            Registry::addMessage("Acceso incorrecto", "error", "login");
        }
        $this->ajax();
    }

    public function doLogout()
    {
        $user = Registry::getUser();
        if ($user->id) {
            $user->logout();
        }
        Url::redirect(Url::site());
    }

    public function tfa()
    {
        //Usamos el template Admin
        $config = Registry::getConfig();
        $config->set("template", "admin");

        $user = Registry::getUser();
        $this->setData("user", $user);
        $html = $this->view("views.tfa");
        $this->render($html);
    }

    public function doTfa()
    {
        $user = Registry::getUser();
        //2FA?
        if ($user->tfaStatus) {
            if (!$user->check2fa($_REQUEST["2faCode"])) {
                Registry::addMessage("Wrong code", "error", "2faCode");
            } else {
                $user->auth2fa();
                Registry::addMessage("", "", "", Url::site("admin"));
            }
        } else {
            Registry::addMessage("", "", "", Url::site("admin"));
        }
        $this->ajax();
    }

    /**
     * Registro de Triber (periodismo ciutadano)
     */
    public function registerTriber()
    {
        $config  = Registry::getConfig();
        //Try to register
        $user = new User();
        //Force disable account
        $_REQUEST['statusId'] = $config->get("enableTribers");
        //Force un-verified account
        $_REQUEST['verified'] = 0;
        //Force role
        $_REQUEST['roleId'] = USER_ROLE_TRIBBER;
        if ($user->insert($_REQUEST)) {
            //Redirect to main page thought Message URL parameter
            //Registry::addMessage("Gracias por registrarte!", "success", "", Url::site());
            Registry::addMessage("", "", "", Url::site("tribonews/bienvenido"));
        }
        //Do not render the template, just ajax (Messages)
        $this->ajax();
    }

    public function doRegister()
    {
        //Try to register
        $user = new User();
        //Force enable account
        $_REQUEST['statusId'] = 1;
        //Force un-verified account
        $_REQUEST['verified'] = 0;
        //Force nophoto
        $_REQUEST['foto'] = "nophoto0".rand(1, rand(1, 4)).".png";
        //Force role
        $_REQUEST['roleId'] = USER_ROLE_REGULAR;
        if ($user->insert($_REQUEST)) {
            //Do first login
            $user->login($_REQUEST['email'], $_REQUEST['password']);
            //Redirect to main page thought Message URL parameter
            Registry::addMessage("", "", "", Url::site());
        }
        //Do not render the template, just ajax (Messages)
        $this->ajax();
    }
}
