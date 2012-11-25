<?php
class GrumbleModel extends BaseModel {
	//get grumble data
	public function getGrumble($id) {
		 $sql = "SELECT scg.sub_category_id, scg.sub_category_name, scg.sub_category_created, scg.grumble_number, " .
        "scg.sub_category_description, scg.sub_category_url, cg.category_name, cg.category_id, cg.category_url, " .
        "ug.username, COUNT(ugl.grumble_like_id) AS votes_up FROM sub_category_grumble AS scg " .
		"LEFT OUTER JOIN categories_grumble AS cg ON scg.category_id = cg.category_id " .
		"LEFT OUTER JOIN users_grumble AS ug ON scg.user_id = ug.user_id " .
        "LEFT OUTER JOIN user_grumble_likes AS ugl ON ugl.sub_category_id = scg.sub_category_id " .
		"WHERE scg.sub_category_id = " . $id . " LIMIT 0,1";
		 
		 return $this->db->query($sql);
	}
	
	//get grumble comments
	public function getComments($id, $limit = 10) {
		 $sql = "SELECT status_id FROM status_grumble " .
		"WHERE sub_category_id = " . $id . 
		" ORDER BY status_id DESC LIMIT " . $limit;
		 
		 return $this->db->query($sql);
	}
}
?>