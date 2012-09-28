<?php
	require_once "conn.php";
	require_once "functions.php";
	require_once "notifications.php";
	require_once "outputcomments.php";
	session_start();
	setTimezone();
	//code for inserting a new comment on a grumble
	if(isset($_POST["comment"]) && strlen($_POST["comment"]) > 0 && strlen($_POST["comment"]) <= 400 && isset($_POST["category"]) && is_numeric($_POST["category"]) && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		$comment = escapeAndStrip($_POST["comment"]);
		$category = escapeAndStrip($_POST["category"]);
		
		$sql = "SELECT sub_category_id FROM sub_category_grumble WHERE sub_category_id = " . $category . " LIMIT 0,1";
		$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
		//check if the entered category is valid
		if(mysql_num_rows($result) != 0) {
			//remove spaces
			$comment = str_replace("\r", "", $comment);
			$comment = str_replace("\n", "", $comment);
			
			$sql = "SELECT status_id FROM status_grumble WHERE sub_category_id = " . $category .
			" AND status_text = '" . $comment . "' AND date_submitted >= (UTC_TIMESTAMP() - INTERVAL 2 MINUTE) LIMIT 0,1";
			
			$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
			//check if comment was already submitted
			if(mysql_num_rows($result) != 1) {
				//validate grumble length is less than 160 with URL or without
				/*$url = "";
				$urlpresent = preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%g', $comment, $matches);
				if(strlen($comment) <= 160) {
					
				}
				else if($urlpresent == 1 && strlen($comment) > 160) {
					$url = $matches[1] . $matches[2];
					echo $url;
				}
				else {
					echo 0;
				}*/
				
				$sql = "INSERT INTO status_grumble " .
					"(status_text, sub_category_id, date_submitted, user_id) " .
					"VALUES ('" . $comment . "'," . $category . 
					",UTC_TIMESTAMP()," . $_SESSION["user_id"] . ")"; 
				mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
				$last_id_status = mysql_insert_id();	
				
				$sql =  "UPDATE sub_category_grumble SET grumble_number = grumble_number + 1 WHERE sub_category_id = " . $category;
				mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
				
				$sql =  "SELECT scg.sub_category_url, cg.category_url, COUNT(sg.status_id) AS grumble_number, ug.user_email, ug.username, ug.user_id FROM status_grumble AS sg " .
				"LEFT OUTER JOIN sub_category_grumble AS scg ON scg.sub_category_id = sg.sub_category_id " .
				"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = scg.user_id " .
				"LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id " .
				"LEFT OUTER JOIN settings_user_grumble AS sug ON sug.user_id = ug.user_id " .
				"WHERE sg.sub_category_id = " . $category . " AND sug.settings_email_thread = 1 LIMIT 0,1";
				$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
				$row = mysql_fetch_array($result);
				//if grumble number is divisible by 15, send email
				if(mysql_num_rows($result) != 0 && $row["grumble_number"] % 15 == 0 && $row["grumble_number"] != 0) {
					$parameters = array($row["grumble_number"], "http://" . $_SERVER["HTTP_HOST"] . "/" . $row["category_url"] . "/" . $row["sub_category_url"] . "/" . $category, $row["username"]);
					sendEmail($row["user_email"], "no-reply@grumbleonline.com", "grumble", $parameters);
				}
				//insert a new notification
				if($_SESSION["user_id"] != $row["user_id"]) {
					insertNotification($row["user_id"], $_SESSION["user_id"], $_SESSION["username"], "http://" . $_SERVER["HTTP_HOST"] . "/" . $row["category_url"] . "/" . $row["sub_category_url"] . "/" . $category, "comment");
				}
				
				outputComments($last_id_status, false, true);
			}
			else {
				echo 1;
			}
		}
		else {
			echo 0;
		}
	}
	
	//code for handing deletion of a grumble
	if(isset($_POST["commentid"]) && is_numeric($_POST["commentid"]) && isset($_POST["action"]) && $_POST["action"] == "Delete" && isset($_SESSION["username"])) {
		$id = mysql_real_escape_string($_POST["commentid"]);
		
		//check if status is there and user is owner
		$sql = "SELECT ug.username, sg.status_id, sg.sub_category_id FROM status_grumble AS sg " .
		"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sg.user_id " . 
		"WHERE sg.status_id = " . $id . " LIMIT 0,1";
		$result = mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
		if(mysql_num_rows($result) != 0) {
			$row = mysql_fetch_array($result);
			if($row["username"] == $_SESSION["username"]) {
				//delete everything associated with grumble (grumble, comments, votes)
				$sql = "DELETE FROM status_grumble WHERE status_id = " . $id . " LIMIT 1";
				mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
				$sql = "DELETE FROM replies_grumble WHERE status_id = " . $id;
				mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
				$sql = "DELETE FROM user_likes_grumble WHERE status_id = " . $id;
				mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
				$sql =  "UPDATE sub_category_grumble SET grumble_number = grumble_number - 1 WHERE sub_category_id = " . $row["sub_category_id"];
				mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
				
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
    else if(isset($_POST["commentid"]) && is_numeric($_POST["commentid"]) && isset($_POST["action"]) && $_POST["action"] == "Spam" && isset($_SESSION["username"])) {
		$id = mysql_real_escape_string($_POST["commentid"]);
		
		$sql = "SELECT spam_id FROM spam_grumble WHERE status_id = " . $id;
		$result = mysql_query($sql, $conn) or die("Could not spam: " . mysql_error());
		if(mysql_num_rows($result) == 0) {
			//insert into spam table
			$sql = "INSERT INTO spam_grumble(status_id, spam_report_number) VALUES(" . $id . ", 1)";
			mysql_query($sql, $conn) or die("Could not spam: " . mysql_error());
		}
		else {
			//row already exists, update
			$sql = "UPDATE spam_grumble SET spam_report_number = spam_report_number + 1 WHERE status_id = " . $id;
			mysql_query($sql, $conn) or die("Could not spam: " . mysql_error());
		}
		echo 1;
	}
	else if(isset($_POST["commentid"]) && is_numeric($_POST["commentid"]) && isset($_POST["action"]) && $_POST["action"] == "Remove" && isset($_SESSION["username"]) && $_SESSION["access_lvl"] == 3) {
		$id = mysql_real_escape_string($_POST["commentid"]);
		
		$sql = "SELECT spam_id FROM spam_grumble WHERE status_id = " . $id;
		$result = mysql_query($sql, $conn) or die("Could not spam: " . mysql_error());
		if(mysql_num_rows($result) != 0) {
			$row = mysql_fetch_array($result);
			$sql = "DELETE FROM spam_grumble WHERE spam_id = " . $row["spam_id"] . " LIMIT 1";
			mysql_query($sql, $conn) or die("Could not spam: " . mysql_error());
			echo 1;
		}
	}
?>