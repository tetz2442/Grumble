<?php
	require_once "conn.php";
	require_once "http.php";
	require_once "sendemail.php";
	session_start();
	if(isset($_REQUEST["action"])) {
		switch ($_REQUEST["action"]) {
		case "Sign In" :
			if(isset($_POST["email"]) && strlen($_POST["email"]) > 0 && isset($_POST["password"]) && strlen($_POST["password"]) > 0 && isset($_POST["referrer"]) && (!empty($_POST['token']) || $_POST['token'] == $_SESSION['token'] )) {
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token']);
				
				$email = mysql_real_escape_string(strip_tags($_POST["email"]));
				$password = mysql_real_escape_string(strip_tags($_POST["password"]));
					
				$sql = "SELECT user_id, access_lvl, username, user_password, user_salt, user_timezone " .
					"FROM users_grumble " .
					"WHERE user_email='" . $email . "' AND user_verified = 1 LIMIT 0,1";
				$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
				$row = mysql_fetch_array($result);
				$hashed_pass = crypt($password, $row['user_salt']) . $row["user_salt"];
				
				$refer = strip_tags($_POST["referrer"]);
				//email was entered wrong
				if(mysql_num_rows($result) == 0) {
					redirect("../login?login=failed&email=" . $email);
				}
				else if($hashed_pass == $row["user_password"]) {
					session_start();
					$_SESSION["user_id"] = $row["user_id"];
					$_SESSION["access_lvl"] = $row["access_lvl"];
					$_SESSION["username"] = $row["username"];	
					$_SESSION["timezone"] = $row["user_timezone"];
					
					//mysql_query("SET time_zone = " . $row["user_timezone"], $conn);
					if(isset($_POST["remember-box"])) {
						$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
						$Chars_Len = 63;
						$Salt_Length = 25;
						
						$salt = "";
	
						for($i=0; $i<$Salt_Length; $i++)
						{
							$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
						}
					
						$cookie_text = crypt($salt);
						$sql = "SELECT user_id FROM cookies_grumble WHERE user_id=" . $_SESSION["user_id"] . " LIMIT 0,1";
						$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
						if(mysql_num_rows($result) == 0) {
							$sql = "INSERT INTO cookies_grumble(cookie_text, cookie_expire, user_id) VALUES('" . $cookie_text . "','" . date("Y-m-d H:i:s", time()+7*24*60*60) . "'," . $_SESSION["user_id"] . ")";
							mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
						}
						else {
							$sql = "UPDATE cookies_grumble SET cookie_text='" . $cookie_text . "', cookie_expire = '" . date("Y-m-d H:i:s", time()+7*24*60*60) . "' WHERE user_id = " . $_SESSION["user_id"];
							mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
						}
						
						setcookie("user_grumble", $cookie_text, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST']);
					}

					if(strpos($refer, "login.php") || strpos($refer, "index.php") || strpos($refer, "create-account.php"))
						redirect("../");
					else
						redirect($refer);
				}
				else if($hashed_pass != $row["user_password"]) {
					redirect("../login?login=failed&email=" . $email);	
				}
				else {
					redirect($refer . "../login?login=failed");	
				}
			}
			else {
				redirect($refer . "../login?login=failed");	
			}
		break;
		
		case "Logout" :
			if(isset($_SESSION["user_id"])) {
				setcookie("user_grumble","", time()-7*24*60*60, "/", $_SERVER['HTTP_HOST']);
				session_unset();
				session_destroy();
				redirect("../");
			}
			else {
				redirect("../");
			}
			break;
			
		case "Create Account" :
			if(isset($_POST["firstname"]) && strlen($_POST["firstname"]) > 1 && isset($_POST["lastname"]) && strlen($_POST["lastname"]) > 1
			&& isset($_POST["username"]) && strlen($_POST["username"]) > 3 && isset($_POST["email"]) && strlen($_POST["email"]) > 5 && isset($_POST["password"]) && strlen($_POST["password"]) > 5 && isset($_POST["password2"])
				&& ($_POST["password"]) == $_POST["password2"] && isset($_POST["terms"]) && ( !empty($_POST['token']) || $_POST['token'] == $_SESSION['token2']) && isset($_POST["tz"]) && $_POST["tz"] != "none") {
					// Unset the token, so that it cannot be used again.
					unset($_SESSION['token2']);
					
					$username = mysql_real_escape_string($_POST["username"]);
					$username = str_replace(" ", "", $username);
					//validate username further
					if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {

						$firstname = mysql_real_escape_string($_POST["firstname"]);
						$lastname = mysql_real_escape_string($_POST["lastname"]);
						
						$pass1 = mysql_real_escape_string($_POST["password"]);
						$pass2 = mysql_real_escape_string($_POST["password2"]);
						$email = mysql_real_escape_string($_POST["email"]);
						$timezone = mysql_real_escape_string($_POST["tz"]);
						
						$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
						$Chars_Len = 63;
						$Salt_Length = 21;
						
						$salt = "";
	
						for($i=0; $i<$Salt_Length; $i++)
						{
							$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
						}
						
						$hashed_password = crypt($pass1, $salt) . $salt;
						
						$sql = "INSERT INTO users_grumble(username, user_firstname, user_lastname, user_password, user_salt, user_email, user_create_date, user_timezone) " . 
							"VALUES('" . $username . "','" . $firstname . "','" . $lastname . "','" . $hashed_password . "','" . $salt . "','" . $email . "',UTC_TIMESTAMP(),'" . $timezone . "')";
						mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
						
						$id = mysql_insert_id();
						
						$sql = "INSERT INTO settings_user_grumble(user_id) " . 
							"VALUES(" . $id . ")";
						mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
						
						//redo salt
						$Salt_Length = 50;
						$salt = "";
	
						for($i=0; $i<$Salt_Length; $i++)
						{
							$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
						}
						
						$sql = "INSERT INTO temp_password_grumble (user_email, temp_password, temp_create) VALUES('" . 
							$email . "','" . $salt . "','" . date("Y-m-d H:i:s", time()) . "')";
						mysql_query($sql, $conn) or die("Could not insert: " . mysql_error());
						/*session_start();
						$_SESSION["user_id"] = $id;
						$_SESSION["access_lvl"] = 1;
						$_SESSION["username"] = $username;
						$_SESSION["timezone"] = $timezone;*/
						
						$parameters = array("http://" . $_SERVER["HTTP_HOST"] . "/php/transact-user.php?email=" . $email . "&hash=" . $salt . "&action=verify");
						sendEmail($email, "From: no-reply@grumbleonline.com", "verify", $parameters);
						redirect("../create-account?user_created=1");
					}
					else {
						redirect("../create-account?create=fail");
					}
			}
			else {
				redirect("../create-account?create=fail");
			}
			break;
			
		case "Send Email" :
			if(isset($_POST["email"]) && isset($_POST["token"]) && $_SERVER['REQUEST_METHOD'] == "POST" && (!empty($_POST['token']) || $_POST['token'] == $_SESSION['token3']) ) {
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token3']);
				
				$email = mysql_real_escape_string($_POST["email"]);
				
				$sql = "SELECT user_email FROM users_grumble " . 
					"WHERE user_email='" . $email . "' AND user_verified = 1 LIMIT 0,1";
				$result = mysql_query($sql, $conn) or die("Could not lookup email: " . mysql_error());
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
					$subject = "[Grumble] password change";
					$body = "Change your password by following the link below.\n\nClick the link or paste it in your browser to reset your password:\n\n" . 
					"http://" . $_SERVER["HTTP_HOST"] . "/" . "forgot-password?hash=" . $salt . "&email=" . $email;
					
					$sql = "SELECT user_email FROM temp_password_grumble " . 
						"WHERE user_email='" . $email . "' LIMIT 0,1";
					$result = mysql_query($sql, $conn) or die("Could not lookup email: " . mysql_error());
					if(mysql_num_rows($result) > 0) {
						$sql = "UPDATE temp_password_grumble SET temp_password = '" . $salt . "', temp_create = '" . date("Y-m-d H:i:s", time()+3*24*60*60) . "' WHERE user_email = '" . 
						$email . "'";
						mysql_query($sql, $conn) or die("Could not update: " . mysql_error());
					}
					else {
						$sql = "INSERT INTO temp_password_grumble (user_email, temp_password, temp_create) VALUES('" . 
							$email . "','" . $salt . "','" . date("Y-m-d H:i:s", time()+3*24*60*60) . "')";
						mysql_query($sql, $conn) or die("Could not insert: " . mysql_error());
					}
					
					mail($email, $subject, $body, "From: no-reply@grumbleonline.com") or die("Could not send reminder email.");
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
				and isset($_POST["email"]) and $_POST["password"] == $_POST["password2"] && isset($_POST["hash"]) && $_SERVER['REQUEST_METHOD'] == "POST" && (!empty($_POST['token']) || $_POST['token'] == $_SESSION['token3'])) {		
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token3']);
					
				$email = mysql_real_escape_string($_POST["email"]);
				$password = mysql_real_escape_string($_POST["password"]);
				$hash = mysql_real_escape_string($_POST["hash"]);
				
				$sql = "SELECT ug.user_id FROM temp_password_grumble AS tpg " .
				"LEFT OUTER JOIN users_grumble AS ug ON ug.user_email = tpg.user_email " .
				"WHERE tpg.temp_password ='" .	$hash. "' AND tpg.user_email ='" . $email . "' LIMIT 0,1";
				$result = mysql_query($sql, $conn) or die("Could not lookup temp password: " . mysql_error());
				if(mysql_num_rows($result) != 0) {
					$row = mysql_fetch_assoc($result);
					$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.';
					$Chars_Len = 63;
					$Salt_Length = 21;
					
					$salt = "";
	
					for($i=0; $i<$Salt_Length; $i++)
					{
						$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
					}
					
					$hashed_password = crypt($password, $salt) . $salt;
					
					$sql = "UPDATE users_grumble SET user_password='" . $hashed_password . "', user_salt='" . $salt . "' WHERE user_id = " . intval($row["user_id"]);
					mysql_query($sql, $conn) or die("Could not update your user account: " . mysql_error());
					$sql = "DELETE FROM temp_password_grumble WHERE user_email = '" . $email . "'";
					mysql_query($sql, $conn) or die("Could not update your user account: " . mysql_error());
					
					redirect("../?login=1");
				}
			}
			redirect("../login");
			break;
			
		case "verify" :
			if(isset($_GET["hash"]) && strlen($_GET["hash"]) == 50 && isset($_GET["email"])) {	
				$hash = mysql_real_escape_string($_GET["hash"]);
				$email = mysql_real_escape_string($_GET["email"]);
				
				$sql = "SELECT ug.user_id, ug.username, ug.user_timezone FROM temp_password_grumble AS tpg " .
				"LEFT OUTER JOIN users_grumble AS ug ON ug.user_email = tpg.user_email AND ug.user_verified = 0 " .
				"WHERE tpg.temp_password ='" .	$hash. "' AND tpg.user_email ='" . $email . "' LIMIT 0,1";
				$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
				if(mysql_num_rows($result) == 1) {
					$row = mysql_fetch_array($result);
					$sql = "UPDATE users_grumble SET user_verified = 1 WHERE user_id = " . $row["user_id"];
					mysql_query($sql, $conn) or die("Error: " . mysql_error());
					$sql = "DELETE FROM temp_password_grumble WHERE user_email = '" . $email . "'";
					mysql_query($sql, $conn) or die("Error: " . mysql_error());
					
					$_SESSION["user_id"] = $row["user_id"];
					$_SESSION["access_lvl"] = 1;
					$_SESSION["username"] = $row["username"];
					$_SESSION["timezone"] = $row["user_timezone"];
					redirect("../");
				}
				else {
					redirect("../create-account");
				}
			}
			redirect("../");
			break;
		}
	}
	else {
		redirect("../");	
	}
?>