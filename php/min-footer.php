<div id="lightbox-container"></div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>!window.jQuery && document.write('<script src="/javascript/jquery-1.8.0.min"><\/script>')</script>
<script type="text/javascript" src="/javascript/script.js"></script>
<?php
if($validation == true) {
 echo '<script type="text/javascript" src="/javascript/formValidation.js"></script>';	
}
if($contactvalidation == true) {
 echo '<script type="text/javascript" src="/javascript/contactvalidation.js"></script>';	
}
if($settings == true) {
 echo '<script type="text/javascript" src="/javascript/settingsvalidation.js"></script>';	
}
?>
<div id="fb-root"></div>
</body>
</html>