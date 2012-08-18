<?php
	require_once "conn.php";
	
	if(isset($_POST["id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		//get the passed parameter
		$id = mysql_real_escape_string($_POST["id"]);
		
		//send a request to the database
		$sql = "SELECT help_callout_title, help_callout_text FROM help_callout_text " .
		"WHERE help_callout_id = " . $id;
		$result = mysql_query($sql, $conn) or die("Failed: " . mysql_error());
		
		if(mysql_num_rows($result) > 0) {
			$row = mysql_fetch_array($result);
			echo '<h3>' . $row["help_callout_title"] . '</h3>';
			echo '<p>' . $row["help_callout_text"] . '</p>';
		}
	}
?>