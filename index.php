<?php

//Pass trought index
define("_EXE", 1);

//Configuration
include 'config.php';

//Composer autoload
require 'vendor/autoload.php';

//Language init
$language = new Language();

//Registry init
$registry = new Registry();

//Router init
$router = new Router();

//Delegate
$router->delegate();

$config = Registry::getConfig();
echo $config->get("host")."<br>";
echo $config->get("dir")."<br>";
