<?php
//class for setting constants used throughout site
//set constants for mysql connection
define ("SQL_HOST", "localhost");
define ("SQL_USER", "root");
define ("SQL_PASS", "");
define ("SQL_DB", "grumble");
//detect mobile browser
define("MOBILE", isMobile());
//define grumble url
define("SITE_URL", "http://" . $_SERVER["HTTP_HOST"]);
//define view URL
define("TEMPLATE_PATH", "http://" . $_SERVER["HTTP_HOST"] . "/grumble/view");
//start the session
session_start();
//set timezone
setTimezone();
//hooks
$hooks["register_script"] = array();
$hooks["register_style"] = array();
?>