<?php
require_once "conn.php";
session_start();
if(isset($_POST["vote_up"]) && $_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION["user_id"])) {
	catchUpVote(mysql_real_escape_string(strip_tags($_POST["vote_up"])));
}

function catchUpVote($voteid) {
	global $conn;
	if(isset($_SESSION["user_id"])) {
		$sql = "SELECT user_like_id FROM user_likes_grumble " .
			"WHERE status_id = " . $voteid . " AND " . 
			"user_id = " . $_SESSION["user_id"];
		$result = mysql_query($sql, $conn);
		if(mysql_num_rows($result) == 0) {
			/*$sql = "UPDATE votes_up_grumble SET " . 
				"votes_up_count = votes_up_count + 1" . 
				" WHERE status_id = " . $voteid;
			mysql_query($sql, $conn) or die("Error: " . mysql_error());*/
			
			$sql = "INSERT INTO user_likes_grumble(user_id, status_id) " . 
				"VALUES (" . $_SESSION["user_id"] . "," . $voteid . ")";
			mysql_query($sql, $conn) or die("Error: " . mysql_error());
			echo 1;
		}
		else {
			echo 0;	
		}
	}
	else {
		echo 0;	
	}
}
?>