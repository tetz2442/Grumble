<?php
function sendEmail($email, $sendfrom, $type, $url = "", $username = "") {
	if($type = "comment") {
		$subject = "[Comment] on your Grumble!";
		$body = "A new comment has been placed on your Grumble! Click the URL or paste it in your browser to view the comment.\n\n" . $url . "\n\nThe Grumble Team\n\n"
		. "To unsubscribe from these emails, change your settings here - http://" . $_SERVER['HTTP_HOST'] . "/profile/" . $username . "#settings\n"
		. "Then let us know what we are doing wrong - http://" . $_SERVER['HTTP_HOST'] . "/contact";
		mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send reminder email.");
	}
}
?>