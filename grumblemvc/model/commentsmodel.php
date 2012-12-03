<?php
class CommentModel extends BaseModel {
	public $id, $name, $created, $description, $shorturl, $likes, $category_name, $category_id, $category_url, $owner_username;
	
	//get grumble comments
	public function load($id, $limit = 10, $offset = 0) {
		$id = $this->db->escape($id);
		$limit = $this->db->escape($limit);
		
		 $sql = "SELECT status_id FROM status_grumble " .
		"WHERE sub_category_id = " . $id . 
		" ORDER BY status_id DESC LIMIT " . $limit;
		 
		 return $this->db->query($sql);
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
	
}
?>