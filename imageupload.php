<?php 
require_once "php/conn.php";
require_once "php/http.php";
require_once "php/header.php";
require_once("php/containerWide.php");
if(!isset($_SESSION["user_id"])) {
	redirect("login.php");
}

if(isset($_GET["error"])) {
	$error = mysql_real_escape_string($_GET["error"]);
	if($error ==  "type1") {
		echo "<h3>Image must be under 1MB.</h3>";
	}
	else if($error ==  "type2") {
		echo "<h3>Incorrect Filetype.</h3>";
	}
	else if($error ==  "type3") {
		echo "<h3>Image selected is too small.</h3>";
	}
}
?>
<form method="post" enctype="multipart/form-data" action="php/upload.php">
		Choose an image to upload:<input name="files" type="file" id="choose"/><br/><br/>
		<input type="submit" value="Upload Image" id="upload"/>
</form>
<?php require_once "php/footer.php"; ?>