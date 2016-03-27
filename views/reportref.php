» <a href="/reports"><?=$lang["reports"];?></a> » <?=$lang["referers"];?>
<br />
<br />

<table id="reportref" cellspacing="1" cellpadding="2" >
	<tr>
		<td class="smallerheader titlebg" width="10">»</td>
		<td class="smallerheader titlebg" colspan="2"><?= $lang["referers"]; ?></td>
		<td class="smallerheader titlebg" width="10"></td>
	</tr>
	<tr>
		<td class="listbg" width="10"></td>
		<?php
			 
		global $db;
		
		$reportref = $db->prepare("SELECT RefName, Total FROM Refs ORDER BY Total DESC");
		$reportref->execute();
		 
		$iFieldCount = 0;
		foreach ( getNames($reportref) as $field ) : 
		
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
			<td class="listbg" width="<?=$iWidth;?>" align="<?=$sAlign;?>" ><?=$name;?></td>
		<?php endforeach; ?>
		<td class="listbg" width="10"></td>
	</tr>
	<?php
	while ($row = $reportref->fetch(PDO::FETCH_ASSOC)) {

		echo '<tr  class="listbg">';
		echo '<td  width="10"></td>';
		
		$iFieldCount = 0;
		for ($i = 0; $i < $reportref->columnCount(); $i++){
			$field = $reportref->getColumnMeta($i)["name"];
	
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
		<td align="<?=$sAlign;?>"><?=$sFieldName;?></td>
		<?php } ?>
		<td width="10"></td>
	</tr>
	<?php } ?>
</table>
	