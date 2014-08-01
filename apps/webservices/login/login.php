<?php
//No direct access
defined('_EXE') or die('Restricted access');

class loginController extends Controller
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
        $this->login();
    }

    /**
     * Login
     */
    public function login()
    {
        //Login
        $user = User::login($_REQUEST["email"], $_REQUEST["password"]);
        if ($user->id) {
            //Device login
            Device::login(WS::$headers["PUSH_TOKEN"], $user->id, WS::$headers["DEVICE_OS"]);
            //Response
            WS::addData("user", $user->getWs(true));
        } else {
            //Response
            WS::setCode(1101);
        }
        WS::output();
    }

    /**
     * Logout
     */
    public function logout()
    {
        $user = WS::getUser();
        if ($user->id) {
            //Delete device
            $device = WS::getDevice();
            if ($device->id && $device->userId==$user->id) {
                $device->delete();
            } else {
                //Response
                WS::setCode(1004);
            }
        } else {
            //Response
            WS::setCode(1003);
        }
        WS::output();
    }
}
