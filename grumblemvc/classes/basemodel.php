<?php
require("database.php");

abstract class BaseModel {
	protected $db, $user;

	public function __construct() {
		$this->db = new DB(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
		//$this->user = new User();
	}
}
?>