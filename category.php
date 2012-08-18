<?php
require_once "php/conn.php";
require_once "php/http.php";
require_once "php/outputthreads.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";

$category = mysql_real_escape_string($_GET["cat"]);
$sql = "SELECT category_id, category_name FROM categories_grumble" .
	" WHERE category_url = '" . $category . "'";
$result = mysql_query($sql, $conn);
$row = mysql_fetch_array($result);

if(mysql_num_rows($result) == 0) {
?>
<div class="content-padding"><p class="text-align-center"><br/><b>This category doesn't exist. Please check your URL.</b></p></div>
<?php
}
else {
?>
<div class="content-padding">
<div id="cat-header">
     <h1 rel="<?php echo $row["category_id"]; ?>"><?php echo $row["category_name"]; ?></h1>
     <?php
	 	if(isset($_SESSION["user_id"])) {
	 ?>
     <button class="push_button orange large" id="start-new-thread">Start New Thread</button>
     <?php
		}
		else {
	 ?>
     <button class="push_button orange large dropdown-shortlink">Start New Thread</button>
     <?php
		}
	 ?>
</div>
    <ul class="tabs">
        <li><a href='#tab1' class="active">Top Threads</a></li>
        <li><a href='#tab2'>Recent Threads</a></li>
    </ul>
    <div id="arrow-top"><img src="/images/arrow-up.png" width="15" height="15"/></div>
    <div id='tab1'>
         <?php
			//top threads
			$sql = "SELECT sub_category_id FROM sub_category_grumble" .
			" WHERE category_id = " . $row["category_id"] . " AND grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10";
			$result = mysql_query($sql, $conn);
			
			$topnumber = mysql_num_rows($result);
			
			if(mysql_num_rows($result) > 0) {
				while($row2 = mysql_fetch_array($result)) {
					outputThreads($row2["sub_category_id"]);	
				}
			}
			else {
				echo '<p class="content-padding"><b>No grumble threads.</b></p>';	
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
				outputThreads($row2["sub_category_id"]);	
			}
		}
		else {
			echo '<p class="content-padding"><b>No grumble threads.</b></p>';	
		}
	?>
    </div>
    <div id="gif-loader"><img src="/images/ajax-loader2.gif" width="32" height="32"/></div>
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
</div>
<?php
if(isset($_SESSION["username"])) {
	require_once "php/lightboxthread.php";
}
require_once "php/footer.php"; 
?>