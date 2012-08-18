<?php
	require_once "conn.php";
	if(isset($_POST["name"]) && isset($_POST["email"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		//get the passed parameter
		$name = mysql_real_escape_string($_POST["name"]);
		$email = mysql_real_escape_string($_POST["email"]);
		//check if fields are too long
		if(strlen($name) < 50 || strlen($email) < 100) {
			//send a request to the database
			$sql = "INSERT INTO coming_soon(soon_name, soon_email) VALUES ('" . $name . "','" . $email . "')";
			$result = mysql_query($sql, $conn) or die("Could not subscribe: " . mysql_error());
			
			$name = $name;
			$subject = "Grumble [Subscribed]";
			
			$fullMessage = "Thanks for subscribing to Grumble " . $name . "!\n\n" . 
			"We will be sure to let you know when we get things up and running at Grumble.  We are as excited as you and can't wait to see where things go." . 
			"\n\nThanks,\nThe Grumble Team";
			
			if(mail($email, $subject, $fullMessage, "From: no-reply@grumbleonline.com")) {
				//mailed
			}
			else {
				//failed to mail
			}
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