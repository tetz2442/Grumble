<?php
//require the general classes
require("basecontroller.php");
require("basemodel.php");
//require utility functions
require("inc/functions.php");
//require defined
require("inc/config.php");
//require classes that will be used application wide
require("model/usermodel.php");
require("model/categorymodel.php");

class Loader {
	private $controller, $action, $urlvalues;

	//store the URL values on creation
	public function __construct($urlvalues) {
		$this->urlvalues = $urlvalues;
		if($this->urlvalues["controller"] == "") {
			$this->controller = "home";
			//require the model class
			require("model/homemodel.php");
			//require the controller class
			require("controller/home.php");
		}
		else {
			$this->controller = $this->urlvalues["controller"] . "controller";
			//require correct controller and model based on url
			//model filenames should go "model/[viewname]model.php"
			//controller filenames should go "controller/[viewname].php"
			require("model/" . $this->urlvalues["controller"] . "model.php");
			require("controller/" . $this->urlvalues["controller"] . "controller.php");
		}
		if($this->urlvalues["action"] == "") {
			$this->action = "index";
		}
		else {
			$this->action = $this->urlvalues["action"];
		}
	}

	//establish the requested controller as an object
	public function createController() {
		//does the class exist?
		if(class_exists($this->controller)) {
			$parents = class_parents($this->controller);
			//does the cass extend the controller class?
			if(in_array("BaseController", $parents)) {
				//does the class contain the requested method?
				if(method_exists($this->controller, $this->action)) {
					return new $this->controller($this->action,$this->urlvalues);
				}
				else {
					//bad method error
					return new Error("badUrl", $this->urlvalues);
				}
			}
			else {
				//bad controller error
				return new Error("badUrl", $this->urlvalues);
			}
		}
		else {
			//bad controller error
			return new Error("badUrl", $this->urlvalues);
		}
	}
}
?>