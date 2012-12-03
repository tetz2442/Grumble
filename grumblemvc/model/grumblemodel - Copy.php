<?php
class GrumbleModel extends BaseModel {
	private $grumble, $category, $owner;
	
	//gets grumble and creates 3 new objects
	public function getGrumble($id) {
		require("grumble.php");
		require("category.php");
		require("user.php");
		//escape id
		$id = $this->db->escape($id);
		
		$sql = "SELECT scg.sub_category_id, scg.sub_category_name, scg.sub_category_created, scg.grumble_number, " .
        "scg.sub_category_description, scg.sub_category_url, cg.category_name, cg.category_id, cg.category_url, " .
        "ug.username, COUNT(ugl.grumble_like_id) AS votes_up FROM sub_category_grumble AS scg " .
		"LEFT OUTER JOIN categories_grumble AS cg ON scg.category_id = cg.category_id " .
		"LEFT OUTER JOIN users_grumble AS ug ON scg.user_id = ug.user_id " .
        "LEFT OUTER JOIN user_grumble_likes AS ugl ON ugl.sub_category_id = scg.sub_category_id " .
		"WHERE scg.sub_category_id = " . $id . " LIMIT 0,1";
		
		$result = $this->db->query($sql);
		//create grumble object
		$grumble = new Grumble($result["sub_category_id"], stripslashes($result["sub_category_name"]), $result["sub_category_created"], $result["sub_category_url"], stripslashes($result["sub_category_description"]), $result["votes_up"]);
		//create category object
		$category = new Category($result["category_id"], $result["category_name"], $result["category_url"]);
		//create owner object
		$owner = new User(0, $result["username"]);
		
		return array($grumble, $category, $owner);
	}
	
	//get grumble comments
	public function getComments($id, $limit = 10) {
		$id = $this->db->escape($id);
		$limit = $this->db->escape($limit);
		
		 $sql = "SELECT status_id FROM status_grumble " .
		"WHERE sub_category_id = " . $id . 
		" ORDER BY status_id DESC LIMIT " . $limit;
		 
		 return $this->db->query($sql);
	}
}
?>