<?php
/*
  InStats
  @yasinkuyu, 2016
*/
require 'config.php';
require "apps/languages/tr-tr.php";
require "views/layout.php";
 
?>

<hr size="1" color="#C0C0C0" noshade>
<br />
 
<?php

function ListIps( $lYear, $lMonth, $lDay, $lHour )   
{

	if (strlen($lHour) > 0){
	  $sDataSource = "groupipsbyhouranddate";
	} else {
	  $sDataSource = "groupipsbydate";
	}

	$sSQL = 'SELECT * From '. $sDataSource .' WHERE 1 = 1 ';

	if (strlen($lYear) > 0){
	  $sSQL .= ' and YEAR(`date`) = '. $lYear .'';
	}

	if (strlen($lMonth) > 0){
	  $sSQL .= ' and MONTH(`date`) = '. $lMonth .'';
	}

	if (strlen($lDay) > 0){
	  $sSQL .= ' and DAY(`date`) = '. $lDay .'';
	}

	if (strlen($lHour) > 0){
	  $sSQL .= ' and hour = '. $lHour .' ';
	}

?>   
 
<table cellspacing="0" cellpadding="0" class="titlebg list">
	<tr>
	   <td class="titlebg" width="10">»</td>
	   <td class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$lang["visitors"]; ?> <?=GetDates()?></td>
	   <td class="titlebg" width="10"></td>
	</tr>
	<?php

		$db = Flight::db();
		$ips = $db->query($sSQL)->fetchAll();

		foreach ($ips as $row){
		
		   $sLink = "<a href=visitors.php?visitorname=" . $row["visitorname"];
		  
		   $sLink .= '>' . $row["ip"] . '</a>';
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
' sIp - The ip to show the click path for.
' lYear - the numerical year (optional)
' lMonth - the numerical month (optional)
' lDay - the numerical day (optional)
' lHour - the numerical hour (optional)
'
*/

function ShowClickPath( $sIp, $lYear, $lMonth, $lDay, $lHour )   
{
	if ( $sIp === "" ) :
	  echo( "Hata: ip Addres görüntülenemiyor." );
	  exit();
	endif;

	$sSQL = "SELECT stats.date, stats.Time, stats.ip, paths.pathname, refs.refname FROM paths RIGHT JOIN (refs RIGHT JOIN stats ON refs.RefID = stats.RefID) ON paths.PathID = stats.PathID Where stats.ip='" . $sIp . "'";
 
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
		if ( BSHOWLINKS && strpos( $row["pathname"], "http://" ) > 0 ) :
			$sFieldName = '<a href="' . $row["pathname"] . '" target="_blank">"' . $row["pathname"] . '"</a>';
		else:
			$sFieldName = $row["pathname"];
		endif;
	?>	
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$row["date"];?></td>
		   <td class="listbg"><?=$row["Time"];?></td>
		   <td class="listbg"><?=$sFieldName;?></td>
		   <td class="listbg"></td>
		</tr>
	<?php } ?>
	</table>
<?php }

function GetDates()
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
» <a href="reports.php"><?=$lang["reports"]; ?></a> » <a href="reportpathy.php"><?=$lang["yearly"]; ?></a> 
» <a href="visitors.php?year=<?=$sYear;?>"><?=$lang["daily"]; ?></a> 

<?php if ( $sIp != "" ) : ?>   
      » <a href="visitors.php?year=<?=$sYear;?>&month=<?=$sMonth;?>&day=<?=$sDay;?>"><?=$lang["visitor_reports"]; ?></a> » <?=$lang["select"]; ?>
<?php else : ?>   
      » <?=$lang["visitor_reports"]; ?>
<?php endif; ?>

<br /><br />
<?php

   echo( "<b>". $lang["page_views"] ."</b> <br /><br />" );

   if ( $sIp != "" ) :
      ShowClickPath($sIp, $sYear, $sMonth, $sDay, $sHour);
   else :
      ListIps($sYear, $sMonth, $sDay, $sHour);
   endif;

?>

<br />
<a href="<?= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '/reports'; ?>"><?=$lang["back"]; ?></a>
<br />
<br />