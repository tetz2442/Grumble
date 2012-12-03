<?php
class User {
	public $id, $username, $email, $url;
	
	public function __construct($id = 0, $username = null, $email = null) {
		$this->id = $id;
		$this->username = $username;
		$this->email = $email;
		$this->url = "/profile/" . $username;
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
}
?>