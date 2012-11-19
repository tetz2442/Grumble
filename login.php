<?php 
require_once "php/functions.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
 ?>
 <div class="content-padding text-align-center">
<?php
if(!isset($_SESSION["user_id"])) {
?>
 <h1>Login</h1>
    </div>
<div id="login-table" class="rounded-corners-medium table-box-shadow">
	<form method="post" action="php/transact-user.php">
		<ul>
			<li>
			    <label for="email" class="login-label">Email or Username:</label>
			    <input type="text" id="email" class="textInput" name="email" maxlength="100" value="<?php if(isset($_GET["email"])) echo strip_tags($_GET["email"]); ?>"/>
			</li>
			<li>
			    <label for="password" class="login-label">Password:</label>
			    <?php
				$refer = "../" . basename($_SERVER['PHP_SELF']);
				if($_SERVER['QUERY_STRING'] != "") {
					$refer = $refer . "?" . $_SERVER['QUERY_STRING'];	
				}
				?>
				<input type="hidden" name="referrer" value="<?php echo $refer; ?>"/>
			    <input type="password" class="textInput" name="password" maxlength="50"/>
			</li>
			<li>
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
			    <input type="checkbox" name="remember-box" id="remember-checkbox2"/><label for="remember-checkbox2" class="colored-link-1">Remember me</label>
			    <input type="submit" class="button submit" name="action" value="Sign In"/>
			</li>
			<li>
			    <a href="forgot-password" class="colored-link-1">Forgot your password?</a>
			</li>
		</ul>
	</form>
</div>

<?php 
/*old stuff
 * 
 * <li class="padding-top"><p class="padding-top">OR login with</p></li>
<li class="padding-top social-login">
	<a href="/php/transact-user.php?provider=facebook&action=sociallogin"><img src="/images/social/facebook.png" alt="Login with Facebook" title="Login with Facebook" /></a>
	<a href="/php/transact-user.php?provider=google&action=sociallogin"><img src="/images/social/google.png" alt="Login with Google" title="Login with Google" /></a>
</li>
 */
}
else {
?>
<p class="content-padding">Looks like you are already logged in. Get out there and start Grumbling!</p>
<?php
}
getFooter($filename); 
?>