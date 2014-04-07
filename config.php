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

//Mail
$_config['mailHost'] = "smtp.gmail.com";
$_config['mailPort'] = "587";
$_config['mailSecure'] = "tls";
$_config['mailUsername'] = "testtribo@gmail.com";
$_config['mailPassword'] = "LaTaronjaEsdeAlborayatet3";
$_config['mailFromAdress'] = "testtribo@gmail.com";
$_config['mailFromName'] = "TriboTV";

//Database
$_config['dbHost'] = "dev.tribo.tv";
$_config['dbUser'] = "tribotv_nano";
$_config['dbPass'] = "LaTaronjaEsdeAlborayatet3";
$_config['dbName'] = "tribotv_dev";

//Urls/Paths
$_config['path'] = dirname(__FILE__);
$_config['host'] = $_SERVER["SERVER_NAME"];
$_config['dir'] = str_replace("index.php","",$_SERVER["SCRIPT_NAME"]);
$_config['url'] = "http://".$_config['host'].$_config['dir'];

//Functions
function print_pre($array="", $return=false){
	$out = "<pre>";
	$out .= print_r($array, true);
	$out .= "</pre>";
	if($return){
		return $out;
	}else{
		echo $out;
	}
}

function redirect($url, $message="", $type=""){
	if($message){
		Registry::addMessage($message, $type);
	}
	header("Location: ".$url);
	die();
}
