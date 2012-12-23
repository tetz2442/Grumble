<?php
class GrumbleController extends BaseController {
	protected function index() {
		$grumble = new Grumble($this->db);
		//get grumble data
		$grumble->load($this->urlvalues["id"]);
		$this->data["grumble"] = $grumble;
		
		require_once("model/commentsmodel.php");
		$comm = new Comments($this->db);
		$comments = $comm->loadGrumbleComments($this->urlvalues["id"]);
		$this->data["comments"] = $comments;
		//$this->data["siteDescription"] = $grumble->siteDescription;
		//$this->data["siteTitle"] = $grumble->siteTitle;
		
		//get page data, this is not an ajax call
		$this->buildPageData();
		
		$this->returnView($this->data);
	}
}
?>