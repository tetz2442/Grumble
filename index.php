<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
require_once "php/timeago.php";
require_once "php/timer.php";
require_once "php/outputgrumbles.php";
require_once "php/outputcomments.php";
require_once "php/seofriendlyurls.php";
?>
<div class="content-padding">
<div id="grumble-home-info">
<?php
if(!isset($_SESSION["username"])) {
?>
        <h2>Hey there! Got something to Grumble about? Let's hear it.</h2>
        <p>Grumble lets you discuss topics that you feel are important and need attention.</p>
        <p>Create a new Grumble and start Grumbling!</p>
        <p>
        	<a href='about' class="colored-link-1">About</a> |
        	<a href="create-account" class="colored-link-1">Create account</a>
        </p>
<?php
}
else {
	require_once "php/notificationbar.php";
?>
<h2>Hey <a href="profile/<?php echo $_SESSION["username"]; ?>" class="colored-link-1"><?php echo $_SESSION["username"]; ?></a>! Got something to Grumble about? Let's hear it.</h2>
 <button class="push_button orange" id="start-new-grumble" title="New Grumble">New Grumble</button>
<?php
}
?>
</div>
<div id="home-tabs-holder">
    <ul class="tabs">
        <li><a href='#tab1' class="active">Top Grumbles</a></li>
        <li><a href='#tab2'>Recent Grumbles</a></li>
        <li><a href='#tab3'>Top Comments</a></li>
        <li><a href='#tab4'>Recent Comments</a></li>
    </ul>
    <div id="arrow-top"><img src="images/arrow-up.png" alt="arrow" width="15" height="15"/></div>
    <div class="float-left">
        <div id='tab1'>
             <?php
                //top grumbles
                $sql = "SELECT sub_category_id FROM sub_category_grumble" .
                " WHERE grumble_number > 0 AND sub_category_created >= (UTC_TIMESTAMP() - INTERVAL 7 DAY) ORDER BY grumble_number DESC LIMIT 10";
                $result = mysql_query($sql, $conn);
                
				$topnumber = mysql_num_rows($result);
			
                if(mysql_num_rows($result) > 0) {
                    while($row2 = mysql_fetch_array($result)) {
                        outputGrumbles($row2["sub_category_id"], true);	
                    }
                }
                else {
                    echo '<p class="content-padding">No top grumbles at this time.</p>';	
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
                  "WHERE sg.date_submitted >= (UTC_TIMESTAMP() - INTERVAL 7 DAY) HAVING votes_up_count > 0" .
                  " ORDER BY votes_up_count DESC LIMIT 10";
                $result = mysql_query($sql, $conn);
                
                if(mysql_num_rows($result) > 0) {
                    while($row2 = mysql_fetch_array($result)) {
                        outputComments($row2["status_id"], false, $loggedin);	
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
                    outputComments($row2["status_id"], false, $loggedin);	
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
</div>
<?php	
require_once "php/lightboxgrumble.php";
require_once "php/footer.php"; 
?>