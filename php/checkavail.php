<?php
	require_once "conn.php";
	require_once "functions.php";
	if(isset($_POST["username"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		//get the passed parameter
		$username = mysql_real_escape_string($_POST["username"]);
		$username = str_replace(" ", "", $username);
		
		//check if username is allowed
		if(checkUsername($username)) {
			//send a request to the database
			$sql = "SELECT username FROM users_grumble WHERE LOWER(username) = '" . strtolower($username) . "'";
			$result = mysql_query($sql, $conn) or die("Could not get username: " . mysql_error());
			
			if(mysql_num_rows($result) > 0) {
				//email is already taken
				echo 0;
			}
			else {
				//email is available
				echo 1;
			}
		}
		else {
			echo 0;
		}
	}
	else if(isset($_POST["email"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		//get the passed parameter
		$email = mysql_real_escape_string(strtolower($_POST["email"]));
		
		//send a request to the database
		$sql = "SELECT user_email FROM users_grumble WHERE LOWER(user_email) = '" . $email . "'";
		$result = mysql_query($sql, $conn) or die("Could not get email: " . mysql_error());
		
		if(mysql_num_rows($result) > 0) {
			//email is already taken
			echo 0;
		}
		else {
			//email is available
			echo 1;
		}
	}
	else {
		echo 0;	
	}
?>