<?php
class Grumble {
	public $id, $name, $created, $description, $shorturl, $likes;
	
	//build grumble object, parameters are optional
	public function __construct($id = 0, $name = null, $created = null, $description = null, $shorturl = null, $likes = null) {
		$this->id = $id;
		$this->name = $name;
		$this->created = $created;
		$this->description = $description;
		$this->shorturl = $shorturl;
		$this->likes = $likes;
	}
	
	//build url for a href
	public function buildURL($category_url) {
		return "/" . $category_url . "/" . $this->shorturl . "/" . $this->id;
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
}
?>