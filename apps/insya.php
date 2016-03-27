<?php

 /*
	@yasinkuyu, 2016
	Oğlum Ali Yaman Kuyu için...
 */
 
function getUrl( $s, $use_forwarded_host = false )
{
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function request($name){
	return isset($_REQUEST[$name]) ? $_REQUEST[$name] : '';
}

function getNames($result){
	
	// Get column headers
	for ($i = 0; $i < $result->columnCount(); $i++) {
		$meta = $result->getColumnMeta($i)["name"];
		$fields[] = $meta;
	}
	
	return $fields;
}

function getLanguages(){
	
	$directory = 'apps/languages/';
	$extension = '.php';
	$languages = array();
	
	if ( file_exists($directory) ) {
	   foreach(glob($directory.'*'.$extension) as $file){
		   include $file;
		   $languages[$lang["lang"]] = $lang["lang_name"];
	   }
	}
	else {
		   print "Language directory ${directory} doesn't exist!";
	} 
	
	return $languages;
}

function languageDetect($language){

	if(is_null($language) || $language === ""){
		
		$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			
	}

	if (!in_array($language, Flight::get('possible_languages'))) {

		$language = Flight::get('default_language');
		
	}	

	return $language;
	
}

function getLang($name){
		
	if($name == "")
	   $name = Flight::get('language');
	 
    if (in_array($name, Flight::get('possible_languages'))) {

        Flight::set('language', $name);
		include 'apps/languages/'. $name .'.php';
		
		
		return $lang;		
    }else{
		echo "Insya: Internal Error..."; die();
	}

}
   
