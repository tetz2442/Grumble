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
<link type="text/css" href="/css/styles.css" rel="stylesheet" media="all">
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
</head>
<body>
<?php require_once "usernavigation.php"; ?>
<div id="maincolumn">