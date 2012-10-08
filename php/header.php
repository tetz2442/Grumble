<?php 
session_start(); 
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

$loggedin = false;
//if $_SESSION['username'] is false, we know the user is not logged in
if(isset($_SESSION['username'])) {
    $loggedin = true;
}
else {
    $loggedin = false;	
}

//detect mobile browser
$mobile = false;
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
	$mobile = true;
?>
<!DOCTYPE html>  
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="/css/styles.css" rel="stylesheet" media="all">
<noscript>
    <meta http-equiv="Refresh" content="0; url=/noscript.php">
</noscript>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Grumble |
<?php
$filename = basename($_SERVER['PHP_SELF']);
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
	$id = mysql_real_escape_string($_GET["s"]);
	$sql = "SELECT sg.status_text FROM status_grumble AS sg " .
		"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sg.user_id " .
		"WHERE sg.status_id = " . $id;
	$result = mysql_query($sql, $conn) or die("Could not look up information: " . mysql_error());
	$row = mysql_fetch_array($result);
	echo " " . strip_tags($_GET["user"]);
}
else if(isset($_GET["id"])) { //profile
	echo " " . strip_tags($_GET["id"]);
}
else if($filename == "create-account.php") {
	echo " Create Account";
}
else if($filename == "about.php") {
	echo " About";
}
else if($filename == "privacy.php") {
	echo " Privacy Policy";
}
else if($filename == "terms-of-service.php") {
	echo " Terms of Service";
}
else if($filename == "login.php") {
	echo " Login";
}
else if($filename == "contact.php") {
	echo " Contact Us";
}
else if($filename == "how-it-works.php") {
	echo " How it works";
}
else if($filename == "noscript.php") {
	echo " JavaScript not enabled";
}
else if($filename == "updates.php") {
	echo " Updates";
}
else if($filename == "forgot-password.php") {
	echo " Forgot Password";
}
else {
	echo " Grumble for you. Grumble for change.";	
}
?>
</title>
<meta name="description" content="<?php
if(isset($_GET["subcat"])) {
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
	$catname = stripslashes($row["category_name"]);
	echo $catname . " is a category on Grumble. Categories are full of Grumbles that relate to that specific category. Place a Grumble into the category that you feel relates best.";
}
else if($filename == "create-account.php") {
	echo "Create Account an account on Grumble to access its many features. Join today and inspire an action for change or simply get something off of your chest. ";
}
else if($filename == "privacy.php") {
	echo "What you say on Grumble will be accessible by anyone with an Internet connection. Read more of this document to find out more.";
}
else if($filename == "terms-of-service.php") {
	echo "Terms of Service.  These Terms of Service explain how Grumble works. Read more of this document for more information.";
}
else if($filename == "login.php") {
	echo "Login in to Grumble with your user account. ";
}
else if($filename == "contact.php") {
	echo "Contact Grumble. Use this page to suggest a feature, report a bug, or just send us a message. We will get back to you as soon as possible.";
}
else if($filename == "noscript.php") {
	echo "You must enable your JavaScript to be able to have the best viewing experience on Grumble.";
}
else if($filename == "updates.php"){
	echo "Come here for updates on new things happening at Grumble. Grumble is a place where you can discuss the topics that you feel are important and need attention.";
}
else if($filename == "about.php") {
	echo "Find out a little more about Grumble on our about page. Grumble is a place where you can discuss the topics that you feel are important and need attention.";
}
else if($filename == "forgot-password.php") {
	echo "Have you forgetten your password on Grumble? On this page you can reset your password through email. Simply enter it into the provided field.";
}
else if(isset($_GET["s"]) && isset($_GET["user"])) { //statusview
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
?>
">
<link rel="Shortcut Icon" href="/favicon.ico">
<?php //javascript files?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript">
!window.jQuery && document.write('<script src="/javascript/jquery-1.8.1.min.js"><\/script>');
var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33671147-1']);
  _gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
<?php if(!isset($_SESSION["time"]) && !isset($_SESSION["timezone"])) { ?>
//gets timezone to display proper time for comments, this information is not collected
if("<?php echo $_SESSION["time"]; ?>".length==0){
            var visitortime = new Date();
            var visitortimezone = -visitortime.getTimezoneOffset()/60;
            $.post("/php/timezoneset.php",{time:visitortimezone}, 
            	function(result) {
            		location.reload();
            	});
        }
<?php }?>
</script>
<script type="text/javascript" src="/javascript/script.min.js"></script>
<?php
if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && !isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formValidation.min.js"></script>';	
}
if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formvalidationsocial.min.js"></script>';	
}
if($filename == "contact.php") {
 echo '<script type="text/javascript" src="/javascript/contactvalidation.min.js"></script>';	
}
if($filename == "profile.php" || $filename == "forgot-password.php") {
 echo '<script type="text/javascript" src="/javascript/settingsvalidation.min.js"></script>';	
}
?>
</head>
<body>
<?php
require_once "usernavigation.php";
echo '<div id="maincolumn">';
?>