<?php require_once 'php/notificationbar.php'; ?>
</div>
</div>
<div id="lightbox-container"></div>
<div id="footer">
	<div id="footer-links">
    	<div id="footer-copyright">© 2013 Grumble</div>
    	<a class="colored-link-1" href="/about">About</a>|
    	<a class="colored-link-1" href="/how-it-works">How it works</a>|
    	<a class="colored-link-1" href="/updates">Updates</a>|
        <a class="colored-link-1" href="/privacy">Privacy</a>|
        <a class="colored-link-1" href="/terms-of-service">Terms</a>|
        <a class="colored-link-1" href="/contact">Contact Us</a>
    </div>
    <div id="social-icons">
    	<a href="https://facebook.com/grumbleonline" target="_blank"><img src="/images/icons/facebook-footer.png" width="25" height="25" alt="Facebook page" title="Facebook page"></a>
    	<a href="https://twitter.com/grumbleonline" target="_blank"><img src="/images/icons/twitter-footer.png" width="25" height="25" alt="Twitter" title="Twitter page"></a>
    </div>
</div>
<div id="fb-root"></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
!window.jQuery && document.write('<script src="/javascript/jquery-1.8.1.min.js"><\/script>');
</script>
<script type="text/javascript" src="/javascript/script.js" async="async"></script>
<?php
if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && !isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formValidation.min.js" async="async"></script>';   
}
if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formvalidationsocial.min.js" async="async"></script>'; 
}
if($filename == "contact.php") {
 echo '<script type="text/javascript" src="/javascript/contactvalidation.min.js" async="async"></script>';    
}
if($filename == "profile.php" || $filename == "forgot-password.php") {
 echo '<script type="text/javascript" src="/javascript/settingsvalidation.min.js" async="async"></script>';   
}
if(($filename == "index.php" && !$mobile) || $filename == "grumbles.php" || $filename == "statusview.php") {
    echo '<script type="text/javascript" src="/javascript/socialscript.js" async="async"></script>'; 
}
?>
</body>
</html>