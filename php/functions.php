<?php
//user is logged in and timezone is set
function convertToTimeZone($time, $tz) {
	$newtime = new DateTime($time . " UTC");
	$newtime->setTimezone(new DateTimeZone($tz));
	return date_format($newtime, "M d, Y g:iA");
}

//user is not logged in and offset was grabbed
function convertToUserTime($time, $offset) {
	$newtime = new DateTime($time . " " . $offset);
	return date_format($newtime, "M d, Y g:iA");
}

//get gravatar
function getGravatar($email, $size = 45) {
	$default = "http://" . $_SERVER["HTTP_HOST"] . "/images/default.png";
	
	return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
}

//set timezone
function setTimezone() {
	if (isset($_SESSION["timezone"])) {
		date_default_timezone_set($_SESSION["timezone"]);
	}
	else if (isset($_SESSION["time"])) {
		date_default_timezone_set($_SESSION["time"]);
	}
	else {
		date_default_timezone_set("America/Chicago");
	}
}

//returns the date as the time ago (1m, 1w, etc)
function time_ago($date,$granularity=1) {
	$retval = "";
    $date = strtotime($date);
    $difference = time() - $date;
    $periods = array('dec' => 315360000,
        'y' => 31536000,
        'mon' => 2628000,
        'w' => 604800, 
        'd' => 86400,
        'h' => 3600,
        'm' => 60,
        's' => 1);
    if ($difference <= 59) { // less than 5 seconds ago, let's say "just now"
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

/* takes the input, scrubs bad characters */
function generate_seo_link($input,$replace = '-',$remove_words = true,$words_array = array())
{
	//make it lowercase, remove punctuation, remove multiple/leading/ending spaces
	$return = trim(preg_replace('/[^a-zA-Z0-9\s]/','',strtolower($input)));

	//remove words, if not helpful to seo
	//i like my defaults list in remove_words(), so I wont pass that array
	if($remove_words) { $return = remove_words($return,$replace,$words_array); }

	//convert the spaces to whatever the user wants
	//usually a dash or underscore..
	//...then return the value.
	return str_replace(' ',$replace,$return);
}

/* takes an input, scrubs unnecessary words */
function remove_words($input,$replace,$words_array = array(),$unique_words = true)
{
	//separate all words based on spaces
	$input_array = explode(' ',$input);

	//create the return array
	$return = array();

	//loops through words, remove bad words, keep good ones
	foreach($input_array as $word)
	{
		//if it's a word we should add...
		if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
		{
			$return[] = $word;
		}
	}

	//return good words separated by dashes
	return implode($replace,$return);
}

//clean input
function escape($input) {
	return mysql_real_escape_string($input);
}

//clean input and strip html
function escapeAndStrip($input) {
	return mysql_real_escape_string(strip_tags($input));
}

//strip tags
function strip($input) {
	return strip_tags($input);
}

//replace spaces
function replaceSpaces($input) {
	return str_replace(" ", "", $input);
}

//remove newline characters
function removeNewLine($input) {
	$output = str_replace("\r", "", $input);
	$output = str_replace("\n", "", $output);
	
	return $output;
}

//email function
function sendEmail($email, $sendfrom, $type, $parameters) {
	if($type == "reply") {
		$subject = "[Reply] to your Grumble!";
		$body = "A new reply has been placed on your Grumble by " . $parameters[2] . "!\n\n" . 
		"'" . $parameters[3] . "'\n\nClick the URL or paste it in your browser to view the reply.\n" . $parameters[0] . "\n\nThe Grumble Team\n\n"
		. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[1] . "#settings\n"
		. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
		mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "grumble") {
		//if the grumble number is divisible by 15, send an email
		if((intval($parameters[0]) % 15 == 0)) {
			$subject = "[Grumble] your Grumble has reached " . $parameters[0]. " Comments!";
			$body = "Your Grumble is growing in popularity! Come check out the new comments on your Grumble.\n\n" . 
			"Click the URL or paste it in your browser to view.\n" . $parameters[1] 
			. "\n\nThe Grumble Team\n\n"
			. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[2] . "#settings\n"
			. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
			mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
		}
	}
	else if($type == "verify") {
		$subject = "[Grumble] Verify email";
		$body = "Thanks for signing up for Grumble!\n\n" .
		"To verify this email please follow the link below by pasting it in your browser or clicking on it.\n\n" . 
		$parameters[0] . "\n\nThe Grumble Team";
		mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "admin") {
		$subject = $parameters[0];
		$body = stripslashes($parameters[1]);
		mail($email, $subject, $body, $sendfrom) or die("Could not send email.");
	}
}

//check if timezone exists
function checkTimeZone($tz) {
	// create an array listing the time zones
	$zonelist = array('Kwajalein' => '(GMT-12:00) International Date Line West',
			'Pacific/Midway' => '(GMT-11:00) Midway Island',
			'Pacific/Samoa' => '(GMT-11:00) Samoa',
			'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
			'America/Anchorage' => '(GMT-09:00) Alaska',
			'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
			'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
			'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
			'America/Chihuahua' => '(GMT-07:00) Chihuahua',
			'America/Mazatlan' => '(GMT-07:00) Mazatlan',
			'America/Phoenix' => '(GMT-07:00) Arizona',
			'America/Regina' => '(GMT-06:00) Saskatchewan',
			'America/Tegucigalpa' => '(GMT-06:00) Central America',
			'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
			'America/Mexico_City' => '(GMT-06:00) Mexico City',
			'America/Monterrey' => '(GMT-06:00) Monterrey',
			'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
			'America/Bogota' => '(GMT-05:00) Bogota',
			'America/Lima' => '(GMT-05:00) Lima',
			'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
			'America/Indiana/Indianapolis' => '(GMT-05:00) Indiana (East)',
			'America/Caracas' => '(GMT-04:30) Caracas',
			'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
			'America/Manaus' => '(GMT-04:00) Manaus',
			'America/Santiago' => '(GMT-04:00) Santiago',
			'America/La_Paz' => '(GMT-04:00) La Paz',
			'America/St_Johns' => '(GMT-03:30) Newfoundland',
			'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
			'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
			'America/Godthab' => '(GMT-03:00) Greenland',
			'America/Montevideo' => '(GMT-03:00) Montevideo',
			'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
			'Atlantic/Azores' => '(GMT-01:00) Azores',
			'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
			'Europe/Dublin' => '(GMT) Dublin',
			'Europe/Lisbon' => '(GMT) Lisbon',
			'Europe/London' => '(GMT) London',
			'Africa/Monrovia' => '(GMT) Monrovia',
			'Atlantic/Reykjavik' => '(GMT) Reykjavik',
			'Africa/Casablanca' => '(GMT) Casablanca',
			'Europe/Belgrade' => '(GMT+01:00) Belgrade',
			'Europe/Bratislava' => '(GMT+01:00) Bratislava',
			'Europe/Budapest' => '(GMT+01:00) Budapest',
			'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
			'Europe/Prague' => '(GMT+01:00) Prague',
			'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
			'Europe/Skopje' => '(GMT+01:00) Skopje',
			'Europe/Warsaw' => '(GMT+01:00) Warsaw',
			'Europe/Zagreb' => '(GMT+01:00) Zagreb',
			'Europe/Brussels' => '(GMT+01:00) Brussels',
			'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
			'Europe/Madrid' => '(GMT+01:00) Madrid',
			'Europe/Paris' => '(GMT+01:00) Paris',
			'Africa/Algiers' => '(GMT+01:00) West Central Africa',
			'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
			'Europe/Berlin' => '(GMT+01:00) Berlin',
			'Europe/Rome' => '(GMT+01:00) Rome',
			'Europe/Stockholm' => '(GMT+01:00) Stockholm',
			'Europe/Vienna' => '(GMT+01:00) Vienna',
			'Europe/Minsk' => '(GMT+02:00) Minsk',
			'Africa/Cairo' => '(GMT+02:00) Cairo',
			'Europe/Helsinki' => '(GMT+02:00) Helsinki',
			'Europe/Riga' => '(GMT+02:00) Riga',
			'Europe/Sofia' => '(GMT+02:00) Sofia',
			'Europe/Tallinn' => '(GMT+02:00) Tallinn',
			'Europe/Vilnius' => '(GMT+02:00) Vilnius',
			'Europe/Athens' => '(GMT+02:00) Athens',
			'Europe/Bucharest' => '(GMT+02:00) Bucharest',
			'Europe/Istanbul' => '(GMT+02:00) Istanbul',
			'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
			'Asia/Amman' => '(GMT+02:00) Amman',
			'Asia/Beirut' => '(GMT+02:00) Beirut',
			'Africa/Windhoek' => '(GMT+02:00) Windhoek',
			'Africa/Harare' => '(GMT+02:00) Harare',
			'Asia/Kuwait' => '(GMT+03:00) Kuwait',
			'Asia/Riyadh' => '(GMT+03:00) Riyadh',
			'Asia/Baghdad' => '(GMT+03:00) Baghdad',
			'Africa/Nairobi' => '(GMT+03:00) Nairobi',
			'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
			'Europe/Moscow' => '(GMT+03:00) Moscow',
			'Europe/Volgograd' => '(GMT+03:00) Volgograd',
			'Asia/Tehran' => '(GMT+03:30) Tehran',
			'Asia/Muscat' => '(GMT+04:00) Muscat',
			'Asia/Baku' => '(GMT+04:00) Baku',
			'Asia/Yerevan' => '(GMT+04:00) Yerevan',
			'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
			'Asia/Karachi' => '(GMT+05:00) Karachi',
			'Asia/Tashkent' => '(GMT+05:00) Tashkent',
			'Asia/Kolkata' => '(GMT+05:30) Calcutta',
			'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
			'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
			'Asia/Dhaka' => '(GMT+06:00) Dhaka',
			'Asia/Almaty' => '(GMT+06:00) Almaty',
			'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
			'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
			'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
			'Asia/Bangkok' => '(GMT+07:00) Bangkok',
			'Asia/Jakarta' => '(GMT+07:00) Jakarta',
			'Asia/Brunei' => '(GMT+08:00) Beijing',
			'Asia/Chongqing' => '(GMT+08:00) Chongqing',
			'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
			'Asia/Urumqi' => '(GMT+08:00) Urumqi',
			'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
			'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
			'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
			'Asia/Singapore' => '(GMT+08:00) Singapore',
			'Asia/Taipei' => '(GMT+08:00) Taipei',
			'Australia/Perth' => '(GMT+08:00) Perth',
			'Asia/Seoul' => '(GMT+09:00) Seoul',
			'Asia/Tokyo' => '(GMT+09:00) Tokyo',
			'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
			'Australia/Darwin' => '(GMT+09:30) Darwin',
			'Australia/Adelaide' => '(GMT+09:30) Adelaide',
			'Australia/Canberra' => '(GMT+10:00) Canberra',
			'Australia/Melbourne' => '(GMT+10:00) Melbourne',
			'Australia/Sydney' => '(GMT+10:00) Sydney',
			'Australia/Brisbane' => '(GMT+10:00) Brisbane',
			'Australia/Hobart' => '(GMT+10:00) Hobart',
			'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
			'Pacific/Guam' => '(GMT+10:00) Guam',
			'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
			'Asia/Magadan' => '(GMT+11:00) Magadan',
			'Pacific/Fiji' => '(GMT+12:00) Fiji',
			'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
			'Pacific/Auckland' => '(GMT+12:00) Auckland',
			'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa');
	$zone = false;
	foreach($zonelist as $key => $value) {
        if($key == $tz) {
        	$zone = true;
        	break;
        }
        $zone = false;
    }

    return $zone;
}
?>