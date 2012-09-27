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
?>
<!DOCTYPE html>  
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="/css/styles.css" rel="stylesheet" media="all">
<noscript>
    <meta http-equiv="Refresh" content="0; url=/noscript.php">
</noscript>
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
else if(isset($_GET["id"])) {
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
else {
	echo "Grumble is a place where you can discuss the topics that you feel are important and need attention. It's simple. Grumble for you. Grumble for change.";
}
?>
">
<!--[if IE]
	<script src="http://html5shiv.googlecode.com/svn/trunk/html.js"></script>
    <![endif]-->
<link rel="Shortcut Icon" href="/favicon.ico">
<?php //javascript files?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript">
!window.jQuery && document.write('<script src="/javascript/jquery-1.8.1.min.js"><\/script>');
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