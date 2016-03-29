<?php
/*
  InStats
  @yasinkuyu, 2016
*/
?>

<hr size="1" color="#C0C0C0" noshade>
<br />
 
<?php

function ListIps( $lYear, $lMonth, $lDay, $lHour, $lang )   
{

	if (strlen($lHour) > 0){
	  $sDataSource = "GroupIpsByHourAndDate";
	} else {
	  $sDataSource = "GroupIpsByDate";
	}

	$sSQL = 'SELECT * From '. $sDataSource .' Where 1 = 1 ';

	if (strlen($lYear) > 0){
	  $sSQL .= ' and YEAR(`Date`) = '. $lYear .'';
	}

	if (strlen($lMonth) > 0){
	  $sSQL .= ' and MONTH(`Date`) = '. $lMonth .'';
	}

	if (strlen($lDay) > 0){
	  $sSQL .= ' and DAY(`Date`) = '. $lDay .'';
	}

	if (strlen($lHour) > 0){
	  $sSQL .= ' and Hour = '. $lHour .' ';
	}

?>   
 
<table cellspacing="0" cellpadding="0" class="titlebg list">
	<tr>
	   <td class="titlebg" width="10">»</td>
	   <td class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$lang["visitors"]; ?> <?=GetDates($lang)?></td>
	   <td class="titlebg" width="10"></td>
	</tr>
	<?php

		$db = Flight::db();
		$ips = $db->query($sSQL)->fetchAll();

		foreach ($ips as $row){
		
		   $sLink = "<a href=/ips?ip=" . $row["IP"];
		
		  if (strlen( $lYear ) > 0 ) :
			 $sLink .= "&year=" . $lYear;
		  endif;
		  
		  if (strlen( $lMonth ) > 0 ) :
			 $sLink .= "&month=" . $lMonth;
		  endif;
		  
		  if (strlen( $lDay ) > 0 ) :
			 $sLink .= "&day=" . $lDay;
		  endif;
		  
		  if (strlen( $lHour ) > 0 ) :
			 $sLink .= "&hour=" . $lHour;
		  endif;
		  
		   $sLink .= '>' . $row["IP"] . '</a>';
	?>
	<tr>
	   <td class="listbg"></td>
	   <td class="listbg"><?=$sLink?></td>
	   <td class="listbg"></td>
	</tr>
	<?php } ?>
	<tr>
	   <td class="listbg"></td>
	   <td class="listbg"><?=count($ips);?> <?=$lang["visitor"]; ?></td>
	   <td class="listbg"></td>
	</tr>
</table>
	
<?php } ?>
	
<?php
 
/*
'
' Sub ShowClickPath
'
' Usage:
' sIp - The IP to show the click path for.
' lYear - the numerical year (optional)
' lMonth - the numerical month (optional)
' lDay - the numerical day (optional)
' lHour - the numerical hour (optional)
'
*/

function ShowClickPath( $sIp, $lYear, $lMonth, $lDay, $lHour, $lang )   
{
	if ( $sIp === "" ) :
	  echo( "Hata: IP Addres görüntülenemiyor." );
	  exit();
	endif;

	$sSQL = "SELECT Stats.Date, Stats.Time, Stats.IP, Paths.PathName, Refs.RefName FROM Paths RIGHT JOIN (Refs RIGHT JOIN Stats ON Refs.RefID = Stats.RefID) ON Paths.PathID = Stats.PathID Where Stats.IP='" . $sIp . "'";

	if( strlen( $lYear ) > 0  ) :
	  $sSQL .= ' and YEAR(Stats.Date) = ' . $lYear;
	endif;

	if( strlen( $lMonth ) > 0 ) :
	  $sSQL .= ' and MONTH(Stats.Date) = ' . $lMonth;
	endif;

	if( strlen( $lDay ) > 0 ) :
	  $sSQL .= ' and DAY(Stats.Date) = ' . $lDay;
	endif;

	if( strlen( $lHour ) > 0 ) :
	  $sSQL .= ' and HOUR(Stats.Time) = ' . $lHour;
	endif;
 
    $db = Flight::db();
			
	$paths = $db->query($sSQL)->fetchAll();
	
?>   

<table cellspacing="0" cellpadding="0" class="titlebg list">
	<tr>
	   <td class="titlebg" width="10">»</td>
	   <td colspan="3" class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$lang["path"]; ?> <?=$sIp;?></td>
	   <td class="titlebg" width="10"></td>
	</tr>
	<tr>
	   <td class="listbg"></td>
	   <td class="listbg"><?=$lang["date"]; ?></td>
	   <td class="listbg"><?=$lang["time"]; ?></td>
	   <td class="listbg"><?=$lang["path"]; ?></td>
	   <td class="listbg"></td>
	</tr>
	<?php
	foreach ( $paths as $row)
	{ 	
		if ( BSHOWLINKS && strpos( $row["PathName"], "http://" ) > 0 ) :
			$sFieldName = '<a href="' . $row["PathName"] . '" target="_blank">"' . $row["PathName"] . '"</a>';
		else:
			$sFieldName = $row["PathName"];
		endif;
	?>	
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$row["Date"];?></td>
		   <td class="listbg"><?=$row["Time"];?></td>
		   <td class="listbg"><?=$sFieldName;?></td>
		   <td class="listbg"></td>
		</tr>
	<?php } ?>
	</table>
<?php }

function GetDates($lang)
{
   $return = "";
	
   if( strlen(request("month")) > 0 ) :  
      
	  $return = date('F', mktime(0, 0, 0, request("month"), 10));
      
      if( strlen(request("day")) > 0 ) :   
         $return = $return . " " . request("day");
      endif;
      
      $return = $return . ", ";
   endif;

   if( strlen(request("year")) > 0 ) :  
      $return = $return . request("year");
   endif;
   
   if( strlen($return) === 0 ) :  
      return $lang["all_data"];
   endif;
   
   return $return;
}

$sIp = request("ip");
$sYear = request("year");
$sMonth = request("month");
$sDay = request("day");
$sHour = request("hour");

?>
» <a href="/reports"><?=$lang["reports"]; ?></a> » <a href="/reportpathy"><?=$lang["yearly"]; ?></a> 
» <a href="/reportpathm?year=<?=$sYear;?>"><?=$lang["monthly"]; ?></a> 
» <a href="/ips?year=<?=$sYear;?>"><?=$lang["daily"]; ?></a> 

<?php if ( $sIp != "" ) : ?>   
      » <a href="ips?year=<?=$sYear;?>&month=<?=$sMonth;?>&day=<?=$sDay;?>"><?=$lang["visitor_reports"]; ?></a> » <?=$lang["select"]; ?>
<?php else : ?>   
      » <?=$lang["visitor_reports"]; ?>
<?php endif; ?>

<br /><br />
<?php
   echo( "<b>". $lang["page_views"] ." " . GetDates($lang) . "</b><br /><br />" );

   if ( $sIp != "" ) :
      ShowClickPath($sIp, $sYear, $sMonth, $sDay, $sHour, $lang);
   else :
      ListIps($sYear, $sMonth, $sDay, $sHour, $lang);
   endif;
?>

<br />
<a href="<?= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '/reports'; ?>"><?=$lang["back"]; ?></a>
<br />
<br />