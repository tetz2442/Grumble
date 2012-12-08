<?php
class Category extends BaseModel {
	//loads all category data
	public function loadAllCategories() {
		$sql = "SELECT * FROM categories_grumble ORDER BY category_name ASC";
		$this->db->query($sql);
		return $this->db->rows();
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
}
?>