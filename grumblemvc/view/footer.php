	</div>
</div>
<div id="lightbox-container"></div>
<?php //min footer without the link
if(!$min) { ?>
<footer>
	<div id="footer-links">
    	<div id="footer-copyright">© 2012 Grumble</div>
    	<a class="colored-link-1" href="/about">About</a>|
    	<a class="colored-link-1" href="/how-it-works">How it works</a>|
    	<a class="colored-link-1" href="/updates">Updates</a>|
        <a class="colored-link-1" href="/privacy">Privacy</a>|
        <a class="colored-link-1" href="/terms-of-service">Terms</a>|
        <a class="colored-link-1" href="/contact">Contact Us</a>
    </div>
    <div id="social-icons">
    	<a href="https://facebook.com/grumbleonline" target="_blank"><img src="<?php echo TEMPLATE_PATH; ?>/images/icons/facebook-footer.png" alt="Facebook page"></a>
    	<a href="https://twitter.com/grumbleonline" target="_blank"><img src="<?php echo TEMPLATE_PATH; ?>/images/icons/twitter-footer.png" alt="Twitter"></a>
    </div>
</footer>
<?php } ?>
<div id="fb-root"></div>
<?php grumble_foot(); ?>
<script type="text/javascript" src="<?php echo TEMPLATE_PATH; ?>/javascript/script.min.js" async></script>
<?php
//get needed files
/*if(__FILE__ == "create-account.php" && !$user->is_logged_in() && !isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formValidation.min.js" async="async"></script>';   
}
if(__FILE__ == "create-account.php" && !$user->is_logged_in() && isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formvalidationsocial.min.js" async="async"></script>'; 
}
if(__FILE__ == "contact.php") {
 echo '<script type="text/javascript" src="/javascript/contactvalidation.min.js" async="async"></script>';    
}
if(__FILE__ == "profile.php" || __FILE__ == "forgot-password.php") {
 echo '<script type="text/javascript" src="/javascript/settingsvalidation.min.js" async="async"></script>';   
}
if((__FILE__ == "index.php" && !MOBILE) || __FILE__ == "grumbles.php" || __FILE__ == "statusview.php") {
    echo '<script type="text/javascript" src="/javascript/socialscript.js" async="async"></script>'; 
}*/
?>
</body>
</html>