<?php
require_once "../php/conn.php";
require_once "../php/functions.php";
session_start();
//is an admin
if(isset($_SESSION["username"]) && $_SESSION["access_lvl"] == 3) {
	if(isset($_POST["contactid"]) && is_numeric($_POST["contactid"]) && isset($_POST["action"]) && $_POST["action"] == "Delete") {
		$id = escapeAndStrip($_POST["contactid"]);
		$sql = "DELETE FROM contact_grumble WHERE contact_id = " . $id . " LIMIT 1";
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		echo 1;
	}
	else if(isset($_POST["contactid"]) && is_numeric($_POST["contactid"]) && isset($_POST["action"]) && $_POST["action"] == "Resolved") {
		$id = escapeAndStrip($_POST["contactid"]);
		$sql = "UPDATE contact_grumble SET contact_resolved = 1 WHERE contact_id = " . $id . " LIMIT 1";
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		echo 1;
	}
	else if(isset($_POST["contactid"]) && is_numeric($_POST["contactid"]) && isset($_POST["message"]) && strlen($_POST["message"]) > 0 && isset($_POST["action"]) && $_POST["action"] == "Contact") {
		$id = escapeAndStrip($_POST["contactid"]);
		$message = $_POST["message"];
		$sql = "SELECT contact_email FROM contact_grumble WHERE contact_id = " . $id . " LIMIT 1";
		$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());

		if(mysql_num_rows($result) != 0) {
			$row = mysql_fetch_array($result);
			$subject = "[Contact] Grumble admin";
			$parameters = array($subject, $message);
			sendEmail($row["contact_email"], "admin@grumbleonline.com", "admin", $parameters);
			echo 1;
		}
	}
}
?>
