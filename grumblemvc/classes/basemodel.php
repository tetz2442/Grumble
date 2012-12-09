<?php
abstract class BaseModel {
	protected $db, $siteTitle, $siteDescription;

	public function __construct($db) {
		$this->db = $db;
		//$this->db = new DB(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
	}
	
	public function convertToTimeZone($time, $tz) {
		$newtime = new DateTime($time . " UTC");
		$newtime->setTimezone(new DateTimeZone($tz));
		return date_format($newtime, "M d, Y g:iA");
	}
	
	public function createTitle($string = "") {
		if(strlen($string) == 0) {
			$title = "Grumble | Grumble for you. Grumble for change.";
		}
		else {
			$title = "Grumble | " . $string;
		}
		$this->siteTitle = $title;
		return $title;
	}
	
	public function createDescription($string = "") {
		$description = $string;
		if(strlen($description) > 255) {
			$description = substr($description, 0, 255) . "...";
		}
		else if(strlen($description) < 50 && strlen($description) > 0){
			$description . " | Grumble is a place where you can discuss the topics that you feel are important and need attention. It's simple. Grumble for you. Grumble for change.";
		}
		else if($description == ""){
			$description = "Grumble is a place where you can discuss the topics that you feel are important and need attention. It's simple. Grumble for you. Grumble for change.";
		}
		$this->siteDescription = $description;
		return $description;
	}
	
	//replace spaces
	public function replaceSpaces($input) {
		return str_replace(" ", "", $input);
	}
	
	//remove newline characters
	public function removeNewLine($input) {
		$output = str_replace("\r", "", $input);
		$output = str_replace("\n", "", $output);
		
		return $output;
	}
}
?>