<?php

/**
 * Router Class
 *
 * @package LightFramework\Core
 */
class Router
{
    /**
     * Load the correct App and launch an App Action
     */
    public static function delegate()
    {
        //Get the current Config
        $config = Registry::getConfig();
        if ($config->get("debug")) {
            Registry::setDebug("started", microtime(true));
        }
        //Get the current Url
        $url = Registry::getUrl();
        //Load App
        $app = self::getAppPath($url->app, $url->router);
        //Route
        self::route($app, $url->action);
    }

    public static function getAppPath($appName, $router="")
    {
        //Get the current Config
        $config = Registry::getConfig();
        //Load App
        return $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$router.DIRECTORY_SEPARATOR.$appName.DIRECTORY_SEPARATOR.$appName.".php";
    }

    private static function route($appPath, $action="index")
    {
        //Appname
        $appName = current(explode(".", end(explode(DIRECTORY_SEPARATOR, $appPath))));
        //Get the current Config
        $config = Registry::getConfig();
        //Get the current Url
        $url = Registry::getUrl();
        //Securize
        $appPath = str_replace("..", "", $appPath);
        //Check if the app path exists
        if (is_readable($appPath)==false) {
            if($config->get("debug"))
                die("App not found: ".$appPath);
            else
                redirect(Url::site());
        } else {
            //Load the App
            include_once($appPath);
            //Check if its a Controller
            $class = $appName."Controller";
            if (class_exists($class)) {
                //Init
                $controller = new $class();
                //Check if the acction exists
                if (method_exists($controller, $action)) {
                    //Launch the App Action
                    $controller->$action();
                    //Preserve Current Debug
                    Registry::preserveDebug();
                } else {
                    if($config->get("debug"))
                        die("Acction not found: ".$action);
                    else
                        redirect(Url::site());
                }
            } else {
                //Check if its a ControllerRouter
                $class = $appName."ControllerRouter";
                if (class_exists($class)) {
                    //Init
                    $controller = new $class();
                    //No action?
                    if ($action=="index") {
                        //Action
                        $controller->$action();
                    } else {
                        //New App Path
                        $appPath = self::getAppPath($action, $appName);
                        //Set new URL
                        $url->router = $appName;
                        $url->app = $action;
                        $url->action = $url->vars[0] ? $url->vars[0] : "index";
                        @array_shift($url->vars);
                        Registry::setUrl($url);
                        //Route
                        self::route($appPath, $url->action);
                    }
                }
            }
        }
    }
}
