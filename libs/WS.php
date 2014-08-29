<?php
/**
 * WS object
 */
class WS
{

    public static $headers;

    private static $user = NULL;
    private static $device = NULL;

    private static $status;
    private static $error;
    private static $code;

    private static $data = array();

    private static $errors = array(
        //General
        1001 => "Push token vacío",
        1002 => "Device OS incorrecto",
        1003 => "User token incorrecto",
        1004 => "Dispositivo incorrecto",
        1005 => "Error en los campos",
        //Videos
        2001 => "Formato de vídeo no soportado",
        2002 => "El tamaño de vídeo supera el límite",
    );

    /**
     * Get the current User object
     * @return object User
     */
    public static function getUser()
    {
        if (self::$user == NULL || !self::$user->id) {
            self::$user = @current(User::getBy("wsToken", self::$headers["USER_TOKEN"]));
        }

        return self::$user;
    }

    /**
     * Get the current Device object
     * @return object Device
     */
    public static function getDevice()
    {
        if (self::$device == NULL || !self::$device->id) {
            self::$device = @current(Device::getBy("pushToken", self::$headers["PUSH_TOKEN"]));
        }

        return self::$device;
    }

    public static function setHeaders()
    {
        $headers = '';
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[strtoupper(substr($name, 5))] = $value;
            }
        }
        self::$headers = $headers;
    }

    public static function setStatus($status)
    {
        self::$status = $status;
    }

    public static function setError($error)
    {
        self::$error = $error;
    }

    public static function setCode($code)
    {
        self::$code = $code;
    }

    public static function addData($key, $data)
    {
        self::$data[$key] = $data;
    }

    public static function toWs($array, $params=array())
    {
        $ws = array();
        if (count($array)) {
            foreach ($array as $object) {
                $ws[] = call_user_func_array(array($object, "getWs"), $params);
            }
        }

        return $ws;
    }

    public static function output()
    {
        //Errors
        $errors = Registry::getMessages();
        if (is_array($errors) && !empty($errors)) {
            self::addData("errors", $errors);
        }
        //Debug
        $debug = Registry::getDebug();
        if (is_array($debug) && !empty($debug)) {
            self::addData("debug", $debug);
        }
        //Logic
        if (self::$code) {
            self::$error = self::$errors[self::$code];
            self::$status = "error";
        } else {
            self::$status = "ok";
        }
        //Prepare data
        $data = array();
        $data["status"] = self::$status;
        $data["error"] = self::$error;
        $data["code"] = self::$code;
        if (is_array(self::$data) && !empty(self::$data)) {
            $data["data"] = (array) self::$data;
        }
        //Show data
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
