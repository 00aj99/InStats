<?php

	/*
		InStats
		@yasinkuyu, 2016
	*/

	require 'config.php';
	require "apps/languages/tr-tr.php";
	require "views/layout.php";
	 
	$sYear = request("year"); 
	$sMonth = request("month"); 

	$data = array(
		'lng' => Flight::get('language'), 
		'lang' => $lang, 
		'sYear' => $sYear, 
		'sMonth' => $sMonth
	);

	$slug = "reports";
    $slug = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  

	if(FORCELOGIN && $_SESSION['IsLogin'] == false && $slug != "login"){
		$data["message"] = "Verileri görebilmek için giriş yapmalısınız";
		Flight::redirect('/login', 301);
	require "apps/insya.php";
	}

	if($slug == "logout"){
		$_SESSION['IsLogin'] = false;
		Flight::redirect('/login.php', 301);
	}
	
	if($slug == "login"){
		
		if(isset($_POST["username"]) && isset($_POST["password"]))
		{
				
			$username = $_POST["username"];
			$password = $_POST["password"];
			
			if($username != "" && $password != ""){
				
				// LEVEL:  3 admin //2 editor //1 viewer //0 ban
				$result = $db->prepare("SELECT Username,Password,Level FROM Users WHERE Username = :username AND Password = :password LIMIT 1");
				$result->bindParam(':username', $username);
				$result->bindParam(':password', $password);
				$result->execute();
				$login = $result->fetch(PDO::FETCH_ASSOC);
				
				if($login){
					
					if($login["Level"] == 0){
						$data["message"] = $lang["login_user_banned"];
					}
					
					if(isset($_POST["Remember"])){
						// Todo remember 
					}
					
					$_SESSION['IsLogin'] = true;
					$_SESSION['Level'] = $login["Level"];
					$_SESSION['Username'] = $login["Username"];
					
					$data["message"] = $lang["login_info_wellcome"] . ' '. $login["Username"] . '<br /><br /><a href="/reports">'. $lang["reports"] .'</a>';
					
					
					
				}else{
					
					$_SESSION['IsLogin'] = false;
					
					$data["message"] = $lang["login_info_incorrect"];
				}
	
			}else{
				$data["message"] = $lang["login_info_not_empaty"];
			}
		}
	}
	
	$sToday = date("Y") . "-" . date("m") . "-" . date("d");
	$dtYesterday =  date('Y-m-d', strtotime(' - 1 days'));
	$sYesterday = $dtYesterday; //date("Y-m-d", $dtYesterday);
	
	//total PageViews
	$sSQL = $db->query("SELECT COUNT(statid) AS total FROM stats")->fetch();
	$lPageViewsTotal = $sSQL["total"];

	$sSQL = $db->query("SELECT COUNT(statid) AS total FROM stats WHERE date = '$sToday'")->fetch();
	$lPageViewsToday = $sSQL["total"];

	$sSQL = $db->query("SELECT COUNT(statid) AS total FROM stats WHERE date = '$sYesterday'")->fetch();
	$lPageViewsYesterday = $sSQL["total"];

	$sSQL = $db->query("SELECT COUNT(ip) AS total FROM stats GROUP BY ip")->fetch();
	$lVisitorsTotal = $sSQL["total"];

	$sSQL = $db->prepare("SELECT COUNT(ip) AS total FROM stats WHERE date = '$sToday' GROUP BY ip");
	$sSQL->execute();
	$lVisitorsToday = $sSQL->rowCount();

	$sSQL = $db->prepare("SELECT COUNT(ip) AS total FROM stats WHERE date = '$sYesterday' GROUP BY ip");
	$sSQL->execute();
	$lVisitorsYesterday = $sSQL->rowCount();

	$sSQL = $db->query("SELECT * FROM toppageviewsperday LIMIT 1")->fetch();
	$lTopViews = $sSQL["total"];
	$data["stopviewsday"]  = $sSQL["date"];

	$sSQL = $db->query("SELECT * FROM topipsperday LIMIT 1")->fetch();
	$lTopVisitors = $sSQL["total"];
	$data["stopvisitorsday"] = $sSQL["date"];
	
	$data["spageviewstoday"] = number_format( $lPageViewsToday, 0);
	$data["spageviewsyesterday"] = number_format( $lPageViewsYesterday, 0);
	$data["spageviewstotal"] = number_format( $lPageViewsTotal, 0);

	$data["svisitorstoday"] = number_format( $lVisitorsToday, 0);
	$data["svisitorsyesterday"] = number_format( $lVisitorsYesterday, 0);
	$data["svisitorstotal"] = number_format( $lVisitorsTotal, 0);

	$data["stopviews"] = number_format( $lTopViews, 0 );
	$data["stopvisitors"] = number_format( $lTopVisitors, 0 );
  
	extract($data, EXTR_SKIP);

?>
 
<hr size="1" color="#C0C0C0" noshade>
<p class="title"><?=$lang['summary'];?></p>
<table border="0" cellspacing="0" class="titlebg summary">
	<tr>
		<td></td>
		<td align="right" class="smallerheader"><?=$lang["page_views"]; ?></td>
		<td align="right" class="smallerheader"><?=$lang["visitors"]; ?></td>
	</tr>
	<tr bgcolor="#fdf5e6">
		<td><a href="reportpathdd.php?year=<?= date("Y"); ?>&month=<?= date("m"); ?>&day=<?= date("d"); ?>"><?=$lang["today"]; ?></a></td>
		<td align="right"><?= $spageviewstoday; ?></td>
		<td align="right"><?= $svisitorstoday; ?></td>
	</tr>
	<tr bgcolor="#fdf5e6">
	<?php
	$date = date('Y-m-d', strtotime("-1 days"));
	$date = date_parse($date);
	?>
		<td><a href="reportpathdd.php?year=<?= $date["year"]; ?>&month=<?= $date["month"]; ?>&day=<?= $date["day"]; ?>"><?=$lang["yesterday"]; ?></a></td>
		<td align="right"><?= $spageviewsyesterday; ?></td>
		<td align="right"><?= $svisitorsyesterday; ?></td>
	</tr>
	<tr bgcolor="#fdf5e6">
		<?php
		$TopViewsDay = date_parse($stopviewsday);
		$TopVisitorsDay = date_parse($stopvisitorsday);
		?>
		<td><?=$lang["top_day"]; ?></td>
		<td align="right"><a href="reportpathdd.php?year=<?= $TopViewsDay["year"]; ?>&month=<?= $TopViewsDay["month"]; ?>&day=<?= $TopViewsDay["day"]; ?>"><?= $stopviews; ?><br />(<?= $stopviewsday; ?>)</a></td>
		<td align="right"><a href="reportpathdd.php?year=<?= $TopVisitorsDay["year"]; ?>&month=<?= $TopVisitorsDay["month"]; ?>&day=<?= $TopVisitorsDay["day"]; ?>"><?= $stopvisitors; ?><br />(<?= $stopvisitorsday; ?>)</a></td>
	</tr>
	<tr>
		<td class="smallerheader"><?=$lang["total"]; ?></td>
		<td align="right"><?= $spageviewstotal; ?></td>
		<td align="right"><?= $svisitorstotal; ?></td>
	</tr>
</table>

<?php require 'calendar.php'; ?>

<p class="title"><?=$lang["detail_stats"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="reportall.php"><?= "Tüm raporlar"; ?></a> <br />
» <?=$lang["view"]; ?> <a href="reportd.php"><?=$lang["detail_reports"]; ?></a> <?=$lang["detail_reports_text"]; ?><br />
» <?=$lang["view"]; ?> <a href="reportpath.php"><?=$lang["page_views_ap"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="reportref.php"><?=$lang["report_ref"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="reportpathy.php"><?=$lang["reportpathy"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="ips.php"><?=$lang["report_ips"]; ?></a><br />
</p>

<p class="title"><?=$lang["graphs"]; ?> (<?=$lang["all_data"]; ?>)</p>
<p class="smallertext">
» <?=$lang["view"]; ?> <a href="graphs.php?type=hour&year=<?=$sYear;?>"><?=$lang["graphs_hour"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=dow&year=<?=$sYear;?>"><?=$lang["graphs_dow"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=dom&year=<?=$sYear;?>"><?=$lang["graphs_dom"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=week&year=<?=$sYear;?>"><?=$lang["graphs_week"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=month&year=<?=$sYear;?>"><?=$lang["graphs_month"]; ?></a><br />
» <?=$lang["view"]; ?> <a href="graphs.php?type=year&year=<?=$sYear;?>"><?=$lang["graphs_year"]; ?></a><br />
</p>

<p class="title"><?=$lang["admin"]; ?></p>
» <?=$lang["view"]; ?> <a href="admin.php"><?=$lang["admin_page"]; ?></a>
<br />

<?php
	require "views/footer.php";
