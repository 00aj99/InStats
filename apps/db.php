<?php
	
	function read_update($table,$nameField,$idField,$nameData){
	
		$db = Flight::db();
		$update = $db->query("SELECT " . $idField . ", " . $nameField . ", total FROM " . $table . " WHERE " . $nameField . " = '" . $nameData . "'");
				
		if($update->rowCount() > 0){
			
			$db->query("UPDATE " . $table . " SET total = total+1 WHERE " . $nameField . " = '". $nameData ."'");
			$ru = $update->fetch();
			
			return $ru[$idField];
		}	
		else {
			
			$rui = $db->prepare("INSERT INTO " . $table . " (" . $nameField . ", total) VALUES('". $nameData ."',0)");
			$rui->execute();
			
			return $db->lastInsertId();

		}
		
	}
	
	function GetIdOS($sName){
	
		//Get osid
		return read_update("oses","osname","osid", $sName);
	}
	
	function GetIdColor($sName){
	
		//Get colorid
		return read_update("colors","colorname","colorid", $sName);
		
	}

	function GetIdBrowser($sName){
		//Get browserid
		return read_update("browsers","browsername","browserid", $sName);
		
	}
	
	function GetIdPath($sName){
		//Get PathID
		return read_update("paths","pathname","PathID", $sName);
		  
	}

	function GetIdRef($sName){
		//Get RefID
		return read_update("refs","refname","RefID", $sName);

	}

	function GetIdKey($sName){
		return read_update("keywords","keyword","keyid", $sName);

	}

	function GetIdLang($sName){
		return read_update("langs","langname","langid", $sName);

	}

	function GetIdUagent($sName){
		return read_update("uagents","uagentname","uagentid", $sName);

	}

	function GetIdVisitor($sName){
		return read_update("visitors","visitorname","visitorid", $sName);

	}

	function GetIdRes($sName){
		//Get ResID
		return read_update("resolutions","resname","ResID", $sName);

	}

	function GetIdStatus($sName){
		return read_update("statuscodes","statusname","statusid", $sName);
	}

	function StripParameter($sPath){
		$sPath = preg_replace('/\\?.*/', '', $sPath);
		return $sPath;
	}
	
	function StripProtocol($sPath){
		$sPath = preg_replace('#^https?://#', '', rtrim($sPath,'/'));
		return $sPath;
	}
	
	function ParseDomain($url) {
	   $url = preg_replace('/https?:\/\/|www./', '', $url);
	   if ( strpos($url, '/') !== false ) {
		  $ex = explode('/', $url);
		  $url = $ex['0'];
	   }
	   return $url;
	}

	function ParseKeyword($referrer){
		
		// $referrer = strtolower($_SERVER['HTTP_REFERER']);

		// url den anahtar kelimeyi tespit et
		// https://stackoverflow.com/questions/1805296/get-keyword-from-a-search-engine-referrer-url-using-php

		if (strpos($referrer, "google")) {

			$parsed = parse_url( $referrer, PHP_URL_QUERY );

			// Parse the query string into an array
			parse_str( $parsed, $query );

			if($query['q'] != "") return $query['q'];
		}

	}
