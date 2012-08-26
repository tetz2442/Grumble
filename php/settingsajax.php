<?php
require_once "conn.php";
session_start();
if(isset($_POST["user"]) && isset($_POST["username"]) && isset($_POST["threadcheck"]) && isset($_POST["commentcheck"]) && isset($_POST["currentpass"]) && isset($_POST["newpass"]) && isset($_POST["newpass2"]) && $_SESSION["username"] == $_POST["username"] && $_SERVER['REQUEST_METHOD'] == "POST") {
	if($_POST["threadcheck"] == "true")
		$thread = 1;
	else
		$thread = 0;
		
	if($_POST["commentcheck"] == "true")
		$comment = 1;
	else
		$comment = 0;
		
	$username = mysql_real_escape_string($_POST["user"]);
	$currentpass = mysql_real_escape_string($_POST["currentpass"]);
	$changepass = mysql_real_escape_string($_POST["newpass"]);
	$changepass2 = mysql_real_escape_string($_POST["newpass2"]);
			
	if(strlen($changepass) > 5 && strlen($changepass2) > 5 && strlen($currentpass) > 5 && $changepass == $changepass2 && $_POST["user"] == $_SESSION["username"]) {
		//insert into users with new passwords, username hasnt changed
		echo 2;
	}
	else if(strlen($changepass) > 5 && strlen($changepass2) > 5 && strlen($currentpass) > 5 && $changepass == $changepass2 && $_POST["user"] != $_SESSION["username"]) {
		if(strlen($username) >= 4 && strlen($username) <= 15) {
			//insert into users with new passwords, username has changed also
			echo 1;
		}
		else {
			echo 0;
		}
	}
	else if($_POST["user"] == $_SESSION["username"]) {
		//username has not changed, insert email settings
		$sql = "UPDATE settings_user_grumble SET settings_email_thread = " . $thread . ", settings_email_comment = " .
		$comment . " WHERE user_id = " . $_SESSION["user_id"];
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		echo 2;
	}
	else if($_POST["user"] != $_SESSION["username"]) {
		if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
			//username has changed
			$sql = "UPDATE users_grumble SET username = '" . $username . "' WHERE user_id = " . $_SESSION["user_id"];
			mysql_query($sql, $conn) or die("Error: " . mysql_error());
			$_SESSION["username"] = $username;
			//update email settings
			$sql = "UPDATE settings_user_grumble SET settings_email_thread = " . $thread . ", settings_email_comment = " .
			$comment . " WHERE user_id = " . $_SESSION["user_id"];
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