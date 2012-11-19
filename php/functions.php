<?php
/***
 * utility functions for grumble
 */
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
    if ($difference <= 59) { // less than 59 seconds ago, let's say "just now"
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

//check if username is allowed
function checkUsername($input) {
	$unallowed_username = array('slut','bitch','whore','fuck','motherfucker','cunt','asshole','damn','poop','shit','admin','moderator','ass','fucker');
	foreach ($unallowed_username as $value) {
		if(strpos($input, $value) !== false)
			return false;
	}
	return true;
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

//get title for page
function getTitle($pagename) {
	global $conn;
	//dynamically change title
	if(isset($_GET["subcat"])) {
		$sql = "SELECT sub_category_name, sub_category_description FROM sub_category_grumble " .
			"WHERE sub_category_id = " . mysql_real_escape_string($_GET["subcat"]);
		$result = mysql_query($sql, $conn) or die("Could not look up information: " . mysql_error());
		$row = mysql_fetch_array($result);
		echo " " . stripslashes($row["sub_category_name"]);
	}
	else if(isset($_GET["cat"])) {
		$category = strtolower(mysql_real_escape_string($_GET["cat"]));
		$sql = "SELECT category_name FROM categories_grumble " .
			"WHERE category_url = '" . $category . "'";
		$result = mysql_query($sql, $conn) or die("Could not look up information: " . mysql_error());
		$row = mysql_fetch_array($result);
		echo " " . stripslashes($row["category_name"]);
	}
	else if(isset($_GET["s"]) && isset($_GET["user"])) { //statusview
		echo " " . strip_tags($_GET["user"]);
	}
	else if(isset($_GET["id"])) { //profile
		echo " " . strip_tags($_GET["id"]);
	}
	else if($pagename == "create-account.php") {
		echo " Create Account";
	}
	else if($pagename == "about.php") {
		echo " About";
	}
	else if($pagename == "privacy.php") {
		echo " Privacy Policy";
	}
	else if($pagename == "terms-of-service.php") {
		echo " Terms of Service";
	}
	else if($pagename == "login.php") {
		echo " Login";
	}
	else if($pagename == "contact.php") {
		echo " Contact Us";
	}
	else if($pagename == "how-it-works.php") {
		echo " How it works";
	}
	else if($pagename == "noscript.php") {
		echo " JavaScript not enabled";
	}
	else if($pagename == "updates.php") {
		echo " Updates";
	}
	else if($pagename == "forgot-password.php") {
		echo " Forgot Password";
	}
	else {
		echo " Grumble for you. Grumble for change.";	
	}
}

//get descriptions for page 
function getDescription($pagename) {
	global $conn;
	if(isset($_GET["subcat"])) {
		$sql = "SELECT sub_category_name, sub_category_description FROM sub_category_grumble " .
			"WHERE sub_category_id = " . mysql_real_escape_string($_GET["subcat"]);
		$result = mysql_query($sql, $conn) or die("Could not look up information: " . mysql_error());
		$row = mysql_fetch_array($result);
		$length = strlen($row["sub_category_description"]);
		if($length > 50 && $length < 250)
			echo stripslashes($row["sub_category_description"]);
		else if(strlen($row["sub_category_description"]) > 50) {
			echo stripslashes(substr($row["sub_category_description"], 0, 250)) . "...";
		}
		else
			echo stripslashes($row["sub_category_description"]) . " | Grumble is a place where you can discuss the topics that you feel are important and need attention. It's simple. Grumble for you. Grumble for change.";
	}
	else if(isset($_GET["cat"])) {
		$category = strtolower(mysql_real_escape_string($_GET["cat"]));
		$sql = "SELECT category_name FROM categories_grumble " .
			"WHERE category_url = '" . $category . "'";
		$result = mysql_query($sql, $conn) or die("Could not look up information: " . mysql_error());
		$row = mysql_fetch_array($result);
		$catname = stripslashes($row["category_name"]);
		echo $catname . " is a category on Grumble. Categories are full of Grumbles that relate to that specific category. Place a Grumble into the category that you feel relates best.";
	}
	else if($pagename == "create-account.php") {
		echo "Create Account an account on Grumble to access its many features. Join today and inspire an action for change or simply get something off of your chest. ";
	}
	else if($pagename == "privacy.php") {
		echo "What you say on Grumble will be accessible by anyone with an Internet connection. Read more of this document to find out more.";
	}
	else if($pagename == "terms-of-service.php") {
		echo "Terms of Service.  These Terms of Service explain how Grumble works. Read more of this document for more information.";
	}
	else if($pagename == "login.php") {
		echo "Login in to Grumble with your user account. ";
	}
	else if($pagename == "contact.php") {
		echo "Contact Grumble. Use this page to suggest a feature, report a bug, or just send us a message. We will get back to you as soon as possible.";
	}
	else if($pagename == "noscript.php") {
		echo "You must enable your JavaScript to be able to have the best viewing experience on Grumble.";
	}
	else if($pagename == "updates.php"){
		echo "Come here for updates on new things happening at Grumble. Grumble is a place where you can discuss the topics that you feel are important and need attention.";
	}
	else if($pagename == "about.php") {
		echo "Find out a little more about Grumble on our about page. Grumble is a place where you can discuss the topics that you feel are important and need attention.";
	}
	else if($pagename == "forgot-password.php") {
		echo "Have you forgetten your password on Grumble? On this page you can reset your password through email. Simply enter it into the provided field.";
	}
	else if(isset($_GET["s"]) && isset($_GET["user"])) { //statusview
		$id = mysql_real_escape_string($_GET["s"]);
		$sql = "SELECT sg.status_text FROM status_grumble AS sg " .
			"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sg.user_id " .
			"WHERE sg.status_id = " . $id;
		$result = mysql_query($sql, $conn) or die("Could not look up information: " . mysql_error());
		$row = mysql_fetch_array($result);
		$length = strlen(stripslashes($row["status_text"]));
		if($length < 250)
			echo strip_tags($_GET["user"]) . "'s comment, '" . stripslashes($row["status_text"]) . "'";
		else {
			echo strip_tags($_GET["user"]) . "'s comment, '" . stripslashes(substr($row["status_text"], 0, 250)) . "...'";
		}
	}
	else if(isset($_GET["id"])) { //profile
		echo strip_tags($_GET["id"]) . ". This is the profile of " . strip_tags($_GET["id"]) . " on Grumble. To create a profile on Grumble go to the create account page.";
	}
	else {
		echo "Grumble is a place where you can discuss the topics that you feel are important and need attention. It's simple. Grumble for you. Grumble for change.";
	}
}

//email function
function sendEmail($email, $sendfrom, $type, $parameters) {
	require_once "Mail.php"; 
	$send = false;
	$subject ="";
	$body ="";
	if($type == "reply") {
		$subject = "[Reply] to your Grumble!";
		$body = "A new reply has been placed on your Grumble by " . $parameters[2] . "!\n\n" . 
		"'" . $parameters[3] . "'\n\nClick the URL or paste it in your browser to view the reply.\n" . $parameters[0] . "\n\nThe Grumble Team\n\n"
		. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[1] . "#settings\n"
		. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
		$send = true;
		//mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "grumble") {
		$subject = "[Grumble] your Grumble has reached " . $parameters[0]. " Comments!";
		$body = "Your Grumble is growing in popularity! Come check out the new comments on your Grumble.\n\n" . 
		"Click the URL or paste it in your browser to view.\n" . $parameters[1] 
		. "\n\nThe Grumble Team\n\n"
		. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[2] . "#settings\n"
		. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
		$send = true;
		//mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "verify") {
		$subject = "[Grumble] Verify email";
		$body = "Thanks for signing up for Grumble!\n\n" .
		"To verify this email please follow the link below by pasting it in your browser or clicking on it.\n\n" . 
		$parameters[0] . "\n\nThe Grumble Team";
		$send = true;
		//mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "resetpassword") {
		$subject = "[Grumble] password change";
		$body = "Change your password by following the link below.\n\nClick the link or paste it in your browser to reset your password:\n\n" . 
		$parameters[0];
		$send = true;
		//mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "admin") {
		$subject = $parameters[0];
		$body = stripslashes($parameters[1]);
		$send = true;
		//mail($email, $subject, $body, $sendfrom) or die("Could not send email.");
	}
	else if($type == "admincontact") {
		$subject = "[Grumble] Contact";
		$body = "A new contact message has been filled out by a user. Please check as soon as possible.";
		$send = true;
	}
	
	if($send) {
		$from = "Grumble <" . $sendfrom . ">"; 
		$to = "Grumbler <" . $email . ">"; 
		$host = $_SERVER["HTTP_HOST"]; 
		$username = "grumble1"; 
		$password = "Clayweb2442!!"; 
		$headers = array ('From' => $from, 
		'To' => $to, 
		'Subject' => $subject); 
		$smtp = Mail::factory('smtp', 
		array ('host' => $host, 
		'auth' => true, 
		'username' => $username, 
		'password' => $password)); 
		$mail = $smtp->send($to, $headers, $body); 
	}
}

//check for a cookie and if it is valid
function checkCookie() {
	global $conn;
	//if cookie is set, set session variables
	if(isset($_COOKIE["user_grumble"]) && isset($_COOKIE["cookie_id"]) && !isset($_SESSION["user_id"])) {
		require_once "conn.php";
		$sql = "SELECT cg.cookie_id, ug.user_id, ug.user_email, ug.access_lvl, ug.username, ug.user_timezone " .
				"FROM cookies_grumble AS cg " .
				"LEFT OUTER JOIN users_grumble AS ug ON cg.user_id = ug.user_id " .
				"WHERE cg.cookie_text='" . $_COOKIE["user_grumble"] . "' AND cg.cookie_expire >= '" . date("Y-m-d H:i:s", time()) . "' AND cookie_id = " . $_COOKIE["cookie_id"] . " LIMIT 0,1";
		$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
		if(mysql_num_rows($result) != 0) {
			$row = mysql_fetch_array($result);
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["access_lvl"] = $row["access_lvl"];
			$_SESSION["username"] = $row["username"];
			$_SESSION["email"] = $row["user_email"];
			$_SESSION["timezone"] = $row["user_timezone"];
		}	
	}
}

//check if user is logged in
function is_user_logged_in() {
	//if $_SESSION['username'] is false, we know the user is not logged in
	if(isset($_SESSION['username'])) {
	    return true;
	}
	else {
	    return false;	
	}
}

//get notification number
function notificationNumber() {
	global $conn;
	$sql = "SELECT COUNT(notification_id) as number FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " AND notification_read = 0";
	$number = mysql_query($sql, $conn);
	return $number;
}

function isMobile() {
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		return true;
	else
		return false;
}

function getFooter($filename, $min = false) { ?>
	<?php require_once 'php/notificationbar.php'; ?>
	</div>
	</div>
	<div id="lightbox-container"></div>
	<?php //min footer without the link
	if(!$min) { ?>
	<div id="footer">
		<div id="footer-links">
	    	<div id="footer-copyright">© 2012 Grumble</div>
	    	<a class="colored-link-1" href="/about">About</a>|
	    	<a class="colored-link-1" href="/how-it-works">How it works</a>|
	    	<a class="colored-link-1" href="/updates">Updates</a>|
	        <a class="colored-link-1" href="/privacy">Privacy</a>|
	        <a class="colored-link-1" href="/terms-of-service">Terms</a>|
	        <a class="colored-link-1" href="/contact">Contact Us</a>
	    </div>
	    <div id="social-icons">
	    	<a href="https://facebook.com/grumbleonline" target="_blank"><img src="/images/icons/facebook-footer.png" width="25" height="25" alt="Facebook page" title="Facebook page"></a>
	    	<a href="https://twitter.com/grumbleonline" target="_blank"><img src="/images/icons/twitter-footer.png" width="25" height="25" alt="Twitter" title="Twitter page"></a>
	    </div>
	</div>
	<?php } ?>
	<div id="fb-root"></div>
	<script type="text/javascript" src="/javascript/script.min.js" async="async"></script>
	<?php
	if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && !isset($_GET["social_create"])) {
	 echo '<script type="text/javascript" src="/javascript/formValidation.min.js" async="async"></script>';   
	}
	if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && isset($_GET["social_create"])) {
	 echo '<script type="text/javascript" src="/javascript/formvalidationsocial.min.js" async="async"></script>'; 
	}
	if($filename == "contact.php") {
	 echo '<script type="text/javascript" src="/javascript/contactvalidation.min.js" async="async"></script>';    
	}
	if($filename == "profile.php" || $filename == "forgot-password.php") {
	 echo '<script type="text/javascript" src="/javascript/settingsvalidation.min.js" async="async"></script>';   
	}
	if(($filename == "index.php" && !$mobile) || $filename == "grumbles.php" || $filename == "statusview.php") {
	    echo '<script type="text/javascript" src="/javascript/socialscript.js" async="async"></script>'; 
	}
	?>
	</body>
	</html>
<?php }

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