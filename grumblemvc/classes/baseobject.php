<?php
class BaseObject {
	public $vars = array();
	
	public function __construct($vars) {
		foreach ($vars as $key => $value) {
			$this->$key = $value;
		}
	}
	
	public function addProperty($name, $value) {
		$this->$name = $value;
	}
}
?>