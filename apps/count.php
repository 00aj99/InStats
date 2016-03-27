<?php
	
	function read_update($table,$nameField,$idField,$nameData){
	
		$db = Flight::db();
		$update = $db->query("SELECT " . $idField . ", " . $nameField . ", Total FROM " . $table . " WHERE " . $nameField . " = '" . $nameData . "'");
				
		if($update->rowCount() > 0){
			
			$db->query("UPDATE " . $table . " SET Total = Total+1 WHERE " . $nameField . " = '". $nameData ."'");
			$ru = $update->fetch();
			
			return $ru[$idField];
		}	
		else {
			
			$rui = $db->prepare("INSERT INTO " . $table . " (" . $nameField . ", Total) VALUES('". $nameData ."',0)");
			$rui->execute();
			
			return $db->lastInsertId();

		}
		
	}
	
	function GetIdOS($sName){
	
		//Get OsID
		return read_update("OSes","OsName","OsID", $sName);
	}
	
	function GetIdColor($sName){
	
		//Get ColorID
		return read_update("Colors","ColorName","ColorID", $sName);
		
	}

	function GetIdBrowser($sName){
		//Get BrowserID
		return read_update("Browsers","BrowserName","BrowserID", $sName);
		
	}
	
	function GetIdPath($sName){
		//Get PathID
		return read_update("Paths","PathName","PathID", $sName);
		  
	}

	function GetIdRef($sName){
		//Get RefID
		return read_update("Refs","RefName","RefID", $sName);

	}

	function GetIdRes($sName){
		//Get ResID
		return read_update("Resolutions","ResName","ResID", $sName);

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
