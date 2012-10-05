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