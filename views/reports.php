
<p class="title"><?=$lang['summary'];?></p>
<table border="0" cellspacing="0" class="titlebg summary">
	<tr>
		<td></td>
		<td align="right" class="smallerheader"><?=$lang["page_views"]; ?></td>
		<td align="right" class="smallerheader"><?=$lang["visitors"]; ?></td>
	</tr>
	<tr bgcolor="#fdf5e6">
		<td><a href="reportpathdd?year=<?= date("Y"); ?>&month=<?= date("m"); ?>&day=<?= date("d"); ?>"><?=$lang["today"]; ?></a></td>
		<td align="right"><?= $sPageViewsToday; ?></td>
		<td align="right"><?= $sVisitorsToday; ?></td>
	</tr>
	<tr bgcolor="#fdf5e6">
	<?php
	$date = date('Y-mm-d', strtotime("-1 days"));
	$date = date_parse($date);
	?>
		<td><a href="reportpathdd?year=<?= $date["year"]; ?>&month=<?= $date["month"]; ?>&day=<?= $date["day"]; ?>"><?=$lang["yesterday"]; ?></a></td>
		<td align="right"><?= $sPageViewsYesterday; ?></td>
		<td align="right"><?= $sVisitorsYesterday; ?></td>
	</tr>
	<tr bgcolor="#fdf5e6">
		<?php
		$TopViewsDay = date_parse($sTopViewsDay);
		$TopVisitorsDay = date_parse($sTopVisitorsDay);
		?>
		<td><?=$lang["top_day"]; ?></td>
		<td align="right"><a href="reportpathdd?year=<?= $TopViewsDay["year"]; ?>&month=<?= $TopViewsDay["month"]; ?>&day=<?= $TopViewsDay["day"]; ?>"><?= $sTopViews; ?><br />(<?= $sTopViewsDay; ?>)</a></td>
		<td align="right"><a href="reportpathdd?year=<?= $TopVisitorsDay["year"]; ?>&month=<?= $TopVisitorsDay["month"]; ?>&day=<?= $TopVisitorsDay["day"]; ?>"><?= $sTopVisitors; ?><br />(<?= $sTopVisitorsDay; ?>)</a></td>
	</tr>
	<tr>
		<td class="smallerheader"><?=$lang["Total"]; ?></td>
		<td align="right"><?= $sPageViewsTotal; ?></td>
		<td align="right"><?= $sVisitorsTotal; ?></td>
	</tr>
</table>

<?php require 'calendar.php'; ?>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_datas"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="reportd"><?=$lang["detail_reports"]; ?></a> <?=$lang["detail_reports_text"]; ?><br />
» <?=$lang["view"]; ?> <a href="reportpath"><?=$lang["page_views_ap"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="reportref"><?=$lang["report_ref"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="reportpathy"><?=$lang["reportpathy"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="ips"><?=$lang["report_ips"]; ?></a><br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?=$lang["all_datas"]; ?>)</p>
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
