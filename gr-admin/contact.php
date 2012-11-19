<?php
require_once "../php/conn.php";
require_once "../php/functions.php";
require_once "../php/header.php";
require_once "../php/containerGrumbles.php";
require_once "outputcontact.php";
require_once "adminincludes.php";

//is an admin
if(isset($_SESSION["username"]) && $_SESSION["access_lvl"] == 3) {
	//include button for clearing temp passwords
	$sql = "SELECT contact_id FROM " .
	"contact_grumble WHERE contact_resolved = 0 ORDER BY contact_create";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	
?>
<div class="content-padding">
	<div>
		<a class="button" href="contact.php">Contact Messages</a>
		<a class="button" href="spam.php">Spam</a>
	</div>
    	<?php
    	if(mysql_num_rows($result) != 0) {
			while($row = mysql_fetch_array($result)) {
				outputcontact($row["contact_id"]);
			}
		}
		else {
			echo '<p class="content-padding">No messages at this time.</p>';
		}
		?>
</div>
<?php
}
require_once "../php/notificationbar.php";
getFooter($filename, true);
?>
