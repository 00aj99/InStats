<?php

  $mMonth = request("month");
  $yYear =  request("year");
  
  if ($mMonth === "" ) $mMonth = date("n"); // date("m") : 01, date("n") : 1
  if ($yYear === "" ) $yYear = date("Y"); 

function DisplayCalendar($month,$year, $lang){
 
	$bgColor = '#ffe4b5';

	$calendar = '<br />';
	$calendar.= '<table cellPadding="3" cellSpacing="0" border="0" class="callendar">';
	$calendar.= '<tr valign="top" align="center" bgColor="'. $bgColor .'">';
	
	$weekdays = $lang["weekdays"];

	foreach(explode(",", $weekdays) as $day) {
		$calendar.= '<td width="15%"><span class="smallertext"><b>'. $day .'</b></span></td>';
	}
	
	echo '</tr>';

	$running_day = date('w',mktime(0,0,0,$month,0,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	$calendar.= '<tr>';

	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td> </td>';
		$days_in_this_week++;
	endfor;

	for($current_day = 1; $current_day <= $days_in_month; $current_day++):
	
		$CellStr = '&nbsp;';
		$CellColor = '#fdf5e6';
		
		if ($current_day == date("d")) $CellColor="Yellow"; 
		
		$CellStr = '<span class="smallertext datetable"><a href="reportpathdd.php?year=' . $year . '&month=' . $month . '&day=' . $current_day . '">' . $current_day . '</a></span>';
			
		$calendar.= '<td bgColor="'. $CellColor .'">'. $CellStr .'</td>';
		
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr>';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		
		$days_in_this_week++; $running_day++; $day_counter++;
		
	endfor;

	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td> </td>';
		endfor;
	endif;

	$calendar.= '</tr>';
	$calendar.= '</table>';
	
	return $calendar;
}


echo DisplayCalendar($mMonth,$yYear, $lang);
	 DisplaySelectDate($lang);

function DisplaySelectDate($lang){
	echo '<br /><form method="get">';
	MonthCombo($lang);
	YearCombo();
	echo '<input type="submit" value="'. $lang["go"] .'">';
	echo '</form>';
}

function MonthCombo($lang){
	
  global $mMonth;

  $months = $lang["months"];
  $months = explode(",", $months);
  
  echo '<select name="month">';
  
  if ($mMonth === "" ) $mMonth = date("n");

  for($i=0; $i < 12; $i++) {
	
	$num = ($i+1);
	$selected = $mMonth == $num ? 'selected="selected"' : '';

	echo '<option '. $selected .' value='. $num .'>'. $months[$i] .'</option>';
	
  }
  echo '</select>';
}

function YearCombo(){ 

  global $mYear;
  
  echo '<select name="year">';
  if ($mYear == "" ) $mYear = date("Y");

  for( $i = 2016 ; $i <= 2071; $i++ ) {

	$selected = ($mYear == $i ? 'selected="selected"' : '');
    echo  '<option '. $selected .' value="'. $i .'">'. $i .'</option>';
	
  }
  echo '</select>';
}
