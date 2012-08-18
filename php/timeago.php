<?php
// DISPLAYS COMMENT POST TIME AS "1 year, 1 week ago" or "5 minutes, 7 seconds ago", etc...
function time_ago($date,$granularity=1) {
	$retval = "";
    $date = strtotime($date);
    $difference = time() - $date;
    $periods = array('decade' => 315360000,
        'y' => 31536000,
        'mon' => 2628000,
        'w' => 604800, 
        'd' => 86400,
        'h' => 3600,
        'm' => 60,
        's' => 1);
    if ($difference < 30) { // less than 5 seconds ago, let's say "just now"
        $retval = "just now";
        return $retval;
    } else {                            
        foreach ($periods as $key => $value) {
            if ($difference >= $value) {
                $time = floor($difference/$value);
                $difference %= $value;
                $retval .= ($retval ? ' ' : '').$time;
                $retval .= (($time > 1) ? $key : $key);
                $granularity--;
            }
            if ($granularity == '0') { break; }
        }
        return $retval;      
    }
}
?>