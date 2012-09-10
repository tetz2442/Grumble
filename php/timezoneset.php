<?php
    if(!isset($_SESSION["user_id"]) && isset($_POST["time"])) {
    	session_start();
    	$_SESSION['time'] = strip_tags($_POST['time']);
    }
?>