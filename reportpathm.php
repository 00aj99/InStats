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
» <?=$lang["monthly"]; ?>
<br /><br />

<table border="0" cellspacing="0" cellpadding="0" class="titlebg list">
	<tr>
		<td class="titlebg" width="10">»</td>
		<td colspan="3" class="smallerheader titlebg" width="300"><?=$sYear;?> <?=$lang["year_stats"]; ?></td>
		<td class="titlebg" width="10"></td>
	</tr>
	<tr>
		<td class="listbg" width="10"></td>
		<td class="smallerheader listbg" width="200"><?=$lang['month'];?></td>
		<td class="smallerheader listbg" width="100"><?=$lang['page_views'];?></td>
		<td class="smallerheader listbg" width="60"><?=$lang['visitors'];?></td>
		<td class="listbg" width="10"></td>
	</tr>

<?php 

	global $db;
	
	$sSQL = '
			SELECT
				*,
				Sum(topipsperday.total) AS ips,
				Sum(toppageviewsperday.total) AS Views,
				MONTH(topipsperday.date) AS MonthNumber
			FROM
				topipsperday
			INNER JOIN toppageviewsperday ON topipsperday.date = toppageviewsperday.date
			GROUP BY
				MONTH(topipsperday.date),
				YEAR(topipsperday.date)
			HAVING
				(YEAR(topipsperday.date) = "'. $sYear .'")
			';
 	
	$reportpathm = $db->query($sSQL);
	
	foreach ($reportpathm->fetchAll() as $row){ 
?>
	<tr>
		<td class="listbg"></td>
		<td class="listbg" width="200"><a href="reportpathd.php?year=<?=$sYear;?>&month=<?=$row["MonthNumber"];?>"><?=date("F", mktime(0, 0, 0, $row["MonthNumber"], 1));?></a> </td>
		<td class="listbg" width="100" align="right"><?=$row["Views"];?></td>
		<td class="listbg" width="50" align="right"><?=$row["ips"];?></td>
		<td class="listbg"></td>
	</tr>
	<?php } ?>

</table>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["year"]; ?> <?=$sYear;?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="ips.php?year=<?=$sYear;?>"><?=$lang["report_ips"]; ?></a>.<br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?=$lang["year"]; ?> <?=$sYear;?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="graphs.php?type=hour&year=<?=$sYear;?>"><?=$lang["graphs_hour"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=dow&year=<?=$sYear;?>"><?=$lang["graphs_dow"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=dom&year=<?=$sYear;?>"><?=$lang["graphs_dom"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=week&year=<?=$sYear;?>"><?=$lang["graphs_week"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=month&year=<?=$sYear;?>"><?=$lang["graphs_month"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=year&year=<?=$sYear;?>"><?=$lang["graphs_year"]; ?></a>.<br />
</p>

<p class="title"><?=$lang["admin"]; ?></p>
» <?=$lang["view"]; ?> <a href="admin.php"><?=$lang["admin_page"]; ?></a>
<br />
 
 
<?php
	require "views/footer.php";
?>