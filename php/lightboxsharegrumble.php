<div id="grumble-share">
    <div class="lightbox-head">
    	<h3 class="view-all-header">Share your new Grumble!</h3>
    	<img src="/images/exit.png" alt="exit" width="15" height="15" class="close-quick-submit" onmouseover="this.src='/images/exitHover.png'" onmouseout="this.src='/images/exit.png'"/>
    </div>
   <p id="share-info">Congrats on your new Grumble!  Be a pal and share it with your friends.</p>
   <?php
	$old_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$new_url = preg_replace('/&create=new/', '', $old_url);
	$new_url = preg_replace('/\?create=new/', '', $new_url);
	?>
    <div>
        <div class="g-plusone" data-href="<?php echo $new_url;?>" data-size="medium"></div>
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $new_url;?>" data-via="grumbleonline" data-text="I just created a new Grumble!" data-related="grumbleonline" data-hashtags="grumble">Tweet</a>
        <div class="fb-like" data-href="<?php echo $new_url;?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-action="like"></div>
    </div>
</div>