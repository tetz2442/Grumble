<?php
class Grumble extends BaseController {
	protected function index() {
		$row = new GrumbleModel();
		$this->returnView($row->getGrumble($this->urlvalues["id"]));
	}
}
?>