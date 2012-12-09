<?php
class User extends BaseModel {
	public $url, $username;
	
	//load user with id or username
	protected function load($id) {
		if(is_numeric($id)) {
			
		}
		//load with username
		else {
			
		}
		return $this;
	}
	//check if user is logged in
	public function is_logged_in() {
		if(isset($_SESSION["user_id"]))
			return true;
		else
			return false;
	}
	//check username equality
	public function checkUsername($username) {
		if($username === $_SESSION["username"])
			return true;
		else
			return false;
	}
	//getusername
	public function username() {
		if(isset($_SESSION["username"]))
			return $_SESSION["username"];
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
}
?>