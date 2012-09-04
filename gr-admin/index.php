<?php
require_once "../php/conn.php";
require_once "../php/header.php";
require_once "../php/containerGrumbles.php";
require_once "outputcontact.php";
require_once "outputspam.php";

//is an admin
if(isset($_SESSION["username"]) && $_SESSION["access_lvl"] == 3) {
	//include button for clearing temp passwords
	$sql = "SELECT contact_email, contact_message_type, contact_message, contact_name FROM " .
	"contact_grumble WHERE contact_resolved = 0 ORDER BY contact_create DESC";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	
?>
<link type="text/css" href="/css/admin.css" rel="stylesheet" media="all">
<ul class="tabs">
    <li><a href='#tab1' class="active">Contact Messages</a></li>
    <li><a href='#tab2'>Reported Spam</a></li>
</ul>
<div id="tabs-horizontal-float">
    <div id='tab1'>
    	<?php
		while($row = mysql_fetch_array($result)) {
			echo "<div>";
			echo '<p>' . $row["contact_name"] . '</p>';
			echo '<p>' . $row["contact_message_type"] . '</p>';
			echo '<p>' . $row["contact_message"] . '</p>';
			echo "</div>";
		}
		?>
    </div>
    <div id='tab2'>
    </div>
</div>
<?php
}
else {
?>
<div id="login-table" class="content-padding">
<form method="post" action="php/transact-user.php">
<table>
<tr>
    <td align="right"><label for="email">Email Address:</label></td>
    <td class="table-padding"><input type="email" id="email" class="textInput" name="email" maxlength="100" value=""/></td>
</tr>
<tr>
    <td align="right"><label for="password">Password:</label>
    </td>
    <td class="table-padding"><input type="password" class="textInput" name="password" maxlength="50"/></td>
</tr>
<tr>
	<td colspan="2" align="right" class="table-padding"><input type="submit" class="button submit" name="action" value="Admin Sign In"/></td>
</tr>
</table>
</form>
</div>
<?php	
}
?>

<?php	
require_once "../php/min-footer.php"; 
?>