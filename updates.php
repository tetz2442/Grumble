<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
?>

<div id="how-it-works-holder" class="content-padding">
	<h1>Updates about Grumble</h1>
	<p>On this page we will keep you up to date on new things happening on Grumble.</p>
	<div class="divider"></div>
	    <h2>Notifications</h2>
	    <p>Notifications are upon us! The newest addition to Grumble is the ability to receive notifications on Grumbles and comments. 
	    	With these you will no longer have to search around for the latest reply or comment. To access your notifications, just click on the little conversation bubble 
	    	next to your username in the navigation. After that you will be able to see your most recent notifications. Scroll down and click load for more.</p> 
	    <p>If you have any troubles with your notifications, make sure to report it to us using our <a href="/contact" class="colored-link-1">contact form</a>.</p>
	    <div class="divider light"></div>
	    <h2>Social login</h2>
	    <p>We are pleased to announce that you can use Facebook or Google to login or create an account with Grumble! This was made possible with the help of <a href="hybridauth.sourcefourge.net" target="_blank" class="colored-link-1">HybridAuth</a>. 
	    	If you have any problems logging in with these services, be sure to let us know in the <a href="/contact" class="colored-link-1">contact form</a>.</p>
	    <p>Right now you must log in every time you come to Grumble if you choose to register/login socially. Hopefully in the future we will be able to let you log in for extended periods of time.</p>
	    <div class="divider light"></div>
	    <h2>Cookies</h2>
	    <p>Cookies on Grumble have now been updated so you can keep yourself logged into multiple computers! An update was just pushed up and fixed the problem of deleting previous cookies. Sorry for any inconvenience this may have caused you.</p>
	    <div class="divider light"></div>
	    <h2>Email from Grumble</h2>
	    <p>Unfortunately right now email from Grumble could be getting placed in your spam. We are working on a fix, so be sure to check your spam folders when signing up for Grumble.</p>
	    <div class="divider light"></div>
	    <p class="content-padding"><a href="/create-account" class="button orange">Create Account</a> <a href="<?php echo "http://" . $_SERVER["HTTP_HOST"]?>" class="button orange">Home</a></p>

</div>

</div>
<?php
require_once "php/footer.php"; 
?>