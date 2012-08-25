<?php
require_once "conn.php";

if(isset($_POST["user"]) && isset($_POST["usernamevalid"]) && isset($_POST["threadcheck"]) && isset($_POST["commentcheck"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
	if(isset($_POST["currentpass"]) && isset($_POST["newpass"]) && isset($_POST["newpass2"])) {
		if(strlen($_POST["newpass"]) > 5 && strlen($_POST["newpass2"]) > 5 && $_POST["newpass"] == $_POST["newpass2"]) {
			//insert into 
			echo 1;
		}
		else {
			//password error, not long enough or dont match
			echo 2;
		}
	}
	else if(strlen($_POST["user"]) >= 4 && strlen($_POST["user"]) <= 15) {
		echo 1;
	}
}
?>