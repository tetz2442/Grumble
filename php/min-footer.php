<?php require_once 'php/notificationbar.php'; ?>
<div id="lightbox-container"></div>
</div>
</div>
<div id="fb-root"></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
!window.jQuery && document.write('<script src="/javascript/jquery-1.8.1.min.js"><\/script>');
</script>
<script type="text/javascript" src="/javascript/script.js"></script>
<?php
if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && !isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formValidation.min.js"></script>';	
}
if($filename == "create-account.php" && !isset($_SESSION["user_id"]) && isset($_GET["social_create"])) {
 echo '<script type="text/javascript" src="/javascript/formvalidationsocial.min.js"></script>';	
}
if($filename == "contact.php") {
 echo '<script type="text/javascript" src="/javascript/contactvalidation.min.js"></script>';	
}
if($filename == "profile.php" || $filename == "forgot-password.php") {
 echo '<script type="text/javascript" src="/javascript/settingsvalidation.min.js"></script>';	
}
?>
</body>
</html>