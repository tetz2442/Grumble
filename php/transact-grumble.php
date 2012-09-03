<?php
	session_start();
	require_once "conn.php";
	require_once "http.php";
	require_once "seofriendlyurls.php";
	require_once "sendemail.php";
	
	if(isset($_REQUEST["action"]) &&
		isset($_SESSION["username"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		switch ($_REQUEST["action"]) {
			case "Submit Comment" :
			//this isnt used anymore, moved to commentajax.php
				if(isset($_POST["comment"]) && strlen($_POST["comment"]) > 0 && strlen($_POST["comment"]) <= 400 && isset($_POST["category"]) && ( !empty($_POST['token']) || $_POST['token'] == $_SESSION['token4'] )) {
					// Unset the token, so that it cannot be used again.
					unset($_SESSION['token4']);
					
					$grumble = mysql_real_escape_string(strip_tags($_POST["grumble"]));
					$category = mysql_real_escape_string(strip_tags($_POST["category"]));
					
					$sql = "SELECT sub_category_id FROM sub_category_grumble WHERE sub_category_id = " . $category . " LIMIT 0,1";
					$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
					
					//check if the entered category is valid
					if(mysql_num_rows($result) != 0) {
						//remove spaces
						$grumble = str_replace("\r", "", $grumble);
						$grumble = str_replace("\n", "", $grumble);
						
						$sql = "INSERT INTO status_grumble " .
							"(status_text, sub_category_id, date_submitted, user_id) " .
							"VALUES ('" . $grumble . "'," . $category . 
							",'" . date("Y-m-d H:i:s", time()) . 
							"'," . $_SESSION["user_id"] . ")"; 
						mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
						$last_id_status = mysql_insert_id();	
						
						$sql =  "UPDATE sub_category_grumble SET grumble_number = grumble_number + 1 WHERE sub_category_id = " . $category;
						mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
							
						/*$sql = "INSERT INTO votes_up_grumble " . 
							"(status_id) VALUES (" . $last_id_status . ")";
						mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());*/
						
						$sql =  "SELECT scg.sub_category_url, cg.category_url, COUNT(sg.status_id) AS grumble_number, ug.user_email, ug.username FROM status_grumble AS sg " .
						"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sg.user_id " .
						"LEFT OUTER JOIN sub_category_grumble AS scg ON scg.sub_category_id = sg.sub_category_id " .
						"LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id " .
						"LEFT OUTER JOIN settings_user_grumble AS sug ON sug.user_id = ug.user_id " .
						"WHERE sg.sub_category_id = " . $category . " AND sug.settings_email_thread = 1 LIMIT 0,1";
						$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
						
						if(mysql_num_rows($result) != 0) {
							$row = mysql_fetch_array($result);
							$parameters = array($row["grumble_number"], "http://" . $_SERVER["HTTP_HOST"] . "/" . $row["category_url"] . "/" . $row["sub_category_url"] . "/" . $category, $row["username"]);
							sendEmail($row["user_email"], "From: no-reply@grumbleonline.com", "grumble", $parameters);
						}
						
						$refer = ".." . strip_tags($_POST["referrer"]);
						redirect($refer);
					}
					else {
						redirect("../");
					}
				}
				else {
					redirect("../");
				}
				break;
			
			case "Submit Grumble" :
				if(isset($_POST["grumble"]) && strlen($_POST["grumble"]) > 0 && strlen($_POST["grumble"]) <= 40 && isset($_POST["category"]) && $_POST["category"] != "Choose a Category" && 
				isset($_POST["description"]) && strlen($_POST["description"]) > 0 && strlen($_POST["description"]) <= 400 && ( !empty($_POST['token']) || $_POST['token'] == $_SESSION['token4'] )) {				
					// Unset the token, so that it cannot be used again.
					unset($_SESSION['token4']);
					
					$grumble = mysql_real_escape_string(strip_tags($_POST["grumble"]));
					$category = mysql_real_escape_string(strip_tags($_POST["category"]));
					$description = mysql_real_escape_string(strip_tags($_POST["description"]));
					//remove spaces
					$description = str_replace("\r", "", $description);
					$description = str_replace("\n", "", $description);
					$grumble = str_replace("\r", "", $grumble);
					$grumble = str_replace("\n", "", $grumble);
					
					$sql = "SELECT category_url FROM categories_grumble WHERE category_id = " . $category;
					$result = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
					$catexist = mysql_num_rows($result);
					$sql = "SELECT sub_category_url, sub_category_id FROM sub_category_grumble WHERE sub_category_description = '" . $description .
					"' AND sub_category_name = '" . $grumble . "' AND user_id = " . $_SESSION["user_id"] . " LIMIT 0,1";
					$result2 = mysql_query($sql, $conn) or die("Could not submit grumble: " . mysql_error());
					$grumbleexist = mysql_num_rows($result2);
					//check if the entered category is valid
					if($catexist != 0) {
						$row = mysql_fetch_array($result);
						//check if grumble has already been created
						if($grumbleexist != 1) {
							//$bad_words = array('a','and','the','an','it','is','with','can','of','not');
							$seo = generate_seo_link($grumble,'-',false);
							
							$sql = "INSERT INTO sub_category_grumble " .
								"(category_id, sub_category_name, sub_category_description, sub_category_created, sub_category_url, user_id) " .
								"VALUES (" . $category . ",'" . $grumble . 
								"','" . $description . "','" . date("Y-m-d H:i:s", time()) . "','" . $seo . "'," . $_SESSION["user_id"] . ")";
							mysql_query($sql, $conn) or die("Could not submit thread: " . mysql_error());
							$id = mysql_insert_id();
							
							$sql = "UPDATE categories_grumble SET thread_number = thread_number + 1 WHERE category_id = " . $category;
							mysql_query($sql, $conn) or die("Could not submit thread: " . mysql_error());
							
							redirect("../" . $row["category_url"] . "/" . $seo . "/" . $id . "?create=new");
						}
						else {
							//grumble was already created (multi-submit), redirect to grumble
							$row2 = mysql_fetch_array($result2);
							redirect("../" . $row["category_url"] . "/" . $row2["sub_category_url"] . "/" . $row2["sub_category_id"]);
						}
					}
					else
						redirect("../");
				}
				else {
					redirect("../");
				}
				break;
		}
	}
	else {
		redirect("../?login=1");
	}
?>