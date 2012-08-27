<div id="lightbox-container"></div>
</div>
<div id="footer">
	<div id="footer-links">
    	<div id="footer-copyright">© 2012 Grumble</div>
    	<a class="colored-link-1" href="/about">About</a>|
        <a class="colored-link-1" href="/privacy">Privacy</a>|
        <a class="colored-link-1" href="/terms-of-service">Terms</a>|
        <a class="colored-link-1" href="/contact">Contact Us</a>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="/javascript/jquery-1.8.0.min"><\/script>')</script>
    <script type="text/javascript" src="/javascript/script.js"></script>
    <?php
    if($validation) {
     echo '<script type="text/javascript" src="/javascript/formValidation.js"></script>';	
    }
    if($contactvalidation) {
     echo '<script type="text/javascript" src="/javascript/contactvalidation.js"></script>';	
    }
	if($settings) {
     echo '<script type="text/javascript" src="/javascript/settingsvalidation.js"></script>';	
    }
    ?>
</div>
<div id="fb-root"></div>
</body>
</html>