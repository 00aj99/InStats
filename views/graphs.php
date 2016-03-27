<?php
  
// GraphHours
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
// lyear - a four-digit year or "" for none.
// lmonth - a 0-based one- or two-digit month number.
// lDay - a 1-based one- or two- digit day number.
 
function GraphHours( $sViewType, $lyear, $lmonth, $lDay , $lang)   
{
	if ($sViewType === "Views") {
	  
	  $sSQL = "SELECT DATE_FORMAT( Stats.Time, '%h') As Hour, COUNT(Stats.IP) AS Total ";
	  $sSQL.= " FROM Stats ";
	  
	  $sGroupBy = " GROUP BY DATE_FORMAT( Stats.Time, '%h') ";
	  
	  $sDataSource = "Stats";
	  
	} elseif ($sViewType == "Visits") {
		
	  $sSQL = "SELECT GroupIpsByHourAndDate.Hour, COUNT(GroupIpsByHourAndDate.IP) AS Total ";
	  $sSQL.=" FROM GroupIpsByHourAndDate ";
	  
	  $sGroupBy = " GROUP BY GroupIpsByHourAndDate.Hour ";
	  
	  $sDataSource = "GroupIpsByHourAndDate";
	} 
 
	$sHaving = " HAVING ((1=1) ";

	if( strlen( $lyear ) > 0 ) {
	  $sHaving .= "AND (DATE_FORMAT( ". $sDataSource .".Date, '%Y')=" . $lyear . ") ";
	  $sGroupBy .= ", DATE_FORMAT( ". $sDataSource .".Date, '%Y') ";
	}

	if( strlen( $lmonth ) > 0 ) {
	  $sHaving .= "AND (DATE_FORMAT( ". $sDataSource .".Date, '%m')=" . $lmonth . ") ";
	  $sGroupBy .= ", DATE_FORMAT( ". $sDataSource .".Date, '%m') ";
	}

	if( strlen( $lDay ) > 0 ) {
	  $sHaving .= "AND (DATE_FORMAT( ". $sDataSource .".Date, '%d')=" . $lDay . ") ";
	  $sGroupBy .= ", DATE_FORMAT( ". $sDataSource .".Date, '%d') ";
	} 

    $sHaving .= " ) ";
  
	global $db;	
 	$data = $db->prepare($sSQL);
	$data->execute();
	
    $ahours = array();
	$lTotal = 0;
	$lTop = 0;
	
    // Calculate totals
	foreach($data as $row) {
		if ( $row["Total"] > $lTop ) {  
			$lTop = $row["Total"];
		}
	    $lTotal = $lTotal + $row["Total"];
	    $ahours[$row["Hour"]] = $row["Total"];
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
		foreach($ahours as $lCounter) {
			
			if ($lTop > 0) {
				$lHeight = ($lCounter/$lTop) * 150;
			}  else  { 
				$lHeight = 0;
			}
		?>
			<td class="listbg" valign="bottom" align="center">
			   <img src="/assets/dr.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter; ?>">
			</td>
		<?php } ?>
			<td class="listbg" width="10"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$sViewType;?></td>
		<?php foreach($ahours as $lCounter) { ?>
			<td class="listbg" align="center"><?=$lCounter;?></td>
		<?php } ?>
		<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg">%</td>
		<?php foreach($ahours as $lCounter) { 
   		if  ($lTotal > 0) {
	   		$sPercent = $lCounter/$lTotal;
		}  else  { 
			$sPercent = "";
		}
		?>
		<td class="listbg" align="center"><?=$sPercent?></td>
		<?php } ?>
		<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["hour"]; ?></td>
		<?php for($lCounter = 0; $lCounter < 23; $lCounter++){ ?>
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
// lyear - a four-digit year or "" for none.
// lmonth - a 0-based one- or two-digit month number.
// lweek - a 0-based one- or two-digit week (of year) number
 
function GraphDayOfWeek( $sViewType, $lyear, $lmonth, $lweek, $lang )
{
   if ($sViewType == "Views") { 
      $sSQL = "SELECT DATE_FORMAT( Stats.Date, '%w') as Day, Count(Stats.IP) AS Total ";
      $sSQL.= "FROM Stats ";
      
      $sGroupBy = "GROUP BY DATE_FORMAT( Stats.Date, '%w') ";
      
      $sDataSource = "Stats";
    } elseif ($sViewType == "Visits") {  
      $sSQL = "SELECT DATE_FORMAT( GroupIpsByDate.Date, '%w') as Day, Count(GroupIpsByDate.IP) AS Total ";
      $sSQL.= "FROM GroupIpsByDate ";
      
      $sGroupBy = "GROUP BY DATE_FORMAT( GroupIpsByDate.Date, '%w') ";
      
      $sDataSource = "GroupIpsByDate";
	}  else  { 
      exit();
	}

	$sHaving = " HAVING ((1=1) ";

	if (strlen( $lyear ) > 0) {
	  $sHaving = $sHaving . "AND (DATE_FORMAT( ". $sDataSource .".Date, '%Y')=" . $lyear . ") ";
	  $sGroupBy = $sGroupBy . ", DATE_FORMAT( ". $sDataSource .".Date, '%Y') ";
	}

	if (strlen( $lmonth ) > 0) {
	  $sHaving = $sHaving . "AND (DATE_FORMAT( ". $sDataSource .".Date, '%m')=" . $lmonth . ") ";
	  $sGroupBy = $sGroupBy . ", DATE_FORMAT( ". $sDataSource .".Date, '%m') ";
	}

	if (strlen( $lweek ) > 0) {
	  $sHaving = $sHaving . "AND (DATE_FORMAT( ". $sDataSource .".Date, '%w')=" . $lweek . ") ";
	  $sGroupBy = $sGroupBy . ", DATE_FORMAT( ". $sDataSource .".Date, '%w') ";
	} 

    $sHaving .= ")";

	global $db;	
 	$data = $db->prepare($sSQL);
	$data->execute();
	
	$aDays = array();
	$lTotal = 0;
	$lTop = 0;
	
    // Calculate totals
	foreach($data->fetchAll() as $row) {
		if ($row["Total"] > $lTop){
			$lTop = $row["Total"];
		}
		$lTotal = $lTotal + $row["Total"];
		$aDays[ $row["Day"] -1 ] = $row["Total"];
	}

   // Display results
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
		   <img src="/assets/dr.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
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
		   <td class="listbg"></td>
		   <td class="listbg">%</td>
<?php foreach($aDays as $lCounter) { ?>
		<td class="listbg" align="center"><?=$lCounter/$lTotal;?></td>
<?php } ?>
		<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["day"]; ?></td>
<?php for($lCounter = 0; $lCounter < 6; $lCounter++) { ?>
		<td class="listbg" align="center"><?=  date("w", strtotime($lCounter + 1)); ?></td>
<?php } ?>
		<td class="listbg"></td>
		</tr>
	</table>
	<br /><br />
<?php } ?>

<?php
// GraphDayOfmonth
 
// Usage:
// sViewType - The type of content to display. Values: "Visits" or "Views".
// lyear - a four-digit year or "" for none.
// lmonth - a 0-based one- or two-digit month number.
//
function GraphDayOfmonth( $sViewType, $lyear, $lmonth, $lweek, $lang )
{
	if ($sViewType == "Views" ) {
	  $sSQL = "SELECT DATE_FORMAT( Stats.Date, '%d') AS Day, Count(Stats.IP) AS Total ";
	  $sSQL.= "FROM Stats ";
	  
	  $sGroupBy = "GROUP BY DATE_FORMAT( Stats.Date, '%d') ";
	  
	  $sDataSource = "Stats";
	} elseif ( $sViewType == "Visits") { 

	  $sSQL = "SELECT DATE_FORMAT( GroupIpsByDate.Date, '%d') AS Day, COUNT(GroupIpsByDate.IP) AS Total ";
	  $sSQL .= " FROM GroupIpsByDate ";
	  
	  $sGroupBy = "GROUP BY DATE_FORMAT( GroupIpsByDate.Date, '%d') ";
	  
	  $sDataSource = "GroupIpsByDate";
	}  

	$sHaving = "HAVING ((1=1) ";

	if (strlen( $lyear ) > 0 ) {
	  $sHaving .= "AND (DATE_FORMAT( ". $sDataSource .".Date, '%Y')=" . $lyear . ") ";
	  $sGroupBy .= ", DATE_FORMAT( ". $sDataSource .".Date, '%Y') ";
	}

	if (strlen( $lmonth ) > 0 ) {
	  $sHaving .= "AND (DATE_FORMAT( ". $sDataSource .".Date, '%m')=" . $lmonth . ") ";
	  $sGroupBy .= ", DATE_FORMAT( ". $sDataSource .".Date, '%m') ";
	}

	if (strlen( $lweek ) > 0 ) {
	  $sHaving .= "AND (DATE_FORMAT( ". $sDataSource .".Date, '%w')=" . $lweek . ") ";
	  $sGroupBy .= ", DATE_FORMAT( ". $sDataSource .".Date, '%w') ";
	}

    $sHaving .= ")";
 
	global $db;
	$data = $db->prepare($sSQL);
	$data->execute();
	
    $aDays = array();
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
		   <img src="/assets/dr.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
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
		if ($lTotal > 0 ) {
			$lPercent = $lCounter / $lTotal;
		 } else { 
			$lPercent = 0;
		}
?>
		<td class="listbg" align="center"><?=FormatPercent($lPercent);?></td>
<?php } ?>
		<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["day"]; ?></td>
<?php	
   for ($lCounter = 0; $lCounter > 30; $lCounter++) {
      $sDay = "";
      if ($lyear > 0 && $lmonth > 0 ) {
         $sDay = '<a href="graphs?year=' . $lyear . '&month=' . $lmonth . '&day=' . $lCounter + 1 . '">' . ($lCounter + 1) . '</a>';
      }  else  { 
         $sDay++;
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
// lyear - a four-digit year or "" for none.
  
function GraphWeek( $sViewType, $lyear, $lang )
 {
   if ($sViewType == "Views" ) {
      $sSQL = "SELECT DATE_FORMAT( Stats.Date, '%x') as Week, Count(Stats.IP) AS Total ";// ww
      $sSQL .= "FROM Stats ";
      
      $sGroupBy = "GROUP BY DATE_FORMAT( Stats.Date, '%x') ";// ww
      
      $sDataSource = "Stats";
    } elseif ( $sViewType == "Visits" ) {
      $sSQL = "SELECT DATE_FORMAT( GroupIpsByDate.Date, '%x') as Week, Count(GroupIpsByDate.IP) AS Total ";
      $sSQL .= "FROM GroupIpsByDate ";
      
      $sGroupBy = "GROUP BY DATE_FORMAT( GroupIpsByDate.Date, '%x') "; // ww
      
      $sDataSource = "GroupIpsByDate";
   } else {
      exit();
   }

	$sHaving = " HAVING ((1=1) ";

	if (strlen( $lyear ) > 0 ) {
	  $sHaving .= "AND (DATE_FORMAT( ". $sDataSource .".Date, '%Y')=" . $lyear . ") ";
	  $sGroupBy .= ", DATE_FORMAT( ". $sDataSource .".Date, '%Y') ";
	}

	$sHaving .= ")";

    global $db;
	$data = $db->prepare($sSQL);
	$data->execute();
	
    $aWeeks = array();
	$lTotal = 0;
	$lTop = 0;
	
    // Calculate totals
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
		   <td colspan=53 class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType;?> <?=$lang["view_year_week"]; ?></td>
		   <td class="titlebg" width="10"></td>
      </tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg" valign="bottom"></td>
			<?php
			foreach ( $aWeeks as $lCounter) {
				if ($lTop > 0) {
					$lHeight = ($lCounter/$lTop ) * 150;
				}  else { 
					$lHeight = 0;
				}
			?>
				<td class="listbg"  valign="bottom" align="center">
				   <img src="/assets/dr.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
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
				if ($lTotal > 0 ) {
					$lPercent = ($lCounter/$lTotal);
				} else {
					$lPercent = 0;
				}
			?>
					<td class="listbg" align="center"><?=FormatPercent($lPercent); ?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["week"]; ?></td>
			<?php for($lCounter = 0; $lCounter > 53; $lCounter++) { ?>
				<td class="listbg" align="center"><?=$lCounter + 1 ?></td>
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
// lyear - a four-digit year or "" for none.
//
function GraphMonth( $sViewType, $lyear, $lang )
{ 
   $sDataSource = "";
   if ($sViewType == "Views" ){
      $sSQL = "SELECT DATE_FORMAT( Stats.Date, '%m') AS Month, Count(Stats.IP) AS Total ";
      $sSQL .= "FROM Stats ";
      
      $sGroupBy = "GROUP BY DATE_FORMAT( Stats.Date, '%m') ";
      
      $sDataSource = "Stats";
   } elseif ( $sViewType = "Visits" ) {
      $sSQL = "SELECT DATE_FORMAT( GroupIpsByDate.Date, '%m') AS Month, COUNT(GroupIpsByDate.IP) AS Total ";
      $sSQL = $sSQL . "FROM GroupIpsByDate ";
      
      $sGroupBy = "GROUP BY DATE_FORMAT( GroupIpsByDate.Date, '%m') ";
      
      $sDataSource = "GroupIpsByDate";
   } else {
      exit();
   }
   
	$sHaving = " HAVING ((1=1) ";

	if (strlen( $lyear ) > 0 ) {
	  $sHaving .=  "AND (DATE_FORMAT( ". $sDataSource .".Date, '%Y')=" . $lyear . ") ";
	  $sGroupBy .=  ", DATE_FORMAT( ". $sDataSource .".Date, '%Y') ";
	}
   
    $sHaving .= ")";
   
    global $db;
 	$data = $db->prepare($sSQL);
	$data->execute();
	
    $aMonths = array();
	$lTotal = 0;
	$lTop = 0;
	
	foreach($data as $row) {
		if ($row["Total"] > $lTop ){
			$lTop =  $row["Total"];
		}
		$lTotal = $lTotal + $row["Total"];
		$aMonths[ $row["Month"] -1 ] = $row["Total"];
	}
?>   
   <table border="0" cellspacing="1" cellpadding="2" class="titlebg">
	   <tr>
		   <td class="titlebg" width="10">»</td>
		   <td colspan=12 class="smallerheader titlebg"><?=$lang["status"]; ?>: <?=$sViewType;?> <?=$lang["view_month"]; ?></td>
		   <td class="titlebg" width="10"></td>
      </tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg" valign="bottom"></td>
			<?php
				foreach( $aMonths as $lCounter) {
					if ($lTop > 0 ) {
						$lHeight = ($lCounter/$lTop ) * 150;
					} else {
						$lHeight = 0;
					}
			?>
			<td class="listbg"  valign="bottom" align="center">
			   <img src="/assets/dr.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
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
				<td class="listbg" align="center"><?=$lCounter/$lTotal;?></td>
			<?php } ?>
			<td class="listbg"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$lang["month"]; ?></td>
			<?php	
			   for($lCounter=0; $lCounter > 11; $lCounter++) {
				  $sMonth = "";
				  if ($lYear > 0 ) {
					 $sMonth = '<a href="reportpathd?year=' . $lYear . '&month=' . $lCounter + 1 . '">' . date('F', mktime(0, 0, 0, $lCounter + 1, 10)) . '</a>';
				  } else {
					 $sMonth = date('F', mktime(0, 0, 0, $sMonth, 10));
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
 
function GraphYear( $sViewType ) 
{
	if ($sViewType == "Views" ) {
	  $sSQL = "SELECT DATE_FORMAT( Stats.Date, '%Y') as Year, Count(Stats.IP) AS Total ";
	  $sSQL .= "FROM Stats ";
	  $sSQL .=  "GROUP BY DATE_FORMAT( Stats.Date, '%Y') ";
	} elseif ( $sViewType == "Visits" ) {
	  $sSQL = "SELECT DATE_FORMAT( GroupIpsByDate.Date, '%Y') as Year, Count(GroupIpsByDate.IP) AS Total ";
	  $sSQL .= "FROM GroupIpsByDate ";
	  $sSQL .= "GROUP BY DATE_FORMAT( GroupIpsByDate.Date, '%Y') ";
	} else {
	  exit();
	}
    
	global $db;
	$data = $db->prepare($sSQL);
	$data->execute();
	 
    $aYears = array(); 
    $aYearValues = array(); 
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
		if ($lCounter == 0 ){
			exit();
		}
 
		if ($lTop > 0 ) {
			$lHeight = ($lCounter/$lTop ) * 150;
		} else {
			$lHeight = 0;
		}
?>
		<td class="listbg"  valign="bottom" align="center">
		   <img src="/assets/dr.gif" height=<?=$lHeight?> width="10" alt="<?=$lCounter;?>">
		</td>
<?php } ?>
		<td class="listbg" width="10"></td>
		</tr>
		<tr>
		   <td class="listbg"></td>
		   <td class="listbg"><?=$sViewType;?></td>
<?php	
   foreach($aYearValues as $lCounter) {
      if ($lCounter == 0 ) {
         exit();
      }
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
      if ($lCounter == 0 ) {
         exit();
      }
	  
	  if ($lTotal > 0 ) {
	  	$lPercent = $lCounter / $lTotal;
	  } else {
	  	$lPercent = 0;
	  }
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
      if ($lCounter == 0 ) {
         exit();
      }
	  
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
      return $lang["all_datas"];
   endif;
   
   return $return;
}

 
?>

<hr size="1" color="#C0C0C0" noshade>

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
        
         GraphDayOfmonth ( "Views", request("year"), request("month"), request("week"), $lang );
         GraphDayOfmonth ( "Visits", request("year"), request("month"), request("week"), $lang );
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
        
         GraphYear ( "Views" );
         GraphYear ( "Visits" );
		break;
 
   }  
?>

<p class="title"><?=$lang["graphs"]; ?> (<?=$lang["all_datas"]; ?>)</p>
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