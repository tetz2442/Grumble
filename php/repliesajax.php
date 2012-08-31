<?php
require_once "conn.php";
require_once "http.php";
require_once "sendemail.php";
session_start();
if(isset($_POST["reply"]) && isset($_POST["type"]) && $_POST["type"] == "load" && isset($_POST["amount"]) && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	retrieveReplies(mysql_real_escape_string($_POST["comment"]), mysql_real_escape_string($_POST["amount"]));
}
else if(isset($_POST["reply"]) && isset($_POST["type"]) && $_POST["type"] == "enter" && isset($_POST["text"]) && isset($_POST["statususername"]) && strlen($_POST["text"]) > 0 && strlen($_POST["text"]) < 160 && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	enterReply(mysql_real_escape_string(strip_tags($_POST["comment"])), $_POST["text"], $_POST["statususername"]);
}

function retrieveReplies($voteid, $amount) {
	global $conn;
	if($amount == "few") {
		$sql = "(SELECT cg.comment_id, cg.status_id, DATE_FORMAT(cg.comment_date, '%b %e, %Y %l:%i %p') AS comment_date, cg.comment_text, ug.username FROM comments_grumble AS cg" . 
			" LEFT OUTER JOIN users_grumble AS ug ON cg.comment_user = ug. user_id" . 
			" WHERE status_id = " . intval($voteid) . " ORDER BY cg.comment_date DESC LIMIT 2)" . 
			" ORDER BY comment_id";
	}
	else if($amount = "all") {
		$sql = "SELECT cg.comment_id, cg.status_id, DATE_FORMAT(cg.comment_date, '%b %e, %Y %l:%i %p') AS comment_date, cg.comment_text, ug.username FROM comments_grumble AS cg" . 
			" LEFT OUTER JOIN users_grumble AS ug ON cg.comment_user = ug. user_id" . 
			" WHERE status_id = " . intval($voteid) . " ORDER BY cg.comment_id";
	}
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	if(mysql_num_rows($result) != 0) {
		while($row = mysql_fetch_array($result)) {
			echo '<div class="ind-reply">';
			echo '<div class="reply-padding">';
			echo '<a class="reply-username username" href="/profile/' . $row["username"] . '">' . $row["username"] . '</a>';
			echo '<p class="reply-text">' . stripslashes($row["comment_text"]) . '</p>';
			echo '<small class="reply-time">' . $row["comment_date"] . '</small>';
			echo '</div>';
			echo '</div>';
		}
	}
	//echo '<div class="ind-comment" style="display:none;">';
	echo '</div>';
}

function enterReply($id, $text, $statususername) {
	global $conn;
	$commenttext = str_replace("\r", "", $text);
	$commenttext = str_replace("\n", "", $commenttext);
	$commenttext = mysql_real_escape_string(strip_tags($commenttext));
	$sql = "INSERT INTO comments_grumble (status_id, comment_date, comment_user, comment_text) " . 
		"VALUES(" . intval($id) . ",'" . date("Y-m-d H:i:s", time()) . "'," . $_SESSION["user_id"] . ",'" . $commenttext . "')";
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
		"ON ug.user_id = sg.user_id LEFT OUTER JOIN settings_user_grumble AS sug ON sug.user_id = ug.user_id WHERE sg.status_id = " . intval($id) . " AND sug.settings_email_comment = 1";
		$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
		if(mysql_num_rows($result) != 0) {
			$row = mysql_fetch_array($result);
			$parameters = array("http://" . $_SERVER["HTTP_HOST"] . "/profile/" . $row["username"] . "/grumble/" . $row["status_id"], $statususername, $_SESSION["username"], $commenttext);
			sendEmail($row["user_email"], "From: no-reply@grumbleonline.com", "reply", $parameters);
		}
	}
}
?>