<?php
/* implement the hooks */  
foreach($hooks['register_script'] as $hook) {
	echo '<script type="text/javascript" src="' . $hook . '" async></script>'; 
}  
?>