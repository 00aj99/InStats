<?php
/*
  InStats
  @yasinkuyu, 2016
*/
require 'config.php';
require "apps/languages/tr-tr.php";
require "views/layout.php";
 
if (request("method") == "change") :

	$force_login = isset($_POST["forcelogin"]) ? 1 : 0;
	
	$strSql = "UPDATE config "; 
	$strSql .= "SET C_IMAGELOC = '" . request('ImageLocation') . "'"; 
	$strSql .= ",   c_filterip = '" . request('FilterIPs') . "'";
	$strSql .= ",   c_showlinks = " . request('ShowLinks'); 
	$strSql .= ",   c_refthisserver = " . request('CountServer') ;
	$strSql .= ",   c_strippathparameters = " . request('PathParameters');
	$strSql .= ",   c_strippathprotocol = " . request('PathProtocol');
	$strSql .= ",   c_striprefparameters = " . request('RefParameters');
	$strSql .= ",   c_striprefprotocol = " . request('RefProtocol');
	$strSql .= ",   c_stripreffile = " . request('RefFile');
	$strSql .= ",   forcelogin = " . $force_login;
	$strSql .= ",   language = '" . request('language') ."'";
	$strSql .= " WHERE ID = 1";
	
	global $db;

	if(isset($_POST['ClearStats']))
	{
		$db->query("DELETE FROM browsers");  
		$db->query("DELETE FROM colors");  
		$db->query("DELETE FROM oses");  
		$db->query("DELETE FROM paths");  
		$db->query("DELETE FROM refs");  
		$db->query("DELETE FROM resolutions");  
		$db->query("DELETE FROM stats");  
		$db->query("DELETE FROM keywords");  
		$db->query("DELETE FROM uagents");  
		$db->query("DELETE FROM visitors");  
		
		echo '<script type="text/javascript">alert("'. $lang["clear_data_success"]. '"); </script>';
	}

	$result = $db->query($strSql);

?>


<h1 class="title"><?=$lang["admin"];?>:</h1>

<table border="1" cellspacing="1" class="titlebg" width="800">
	<tr>
		<td align="middle" class="smallerheader" colspan="3"><?=$lang["update_successfully"]; ?></td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader">
		<?=$lang["update_settings"]; ?>
		</td>
		<td align="middle" class="smallerheader"><a href="reports.php"><?=$lang["return_reports"]; ?></a></td>
		<td align="middle" class="smallerheader"><a href="admin.php"><?=$lang["return_admin"]; ?></a></td>
	</tr>
</table>
</body>
</html>

<?php else : ?>

<hr size="1" color="#C0C0C0" noshade>
<br />
<p class="title"><?=$lang["admin"];?>:</p>

<form action="admin.php" method="post">
  <table border="1" cellspacing="1" class="titlebg" width="800">
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["feature"]; ?></td>
		<td align="middle" class="smallerheader"><?=$lang["setting"]; ?></td>
		<td align="middle" class="smallerheader"><?=$lang["desc"]; ?></td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["image_location"]; ?></td>
		<td align="middle" class="smallerheader"> 
			<input type="text" name="ImageLocation" size="25" value="<?=SIMAGELOCATION ?>">
		</td>
		<td align="left" class="smallerheader">
		<?=$lang["image_location_desc"]; ?>
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["filter_ips"]; ?></td>
		<td align="middle" class="smallerheader">
		<input type="text" name="FilterIPs" size="25" value="<?=SFILTERIPS ?>"> 
		</td>
		<td align="left" class="smallerheader">
		<?=$lang["filter_ips_desc"]; ?>
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["show_links"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["on"]; ?>: <input type="radio" class="radio" name="ShowLinks" value="1" <?=(BSHOWLINKS == "1") ? "checked" : ""; ?> /> 
		<?=$lang["off"]; ?>: <input type="radio" class="radio" name="ShowLinks" value="0" <?=(BSHOWLINKS == "0") ? "checked" : ""; ?> />
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["show_links_desc"]; ?>

		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["count_own_server"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["on"]; ?>: <input type="radio" class="radio" name="CountServer" value="1" <?=(BREFTHISSERVER == "1") ? "checked" : ""; ?>> 
		<?=$lang["off"]; ?>: <input type="radio" class="radio" name="CountServer" value="0" <?=(BREFTHISSERVER == "0") ? "checked" : ""; ?>>
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["count_own_server_desc"]; ?>

		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["strip_params"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["on"]; ?>: <input type="radio" class="radio" name="PathParameters" value="1" <?=(BSTRIPPATHPARAMETERS == "1") ? "checked" : ""; ?>> 
		<?=$lang["off"]; ?>: <input type="radio" class="radio" name="PathParameters" value="0" <?=(BSTRIPPATHPARAMETERS == "0") ? "checked" : ""; ?>>
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["strip_params_desc"]; ?>
		
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["strip_protocol"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["on"]; ?>: <input type="radio" class="radio" name="PathProtocol" value="1" <?=(BSTRIPPATHPROTOCOL == "1") ? "checked" : ""; ?>> 
		<?=$lang["off"]; ?>: <input type="radio" class="radio" name="PathProtocol" value="0" <?=(BSTRIPPATHPROTOCOL == "0") ? "checked" : ""; ?>>
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["strip_protocol_desc"]; ?>
		
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["strip_ref_params"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["on"]; ?>: <input type="radio" class="radio" name="RefParameters" value="1" <?=(BSTRIPREFPARAMETERS == "1") ? "checked" : ""; ?>> 
		<?=$lang["off"]; ?>: <input type="radio" class="radio" name="RefParameters" value="0" <?=(BSTRIPREFPARAMETERS == "0") ? "checked" : ""; ?>>
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["strip_ref_params_desc"]; ?>
		
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["strip_ref_protocol"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["on"]; ?>: <input type="radio" class="radio" name="RefProtocol" value="1" <?=(BSTRIPREFPROTOCOL == "1") ? "checked" : ""; ?>> 
		<?=$lang["off"]; ?>: <input type="radio" class="radio" name="RefProtocol" value="0" <?=(BSTRIPREFPROTOCOL == "0") ? "checked" : ""; ?>>
    	</td>
		<td align="left" class="smallerheader">
		<?=$lang["strip_ref_protocol_desc"]; ?>		
		
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["ref_file"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["on"]; ?>: <input type="radio" class="radio" name="RefFile" value="1" <?=(BSTRIPREFFILE == "1") ? "checked" : ""; ?>> 
		<?=$lang["off"]; ?>: <input type="radio" class="radio" name="RefFile" value="0" <?=(BSTRIPREFFILE == "0") ? "checked" : ""; ?>>
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["ref_file_desc"]; ?>
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["language"]; ?></td>
		<td align="middle" class="smallerheader">
		
		<select name="language">
		<?php foreach(getLanguages() as $slug => $lng) { ?>	
			<option value="<?=$slug;?>" <?=(LANGUAGE == $slug) ? "selected" : ""; ?>><?=$lng;?></option>
		<?php }	?>
 
		</select>
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["language_desc"]; ?> 
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader">-</td>
		<td align="middle" class="smallerheader"> 
    	</td>
		<td align="left" class="smallerheader">	
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["clear_data"]; ?></td>
		<td align="middle" class="smallerheader">
		<?=$lang["clear_data_msg"]; ?>: <input type="checkbox" class="checkbox" name="ClearStats" /> 
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["clear_data_desc"]; ?> 
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader"><?=$lang["force_login"]; ?></td>
		<td align="middle" class="smallerheader">
		<input type="checkbox" class="checkbox" name="forcelogin" <?=FORCELOGIN ? "checked" : ""; ?>/> 
    	</td>
		<td align="left" class="smallerheader">	
		<?=$lang["force_login_desc"]; ?> 
		</td>
	</tr>
	<tr>
		<td align="middle" class="smallerheader" colspan="3">
			<br />
			<input type="hidden" value="change" name="method" id="hidden">
			<input type="submit" value="<?=$lang["save"]; ?>" id="submit" name="submit"> 
			<button type="button" onclick="location.href='/reports.php'"><?=$lang["back"]; ?></button>
			<br />
		<td>
	</tr>

</form>
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

<?php endif; ?>
