 
» <a href="/reports"><?=$lang["reports"]; ?></a> » <a href="/reportpathy"><?=$lang["yearly"]; ?></a> 
» <a href="/reportpathm?year=<?=$sYear;?>"><?=$lang["monthly"]; ?></a> 
» <a href="/reportpathd?year=<?=$sYear;?>&month=<?=$sMonth;?>"><?=$lang["daily"]; ?></a> 
<br /><br />

<?php

function SQLTable($sTitle, $sSQL, $lang) {
 
	global $db;
	$result = $db->query($sSQL);
	
?>
		<table border="0" cellspacing="0" cellpadding="0" class="titlebg list" width="600">
			<tr>
				<td class="smallerheader titlebg" width="10">»</td>
				<td class="smallerheader titlebg" colspan="2"><?=$sTitle; ?></td>
				<td class="smallerheader titlebg" width="10"></td>
			</tr>
		<tr>
			<td class="listbg" width="10"></td>
			<?php
			$iFieldCount = 0;
			foreach ( getNames($result) as $field ) : 
			
				$iFieldCount++;
				
				if ($iFieldCount == 1) {
					$iWidth = 500;
					$sAlign="left";
				} else {
					$iWidth = 50;
					$sAlign="right";
				}
				
				$name = $lang[$field];
			?>
				<td width="<?=$iWidth;?>" align="<?=$sAlign;?>" class="listbg"><?=$name;?></td>
			<?php endforeach; ?>
			<td class="listbg" width="10"></td>
		</tr>
		
	<?php
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

		echo '<tr class="listbg">';
		echo '<td class="listbg" width="10"></td>';
		
		$iFieldCount = 0;
		for ($i = 0; $i < $result->columnCount(); $i++){
			$field = $result->getColumnMeta($i)["name"];
	
			$iFieldCount++;
			
			if ($iFieldCount == 1) {
				$iWidth = 400;
				$sAlign="left";
			} else {
				$iWidth = 50;
				$sAlign="right";
			}
			
			if (BSHOWLINKS && startsWith( $row[$field], "http://" )) {
				$sFieldName = '<a href="'. $row[$field] . '" target="_blank">'. $row[$field] . '</a>';
			} else {
				$sFieldName = $row[$field];
			}
	?>
		<td class="listbg" align="<?=$sAlign;?>"><?=$sFieldName;?></td>
		<?php } ?>
		<td class="listbg" width="10"></td>
	</tr>
	<?php } ?>
	
</table>
<?php } ?>

<?php 
	
	$sYear = request("year");
	$sMonth = request("month");
	$sDay = request("day");
	
	$sDate = $sYear . "." . $sMonth . "." . $sDay; 
	$monthName = "";
	if($sMonth != "" && isset($sMonth))
	{
		$monthName = "ws"  ;//date("F", mktime(0, 0, 0, $sMonth, 1));
	}
	
	echo( $lang["stats"] . ": " . $monthName . " " . $sDay . ", " . $sYear . "<br /><br />");
	
    $qstring = $_SERVER['QUERY_STRING'];
	
    if (request("rall") != "" || request("pall") != "") {
		$qstring = substr ($qstring, strpos($qstring, ".") - 1);
    }
	
	$pLimit = "";
	$rLimit = "";

    if (request("pall") != "yes") $pLimit = " LIMIT 10";
    SQLTable('<a href="/reportpathdd?' . $qstring . '">'. $lang["top_ten_page"] . '</a> <a href="/reportpathdd?' . $qstring . '&pall=yes">('. $lang['all_pages'] .')</a>', 'SELECT Paths.PathName, COUNT(Paths.PathName) AS Total FROM Stats LEFT JOIN Paths ON (Stats.PathID=Paths.PathID) WHERE Stats.Date = \'' . $sDate . '\'  GROUP BY Paths.PathName ORDER BY COUNT(Paths.PathName) DESC '. $pLimit, $lang);
    
	if (request("rall") != "yes") $rLimit = "LIMIT 10";
    SQLTable('<a href="/reportpathdd?' . $qstring . '">'. $lang["graphs_hour"] .'</a> <a href="/reportpathdd?' . $qstring . '&rall=yes">('. $lang['all_referers'] .')</a>', 'SELECT RefName, COUNT(RefName) AS Total FROM Stats LEFT JOIN Refs ON (Stats.RefID=Refs.RefID) WHERE Date = \'' . $sDate . '\' GROUP BY RefName ORDER BY COUNT(RefName) DESC '. $rLimit, $lang);

	SQLTable($lang["browsers"], 'SELECT BrowserName, COUNT(BrowserName) AS Total FROM Stats LEFT JOIN Browsers ON (Stats.BrowserID=Browsers.BrowserID) WHERE Date = \'' . $sDate . '\' GROUP BY BrowserName ORDER BY COUNT(BrowserName) DESC', $lang);

    SQLTable($lang["resolutions"], 'SELECT ResName, COUNT(ResName) AS Total FROM Stats LEFT JOIN Resolutions ON (Stats.ResID=Resolutions.ResID) WHERE Date =  \'' . $sDate . '\'  GROUP BY ResName ORDER BY COUNT(ResName) DESC', $lang);

	SQLTable($lang["colors"], 'SELECT ColorName, COUNT(ColorName) AS Total FROM Stats LEFT JOIN Colors ON (Stats.ColorID=Colors.ColorID) WHERE Date = \'' . $sDate . '\'  GROUP BY ColorName ORDER BY COUNT(ColorName) DESC', $lang);

    SQLTable($lang["oses"], 'SELECT OsName, COUNT(OsName) AS Total FROM Stats LEFT JOIN OSes ON (Stats.OsID=OSes.OsID) WHERE Date = \'' . $sDate . '\' GROUP BY OsName ORDER BY COUNT(OsName) DESC', $lang);
 
?>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_datas"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="/ips?year=<?=$sYear; ?>&month=<?=$sMonth; ?>&day=<?=$sDay; ?>"><?=$lang["report_ips"]; ?></a><br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?=date("F", mktime(0, 0, 0, $sMonth, 1)) . " " . $sDay . ", " . $sYear; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="/graphs?type=hour&year=<?=$sYear; ?>&month=<?=$sMonth; ?>&day=<?=$sDay; ?>"><?=$lang["graphs_hour"]; ?></a><br />
</p>
 
