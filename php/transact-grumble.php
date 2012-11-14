<?php
	session_start();
	require_once "conn.php";
	require_once "http.php";
	require_once "functions.php";
	require_once "notifications.php";
	
	if(isset($_REQUEST["action"]) && isset($_SESSION["username"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
		switch ($_REQUEST["action"]) {
			case "Submit Grumble" :
				if(isset($_POST["grumble"]) && strlen(trim($_POST["grumble"])) > 0 && strlen($_POST["grumble"]) <= 40 && isset($_POST["category"]) && $_POST["category"] != "Choose a Category" && 
				isset($_POST["description"]) && strlen(trim($_POST["description"])) > 0 && strlen($_POST["description"]) <= 600 && ( !empty($_POST['token']) || $_POST['token'] == $_SESSION['token4'] )) {				
					// Unset the token, so that it cannot be used again.
					unset($_SESSION['token4']);
					
					$grumble = escapeAndStrip($_POST["grumble"]);
					$category = escapeAndStrip($_POST["category"]);
					$description = escapeAndStrip($_POST["description"]);
					//remove spaces
					$description = removeNewLine(trim($description));
					$grumble = removeNewLine(trim($grumble));
					
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
								"','" . $description . "',UTC_TIMESTAMP(),'" . $seo . "'," . $_SESSION["user_id"] . ")";
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
				
				case "voteup" :
				if(isset($_SESSION["user_id"]) && isset($_POST["subcatid"]) && is_numeric($_POST["subcatid"])) {
					$id = escapeAndStrip($_POST["subcatid"]);
					
					//see if sub category exists
					$sql = "SELECT scg.sub_category_id, scg.sub_category_url, cg.category_url, ug.user_id FROM sub_category_grumble AS scg " .
						"LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id " .
						"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = scg.user_id " .
						"WHERE scg.sub_category_id = " . $id . " LIMIT 0,1";
					$result = mysql_query($sql, $conn) or die("Could not like Grumble: " . mysql_error());
					$row = mysql_fetch_array($result);
					//see if user has already liked
					$sql = "SELECT grumble_like_id FROM user_grumble_likes " .
						"WHERE sub_category_id = " . $id . " AND " . 
						"user_id = " . $_SESSION["user_id"] . " LIMIT 0,1";
					$result2 = mysql_query($sql, $conn) or die("Could not like Grumble: " . mysql_error());
					if(mysql_num_rows($result) != 0 && mysql_num_rows($result2) != 1) {
						//insert into grumble likes table
						$sql = "INSERT INTO user_grumble_likes(user_id, sub_category_id) VALUES(" . $_SESSION["user_id"] . "," . $id . ")";
						$result = mysql_query($sql, $conn) or die("Could not like Grumble: " . mysql_error());
						//if user did not like his own Grumble, insert notification
						if($_SESSION["user_id"] != $row["user_id"]) {
							$url = "http://" . $_SERVER["HTTP_HOST"] . "/" . $row["category_url"] . "/" . $row["sub_category_url"] . "/" . $row["sub_category_id"];
							insertNotification($row["user_id"], $_SESSION["user_id"], $_SESSION["username"], $url, "grumbleupvote");
						}
						echo 1;
					}
					else {
						echo 0;
					}
				}
				break;
				
				case "Delete" :
					if(isset($_POST["id"]) && is_numeric($_POST["id"])) {
						$id = mysql_real_escape_string($_POST["id"]);
			
						//check if status is there and user is owner
						$sql = "SELECT ug.username, scg.sub_category_id FROM sub_category_grumble AS scg " .
						"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = scg.user_id " . 
						"WHERE scg.sub_category_id = " . $id . " LIMIT 0,1";
						$result = mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
						if(mysql_num_rows($result) != 0) {
							$row = mysql_fetch_array($result);
							if($row["username"] == $_SESSION["username"]) {
								//delete (grumble (grumble votes))
								$sql = "DELETE FROM sub_category_grumble WHERE sub_category_id = " . $id;
								mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
								$sql = "DELETE FROM user_grumble_likes WHERE sub_category_id = " . $id;
								mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
								
								$sql = "SELECT status_id FROM status_grumble WHERE sub_category_id = " . $id;
								$result = mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
								while($row = mysql_fetch_array($result)) {
									//delete comments (replies, votes up)
									$sql = "DELETE FROM status_grumble WHERE status_id = " . $row["status_id"] . " LIMIT 1";
									mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
									$sql = "DELETE FROM replies_grumble WHERE status_id = " . $row["status_id"];
									mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
									$sql = "DELETE FROM user_likes_grumble WHERE status_id = " . $row["status_id"];
									mysql_query($sql, $conn) or die("Could not delete: " . mysql_error());
								}
								
								echo 1;
							}
							else {
								echo 0;	
							}
						}
						else {
							echo 0;	
						}
					}
					else {
						echo 0;	
					}
				break;
		}
	}
	else {
		redirect("../?login=1");
	}
?>