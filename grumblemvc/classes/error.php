<?php
class Error {
	private $urlvalues, $type;

	//store the URL values on creation
	public function __construct($type, $urlvalues) {
		$this->urlvalues = $urlvalues;
		$this->type = $type;

		if($type == "badurl") {
			require_once("views/404.php");
		}
	}
}
?>