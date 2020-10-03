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
» <a href="reports.php"><?=$lang["page_views"]; ?></a> 
<br /><br />

<table border="0" cellspacing="0" cellpadding="0" class="titlebg list" width="600">
	<tr>
		<td class="smallerheader titlebg" width="10">»</td>
		<td class="smallerheader titlebg" ><?=$lang["page_views"]; ?></td>
		<td class="smallerheader titlebg" width="10"></td>
	</tr>
	<tr>
		<td class="listbg" width="10"></td>
		<?php
		 
		global $db;
		
		$reportpath = $db->prepare("SELECT pathname, total FROM paths ORDER BY total DESC");
		$reportpath->execute();

		$iFieldCount = 0;
		foreach ( getNames($reportpath) as $field ) : 
		
			$iFieldCount++;
			
			if ($iFieldCount == 1) {
				$iWidth = 400;
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
	<tr>

	<?php
	while ($row = $reportpath->fetch(PDO::FETCH_ASSOC)) {

		echo '<tr class="listbg">';
		echo '<td class="listbg" width="10"></td>';
		
		$iFieldCount = 0;
		for ($i = 0; $i < $reportpath->columnCount(); $i++){
			$field = $reportpath->getColumnMeta($i)["name"];
	
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
	

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="reportd.php"><?=$lang["detail_reports"]; ?></a> <?=$lang["detail_reports_text"]; ?><br />
» <?=$lang["view"]; ?> <a href="reportpath.php"><?=$lang["page_views_ap"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="reportref.php"><?=$lang["report_ref"]; ?></a>.<br />
» <?=$lang["view"]; ?> <a href="reportpathy.php"><?=$lang["reportpathy"]; ?></a>.<br />
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