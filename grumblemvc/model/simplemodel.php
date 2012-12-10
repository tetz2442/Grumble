<?php
class Simple extends BaseModel {
	//check if user is logged in
	public function createaccount() {
		//register scripts and styles for forms
		add_action("register_script", TEMPLATE_PATH . "/javascript/jquery.idealforms.min.js");
		add_action("register_script", TEMPLATE_PATH . "/javascript/forms.js");
		add_action("register_style", TEMPLATE_PATH . "/css/jquery.idealforms.min.css");
	}
}
?>