<?php getHeader($data); ?>
<div id="grumble-wide-container" class="content-padding">
    <div class="text-align-center" id="page-four">
        <h1>404 Error!</h1>
        <p>The page you are trying to reach doesn't exist. <br/>Try checking the URL for errors, or let us guide you to our homepage.</p>
        <a href="<?php echo SITE_URL;?>" class=""><button class="push_button orange">Go Home</button></a>
        <a href="http://wiki.zeldalegends.net/index.php?title=Bait" target="_blank"><img src="<?php echo TEMPLATE_PATH; ?>/images/legend-of-zelda-grumble-guy.png"  height="528" width="768"/></a>
    </div>
</div>
<?php getFooter($user); ?>