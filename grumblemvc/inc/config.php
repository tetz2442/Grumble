<?php
//class for setting constants used throughout site
//set constants for mysql connection
define ("SQL_HOST", "localhost");
define ("SQL_USER", "root");
define ("SQL_PASS", "");
define ("SQL_DB", "grumble");
//detect mobile browser
$mobile = isMobile();
define("MOBILE", $mobile);
//define grumble url
define("SITE_URL", "http://" . $_SERVER["HTTP_HOST"]);
//define view URL
define("TEMPLATE_PATH", "http://" . $_SERVER["HTTP_HOST"] . "/view");
//start the session
session_start();
//set timezone
setTimezone();
?>