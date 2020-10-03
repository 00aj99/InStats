<?php
ob_start(); @session_start();

set_time_limit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_URL', 'http://localhost/instats/');

// DATABASE INFO  
define("SERVER", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("TABLE", "instats");

// Database port
define("PORT", "3306");
  
require 'apps/flight/Flight.php';
require 'apps/detect.php';
require 'apps/insya.php';
require 'apps/db.php';

date_default_timezone_set('Europe/Istanbul'); 

if (!isset($_SERVER['CI_ENV'])) {
  $_SERVER['CI_ENV'] = 'production';
}
  
switch (isset($_SERVER['CI_ENV'])) {
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

$config = $db->query("SELECT c_imageloc, c_filterip, c_showlinks, c_refthisserver, c_strippathparameters, c_strippathprotocol, c_striprefparameters, c_striprefprotocol, c_stripreffile, language, forcelogin FROM config WHERE id = 1")->fetch();

//Get Variables
define("SIMAGELOCATION", $config["c_imageloc"]);
define("SFILTERIPS", $config["c_filterip"]);
define("BSHOWLINKS", $config["c_showlinks"]);
define("BREFTHISSERVER", $config["c_refthisserver"]);
define("BSTRIPPATHPARAMETERS", $config["c_strippathparameters"]);
define("BSTRIPPATHPROTOCOL", $config["c_strippathprotocol"]);
define("BSTRIPREFPARAMETERS", $config["c_striprefparameters"]);
define("BSTRIPREFPROTOCOL", $config["c_striprefprotocol"]);
define("BSTRIPREFFILE", $config["c_stripreffile"]);
define("LANGUAGE", $config["language"]);
define("FORCELOGIN", $config["forcelogin"]);


$sIp = request("ip");
$sYear = request("year");
$sMonth = request("month");
$sDay = request("day");
$sHour = request("hour");
