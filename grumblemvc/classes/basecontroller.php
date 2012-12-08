<?php
require("database.php");

abstract class BaseController {
	protected $urlvalues, $action;
	//class variables
	protected $category, $user, $notification, $db;
	//variable for holding data
	protected $data;
	
	public function __construct($action, $urlvalues) {
		$this->action = $action;
		$this->urlvalues = $urlvalues;
		//connect to database
		$this->db = new DB(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
		//create user class
		$this->user = new User($this->db);
		//create category class and get list of categories for user navigation
		$this->category = new Category($this->db);
		//store category data
		$this->data["categories"] = $this->category->loadAllCategories();
		//load notifications if user is logged in
		if($this->user->is_logged_in()) {
			require("model/notificationmodel.php");
			$this->notification = new Notifications($this->db);
			$this->data["notifications"] = $this->notification->load();
		}
		else
			$this->data["notifications"] = "";
	}
	public function executeAction() {
		return $this->{$this->action}();
	}
	protected function returnView($data = null) {
		//print_r($data);
		extract($data);
		$viewloc = "view/" . $this->urlvalues["controller"] .  ".php";
		//require view
		require($viewloc);
	}
}
?>