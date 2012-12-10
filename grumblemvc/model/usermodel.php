<?php
class User extends BaseModel {
	public $url;
	
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
	public function checkUsername($user) {
		if(isset($_SESSION["username"]) && $user === $_SESSION["username"])
			return true;
		else
			return false;
	}
	//getusername
	public function username() {
		if(isset($_SESSION["username"]))
			return $_SESSION["username"];
	}
	
	public function checkEmailAvailability() {
		//get the passed parameter
		$email = $this->db->escape(strtolower($_POST["email"]));
		
		//send a request to the database
		$sql = "SELECT user_email FROM users_grumble WHERE LOWER(user_email) = '" . $email . "'";
		$this->db->query($sql);
		
		if($this->db->numRows() > 0) {
			//email is already taken
			echo json_encode(false);
		}
		else {
			//email is available
			echo json_encode(true);
		}
	}

	public function checkUsernameAvailability() {
		//get the passed parameter
		$username = $this->db->escape(strtolower($_POST["username"]));
		
		//check if username is allowed
		if(checkUsername($username)) {
			//send a request to the database
			$sql = "SELECT username FROM users_grumble WHERE LOWER(username) = '" . $username . "'";
			$this->db->query($sql);
			
			if($this->db->numRows() > 0) {
				//email is already taken
				echo json_encode(false);
			}
			else {
				//email is available
				echo json_encode(true);
			}
		}
		else {
			echo json_encode(false);
		}
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
}
?>