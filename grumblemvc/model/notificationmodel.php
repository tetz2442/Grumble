<?php
class Notifications extends BaseModel {
	public function update() {
		
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
	
	//gets grumble and creates 3 new objects
	public function load() {
		if(isset($_SESSION["user_id"])) {
			$sql = "SELECT notification_id, notification_message, notification_url, notification_created, notification_read FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY notification_created DESC LIMIT 10";
			$result = $this->db->query($sql);
			return $result;
		}
	}
}
?>