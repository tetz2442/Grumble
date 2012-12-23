<?php
class Outputter {
	
	public function outputComments($data) {
		foreach ($data as $row) { ?>
			<div class="comment-holder">
				<div class="comment-inner-holder">
					<div class="comment-header">
						<?php //if it is a users profile display the grumble
						if(!$profile && !$homepage)
							echo '<a href="/profile/' . $row["username"] . '" data-id="' . $row["status_id"] . '" class="username" title="Visit profile"><strong>' . $row["username"] . '</strong></a>';
						else if($homepage) //if it is the hompage display the Grumble the comment originated from
							echo '<a href="/profile/' . $row["username"] . '" data-id="' . $row["status_id"] . '" class="username" title="Visit profile"><strong>' . $row["username"] . '</strong></a><span class="splitter">in </span>' .
							'<a href="/' . $row["category_url"] . '/' . $row["sub_category_url"] . '/' . $row["sub_category_id"] . '" class="username-grumble" title="Go to Grumble">' . stripslashes($row["sub_category_name"]) . '</a>';
						else 
							echo '<a href="/' . $row["category_url"] . '/' . $row["sub_category_url"] . '/' . $row["sub_category_id"] . '" data-id="' . $row["status_id"] . '" class="username" title="Go to Grumble"><strong>' . stripslashes($row["sub_category_name"]) . '</strong></a>';
						//convert the time to the users timezone
						if (isset($_SESSION["timezone"])) {
							$formatted_date = convertToTimeZone($row["date_submitted"], $_SESSION["timezone"]);
							//Sep 10, 2012 1:35 PM
							echo '<span class="comment-time" title="' . $formatted_date . '"><a href="/profile/' . $row["username"] . '/comment/' . $row["status_id"] . '" class="colored-link-1">' . time_ago($formatted_date) . '</a></span>';
						}
						else if(isset($_SESSION["time"])) {
							$formatted_date = convertToTimeZone($row["date_submitted"], $_SESSION["time"]);
							//Sep 10, 2012 1:35 PM
							echo '<span class="comment-time" title="' . $formatted_date . '"><a href="/profile/' . $row["username"] . '/comment/' . $row["status_id"] . '" class="colored-link-1">' . time_ago($formatted_date) . '</a></span>';
						} ?>
					</div>
					<div class="comment-text-holder">
						<p class="comment-text"><?php echo stripslashes($row["status_text"]); ?></p>
					</div>
					<a href="<?php echo '/profile/' . $row["username"]; ?>"><img class="user-image rounded-corners-medium" src="<?php echo getGravatar($row["user_email"]); ?>" alt="<?php echo $row["username"]; ?>"></a>
				</div>
			<?php //container for comment options ?>
			<div class="comment-extras">
			<?php //if user is owner or admin, let the user delete 
			if(isset($_SESSION["username"]) && $_SESSION["username"] == $row["username"] || $admin) {
				echo '<div class="comment-options">';
				echo '<p class="comment-delete" title="Delete this Comment">Delete</p>';
				if($admin) {
					echo '<p class="comment-remove" title="Remove this comment from the spam list">Remove</p>';
				}
				echo '</div>';
			}
			//if user does not own, let them report as spam
			else if(isset($_SESSION["username"])) {
				echo '<div class="comment-options">';
				echo '<p class="comment-spam" title="Report this comment as spam">Spam</p>';
				echo '</div>';
			}
			echo '<div class="comment-votes">';
			//get the number of comments from the db
			$sql = "SELECT COUNT(*) FROM replies_grumble WHERE status_id = " . $grumble;
			$commentcount = mysql_query($sql, $conn);
			$row3 = mysql_fetch_array($commentcount);
			//show comment options if user is logged in
			if(isset($_SESSION["user_id"])) {
				if($comments) {
					echo '<p class="gif-loader-replies"><img src="/images/ajax-loader.gif" alt="loader" width="16" height="16"/></p><p class="replies-view" data-id="' . $row["status_id"] . '" data-html="Replies" data-replies="' . $row3[0] . '" title="View/Add replies on this comment">Replies';
					if($row3[0] >= 1)
						echo '<img src="/images/icons/balloons.png" alt="View Replies" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
					else 
						echo '<img src="/images/icons/balloon.png" alt="View Replies" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
				}
				else {
					echo '<p class="gif-loader-replies"><img src="/images/ajax-loader.gif" alt="loader" width="16" height="16"/></p><p class="replies-view" data-id="' . $row["status_id"] . '" data-html="Replies" data-replies="' . $row3[0] . '" title="View/Add replies on this comment"><a>Replies</a>';
					if($row3[0] > 1)
						echo '<img src="/images/icons/balloons.png" alt="View Replies" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
					else 
						echo '<img src="/images/icons/balloon.png" alt="View Reply" width="16" height="16"/><span>(' . $row3[0] . ')</span></p>';
				}
			}
			else {
				echo '<p title="Login to View/Add replies on this comment"><a>Replies(' . $row3[0] . ')</a>';
			}
			//user has already voted up
			if((isset($result2) && $row2 = mysql_fetch_array($result2))) {
				echo '<p class="votes-up" title="You have already voted up">Votes up<img src="/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/><span class="votes-up-number">(' . $row["votes_up_count"] . ')</span></p>';
			}
			//user is not logged in
			else if(!isset($_SESSION["user_id"])) {
				echo '<p class="votes-up" title="You must log in to vote up">Votes up(' . $row["votes_up_count"]  . ')</p>';
			}
			else {
				echo '<p class="votes-up" title="Vote this grumble up"><a data-id="' . $row["status_id"] . '" href="#">Vote up</a><img src="/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/>(<span class="votes-up-number">' . $row["votes_up_count"] . '</span>)</p>';
			}
			echo '</div>';
			echo '</div>';
			echo '<div class="replies rounded-corners-small">';
			//if there are more than 2 replies, show the view all replies button
			if($loggedin && $row3[0] > 2) {
				if(!$comments) {
				echo '<div class="view-all-replies" data-id="' . $row["status_id"] . '"><p>View All Replies (';
				echo $row3[0];
				echo ')</p></div>';
				}
			} ?>
				<div class="quick-reply">
					<div class="reply-padding">
						<textarea rows="3" class="quick-reply-input textArea" placeholder="Type reply..."></textarea>
						<div class="reply-btn-holder">
							<span class="link-present">Link will be shortened.</span>
							<input type="button" value="Send" class="quick-reply-button button"/>
							<span class="reply-character-count">240</span>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
}
?>