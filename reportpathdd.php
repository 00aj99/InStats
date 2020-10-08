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
» <a href="reports.php"><?=$lang["reports"]; ?></a> » <a href="reportpathy.php"><?=$lang["yearly"]; ?></a> 
» <a href="reportpathm.php?year=<?=$sYear;?>"><?=$lang["monthly"]; ?></a> 
» <a href="reportpathd.php?year=<?=$sYear;?>&month=<?=$sMonth;?>"><?=$lang["daily"]; ?></a> 
<br /><br />

<?php

function SQLTable($sTitle, $sSQL) {
 
	global $db;
	global $lang;
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
				
				$name = isset($lang[$field]) ? $lang[$field] : $field;
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
	
	$sDate = $sYear . "-" . $sMonth . "-" . $sDay; 
	
	$months = explode(",", $lang['months']);
	$mName = $sMonth > 0 ? $months[$sMonth] : "";

	echo( $lang["stats"] . ": " . $mName . " " . $sDay . ", " . $sYear . "<br /><br />");
	
    $qstring = $_SERVER['QUERY_STRING'];
	
    if (request("rall") != "" || request("pall") != "") {
		$qstring = substr ($qstring, strpos($qstring, ".") - 1);
    }
	
	$pLimit = "";
	$rLimit = "";

    if (request("pall") != "yes") $pLimit = " LIMIT 10";
    SQLTable('<a href="reportpathdd.php?' . $qstring . '">'. $lang["top_ten_page"] . '</a> <a href="reportpathdd.php?' . $qstring . '&pall=yes">('. $lang['all_pages'] .')</a>', "SELECT paths.pathname, COUNT(paths.pathname) AS total FROM stats LEFT JOIN paths ON (stats.PathID=paths.PathID) WHERE stats.date = '$sDate'  GROUP BY paths.pathname ORDER BY COUNT(paths.pathname) DESC ". $pLimit);
    
	if (request("rall") != "yes") $rLimit = "LIMIT 10";
    SQLTable('<a href="reportpathdd.php?' . $qstring . '">'. $lang["graphs_hour"] .'</a> <a href="reportpathdd.php?' . $qstring . '&rall=yes">('. $lang['all_referers'] .')</a>', "SELECT refname, COUNT(refname) AS total FROM stats LEFT JOIN refs ON (stats.RefID=refs.RefID) WHERE date = '$sDate' GROUP BY refname ORDER BY COUNT(refname) DESC ". $rLimit);

	SQLTable($lang["browsers"], "SELECT browsername, COUNT(browsername) AS total FROM stats 
								  		LEFT JOIN browsers ON (stats.browserid=browsers.browserid) WHERE date = '$sDate' GROUP BY browsername ORDER BY COUNT(browsername) DESC");

    SQLTable($lang["resolutions"], "SELECT resname, COUNT(resname) AS total FROM stats 
										LEFT JOIN resolutions ON (stats.ResID=resolutions.ResID) WHERE date = '$sDate'  GROUP BY resname ORDER BY COUNT(resname) DESC");

	SQLTable($lang["colors"], "SELECT colorname, COUNT(colorname) AS total FROM stats 
										LEFT JOIN colors ON (stats.colorid=colors.colorid) WHERE date = '$sDate' GROUP BY colorname ORDER BY COUNT(colorname) DESC");

    SQLTable($lang["oses"], "SELECT osname, COUNT(osname) AS total FROM stats 
										LEFT JOIN oses ON (stats.osid=oses.osid) WHERE date = '$sDate' GROUP BY osname ORDER BY COUNT(osname) DESC");
	
	SQLTable($lang["langs"], "SELECT langname, COUNT(langname) AS total FROM stats 
										LEFT JOIN langs ON (stats.langid=langs.langid) WHERE date = '$sDate' GROUP BY langname ORDER BY COUNT(langname) DESC");
	
	SQLTable($lang["uagents"], "SELECT uagentname, COUNT(uagentname) AS total FROM stats 
										LEFT JOIN uagents ON (stats.uagentid=uagents.uagentid) WHERE date ='$sDate' GROUP BY uagentname ORDER BY COUNT(uagentname) DESC");
	
	SQLTable($lang["keywords"], "SELECT keyword, COUNT(keyword) AS total FROM stats 
										LEFT JOIN keywords ON (stats.keyid=keywords.keyid) WHERE date = '$sDate' GROUP BY keyword ORDER BY COUNT(keyword) DESC");
	
	SQLTable($lang["visitors"], "SELECT visitorname, COUNT(visitorname) AS total FROM stats 
										LEFT JOIN visitors ON (stats.visitorid=visitors.visitorid) WHERE date = '$sDate' GROUP BY visitorname ORDER BY COUNT(visitorname) DESC");
 
?>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="ips.php?year=<?=$sYear; ?>&month=<?=$sMonth; ?>&day=<?=$sDay; ?>"><?=$lang["report_ips"]; ?></a><br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?= $mName . " " . $sDay . ", " . $sYear; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="graphs.php?type=hour&year=<?=$sYear; ?>&month=<?=$sMonth; ?>&day=<?=$sDay; ?>"><?=$lang["graphs_hour"]; ?></a><br />
</p>
 

<?php require "views/footer.php"; ?>