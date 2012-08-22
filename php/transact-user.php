<?php
	require_once "conn.php";
	require_once "http.php";
	session_start();
	if(isset($_REQUEST["action"])) {
		switch ($_REQUEST["action"]) {
		case "Sign In" :
			if(isset($_POST["email"]) && strlen($_POST["email"]) > 0 && isset($_POST["password"]) && strlen($_POST["password"]) > 0 && isset($_POST["referrer"])) {
				if( empty($_POST['token']) || $_POST['token'] != $_SESSION['token'] ) 
					redirect("../");
			
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token']);
					
				$sql = "SELECT user_id, access_lvl, username, user_password, user_salt " .
					"FROM users_grumble " .
					"WHERE user_email='" . mysql_real_escape_string(strip_tags($_POST["email"])) . "' ";
				$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
				$row = mysql_fetch_array($result);
				$hashed_pass = crypt(mysql_real_escape_string(strip_tags($_POST["password"])), $row['user_salt']) . $row["user_salt"];
				
				$refer = strip_tags($_POST["referrer"]);
				//email was entered wrong
				if(mysql_num_rows($result) < 1) {
					redirect("../login?login=failed&email=" . strip_tags($_POST["email"]));
				}
				else if($hashed_pass == $row["user_password"]) {
					session_start();
					$_SESSION["user_id"] = $row["user_id"];
					$_SESSION["access_lvl"] = $row["access_lvl"];
					$_SESSION["username"] = $row["username"];	
					if(isset($_POST["remember-box"])) {
						//CHANGE THIS WHEN TRANSFERING TO GRUMBLEONLINE.COM
						//setcookie("user", $row["username"], time()+7*24*60*60, '/', 'test.grumbleonline.com');
					}
					if(strpos($refer, "login.php") || strpos($refer, "index.php"))
						redirect("../");
					else
						redirect($refer);
				}
				else if($hashed_pass != $row["user_password"]) {
					redirect("../login?login=failed&email=" . strip_tags($_POST["email"]));	
				}
				else {
					redirect($refer . "?login=1");	
				}
			}
			else {
				redirect($refer . "?login=1");	
			}
		break;
		
		case "Logout" :
			session_unset();
			session_destroy();
			//setcookie("user","", time()-15);
			redirect("../");
			break;
			
		case "Create Account" :
			if(isset($_POST["firstname"]) && strlen($_POST["firstname"]) > 1
			&& isset($_POST["lastname"]) && strlen($_POST["lastname"]) > 1
			&& isset($_POST["username"]) && strlen($_POST["username"]) > 3
				&& isset($_POST["email"]) && strlen($_POST["email"]) > 5
				&& isset($_POST["password"]) && strlen($_POST["password"]) > 5
				&& isset($_POST["password2"])
				&& ($_POST["password"]) == $_POST["password2"] && isset($_POST["terms"])) {
					if( empty($_POST['token']) || $_POST['token'] != $_SESSION['token2'] ) 
						redirect("../");
				
					// Unset the token, so that it cannot be used again.
					unset($_SESSION['token2']);

					$firstname = mysql_real_escape_string($_POST["firstname"]);
					$lastname = mysql_real_escape_string($_POST["lastname"]);
					
					$username = mysql_real_escape_string($_POST["username"]);
					$username = str_replace(" ", "", $username);
					
					$pass1 = mysql_real_escape_string($_POST["password"]);
					$pass2 = mysql_real_escape_string($_POST["password2"]);
					$email = mysql_real_escape_string($_POST["email"]);
					
					$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
					$Chars_Len = 63;
					$Salt_Length = 21;
					
					$salt = "";

					for($i=0; $i<$Salt_Length; $i++)
					{
						$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
					}
					
					$hashed_password = crypt($pass1, $salt) . $salt;
					
					$sql = "INSERT INTO users_grumble(username, user_firstname, user_lastname, user_password, user_salt, user_email, user_create_date) " . 
						"VALUES('" . $username . "','" . $firstname . "','" . $lastname . "','" . $hashed_password . "','" . $salt . "','" . $email . "','" . date("Y-m-d H:i:s", time()) . "')";
					mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
					
					$id = mysql_insert_id();
					
					$sql = "INSERT INTO settings_user_grumble(user_id) " . 
						"VALUES(" . $id . ")";
					mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
					
					session_start();
					$_SESSION["user_id"] = $id;
					$_SESSION["access_lvl"] = 1;
					$_SESSION["username"] = $username;
					redirect("../");
			}
			else {
				redirect("../create-account?create=fail");
			}
			break;
			
		case "Send Email" :
			if(isset($_POST["email"]) && isset($_POST["token"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
				if( empty($_POST['token']) || $_POST['token'] != $_SESSION['token3'] ) {
						redirect("../");
				}
				
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token3']);
				
				$email = mysql_real_escape_string($_POST["email"]);
				
				$sql = "SELECT user_password FROM users_grumble " . 
					"WHERE user_email='" . $email . "'";
				$result = mysql_query($sql, $conn) or die("Could not lookup password: " . mysql_error());
				if(mysql_num_rows($result) > 0) {
					$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.';
					$Chars_Len = 63;
					$Salt_Length = 50;
					
					$salt = "";

					for($i=0; $i<$Salt_Length; $i++)
					{
						$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
					}
					
					$row = mysql_fetch_array($result);
					$subject = "Grumble password change";
					$body = "Change your password by following the link below.\n\nPaste the link below in your browser to reset your password:\n\n" . 
					"http://" . $_SERVER["HTTP_HOST"] . "/" . "forgot-password.php?hash=" . $salt . "&email=" . $email;
					
					$sql = "SELECT user_email FROM temp_password_grumble " . 
						"WHERE user_email='" . $email . "'";
					$result = mysql_query($sql, $conn) or die("Could not lookup email: " . mysql_error());
					if(mysql_num_rows($result) > 0) {
						$sql = "UPDATE temp_password_grumble SET temp_password = '" . $salt . "', temp_create = '" . date("Y-m-d H:i:s", time()) . "' WHERE user_email = '" . 
						$email . "'";
						mysql_query($sql, $conn) or die("Could not update: " . mysql_error());
					}
					else {
						$sql = "INSERT INTO temp_password_grumble (user_email, temp_password, temp_create) VALUES('" . 
							$email . "','" . $salt . "','" . date("Y-m-d H:i:s", time()) . "')";
						mysql_query($sql, $conn) or die("Could not insert: " . mysql_error());
					}
					
					mail($_POST["email"], $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send reminder email.");
					redirect("../forgot-password?success=1");
				}
				else {
					redirect("../forgot-password?error=1");
				}
			}
			else {
				redirect("../login");
			}
			break;
		
		case "Reset Password" :
			if(isset($_POST["password"]) and strlen($_POST["password"]) > 5 and isset($_POST["password2"])
				and isset($_POST["email"]) and $_POST["password"] == $_POST["password2"] && isset($_POST["token"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
				if( empty($_POST['token']) || $_POST['token'] != $_SESSION['token3'] ) 
						redirect("../");
				
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token3']);
					
				$email = mysql_real_escape_string($_POST["email"]);
				$password = mysql_real_escape_string($_POST["password"]);
				
				$sql = "SELECT user_salt FROM users_grumble " . 
					"WHERE user_email='" . $email . "'";
				$result = mysql_query($sql, $conn) or die("Could not lookup password: " . mysql_error());
				if(mysql_num_rows($result) > 0) {
					$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
					$Chars_Len = 63;
					$Salt_Length = 21;
					
					$salt = "";
	
					for($i=0; $i<$Salt_Length; $i++)
					{
						$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
					}
					
					$hashed_password = crypt($password, $salt) . $salt;
					
					$sql = "UPDATE users_grumble " .
						"SET user_password='" . $hashed_password . 
						"', user_salt='" . $salt . "' " .
						"WHERE user_email='" . $email . "'";
					mysql_query($sql, $conn) or die("Could not update your user account: " . mysql_error());
				}
				else {
					redirect("../login");
				}
			}
			redirect("../login");
			break;
		}
	}
	else {
		redirect("../");	
	}
?>