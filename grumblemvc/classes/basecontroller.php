<?php
abstract class BaseController {
	protected $urlvalues;
	protected $action;
	public function __construct($action, $urlvalues) {
		$this->action = $action;
		$this->urlvalues = $urlvalues;
	}
	public function executeAction() {
		return $this->{$this->action}();
	}
	protected function returnView($row) {
		$viewloc = 'view/' . get_class($this) .  '.php';
		//require view
		require($viewloc);
	}
}
?>