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
» <a href="reports.php"><?=$lang["reports"];?></a> » <?=$lang["referers"];?>
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
		SELECT Sum(topipsperday.total) AS ips,
			   Sum(toppageviewsperday.total) AS Views,
			   DATE_FORMAT(topipsperday.date, '%Y') AS YearNumber
		FROM topipsperday
		INNER JOIN toppageviewsperday ON topipsperday.date = toppageviewsperday.date
		GROUP BY DATE_FORMAT(topipsperday.date,'%Y')
	");
	 
	foreach ($reportpathy->fetchAll() as $row){?>
		
	<tr>
		<td class="listbg"></td>
		<td class="listbg" width="10"><a href="reportpathm.php?year=<?=$row["YearNumber"]; ?>"><?=$row["YearNumber"]; ?></a></td>
		<td class="listbg" width="50" align="right"><?=$row["Views"]; ?></td>
		<td class="listbg" width="50" align="right"><?=$row["ips"]; ?></td>
		<td class="listbg"></td>
	</tr>

	<?php } ?>
</table>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="ips.php"><?=$lang["report_ips"]; ?></a><br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?=$lang["all_data"]; ?>)</p>
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