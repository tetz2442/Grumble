<?php
require_once "../php/conn.php";
require_once "../php/header.php";
require_once "../php/containerGrumbles.php";
require_once "outputcontact.php";

//is an admin
if(isset($_SESSION["username"]) && $_SESSION["access_lvl"] == 3) {
	//include button for clearing temp passwords
	$sql = "SELECT contact_id FROM " .
	"contact_grumble WHERE contact_resolved = 0 ORDER BY contact_create DESC";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	
?>
<link type="text/css" href="/css/admin.css" rel="stylesheet" media="all">
<div class="content-padding">
	<a class="button" href="contact.php">Contact Messages</a>
	<a class="button" href="spam.php">Spam</a>
	<a class="button">Remove old Temp Passwords</a>
    	<?php
		while($row = mysql_fetch_array($result)) {
			outputcontact($row["contact_id"]);
		}
		?>
</div>
<?php
}
require_once "../php/notificationbar.php";
require_once "../php/min-footer.php";
?>
