<?php
class GrumbleController extends BaseController {
	protected function index() {
		$grumble = new Grumble($this->db);
		//get grumble data
		$grumble->load($this->urlvalues["id"]);
		$this->data["grumble"] = $grumble;
		$this->returnView($this->data);
	}
}
?>