<?php
require("database.php");

abstract class BaseController {
	protected $urlvalues, $action, $db;
	public $grumble, $category;
	public function __construct($action, $urlvalues) {
		$this->action = $action;
		$this->urlvalues = $urlvalues;
		$this->db = new DB(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
	}
	public function executeAction() {
		return $this->{$this->action}();
	}
	protected function returnView() {
		//print_r($data);
		$viewloc = "view/" . $this->urlvalues["controller"] .  ".php";
		//require view
		require($viewloc);
	}
}
?>