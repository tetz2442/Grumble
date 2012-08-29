<?php
	require_once "php/conn.php";
	require_once "php/http.php";
	require_once "php/header.php";
	require_once "php/containerWide.php";
	$validation = true;
	$previousFill = false;
	$name =  array("", "");
	if(isset($_POST["fullname"]) && isset($_POST["email"])) {
		$previousFill = true;
		$name = explode(" ", strip_tags($_POST["fullname"]));
	}
	
	$token = md5(uniqid(rand(), true));
	$_SESSION['token2'] = $token;
?>
<div id="account-create-container">
	<div id="account-create-welcome">
    	 <h1>Create an account on Grumble</h1>
    </div>
    <div id="login-grumble-info">
        <p>Creating an account on Grumble will give you access to its many features.</p>
        <p>Start new Grumble categories and inspire an action for change or simply Grumble about an issue that has been bothering you.</p>
        <p>Welcome to Grumble!</p>
    </div>
    <div id="create-account-table">	
        <form method='post' action='/php/transact-user.php' onsubmit="return checkForm(this)" name='userForm'>
        <table>
        <tr>
            <th colspan="2" align="center"><h3>Enter user information</h3></th>
        </tr>
        <tr>
            <td align="right"><label for="firstname">First name:</label></td>
            <td><input type="text" id="firstname" class="textInput" name="firstname" maxlength="50" autocomplete="off" <?php echo "value='" . $name[0] . "'"; ?>/></td>
            <td width="290"><span id="firstnameError"></span></td>
        <tr>
        <tr>
            <td align="right"><label for="lastname">Last name:</label></td>
            <td><input type="text" id="lastname" class="textInput" name="lastname" maxlength="50" autocomplete="off" <?php echo "value='" . $name[1] . "'"; ?>/></td>
            <td><span id="lastnameError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="username">Username:</label> (<span class="help-callout colored-link-1" data-id="3" title="Tips for creating a username on Grumble."><b>?</b></span>)</td>
            <td><input type="text" id="username" class="textInput" name="username" maxlength="15" autocomplete="off"/></td>
            <td><img src="/images/ajax-loader.gif" width="16" height="16" class="gif-loader" style="display:none;"/><span id="usernameError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="email">Email Address:</label></td>
            <td><input type="text" id="emails" class="textInput" name="email" maxlength="100" autocomplete="off" <?php if(isset($_POST["email"])) { echo "value='" . strip_tags($_POST["email"]) . "'";}; ?>/></td>
            <td><img src="/images/ajax-loader.gif" width="16" height="16" class="gif-loader" style="display:none;"/><span id="emailError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="userpassword">Password:</label></td>
            <td><input type="password" id="userpassword" class="textInput" name="password" maxlength="50"/></td>
            <td><span id="passError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="userpassword2">Re-enter Password:</label></td> 
            <td><input type="password" id="userpassword2" class="textInput" name="password2" maxlength="50"/></td>
            <td><span id="pass2Error"></span></td>
        </tr>
        <tr>
        	<td></td>
            <td width="205">
            	<input type="checkbox" name="terms" id="terms"/><label for="terms" class="terms">Agree to <a href="terms-of-service.php" target="_blank">Terms of Service</a> & <a href="terms-of-service.php" target="_blank">Privacy Policy</a></label>
            </td>
            <td><span id="termsError"></span></td>
        </tr>
        <tr>
            <td align="right" colspan="2">
            <input type="hidden" name="token" value="<?php echo $token; ?>" />
            <input type="submit" class="button orange" name="action" value="Create Account"/>
            </td>
        </tr>
        </table>
        </form>
    </div>
</div>
<?php 
require_once "php/helpcallout.php";
require_once "php/footer.php"; 
?>
