<?php
class Home extends BaseController {
	protected function index() {
		$viewmodel = new HomeModel();
		$this->returnView($viewmodel->index());
	}
}
?>