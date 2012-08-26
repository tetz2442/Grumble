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
		$sql = "SELECT user_password, user_salt " .
			"FROM users_grumble " .
			"WHERE user_id=" . $_SESSION["user_id"] . " LIMIT 0,1";
		$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
		if(mysql_num_rows($result) != 0) {
			$row = mysql_fetch_array($result);
			$hashed_pass = crypt($currentpass, $row['user_salt']) . $row["user_salt"];
			if($row["user_password"] == $hashed_pass) {
				$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
				$Chars_Len = 63;
				$Salt_Length = 21;
				
				$salt = "";
	
				for($i=0; $i<$Salt_Length; $i++)
				{
					$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
				}
				
				$hashed_password = crypt($changepass, $salt) . $salt;
				//username has changed and password
				$sql = "UPDATE users_grumble SET user_password = '" . $hashed_password . "', user_salt = '" . $salt . "' WHERE user_id = " . $_SESSION["user_id"];
				mysql_query($sql, $conn) or die("Error: " . mysql_error());
					
				echo 2;
			}
			else {
				echo 5;	
			}
		}
		else {
			echo 0;	
		}
	}
	else if(strlen($changepass) > 5 && strlen($changepass2) > 5 && strlen($currentpass) > 5 && $changepass == $changepass2 && $_POST["user"] != $_SESSION["username"]) {
		//insert into users with new passwords, username has changed also
		if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
			$sql = "SELECT user_password, user_salt " .
				"FROM users_grumble " .
				"WHERE user_id=" . $_SESSION["user_id"] . " LIMIT 0,1";
			$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
			
			if(mysql_num_rows($result) != 0) {
				$row = mysql_fetch_array($result);
				$hashed_pass = crypt($currentpass, $row['user_salt']) . $row["user_salt"];
				if($row["user_password"] == $hashed_pass) {
					//remove spaces
					$username = str_replace("\r", "", $username);
					$username = str_replace("\n", "", $username);
					
					$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
					$Chars_Len = 63;
					$Salt_Length = 21;
					
					$salt = "";
		
					for($i=0; $i<$Salt_Length; $i++)
					{
						$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
					}
					
					$hashed_password = crypt($changepass, $salt) . $salt;
					
					//username has changed and password
					$sql = "UPDATE users_grumble SET username = '" . $username . "', user_password = '" . $hashed_password . "', user_salt = '" . $salt . "' WHERE user_id = " . $_SESSION["user_id"];
					mysql_query($sql, $conn) or die("Error: " . mysql_error());
					//set session username
					$_SESSION["username"] = $username;
					//update email settings
					$sql = "UPDATE settings_user_grumble SET settings_email_thread = " . $thread . ", settings_email_comment = " .
					$comment . " WHERE user_id = " . $_SESSION["user_id"];
					mysql_query($sql, $conn) or die("Error: " . mysql_error());
					echo 4;
				}
				else {
					echo 5;	
				}
			}
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
		echo 3;
	}
	else if($_POST["user"] != $_SESSION["username"]) {
		if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
			//remove spaces
			$username = str_replace("\r", "", $username);
			$username = str_replace("\n", "", $username);
					
			//username has changed
			$sql = "UPDATE users_grumble SET username = '" . $username . "' WHERE user_id = " . $_SESSION["user_id"];
			mysql_query($sql, $conn) or die("Error: " . mysql_error());
			//set session username
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