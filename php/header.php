<?php 
session_start(); 
//check if cookie is set
checkCookie();
$loggedin = is_user_logged_in();
//get user notification number if logged in
if($loggedin)
	$number = notificationNumber();
//detect mobile browser
$mobile = isMobile();
?>
<!DOCTYPE html>  
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="/css/styles.min.css" rel="stylesheet" media="all">
<?php //if the user does not have javascript enabled, redirect them ?>
<noscript>
    <meta http-equiv="Refresh" content="0; url=/noscript.php">
</noscript>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php $filename = basename($_SERVER['PHP_SELF']); ?>
<title>Grumble | <?php getTitle($filename); ?></title>
<meta name="description" content="<?php getDescription($filename); ?>">
<link rel="Shortcut Icon" href="/favicon.ico">
<?php //javascript files?>
<script src="/javascript/ga.js"></script>

<?php 
//set timezone
if(!isset($_SESSION["time"]) && !isset($_SESSION["timezone"])) { 
	$_SESSION["time"] == "America/Chicago";
}
?>
<?php
//gets timezone to display proper time for comments, this information is not collected
// if(" echo $_SESSION["time"]; ".length==0){
            // var visitortime = new Date();
            // var visitortimezone = -visitortime.getTimezoneOffset()/60;
            // $.post("/php/timezoneset.php",{time:visitortimezone}, 
            	// function(result) {
            		// location.reload();
            	// });
        // }
 ?>
</head>
<body>
<?php require_once "usernavigation.php"; ?>
<div id="maincolumn">