<?php
function outputNotifications($result) {
	if(mysql_num_rows($result) != 0) {
    	while($row = mysql_fetch_array($result)) {
    		$formatted_date = convertToTimeZone($row["notification_created"], $_SESSION["timezone"]);
    		if($row["notification_read"] == 0) {
				echo '<li data-id="' . $row["notification_id"] .'" class="ind-notification">';
					echo '<a href="' . $row["notification_url"] . '" class="colored-link-1 highlight">' . $row["notification_message"];
					echo '<small>' . $formatted_date . '</small>'. '</a>';
				echo '</li>';
			}
			else {
				echo '<li data-id="' . $row["notification_id"] .'" class="ind-notification">';
					echo '<a href="' . $row["notification_url"] . '" class="colored-link-1">' . $row["notification_message"];
					echo '<small>' . $formatted_date . '</small>'. '</a>';
				echo '</li>';
			}
		}
	}
}
?>