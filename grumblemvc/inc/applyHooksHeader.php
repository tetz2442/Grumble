<?php
/* implement the hooks */  
foreach($hooks['register_style'] as $hook) {
	echo '<link href="' . $hook . '" rel="stylesheet" media="all">'; 
}  
?>