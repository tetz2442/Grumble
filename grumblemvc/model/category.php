<?php
class Category {
	public $id, $name, $url;
	
	public function __construct($id, $name, $url) {
		$this->id = $id;
		$this->name = $name;
		$this->url = "/category/" . $url;
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
}
?>