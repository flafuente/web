<?php
//PHP
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Madrid');
ini_set("session.gc_maxlifetime","140000");

//Config
$_config['title'] = "Tribo.tv";
$_config['defaultLang'] = "en_GB";
$_config['template'] = "tribo";
$_config['defaultApp'] = "home";
$_config['defaultLimit'] = 10;
$_config['debug'] = true;
$_config['cookie'] = "authtribo";

//Mail
$_config['mailHost'] = "smtp.mandrillapp.com";
$_config['mailPort'] = "587";
$_config['mailSecure'] = "";
$_config['mailUsername'] = "soporte@spmedia.es";
$_config['mailPassword'] = "2RQHrMm4FLMIMklYfI8LfA";
$_config['mailFromAdress'] = "noreply@tribo.tv";
$_config['mailFromName'] = "TriboTV";

//Database
$_config['dbHost'] = "dev.tribo.tv";
$_config['dbUser'] = "tribotv_nano";
$_config['dbPass'] = "LaTaronjaEsdeAlborayatet3";
$_config['dbName'] = "tribotv_dev";

//User Roles
define("USER_ROLE_REGULAR", 	1);
define("USER_ROLE_TRIBBER", 	2);
define("USER_ROLE_COLABORADOR", 3);
define("USER_ROLE_VALIDADOR", 	4);
define("USER_ROLE_ADMIN", 		5);

//Categorías
define("USER_CATEGORIA_PERIODISMOCIUTADANO",	7);

//Urls/Paths
$_config['path'] = dirname(__FILE__);
$_config['host'] = $_SERVER["SERVER_NAME"];
$_config['dir'] = str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]);
$_config['url'] = "http://".$_config['host'].$_config['dir'];
