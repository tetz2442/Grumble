<?php
class HomeModel extends BaseModel {
	public function loadTopGrumbles() {
		//top grumbles
	    $sql = "SELECT sub_category_id, " . 
	    "((SELECT COUNT(DISTINCT ugl.grumble_like_id) FROM user_grumble_likes AS ugl WHERE ugl.sub_category_id = scg.sub_category_id) + " . 
	    "(SELECT COUNT(DISTINCT sg.status_id) FROM status_grumble AS sg WHERE sg.sub_category_id = scg.sub_category_id)) AS grumble_number" . 
	    " FROM sub_category_grumble AS scg" .
	    " WHERE sub_category_created >= (UTC_TIMESTAMP() - INTERVAL 5 DAY) HAVING grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10";
	    $result = $this->db->query($sql);
	}

	public function loadRecentGrumbles() {
		$sql = "SELECT sub_category_id FROM sub_category_grumble" .
        " ORDER BY sub_category_id DESC LIMIT 10";
        $result = $this->db->query($sql);
	}

	public function loadTopComments() {
		$sql = "SELECT sg.status_id,(SELECT COUNT(user_like_id) FROM user_likes_grumble AS ulg WHERE sg.status_id = ulg.status_id) AS votes_up_count" .
		" FROM status_grumble AS sg " . 
          "WHERE sg.date_submitted >= (UTC_TIMESTAMP() - INTERVAL 4 DAY) HAVING votes_up_count > 0" .
          " ORDER BY votes_up_count DESC LIMIT 10";
        $result = $this->db->query($sql);
	}

	public function loadRecentComments() {
		$sql = "SELECT status_id FROM status_grumble" .
            " ORDER BY status_id DESC LIMIT 10";
        $result = $this->db->query($sql);
	}
}
?>