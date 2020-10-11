<?php
/*
  InStats
  @yasinkuyu, 2016
*/
 
require 'config.php';
require "apps/languages/tr-tr.php";
require "views/layout.php";
 
//  ( SELECT COUNT(stats.visitorid) FROM stats AS s2 WHERE s2.visitorid = stats.visitorid ) AS visitcount,

$result = $db->query("

			SELECT 
				statid,
				ip,
				date,
				time,
				( SELECT refname FROM refs WHERE stats.refid = refs.refid ) AS refname,
				( SELECT visitorname FROM visitors WHERE stats.visitorid = visitors.visitorid ) AS visitorname,
				( SELECT browsername FROM browsers WHERE stats.browserid = browsers.browserid ) AS browsername,
				( SELECT osname FROM oses WHERE stats.osid = oses.osid ) AS osname,
				( SELECT pathname FROM paths WHERE stats.pathid = paths.pathid ) AS pathname,
				( SELECT keyword FROM keywords WHERE stats.keyid = keywords.keyid ) AS keyword,
				( SELECT colorname FROM colors WHERE stats.colorid = colors.colorid ) AS colorname,
				( SELECT resname FROM resolutions WHERE stats.resid = resolutions.resid ) AS resname,
				( SELECT langname FROM langs WHERE stats.langid = langs.langid ) AS langname,
				( SELECT uagentname FROM uagents WHERE stats.uagentid = uagents.uagentid ) AS uagentname,
				( SELECT statusname FROM statuscodes WHERE stats.statusid = statuscodes.statusid ) AS statusname
			
			FROM stats ORDER BY statid DESC 

		");
	 
?>

<h5>All Reports</h5>
<table border="0" cellspacing="1" cellpadding="2" class="titlebg list">
	<tr>
		<td class="smallerheader titlebg" width="10">»</td>
		<td class="smallerheader titlebg">date</td>
		<td class="smallerheader titlebg">time</td>
		<td class="smallerheader titlebg">pathname</td>
		<td class="smallerheader titlebg">refname</td>
		<td class="smallerheader titlebg">ip</td>
		<td class="smallerheader titlebg">visitorname</td>
		<td class="smallerheader titlebg">browsername</td>
		<td class="smallerheader titlebg">osname</td>
		<td class="smallerheader titlebg">keyword</td>
		<td class="smallerheader titlebg">colorname</td>
		<td class="smallerheader titlebg">resname</td>
		<td class="smallerheader titlebg">langname</td>
		<td class="smallerheader titlebg">statusname</td>
		<td class="smallerheader titlebg">uagentname</td>
	</tr>
	<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
	<tr>
		<td class="listbg" width="10"><?= $row['statid']; ?></td>
		<td class="listbg" width="60"><?= $row['date']; ?></td>
		<td class="listbg"><?= $row['time']; ?></td>
		<td class="listbg"><?= $row['pathname']; ?></td>
		<td class="listbg"><?= $row['refname']; ?></td>
		<td class="listbg"><?= $row['ip']; ?></td>
		<td class="listbg"><?= $row['visitorname']; ?></td>
		<td class="listbg"><?= $row['browsername']; ?></td>
		<td class="listbg"><?= $row['osname']; ?></td>
		<td class="listbg"><?= $row['keyword']; ?></td>
		<td class="listbg"><?= $row['colorname']; ?></td>
		<td class="listbg"><?= $row['resname']; ?></td>
		<td class="listbg"><?= $row['langname']; ?></td>
		<td class="listbg"><?= $row['statusname']; ?></td>
		<td class="listbg"><?= $row['uagentname']; ?></td>
	</tr>
	<?php endwhile; ?>
</table>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="reportd.php"><?=$lang["detail_reports"]; ?></a> <?=$lang["detail_reports_text"]; ?><br />
» <?=$lang["view"]; ?> <a href="reportpath.php"><?=$lang["page_views_ap"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="reportref.php"><?=$lang["report_ref"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="reportpathy.php"><?=$lang["reportpathy"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="ips.php"><?=$lang["report_ips"]; ?></a><br />
</p>


<p class="title"><?=$lang["graphs"]; ?>  (<?=$lang["all_data"]; ?>)</p>
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