<?php
require_once "../php/conn.php";
require_once "../php/header.php";
require_once "../php/containerGrumbles.php";
require_once "../php/functions.php";
require_once "adminincludes.php";

//is an admin
if(isset($_SESSION["username"]) && $_SESSION["access_lvl"] == 3) {
	//include button for clearing temp passwords
	$sql = "SELECT spam_id FROM spam_grumble ORDER BY spam_id";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	
?>
<div class="content-padding">
	<p>Sending emails</p>
	<?php
	$sql = "SELECT * FROM coming_soon";
	$result = mysql_query($sql, $conn);
	
	while($row = mysql_fetch_array($result)) {
		echo $row["soon_name"] . " " . $row["soon_email"] . "<br/>";
	
		$name = $row["soon_name"];
		$email = $row["soon_email"];
		$subject = "[Grumble] is launching!";
		$linkname = explode(" ", $name);
		if(count($linkname) > 1) {
			$fullMessage = "Thanks for subscribing to Grumble " . $name . "!\n\n" . 
			"Grumble is only an hour away from launch! We hope you will join us at 6:30pm (Central Time) for the launch of Grumble.\n\n" .
			"To get you started we have given you a headstart on the registration process. Follow the link below to sign up.\n\n" .
			 "http://www.grumbleonline.com/create-account?email=" . $email. "&fullname=" . $linkname[0] . "%20" . $linkname[1] . "\n\n" .
			 "Or you can head to the hompage.\nhttp://www.grumbleonline.com" .
			"\n\nThanks,\nThe Grumble Team";
		}
		else {
			$fullMessage = "Thanks for subscribing to Grumble " . $name . "!\n\n" . 
			"Grumble is only an hour away from launch! We hope you will join us at 6:30pm (Central Time) for the launch of Grumble.\n\n" .
			"To get you started we have given you a headstart on the registration process. Follow the link below to sign up.\n\n" .
			 "http://www.grumbleonline.com/create-account?email=" . $email. "&fullname=" . $name . "\n\n" .
			 "Or you can head to the hompage.\nhttp://www.grumbleonline.com" .
			"\n\nThanks,\nThe Grumble Team";
		}
		
		if(mail($email, $subject, $fullMessage, "From: no-reply@grumbleonline.com")) {
			//mailed
		}
		else {
			//failed to mail
		}
		echo 1;
	}
	?>
</div>
<?php	
}
require_once "../php/notificationbar.php";
require_once "../php/min-footer.php"; 
?>