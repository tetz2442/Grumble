<?php
require_once "conn.php";
require_once "functions.php";

session_start();
if(isset($_POST["action"]) && $_POST["action"] == "markasread" && isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
	$sql = "UPDATE notifications_grumble SET notification_read = 1 WHERE notification_read = 0 AND user_id = " . $_SESSION["user_id"]; 
	mysql_query($sql, $conn) or die("Could not mark as read: " . mysql_error());
}
else if(isset($_POST["action"]) && $_POST["action"] == "load" && isset($_POST["lastid"]) && is_numeric($_POST["lastid"]) && isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
	$lastid = escapeAndStrip($_POST["lastid"]);
	$sql = "SELECT notification_id, notification_message, notification_url, notification_read, notification_created FROM 
	notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " AND notification_id < " . $lastid . " ORDER BY notification_created DESC LIMIT 10";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	
	if(mysql_num_rows($result) != 0) {
		outputNotifications($result);
	}
	else {
		echo '0';
	}
}

//insert notification
function insertNotification($user_id, $from_user_id, $username, $url, $type) {
	global $conn;
	//get type and compose message
	if($type == "comment") {
		$message = $username . " commented on your Grumble";
	}
	else if($type == "reply") {
		$message = $username . " replied to your comment";
	}
	else if($type == "reply-other") {
		$message = $username . " replied to the same comment";
	}
	else if($type == "upvote") {
		$message = $username . " voted up your comment";
	}
	else if($type == "grumbleupvote") {
		$message = $username . " voted up your Grumble";
	}
	
	$sql = "INSERT INTO notifications_grumble " .
		"(user_id, from_user_id, notification_message, notification_url, notification_created) " .
		"VALUES (" . $user_id . "," . $from_user_id . ",'" . $message . "','" . $url . "',UTC_TIMESTAMP())"; 
	mysql_query($sql, $conn) or die("Could not insert: " . mysql_error());
}

//mark as read
function clearNotifications($user_id) {
	
}
?>