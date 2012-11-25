<?php
//display errors in production mode
ini_set("display_errors", 1);

//require loader class
require("classes/loader.php");

//create the controller and execute the action
$loader = new Loader($_GET);
$controller = $loader->createController();
$controller->executeAction();
?>