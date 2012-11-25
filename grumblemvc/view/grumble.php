<?php getHeader(); ?>
<div id="grumble-header">
        <div id="category-header">
            <h1 id="subcat-id" data-id="<?php echo strip_tags($_GET["subcat"]);?>"><?php echo stripslashes($row[0]["sub_category_name"]); ?></h1>
            <h4><a href="/category/<?php echo $row["category_url"]; ?>" class="colored-link-1"><?php echo stripslashes($row[0]["category_name"]); ?></a> | Created by <a href="/profile/<?php echo $row["username"];?>" class="colored-link-1"><?php echo $row["username"];?></a></h4>
            <?php if(isset($_SESSION["timezone"])) 
            	echo '<small id="sub-category-created">Grumbled on ' . convertToTimeZone($row["sub_category_created"], $_SESSION["timezone"]) . '</small>';
            else if(isset($_SESSION["time"]))
            	echo '<small id="sub-category-created">Grumbled on ' . convertToTimeZone($row["sub_category_created"], $_SESSION["time"]) . '</small>';
            if($row["username"] == $_SESSION["username"]) {
            ?>
            <small id="grumble-delete" title="Delete this Grumble and all the comments and replies. This cannot be undone." data-id="<?php echo $row["sub_category_id"]; ?>">Delete</small>
            <?php } ?>
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
<?php getFooter(); ?>