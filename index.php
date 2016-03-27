<?php

set_time_limit(0);

define('INSYA', true);

require 'config.php';
  
Flight::route('/count', function(){
	
	//Get parameters
	$sResolution = request("w") . "x" . request("h");	
	$sColor = request("c");
	$sPath = request("u");
	$sReferer = request("r");	
	$sFontSmoothing = request("fs");
	
	$sIP = $_SERVER['REMOTE_ADDR'];
	 
	//Ignore certain IPs
	$aIps = split ( "," , SFILTERIPS);
	
	if (in_array($sIP, $aIps)) exit;
		
	//Process the inputs
	if ($sResolution === "x") $sResolution = "unknown";
	
	//Get referer url
	if ($sReferer == "") $sReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
	if ($sReferer == "") $sReferer = "...";
	
	//This server as a referer?
	if (BREFTHISSERVER) {
		if (strpos(StripParameter($sReferer), $_SERVER["HTTP_HOST"]) === true) {
			$sReferer = "...";
		}
	}
	
	//Referer path and file
	if (BSTRIPREFFILE) $sReferer = ParseDomain($sReferer);
	
	//Path Parameters
	if (BSTRIPPATHPARAMETERS) $sPath = StripParameter($sPath);
	
	//Path Protocol
	if (BSTRIPPATHPROTOCOL) $sPath = StripProtocol($sPath);
	
	//Referer Parameters
	if (BSTRIPREFPARAMETERS) $sReferer = StripParameter($sReferer);
	
	//Referer Protocol
	if (BSTRIPREFPROTOCOL) $sReferer = StripProtocol($sReferer);
	
	if ($sPath == "") $sPath = "/";
	
	//Detect os
	$sOS = getOS();
	
	//Detect browser
	$sBrowser = getBrowser();
	
	//Get ID's by Names
	$lIdOS		= GetIdOS($sOS);
	$lIdColor	= GetIdColor($sColor);
	$lIdBrowser	= GetIdBrowser($sBrowser);
	$lIdPath	= GetIdPath($sPath);
	$lIdRef		= GetIdRef($sReferer);
	$lIdRes		= GetIdRes($sResolution);
	
	global $db;
			
	$db->query("
	INSERT INTO Stats (OsID,ColorID,BrowserID,PathID,RefID,ResID,Date,Time,IP)
	VALUES
		(
			$lIdOS,
			$lIdColor,
			$lIdBrowser,
			$lIdPath,
			$lIdRef,
			$lIdRes,
			CURDATE(),
			CURTIME(),
			'$sIP'
		)	
	");
	
	$image = file_get_contents(dirname(__FILE__) . SIMAGELOCATION);
	header("Content-type: image/png");
	
	echo $image;
});
	
Flight::route('/import', function(){

	if(isset($_POST["install"])){
		
		// dump file
		$filename = 'apps/instats.sql';
		// MySQL host
		$mysql_host = isset($_POST["install"]) ? $_POST["server"]  : 'localhost';
		// MySQL username
		$mysql_username = isset($_POST["username"]) ? $_POST["username"]  : 'root';;
		// MySQL password
		$mysql_password = isset($_POST["password"]) ? $_POST["password"]  : '';;
		// Database name
		$mysql_database = isset($_POST["table"]) ? $_POST["table"]  : 'instats';

		// Connect to MySQL server
		mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
		
		// Select database
		mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

		$sql = '';
		$file = file($filename);
		
		foreach ($file as $line)
		{
			
			if(!startsWith($line))  
			   echo $line;
				
			// Skip comment
			if (substr($line, 0, 2) == '--' || $line == '' || $line == '#')
				continue;

			$sql .= $line;
			
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
				
				// Perform the query
				mysql_query($sql) or print('' . $sql . ': ' . mysql_error() . '<br /><hr />');
				
				// Temp variable to empty
				$sql = '';
			}
		}
		echo 'Installation successfully   <a href="/reports">Login</a>';
	}

});
	
Flight::route('(/@lang:[a-z])(/@slug)', function($lang, $slug){
	global $db;
/*
echo  "lang:" . $lang . "<br>";
echo  "slug:" . $slug; die();
			
	
	// Set default language
	if( $lang == "" && !isset($_COOKIE['inlang'])){
		
		// Set cookie current language
		setcookie("inlang", "en-us");
	}
	
	// Check url defined paramater
	if( $lang != "" || in_array($lang, Flight::get('possible_languages'))){
		
		// Cookie store current language
		setcookie("inlang", $lang);
	}
	 */
	// Read and set language parameter
	$lang = LANGUAGE;
	
	// Check language support languages
	$language = languageDetect($lang);		
	
	// Set fligh language parameter
	Flight::set('language', $language);
	
	// Read language file
	$lang = getLang($language);
		
	// Check current file
	$file = $slug == "reports" ? "reports" : $slug;
	$file = $slug == "" ? "reports" : $slug;
	
	Flight::set('lang', $lang);
	 
	$sYear = request("year"); 
	$sMonth = request("month"); 

	$data = array(
		'lng' => Flight::get('language'), 
		'lang' => $lang, 
		'sYear' => $sYear, 
		'sMonth' => $sMonth
	);

	$sToday = date("Y") . "-" . date("m") . "-" . date("d");
	$dtYesterday =  date('Y-m-d', strtotime(' - 1 days'));
	$sYesterday = $dtYesterday . "-" . $dtYesterday . "-" . $dtYesterday;
	
	//Total PageViews
	$sSQL = $db->query("SELECT COUNT(StatID) AS Total FROM Stats")->fetch();
	$lPageViewsTotal = $sSQL["Total"];

	$sSQL = $db->query("SELECT COUNT(StatID) AS Total FROM Stats WHERE Date = '" . $sToday . "'")->fetch();
	$lPageViewsToday = $sSQL["Total"];

	$sSQL = $db->query("SELECT COUNT(StatID) AS Total FROM Stats WHERE Date = '" . $sYesterday . "'")->fetch();
	$lPageViewsYesterday = $sSQL["Total"];

	$sSQL = $db->query("SELECT COUNT(IP) AS Total FROM Stats GROUP BY IP")->fetch();
	$lVisitorsTotal = $sSQL["Total"];

	$sSQL = $db->query("SELECT COUNT(IP) AS Total FROM Stats WHERE Date = '" . $sToday . "' GROUP BY IP")->fetch();
	$lVisitorsToday = $sSQL["Total"];

	$sSQL = $db->query("SELECT COUNT(IP) AS Total FROM Stats WHERE Date = '" . $sYesterday . "' GROUP BY IP")->fetch();
	$lVisitorsYesterday = $sSQL["Total"];

	$sSQL = $db->query("SELECT * FROM TopPageViewsPerDay LIMIT 1")->fetch();
	$lVisitorsYesterday = $sSQL["Total"];

	$sSQL = $db->query("SELECT * FROM TopPageViewsPerDay  LIMIT 1")->fetch();
	$lTopViews = $sSQL["Total"];
	$data["sTopViewsDay"]  = $sSQL["Date"];

	$sSQL = $db->query("SELECT * FROM TopIpsPerDay  LIMIT 1")->fetch();
	$lTopVisitors = $sSQL["Total"];
	$data["sTopVisitorsDay"] = $sSQL["Date"];

	$data["sPageViewsToday"] = number_format( $lPageViewsToday, 0);
	$data["sPageViewsYesterday"] = number_format( $lPageViewsYesterday, 0);
	$data["sPageViewsTotal"] = number_format( $lPageViewsTotal, 0);

	$data["sVisitorsToday"] = number_format( $lVisitorsToday, 0);
	$data["sVisitorsYesterday"] = number_format( $lVisitorsYesterday, 0);
	$data["sVisitorsTotal"] = number_format( $lVisitorsTotal, 0);

	$data["sTopViews"] = number_format( $lTopViews, 0 );
	$data["sTopVisitors"] = number_format( $lTopVisitors, 0 );
  
	if(file_exists(Flight::get('flight.views.path').'/'.$file.'.php')) {
		Flight::render($file, $data, 'body');
    }else{
		//Flight::redirect('/404?'.$_SERVER['REQUEST_URI'], 404);
    }
	
	Flight::render("layout", $data);

});

/*
Flight::map('notFound', function(){
	echo "404";
});
*/

Flight::start();

ob_end_flush(); 