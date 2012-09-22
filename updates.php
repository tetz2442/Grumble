<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
?>

<div id="how-it-works-holder" class="content-padding">
	<h1>Updates about Grumble</h1>
	<p>On this page we will keep you up to date on new things happening on Grumble.</p>
	<div class="content-padding">
	    <h2>Cookies</h2>
	    <p>Cookies on Grumble have now been updated so you can keep yourself logged into multiple computers! An update was just pushed up and fixed the problem of deleting previous cookies. Sorry for any inconvenience this may have caused you.</p>
	    <div class="divider light"></div>
	    <h2>Email from Grumble</h2>
	    <p>Unfortunately right now email from Grumble could be getting placed in your spam. We are working on a fix, so be sure to check your spam folders when signing up for Grumble.</p>
	    <div class="divider light"></div>
	    <p class="content-padding"><a href="/create-account" class="button orange">Create Account</a> <a href="<?php echo "http://" . $_SERVER["HTTP_HOST"]?>" class="button orange">Home</a></p>
   </div>

</div>

</div>
<?php
require_once "php/footer.php"; 
?>