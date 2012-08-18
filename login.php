<?php 
require_once "php/header.php";
require_once "php/containerWide.php";
 ?>
 <div class="content-padding text-align-center">
 <h1>Login</h1>
    <?php
    if(isset($_GET["login"]) && $_GET["login"] == "failed") {
        echo '<p class="error padding-top">Incorrect email/password entered</p>';	
    }
    ?>
    </div>
<div id="login-table">
<form method="post" action="php/transact-user.php">
<table>
<tr>
    <td align="right"><label for="email">Email Address:</label></td>
    <td class="table-padding"><input type="email" id="email" class="textInput" name="email" maxlength="100" value="<?php if(isset($_GET["email"])) echo strip_tags($_GET["email"]); ?>"/></td>
</tr>
<tr>
    <td align="right"><label for="password">Password:</label>
    <?php
	$refer = "../" . basename($_SERVER['PHP_SELF']);
	if($_SERVER['QUERY_STRING'] != "") {
		$refer = $refer . "?" . $_SERVER['QUERY_STRING'];	
	}
	?>
	<input type="hidden" name="referrer" value="<?php echo $refer; ?>"/>
    </td>
    <td class="table-padding"><input type="password" class="textInput" name="password" maxlength="50"/></td>
</tr>
<tr>
    <td rowspan="2" align="right"><a href="forgot-password" class="colored-link-1">Forgot your password?</a></td>
</tr>
<tr>
	<td colspan="2" align="right" class="table-padding"><input type="submit" class="button submit" name="action" value="Sign In"/></td>
</tr>
</table>
</form>
</div>

<?php require_once "php/footer.php"; ?>