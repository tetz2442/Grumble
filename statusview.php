<?php 
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerStatus.php";
require_once "php/outputgrumbles.php";
$grumble = true;
?>
<div id="view-comments-header">
<h1>View All Comments</h1>
</div>
<?php
if(isset($_GET["c"]) && $_GET["c"] == "comment" && isset($_GET["s"])) {
	outputGrumbles(mysql_real_escape_string($_GET["s"]), true, $loggedin);	
}
else if(!isset($_GET["c"]) && isset($_GET["s"])) {
	outputGrumbles(mysql_real_escape_string($_GET["s"]), false, $loggedin);	
}
?>
 <script type="text/javascript">
 function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

window.onload = function(){
var id = getUrlVars()["s"];
$.post("php/comments.php", {comment:id, type:"load", amount:"all"},
		function(result) {
			if(result != "") {
				$(".comments").html(result);
				$(".comments").slideDown("fast");
				$(".comments").find(".ind-comment:last").hide();
			}
});
}
 
</script>
<?php require_once "php/footer.php"; ?>