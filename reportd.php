<?php
/*
  InStats
  @yasinkuyu, 2016
*/
 
require 'config.php';
require "apps/languages/tr-tr.php";
require "views/layout.php";
 
function SQLTable($sTitle, $sSQL, $lang)
{
	global $db;
	$result = $db->query($sSQL);
	 
?>
		<table border="0" cellspacing="1" cellpadding="2" class="titlebg list" width="600">
			<tr>
				<td class="smallerheader titlebg" width="10">»</td>
				<td class="smallerheader titlebg" ><?=$sTitle?></td>
				<td class="smallheader" class="titlebg" width="10"></td>
			</tr>
			<tr>
				<td class="listbg" width="10"></td>
				<?php
				$iFieldCount = 0;
				foreach ( getNames($result) as $field ) { 
				
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
				<?php } ?>
				<td class="listbg" width="10"></td>
			<tr>
			
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
	SQLTable($lang["top_ten_page"], "SELECT pathname, total FROM paths ORDER BY total DESC LIMIT 10", $lang);
	SQLTable($lang["top_ten_ref"], "SELECT refname, total FROM refs ORDER BY total DESC LIMIT 10", $lang);
	SQLTable($lang["browsers"], "SELECT browsername, total FROM browsers ORDER BY total DESC", $lang);
	SQLTable($lang["resolutions"], "SELECT resname, total FROM resolutions ORDER BY total DESC", $lang);
	SQLTable($lang["colors"], "SELECT colorname, total FROM colors ORDER BY total DESC", $lang);
	SQLTable($lang["oses"], "SELECT osname, total FROM oses ORDER BY total DESC", $lang);
	SQLTable($lang["uagents"], "SELECT uagentname, total FROM uagents ORDER BY total DESC", $lang);
	SQLTable($lang["keywords"], "SELECT keyword, total FROM keywords ORDER BY total DESC", $lang);
?>

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