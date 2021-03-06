<?php
require_once "php/conn.php";
require_once "php/functions.php";
require_once "php/outputgrumbles.php";
require_once "php/header.php";
require_once "php/containerStatus.php";

$category = strtolower(mysql_real_escape_string($_GET["cat"]));
$sql = "SELECT category_id, category_name FROM categories_grumble" .
	" WHERE category_url = '" . $category . "'";
$result = mysql_query($sql, $conn);
$row = mysql_fetch_array($result);

if(mysql_num_rows($result) == 0) {
?>
<div class="content-padding"><p class="text-align-center">This category doesn't exist. Please check your URL.</p></div>
<?php
}
else {
?>
<div class="content-padding">
<div id="cat-header">
     <h1 data-id="<?php echo $row["category_id"]; ?>"><?php echo $row["category_name"]; ?></h1>
     <?php
	 	if(isset($_SESSION["user_id"])) {
	 ?>
     <button class="push_button orange large" id="start-new-grumble">New Grumble</button>
     <?php
		}
	 ?>
</div>
<div class="clear"></div>
    <ul class="tabs">
        <li><a href='#tab1' class="active">Top Grumbles</a></li>
        <li><a href='#tab2'>Recent Grumbles</a></li>
    </ul>
    <div id="arrow-top"><img src="/images/arrow-up.png" alt="arrow" width="15" height="15"/></div>
    <div id='tab1'>
         <?php
			//top threads
			/*$sql = "SELECT sub_category_id FROM sub_category_grumble" .
			" WHERE category_id = " . $row["category_id"] . " AND grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10";*/
			$sql = "SELECT sub_category_id, " . 
            "((SELECT COUNT(DISTINCT ugl.grumble_like_id) FROM user_grumble_likes AS ugl WHERE ugl.sub_category_id = scg.sub_category_id) + " . 
            "(SELECT COUNT(DISTINCT sg.status_id) FROM status_grumble AS sg WHERE sg.sub_category_id = scg.sub_category_id)) AS grumble_number" . 
            " FROM sub_category_grumble AS scg" .
            " WHERE category_id = " . $row["category_id"] . " HAVING grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10";
			$result = mysql_query($sql, $conn);
			
			$topnumber = mysql_num_rows($result);
			
			if(mysql_num_rows($result) > 0) {
				while($row2 = mysql_fetch_array($result)) {
					outputGrumbles($row2["sub_category_id"]);	
				}
			}
			else {
				echo '<p class="content-padding">No Grumbles to view.</p>';	
			}
		?>
    </div>
    <div id="tab2">
    <?php
		//recent threads
		$sql = "SELECT sub_category_id FROM sub_category_grumble" .
		" WHERE category_id = " . $row["category_id"] . " ORDER BY sub_category_id DESC LIMIT 10";
		$result = mysql_query($sql, $conn);
		
		if(mysql_num_rows($result) > 0) {
			while($row2 = mysql_fetch_array($result)) {
				outputGrumbles($row2["sub_category_id"]);	
			}
		}
		else {
			echo '<p class="content-padding">No Grumbles to view.</p>';	
		}
	?>
    </div>
    <div id="gif-loader"><img src="/images/ajax-loader2.gif" alt="loader" width="32" height="32"/></div>
    <div id="view-more-holder">
    <?php
	if($topnumber < 10) 
    	echo '<input type="button" class="button view-more" value="View More" style="display:none;"/>';
	else 
		echo '<input type="button" class="button view-more" value="View More"/>';
	?>
    </div>
</div>
<?php
}
?>
<div class="clear"></div>
</div>
<?php
if(isset($_SESSION["username"])) {
	require_once "php/lightboxgrumble.php";
}
getFooter($filename);
?>