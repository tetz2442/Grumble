<?php
class SimpleController extends BaseController {
	protected function index() {
		//get site title and description
		//$this->data["siteDescription"] = $grumble->createDescription();
		//$this->data["siteTitle"] = $grumble->createTitle();
		//get page data, this is not an ajax call
		$this->buildPageData();
		
		$this->returnView($this->data);
	}
}
?>