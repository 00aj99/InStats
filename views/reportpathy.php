<?php
/*
  InStats
  @yasinkuyu, 2016
*/
?>
<hr size="1" color="#C0C0C0" noshade>
<br />
» <a href="/reports"><?=$lang["reports"];?></a> » <?=$lang["referers"];?>
» <?=$lang["yearly"]; ?>
<br /><br />

<table border="0" cellspacing="1" cellpadding="2" class="titlebg list">
	<tr>
		<td class="titlebg" width="10">»</td>
		<td colspan="3" class="smallerheader titlebg" width="250"><?=$lang["year_stats"];?></td>
		<td class="titlebg" width="10"></td>
	</tr>
	<tr>
		<td class="listbg" width="10"></td>
		<td class="smallerheader listbg" width="80"><?=$lang["year"];?></td>
		<td class="smallerheader listbg" width="90" align="right"><?=$lang["page_views"];?></td>
		<td class="smallerheader listbg" width="90" align="right"><?=$lang["visitors"];?></td>
		<td class="listbg" width="10"></td>
	</tr>
	<?php 
 
	global $db;
 
	$reportpathy = $db->query("
		SELECT Sum(TopIpsPerDay.Total) AS Ips,
			   Sum(TopPageViewsPerDay.Total) AS Views,
			   DATE_FORMAT(TopIpsPerDay.Date, '%Y') AS YearNumber
		FROM TopIpsPerDay
		INNER JOIN TopPageViewsPerDay ON TopIpsPerDay.Date = TopPageViewsPerDay.Date
		GROUP BY DATE_FORMAT(TopIpsPerDay.Date,'%Y')
	");
	 
	foreach ($reportpathy->fetchAll() as $row){?>
		
	<tr>
		<td class="listbg"></td>
		<td class="listbg" width="10"><a href="reportpathm?year=<?=$row["YearNumber"]; ?>"><?=$row["YearNumber"]; ?></a></td>
		<td class="listbg" width="50" align="right"><?=$row["Views"]; ?></td>
		<td class="listbg" width="50" align="right"><?=$row["Ips"]; ?></td>
		<td class="listbg"></td>
	</tr>

	<?php } ?>
</table>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="ips"><?=$lang["report_ips"]; ?></a><br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="/graphs?type=hour&year=<?=$sYear;?>"><?=$lang["graphs_hour"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="/graphs?type=dow&year=<?=$sYear;?>"><?=$lang["graphs_dow"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="/graphs?type=dom&year=<?=$sYear;?>"><?=$lang["graphs_dom"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="/graphs?type=week&year=<?=$sYear;?>"><?=$lang["graphs_week"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="/graphs?type=month&year=<?=$sYear;?>"><?=$lang["graphs_month"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="/graphs?type=year&year=<?=$sYear;?>"><?=$lang["graphs_year"]; ?></a>.<br />
</p>

<p class="title"><?=$lang["admin"]; ?></p>
» <?=$lang["view"]; ?> <a href="admin"><?=$lang["admin_page"]; ?></a>
<br />