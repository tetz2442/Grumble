<?php
require_once "conn.php";
require_once "functions.php";
require_once "notifications.php";
require_once "outputreplies.php";
session_start();
//retrieve replies
if(isset($_POST["reply"]) && is_numeric($_POST["reply"]) && isset($_POST["type"]) && $_POST["type"] == "load" && isset($_POST["amount"]) && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	retrieveReplies(escape($_POST["reply"]), escape($_POST["amount"]));
}
//enter a reply into db
else if(isset($_POST["reply"]) && is_numeric($_POST["reply"]) && isset($_POST["type"]) && $_POST["type"] == "enter" && isset($_POST["text"]) && isset($_POST["statususername"]) && strlen(trim($_POST["text"])) > 0 && strlen($_POST["text"]) < 340 && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	enterReply($_POST["reply"], trim($_POST["text"]), $_POST["statususername"]);
}
//delete reply
else if(isset($_POST["id"]) && is_numeric($_POST["id"]) && $_POST["action"] == "Delete") {
	deleteReply(escape($_POST["id"]));
}

function retrieveReplies($voteid, $amount) {
	global $conn;
	if($amount == "few") {
		$sql = "(SELECT cg.reply_id, cg.status_id, DATE_FORMAT(cg.reply_date, '%b %e, %Y %l:%i %p') AS reply_date, cg.reply_text, ug.username, ug.user_email FROM replies_grumble AS cg" . 
			" LEFT OUTER JOIN users_grumble AS ug ON cg.reply_user = ug. user_id" . 
			" WHERE status_id = " . $voteid . " ORDER BY cg.reply_date DESC LIMIT 2)" . 
			" ORDER BY reply_id";
	}
	else if($amount = "all") {
		$sql = "SELECT cg.reply_id, cg.status_id, DATE_FORMAT(cg.reply_date, '%b %e, %Y %l:%i %p') AS reply_date, cg.reply_text, ug.username, ug.user_email FROM replies_grumble AS cg" . 
			" LEFT OUTER JOIN users_grumble AS ug ON cg.reply_user = ug.user_id" . 
			" WHERE status_id = " . $voteid . " ORDER BY cg.reply_id";
	}
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	outputReplies($result);
}

function enterReply($id, $text, $statususername) {
	global $conn;
	$id = escapeAndStrip($id);
	$commenttext = removeNewLine($text);
	$commenttext = escapeAndStrip($commenttext);
	
	$sql = "SELECT sg.status_id, ug.user_id, ug.username FROM status_grumble AS sg 
	LEFT OUTER JOIN users_grumble AS ug ON sg.user_id = ug.user_id WHERE status_id = " . $id . " LIMIT 0,1";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error()); 
	
	if(mysql_num_rows($result) != 0) {
		$row = mysql_fetch_array($result);
		$sql = "INSERT INTO replies_grumble (status_id, reply_date, reply_user, reply_text) " . 
			"VALUES(" . $id . ",UTC_TIMESTAMP()," . $_SESSION["user_id"] . ",'" . $commenttext . "')";
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		$commenttext = stripslashes(stripslashes($commenttext));
		echo '<div class="ind-reply">';
		echo '<div class="reply-padding">';
		echo '<a class="reply-username username" href="/profile/' . $_SESSION["username"] . '">' . $_SESSION["username"] . '</a>';
		echo '<p class="reply-text">' . $commenttext . '</p>';
		echo '<small class="reply-time">' . convertToTimeZone(gmdate("M d, o g:i A", time()), $_SESSION["timezone"]) . '</small>';
		echo '<a href="/profile/' . $_SESSION["username"] . '"><img class="reply-user-image rounded-corners-medium" src="' . getGravatar($_SESSION["email"]) . '" width="45" height="45" alt="' .  $_SESSION["username"] . '"></a>';
		echo '</div>';
		echo '</div>';
		
		$sql = "SELECT reply_user FROM replies_grumble WHERE status_id = " . $id . " GROUP BY reply_user";
		$result = mysql_query($sql, $conn) or die("Error: " . mysql_error()); 
		//someone replied, notify everyone else who also replied
		if($_SESSION["user_id"] != $row["user_id"]) {
			while($row2 = mysql_fetch_array($result)) {
				//owner of comment
				if($row["user_id"] == $row2["reply_user"]) {
					insertNotification($row["user_id"], $_SESSION["user_id"], $_SESSION["username"], "http://" . $_SERVER["HTTP_HOST"] . "/profile/" . $row["username"] . "/comment/" . $row["status_id"], "reply");
				}
				//other users who replied
				else if($row2["reply_user"] != $_SESSION["user_id"]) {
					insertNotification($row2["reply_user"], $_SESSION["user_id"], $_SESSION["username"], "http://" . $_SERVER["HTTP_HOST"] . "/profile/" . $row["username"] . "/comment/" . $row["status_id"], "reply-other");
				}
			}
		}
		//user commented on his own reply, notify everyone else but him
		else {
			while($row2 = mysql_fetch_array($result)) {
				//notify everone but owner
				if($row["user_id"] != $row2["reply_user"]) {
					insertNotification($row2["reply_user"], $_SESSION["user_id"], $_SESSION["username"], "http://" . $_SERVER["HTTP_HOST"] . "/profile/" . $row["username"] . "/comment/" . $row["status_id"], "reply-other");
				}
			}
		}
	}
}

function deleteReply($id) {
	global $conn;
	
	//check if status is there and user is owner
	$sql = "SELECT ug.username, rg.reply_id FROM replies_grumble AS rg " .
	"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = rg.reply_user " . 
	"WHERE rg.reply_id = " . $id . " LIMIT 0,1";
	$result = mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	if(mysql_num_rows($result) != 0) {
		$row = mysql_fetch_array($result);
		if($row["username"] == $_SESSION["username"]) {
			//delete everything associated with grumble (grumble, comments, votes)
			$sql = "DELETE FROM replies_grumble WHERE reply_id = " . $id . " LIMIT 1";
			mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
			
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