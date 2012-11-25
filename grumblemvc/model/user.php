<?php
//class to hold user information
class User extends BaseModel {
	protected $access_lvl, $username, $id, $email;
	
	public function checkPassword($password) {
		$sql = "";
		$this->db->query($sql);
	}

	//get user id
	public function id() {
		return $this->id;
	}
	//get username
	public function username() {
		return $this->username;
	}
	//get email address 
	public function email() {
		return $this->email;
	}
	//get access level
	public function access_lvl() {
		return $this->access_lvl;
	}
}
?>