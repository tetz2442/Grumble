<?php
	require_once "conn.php";
	require_once "timeago.php";
	require_once "outputgrumbles.php";
	require_once "sendemail.php";
	
	session_start();
	if(isset($_POST["grumble"]) && strlen($_POST["grumble"]) > 0 && strlen($_POST["grumble"]) <= 400 && isset($_POST["category"]) && isset($_SESSION["user_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		
		$grumble = mysql_real_escape_string(strip_tags($_POST["grumble"]));
		$category = mysql_real_escape_string(strip_tags($_POST["category"]));
		
		$sql = "SELECT sub_category_id FROM sub_category_grumble WHERE sub_category_id = " . $category . " LIMIT 0,1";
		$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
		//check if the entered category is valid
		if(mysql_num_rows($result) != 0) {
			//remove spaces
			$grumble = str_replace("\r", "", $grumble);
			$grumble = str_replace("\n", "", $grumble);
			
			$sql = "INSERT INTO status_grumble " .
				"(status_text, sub_category_id, date_submitted, user_id) " .
				"VALUES ('" . $grumble . "'," . $category . 
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
				sendEmail($row["user_email"], "From: no-reply@grumbleonline.com", "thread", $parameters);
			}
			
			outputGrumbles($last_id_status, false, true);
		}
		else {
			echo 0;
		}
	}
	else {
		echo 0;
	}
?>