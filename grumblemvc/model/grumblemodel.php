<?php
class Grumble extends BaseModel {
	public $id, $name, $created, $description, $shorturl, $likes, $category_name, $category_id, $category_url, $owner_username, $grumble_url;

	//build url for a href
	public function buildURL($category_url) {
		return "/" . $this->category_url . "/" . $this->shorturl . "/" . $this->id;
	}
	
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
	
	//gets grumble and creates 3 new objects
	public function load($id) {
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
		//$category_name, $category_id, $category_url, $owner_username
		$this->id = $result["sub_category_id"];
		$this->name = stripslashes($result["sub_category_name"]);
		$this->description = stripslashes($result["sub_category_description"]);
		$this->shorturl = $result["sub_category_url"];
		$this->likes = $result["votes_up"];
		$this->category_id = $result["category_id"];
		$this->category_name = $result["category_name"];
		$this->category_url = $result["category_url"];
		$this->grumble_url = "/" . $this->category_url . "/" . $this->shorturl . "/" . $this->id;
		$this->owner_username = $result["username"];
		
		//create title and description
		$this->createTitle($this->name);
		$this->createDescription($this->description);
		
		//format time returned
		if(isset($_SESSION["timezone"])) 
        	$this->created = $this->convertToTimeZone($result["sub_category_created"], $_SESSION["timezone"]);
        else if(isset($_SESSION["time"]))
            $this->created = $this->convertToTimeZone($result["sub_category_created"], $_SESSION["time"]);
        
		return $this;
	}
	
	//get grumble comments
	public function loadComments($id, $limit = 10, $offset = null) {
		$id = $this->db->escape($id);
		$limit = $this->db->escape($limit);
		
		 $sql = "SELECT status_id FROM status_grumble " .
		"WHERE sub_category_id = " . $id . 
		" ORDER BY status_id DESC LIMIT " . $limit;
		 
		 return $this->db->query($sql);
	}

	//load top grumbles
	public function loadTopGrumbles($limit = 10, $offset = null, $interval = 25) {
		if($offset != null && is_numeric($offset))
			$offset = " OFFSET " . $offset;
		else
			$offset = "";  
		//top grumbles
		$sql = "SELECT scg.sub_category_id, cg.category_name, cg.category_url, scg.sub_category_name, 
		scg.sub_category_description, scg.sub_category_url, 
		((SELECT COUNT(DISTINCT ugl.grumble_like_id ) FROM user_grumble_likes AS ugl WHERE ugl.sub_category_id = scg.sub_category_id) + 
		( SELECT COUNT(DISTINCT sg.status_id ) FROM status_grumble AS sg WHERE sg.sub_category_id = scg.sub_category_id ) ) 
		AS grumble_number, DATE_FORMAT( scg.sub_category_created,'%b %e, %Y %l:%i %p') AS sub_category_created
		FROM sub_category_grumble AS scg
		LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id
		WHERE sub_category_created >= ( UTC_TIMESTAMP()-INTERVAL " . $interval . " DAY) 
		HAVING grumble_number >0
		ORDER BY grumble_number DESC 
		LIMIT " . $limit . $offset;
		//store each grumble in an object with the certain properties
	    return $this->db->query($sql);
	}

	//load recent grumbles
	public function loadRecentGrumbles() {
		$sql = "SELECT sub_category_id FROM sub_category_grumble" .
        " ORDER BY sub_category_id DESC LIMIT 10";
        $result = $this->db->query($sql);
	}
}
?>