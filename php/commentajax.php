<?php
	require_once "conn.php";
	require_once "timeago.php";
	require_once "outputcomments.php";
	require_once "sendemail.php";
	session_start();
	if(isset($_POST["comment"]) && strlen($_POST["comment"]) > 0 && strlen($_POST["comment"]) <= 400 && isset($_POST["category"]) && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		date_default_timezone_set($_SESSION["timezone"]);
		$comment = mysql_real_escape_string(strip_tags($_POST["comment"]));
		$category = mysql_real_escape_string(strip_tags($_POST["category"]));
		
		$sql = "SELECT sub_category_id FROM sub_category_grumble WHERE sub_category_id = " . $category . " LIMIT 0,1";
		$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
		//check if the entered category is valid
		if(mysql_num_rows($result) != 0) {
			//remove spaces
			$comment = str_replace("\r", "", $comment);
			$comment = str_replace("\n", "", $comment);
			
			//validate grumble length is less than 160 with URL
			/*if(preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $url) == 0 && strlen($comment) <= 160) {
				
			}
			else if(preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $url) && strlen($comment) > 160) {
				
			}
			else {
				echo 0;
			}*/
			
			$sql = "INSERT INTO status_grumble " .
				"(status_text, sub_category_id, date_submitted, user_id) " .
				"VALUES ('" . $comment . "'," . $category . 
				",'" . date("Y-m-d H:i:s", time()) . 
				"'," . $_SESSION["user_id"] . ")"; 
			mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
			$last_id_status = mysql_insert_id();	
			
			$sql =  "UPDATE sub_category_grumble SET grumble_number = grumble_number + 1 WHERE sub_category_id = " . $category;
			mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
				
			/*$sql = "INSERT INTO votes_up_grumble " . 
				"(status_id) VALUES (" . $last_id_status . ")";
			mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());*/
			
			$sql =  "SELECT scg.sub_category_url, cg.category_url, COUNT(sg.status_id) AS grumble_number, ug.user_email, ug.username FROM status_grumble AS sg " .
			"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sg.user_id " .
			"LEFT OUTER JOIN sub_category_grumble AS scg ON scg.sub_category_id = sg.sub_category_id " .
			"LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id " .
			"LEFT OUTER JOIN settings_user_grumble AS sug ON sug.user_id = ug.user_id " .
			"WHERE sg.sub_category_id = " . $category . " AND sug.settings_email_thread = 1 LIMIT 0,1";
			$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
			
			if(mysql_num_rows($result) != 0) {
				$row = mysql_fetch_array($result);
				$parameters = array($row["grumble_number"], "http://" . $_SERVER["HTTP_HOST"] . "/" . $row["category_url"] . "/" . $row["sub_category_url"] . "/" . $category, $row["username"]);
				sendEmail($row["user_email"], "From: no-reply@grumbleonline.com", "grumble", $parameters);
			}
			
			outputComments($last_id_status, false, true);
		}
		else {
			echo 0;
		}
	}
	
	//code for handing deletion of a grumble
	if(isset($_POST["commentid"]) && isset($_POST["action"]) && $_POST["action"] == "Delete" && isset($_SESSION["username"])) {
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
				$sql = "DELETE FROM comments_grumble WHERE status_id = " . $id;
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
?>