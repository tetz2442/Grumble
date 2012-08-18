<?php
require_once "conn.php";

if(isset($_POST["vote_up"])) {
	catchUpVote(mysql_real_escape_string(strip_tags($_POST["vote_up"])));
}
else {
	echo 0;	
}

function catchUpVote($voteid) {
	global $conn;
	session_start();
	if(isset($_SESSION["user_id"])) {
		$sql = "UPDATE votes_up_grumble SET " . 
			"votes_up_count = votes_up_count + 1" . 
			" WHERE status_id = " . intval($voteid);
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		
		$sql = "INSERT INTO user_likes_grumble(user_id, status_id) " . 
			"VALUES (" . $_SESSION["user_id"] . "," . $voteid . ")";
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		echo 1;
	}
	else {
		echo 0;	
	}
}
?>