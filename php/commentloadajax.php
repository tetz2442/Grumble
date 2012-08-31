<?php
	require_once "conn.php";
	require_once "timeago.php";
	require_once "outputgrumbles.php";
	
	session_start();
	if(isset($_POST["pagenumber"]) && isset($_POST["number"]) && isset($_POST["subCat"]) && isset($_POST["lastid"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		//get the passed parameter
		$pagenumber = mysql_real_escape_string($_POST["pagenumber"]);
		$number = mysql_real_escape_string($_POST["number"]);
		$subcat = mysql_real_escape_string($_POST["subCat"]);
		$lastid = mysql_real_escape_string($_POST["lastid"]);
		
		//load grumbles from sub category
		if(is_numeric($subcat)) {
			//send a request to the database
			$sql = "SELECT status_id FROM status_grumble " .
			"WHERE sub_category_id = " . $subcat . 
			" AND status_id < " . $lastid . " ORDER BY status_id DESC LIMIT 10";
			$result = mysql_query($sql, $conn) or die("Failed: " . mysql_error());
		}
		//load grumbles for profile
		/*else {
			//send a request to the database
			$sql = "SELECT sg.status_id FROM status_grumble AS sg " .
			"LEFT OUTER JOIN users_grumble AS ug ON sg.user_id = ug.user_id " .
			"WHERE ug.username = '" . $subcat . 
			"' AND sg.status_id < " . $lastid . " ORDER BY sg.status_id DESC LIMIT 10";
			$result = mysql_query($sql, $conn) or die("Failed: " . mysql_error());
		}*/
		
		if(mysql_num_rows($result) > 0) {
			if(isset($_SESSION["user_id"])) {
				while($row = mysql_fetch_array($result)) {
					outputGrumbles($row["status_id"], false, true);	
				}
			}
			else {
				while($row = mysql_fetch_array($result)) {
					outputGrumbles($row["status_id"], false, false);	
				}
			}
		}
		else {
			echo "none";
		}
	}
	else if(isset($_POST["type"]) && isset($_POST["last"]) && isset($_POST["location"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		$last = mysql_real_escape_string($_POST["last"]);
		$type = $_POST["type"];
		
		if($type == "recent-grumble") {
			$sql = "SELECT status_id FROM status_grumble" .
                " WHERE status_id < " . $last . " ORDER BY status_id DESC LIMIT 10";
			$result = mysql_query($sql, $conn);
			if(mysql_num_rows($result) == 0) {
				echo "none";	
			}
			else {
				if(isset($_SESSION["user_id"])) {
					while($row = mysql_fetch_array($result)) {
						outputgrumbles($row["status_id"], false, true);
					}
				}
				else {
					while($row = mysql_fetch_array($result)) {
						outputgrumbles($row["status_id"], false, false);
					}
				}
			}
		}
		else if($type == "top-grumble") {
			$sql = "SELECT sg.status_id FROM status_grumble AS sg " . 
                  "LEFT OUTER JOIN votes_up_grumble AS vg ON sg.status_id = vg.status_id " .
                  "LEFT OUTER JOIN users_grumble AS ug ON " .
                  "sg.user_id = ug.user_id " . 
                  "WHERE date_submitted >= (CURDATE() - INTERVAL 7 DAY) " .
                  "AND vg.votes_up_count > 0 ORDER BY vg.votes_up_count DESC LIMIT 10 OFFSET " . $last;
			$result = mysql_query($sql, $conn);
			if(mysql_num_rows($result) == 0) {
				echo "none";	
			}
			else {
				if(isset($_SESSION["user_id"])) {
					while($row = mysql_fetch_array($result)) {
						outputgrumbles($row["status_id"], false, true);
					}
				}
				else {
					while($row = mysql_fetch_array($result)) {
						outputgrumbles($row["status_id"], false, false);
					}
				}
			}
		}
		else {
			echo "none";	
		}
	}
	else if(isset($_POST["type"]) && isset($_POST["last"]) && isset($_POST["userID"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		$last = mysql_real_escape_string($_POST["last"]);
		$userID = mysql_real_escape_string($_POST["userID"]);
		$type = $_POST["type"];
		
		if($type == "recent-grumble") {
			$sql = "SELECT status_id FROM status_grumble" .
                " WHERE status_id < " . $last . " AND user_id = " . $userID . " ORDER BY status_id DESC LIMIT 10";
				
			$result = mysql_query($sql, $conn);
			if(mysql_num_rows($result) == 0) {
				echo "none";	
			}
			else {
				if(isset($_SESSION["user_id"])) {
					while($row = mysql_fetch_array($result)) {
						outputgrumbles($row["status_id"], false, true);
					}
				}
				else {
					while($row = mysql_fetch_array($result)) {
						outputgrumbles($row["status_id"], false, false);
					}
				}
			}
		}
		else {
			echo "none";	
		}
	}
?>