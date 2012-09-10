<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerWide.php";
$validation = true;
?>
<div id="account-create-container">
	<div id="about-left">
    	<h2>So...what is Grumble?</h2>
        <p>Grumble is a place where you can discuss the topics that you feel are important and need attention.</p>
        <p>The topics are broken down into threads. You can join in on an existing thread, or create your own.</p>
        <p>Grumble simply to get something off your chest, or Grumble to raise awareness for a problem.</p>
        <p>You never know what could happen if enough people join together for something important.</p>
        <p>It's that simple. Grumble for you. Grumble for change.</p>
    </div>
    <div id="about-right">
    	<h2>Have something to Grumble about?</h2>
        <p>Start your sign up below and start Grumbling.</p>
        <div id="login-table-about" class="rounded-corners-large content-padding">	
            <form method='post' action='/create-account' name='userForm'>
            <ul>
	            <li>
	            	<label for="fullname">Full Name: (ex. John Doe)</label>
	                <td><input type="text" id="fullname" class="textInput" name="fullname" maxlength="50"/></td>
	            </li>
	            <li class="padding-top">
	            	<label for="emails">Email Address:</label>
	                <input type="text" id="emails" class="textInput" name="email" maxlength="255"/>
	            </li>
	            <li>
	                <input type="submit" id="about-create" class="button orange" name="action" value="Create Account"/>
	            </li>
            </ul>
            </form>
        </div>
    </div>
</div>
<?php	
require_once "php/footer.php"; 
?>