<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerWide.php";
?>

<div id="how-it-works-holder" class="content-padding">
	<h1>How Grumble Works</h1>
	<p>Here is a quick guide to get you started Grumbling. This is meant to give you the basics of how Grumble works.</p>
	<p>Grumble is an online, social petition like site that allows users to post “Grumbles”.  You can post just for fun, or for something more serious.</p>
	<p>Any user can start a Grumble as long as you have made an <a href="/create-account" class="colored-link-1">account</a>.  After it is created, that is when the fun begins. Place your comments on the Grumble of your choice that you support or have mutual feelings with the starter about. 
		 Who knows what could happen if enough people come together around a common Grumble, it could even inspire a real action for change.</p>
	<p>Below we will take you through the inner workings of Grumble.</p>
	<div class="content-padding">
	    <h2>A. Grumbles</h2>
	    <p><img src="/images/works/howitworks-subcat.jpg" id="works-image1" alt="Grumble how to" /></p>
	    <ul>
		    <li>Grumble title</li>
		    <li>The category that the Grumble belongs to.</li>
		    <li>The user that created this Grumble.</li>
		    <li>Vote up a Grumble.</li>
		    <li>Options for sharing a Grumble.</li>
	    </ul>
	    <div class="divider light"></div>
	    <h2>B. Comments</h2>
	    <p><img src="/images/works/howitworks-comment.jpg" id="works-image2" alt="Grumble how to" /></p>
	    <ul>
		    <li>Start a new comment.</li>
		    <li>User who created the comment.</li>
		    <li>Comment options. If you own the comment, you can delete it, otherwise you can report a comment as spam.</li>
		    <li>How long ago the comment was created. You can also click the time to open the status and see it individually.</li>
		    <li>More comment options. From here you can either vote up a comment or enter a reply (more information below).</li>
	    </ul>
	    <div class="divider light"></div>
	    <h2>C. Replies</h2>
	    <p><img src="/images/works/howitworks-reply.jpg" id="works-image3" alt="Grumble how to" /></p>
	    <ul>
		    <li>Reply contents. A reply contains the user who created it, the reply text, and the time it was sumbitted.</li>
		    <li>The textfield at the bottom lets you type a new reply.</li>
		    <li>After opening the replies, you can close them simply by clicking the "Close" link.</li>
		    <li>The numbers to the left of the send button show how many characters are left.</li>
	    </ul>
	    <div class="divider light"></div>
	    <p class="content-padding"><a href="/create-account" class="button orange">Create Account</a> <a href="<?php echo "http://" . $_SERVER["HTTP_HOST"]?>" class="button orange">Home</a></p>
   </div>

</div>

</div>
<?php
require_once "php/footer.php"; 
?>