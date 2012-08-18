<?php
function grumbleOfTheDay() {
	global $conn;
	//grumble of the day selector
	$sql = "SELECT sg.status_text, DATE_FORMAT(sg.date_submitted, '%b %e, %Y %l:%i %p') AS date_submitted, " . 
		  "ug.username, vg.votes_up_count FROM status_grumble AS sg " . 
		  "LEFT OUTER JOIN votes_up_grumble AS vg ON sg.status_id = vg.status_id " .
		  "LEFT OUTER JOIN users_grumble AS ug ON " .
		  "sg.user_id = ug.user_id " . 
		  "WHERE sg.sub_category_id = " . mysql_real_escape_string($_GET["subcat"]) . 
		   " AND date_submitted >= (CURDATE() - INTERVAL 1 DAY) ORDER BY vg.votes_up_count DESC LIMIT 1";	
	$result2 = mysql_query($sql, $conn);
	if($row = mysql_fetch_array($result2)) {
		if($row["votes_up_count"] != 0) {
			echo '<div class="grumble-holder-top">';
			echo '<div id="top-grumble">';
			echo '<h2>Grumble of the day</h2>';
			echo '</div>';
			echo '<div class="img-grumble-holder">';
			echo '<div class="image-holder">';
			echo '</div>';
			echo '<div class="user-grumble">';
			echo '<a href="profile.php?id=' . $row["username"] . '"><strong class="username">' . $row["username"] . '</strong></a>';
			echo '<p class="grumble-text">' . $row["status_text"] . '</p>';
			echo '<small class="grumble-time">' . $row["date_submitted"] . '</small>';
			echo '</div>';
			echo '<div id="top-grumble-votes">';
			echo '<div id="top-votes-header">Votes up</div>';
			echo '<div id="top-votes-count">' . $row["votes_up_count"] . '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
}
?>