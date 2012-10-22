<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerStatus.php";
require_once "php/functions.php";
require_once "php/outputcomments.php";

$grumble = true;
$exist = false;
if(isset($_GET["subcat"]) && is_numeric($_GET["subcat"])) {
    $subcat = mysql_real_escape_string($_GET["subcat"]);

	$sql = "SELECT status_id FROM status_grumble " .
		"WHERE sub_category_id = " . $subcat . 
		" ORDER BY status_id DESC LIMIT 10";
	$result = mysql_query($sql, $conn);
	
	$sql = "SELECT scg.sub_category_id, scg.sub_category_name, scg.sub_category_created, scg.grumble_number, " .
        "scg.sub_category_description, scg.sub_category_url, cg.category_name, cg.category_id, cg.category_url, " .
        "ug.username, COUNT(ugl.grumble_like_id) AS votes_up FROM sub_category_grumble AS scg " .
		"LEFT OUTER JOIN categories_grumble AS cg ON scg.category_id = cg.category_id " .
		"LEFT OUTER JOIN users_grumble AS ug ON scg.user_id = ug.user_id " .
        "LEFT OUTER JOIN user_grumble_likes AS ugl ON ugl.sub_category_id = scg.sub_category_id " .
		"WHERE scg.sub_category_id = " . $subcat . " LIMIT 0,1";
	$result2 = mysql_query($sql, $conn);
	
	if(mysql_num_rows($result2) != 0)
		$exist = true;
}

if($exist) {
	$row = mysql_fetch_array($result2);
?>
    <div id="grumble-header">
        <div id="category-header">
            <h1 id="subcat-id" data-id="<?php echo strip_tags($_GET["subcat"]);?>"><?php echo stripslashes($row["sub_category_name"]); ?></h1>
            <h4><a href="/category/<?php echo $row["category_url"]; ?>" class="colored-link-1"><?php echo stripslashes($row["category_name"]); ?></a> | Created by <a href="/profile/<?php echo $row["username"];?>" class="colored-link-1"><?php echo $row["username"];?></a></h4>
            <?php if(isset($_SESSION["timezone"])) 
            	echo '<small id="sub-category-created">Grumbled on ' . convertToTimeZone($row["sub_category_created"], $_SESSION["timezone"]) . '</small>';
            else if(isset($_SESSION["time"]))
            	echo '<small id="sub-category-created">Grumbled on ' . convertToTimeZone($row["sub_category_created"], $_SESSION["time"]) . '</small>';
            ?>
            <p id="sub-category-desc"><?php echo stripslashes($row["sub_category_description"]);?></p>
        </div>
        <div id="share-category">
            <div class="grumble-like-number grumble-vote-up<?php if(isset($_SESSION["user_id"])) { echo '" title="Vote Grumble up"'; } else { echo ' dropdown-shortlink" title="You must be logged in to vote up."'; } ?>>
                <?php if(isset($_SESSION["user_id"])) { ?>
                <p class="colored-link-1">Vote up<img src="/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/></p>
                <?php } else { ?>
                <p class="colored-link-1">Vote up<img src="/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/></p>
                <?php } ?>
                <p class="grumble-vote-font"><?php echo $row["votes_up"]; ?></p>
                <div class="clear"></div>
            </div>
            <?php
            $new_url = "http://".$_SERVER['HTTP_HOST']. "/" . $row["category_url"] . "/" . $row["sub_category_url"] . "/" . $row["sub_category_id"];
            ?>
            <div id="share-category-social">
                <div class="g-plusone" data-href="<?php echo $new_url;?>" data-size="medium"></div>
                <div class="fb-like" data-href="<?php echo $new_url;?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-action="like"></div>
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $new_url;?>" data-via="grumbleonline" data-text="Come check out <?php echo $row["sub_category_name"];?>" data-related="grumbleonline" data-hashtags="grumble">Tweet</a>
            </div>
        </div>
    </div>
    <?php
    //no comments returned
    if(mysql_num_rows($result) == 0) {
        echo '<div id="comments-left">';
        if(isset($_SESSION["username"])) {
			?>
            <div id="grumble-comment">
                    <form id="grumble-comment-form" method="post">
                        <textarea id="quick-compose-textarea" class="textArea" title="Compose comment" rows="4" name="comment" placeholder="Compose new comment..."></textarea>
                        <input type="hidden" name="referrer" value="" id="referrer"/>
                        <input type="hidden" name="category" id="comment-category" value="<?php echo strip_tags($_GET["subcat"]); ?>"/>
                        <div>
                            <input type="submit" value="Submit Comment" name="action" id="quick-compose-submit" class="button"/>
                            <span id="character-count">600</span>
                            <span id="gif-loader-comment"><img src="/images/ajax-loader.gif" width="16" height="16"/></span>
                            <span id="link-present">Link will be shortened.</span>
                        </div>
                    </form>
            </div>
            <?php
        }
        echo "<p class='text-align-center content-padding'>There are currently no comments to view.</p>";	
        echo '</div>';
    }
    //comments were returned
    else {
        ?>
        <div id="comments-left">
            <div id="comments-left-header">
                <h4 title="Total number comments">Comments
                    <?php if($row["grumble_number"] > 10) echo "(<span>" . $row["grumble_number"] . "</span>)";?>
                </h4>
                <?php if($row["grumble_number"] > 10) { ?>
                <select id="comments-filter">
                    <option value="recent" selected="selected">Recent</option>
                    <option value="top">Top</option>
                </select>
                <?php } ?>
            </div>
        <?php
        if(isset($_SESSION["username"])) {
			?>
            <div id="grumble-comment">
                    <form id="grumble-comment-form" method="post">
                        <textarea id="quick-compose-textarea" class="textArea" title="Compose comment" rows="4" name="comment" placeholder="Compose new comment..."></textarea>
                        <input type="hidden" name="referrer" value="" id="referrer"/>
                        <input type="hidden" name="category" id="comment-category" value="<?php echo strip_tags($_GET["subcat"]); ?>"/>
                        <div>
                            <input type="submit" value="Submit Comment" name="action" id="quick-compose-submit" class="button"/>
                            <span id="character-count">600</span>
                            <span id="gif-loader-comment"><img src="/images/ajax-loader.gif" width="16" height="16"/></span>
                            <span id="link-present">Link will be shortened.</span>
                        </div>
                    </form>
            </div>
            <?php
        }
        while($row = mysql_fetch_array($result)) {
            outputComments($row["status_id"], false, $loggedin);	
        }
        echo '<div id="gif-loader"><img src="/images/ajax-loader2.gif" alt="loader" width="32" height="32"/></div>';
		if($mobile)
			echo '<div id="load-more-grumbles"><p class="colored-link-1">Load more</p></div>';
        echo '</div>';
    }	
	
    if(preg_match("/\?create=new/", $_SERVER['REQUEST_URI']) == 1) {
        require_once "php/lightboxsharegrumble.php"; 
    }
	echo '<div class="clear"></div>';
	if(mysql_num_rows($result) < 10)
		require_once "php/footer.php"; 
	else
		require_once "php/min-footer.php"; 
}
//subcat doesnt exist
else {
	?>
    <div class="content-padding"><p class="text-align-center">This Grumble doesn't exist. Please check your URL.</p></div>
    <?php
	require_once "php/footer.php"; 
}
?>