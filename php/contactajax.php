<?php
	require_once "conn.php";
	if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"]) && isset($_POST["type"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		//get the passed parameter
		$name = mysql_real_escape_string(strip_tags($_POST["name"]));
		$email = mysql_real_escape_string(strip_tags($_POST["email"]));
		$message = mysql_real_escape_string(strip_tags($_POST["message"]));
		$type = mysql_real_escape_string(strip_tags($_POST["type"]));
		//check if fields are too long
		if(strlen($name) < 50 || strlen($email) < 255 || strlen($message) < 255) {
			//send a request to the database
			$sql = "INSERT INTO contact_grumble(contact_name, contact_email, contact_message, contact_message_type, contact_create)" . 
			" VALUES ('" . $name . "','" . $email . "','" . $message . "','" . $type . "','" . date("Y-m-d H:i:s", time()) . "')";
			mysql_query($sql, $conn) or die("Could not insert: " . mysql_error());
			
			echo 1;
		}
		else {
			echo 0;	
		}
	}
	else if(isset($_POST["username"]) && isset($_POST["message"]) && isset($_POST["type"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		//get the passed parameter
		$username = mysql_real_escape_string(strip_tags($_POST["username"]));
		$message = mysql_real_escape_string(strip_tags($_POST["message"]));
		$type = mysql_real_escape_string(strip_tags($_POST["type"]));
		
		//check if fields are too long
		if(strlen($message) < 255) {
			//get user info from user table
			$sql = "SELECT user_id,user_email,user_firstname FROM users_grumble WHERE username = '" . $username . "'";;
			$result = mysql_query($sql, $conn) or die("Could not get user info: " . mysql_error());
			$row = mysql_fetch_array($result);
			
			//send a request to the database
			$sql = "INSERT INTO contact_grumble(contact_user_id, contact_name, contact_email, contact_message, contact_message_type, contact_create)" . 
			" VALUES (" . $row["user_id"] . ",'" . $row["user_firstname"]. "','" . $row["user_email"] . "','" . $message . "','" . $type . "','" . date("Y-m-d H:i:s", time()) . "')";
			mysql_query($sql, $conn) or die("Could not subscribe: " . mysql_error());
			
			echo 1;
		}
		else {
			echo 0;	
		}
	}
	else {
		echo 0;	
	}
?>