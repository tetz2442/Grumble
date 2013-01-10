<?php
require_once "conn.php";
require_once "functions.php";
session_start();
/*
return
0 - error
1 - username changed
2 - password changed
3 - email settings changed
4 - timezone changed
5 - current passord invalid
6 - 
*/
//username changed
if(isset($_POST["user"]) && isset($_POST["username"]) && $_SESSION["username"] == $_POST["username"] && $_SERVER['REQUEST_METHOD'] == "POST") {
	$username = mysql_real_escape_string($_POST["user"]);
	if($_POST["user"] != $_SESSION["username"]) {
		if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
			//check if the username has been taken (user could have falsified)
			$sql = "SELECT username FROM users_grumble WHERE LOWER(username) = '" . strtolower($username) . "'";
			$result = mysql_query($sql, $conn) or die("Could not get username: " . mysql_error());
			if(mysql_num_rows($result) == 0) {
				//remove spaces
				$username = str_replace("\r", "", $username);
				$username = str_replace("\n", "", $username);
						
				//username has changed
				$sql = "UPDATE users_grumble SET username = '" . $username . "' WHERE user_id = " . $_SESSION["user_id"];
				mysql_query($sql, $conn) or die("Error: " . mysql_error());
				//set session username
				$_SESSION["username"] = $username;
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
	else {
		echo 0;	
	}
}
//email settings changed
else if(isset($_POST["username"]) && isset($_POST["threadcheck"]) && $_SESSION["username"] == $_POST["username"] && $_SERVER['REQUEST_METHOD'] == "POST") {
	if($_POST["threadcheck"] == "true")
		$thread = 1;
	else
		$thread = 0;

	//username has not changed, insert email settings
	$sql = "UPDATE settings_user_grumble SET settings_email_thread = " . $thread . " WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Error: " . mysql_error());
	echo 3;
}
//pasword changed
else if(isset($_POST["username"]) && isset($_POST["currentpass"]) && $_SESSION["username"] == $_POST["username"] && isset($_POST["newpass"])
 && isset($_POST["newpass2"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	$currentpass = mysql_real_escape_string($_POST["currentpass"]);
	$changepass = mysql_real_escape_string($_POST["newpass"]);
	$changepass2 = mysql_real_escape_string($_POST["newpass2"]);

	if(strlen($changepass) > 5 && strlen($changepass2) > 5 && strlen($currentpass) > 5 && $changepass == $changepass2) {
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
}
//timezone changed
else if(isset($_POST["username"]) && $_SESSION["username"] == $_POST["username"] && isset($_POST["timezone"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	$timezone = mysql_real_escape_string($_POST["timezone"]);

	if(checkTimeZone($timezone)) {
		$sql = "UPDATE users_grumble SET user_timezone = '" . $timezone . "' WHERE user_id = " . $_SESSION["user_id"];
		mysql_query($sql, $conn) or die("Error: " . mysql_error());
		$_SESSION["timezone"] = $timezone;
		echo 4;
	}
	else {
		echo 0;
	}
}

/*
 * User wants to delete their account
 */
if(isset($_POST["action"]) && $_POST["action"] == "Delete" && isset($_SESSION["user_id"])) {
	//delete notifications
	$sql = "DELETE FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//delete grumbles (comments, replies, likes with each)
	$sql = "SELECT sub_category_id FROM sub_category_grumble WHERE user_id = " . $_SESSION["user_id"];
	$result = mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//loop through each Grumble
	while($row = mysql_fetch_array($result)) {
		$id = $row["sub_category_id"];
		//delete likes
		$sql = "DELETE FROM user_grumble_likes WHERE sub_category_id = " . $id;
		mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
		//select all statuses that are linked to Grumble
		$sql = "SELECT status_id FROM status_grumble WHERE sub_category_id = " . $id;
		$result = mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
		while($row = mysql_fetch_array($result)) {
			//delete comments (replies, votes up)
			$sql = "DELETE FROM status_grumble WHERE status_id = " . $row["status_id"] . " LIMIT 1";
			mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
			$sql = "DELETE FROM replies_grumble WHERE status_id = " . $row["status_id"];
			mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
			$sql = "DELETE FROM user_likes_grumble WHERE status_id = " . $row["status_id"];
			mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
		}
	}
	//delete grumbles
	$sql = "DELETE FROM sub_category_grumble WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	
	//delete comments
	$sql = "DELETE FROM status_grumble WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//delete replies
	$sql = "DELETE FROM replies_grumble WHERE reply_user = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//delete contact messages
	$sql = "DELETE FROM contact_grumble WHERE contact_user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//delete (grumble (grumble votes))
	$sql = "DELETE FROM authentications WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//delete cookies
	$sql = "DELETE FROM cookies_grumble WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//delete from users
	$sql = "DELETE FROM users_grumble WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	//delete settings
	$sql = "DELETE FROM settings_user_grumble WHERE user_id = " . $_SESSION["user_id"];
	mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
	
	//destry session and log user out
	if(isset($_COOKIE["user_grumble"]) && isset($_COOKIE["cookie_id"])) {
		$sql = "DELETE FROM cookies_grumble WHERE cookie_id = " . $_COOKIE["cookie_id"] . " AND cookie_text = '" . $_COOKIE["user_grumble"] . "'";
		mysql_query($sql, $conn) or die("Error, could not logout: " . mysql_error());
		setcookie("user_grumble","", time()-7*24*60*60, "/", $_SERVER['HTTP_HOST']);
		setcookie("cookie_id","", time()-7*24*60*60, "/", $_SERVER['HTTP_HOST']);
	}
	//if logged in socially, destroy session
	if(isset($_SESSION["social"])) {
		$config = dirname(__FILE__) . '/hybridauth/config.php';
	    require_once( "hybridauth//Hybrid/Auth.php" );
	    try{
	       // initialize Hybrid_Auth with a given file
	       $hybridauth = new Hybrid_Auth( $config );
	 
	       // try to authenticate with the selected provider
	       $adapter = $hybridauth->authenticate( $_SESSION["social"]);
	 
	       $adapter->logout();
	    }
	    catch( Exception $e ){
	       echo "Error: " . $e->getMessage();
	    }
	}
	
	session_unset();
	session_destroy();
	//success
	echo 1;
}
/*if(isset($_POST["user"]) && isset($_POST["username"]) && isset($_POST["threadcheck"]) && isset($_POST["commentcheck"]) && isset($_POST["currentpass"]) && isset($_POST["newpass"])
 && isset($_POST["newpass2"]) && isset($_SESSION["username"]) && $_SESSION["username"] == $_POST["username"] && isset($_POST["timezone"]) && isset($_POST["changes"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	//everything has changed
	if ($changes[0] == true && $changes[1] == true && $changes[2] == true && $changes[3] == true) {
		if(strlen($changepass) > 5 && strlen($changepass2) > 5 && strlen($currentpass) > 5 && $changepass == $changepass2 && $_POST["user"] != $_SESSION["username"]) {
		//insert into users with new passwords, username has changed also
		if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
			//check if the username has been taken (user could have falsified)
			$sql = "SELECT username FROM users_grumble WHERE LOWER(username) = '" . strtolower($username) . "'";
			$result = mysql_query($sql, $conn) or die("Could not get username: " . mysql_error());
			if(mysql_num_rows($result) == 0) {
				$sql = "SELECT user_password, user_salt " .
					"FROM users_grumble " .
					"WHERE user_id=" . $_SESSION["user_id"] . " LIMIT 0,1";
				$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
				
				if(mysql_num_rows($result) != 0) {
					$row = mysql_fetch_array($result);
					$hashed_pass = crypt($currentpass, $row['user_salt']) . $row["user_salt"];
					if($row["user_password"] == $hashed_pass) {
						//check if timezone is valid
						if(checkTimeZone($timezone)) {
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
							$sql = "UPDATE users_grumble SET username = '" . $username . "', user_password = '" . $hashed_password . "', user_salt = '" . $salt . "', user_timezone = '" . $timezone . "' WHERE user_id = " . $_SESSION["user_id"];
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
							echo 0;
						}
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
		else {
			echo 0;
		}
	} 
	//username has changed
	else if($changes[0] == true) {
		if($_POST["user"] != $_SESSION["username"]) {
			if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
				//check if the username has been taken (user could have falsified)
				$sql = "SELECT username FROM users_grumble WHERE LOWER(username) = '" . strtolower($username) . "'";
				$result = mysql_query($sql, $conn) or die("Could not get username: " . mysql_error());
				if(mysql_num_rows($result) == 0) {
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
		else {
			echo 0;	
		}
	}
	//email settings have changed
	else if ($changes[1] == true) {
		if($_POST["user"] == $_SESSION["username"]) {
			//username has not changed, insert email settings
			$sql = "UPDATE settings_user_grumble SET settings_email_thread = " . $thread . ", settings_email_comment = " .
			$comment . " WHERE user_id = " . $_SESSION["user_id"];
			mysql_query($sql, $conn) or die("Error: " . mysql_error());
			echo 3;
		}
	}
	//passwords have changed
	else if($changes[2] == true) {
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
	}
	//timezone has changed
	else if($changes[3] == true) {

	}
}*/
?>