<?php
require_once "php/conn.php";
require_once "php/http.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
require_once "php/timeago.php";
require_once "php/outputgrumbles.php";
require_once "php/grumbleOfTheDay.php";

$grumble = true;
$exist = true;
if(isset($_GET["subcat"])) {
	$sql = "SELECT status_id FROM status_grumble " .
		"WHERE sub_category_id = " . mysql_real_escape_string($_GET["subcat"]) . 
		" ORDER BY status_id DESC LIMIT 10";
	$result = mysql_query($sql, $conn);
	
	$sql = "SELECT scg.sub_category_id, scg.sub_category_name, scg.grumble_number, scg.sub_category_description, cg.category_name, cg.category_id, cg.category_url, ug.username FROM sub_category_grumble AS scg " .
		"LEFT OUTER JOIN categories_grumble AS cg ON scg.category_id = cg.category_id " .
		"LEFT OUTER JOIN users_grumble AS ug ON scg.user_id = ug.user_id " .
		"WHERE sub_category_id = " . mysql_real_escape_string($_GET["subcat"]);
	$result2 = mysql_query($sql, $conn);
	
	if(mysql_num_rows($result2) == 0)
		$exist = false;
		
	$row = mysql_fetch_array($result2);
}

if($exist) {
?>
    <div id="grumbles-header">
        <div id="grumbles-category">
            <div id="category-header">
                <h1 id="subcat-id" data-id="<?php echo strip_tags($_GET["subcat"]);?>"><?php echo stripslashes($row["sub_category_name"]); ?></h1>
                <h4><a href="/category/<?php echo $row["category_name"]; ?>" class="colored-link-1"><?php echo stripslashes($row["category_name"]); ?></a> | Created by <a href="/profile/<?php echo $row["username"];?>" class="colored-link-1"><?php echo $row["username"];?></a></h4>
                <p id="sub-category-desc"><?php echo stripslashes($row["sub_category_description"]); ?></p>
            </div>
            <div id="share-category">
            <?php
            $new_url = "http://".$_SERVER['HTTP_HOST']. "/" . $row["category_url"] . "/" . $row["sub_category_url"] . "/" . $row["sub_category_id"];
            ?>
                <div>
                    <div class="g-plusone" data-href="<?php echo $new_url;?>" data-size="medium"></div>
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $new_url;?>" data-via="grumbleonline" data-text="Come check out <?php echo $row["sub_category_name"];?>" data-related="grumbleonline" data-hashtags="grumble">Tweet</a>
                    <div class="fb-like" data-href="<?php echo $new_url;?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-action="like"></div>
                </div>
                <?php
                //different button for logged in users
                if(isset($_SESSION["username"])) {
                ?>
                <button class="push_button orange compose-gumble" id="open-quick-compose" title="Compose Grumble">Compose New Grumble</button>
                <?php
                }
                else {
                ?>
                <button class="push_button orange dropdown-shortlink compose-grumble" title="Compose Grumble">Compose New Grumble</button>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    //output all other grumbles for this sub category
    if(mysql_num_rows($result) == 0) {
        echo '<div id="grumbles-left">';
        if(isset($_SESSION["username"])) {
            //grumbleOfTheDay();
            require_once "php/lightbox.php";
			require_once "php/notificationbar.php";
        }
        echo " <br/>\n";
        echo "<p class='text-align-center content-padding'><b>There are currently no grumbles to view.</b></p>";	
        echo '</div>';
    }
    else {
        echo '<div id="grumbles-left">';
        ?>
        <div id="grumbles-left-header">
            <h3 <?php if($row["grumble_number"] > 10) echo 'title="Number of total grumbles"';?>>Grumbles<?php if($row["grumble_number"] > 10) echo "(" . $row["grumble_number"] . ")";?></h3>
        </div>
        <?php
        if(isset($_SESSION["username"])) {
            //grumbleOfTheDay();
            require_once "php/lightbox.php";
			require_once "php/notificationbar.php";
        }
        while($row = mysql_fetch_array($result)) {
            outputGrumbles($row["status_id"], false, $loggedin);	
        }
        echo '<div id="gif-loader"><img src="/images/ajax-loader2.gif" width="32" height="32"/></div>';
        echo '</div>';
    }	
	
    if(preg_match("/\?create=new/", $_SERVER['REQUEST_URI']) == 1) {
        require_once "php/lightboxsharethread.php"; 
    }
	
	if(mysql_num_rows($result) < 10)
		require_once "php/footer.php"; 
	else
		require_once "php/min-footer.php"; 
}
//subcat doesnt exist
else {
	?>
    <div class="content-padding"><p class="text-align-center"><br/><b>This thread doesn't exist. Please check your URL.</b></p></div>
    <?php
	require_once "php/footer.php"; 
}
?>