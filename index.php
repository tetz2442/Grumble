<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
require_once "php/timeago.php";
require_once "php/outputgrumbles.php";
require_once "php/outputthreads.php";
require_once "php/seofriendlyurls.php";
?>
<div class="content-padding">
<div id="grumble-home-info">
<?php
if(!isset($_SESSION["username"])) {
?>
        <h2>Hey there! Got something to Grumble about? Let's hear it.</h2>
        <p>Grumble lets you discuss topics that you feel are important and need attention.</p>
        <p>Create a new thread and start Grumbling!</p>
        <p>
        	<a href='about' class="colored-link-1">About</a> |
        	<a href="create-account" class="colored-link-1">Create account</a>
        </p>
<?php
}
else {
?>
<h2>Hey <a href="profile/<?php echo $_SESSION["username"]; ?>" class="colored-link-1"><?php echo $_SESSION["username"]; ?></a>! Got something to Grumble about? Let's hear it.</h2>
 <button class="push_button orange" id="start-new-thread" title="Start New Thread">Start New Thread</button>
<?php
}
?>
</div>
<div id="home-tabs-holder">
    <ul class="tabs">
        <li><a href='#tab1' class="active">Top Threads</a></li>
        <li><a href='#tab2'>Recent Threads</a></li>
        <li><a href='#tab3'>Top Grumbles</a></li>
        <li><a href='#tab4'>Recent Grumbles</a></li>
    </ul>
    <div id="arrow-top"><img src="images/arrow-up.png" width="15" height="15"/></div>
    <div id="tabs-horizontal-float">
        <div id='tab1'>
             <?php
                //top threads
                $sql = "SELECT sub_category_id FROM sub_category_grumble" .
                " WHERE grumble_number > 0 ORDER BY grumble_number DESC LIMIT 10";
                $result = mysql_query($sql, $conn);
                
				$topnumber = mysql_num_rows($result);
				
                if(mysql_num_rows($result) > 0) {
                    while($row2 = mysql_fetch_array($result)) {
                        outputThreads($row2["sub_category_id"], true);	
                    }
                }
                else {
                    echo '<p class="content-padding"><b>No grumble threads.</b></p>';	
                }
            ?>
        </div>
        <div id="tab2">
        <?php
            //recent threads
            $sql = "SELECT sub_category_id FROM sub_category_grumble" .
            " ORDER BY sub_category_id DESC LIMIT 10";
            $result = mysql_query($sql, $conn);
            
            if(mysql_num_rows($result) > 0) {
                while($row2 = mysql_fetch_array($result)) {
                    outputThreads($row2["sub_category_id"], true);	
                }
            }
            else {
                echo '<p class="content-padding"><b>No grumble threads.</b></p>';	
            }
        ?>
        </div>
        <div id='tab3'>
             <?php
                //top grumbles
                $sql = "SELECT sg.status_id FROM status_grumble AS sg " . 
                  "LEFT OUTER JOIN votes_up_grumble AS vg ON sg.status_id = vg.status_id " .
                  "LEFT OUTER JOIN users_grumble AS ug ON " .
                  "sg.user_id = ug.user_id " . 
                  "WHERE date_submitted >= (CURDATE() - INTERVAL 7 DAY) " .
                  "AND vg.votes_up_count > 0 ORDER BY vg.votes_up_count DESC LIMIT 10";
                $result = mysql_query($sql, $conn);
                
                if(mysql_num_rows($result) > 0) {
                    while($row2 = mysql_fetch_array($result)) {
                        outputGrumbles($row2["status_id"], false, $loggedin);	
                    }
                }
                else {
                    echo '<p class="content-padding"><b>No grumble.</b></p>';	
                }
            ?>
        </div>
        <div id="tab4">
        <?php
            //recent threads
            $sql = "SELECT status_id FROM status_grumble" .
                " ORDER BY status_id DESC LIMIT 10";
            $result = mysql_query($sql, $conn);
            
            if(mysql_num_rows($result) > 0) {
                while($row2 = mysql_fetch_array($result)) {
                    outputGrumbles($row2["status_id"], false, $loggedin);	
                }
            }
            else {
                echo '<p class="content-padding"><b>No grumble.</b></p>';	
            }
        ?>
        </div>
        <div id="gif-loader"><img src="images/ajax-loader2.gif" width="32" height="32"/></div>
        <div id="view-more-holder">
        <?php
        if($topnumber < 5) 
			echo '<input type="button" class="button view-more" value="View More" style="display:none;"/>';
		else 
			echo '<input type="button" class="button view-more" value="View More"/>';
		?>
        </div>
    </div>
    </div>
</div>
</div>
<?php	
require_once "php/lightboxthread.php";
require_once "php/footer.php"; 
?>