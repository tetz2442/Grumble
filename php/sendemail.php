<?php
function sendEmail($email, $sendfrom, $type, $parameters) {
	if($type == "comment") {
		$subject = "[Comment] on your Grumble!";
		$body = "A new comment has been placed on your Grumble by " . $parameters[2] . "!\n\n" . 
		"'" . $parameters[3] . "'\n\nClick the URL or paste it in your browser to view the comment.\n" . $parameters[0] . "\n\nThe Grumble Team\n\n"
		. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[1] . "#settings\n"
		. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
		mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
	}
	else if($type == "thread") {
		//if the grumble number is divisible by 15, send an email
		if((intval($parameters[0]) % 15 == 0)) {
			$subject = "[Thread] your thread has reached " . $parameters[0]. " Grumbles!";
			$body = "Your thread is growing in popularity! Come check out the new Grumbles on your thread.\n\n" . 
			"Click the URL or paste it in your browser to view.\n" . $parameters[1] 
			. "\n\nThe Grumble Team\n\n"
			. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $parameters[2] . "#settings\n"
			. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
			mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send email.");
		}
	}
}
?>