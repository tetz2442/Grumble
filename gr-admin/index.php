<?php
require_once "../php/conn.php";
require_once "../php/functions.php";
require_once "../php/header.php";
require_once "../php/containerGrumbles.php";
require_once "adminincludes.php";
//is an admin
if(isset($_SESSION["username"]) && $_SESSION["access_lvl"] == 3) {	
?>
<div class="content-padding">
	<div>
		<a class="button" href="contact.php">Contact Messages</a>
		<a class="button" href="spam.php">Spam</a>
	</div>
	<?php
	$sql = "SELECT COUNT(user_id) AS users FROM users_grumble";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	$row = mysql_fetch_array($result);

	$sql = "SELECT COUNT(sub_category_id) AS grumbles FROM sub_category_grumble";
	$result2 = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	$row2 = mysql_fetch_array($result2);

	$sql = "SELECT COUNT(status_id) AS comments FROM status_grumble";
	$result3 = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	$row3 = mysql_fetch_array($result3);
	?>
	<div>
		<ul>
			<li>Users: <?php echo $row["users"]?></li>
			<li>Grumbles: <?php echo $row2["grumbles"]?></li>
			<li>Comments: <?php echo $row3["comments"]?></li>
		</ul>
	</div>
</div>
<?php
}
else {
?>
<div id="login-table" class="content-padding">
<form method="post" action="../php/transact-user.php">
<ul>
<li>
    <label for="email">Email Address:</label>
    <input type="email" id="email" class="textInput" name="email" maxlength="100" value=""/>
</li>
<li>
    <label for="password">Password:</label>
    <input type="password" class="textInput" name="password" maxlength="50"/>
</li>
<li>
	<input type="submit" class="button submit" name="action" value="Admin Sign In"/>
</li>
</ul>
</form>
</div>
<?php	
}
?>

<?php	
getFooter($filename, true);
?>