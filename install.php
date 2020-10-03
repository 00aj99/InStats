<?php
/*
  InStats
  @yasinkuyu, 2016
*/
?>
<table border="0" width="100%">
	<td class="title">InStats Install</td>
</table>
<hr size="1" color="#8b4513" noshade>

<form method="POST" action="import.php">

<div class="install">
	
	<h5>MySQL/MariaSQL connection info</h5>

	<strong>Server</strong> : <input type="text" name="server" value="localhost" /> <br /><br />
	<strong>Username</strong> : <input type="text" name="username" value="root" /><br /><br />
	<strong>Password</strong> : <input type="text" name="password" value="" /><br /><br /><br /><br />
	
	<strong>Table</strong> : <input type="text" name="table" value="instats" /><br /><br /><br />
	
	<input type="submit" value="install" name="install"><br /><br />
	
</div>

</form>

