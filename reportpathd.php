<?php
/*
  InStats
  @yasinkuyu, 2016
*/

require 'config.php';
require "apps/languages/tr-tr.php";
require "views/layout.php";
 
	$months = explode(",", $lang['months']);
	$mName = $sMonth > 0 ? $months[$sMonth] : "";

?>
<hr size="1" color="#C0C0C0" noshade>
<br />
» <a href="reports.php"><?=$lang["reports"]; ?></a> » <a href="reportpathy.php"><?=$lang["yearly"]; ?></a> 
» <a href="reportpathm.php?year=<?=$sYear;?>"><?=$lang["monthly"]; ?></a> 
» <?=$lang["daily"]; ?>
<br /><br />

<table border="0" cellspacing="0" cellpadding="0" class="titlebg list">
	<tr>
		<td class="titlebg" width="10">»</td>
		<td colspan="3" class="smallerheader titlebg" width="320"><?=$lang['daily_reports'];?>  (<?=  $mName . " " . $sYear; ?>)</td>
		<td class="titlebg" width="10"></td>
	</tr>	
	<tr>
		<td class="listbg" width="10"></td>
		<td class="smallerheader listbg" width="200"><?=$lang['day'];?></td>
		<td class="smallerheader listbg" width="60"><?=$lang['page_views'];?></td>
		<td class="smallerheader listbg" width="60"><?=$lang['visitors'];?></td>
		<td class="listbg" width="10"></td>
	</tr>
	<?php
	 	 
	    global $db;
		
		$reportpathd = $db->query('
			SELECT
				topipsperday.date,
				toppageviewsperday.date,
				Sum(topipsperday.total) AS ips,
				Sum(toppageviewsperday.total) AS Views,
				DAY(topipsperday.date) AS DayNumber
			FROM
				topipsperday
			INNER JOIN toppageviewsperday ON topipsperday.date = toppageviewsperday.date
			GROUP BY
				DAY(topipsperday.date),
				YEAR(topipsperday.date),
				MONTH(topipsperday.date)
			HAVING
				YEAR(topipsperday.date) = "'. $sYear .'"
			AND MONTH(topipsperday.date) = "'. $sMonth .'"
		');
	 
		foreach ($reportpathd->fetchAll() as $row){
	?>
	<tr>
		<td class="listbg"></td>
		<td class="listbg" width="200"><a href="reportpathdd.php?year=<?=$sYear;?>&month=<?=$sMonth;?>&day=<?=$row["DayNumber"];?>"><?=$row["DayNumber"];?></td>
		<td class="listbg" width="80" align="right"><?=$row["Views"];?></td>
		<td class="listbg" width="50" align="right"><?=$row["ips"];?></td>
		<td class="listbg"></td>
	</tr>

	<?php } ?>
</table>
 
<p class="title"><?=$lang["detail_stats"]; ?> (<?= $mName . " " . $sYear; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="ips.php?year=<?=$sYear;?>&month=<?=$sMonth;?>"><?=$lang["report_ips"]; ?></a><br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?= $mName . " " . $sYear; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="graphs.php?type=hour&year=<?=$sYear;?>&month=<?=$sMonth;?>"><?=$lang["graphs_hour"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=dow&year=<?=$sYear;?>&month=<?=$sMonth;?>"><?=$lang["graphs_dow"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=dom&year=<?=$sYear;?>&month=<?=$sMonth;?>"><?=$lang["graphs_dom"]; ?></a>.<br />
</p>


<?php
	require "views/footer.php";
?>