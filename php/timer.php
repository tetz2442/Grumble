<?php
function convertTimeToLocal($time, $tzuser) {
	date_default_timezone_set('America/Chicago');
	$date = new DateTime($time, new DateTimeZone(date_default_timezone_get()));
	$date->setTimezone(new DateTimeZone($tzuser));
	return $date;
}
?>