<?php 
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
require_once "php/timeago.php";
require_once "php/outputgrumbles.php";
$grumble = true;
?>
<div id="grumbles-left">
<?php
if(isset($_GET["user"]) && isset($_GET["s"])) {
	outputGrumbles(mysql_real_escape_string($_GET["s"]), true, $loggedin);	
}
?>
</div>
 <script type="text/javascript">
 var loggedin = <?php echo $loggedin; ?>;
 var statusid = <?php echo strip_tags($_GET["s"]); ?>;
window.onload = function(){
	if(loggedin) {
		$(".grumble-holder").find(".gif-loader-comments").show();
		$.post("/php/comments.php", {comment:statusid, type:"load", amount:"all"},
				function(result) {
					$(".grumble-holder").find(".gif-loader-comments").hide();
					if(result != "") {
						$(result).insertBefore(".quick-comment");
						$(".comments").slideDown("fast");
					}
		});
	}
}
 
</script>
<?php require_once "php/footer.php"; ?>