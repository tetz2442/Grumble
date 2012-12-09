<?php
/* include plugin files */  
foreach($hook_files as $hook_file) {  
  require_once($hook_file);  
}  
  
/* implement the hooks */  
foreach($hooks['the_content'] as $hook) {  
  $content = call_user_func($hook, $content);  
}  
?>