<?php

    /*
        InStats
        @yasinkuyu, 2016
    */

    require 'config.php';
  
	//Get parameters
	$sResolution = request("w") . "x" . request("h");	
	$sColor = request("c");
	$sPath = request("u");
	$sReferer = request("r");	
	$sFontSmoothing = request("fs");
	$sLang = request("l");	
	$sUAgent = request("ua") != "" ? request("ua") : $_SERVER['HTTP_USER_AGENT'];	
	$sKeyword = request("q") != "" ? request("q") : ParseKeyword($sReferer);	
	
	$sIP = $_SERVER['REMOTE_ADDR'];
	 
	// Ignore certain IPs
	// $aIps = explode( "," , SFILTERIPS);
	// if (in_array($sIP, $aIps)) exit;
		
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

	// zamanı unique id olarak tanımla
	$sVisitor = strtotime('now');

	if(isset($_COOKIE["insvstr"]) && $_COOKIE["insvstr"] != ""){
		$sVisitor = $_COOKIE["insvstr"];
	}else{
		setcookie("insvstr", $sVisitor, strtotime( '+360 days' ));
	}
	
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
	$lIdKey		= GetIdKey($sKeyword);
	$lIdLang    = GetIdLang($sLang);
	$lIdUAgent  = GetIdUagent($sUAgent);
	$lIdVisitor = GetIdVisitor($sVisitor);

	global $db;
			
	$db->query("
	INSERT INTO stats (osid,colorid,browserid,pathid,refid,resid,keyid,langid,uagentid,visitorid,date,time,ip)
	VALUES
		(
			$lIdOS,
			$lIdColor,
			$lIdBrowser,
			$lIdPath,
			$lIdRef,
			$lIdRes,
			$lIdKey,
			$lIdLang,
			$lIdUAgent,
			$lIdVisitor,
			CURDATE(),
			CURTIME(),
			'$sIP'
		)	
	");
	
    $image = file_get_contents(dirname(__FILE__) . SIMAGELOCATION);
    
	header("Content-type: image/png");
	print $image;