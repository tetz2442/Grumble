<?php 
session_start(); 
//if cookie is set, set session variables
if(isset($_COOKIE["user_grumble"]) && !isset($_SESSION["user_id"])) {
	require_once "conn.php";
	$sql = "SELECT cg.cookie_id, ug.user_id, ug.access_lvl, ug.username, ug.user_timezone " .
			"FROM cookies_grumble AS cg " .
			"LEFT OUTER JOIN users_grumble AS ug ON cg.user_id = ug.user_id " .
			"WHERE cg.cookie_text='" . $_COOKIE["user_grumble"] . "' AND cg.cookie_expire >= '" . date("Y-m-d H:i:s", time()) . "' LIMIT 0,1";
	$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
	if(mysql_num_rows($result) != 0) {
		$row = mysql_fetch_array($result);
		$_SESSION["user_id"] = $row["user_id"];
		$_SESSION["access_lvl"] = $row["access_lvl"];
		$_SESSION["username"] = $row["username"];
		$_SESSION["timezone"] = $row["user_timezone"];
		date_default_timezone_set($_SESSION["timezone"]);
			
		//mysql_query("SET time_zone = " . $row["user_timezone"], $conn);
	}	
}
?>
<!DOCTYPE html>  
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="/css/styles.css" rel="stylesheet" media="all">
        <noscript>
        <meta http-equiv="Refresh" content="0;url=<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/"; ?>noscript.html">
    </noscript>
<title>Grumble |
<?php
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
else if(basename($_SERVER['PHP_SELF']) == "create-account.php") {
	echo " Create Account";
}
else if(basename($_SERVER['PHP_SELF']) == "about.php") {
	echo " About";
}
else if(basename($_SERVER['PHP_SELF']) == "privacy.php") {
	echo " Privacy Policy";
}
else if(basename($_SERVER['PHP_SELF']) == "terms-of-service.php") {
	echo " Terms of Service";
}
else if(basename($_SERVER['PHP_SELF']) == "login.php") {
	echo " Login";
}
else if(basename($_SERVER['PHP_SELF']) == "contact.php") {
	echo " Contact Us";
}
else if(basename($_SERVER['PHP_SELF']) == "how-it-works.php") {
	echo " How it works";
}
else {
	echo " Grumble for you. Grumble for change.";	
}
?>
</title>
<meta name="description" content="<?php
if(isset($_GET["subcat"])) {
	if(strlen($row["sub_category_description"]) > 50)
		echo stripslashes($row["sub_category_description"]);
	else
		echo stripslashes($row["sub_category_description"]) . " | Grumble is a place where you can discuss the topics that you feel are important and need attention. It's simple. Grumble for you. Grumble for change.";
}
else if(basename($_SERVER['PHP_SELF']) == "create-account.php") {
	echo "Create Account an account on Grumble to access its many features. Join today and inspire an action for change or simply get something off of your chest. ";
}
else if(basename($_SERVER['PHP_SELF']) == "privacy.php") {
	echo "What you say on Grumble will be accessible by anyone with an Internet connection. Read more of this document to find out more.";
}
else if(basename($_SERVER['PHP_SELF']) == "terms-of-service.php") {
	echo "Terms of Service.  These Terms of Service explain how Grumble works. Read more of this document for more information.";
}
else if(basename($_SERVER['PHP_SELF']) == "login.php") {
	echo "Login in to Grumble with your user account. ";
}
else if(basename($_SERVER['PHP_SELF']) == "contact.php") {
	echo "Contact Grumble. Use this page to suggest a feature, report a bug, or just send us a message. We will get back to you as soon as possible.";
}
else {
	echo "Grumble is a place where you can discuss the topics that you feel are important and need attention. It's simple. Grumble for you. Grumble for change.";
}
?>
"/>
<!--[if IE]
	<script src="http://html5shiv.googlecode.com/svn/trunk/html.js"></script>
    <![endif]-->
<link rel="Shortcut Icon" href="/favicon.ico">
</head>
<body>
<?php
require_once "usernavigation.php";
$validation = false;
$contactvalidation = false;
$grumble = false;
?>
<div id="maincolumn">