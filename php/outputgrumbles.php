<?php
function outputGrumbles($grumble, $comments = false, $loggedin = false) {
	global $conn;
	if($grumble) {
		$sql = "SELECT sg.status_id, sg.status_text, ug.username, DATE_FORMAT(sg.date_submitted, '%b %e, %Y %l:%i %p') AS date_submitted, " . 
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
			
			echo '<div class="grumble-holder">';
			
				echo '<div class="grumble-inner-holder">';
					echo '<div class="grumble-header">';
						echo '<a href="/profile/' . $row["username"] . '" rel="' . $row["status_id"] . '" class="username" title="Visit profile"><strong>' . $row["username"] . '</strong></a>';
						echo '<span class="grumble-time" title="' . $row["date_submitted"] . '"><a href="/profile/' . $row["username"] . '/grumble/' . $row["status_id"] . '" class="colored-link-1">' . time_ago($row["date_submitted"]) . '</a></span>';
					echo '</div>';
					echo '<div class="grumble-text-holder">';
						echo '<p class="grumble-text">' . stripslashes($row["status_text"]) . '</p>';
					echo '</div>';
					echo '<div class="embed-link"></div>';
				echo '</div>';
			echo '<div class="grumble-extras">';
			echo '<div class="grumble-votes">';
			if(isset($_SESSION["user_id"])) {
					//get the number of comments from the db
					$sql = "SELECT COUNT(*) FROM comments_grumble WHERE status_id = " . $grumble;
					$commentcount = mysql_query($sql, $conn);
					$row3 = mysql_fetch_array($commentcount);
					if($comments) {
						echo '<p class="gif-loader-comments"><img src="/images/ajax-loader.gif" alt="loader" width="16" height="16"/></p><p class="comments-view" rel="' . $row["status_id"] . '" data-html="Comments" data-number="(' . $row3[0] . ')" data-comments="' . $row3[0] . '" title="View/Add comments on this Grumble">Comments';
						if($row3[0] >= 1)
							echo '<img src="/images/balloons.png" alt="View Comments" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
						else 
							echo '<img src="/images/balloon.png" alt="View Comment" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
					}
					else {
						echo '<p class="gif-loader-comments"><img src="/images/ajax-loader.gif" alt="loader" width="16" height="16"/></p><p class="comments-view" rel="' . $row["status_id"] . '" data-html="Comments" data-number="(' . $row3[0] . ')" data-comments="' . $row3[0] . '" title="View/Add comments on this Grumble"><a>Comments</a>';
						if($row3[0] >= 1)
							echo '<img src="/images/balloons.png" alt="View Comments" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
						else 
							echo '<img src="/images/balloon.png" alt="View Comment" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
					}
			}
			if((isset($result2) && $row2 = mysql_fetch_array($result2))) {
				echo '<p class="votes-up" title="You have already voted up">Vote up<img src="/images/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/><span class="votes-up-number">(' . $row["votes_up_count"] . ')</span></p>';
			}
			else if(!isset($_SESSION["user_id"])) {
				echo '<p class="votes-up" title="You must log in to vote up">' . $row["votes_up_count"] . ' Vote(s) up</p>';
			}
			else {
				echo '<p class="votes-up" title="Vote this grumble up"><a rel="' . $row["status_id"] . '" href="#">Vote up</a><img src="/images/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/>(<span class="votes-up-number">' . $row["votes_up_count"] . '</span>)</p>';
			}
			echo '</div>';
			echo '</div>';
			echo '<div class="comments">';
			if($loggedin && $row3[0] > 2) {
				if(!$comments) {
				echo '<div class="view-all-comments" rel="' . $row["status_id"] . '"><p>View All Comments(';
				echo $row3[0];
				echo ')</p></div>';
				}
			}
				echo '<div class="quick-comment">';
					echo '<div class="comment-padding">';
						//echo '<div class="ind-comment" style="display:none;"></div>';
						echo '<textarea rows="3" class="quick-comment-input" placeholder="Type comment..."></textarea>';
						echo '<span class="comment-character-count">160</span>';
						echo '<input type="button" value="Send" class="quick-comment-button button"></input>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
}
?>