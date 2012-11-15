<?php
//class for setting constants used throughout site
//set constants for mysql connection
define ("SQL_HOST", "localhost");
define ("SQL_USER", "root");
define ("SQL_PASS", "");
define ("SQL_DB", "grumble");
require_once "database.php";
//create new instance of database class
$db = new DB(SQL_HOST, SQL_USER, SQL_PASS, SQL_PASS);
?>