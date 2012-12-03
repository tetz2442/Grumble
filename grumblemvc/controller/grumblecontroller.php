<?php
class GrumbleController extends BaseController {
	protected function index() {
		$grumble = new Grumble($this->db);
		//get grumble data
		//$grumble = $viewmodel->load($this->urlvalues["id"]);
		$grumble->load($this->urlvalues["id"]);
		//get comment data
		//$comments = $viewmodel->getComments($this->urlvalues["id"]);
		$data = $grumble;
		$this->grumble = $grumble;
		$this->returnView();
	}
}
?>