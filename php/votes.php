<?php
require_once "conn.php";
require_once "functions.php";
require_once "notifications.php";
session_start();
if(isset($_POST["vote_up"]) && $_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION["user_id"])) {
	catchUpVote(escapeAndStrip($_POST["vote_up"]));
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
			
			$sql = "SELECT ug.user_id, ug.username FROM status_grumble AS sg " .
				"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sg.user_id " .
				"WHERE sg.status_id = " . $voteid;
			$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
			$row = mysql_fetch_array($result);
			if($_SESSION["user_id"] != $row["user_id"]) {
				insertNotification($row["user_id"], $_SESSION["user_id"], $_SESSION["username"], "http://" . $_SERVER["HTTP_HOST"] . "/profile/" . $row["username"] . "/comment/" . $voteid, "upvote");
			}
				
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