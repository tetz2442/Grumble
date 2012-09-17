<?php
function outputspam($id) {
	global $conn;
	$sql = "SELECT sg.spam_report_number, sgg.status_id FROM spam_grumble AS sg " .
	"LEFT OUTER JOIN status_grumble as sgg ON sgg.status_id = sg.status_id " .
	"WHERE spam_id = " . $id . " LIMIT 1";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());

	if($row = mysql_fetch_array($result)) {
		echo '<div class="spam-holder">';
		echo '<h4>Spam count - ' . $row["spam_report_number"] . '</h4>';
		echo '</div>';
		outputComments($row["status_id"], false, true, true);
	}
}
?>