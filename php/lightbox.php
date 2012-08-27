<div id="grumble-status-lightbox">
<h3 class="quick-compose-header">Compose Grumble</h3>
<img src="/images/exit.png" width="15" height="15" class="close-quick-submit"/>
<?php
	$token = md5(uniqid(rand(), true));
	$_SESSION['token4'] = $token;
?>
    	<form action="/php/transact-grumble.php" method="post">
            <textarea id="quick-compose-textarea" class="textArea" title="Compose grumble" rows="4" name="grumble" placeholder="Compose new Grumble..."></textarea>
            <br/>
            <input type="hidden" name="referrer" value="" id="referrer"/>
            <input type="hidden" name="token" value="<?php echo $token; ?>" />
            <input type="hidden" name="category" id="lightbox-category" value="<?php echo strip_tags($_GET["subcat"]); ?>"/>
            <div>
                <input type="submit" value="Submit Grumble" name="action" id="quick-compose-submit" class="button"/>
                <span id="character-count">160</span>
                <span id="link-present">Link will be shortened.</span>
            </div>
         </form>
         <div id="oembed-link-status"></div>
</div>