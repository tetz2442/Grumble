<?php
function outputcontact($id) {
	global $conn;
	$sql = "SELECT contact_id, contact_email, contact_message_type, contact_message, contact_name FROM " .
	"contact_grumble WHERE contact_id = " . $id . " LIMIT 1";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());

	if($row = mysql_fetch_array($result)) {
		echo '<div class="contact-message">';
		echo '<h4>' . $row["contact_message_type"] . '</h4>';
		echo '<p><strong>' . $row["contact_name"] . " - " . $row["contact_email"] . '</strong></p>';
		echo '<p class="contact-text">' . stripslashes($row["contact_message"]) . '</p>';
		echo '<p class="contact-options" data-id="' . $row["contact_id"] . '"><a href="#">Resolved</a><a href="#">Delete</a><a href="#">Contact User</a></p>';
		echo '</div>';
	}
}
?>