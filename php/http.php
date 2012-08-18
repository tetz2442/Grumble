<?php
	//this function will get used at different times, so seperating it keeps out code more efficient
	function redirect($url) {
		if(!headers_sent()) {
			header("Location: http://" . $_SERVER["HTTP_HOST"] .
				dirname($_SERVER["PHP_SELF"]) . "/" . $url);	
		}
		else {
			die("Could not redirect; headers already sent (output).");	
		}
	}
?>