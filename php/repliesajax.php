<?php
require_once "conn.php";
require_once "http.php";
require_once "sendemail.php";
session_start();
if(isset($_POST["reply"]) && is_numeric($_POST["reply"]) && isset($_POST["type"]) && $_POST["type"] == "load" && isset($_POST["amount"]) && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	retrieveReplies(mysql_real_escape_string($_POST["reply"]), mysql_real_escape_string($_POST["amount"]));
}
else if(isset($_POST["reply"]) && is_numeric($_POST["reply"]) && isset($_POST["type"]) && $_POST["type"] == "enter" && isset($_POST["text"]) && isset($_POST["statususername"]) && strlen($_POST["text"]) > 0 && strlen($_POST["text"]) < 160 && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	enterReply($_POST["reply"], $_POST["text"], $_POST["statususername"]);
}

function retrieveReplies($voteid, $amount) {
	global $conn;
	if($amount == "few") {
		$sql = "(SELECT cg.reply_id, cg.status_id, DATE_FORMAT(cg.reply_date, '%b %e, %Y %l:%i %p') AS reply_date, cg.reply_text, ug.username FROM replies_grumble AS cg" . 
			" LEFT OUTER JOIN users_grumble AS ug ON cg.reply_user = ug. user_id" . 
			" WHERE status_id = " . intval($voteid) . " ORDER BY cg.reply_date DESC LIMIT 2)" . 
			" ORDER BY reply_id";
	}
	else if($amount = "all") {
		$sql = "SELECT cg.reply_id, cg.status_id, DATE_FORMAT(cg.reply_date, '%b %e, %Y %l:%i %p') AS reply_date, cg.reply_text, ug.username FROM replies_grumble AS cg" . 
			" LEFT OUTER JOIN users_grumble AS ug ON cg.reply_user = ug.user_id" . 
			" WHERE status_id = " . intval($voteid) . " ORDER BY cg.reply_id";
	}
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	if(mysql_num_rows($result) != 0) {
		while($row = mysql_fetch_array($result)) {
			echo '<div class="ind-reply">';
			echo '<div class="reply-padding">';
			echo '<a class="reply-username username" href="/profile/' . $row["username"] . '">' . $row["username"] . '</a>';
			echo '<p class="reply-text">' . stripslashes($row["reply_text"]) . '</p>';
			echo '<small class="reply-time">' . $row["reply_date"] . '</small>';
			echo '</div>';
			echo '</div>';
		}
	}
	echo '</div>';
}

function enterReply($id, $text, $statususername) {
	global $conn;
	$id = mysql_real_escape_string(strip_tags($id));
	$commenttext = str_replace("\r", "", $text);
	$commenttext = str_replace("\n", "", $commenttext);
	$commenttext = mysql_real_escape_string(strip_tags($commenttext));
	
	$sql = "SELECT status_id FROM status_grumble WHERE status_id = " . $id . " LIMIT 0,1";
	$result = mysql_query($sql, $conn); 
	
	if(mysql_num_rows($result) != 0) {
		$sql = "INSERT INTO replies_grumble (status_id, reply_date, reply_user, reply_text) " . 
			"VALUES(" . $id . ",'" . date("Y-m-d H:i:s", time()) . "'," . $_SESSION["user_id"] . ",'" . $commenttext . "')";
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		$commenttext = stripslashes(stripslashes($commenttext));
		echo '<div class="ind-reply">';
		echo '<div class="reply-padding">';
		echo '<a class="reply-username username" href="/profile/' . $_SESSION["username"] . '">' . $_SESSION["username"] . '</a>';
		echo '<p class="reply-text">' . $commenttext . '</p>';
		echo '<small class="reply-time">' . date("M d, o g:i A", time()) . '</small>';
		echo '</div>';
		echo '</div>';
		
		if($_SESSION["username"] != $statususername) {
			$sql = "SELECT ug.user_email, ug.username, sg.status_id FROM status_grumble AS sg LEFT OUTER JOIN users_grumble AS ug " .
			"ON ug.user_id = sg.user_id LEFT OUTER JOIN settings_user_grumble AS sug ON sug.user_id = ug.user_id WHERE sg.status_id = " . $id . " AND sug.settings_email_comment = 1";
			$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
			if(mysql_num_rows($result) != 0) {
				$row = mysql_fetch_array($result);
				$parameters = array("http://" . $_SERVER["HTTP_HOST"] . "/profile/" . $row["username"] . "/comment/" . $row["status_id"], $statususername, $_SESSION["username"], $commenttext);
				sendEmail($row["user_email"], "From: no-reply@grumbleonline.com", "reply", $parameters);
			}
		}
	}
}
?>