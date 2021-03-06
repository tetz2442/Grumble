<?php
	require_once "conn.php";
	require_once "http.php";
	require_once "functions.php";
	session_start();
	if(isset($_REQUEST["action"])) {
		switch ($_REQUEST["action"]) {
		case "Sign In" :
			if(isset($_POST["email"]) && strlen($_POST["email"]) > 0 && isset($_POST["password"]) && strlen($_POST["password"]) > 0 && isset($_POST["referrer"]) && (!empty($_POST['token']) || $_POST['token'] == $_SESSION['token'] )) {
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token']);
				$email = escapeAndStrip(strtolower($_POST["email"]));
				$password = escapeAndStrip($_POST["password"]);
					
				$sql = "SELECT user_id, user_email, access_lvl, username, user_password, user_salt, user_timezone " .
					"FROM users_grumble " .
					"WHERE (LOWER(user_email)='" . $email . "' OR LOWER(username) = '" . $email . "') AND user_verified = 1 LIMIT 0,1";
				$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
				$row = mysql_fetch_array($result);
				$hashed_pass = crypt($password, $row['user_salt']) . $row["user_salt"];
				
				$refer = strip($_POST["referrer"]);
				//email was entered wrong
				if(mysql_num_rows($result) == 0) {
					redirect("../login?login=failed&email=" . $email);
				}
				else if($hashed_pass == $row["user_password"]) {
					$_SESSION["user_id"] = $row["user_id"];
					$_SESSION["access_lvl"] = $row["access_lvl"];
					$_SESSION["username"] = $row["username"];	
					$_SESSION["email"] = $row["user_email"];	
					$_SESSION["timezone"] = $row["user_timezone"];
					
					//mysql_query("SET time_zone = " . $row["user_timezone"], $conn);
					if(isset($_POST["remember-box"])) {
						$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
						$Chars_Len = 63;
						$Salt_Length = 50;
						
						$salt = "";
	
						for($i=0; $i<$Salt_Length; $i++)
						{
							$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
						}
					
						$cookie_text = crypt($salt);
						$sql = "SELECT cookie_id FROM cookies_grumble WHERE user_id=" . $_SESSION["user_id"] . " LIMIT 0,1";
						$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
						$row = mysql_fetch_array($result);
						if(mysql_num_rows($result) == 0 || (!isset($_COOKIE["user_grumble"]) && !isset($_COOKIE["cookie_id"]))) {
							$sql = "INSERT INTO cookies_grumble(cookie_text, cookie_expire, user_id) VALUES('" . $cookie_text . "','" . date("Y-m-d H:i:s", time()+7*24*60*60) . "'," . $_SESSION["user_id"] . ")";
							mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
							$id = mysql_insert_id();
						}
						else {
							$sql = "UPDATE cookies_grumble SET cookie_text='" . $cookie_text . "', cookie_expire = '" . date("Y-m-d H:i:s", time()+7*24*60*60) . "' WHERE user_id = " . $_SESSION["user_id"] . " AND cookie_id = " . $row["cookie_id"];
							mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
							$id = $row["cookie_id"];
						}
						
						setcookie("user_grumble", $cookie_text, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST']);
						setcookie("cookie_id", $id, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST']);
					}

					if(strpos($refer, "login.php") || strpos($refer, "index.php") || strpos($refer, "create-account.php") || strpos($refer, "forgot-password.php"))
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
				if(isset($_COOKIE["user_grumble"]) && isset($_COOKIE["cookie_id"])) {
					$sql = "DELETE FROM cookies_grumble WHERE cookie_id = " . $_COOKIE["cookie_id"] . " AND cookie_text = '" . $_COOKIE["user_grumble"] . "'";
					mysql_query($sql, $conn) or die("Error, could not logout: " . mysql_error());
					setcookie("user_grumble","", time()-7*24*60*60, "/", $_SERVER['HTTP_HOST']);
					setcookie("cookie_id","", time()-7*24*60*60, "/", $_SERVER['HTTP_HOST']);
				}
				//if logged in socially, destroy session
				if(isset($_SESSION["social"])) {
					$config = dirname(__FILE__) . '/hybridauth/config.php';
				    require_once( "hybridauth//Hybrid/Auth.php" );
				    try{
				       // initialize Hybrid_Auth with a given file
				       $hybridauth = new Hybrid_Auth( $config );
				 
				       // try to authenticate with the selected provider
				       $adapter = $hybridauth->authenticate( $_SESSION["social"]);
				 
				       $adapter->logout();
				    }
				    catch( Exception $e ){
				       echo "Error: " . $e->getMessage();
				    }
				}
				
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
					
					$username = escapeAndStrip($_POST["username"]);
					$username = replaceSpaces($username);
					$pass1 = escapeAndStrip($_POST["password"]);
					$pass2 = escapeAndStrip($_POST["password2"]);
					$firstname = escapeAndStrip($_POST["firstname"]);
					$lastname = escapeAndStrip($_POST["lastname"]);
					
					$email = escapeAndStrip($_POST["email"]);
					$timezone = escapeAndStrip($_POST["tz"]);
					
					$sql = "SELECT user_email FROM users_grumble WHERE user_email = '" . $email . "'";
					$result = mysql_query($sql, $conn);
					//check if user email is taken
					if(mysql_num_rows($result) == 0) {
						//validate username further
						if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)
							&& preg_match('/[A-Z]/', $pass1) && preg_match('/[0-9]/', $pass1) && checkTimeZone($_POST["tz"])) {
							
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
							
							$parameters = array("http://" . $_SERVER["HTTP_HOST"] . "/php/transact-user.php?email=" . $email . "&hash=" . $salt . "&action=verify");
							sendEmail($email, "no-reply@grumbleonline.com", "verify", $parameters);
							redirect("../create-account?user_created=1");
						}
						else {
							redirect("../create-account?type=grumble&create=fail&email=" . $email . "&fullname=" . $firstname . " " . $lastname . "&username=" . $username);
						}
					}
					else {
						redirect("../create-account?type=grumble&create=fail");
					}
			}
			else {
				redirect("../create-account?type=grumble&create=fail");
			}
			break;
			
		case "Send Email" :
			if(isset($_POST["email"]) && isset($_POST["token"]) && $_SERVER['REQUEST_METHOD'] == "POST" && (!empty($_POST['token']) || $_POST['token'] == $_SESSION['token3']) ) {
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token3']);
				
				$email = escapeAndStrip($_POST["email"]);
				
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
					
					$parameters = array("http://" . $_SERVER["HTTP_HOST"] . "/" . "forgot-password?hash=" . $salt . "&email=" . $email);
					sendEmail($email, "no-reply@grumbleonline.com", "resetpassword", $parameters);
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
				and isset($_POST["email"]) and $_POST["password"] == $_POST["password2"] && isset($_POST["hash"]) 
				&& $_SERVER['REQUEST_METHOD'] == "POST" && (!empty($_POST['token']) || $_POST['token'] == $_SESSION['token3'])
				&& preg_match('/[A-Z0-9]/', $_POST["password"])) {		
				// Unset the token, so that it cannot be used again.
				unset($_SESSION['token3']);
					
				$email = escapeAndStrip($_POST["email"]);
				$password = escapeAndStrip($_POST["password"]);
				$hash = escapeAndStrip($_POST["hash"]);
				
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
					
					redirect("../login?email=" . $email);
				}
			}
			redirect("../login");
			break;
			
		case "verify" :
			if(isset($_GET["hash"]) && strlen($_GET["hash"]) == 50 && isset($_GET["email"])) {	
				$hash = escapeAndStrip($_GET["hash"]);
				$email = escapeAndStrip($_GET["email"]);
				
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

		case "sociallogin" :
			if(isset($_GET["provider"])) {	
			   $config = dirname(__FILE__) . '/hybridauth/config.php';
			   require_once( "hybridauth//Hybrid/Auth.php" );
			 
			   // the selected provider
			   $provider_name = escapeAndStrip($_GET["provider"]);
			 
			   try{
			       // initialize Hybrid_Auth with a given file
			       $hybridauth = new Hybrid_Auth( $config );
			 
			       // try to authenticate with the selected provider
			       $adapter = $hybridauth->authenticate( $provider_name );
			 
			       // then grab the user profile 
			       $user_profile = $adapter->getUserProfile();
				  
				   $email = $user_profile->emailVerified;
				   if(strlen($email) == 0)
				   	$email = $user_profile->email;
				   
				   //check if user is already in the DB
			    	$sql = "SELECT user_id " .
					"FROM authentications " .
					"WHERE provider_uid = '" . $user_profile->identifier . "' AND provider = '" . $provider_name . "' LIMIT 0,1";
					$result = mysql_query($sql, $conn) or die("Could get account: " . mysql_error());
					//user does not exist, add them
					if(mysql_num_rows($result) == 0) {
						//check if user has already created an account
						$sql = "SELECT user_id FROM users_grumble " .
						"WHERE user_email = '" . $email . "' LIMIT 0,1";
						$result = mysql_query($sql, $conn) or die("Could not login: " . mysql_error());
						//user has not created an account
						if(mysql_num_rows($result) == 0) {
							//$username = $user_profile->firstName . $user_profile->lastName;
							//$username = replaceSpaces($username);
							$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.';
							$Chars_Len = 63;
							$Salt_Length = 15;
							
							$salt = "";
			
							for($i=0; $i<$Salt_Length; $i++)
							{
								$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
							}
							
							$sql = "INSERT INTO users_grumble(username, user_firstname, user_lastname, user_password, user_salt, user_email, user_create_date, user_timezone) " . 
								"VALUES('" . $salt . "','" . $user_profile->firstName . "','" . $user_profile->lastName . "','" . "none" . "','" . "none" . "','" . $email . "',UTC_TIMESTAMP(),'America/Chicago')";
							mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
							
							$id = mysql_insert_id();
							
							$sql = "INSERT INTO settings_user_grumble(user_id) " . 
								"VALUES(" . $id . ")";
							mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
							
							$row = mysql_fetch_assoc($result);
					
							$sql = "INSERT INTO authentications(user_id, provider, provider_uid, created_at) " . 
								"VALUES(" . $id. ",'" . $provider_name . "','" . $user_profile->identifier . "', UTC_TIMESTAMP())";
							mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
							
							$token = md5(uniqid(rand(), true));
							//start some session variables
							$_SESSION["social_token"] = $token;
							$_SESSION["verified_email"] = $user_profile->emailVerified;
							$_SESSION["provider"] = $provider_name;
							$_SESSION["social_query_string"] = "?social_create=1&username=" . $username . "&token=" . $token . "&provider=" . $provider_name;
							
							redirect("../create-account?social_create=1&username=" . $username . "&token=" . $token . "&provider=" . $provider_name);
						}
						//user has created an account already with grumble, enter them into the authenticated table
						else {
							//get profile info
							$sql = "SELECT user_email, access_lvl, user_id, username, user_timezone FROM users_grumble " .
							"WHERE user_email = '" . $email . "' LIMIT 0,1";
							$result = mysql_query($sql, $conn) or die("Could not login: " . mysql_error());
							//if email exists, connect accounts
							if(mysql_num_rows($result) == 1) {
								//insert into authenticated table
								$row = mysql_fetch_array($result);
							
								$sql = "INSERT INTO authentications(user_id, provider, provider_uid, created_at) " . 
									"VALUES(" . $row["user_id"] . ",'" . $provider_name . "','" . $user_profile->identifier . "', UTC_TIMESTAMP())";
								mysql_query($sql, $conn) or die("Could not update user account: " . mysql_error());
							
								$_SESSION["user_id"] = $row["user_id"];
								$_SESSION["access_lvl"] = $row["access_lvl"];
								$_SESSION["username"] = $row["username"];	
								$_SESSION["email"] = $row["user_email"];	
								$_SESSION["timezone"] = $row["user_timezone"];
								$_SESSION["social"] = $provider_name;
								
								redirect("../");
							}
							else {
								//email is incorrect and not in user table
								redirect("../login");
							}
						}
					}
					//log user in, credentials are good
					else {
						$row = mysql_fetch_array($result);
						$sql = "SELECT user_id, user_email, access_lvl, username, user_password, user_salt, user_timezone " .
						"FROM users_grumble " .
						"WHERE user_id = " . $row["user_id"] . " AND user_verified = 1 LIMIT 0,1";
						$result = mysql_query($sql, $conn) or die("Could not login: " . mysql_error());
						if(mysql_num_rows($result) != 0) {
							$row = mysql_fetch_array($result);
							
							$_SESSION["user_id"] = $row["user_id"];
							$_SESSION["access_lvl"] = $row["access_lvl"];
							$_SESSION["username"] = $row["username"];	
							$_SESSION["email"] = $row["user_email"];	
							$_SESSION["timezone"] = $row["user_timezone"];
							$_SESSION["social"] = $provider_name;

							$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
							$Chars_Len = 63;
							$Salt_Length = 50;
							
							$salt = "";
		
							for($i=0; $i<$Salt_Length; $i++)
							{
								$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
							}
						
							$cookie_text = crypt($salt);
							$sql = "SELECT cookie_id FROM cookies_grumble WHERE user_id=" . $_SESSION["user_id"] . " LIMIT 0,1";
							$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
							$row = mysql_fetch_array($result);
							if(mysql_num_rows($result) == 0 || (!isset($_COOKIE["user_grumble"]) && !isset($_COOKIE["cookie_id"]))) {
								$sql = "INSERT INTO cookies_grumble(cookie_text, cookie_expire, user_id) VALUES('" . $cookie_text . "','" . date("Y-m-d H:i:s", time()+7*24*60*60) . "'," . $_SESSION["user_id"] . ")";
								mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
								$id = mysql_insert_id();
							}
							else {
								$sql = "UPDATE cookies_grumble SET cookie_text='" . $cookie_text . "', cookie_expire = '" . date("Y-m-d H:i:s", time()+7*24*60*60) . "' WHERE user_id = " . $_SESSION["user_id"] . " AND cookie_id = " . $row["cookie_id"];
								mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
								$id = $row["cookie_id"];
							}
							
							setcookie("user_grumble", $cookie_text, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST']);
							setcookie("cookie_id", $id, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST']);
						}
						
						if(isset($_GET["redirect"]))
							redirect(strip_tags($_GET["redirect"]));
						else 
							redirect("../");
					}
			   }
			   catch( Exception $e ){
			       echo "Error: " . $e->getMessage();
			   }
			}
			//redirect("../");
			break;
			
			case "Finish Registration" :
			if(isset($_POST["password"]) && strlen($_POST["password"]) > 5 && isset($_POST["password2"]) && isset($_POST["username"]) && strlen($_POST["username"]) > 3
				&& ($_POST["password"]) == $_POST["password2"] && isset($_POST["terms"]) && ( !empty($_POST['token']) || $_POST['token'] == $_SESSION['social_token']) && isset($_POST["tz"]) && $_POST["tz"] != "none") {		
					$username = escapeAndStrip($_POST["username"]);
					$username = replaceSpaces($username);
					$pass1 = escapeAndStrip($_POST["password"]);
					$pass2 = escapeAndStrip($_POST["password2"]);
					
					$timezone = escapeAndStrip($_POST["tz"]);
					
					$sql = "SELECT user_email, access_lvl, user_id, user_timezone FROM users_grumble WHERE user_email = '" . $_SESSION["verified_email"] . "'";
					$result = mysql_query($sql, $conn);
					unset($_SESSION['verified_email']);
					//check if user email is in db
					if(mysql_num_rows($result) == 1) {
						//validate password further
						if(strlen($username) >= 4 && strlen($username) <= 15 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)
						&& preg_match('/[A-Z]/', $pass1) && preg_match('/[0-9]/', $pass1) && checkTimeZone($_POST["tz"])) {
							$row = mysql_fetch_array($result);
							$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
							$Chars_Len = 63;
							$Salt_Length = 21;
							
							$salt = "";
		
							for($i=0; $i<$Salt_Length; $i++)
							{
								$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
							}
							
							$hashed_password = crypt($pass1, $salt) . $salt;
							
							//update user profile
							$sql = "UPDATE users_grumble SET username = '" . $username . "', user_password = '" . $hashed_password . "', user_salt = '" . $salt . "', user_timezone = '" . $timezone . "', user_verified = 1 
							WHERE user_email = '" . $row["user_email"] . "' LIMIT 1";
							mysql_query($sql, $conn) or die("Could not create user account: " . mysql_error());
							//create session variables
							$_SESSION["user_id"] = $row["user_id"];
							$_SESSION["access_lvl"] = $row["access_lvl"];
							$_SESSION["username"] = $username;	
							$_SESSION["email"] = $row["user_email"];	
							$_SESSION["timezone"] = $row["user_timezone"];
							$_SESSION["social"] = $_SESSION["provider"];
							unset($_SESSION["provider"]);
							unset($_SESSION['social_token']);
							unset($_SESSION['social_query_string']);
							//create cookie to login
							$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
							$Chars_Len = 63;
							$Salt_Length = 50;
							
							$salt = "";
		
							for($i=0; $i<$Salt_Length; $i++)
							{
								$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
							}
						
							$cookie_text = crypt($salt);
							$sql = "SELECT cookie_id FROM cookies_grumble WHERE user_id=" . $_SESSION["user_id"] . " LIMIT 0,1";
							$result = mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
							$row = mysql_fetch_array($result);
							if(mysql_num_rows($result) == 0 || (!isset($_COOKIE["user_grumble"]) && !isset($_COOKIE["cookie_id"]))) {
								$sql = "INSERT INTO cookies_grumble(cookie_text, cookie_expire, user_id) VALUES('" . $cookie_text . "','" . date("Y-m-d H:i:s", time()+7*24*60*60) . "'," . $_SESSION["user_id"] . ")";
								mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
								$id = mysql_insert_id();
							}
							else {
								$sql = "UPDATE cookies_grumble SET cookie_text='" . $cookie_text . "', cookie_expire = '" . date("Y-m-d H:i:s", time()+7*24*60*60) . "' WHERE user_id = " . $_SESSION["user_id"] . " AND cookie_id = " . $row["cookie_id"];
								mysql_query($sql, $conn) or die("Could not look up user information: " . mysql_error());
								$id = $row["cookie_id"];
							}
							
							setcookie("user_grumble", $cookie_text, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST']);
							setcookie("cookie_id", $id, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST']);

							redirect("../");
						}
						else {
							redirect("../create-account" . $_SESSION["social_query_string"] . "&create=fail");
						}
					}
					//user should not be here
					else {
						redirect("../create-account?create=fail");
					}
			}
			else {
				redirect("../create-account" . $_SESSION["social_query_string"] . "&create=fail");
			}
			break;
		}
	}
	else {
		redirect("../");	
	}
?>