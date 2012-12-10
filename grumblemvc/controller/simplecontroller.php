<?php
class SimpleController extends BaseController {
	protected function index() {
		//replace dashes for some methods
		$method = str_replace("-", "", $this->urlvalues["controller"]);
		//simple model needed for some actions
		$model = new Simple($this->db);
		//if method exists, call it
		if(method_exists($model, $method))
			$model->$method();
		//get page data, this is not an ajax call
		$this->buildPageData();
		
		$this->returnView($this->data);
	}
}
?>