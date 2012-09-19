<?php
function outputComments($grumble, $comments = false, $loggedin = false, $admin = false) {
	global $conn;
	if($grumble) {
		if (isset($_SESSION["timezone"])) {
			date_default_timezone_set($_SESSION["timezone"]);
		}

		$sql = "SELECT sg.status_id, sg.status_text, ug.username, sg.date_submitted, " . 
			"ug.user_id, ug.username, COUNT(user_like_id) AS votes_up_count FROM status_grumble AS sg " . 
			"LEFT OUTER JOIN user_likes_grumble AS vg ON sg.status_id = vg.status_id " .
			"LEFT OUTER JOIN users_grumble AS ug ON " .
			"sg.user_id = ug.user_id " . 
			"WHERE sg.status_id = " . $grumble . 
			" LIMIT 0, 1";	
		$result = mysql_query($sql, $conn) or die("Error" . mysql_error());
		if($row = mysql_fetch_array($result)) {
			if(isset($_SESSION["user_id"])) {
				//check if the user has already liked this status
				$sql = "SELECT user_like_id FROM user_likes_grumble " .
					"WHERE status_id = " . $row["status_id"] . " AND " . 
					"user_id = " . $_SESSION["user_id"];
				$result2 = mysql_query($sql, $conn);
			}
			
			echo '<div class="comment-holder">';
			
				echo '<div class="comment-inner-holder">';
					echo '<div class="comment-header">';
						echo '<a href="/profile/' . $row["username"] . '" data-id="' . $row["status_id"] . '" class="username" title="Visit profile"><strong>' . $row["username"] . '</strong></a>';
						if (isset($_SESSION["timezone"])) {
							$formatted_date = convertToTimeZone($row["date_submitted"], $_SESSION["timezone"]);
							//Sep 10, 2012 1:35 PM
							echo '<span class="comment-time" title="' . $formatted_date . '"><a href="/profile/' . $row["username"] . '/comment/' . $row["status_id"] . '" class="colored-link-1">' . time_ago($formatted_date) . '</a></span>';
						}
						else if(isset($_SESSION["time"])) {
							$formatted_date = convertToTimeZone($row["date_submitted"], $_SESSION["time"]);
							//Sep 10, 2012 1:35 PM
							echo '<span class="comment-time" title="' . $formatted_date . '"><a href="/profile/' . $row["username"] . '/comment/' . $row["status_id"] . '" class="colored-link-1">' . time_ago($formatted_date) . '</a></span>';
						}
					echo '</div>';
					echo '<div class="comment-text-holder">';
						echo '<p class="comment-text">' . stripslashes($row["status_text"]) . '</p>';
					echo '</div>';
					echo '<div class="embed-link"></div>';
				echo '</div>';
			echo '<div class="comment-extras">';
			if(isset($_SESSION["username"]) && $_SESSION["username"] == $row["username"] || $admin) {
				echo '<div class="comment-options">';
				echo '<p class="comment-delete" title="Delete this Comment">Delete</p>';
				if($admin) {
					echo '<p class="comment-remove" title="Remove this comment from the spam list">Remove</p>';
				}
				echo '</div>';
			}
			else if(isset($_SESSION["username"])) {
				echo '<div class="comment-options">';
				echo '<p class="comment-spam" title="Report this comment as spam">Spam</p>';
				echo '</div>';
			}
			echo '<div class="comment-votes">';
			if(isset($_SESSION["user_id"])) {
					//get the number of comments from the db
					$sql = "SELECT COUNT(*) FROM replies_grumble WHERE status_id = " . $grumble;
					$commentcount = mysql_query($sql, $conn);
					$row3 = mysql_fetch_array($commentcount);
					if($comments) {
						echo '<p class="gif-loader-replies"><img src="/images/ajax-loader.gif" alt="loader" width="16" height="16"/></p><p class="replies-view" data-id="' . $row["status_id"] . '" data-html="Replies" data-replies="' . $row3[0] . '" title="View/Add replies on this comment">Replies';
						if($row3[0] >= 1)
							echo '<img src="/images/balloons.png" alt="View Replies" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
						else 
							echo '<img src="/images/balloon.png" alt="View Replies" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
					}
					else {
						echo '<p class="gif-loader-replies"><img src="/images/ajax-loader.gif" alt="loader" width="16" height="16"/></p><p class="replies-view" data-id="' . $row["status_id"] . '" data-html="Replies" data-replies="' . $row3[0] . '" title="View/Add replies on this comment"><a>Replies</a>';
						if($row3[0] > 1)
							echo '<img src="/images/balloons.png" alt="View Replies" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
						else 
							echo '<img src="/images/balloon.png" alt="View Reply" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
					}
			}
			if((isset($result2) && $row2 = mysql_fetch_array($result2))) {
				echo '<p class="votes-up" title="You have already voted up">Votes up<img src="/images/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/><span class="votes-up-number">(' . $row["votes_up_count"] . ')</span></p>';
			}
			else if(!isset($_SESSION["user_id"])) {
				echo '<p class="votes-up" title="You must log in to vote up">' . $row["votes_up_count"] . ' Vote(s) up</p>';
			}
			else {
				echo '<p class="votes-up" title="Vote this grumble up"><a data-id="' . $row["status_id"] . '" href="#">Vote up</a><img src="/images/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/>(<span class="votes-up-number">' . $row["votes_up_count"] . '</span>)</p>';
			}
			echo '</div>';
			echo '</div>';
			echo '<div class="replies rounded-corners-small">';
			if($loggedin && $row3[0] > 2) {
				if(!$comments) {
				echo '<div class="view-all-replies" data-id="' . $row["status_id"] . '"><p>View All Replies (';
				echo $row3[0];
				echo ')</p></div>';
				}
			}
				echo '<div class="quick-reply">';
					echo '<div class="reply-padding">';
						//echo '<div class="ind-comment" style="display:none;"></div>';
						echo '<textarea rows="3" class="quick-reply-input textArea" placeholder="Type reply..."></textarea>';
						echo '<div class="reply-btn-holder">';
							echo '<span class="link-present">Link will be shortened.</span>';
							echo '<input type="button" value="Send" class="quick-reply-button button"/>';
							echo '<span class="reply-character-count">160</span>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
}
?>