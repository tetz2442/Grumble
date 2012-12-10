<?php
class UserController extends BaseController {
	protected function index() {
		$user = new User($this->db);
		//get page data, this is not an ajax call
		$this->buildPageData();
		
		$this->returnView($this->data);
	}
	//ajax call to validate email
	protected function emailvalidate() {
		$user = new User($this->db);
		
		$json = $user->checkEmailAvailability(); 
	}
	//ajax call to validate username
	protected function usernamevalidate() {
		$user = new User($this->db);
		
		$user->checkUsernameAvailability(); 
	}
}
?>