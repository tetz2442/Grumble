<div id="grumble-thread-share">
    <div class="lightbox-head">
    	<h3 class="view-all-header">Share your new thread!</h3>
    	<img src="/images/exit.png" width="15" height="15" class="close-quick-submit" onmouseover="this.src='/images/exitHover.png'" onmouseout="this.src='/images/exit.png'"/>
    </div>
    <div class="lightbox-thread-padding">
       <p id="share-info">Congrats on your new thread!  Be a pal and share it with your friends.</p>
       <?php
		$old_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$new_url = preg_replace('/&create=new/', '', $old_url);
		$new_url = preg_replace('/\?create=new/', '', $new_url);
		?>
       <div id="share-category">
            <div>
                <div class="g-plusone" data-href="<?php echo $new_url;?>" data-size="medium"></div>
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $new_url;?>" data-via="grumbleonline" data-text="I just create a new thread on Grumble!" data-related="grumbleonline" data-hashtags="grumble">Tweet</a>
                <div class="fb-like" data-href="<?php echo $new_url;?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-action="like"></div>
            </div>
       </div>
     </div>
</div>