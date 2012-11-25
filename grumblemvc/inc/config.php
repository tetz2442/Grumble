<?php
//class for setting constants used throughout site
//set constants for mysql connection
define ("SQL_HOST", "localhost");
define ("SQL_USER", "root");
define ("SQL_PASS", "");
define ("SQL_DB", "grumble");
//current filename
define("__FILE__", $_GET["controller"]);
//define mobile variable
//detect mobile browser
$mobile = isMobile();
define("MOBILE", $mobile);
//define grumble url
define("URL", "http://" . $_SERVER["HTTP_HOST"]);

session_start();
?>