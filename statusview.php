<?php 
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerStatus.php";
require_once "php/functions.php";
require_once "php/outputcomments.php";
$grumble = true;

if(isset($_GET["user"]) && isset($_GET["s"])) {
	$statusid = mysql_real_escape_string(strip_tags($_GET["s"]));
	$user = mysql_real_escape_string(strip_tags($_GET["user"]));
	$sql = "SELECT scg.sub_category_id, scg.sub_category_name, scg.sub_category_url, cg.category_name FROM sub_category_grumble AS scg " .
		"LEFT OUTER JOIN status_grumble AS sg ON sg.status_id = " . $statusid . 
		" LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id" .
		" WHERE scg.sub_category_id = sg.sub_category_id";
	$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
	
	if(mysql_num_rows($result) == 0) {
		echo '<div class="content-padding"><p class="text-align-center content-padding">This comment does not exist. Please check your URL.</p></div>';
	}
	else {
		$row = mysql_fetch_array($result);
		?>
        <div id="comments-header">
            <div id="category-header">
                <h1 id="subcat-id"><a href="/<?php echo strtolower($row["category_name"]) . "/" . $row["sub_category_url"] . "/" . $row["sub_category_id"]; ?>" class="colored-link-1"><?php echo stripslashes($row["sub_category_name"]); ?></h1>
                <h4><a href="/category/<?php echo strtolower($row["category_name"]); ?>" class="colored-link-1"><?php echo stripslashes($row["category_name"]); ?></a></h4>
            </div>
            <div id="share-category">
            <?php
            $new_url = "http://".$_SERVER['HTTP_HOST']. "/profile/" . $user . "/grumble/" . $statusid;
            ?>
                <div>
                    <div class="g-plusone" data-href="<?php echo $new_url;?>" data-size="medium"></div>
                    <div class="fb-like" data-href="<?php echo $new_url;?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-action="like"></div>
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $new_url;?>" data-via="grumbleonline" data-text="Come check out <?php echo $user . "'s";?> comment!" data-related="grumbleonline" data-hashtags="grumble">Tweet</a>
                </div>
            </div>
        </div>
        <div id="comments-left">
        <div class="divider"></div>
        <?php
		outputComments($statusid, true, $loggedin);
	}	
}
else {
?>
<div class="content-padding"><p class="text-align-center content-padding">This comment does not exist. Please check your URL.</p></div>
<?php
}
?>
</div>
 <script type="text/javascript">
 var loggedin = <?php echo $loggedin; ?>;
 var statusid = <?php echo strip_tags($_GET["s"]); ?>;
window.onload = function(){
	var replynumber = parseInt($(".reply-view").attr("data-replies"));
	if(loggedin && replynumber != 0) {
		$(".gif-loader-replies").show();
		$.post("/php/repliesajax.php", {reply:statusid, type:"load", amount:"all"},
				function(result) {
					$(".gif-loader-replies").hide();
					if(result != "") {
						$(result).insertBefore(".quick-reply-input");
						$(".replies").slideDown("fast");

						$(".reply-text").each(function() {
							var newText = linkText($(this).html());
							$(this).addClass("linked").html(newText);
						});
						shortenLink(".reply-text a");
					}
		});
	}
	else {
		$(".replies").slideDown("fast");
	}
}
 
</script>
<?php require_once "php/footer.php"; ?>