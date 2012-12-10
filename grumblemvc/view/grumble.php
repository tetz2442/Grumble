<?php 
getHeader($data); 
?>
<div id="grumble-header">
    <div id="category-header">
        <h1 data-id="<?php echo $grumble->id; ?>"><?php echo $grumble->name; ?></h1>
        <h4><a href="<?php echo SITE_URL; ?>/category/<?php echo $grumble->category_url; ?>" class="colored-link-1"><?php echo $grumble->category_name; ?></a> | Created by <a href="<?php echo SITE_URL; ?>/profile/<?php echo $grumble->owner_username;?>" class="colored-link-1"><?php echo $grumble->owner_username;?></a></h4>
        <small>Grumbled on <?php echo $grumble->created; ?></small>
        <?php if($user->checkUsername($grumble->owner_username)) { ?>
        <small id="grumble-delete" title="Delete this Grumble and all the comments and replies. This cannot be undone." data-id="<?php echo $grumble->id; ?>">Delete</small>
        <?php } ?>
        <p><?php echo $grumble->description;?></p>
    </div>
    <div id="share-category">
        <div class="grumble-like-number grumble-vote-up<?php if($user->is_logged_in()) { echo '" title="Vote Grumble up"'; } else { echo ' dropdown-shortlink" title="You must be logged in to vote up."'; } ?>>
            <?php if($user->is_logged_in()) { ?>
            <p class="colored-link-1">Vote up<img src="<?php echo TEMPLATE_PATH; ?>/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/></p>
            <?php } else { ?>
            <p class="colored-link-1">Vote up<img src="<?php echo TEMPLATE_PATH; ?>/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/></p>
            <?php } ?>
            <p class="grumble-vote-font"><?php echo $grumble->likes; ?></p>
            <div class="clear"></div>
        </div>
        <?php
        $new_url = SITE_URL . $grumble->grumble_url;
        ?>
        <div id="share-category-social">
            <div class="g-plusone" data-href="<?php echo $new_url;?>" data-size="medium"></div>
            <div class="fb-like" data-href="<?php echo $new_url;?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-action="like"></div>
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $new_url;?>" data-via="grumbleonline" data-text="Come check out <?php echo $grumble->name;?>" data-related="grumbleonline" data-hashtags="grumble">Tweet</a>
        </div>
    </div>
</div>
<?php getFooter($user); ?>