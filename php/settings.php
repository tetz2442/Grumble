<?php
//get current settings
$sql = "SELECT settings_email_thread, settings_email_comment FROM settings_user_grumble WHERE user_id = " . $_SESSION["user_id"];
$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
$row = mysql_fetch_array($result);
?>
<div id="settings-background"></div>
<div id="settings-holder">
	<div class="content-padding">
    	<h1>Settings</h1>
    	<div id="username-change" class="padding-top">
        	<h4>Change Your Username</h4>
        	<label for="username-change-input" title="Change your username">Change Username</label>
        	<input type="text" name="username-change-input" id="username-change-input" class="textInput" maxlength="15" value="<?php echo strip_tags($_GET["id"]); ?>"/>
            <div id="email-change" class="padding-top">
           		<h4>Email Settings</h4>
        		<input type="checkbox" name="email-noti-thread" id="email-noti-thread" <?php if($row["settings_email_thread"] == 1) echo "checked='checked'";?>/><label for="email-noti-thread" class="colored-link-1" title="When your threads reaches a certian amount of Grumbles (10, 20, etc.)">On Threads</label>
                <input type="checkbox" name="email-noti-comment" id="email-noti-comment" <?php if($row["settings_email_comment"] == 1) echo "checked='checked'";?>/><label for="email-noti-comment" class="colored-link-1" title="When someone comments on your Grumble">On Grumbles</label>
        	</div>
        </div>
        <div id="password-change" class="padding-top">
        	<h4>Password Change</h4>
       		<label for="pass-current" title="Your current password">Current Password</label>
        	<input type="password" name="pass-current" id="pass-current" class="textInput" maxlength="50"/>
        	<label for="pass-change" title="Your new password">New Password</label>
        	<input type="password" name="pass-change" id="pass-change" class="textInput" maxlength="50"/>
            <label for="pass-change2" class="margin-top" title="Your new password again">Verify Password</label>
            <input type="password" name="pass-change2" id="pass-change2" class="textInput" maxlength="50"/>
        </div>
        <div id="button-controls">
        	<div class="divider light"></div>
            <button class="button large"/>Close</button>
        	<button class="button large orange"/>Save</button>
            <img src="/images/ajax-loader2.gif" id="gif-loader-settings" width="32" height="32"/>
        </div>
	</div>
</div>