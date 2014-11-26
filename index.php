<?php

//Pass trought index
define("_EXE", 1);

//Configuration
include 'config.php';

//Composer autoload
require 'vendor/autoload.php';

//CloudFlare visitor IP fix
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

//Language init
$language = new Language();

//Registry init
$registry = new Registry();

//Router init
$router = new Router();

//Delegate
$router->delegate();

$config = Registry::getConfig();
