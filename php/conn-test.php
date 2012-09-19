<?php
	define ("SQL_HOST", "localhost");
	define ("SQL_USER", "grumble1_grumble");
	define ("SQL_PASS", "Clayweb2442!");
	define ("SQL_DB", "grumble1_testgrumbledb");
	
	$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die("Could not connect to the database: " . mysql_error());
	mysql_select_db(SQL_DB, $conn) or die("Could not select the database: " . mysql_error());
?>