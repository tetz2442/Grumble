<?php 
require_once "php/conn.php";
require_once "php/functions.php";
require_once "php/header.php";
require_once "php/containerStatus.php";
require_once "php/outputnotifications.php";

if(isset($_GET["userid"]) && $_SESSION["username"] == $_GET["userid"]) {
	$user = mysql_real_escape_string(strip_tags($_GET["userid"]));
	$sql = "SELECT notification_id, notification_message, notification_url, notification_created, notification_read FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY notification_created DESC LIMIT 20";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	
	if(mysql_num_rows($result) == 0) {
		echo '<div class="content-padding"><p class="text-align-center content-padding">No notifications.</p></div>';
	}
	else {
		?>
		<div id="notifications-page-holder">
			<div><p id="notification-header">Notifications</p></div>
			<ul id="notifications-page">
				<?php
		        outputNotifications($result);
				if(mysql_num_rows($result) == 10) {
					echo ' <li id="notification-load"><a href="#" class="colored-link-1">Load more...</a></li>';
				}
				?>
			</ul>
		</div>
		<?php
	}	
}
else {
?>
<div class="content-padding"><p class="text-align-center content-padding">This user does not exist. Please check your URL.</p></div>
<?php
}
getFooter($filename, true);
?>