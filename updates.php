<?php
require_once "php/conn.php";
require_once "php/functions.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
?>

<div id="updates-holder" class="content-padding">
	<h1>Updates about Grumble</h1>
	<p>On this page we will keep you up to date on new things happening on Grumble.</p>
	<div class="divider"></div>
		<h2>Deletetion of Account Option</h2>
		<time>Jan. 10th, 2012</time>
	    <p>Grumblers can now completely delete their account and all of the data associated with it by visiting their settings. The only data that will be left will be likes of either Grumbles or comments that you have not created. There is no identifying data left over after deletion of an account. We will miss you Grumbling if you choose this new option!</p> 
	    <div class="divider light"></div>
		<h2>New Social Buttons, Ability to Delete Your Grumbles and Replies</h2>
		<time>Nov. 18th, 2012</time>
	    <p>Say hello to new social login buttons! Not only have we came up with some new buttons, but we have made them more prominent when creating an account and logging in. This makes logging in and creating an account with social media that much easier and quicker. You can still easily log in with Grumble by simply clicking "Login with Grumble".</p> 
	    <p>Besides the great new buttons we have introduced the ability to delete your Grumbles and replies. If you made a mistake or feel that you content should not be available anymore you can easily delete them. Navigate to the Grumble or reply, hover over them, and click the delete link.</p>
	    <div class="divider light"></div>
		<h2>New ranking system for Grumbles</h2>
		<time>Oct. 3rd, 2012</time>
	    <p>Grumbles will now be ranked not only by the number of comments on them, but also by the number of votes. This will help provide a more realistic view of how popular a Grumble really is. Take advantage of this new feature by creating
	    	a few Grumbles yourself!</p> 
	    <div class="divider light"></div>
		<h2>Voting up Grumbles</h2>
		<time>Sep. 30th, 2012</time>
	    <p>Our newest feature includes voting up a Grumble! This has been requested by a few of our users and we are glad to be able to now provide this new experience. To try it out simply head over to a Grumble and click "Vote up".</p> 
	    <div class="divider light"></div>
		<h2>Mobile Grumble</h2>
		<time>Sep. 26th, 2012</time>
	    <p>Accessing Grumble from your phone is now simpler than ever! With the newest update Grumble is responsive to the size of your screen. This will allow you to access and post on Grumble wherever you are and no matter what device you are
	    	using. This was all made possible with the power of responsive CSS.</p> 
	    <p>If you have any troubles accessing Grumble on your phone, make sure to report it to us using our <a href="/contact" class="colored-link-1">contact form</a>.</p>
	    <div class="divider light"></div>
		<h2>Longer Grumble descriptions</h2>
		<time>Sep. 27th, 2012</time>
	    <p>You can now put almost double the characters in your descriptions! The most recent update includes a much longer description of your Grumble.
	     We thought this will help you be better able to describe the Grumble you are creating. Also, when a description gets over a certain amount of 
	     character, a more/less link will show up. This is to prevent the page from being overtaken by a particularly long description. Seeing the full 
	     description is as easy as clicking the more link.</p> 
	    <div class="divider light"></div>
	    <h2>Notifications</h2>
		<time>Sep. 26th, 2012</time>
	    <p>Notifications are upon us! The newest addition to Grumble is the ability to receive notifications on Grumbles and comments. 
	    	With these you will no longer have to search around for the latest reply or comment. To access your notifications, just click on the little conversation bubble 
	    	next to your username in the navigation. After that you will be able to see your most recent notifications. Scroll down and click load for more.</p> 
	    <p>If you have any troubles with your notifications, make sure to report it to us using our <a href="/contact" class="colored-link-1">contact form</a>.</p>
	    <div class="divider light"></div>
	    <h2>Social login</h2>
		<time>Sep. 22nd, 2012</time>
	    <p>We are pleased to announce that you can use Facebook or Google to login or create an account with Grumble! This was made possible with the help of <a href="http://hybridauth.sourceforge.net/" target="_blank" class="colored-link-1">HybridAuth</a>. 
	    	If you have any problems logging in with these services, be sure to let us know in the <a href="/contact" class="colored-link-1">contact form</a>.</p>
	    <p>Right now you must log in every time you come to Grumble if you choose to register/login socially. Hopefully in the future we will be able to let you log in for extended periods of time.</p>
	    <div class="divider light"></div>
	    <h2>Cookies</h2>
		<time>Sep. 20th, 2012</time>
	    <p>Cookies on Grumble have now been updated so you can keep yourself logged into multiple computers! An update was just pushed up and fixed the problem of deleting previous cookies. Sorry for any inconvenience this may have caused you.</p>
	    <div class="divider light"></div>
	    <p class="content-padding"><a href="/create-account" class="button orange">Create Account</a> <a href="<?php echo "http://" . $_SERVER["HTTP_HOST"]?>" class="button orange">Home</a></p>
</div>

</div>
<?php
getFooter($filename);
?>