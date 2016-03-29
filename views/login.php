<?php
/*
  InStats
  @yasinkuyu, 2016
*/
?>
<table border="0" width="100%">
	<td class="title">InStats <?=$lang["login"];?></td>
</table>
<hr size="1" color="#8b4513" noshade>

<form method="POST" action="/login">

<div class="install">
	
	<?=$lang["login_desc"];?>
	<br /><br />
	
	<strong><?=$lang["username"];?></strong> : <input type="text" name="username" value="" /> <br /><br />
	<strong><?=$lang["password"];?></strong> : <input type="text" name="password" value="" /><br /><br />
	<?=$lang["remember"];?>: <input type="checkbox" name="Remember" value="ON"><br /><br />
	
	<div class="message"><?=isset($message) ? $message : "";?></div>
	
	<input type="submit" value="<?=$lang["login"];?>" name="Login"><br /><br />
	
</div>

</form>

