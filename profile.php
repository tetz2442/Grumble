<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/timeago.php";
require_once "php/outputgrumbles.php";
require_once "php/outputcomments.php";
require_once "php/containerStatus.php";

$grumble = true;
$id = mysql_real_escape_string($_GET["id"]);
$sql = "SELECT ug.user_id, ug.username, ug.user_firstname, ug.user_lastname " . 
"FROM users_grumble AS ug WHERE ug.username = '" . $id . "'";
$result = mysql_query($sql, $conn);
$row = mysql_fetch_array($result);
if(mysql_num_rows($result) == 0) {
?>
<div class="content-padding"><p class="text-align-center content-padding"><b>This user does not exist</b></p></div>
<?php		
}
else {
if($row["username"] == $_SESSION["username"])
	$userprofile = true;
else {
	$userprofile = false;
}
?>
<div id="user-info-holder">
    <div class="profile-user-info">
    	<h2 class="user-name" rel="<?php echo $row["user_id"]; ?>"><?php echo $row["username"] . "'s Grumbles"; ?></h2>
        <p class="user-bio"></p>
        <?php if($userprofile) {?>
        <button class="button large" disabled="disabled"/>Settings</button>
        <?php }?>
    </div>
    <ul class="tabs-profile">
        <li><a href='#tab1' class="active">Comments</a></li>
        <li><a href='#tab2'>Grumbles</a></li>
    </ul>
    <div id="arrow-top-profile"><img src="/images/arrow-up.png" width="15" height="15"/></div>
    <div id='tab1'>
         <?php
			if(isset($_GET["id"])) {
			//get user omments
			$sql = "SELECT sg.status_id, ug.user_id, sg.sub_category_id FROM status_grumble AS sg " .
			"LEFT OUTER JOIN users_grumble AS ug ON sg.user_id = ug.user_id " .
			"WHERE ug.username = '" . $id . 
			"' ORDER BY sg.status_id DESC LIMIT 10";
			$result = mysql_query($sql, $conn);
			
			$topnumber = mysql_num_rows($result);
			
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_array($result)) {
					outputComments($row["status_id"], false, $loggedin);
				}
			}
			else {
				echo " <br/>\n";
				echo "<p class='text-align-center content-padding'><b>There are currently no comments to view.</b></p>";	
				echo '</div>';
			}
		}
		?>
    </div>
    <div id="tab2">
    <?php
		//recent grumbles
		$sql = "SELECT scg.sub_category_id FROM sub_category_grumble AS scg" .
			" LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = scg.user_id " .
			" WHERE ug.username = '" . $id . "' ORDER BY sub_category_id DESC LIMIT 10";
		$result = mysql_query($sql, $conn);
		
		if(mysql_num_rows($result) > 0) {
			while($row2 = mysql_fetch_array($result)) {
				outputGrumbles($row2["sub_category_id"], true);	
			}
		}
		else {
			echo '<p class="text-align-center content-padding"><b>No grumbles to view.</b></p>';	
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
if($userprofile) {
	require_once "php/settings.php"; 
	require_once "php/notificationbar.php";
	$settings = true;
}
require_once "php/footer.php"; 
?>