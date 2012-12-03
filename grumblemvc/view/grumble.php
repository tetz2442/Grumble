<?php 
getHeader(); 
?>
<div id="grumble-header">
    <div id="category-header">
        <h1 id="subcat-id" data-id="<?php echo $this->grumble->id;?>"><?php echo $this->grumble->name; ?></h1>
        <h4><a href="/category/<?php echo $this->grumble->category_url; ?>" class="colored-link-1"><?php echo $this->grumble->name; ?></a> | Created by <a href="/profile/<?php echo $this->grumble->owner_username;?>" class="colored-link-1"><?php echo $this->grumble->owner_username;?></a></h4>
        <small id="sub-category-created">Grumbled on <?php echo $this->grumble->created; ?></small>';
        <?php if($this->grumble->owner_username == $_SESSION["username"]) { ?>
        <small id="grumble-delete" title="Delete this Grumble and all the comments and replies. This cannot be undone." data-id="<?php echo $this->grumble->id; ?>">Delete</small>
        <?php } ?>
        <p id="sub-category-desc"><?php echo $this->grumble->description;?></p>
    </div>
    <div id="share-category">
        <div class="grumble-like-number grumble-vote-up<?php if(isset($_SESSION["user_id"])) { echo '" title="Vote Grumble up"'; } else { echo ' dropdown-shortlink" title="You must be logged in to vote up."'; } ?>>
            <?php if(isset($_SESSION["user_id"])) { ?>
            <p class="colored-link-1">Vote up<img src="/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/></p>
            <?php } else { ?>
            <p class="colored-link-1">Vote up<img src="/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/></p>
            <?php } ?>
            <p class="grumble-vote-font"><?php echo $this->grumble->likes; ?></p>
            <div class="clear"></div>
        </div>
        <?php
        $new_url = SITE_URL . $this->grumble->grumble_url;
        ?>
        <div id="share-category-social">
            <div class="g-plusone" data-href="<?php echo $new_url;?>" data-size="medium"></div>
            <div class="fb-like" data-href="<?php echo $new_url;?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-action="like"></div>
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $new_url;?>" data-via="grumbleonline" data-text="Come check out <?php echo $this->grumble->name;?>" data-related="grumbleonline" data-hashtags="grumble">Tweet</a>
        </div>
    </div>
</div>
<?php getFooter(); ?>