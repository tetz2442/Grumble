<?php
function outputReplies($result) {
	if(mysql_num_rows($result) != 0) {
		while ($row = mysql_fetch_array($result)) {
			echo '<div class="ind-reply">';
			echo '<div class="reply-padding">';
			echo '<a class="reply-username username" href="/profile/' . $row["username"] . '">' . $row["username"] . '</a>';
			echo '<p class="reply-text">' . stripslashes($row["reply_text"]) . '</p>';
			echo '<small class="reply-time">' . convertToTimeZone($row["reply_date"], $_SESSION["timezone"]) . '</small>';
			echo '<a href="/profile/' . $row["username"] . '"><img class="reply-user-image rounded-corners-medium" src="' . getGravatar($row["user_email"]) . '" width="45" height="45" alt="' .  $row["username"] . '"></a>';
			echo '</div>';
			echo '</div>';
		}
	}
}
?>