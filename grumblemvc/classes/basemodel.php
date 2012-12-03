<?php
abstract class BaseModel {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
		//$this->db = new DB(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
	}
	
	public function convertToTimeZone($time, $tz) {
		$newtime = new DateTime($time . " UTC");
		$newtime->setTimezone(new DateTimeZone($tz));
		return date_format($newtime, "M d, Y g:iA");
	}
}
?>