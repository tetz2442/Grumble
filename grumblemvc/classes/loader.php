<?php
//require the general classes
require_once("basecontroller.php");
require_once("basemodel.php");
require_once("error.php");
//require utility functions
require_once("inc/functions.php");
//require defined
require_once("inc/config.php");
//require classes that will be used application wide
require_once("model/usermodel.php");

class Loader {
	private $controller, $action, $urlvalues;

	//store the URL values on creation
	public function __construct($urlvalues) {
		$this->urlvalues = $urlvalues;
		if($this->urlvalues["controller"] == "") {
			$this->controller = "home";
			$this->urlvalues["controller"] = "index";
			//require the model class
			require_once("model/categorymodel.php");
			require_once("model/grumblemodel.php");
			//require the controller class
			require_once("controller/homecontroller.php");
		}
		else {
			$this->controller = $this->urlvalues["controller"] . "controller";
			//require correct controller and model based on url
			//model filenames should go "model/[viewname]model.php"
			//controller filenames should go "controller/[viewname].php"
			if(file_exists("model/" . $this->urlvalues["controller"] . "model.php")) {
				require_once("model/" . $this->urlvalues["controller"] . "model.php");
				require_once("controller/" . $this->urlvalues["controller"] . "controller.php");
			}
			//file is simple and only needs a simplemodel
			else {
				require_once("model/simplemodel.php");
				require_once("controller/simplecontroller.php");
				$this->controller = "simplecontroller";
			}
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