<?php
require_once "php/conn.php";
require_once "php/functions.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
require_once "php/outputgrumbles.php";
require_once "php/outputcomments.php";

//include homepage cover
if(!isset($_SESSION["username"]) && !$mobile) {
?>
<div id="homepage-cover">
    <div id="cover-content-holder">
        <div id="grumble-monster-home">
            <img src="/images/grumblemonster.png" alt="grumble monster"/>
        </div>
        <div id="cover-text">
            <div class="definition-header"><h3>grum·ble</h3> <span>/’grəmbəl/</span></div>
            <div class="definition"><p>Verb: <span>Complain or protest about something in a bad-tempered but typically muted way.</span></p></div>
            <div class="definition"><p>Noun: <span>A complaint.</span></p></div>
            <div id="cover-about-text">
                <p>Grumble lets you discuss topics that you feel are important and need attention.</p>
                <p>Create a new Grumble and start Grumbling!</p>
                <p class="cover-buttons"><a href="/about" class="button orange">About</a> <a href="/create-account" class="button orange">Create Account</a></p>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="cover-bottom-bar">
        <img src="/images/icons/cover-arrow.png" alt="arrow" title="Show Grumbles"/>
    </div>
</div>
<?php
}
?>
<div id="grumble-home-info">
	<div class="content-padding">
<?php
if(!isset($_SESSION["username"])) {
?>
        <h2>Hey there! Got something to Grumble about? Let's hear it.</h2>
        <?php if($mobile) { ?>
        <p>Grumble lets you discuss topics that you feel are important and need attention.</p>
        <p>Create a new Grumble and start Grumbling!</p>
        <?php } ?>
        <p>
        	<a href='about' class="colored-link-1">About</a> |
        	<a href="create-account" class="colored-link-1">Create account</a>
        </p>
<?php
}
else {
?>
<h2>Hey <a href="profile/<?php echo $_SESSION["username"]; ?>" class="colored-link-1"><?php echo $_SESSION["username"]; ?></a>! Got something to Grumble about? Let's hear it.</h2>
 <button class="push_button orange new-grumble" id="start-new-grumble" title="New Grumble">New Grumble</button>
<?php
}
?>
	</div>
</div>
<div id="home-tabs-holder">
	<?php
	//top grumbles
    $sql = "SELECT sub_category_id, " . 
    "((SELECT COUNT(DISTINCT ugl.grumble_like_id) FROM user_grumble_likes AS ugl WHERE ugl.sub_category_id = scg.sub_category_id) + " . 
    "(SELECT COUNT(DISTINCT sg.status_id) FROM status_grumble AS sg WHERE sg.sub_category_id = scg.sub_category_id)) AS grumble_number" . 
    " FROM sub_category_grumble AS scg" .
    " WHERE sub_category_created >= (UTC_TIMESTAMP() - INTERVAL 5 DAY) HAVING grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10";
    $result = mysql_query($sql, $conn);
    
	$topnumber = mysql_num_rows($result);
	
	?>
    <ul class="tabs">
        <li><a href='#tab1' <?php if($topnumber > 0) echo 'class="active"'; ?>>Top Grumbles</a></li>
        <li><a href='#tab2' <?php if($topnumber == 0) echo 'class="active"'; ?>>Recent Grumbles</a></li>
        <li><a href='#tab3'>Top Comments</a></li>
        <li><a href='#tab4'>Recent Comments</a></li>
    </ul>
    <div id="arrow-top"><img src="images/arrow-up.png" alt="arrow" width="15" height="15"/></div>
    <div class="float-left">
        <div id='tab1'>
             <?php
                if(mysql_num_rows($result) > 0) {
                    while($row2 = mysql_fetch_array($result)) {
                        outputGrumbles($row2["sub_category_id"], true);	
                    }
                }
                else {
                    echo '<p class="content-padding">No top grumbles at this time. How about you <a href="#" class="colored-link-1 new-grumble">create one</a>?</p>';	
                }
            ?>
        </div>
        <div id="tab2">
        <?php
            //recent grumbles
            $sql = "SELECT sub_category_id FROM sub_category_grumble" .
            " ORDER BY sub_category_id DESC LIMIT 10";
            $result = mysql_query($sql, $conn);
            
            if(mysql_num_rows($result) > 0) {
                while($row2 = mysql_fetch_array($result)) {
                    outputGrumbles($row2["sub_category_id"], true);	
                }
            }
            else {
                echo '<p class="content-padding">No recent grumbles to view.</p>';	
            }
        ?>
        </div>
        <div id='tab3'>
             <?php
                //top comments
                $sql = "SELECT sg.status_id,(SELECT COUNT(user_like_id) FROM user_likes_grumble AS ulg WHERE sg.status_id = ulg.status_id) AS votes_up_count" .
				" FROM status_grumble AS sg " . 
                  "WHERE sg.date_submitted >= (UTC_TIMESTAMP() - INTERVAL 4 DAY) HAVING votes_up_count > 0" .
                  " ORDER BY votes_up_count DESC LIMIT 10";
                $result = mysql_query($sql, $conn);
                
                if(mysql_num_rows($result) > 0) {
                    while($row2 = mysql_fetch_array($result)) {
                        outputComments($row2["status_id"], false, $loggedin, false, false, true);	
                    }
                }
                else {
                    echo '<p class="content-padding">No top comments at this time.</p>';	
                }
            ?>
        </div>
        <div id="tab4">
        <?php
            //recent comments
            $sql = "SELECT status_id FROM status_grumble" .
                " ORDER BY status_id DESC LIMIT 10";
            $result = mysql_query($sql, $conn);
            
            if(mysql_num_rows($result) > 0) {
                while($row2 = mysql_fetch_array($result)) {
                    outputComments($row2["status_id"], false, $loggedin, false, false, true);	
                }
            }
            else {
                echo '<p class="content-padding">No recent comments to view.</p>';	
            }
        ?>
        </div>
        <div id="gif-loader"><img src="images/ajax-loader2.gif" alt="loader" width="32" height="32"/></div>
        <div id="view-more-holder">
        <?php
        if($topnumber < 10) 
			echo '<input type="button" class="button view-more" value="View More" style="display:none;"/>';
		else 
			echo '<input type="button" class="button view-more" value="View More"/>';
		?>
        </div>
    </div>
</div>
<?php	
require_once "php/lightboxgrumble.php";
if(!$mobile)
    require_once "php/socialtab.php";
getFooter($filename);
?>