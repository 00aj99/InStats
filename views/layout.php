<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$lng;?>" lang="<?=$lng;?>" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
	<title>InStats</title>
	<meta charset="UTF-8"> 
	<link rel="stylesheet" type="text/css" href="/assets/instats.css">
</head>
			
<body class="<?=$lng;?>">

<table border="0" width="100%">
	<td class="title">
		<a href="/reports?instats=v1">InStats <?=$lang["reports"]; ?></a>
	</td>

	<td class="smallertext" align="right">
		<a href="https://github.com/yasinkuyu/InStats/issues" target="_blank"><?=$lang["ask_question"]; ?></a> |
		<a href="https://github.com/yasinkuyu/InStats/issues" target="_blank"><?=$lang["error_report"]; ?></a> |
		<a href="https://github.com/yasinkuyu/InStats/issues" target="_blank"><?=$lang["suggest_feature"]; ?></a> |
		<a href="https://github.com/yasinkuyu/InStats/issues" target="_blank"><?=$lang["suggest_site"]; ?></a>
	</td>
</table>
  
<?= isset($body) ? $body : ""; ?>
  
<hr size="1" color="#C0C0C0">
<table border="0" width="100%">
	<tr>
	<td class="smallertext">
	
	</td>
	<td align="center">
	<br />
	Powered by <br />
	<a href="http://insya.com" title="Insya Stats" target="_blank"> <img src="/assets/insyapixel.png" alt="InStats" /> </a> 
	</td>
	</tr>
</table>

</body>
</html>