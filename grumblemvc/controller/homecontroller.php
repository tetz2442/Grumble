<?php
class Home extends BaseController {
	protected function index() {
		$categories = new Category($this->db);
		$grumble = new Grumble($this->db);
		//get site title and description
		$this->data["siteDescription"] = $grumble->createDescription();
		$this->data["siteTitle"] = $grumble->createTitle();
		//get page data, this is not an ajax call
		$this->buildPageData();
		
		$this->returnView($this->data);
	}
}
?>