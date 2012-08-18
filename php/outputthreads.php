<?php
function outputThreads($thread, $home = false) {
	global $conn;
	if($thread) {
		$sql = "SELECT cg.category_name, cg.category_url, sg.sub_category_id, sg.sub_category_name, sg.sub_category_description, sg.sub_category_url, sg.grumble_number, DATE_FORMAT(sg.sub_category_created, '%b %e, %Y %l:%i %p') AS sub_category_created " . 
			" FROM sub_category_grumble AS sg LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = sg.category_id " .
			"WHERE sg.sub_category_id = " . $thread . 
			" LIMIT 0, 1";	
		$result = mysql_query($sql, $conn);
		if($row = mysql_fetch_array($result)) {
			echo '<div class="thread-holder">';
				echo '<div class="';
				if($home) {
					echo 'content-padding-home';	
				}
				else {
					echo 'content-padding';
				}
				echo '">';
				echo '<div class="thread-comment-number">';
					if($home)
						echo '<p><a href="category/' . $row["category_url"] . '" class="colored-link-1 thread-cat-name" title="Category">' . $row["category_name"] . '</a></p>';
					echo '<p class="thread-comment-font" title="' . $row["grumble_number"] . ' Grumbles on this thread">'; 
							echo $row["grumble_number"];
					echo '</p>';
					echo '</div>';
					echo '<div class="thread-text-holder">';
							echo '<h3><a href="/' . ($row["category_url"]) . '/' . $row["sub_category_url"] . '/' . $row["sub_category_id"] . '" data-id="' . $row["sub_category_id"] . '" class="colored-link-1">' . stripslashes($row["sub_category_name"]) . '</a></h3>';
							echo '<p class="thread-description">' . stripslashes($row["sub_category_description"]) . '</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}
}
?>