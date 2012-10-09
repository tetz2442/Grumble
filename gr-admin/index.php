<?php
require_once "../php/conn.php";
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
		<a class="button" href="sitemap.php">Create sitemap</a>
	</div>
	<?php
	/*$sql = "SELECT COUNT(DISTINCT ug.user_id) AS users, COUNT(DISTINCT scg.sub_category_id) AS grumbles, COUNT(DISTINCT sg.status_id) AS comments " .
		"FROM users_grumble AS ug " . 
		"LEFT OUTER JOIN sub_category_grumble AS scg " . 
		"LEFT OUTER JOIN status_grumble AS sg";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	$row = mysql_fetch_array($result);*/
	?>
	<!--<div>
		<ul>
			<li>Users: <?php// echo $row["users"]?></li>
			<li>Grumbles: <?php// echo $row["grumbles"]?></li>
			<li>Comments: <?php //echo $row["comments"]?></li>
		</ul>
	</div>-->
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
require_once "../php/min-footer.php"; 
?>