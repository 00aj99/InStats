<?php

ob_start(); @session_start();

// ################################# 
  
// DATABASE INFO  
define("SERVER", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("TABLE", "instats");

// Database port
define("PORT", "3306");

// ################################# 
  
require 'apps/flight/Flight.php';
require 'apps/detect.php';
require 'apps/insya.php';
require 'apps/count.php';

date_default_timezone_set('Europe/Istanbul'); 

Flight::set('flight.log_errors', true);
Flight::set('flight.views.path', __DIR__.'/views');

$languages = array();

foreach(getLanguages() as $slug => $lng)
{
	$languages[] = $slug;
} 

// Supported languages
Flight::set('possible_languages', $languages);

// Default language
Flight::set('default_language', 'tr-tr');

if (!$_SERVER['CI_ENV']) {
  $_SERVER['CI_ENV'] = 'production';
}
  
switch ($_SERVER['CI_ENV']) {
  case 'development':

	Flight::register('db', 'PDO', array('mysql:host=localhost;port=3306;charset=UTF8;dbname=instats', 'root', ''), function($db) {
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	});

	break;
  case 'production':
  default:
 
	Flight::register('db', 'PDO', array('mysql:host='. SERVER .';port='. SERVER .';charset=UTF8;dbname=' . TABLE, USERNAME, PASSWORD), function($db) {
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	});

	break;
}
 
// Set database
$db = Flight::db();

$config = $db->query("SELECT C_ImageLoc, C_FilterIP, C_ShowLinks, C_RefThisServer, C_StripPathParameters, C_StripPathProtocol, C_StripRefParameters, C_StripRefProtocol, C_StripRefFile, Language, ForceLogin FROM Config WHERE ID = 1")->fetch();

//Get Variables
define("SIMAGELOCATION", $config["C_ImageLoc"]);
define("SFILTERIPS", $config["C_FilterIP"]);
define("BSHOWLINKS", $config["C_ShowLinks"]);
define("BREFTHISSERVER", $config["C_RefThisServer"]);
define("BSTRIPPATHPARAMETERS", $config["C_StripPathParameters"]);
define("BSTRIPPATHPROTOCOL", $config["C_StripPathProtocol"]);
define("BSTRIPREFPARAMETERS", $config["C_StripRefParameters"]);
define("BSTRIPREFPROTOCOL", $config["C_StripRefProtocol"]);
define("BSTRIPREFFILE", $config["C_StripRefFile"]);
define("LANGUAGE", $config["Language"]);
define("FORCELOGIN", $config["ForceLogin"]);
