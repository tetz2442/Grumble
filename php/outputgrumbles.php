<?php
function outputGrumbles($thread, $home = false) {
	global $conn;
	if($thread) {
		$sql = "SELECT cg.category_name, cg.category_url, scg.sub_category_id, scg.sub_category_name, scg.sub_category_description, scg.sub_category_url, COUNT(sg.status_id) AS grumble_number, DATE_FORMAT(scg.sub_category_created, '%b %e, %Y %l:%i %p') AS sub_category_created " . 
			" FROM sub_category_grumble AS scg " .
			"LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id " .
			"LEFT OUTER JOIN status_grumble AS sg ON sg.sub_category_id = scg.sub_category_id " .
			"WHERE sg.sub_category_id = " . $thread . 
			" LIMIT 0, 1";	
		$result = mysql_query($sql, $conn);
		if($row = mysql_fetch_array($result)) {
			echo '<div class="grumble-holder">';
				echo '<div class="';
				if($home) {
					echo 'content-padding-home';	
				}
				else {
					echo 'content-padding';
				}
				echo '">';
				echo '<div class="grumble-comment-number">';
					if($home)
						echo '<p><a href="category/' . $row["category_url"] . '" class="colored-link-1 grumble-cat-name" title="Category">' . $row["category_name"] . '</a></p>';
					echo '<p class="grumble-comment-font" title="' . $row["grumble_number"] . ' Grumbles on this thread">'; 
							echo $row["grumble_number"];
					echo '</p>';
					echo '</div>';
					echo '<div class="grumble-text-holder">';
							echo '<h3><a href="/' . ($row["category_url"]) . '/' . $row["sub_category_url"] . '/' . $row["sub_category_id"] . '" data-id="' . $row["sub_category_id"] . '" class="colored-link-1">' . stripslashes($row["sub_category_name"]) . '</a></h3>';
							echo '<p class="grumble-description">' . stripslashes($row["sub_category_description"]) . '</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}
}
?>