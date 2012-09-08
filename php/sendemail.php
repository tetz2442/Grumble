<?php
function sendEmail($email, $sendfrom, $type, $parameters) {
	if($type == "reply") {
		$subject = "[Reply] to your Grumble!";
		$body = "A new reply has been placed on your Grumble by " . $parameters[2] . "!\n\n" . 
		"'" . $parameters[3] . "'\n\nClick the URL or paste it in your browser to view the reply.\n" . $parameters[0] . "\n\nThe Grumble Team\n\n"
		. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[1] . "#settings\n"
		. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
		mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "grumble") {
		//if the grumble number is divisible by 15, send an email
		if((intval($parameters[0]) % 15 == 0)) {
			$subject = "[Grumble] your Grumble has reached " . $parameters[0]. " Comments!";
			$body = "Your Grumble is growing in popularity! Come check out the new comments on your Grumble.\n\n" . 
			"Click the URL or paste it in your browser to view.\n" . $parameters[1] 
			. "\n\nThe Grumble Team\n\n"
			. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[2] . "#settings\n"
			. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
			mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
		}
	}
	else if($type == "verify") {
		$subject = "[Grumble] Verify email";
		$body = "Thanks for signing up for Grumble!\n\n" .
		"To verify this email please follow the link below by pasting it in your browser or clicking on it.\n\n" . 
		$parameters[0] . "\n\nThe Grumble Team";
		mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
}
?>