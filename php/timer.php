<?php
function convertTimeToLocal($time, $tzuser) {
	// timestamp to convert (just an example)
	$timestamp = $time;
	 
	// set this to the time zone provided by the user
	$tz = $tzuser;
	 
	// create the DateTimeZone object for later
	$dtzone = new DateTimeZone($tz);
	 
	// first convert the timestamp into a string representing the local time
	$time = date('r', $timestamp);
	 
	// now create the DateTime object for this time
	$dtime = new DateTime($time);
	 
	// convert this to the user's timezone using the DateTimeZone object
	$dtime->setTimeZone($dtzone);
	 
	// print the time using your preferred format
	$time = $dtime->format('g:i A m/d/y');
	
	return $time;
}
?>