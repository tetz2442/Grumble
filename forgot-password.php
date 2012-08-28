<?php 
require_once "php/conn.php";
require_once "php/http.php";
require_once "php/header.php"; 
require_once "php/containerWide.php";

$token = md5(uniqid(rand(), true));
$_SESSION['token3'] = $token;
?>
<div id="forgot-pass-holder">
<div class="content-padding">
<form method="post" action="/php/transact-user.php">
<h1>Change password by email</h1>
<?php
	if(isset($_GET["error"]) && $_GET["error"] == 1) {
		echo '<span class="error"><i>Could not send email reminder</i></span>';
	}
	else if(isset($_GET["success"]) && $_GET["success"] == 1) {
		echo '<span class="available content-padding"><i>Email reminder has been sent successfully.</i></span>';
	}
	
	if(!isset($_GET["hash"]) && !isset($_GET["email"])) {
?>
<p class="content-padding-forgetpass">Forgot your password? Please enter your email address, and we'll email you a temporary link to change your password.  This link will expire shorty so be sure to reset your password as soon as possible.</p>
<label for="email-forg">Email Address:</label> <br />
	<input type="email" id="email-forg" class="textInput" name="email" maxlength="100"/><br />
    <input type="hidden" name="token" value="<?php echo $token; ?>" />
	<input type="submit" class="submit button" name="action" value="Send Email"/>
</form>
<?php 
	}
	else if(isset($_GET["hash"]) && isset($_GET["email"])) {
	$sql = "SELECT user_email, temp_password FROM temp_password_grumble WHERE temp_password ='" . 
		mysql_real_escape_string($_GET["hash"]) . "' AND user_email ='" . mysql_real_escape_string($_GET["email"]) . "' AND temp_create >= '" . date("Y-m-d H:i:s", time()) . "' LIMIT 0,1";
	$result = mysql_query($sql, $conn) or die("Could not lookup temp password: " . mysql_error());
	$row = mysql_fetch_array($result);
	if(mysql_num_rows($result) == 0) {
	?>
    	<p class="content-padding"><b><i>This link has expired</i></b></p>
    <?php
	}
	else {
		require_once "php/notificationbar.php";
?>
<br/><p>Reset your password below.</p><br/>
<p>New Password: <br />
	<input type="password" id="pass-forg" class="textInput" name="password" maxlength="50"/>
</p>
<p>New Password(again): <br />
	<input type="password" id="pass-forg2" class="textInput" name="password2" maxlength="50"/>
</p>
<p>
	<input type="hidden" name="email" value="<?php echo $row["user_email"]; ?>"/>
    <input type="hidden" name="hash" value="<?php echo $row["temp_password"]; ?>"/>
    <input type="hidden" name="token" value="<?php echo $token; ?>" />
	<input type="submit" class="submit button" id="forg-submit" name="action" value="Reset Password"/>
</p>
</form>
</div>
<?php
	}
	}
echo '</div>';
require_once "php/footer.php"; 
?>