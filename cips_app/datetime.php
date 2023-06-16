
<?php 


function get_hours_from_date_difference($time_in,$time_out)
{
	// $time_out = strtotime("2019-07-09 10:15");
	// $time_in = strtotime("2019-07-10 14:17");
	$time_out = strtotime($time_out);
	$time_in = strtotime($time_in);

	$diffHours = round((($time_in - $time_out) / 3600),2);
	return $diffHours;
}
?>