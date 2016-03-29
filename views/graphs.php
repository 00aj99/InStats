<?php
/*
  InStats
  @yasinkuyu, 2016
*/
  
// GraphHours
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
// lYear - a four-digit year or "" for none.
// lMonth - a 0-based one- or two-digit month number.
// lDay - a 1-based one- or two- digit day number.
 
function GraphHours( $sViewType, $lYear, $lMonth, $lDay , $lang)   
{
	if ($sViewType === "Views") {
	  
	  $sSQL = "SELECT Stats.Date, Stats.IP, HOUR( Stats.Time ) As Hour, COUNT(Stats.IP) AS Total ";
	  $sSQL.= " FROM Stats ";
	  
	  $sGroupBy = " GROUP BY HOUR( Stats.Time ) ";
	  
	  $sDataSource = "Stats";
	  
	} elseif ($sViewType == "Visits") {
		
	  $sSQL = "SELECT GroupIpsByHourAndDate.Date, GroupIpsByHourAndDate.IP, GroupIpsByHourAndDate.Hour, COUNT(GroupIpsByHourAndDate.IP) AS Total ";
	  $sSQL.=" FROM GroupIpsByHourAndDate ";
	  
	  $sGroupBy = " GROUP BY GroupIpsByHourAndDate.Hour ";
	  $sDataSource = "GroupIpsByHourAndDate";
	} 
 
	$sHaving = " HAVING ((1=1) ";

	if( strlen( $lYear ) > 0 ) {
	  $sHaving .= "AND (YEAR( ". $sDataSource .".Date )=" . $lYear . ") ";
	  $sGroupBy .= ", YEAR( ". $sDataSource .".Date ) ";
	}

	if( strlen( $lMonth ) > 0 ) {
	  $sHaving .= "AND (MONTH( ". $sDataSource .".Date )=" . $lMonth . ") ";
	  $sGroupBy .= ", MONTH( ". $sDataSource .".Date ) ";
	}

	if( strlen( $lDay ) > 0 ) {
	  $sHaving .= "AND (DAY( ". $sDataSource .".Date )=" . $lDay . ") ";
	  $sGroupBy .= ", DAY( ". $sDataSource .".Date ) ";
	} 

    $sHaving .= " ) ";
  
	global $db;	
 	$data = $db->query($sSQL . $sGroupBy . $sHaving);
 	
    $aHours = array();
	
	for ($i = 0; $i < 23; $i++) {
		$aHours[$i] = 0;
	}	
	
	$lTotal = 0;
	$lTop = 0;
	
	foreach($data->fetchAll() as $row) {
		if ( $row["Total"] > $lTop ) {  
			$lTop = $row["Total"];
		}
	    $lTotal = $lTotal + $row["Total"];
	    $aHours[$row["Hour"]] = $row["Total"];
	}	

?>   
   <table border="0" cellspacing="1" cellpadding="2" class="titlebg">
		<tr>
		   <td class="titlebg" width="10">»</td>
		   <td colspan="25" class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType; ?> <?=$lang["view_hour"]; ?></td>
		   <td class="titlebg" width="10"></td>
		</tr>
		<tr>
		    <td class="listbg"></td>
		    <td class="listbg" valign="bottom"></td>
			<?php
			foreach($aHours as $lCounter) {
				
				$lHeight = ($lTop > 0) ? ($lCounter/$lTop) * 150 : 0;
			?>
			<td class="listbg" valign="bottom" align="center">
			   <img src="/assets/insya.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter; ?>">
			</td>
			<?php } ?>
			<td class="listbg" width="10"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$sViewType;?></td>
			<?php foreach($aHours as $lCounter) { ?>
				<td class="listbg" align="center"><?=$lCounter;?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		    <td class="listbg"></td>
		    <td class="listbg">%</td>
			<?php 
				foreach($aHours as $lCounter) { 
				$sPercent = $lTotal > 0 ? $lCounter/$lTotal : 0;
			?>
			<td class="listbg" align="center"><?=FormatPercent($sPercent)?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		    <td class="listbg"></td>
		    <td class="listbg"><?=$lang["hour"]; ?></td>
			<?php for($lCounter = 0; $lCounter < 24; $lCounter++){ ?>
			<td class="listbg" align="center"><?=$lCounter;?>:00</td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
	</table>
	<br />
	<br />
<?php	
} 
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
// lYear - a four-digit year or "" for none.
// lMonth - a 0-based one- or two-digit month number.
// lWeek - a 0-based one- or two-digit week (of year) number
 
function GraphDayOfWeek( $sViewType, $lYear, $lMonth, $lWeek, $lang )
{
   
	if ($sViewType == "Views") { 
	
		$sSQL = "SELECT Stats.Date, Stats.IP, DAYOFWEEK( Stats.Date ) as Day, Count(Stats.IP) AS Total ";
		$sSQL.= "FROM Stats ";

		$sGroupBy = "GROUP BY DAYOFWEEK( Stats.Date ) ";
		$sDataSource = "Stats";
		
	} elseif ($sViewType == "Visits") {  
	
		$sSQL = "SELECT GroupIpsByDate.Date, GroupIpsByDate.IP, DAYOFWEEK( GroupIpsByDate.Date ) as Day, Count(GroupIpsByDate.IP) AS Total ";
		$sSQL.= "FROM GroupIpsByDate ";

		$sGroupBy = "GROUP BY DAYOFWEEK( GroupIpsByDate.Date ) ";
		$sDataSource = "GroupIpsByDate";
	} 

	$sHaving = " HAVING ((1=1) ";

	if (strlen( $lYear ) > 0) {
	  $sHaving = $sHaving . "AND (YEAR( ". $sDataSource .".Date)=" . $lYear . ") ";
	  $sGroupBy = $sGroupBy . ", YEAR( ". $sDataSource .".Date) ";
	}

	if (strlen( $lMonth ) > 0) {
	  $sHaving = $sHaving . "AND (MONTH( ". $sDataSource .".Date )=" . $lMonth . ") ";
	  $sGroupBy = $sGroupBy . ", MONTH( ". $sDataSource .".Date ) ";
	}

	if (strlen( $lWeek ) > 0) {
	  $sHaving = $sHaving . "AND (DAYOFWEEK( ". $sDataSource .".Date )=" . $lWeek . ") ";
	  $sGroupBy = $sGroupBy . ", DAYOFWEEK( ". $sDataSource .".Date ) ";
	} 

    $sHaving .= ")";
 
	global $db;	
 	$data = $db->query($sSQL . $sGroupBy . $sHaving);

	$aDays = array();
	
	for ($i = 0; $i < 6; $i++) {
		$aDays[$i] = 0;
	}	
	
	$lTotal = 0;
	$lTop = 0;
	
	foreach($data->fetchAll() as $row) {
		if ($row["Total"] > $lTop){
			$lTop = $row["Total"];
		}
		$lTotal = $lTotal + $row["Total"];
		$aDays[ $row["Day"] -1 ] = $row["Total"];
	}
	
?>   
   <table border="0" cellspacing="1" cellpadding="2" class="titlebg">
	   <tr>
		   <td class="titlebg" width="10">»</td>
		   <td colspan="7" class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType;?> <?=$lang["view_week"]; ?></td>
		   <td class="titlebg" width="10"></td>
      </tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg" valign="bottom"></td>
		<?php foreach($aDays as $lCounter) { 
				if ($lTop > 0 ) {
					$lHeight = ($lCounter/$lTop ) * 150;
				}  else  { 
					$lHeight = 0;
				}
		?>
		<td class="listbg"  valign="bottom" align="center">
		   <img src="/assets/insya.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
		</td>
		<?php } ?>
		<td class="listbg" width="10"></td>
		</tr>
		<tr>
			<td class="listbg"></td>
			<td class="listbg"><?=$sViewType;?></td>
			<?php foreach($aDays as $lCounter) { ?>
			<td class="listbg" align="center"><?=$lCounter; ?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg">%</td>
		<?php 
			foreach($aDays as $lCounter) { 
				$aPercent = $lTotal > 0 ? $lCounter/$lTotal : 0;
		?>
		<td class="listbg" align="center"><?=FormatPercent($aPercent);?></td>
		<?php } ?>
		<td class="listbg"></td>
		</tr>
			<tr>
			   <td class="listbg"></td>
			   <td class="listbg"><?=$lang["day"]; ?></td>
			<?php 
			foreach($aDays as $key => $lCounter) { 

				$months = explode(",", $lang['weekdays']);
			 	$mName = $months[$key];

			?>
			<td class="listbg" align="center"><?= $mName; ?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
	</table>
	<br /><br />
<?php } ?>

<?php
// GraphDayOfMonth
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
// lYear - a four-digit year or "" for none.
// lMonth - a 0-based one- or two-digit month number.
//
function GraphDayOfMonth( $sViewType, $lYear, $lMonth, $lWeek, $lang )
{
	if ($sViewType == "Views" ) {
	  $sSQL = "SELECT Stats.Date, Stats.IP, DAY( Stats.Date ) AS Day, Count(Stats.IP) AS Total ";
	  $sSQL.= "FROM Stats ";
	  
	  $sGroupBy = "GROUP BY DAY( Stats.Date ) ";
	  
	  $sDataSource = "Stats";
	} elseif ( $sViewType == "Visits") { 

	  $sSQL = "SELECT GroupIpsByDate.Date, GroupIpsByDate.IP, DAY( GroupIpsByDate.Date ) AS Day, COUNT(GroupIpsByDate.IP) AS Total ";
	  $sSQL .= " FROM GroupIpsByDate ";
	  
	  $sGroupBy = "GROUP BY DAY( GroupIpsByDate.Date ) ";
	  
	  $sDataSource = "GroupIpsByDate";
	}  

	$sHaving = "HAVING ((1=1) ";

	if (strlen( $lYear ) > 0 ) {
	  $sHaving .= "AND (YEAR( ". $sDataSource .".Date)=" . $lYear . ") ";
	  $sGroupBy .= ", YEAR( ". $sDataSource .".Date) ";
	}

	if (strlen( $lMonth ) > 0 ) {
	  $sHaving .= "AND (MONTH( ". $sDataSource .".Date)=" . $lMonth . ") ";
	  $sGroupBy .= ", MONTH( ". $sDataSource .".Date) ";
	}

	if (strlen( $lWeek ) > 0 ) {
	  $sHaving .= "AND (DAYOFWEEK( ". $sDataSource .".Date )=" . $lWeek . ") ";
	  $sGroupBy .= ", DAYOFWEEK( ". $sDataSource .".Date ) ";
	}

    $sHaving .= ")";
	//echo $sSQL . $sGroupBy . $sHaving;die();
	global $db;
	$data = $db->query($sSQL . $sGroupBy . $sHaving);
	
    $aDays = array();

	for ($i = 0; $i < 31; $i++) {
		$aDays[$i] = 0;
	}	
		
	$lTotal = 0;
	$lTop = 0;
    
	foreach($data->fetchAll() as $row) {
		if ($row["Total"] > $lTop ) {
		  $lTop = $row["Total"];
		}
		$lTotal = $lTotal + $row["Total"];  
		$aDays[ $row["Day"] -1  ] = $row["Total"];
	}	
 
?>   
   <table border="0" cellspacing="1" cellpadding="2" class="titlebg">
		<tr>
		   <td class="titlebg" width="10">»</td>
		   <td colspan="3" class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType;?> <?=$lang["view_day"]; ?></td>
		   <td class="titlebg" width="10"></td>
		</tr>
		<tr>
			<td class="listbg"></td>
			<td class="listbg" valign="bottom"></td>
			<?php
			   foreach($aDays as $lCounter) {
					if ( $lCounter > 0 ) { 
						$lHeight = ($lCounter/$lTop ) * 150;
					}  else  { 
						$lHeight = 0;
					}
			?>
			<td class="listbg" valign="bottom" align="center">
			   <img src="/assets/insya.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
			</td>
			<?php } ?>
			<td class="listbg" width="10"></td>
		</tr>
		<tr>
			<td class="listbg"></td>
			<td class="listbg"><?=$sViewType;?></td>
			<?php foreach($aDays as $lCounter) { ?>
			<td class="listbg" align="center"><?=$lCounter;?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
			<td class="listbg"></td>
			<td class="listbg">%</td>
			<?php	
				foreach($aDays as $lCounter) {
				$lPercent = ($lTotal > 0 ) ?  $lCounter / $lTotal : 0;
			?>
			<td class="listbg" align="center"><?=FormatPercent($lPercent);?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
			<td class="listbg"></td>
			<td class="listbg"><?=$lang["day"]; ?></td>
			<?php	
			   foreach($aDays as $key => $lCounter) {
				  $sDay = "";
				  if ($lYear > 0 && $lMonth > 0 ) {
					 $sDay = '<a href="graphs?year=' . $lYear . '&month=' . $lMonth . '&day=' . $key+1  . '">' . $key+1 . '</a>';
				  }  else  { 
					 $sDay = $key+1;
				  }
			?>
			<td class="listbg" align="center"><?=$sDay?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
	</table>
	<br /><br />
<?php } ?>

<?php

//  GraphWeek
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
// lYear - a four-digit year or "" for none.
  
function GraphWeek( $sViewType, $lYear, $lang )
{
	if ($sViewType == "Views" ) {
	  $sSQL = "SELECT Stats.Date, Stats.IP, WEEKOFYEAR( Stats.Date ) as Week, Count(Stats.IP) AS Total ";// ww
	  $sSQL .= "FROM Stats ";
	  
	  $sGroupBy = "GROUP BY WEEKOFYEAR( Stats.Date ) ";// ww
	  
	  $sDataSource = "Stats";
	} elseif ( $sViewType == "Visits" ) {
	  $sSQL = "SELECT GroupIpsByDate.Date, GroupIpsByDate.IP, WEEKOFYEAR( GroupIpsByDate.Date ) as Week, Count(GroupIpsByDate.IP) AS Total ";
	  $sSQL .= "FROM GroupIpsByDate ";
	  
	  $sGroupBy = "GROUP BY WEEKOFYEAR( GroupIpsByDate.Date ) "; // ww
	  
	  $sDataSource = "GroupIpsByDate";
	}
	
	$sHaving = " HAVING ((1=1) ";

	if (strlen( $lYear ) > 0 ) {
	  $sHaving .= "AND (YEAR( ". $sDataSource .".Date)=" . $lYear . ") ";
	  $sGroupBy .= ", YEAR( ". $sDataSource .".Date) ";
	}

	$sHaving .= ")";
 
    global $db;
	$data = $db->query($sSQL . $sGroupBy . $sHaving);
 
    $aWeeks = array();
	
	for ($i = 0; $i < 54; $i++) {
		$aWeeks[$i] = 0;
	}	
	
	$lTotal = 0;
	$lTop = 0;
	
	foreach($data->fetchAll() as $row) {
	    if ($row["Total"] > $lTop) {
	      $lTop = $row["Total"];
		}
	    
		$aWeeks[ $row["Week"] -1  ] = $row["Total"];
	    $lTotal = $lTotal + $row["Total"];
	}
    
?>   
   <table border="0" cellspacing="1" cellpadding="2" class="titlebg">
	   <tr>
		   <td class="titlebg" width="10">»</td>
		   <td colspan=53 class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType;?> <?=$lang["view_year_weekly"]; ?></td>
		   <td class="titlebg" width="10"></td>
      </tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg" valign="bottom"></td>
			<?php
				foreach ( $aWeeks as $lCounter) {
				$lHeight = ($lTop > 0) ? ($lCounter/$lTop ) * 150 : 0;
			?>
				<td class="listbg"  valign="bottom" align="center">
				   <img src="/assets/insya.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
				</td>
			<?php } ?>
			<td class="listbg" width="10"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$sViewType;?></td>
			<?php foreach ( $aWeeks as $lCounter) { ?>
				<td class="listbg" align="center"><?=$lCounter; ?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg">%</td>
			<?php	
			foreach ( $aWeeks as $lCounter) {
				$lPercent = ($lTotal > 0 ) ? ($lCounter/$lTotal) : 0;
			?>
					<td class="listbg" align="center"><?=FormatPercent($lPercent); ?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["week"]; ?></td>
			<?php foreach ( $aWeeks as $key => $lCounter) { ?>
				<td class="listbg" align="center"><?= $key+1; ?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
	</table>
	<br /><br />
<?php	
}
 
//  GraphMonth
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
// lYear - a four-digit year or "" for none.
//
function GraphMonth( $sViewType, $lYear, $lang )
{ 

	if ($sViewType == "Views" ){
		$sSQL = "SELECT Stats.Date, Stats.IP, MONTH( Stats.Date ) AS Month, Count(Stats.IP) AS Total ";
		$sSQL .= "FROM Stats ";

		$sGroupBy = "GROUP BY MONTH( Stats.Date ) ";

		$sDataSource = "Stats";
	} elseif ( $sViewType = "Visits" ) {
		$sSQL = "SELECT GroupIpsByDate.Date, GroupIpsByDate.IP, MONTH( GroupIpsByDate.Date ) AS Month, COUNT(GroupIpsByDate.IP) AS Total ";
		$sSQL .= "FROM GroupIpsByDate ";

		$sGroupBy = "GROUP BY MONTH( GroupIpsByDate.Date ) ";

		$sDataSource = "GroupIpsByDate";
	}  
   
	$sHaving = " HAVING ((1=1) ";

	if (strlen( $lYear ) > 0 ) {
		$sHaving .=  "AND (YEAR( ". $sDataSource .".Date )=" . $lYear . ") ";
		$sGroupBy .=  ", YEAR( ". $sDataSource .".Date ) ";
	}
   
    $sHaving .= ")";
   
    global $db;
	$data = $db->query($sSQL . $sGroupBy . $sHaving);
	
    $aMonths = array();
	
	for ($i = 0; $i < 12; $i++) {
		$aMonths[$i] = 0;
	}	
	
	$lTotal = 0;
	$lTop = 0;
	
	foreach($data->fetchAll() as $row) {
		
		if ($row["Total"] > $lTop ){
			$lTop =  $row["Total"];
		}

		$aMonths[ $row["Month"] -1 ] = $row["Total"];
		$lTotal = $lTotal + $row["Total"];
	}
?>   
   <table border="0" cellspacing="1" cellpadding="2" class="titlebg">
	   <tr>
		   <td class="titlebg" width="10">»</td>
		   <td colspan="12" class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType;?> <?=$lang["view_month"]; ?></td>
		   <td class="titlebg" width="10"></td>
      </tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg" valign="bottom"></td>
			<?php
				foreach( $aMonths as $lCounter) {
				$lHeight = ($lTop > 0 ) ? ($lCounter/$lTop ) * 150 : 0;
			?>
			<td class="listbg"  valign="bottom" align="center">
			   <img src="/assets/insya.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
			</td>
			<?php } ?>
			<td class="listbg" width="10"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$sViewType;?></td>
			<?php foreach($aMonths as $lCounter) { ?>
				<td class="listbg" align="center"><?=$lCounter;?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg">%</td>
			<?php foreach($aMonths as $lCounter) { ?>
				<td class="listbg" align="center"><?=FormatPercent($lCounter/$lTotal);?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["month"]; ?></td>
			<?php	
			   foreach($aMonths as $key => $lCounter) { 
				  
				  $sMonth = "";
				  $months = explode(",", $lang['months']);
				  $mName = $months[$key];
			  
				  if ($lYear > 0 ) {
					 $sMonth = '<a href="reportpathd?year=' . $lYear . '&month=' . $key + 1 . '">' . $mName . '</a>';
				  } else {
					 $sMonth = $mName;
				  }
			?> 
					<td class="listbg" align="center"><?=$sMonth;?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
	</table>
	<br /><br />
<?php }

// GraphYear
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
 
function GraphYear( $sViewType , $lang) 
{
	if ($sViewType == "Views" ) {
		$sSQL = "SELECT Stats.Date, Stats.IP, YEAR( Stats.Date ) as Year, Count(Stats.IP) AS Total ";
		$sSQL .= "FROM Stats ";
		$sSQL .=  "GROUP BY YEAR( Stats.Date ) ";
	} elseif ( $sViewType == "Visits" ) {
		$sSQL = "SELECT GroupIpsByDate.Date, GroupIpsByDate.IP, YEAR( GroupIpsByDate.Date ) as Year, Count(GroupIpsByDate.IP) AS Total ";
		$sSQL .= "FROM GroupIpsByDate ";
		$sSQL .= "GROUP BY YEAR( GroupIpsByDate.Date ) ";
	} 
	
	global $db;
	
	$data = $db->query($sSQL);
 
    $aYears = array(); 
    $aYearValues = array(); 
	
	for ($i = 0; $i < 25; $i++) {
		$aYears[$i] = 0;
		$aYearValues[$i] = 0;
	}	
	
	$lTotal = 0;
	$lTop = 0;
	$lCounter = 0;
	
	foreach($data->fetchAll() as $row) {
		if ( $row["Total"] > $lTop ) {
		  $lTop = $row["Total"];
		}
		$lTotal = $lTotal + $row["Total"];
		$aYearValues[ $lCounter ] = $row["Total"];
		$aYears[ $lCounter ] = $row["Year"];
		$lCounter++;
	}	

?>   
<table border="0" cellspacing="1" cellpadding="2" class="titlebg">
		<tr>
		   <td class="titlebg" width="10">»</td>
		   <td colspan="<?=$lCounter+1?>" class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType;?> <?=$lang["view_year"]; ?></td>
		   <td class="titlebg" width="10"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg" valign="bottom"></td>
		<?php
		   foreach($aYearValues as $lCounter) {
				if ( $lCounter == 0 ) break;
				$lHeight = ($lTop > 0 ) ? ($lCounter/$lTop ) * 150 : 0;
		?>
		<td class="listbg"  valign="bottom" align="center">
		   <img src="/assets/insya.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
		</td>
		<?php } ?>
		<td class="listbg" width="10"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$sViewType;?></td>
		<?php	
		   foreach($aYearValues as $lCounter) {
			  if ( $lCounter == 0 ) break;
		?>
		<td class="listbg" align="center"><?=$lCounter;?></td>
		<?php } ?>
		<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg">%</td>
		<?php	
		   foreach($aYearValues as $lCounter) {
			  if ( $lCounter == 0 ) break;
			  $lPercent = ($lTotal > 0 ) ? $lCounter / $lTotal : 0;
		?>
		<td class="listbg" align="center"><?=FormatPercent($lPercent);?></td>
		<?php } ?>
		<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["year"]; ?></td>
		<?php	
		   foreach($aYears as $lCounter) {
			  if ( $lCounter == 0 ) break;
		?>
		<td class="listbg" align="center"><?=$lCounter ?></td>
		<?php } ?>
		<td class="listbg"></td>
		</tr>
	</table>
	<br /><br />
<?php	
	
}

function FormatPercent($percent){
	return '%' . number_format( $percent * 100, 2 );
}

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

 
?>

<hr size="1" color="#C0C0C0" noshade>
<br />
<?php

   $sBackCode = "<br /><br /><b>". $lang["data_display"] ." " . GetDates($lang) . "</b><br /><br />";

   $stype = request( "type" );
   
   echo ( '» <a href="reports">'. $lang["reports"]. '</a> » <a href="/graphs">'. $lang["graphs"]. '</a> » ');

   switch ($stype) {
	case "hour":
         echo ( $lang["view_hourly"] . $sBackCode );
         
         GraphHours ( "Views", request("year"), request("month"), request("day"), $lang );
         GraphHours ( "Visits", request("year"), request("month"), request("day"), $lang );
		break;
	case "dow":
         echo ( $lang["view_weekly"] . $sBackCode );
        
         GraphDayOfWeek ( "Views", request("year"), request("month"), request("week"), $lang );
         GraphDayOfWeek ( "Visits", request("year"), request("month"), request("week"), $lang );
		break;
	case "dom":
         echo ( $lang["view_daily"] . $sBackCode );
        
         GraphDayOfMonth ( "Views", request("year"), request("month"), request("week"), $lang );
         GraphDayOfMonth ( "Visits", request("year"), request("month"), request("week"), $lang );
		break;
	case "week":
         echo ( $lang["view_year_weekly"] . $sBackCode );
        
         GraphWeek ( "Views", request("year"), $lang );
         GraphWeek ( "Visits", request("year"), $lang );
		break;
	case "month":
         echo ( $lang["view_monthly"] . $sBackCode );
        
         GraphMonth ( "Views", request("year"), $lang );
         GraphMonth ( "Visits", request("year"), $lang );
		break;
	case "year":
         echo ( $lang["view_yearly"] . $sBackCode );
        
         GraphYear ( "Views", $lang );
         GraphYear ( "Visits" , $lang);
		break;
 
   }  
?>

<p class="title"><?=$lang["graphs"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="/graphs?type=hour"><?=$lang["graphs_hour"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="/graphs?type=dow"><?=$lang["graphs_dow"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="/graphs?type=dom"><?=$lang["graphs_dom"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="/graphs?type=week"><?=$lang["graphs_week"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="/graphs?type=month"><?=$lang["graphs_month"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="/graphs?type=year"><?=$lang["graphs_year"]; ?></a><br />
</p>

<p class="title"><?=$lang["admin"]; ?></p>
» <?=$lang["view"]; ?> <a href="admin"><?=$lang["admin_page"]; ?></a>
<br />

<br />
<a href="<?= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '/reports'; ?>"><?=$lang["back"]; ?></a>
<br />
<br />