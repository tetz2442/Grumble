<?php
//get current settings
?>
<div id="settings-holder">
	<div class="content-padding">
    	<h1>Settings</h1>
    	<div id="username-change" class="padding-top">
        	<label for="username-change-input">Change Username</label><br/>
        	<input type="text" name="username-change-input" id="username-change-input" class="textInput" value="<?php echo strip_tags($_GET["id"]); ?>"/>
            <div id="email-change" class="padding-top">
        		<input type="checkbox" name="email-not" id="email-not"/><label for="email-not" class="colored-link-1">Receive Email Notifications</label>
        	</div>
        </div>
        <div id="password-change" class="padding-top">
       		<label for="pass-current">Current Password</label><br/>
        	<input type="text" name="pass-current" id="pass-current" class="textInput"/><br/><br/>
        	<label for="pass-change">New Password</label><br/>
        	<input type="text" name="pass-change" id="pass-change" class="textInput"/><br/>
            <label for="pass-change2" class="margin-top">Verify Password</label><br/>
            <input type="text" name="pass-change2" id="pass-change2" class="textInput"/><br/>
        </div>
        <div id="button-controls">
        	<div class="divider light"></div>
            <button class="button large"/>Close</button>
        	<button class="button large orange"/>Save</button>
        </div>
	</div>
</div>