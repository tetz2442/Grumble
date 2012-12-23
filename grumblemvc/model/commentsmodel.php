<?php
class Comments extends BaseModel {
	public $id, $name, $created, $description, $shorturl, $likes, $category_name, $category_id, $category_url, $owner_username;
	
	//get comment
	public function load($id, $limit = 10, $offset = 0) {
		$id = $this->db->escape($id);
		 $sql = "SELECT status_id FROM status_grumble " .
		"WHERE sub_category_id = " . $id . 
		" ORDER BY status_id DESC LIMIT " . $limit;
	}
	//get grumble comments
	public function loadGrumbleComments($id, $limit = 10, $offset = 0) {
		$id = $this->db->escape($id);
		$limit = $this->db->escape($limit);
		
		$sql = "SELECT sg.status_id, sg.status_text, ug.username, sg.date_submitted,  
		ug.user_id, ug.username, ug.user_email, COUNT(user_like_id) AS votes_up_count, scg.sub_category_name, scg.sub_category_id, scg.sub_category_url, cg.category_url FROM status_grumble AS sg 
		LEFT OUTER JOIN user_likes_grumble AS vg ON sg.status_id = vg.status_id 
		LEFT OUTER JOIN users_grumble AS ug ON sg.user_id = ug.user_id 
		LEFT OUTER JOIN sub_category_grumble AS scg ON scg.sub_category_id = sg.sub_category_id 
		LEFT OUTER JOIN categories_grumble AS cg ON scg.category_id = cg.category_id 
		WHERE sg.sub_category_id = $id
		LIMIT $limit";
		 //if offset, add to sql query
		 if($offset != 0)
		 	$sql .= " OFFSET " . $offset;
		 
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