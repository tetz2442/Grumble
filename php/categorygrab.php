<?php
require_once "conn.php";
require_once "functions.php";
require_once "outputgrumbles.php";

if(isset($_POST["catID"]) && is_numeric($_POST["catID"]) && isset($_POST["type"]) && isset($_POST["last"]) && is_numeric($_POST["last"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	
	$catid = escape($_POST["catID"]);
	$last = escape($_POST["last"]);
	
	if($_POST["type"] == "recent") {
		$sql = "SELECT sub_category_id FROM sub_category_grumble" .
		" WHERE category_id = " . $catid . " AND sub_category_id < " . $last . " ORDER BY sub_category_id DESC LIMIT 10";
		$result = mysql_query($sql, $conn);
		if(mysql_num_rows($result) == 0) {
			echo "none";	
		}
		else {
			while($row = mysql_fetch_array($result)) {
				outputGrumbles($row["sub_category_id"]);
			}
		}
	}
	else if($_POST["type"] == "top") {
		//$sql = "SELECT sub_category_id FROM sub_category_grumble" .
		//	" WHERE category_id = " . $catid . " AND grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10 OFFSET " . $last;
		$sql = "SELECT sub_category_id, " . 
        "((SELECT COUNT(DISTINCT ugl.grumble_like_id) FROM user_grumble_likes AS ugl WHERE ugl.sub_category_id = scg.sub_category_id) + " . 
        "(SELECT COUNT(DISTINCT sg.status_id) FROM status_grumble AS sg WHERE sg.sub_category_id = scg.sub_category_id)) AS grumble_number" . 
        " FROM sub_category_grumble AS scg" .
        " WHERE category_id = " . $catid. " HAVING grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10 OFFSET " . $last;
		$result = mysql_query($sql, $conn);
		if(mysql_num_rows($result) == 0) {
			echo "noner";	
		}
		else {
			while($row = mysql_fetch_array($result)) {
				outputGrumbles($row["sub_category_id"]);
			}
		}
	}
	else
		echo "none";
}
else if(isset($_POST["type"]) && isset($_POST["last"]) && is_numeric($_POST["last"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	$last = intval(mysql_real_escape_string($_POST["last"]));
	
	if($_POST["type"] == "recent") {
		$sql = "SELECT sub_category_id FROM sub_category_grumble" .
            " WHERE sub_category_id < " . $last . " ORDER BY sub_category_id DESC LIMIT 10";
		$result = mysql_query($sql, $conn);
		if(mysql_num_rows($result) == 0) {
			echo "none";	
		}
		else {
			while($row = mysql_fetch_array($result)) {
				outputGrumbles($row["sub_category_id"], true);
			}
		}
	}
	else if($_POST["type"] == "top") {
		//$sql = "SELECT sub_category_id FROM sub_category_grumble" .
       //         " WHERE grumble_number > 0 && sub_category_created >= (UTC_TIMESTAMP() - INTERVAL 4 DAY) ORDER BY grumble_number DESC LIMIT 10 OFFSET " .$last;
		$sql = "SELECT sub_category_id, " . 
        "((SELECT COUNT(DISTINCT ugl.grumble_like_id) FROM user_grumble_likes AS ugl WHERE ugl.sub_category_id = scg.sub_category_id) + " . 
        "(SELECT COUNT(DISTINCT sg.status_id) FROM status_grumble AS sg WHERE sg.sub_category_id = scg.sub_category_id)) AS grumble_number" . 
        " FROM sub_category_grumble AS scg" .
        " WHERE sub_category_created >= (UTC_TIMESTAMP() - INTERVAL 4 DAY) HAVING grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10 OFFSET " . $last;
		$result = mysql_query($sql, $conn);
		if(mysql_num_rows($result) == 0) {
			echo "none";	
		}
		else {
			while($row = mysql_fetch_array($result)) {
				outputGrumbles($row["sub_category_id"], true);
			}
		}
	}
	else
		echo "none";
}
else if(isset($_POST["type"]) && isset($_POST["last"]) && isset($_POST["userID"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	$last = mysql_real_escape_string($_POST["last"]);
	$userID = mysql_real_escape_string($_POST["userID"]);
	
	if($_POST["type"] == "recent") {
		$sql = "SELECT sub_category_id FROM sub_category_grumble" .
            " WHERE sub_category_id < " . $last . " AND user_id = " . $userID . "  ORDER BY sub_category_id DESC LIMIT 10";
		$result = mysql_query($sql, $conn);
		if(mysql_num_rows($result) == 0) {
			echo "none";	
		}
		else {
			while($row = mysql_fetch_array($result)) {
				outputGrumbles($row["sub_category_id"], true);
			}
		}
	}
	else
		echo "none";
}
?>