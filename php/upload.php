<?php 
require_once "http.php";
require_once "conn.php";
//max size of image
 $max_size = 2000000;
 session_start();
 if(($_FILES["files"]["type"] == "image/jpeg")
|| ($_FILES["files"]["type"] == "image/jpg") &&
isset($_POST["files"]) && isset($_SESSION["username"])) {
	
	 if($_FILES['files']['size'] > $max_size) {
		//echo("File is too large. Must be less than 1MB");
		redirect("../imageupload.php?error=type1");
	 }
	 else {
		$image = $_FILES["files"]["name"];
		$img_source = $_FILES['files']['tmp_name']; // image path/name
		
		$filenameThumb = "tmp/0" . stripslashes($_FILES["files"]["name"]);
		$filenameProfile = "tmp/1" . stripslashes($_FILES["files"]["name"]);
		$extension = getExtension($filenameThumb);
		
		$thumb_path = "user-images/thumbnail/";
		$profile_path = "user-images/profile/";
		
		//grab width and height of image
		list($width, $height) = getimagesize($img_source);
		
		if($extension == "jpg" || $extension == "jpeg") {
			$source = imagecreatefromjpeg($img_source);
		}
		else {
			//image image isnt right filettype
			redirect("../imageupload.php?error=type2");
		}
		if($width < 100 || $height < 100) {
			//image is too small
			redirect("../imageupload.php?error=type3");
		}
		
		//gets correct ratio for profile picture
		$max_height = 300;
		$max_width = 225;
		if($height > $max_height || $width > $max_width)
        {
                if($width > $height)
                {
                        $large_width = $max_width;
                        $large_height = ceil(($height * $large_width)/$width);
                }
                else
                {
                        $large_height = $max_height;
                        $large_width = ceil(($width * $large_height)/$height);
                }
        } 
		else {
                $large_width = $width;
                $large_height = $height;
        }
		
		session_start();
		$upload_type = "new";
		$last_id = 0;
		$image_name = 0;
		//check if image already exists
		$sql = "SELECT image_id FROM images_grumble WHERE " . 
			"user_id = " . $_SESSION["user_id"];
		$result = mysql_query($sql, $conn);
		$numrows = mysql_num_rows($result);
		if($numrows == 0) {
			$row = mysql_fetch_array($result);
			//insert image into image table
			$sql = "INSERT INTO images_grumble (user_id) VALUES " . 
				"(". $_SESSION["user_id"] . ")";
			mysql_query($sql, $conn) or die("Could not add image: " . mysql_error());
			//get image_id number to insert into user table
			$last_id = mysql_insert_id();
			$image_name = $last_id;
		}
		else {
			$row = mysql_fetch_array($result);
			$upload_type = "update";
			$image_name = $row["image_id"];
		}
		
		//create temporary image file
		$tmp = imagecreatetruecolor($large_width, $large_height);
		//copy the image to one with te new width and height
		imagecopyresampled($tmp, $source, 0, 0, 0, 0, $large_width, $large_height, $width, $height);
		//create image file with 100% quality
		imagejpeg($tmp, $image_name, 90);
		$final_profile_name = $profile_path . $image_name . "." .  $extension;
		rename($image_name, $final_profile_name);
		
		/*$img_binary = fread(fopen($filenameProfile, "r"), filesize($filenameProfile));
		$img_string = base64_encode($img_binary);*/
		
		$src_x = $width/2 - ($thumbWidth/2);
		$src_y = $height/2 - ($thumbHeight / 2);
		
		//create thumbnail
		$thumbWidth = 75;
		$thumbHeight = 75;
		//create temporary image file
		$tmp = imagecreatetruecolor($thumbWidth, $thumbHeight);
		//copy the image to one with te new width and height
		imagecopyresampled($tmp, $source, 0, 0, $src_x, $src_y, $thumbWidth, $thumbHeight, $width, $height);
		//create image file with 100% quality
		imagejpeg($tmp, $image_name, 90);
		$thumb_filename = "tmp/" . $_FILES["files"]["name"];
		$final_thumb_name = $thumb_path . $image_name . "." . $extension;
		rename($image_name, $final_thumb_name);
		
		/*$img_binary2 = fread(fopen($filenameThumb, "r"), filesize($filenameThumb));
		$img_string2 = base64_encode($img_binary2);*/
		
		imagedestroy($source);
		imagedestroy($tmp);
		
		if($upload_type == "new") {
			//insert image into image table
			$sql = "INSERT INTO images_grumble (profile_image, thumbnail, user_id) VALUES " . 
				"('" . $final_profile_name . "','" . $final_thumb_name . "'," . $_SESSION["user_id"] . ")";
			mysql_query($sql, $conn) or die("Could not add image: " . mysql_error());
			//insert image id into user table
			$sql = "UPDATE users_grumble SET user_image_id = " . $image_name . 
				" WHERE user_id = " . $_SESSION["user_id"];;
			mysql_query($sql, $conn) or die("Could not add image: " . mysql_error());
			
			unlink($filenameThumb);
			unlink($filenameProfile);
			redirect("../profile.php?id=" . $_SESSION["username"]);
		}
		else if($upload_type == "update") {
			//update image into image table
			$sql = "UPDATE images_grumble SET profile_image = '" . $final_profile_name . 
				"', thumbnail = '" . $final_thumb_name . "' WHERE user_id = " . $_SESSION["user_id"];
			mysql_query($sql, $conn) or die("Could not add image: " . mysql_error());
			
			unlink($filenameThumb);
			unlink($filenameProfile);
			redirect("../profile.php?id=" . $_SESSION["username"]);
		}
		else {
			die("ERROR");	
		}
	 }
}
else {
	//wrong fileype
	redirect("../imageupload.php?error=type2");
}

function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
?>