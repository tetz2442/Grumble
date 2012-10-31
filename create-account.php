<?php
	require_once "php/conn.php";
	require_once "php/header.php";
	require_once "php/containerWide.php";
	require_once "php/functions.php";
	$previousFill = false;
	$name =  array("", "");
	if(isset($_POST["fullname"])) {
		$previousFill = true;
		$name = explode(" ", strip_tags($_POST["fullname"]));
	}
	else if (isset($_GET["fullname"])) {
		$previousFill = true;
		$name = explode(" ", strip_tags($_GET["fullname"]));
	}
	
	$token = md5(uniqid(rand(), true));
	$_SESSION['token2'] = $token;
	if(!isset($_SESSION["user_id"])) {
				// create an array listing the time zones
				$zonelist = array('Kwajalein' => '(GMT-12:00) International Date Line West',
						'Pacific/Midway' => '(GMT-11:00) Midway Island',
						'Pacific/Samoa' => '(GMT-11:00) Samoa',
						'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
						'America/Anchorage' => '(GMT-09:00) Alaska',
						'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
						'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
						'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
						'America/Chihuahua' => '(GMT-07:00) Chihuahua',
						'America/Mazatlan' => '(GMT-07:00) Mazatlan',
						'America/Phoenix' => '(GMT-07:00) Arizona',
						'America/Regina' => '(GMT-06:00) Saskatchewan',
						'America/Tegucigalpa' => '(GMT-06:00) Central America',
						'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
						'America/Mexico_City' => '(GMT-06:00) Mexico City',
						'America/Monterrey' => '(GMT-06:00) Monterrey',
						'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
						'America/Bogota' => '(GMT-05:00) Bogota',
						'America/Lima' => '(GMT-05:00) Lima',
						'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
						'America/Indiana/Indianapolis' => '(GMT-05:00) Indiana (East)',
						'America/Caracas' => '(GMT-04:30) Caracas',
						'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
						'America/Manaus' => '(GMT-04:00) Manaus',
						'America/Santiago' => '(GMT-04:00) Santiago',
						'America/La_Paz' => '(GMT-04:00) La Paz',
						'America/St_Johns' => '(GMT-03:30) Newfoundland',
						'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
						'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
						'America/Godthab' => '(GMT-03:00) Greenland',
						'America/Montevideo' => '(GMT-03:00) Montevideo',
						'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
						'Atlantic/Azores' => '(GMT-01:00) Azores',
						'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
						'Europe/Dublin' => '(GMT) Dublin',
						'Europe/Lisbon' => '(GMT) Lisbon',
						'Europe/London' => '(GMT) London',
						'Africa/Monrovia' => '(GMT) Monrovia',
						'Atlantic/Reykjavik' => '(GMT) Reykjavik',
						'Africa/Casablanca' => '(GMT) Casablanca',
						'Europe/Belgrade' => '(GMT+01:00) Belgrade',
						'Europe/Bratislava' => '(GMT+01:00) Bratislava',
						'Europe/Budapest' => '(GMT+01:00) Budapest',
						'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
						'Europe/Prague' => '(GMT+01:00) Prague',
						'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
						'Europe/Skopje' => '(GMT+01:00) Skopje',
						'Europe/Warsaw' => '(GMT+01:00) Warsaw',
						'Europe/Zagreb' => '(GMT+01:00) Zagreb',
						'Europe/Brussels' => '(GMT+01:00) Brussels',
						'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
						'Europe/Madrid' => '(GMT+01:00) Madrid',
						'Europe/Paris' => '(GMT+01:00) Paris',
						'Africa/Algiers' => '(GMT+01:00) West Central Africa',
						'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
						'Europe/Berlin' => '(GMT+01:00) Berlin',
						'Europe/Rome' => '(GMT+01:00) Rome',
						'Europe/Stockholm' => '(GMT+01:00) Stockholm',
						'Europe/Vienna' => '(GMT+01:00) Vienna',
						'Europe/Minsk' => '(GMT+02:00) Minsk',
						'Africa/Cairo' => '(GMT+02:00) Cairo',
						'Europe/Helsinki' => '(GMT+02:00) Helsinki',
						'Europe/Riga' => '(GMT+02:00) Riga',
						'Europe/Sofia' => '(GMT+02:00) Sofia',
						'Europe/Tallinn' => '(GMT+02:00) Tallinn',
						'Europe/Vilnius' => '(GMT+02:00) Vilnius',
						'Europe/Athens' => '(GMT+02:00) Athens',
						'Europe/Bucharest' => '(GMT+02:00) Bucharest',
						'Europe/Istanbul' => '(GMT+02:00) Istanbul',
						'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
						'Asia/Amman' => '(GMT+02:00) Amman',
						'Asia/Beirut' => '(GMT+02:00) Beirut',
						'Africa/Windhoek' => '(GMT+02:00) Windhoek',
						'Africa/Harare' => '(GMT+02:00) Harare',
						'Asia/Kuwait' => '(GMT+03:00) Kuwait',
						'Asia/Riyadh' => '(GMT+03:00) Riyadh',
						'Asia/Baghdad' => '(GMT+03:00) Baghdad',
						'Africa/Nairobi' => '(GMT+03:00) Nairobi',
						'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
						'Europe/Moscow' => '(GMT+03:00) Moscow',
						'Europe/Volgograd' => '(GMT+03:00) Volgograd',
						'Asia/Tehran' => '(GMT+03:30) Tehran',
						'Asia/Muscat' => '(GMT+04:00) Muscat',
						'Asia/Baku' => '(GMT+04:00) Baku',
						'Asia/Yerevan' => '(GMT+04:00) Yerevan',
						'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
						'Asia/Karachi' => '(GMT+05:00) Karachi',
						'Asia/Tashkent' => '(GMT+05:00) Tashkent',
						'Asia/Kolkata' => '(GMT+05:30) Calcutta',
						'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
						'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
						'Asia/Dhaka' => '(GMT+06:00) Dhaka',
						'Asia/Almaty' => '(GMT+06:00) Almaty',
						'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
						'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
						'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
						'Asia/Bangkok' => '(GMT+07:00) Bangkok',
						'Asia/Jakarta' => '(GMT+07:00) Jakarta',
						'Asia/Brunei' => '(GMT+08:00) Beijing',
						'Asia/Chongqing' => '(GMT+08:00) Chongqing',
						'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
						'Asia/Urumqi' => '(GMT+08:00) Urumqi',
						'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
						'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
						'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
						'Asia/Singapore' => '(GMT+08:00) Singapore',
						'Asia/Taipei' => '(GMT+08:00) Taipei',
						'Australia/Perth' => '(GMT+08:00) Perth',
						'Asia/Seoul' => '(GMT+09:00) Seoul',
						'Asia/Tokyo' => '(GMT+09:00) Tokyo',
						'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
						'Australia/Darwin' => '(GMT+09:30) Darwin',
						'Australia/Adelaide' => '(GMT+09:30) Adelaide',
						'Australia/Canberra' => '(GMT+10:00) Canberra',
						'Australia/Melbourne' => '(GMT+10:00) Melbourne',
						'Australia/Sydney' => '(GMT+10:00) Sydney',
						'Australia/Brisbane' => '(GMT+10:00) Brisbane',
						'Australia/Hobart' => '(GMT+10:00) Hobart',
						'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
						'Pacific/Guam' => '(GMT+10:00) Guam',
						'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
						'Asia/Magadan' => '(GMT+11:00) Magadan',
						'Pacific/Fiji' => '(GMT+12:00) Fiji',
						'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
						'Pacific/Auckland' => '(GMT+12:00) Auckland',
						'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa');
		//user has just created an account, tell them to check there email
		if(isset($_GET["user_created"]) && $_GET["user_created"] == 1) {
?>
<div id="account-create-container">
	<p class="content-padding text-align-center">An email has been sent to your entered email address (make sure to check your spam folder, especially Gmail). Before you can start using Grumble, you must verify this email.</p>
</div>
<?php
		}
		//someone just created an account with social media (facebook, google or twitter)
		else if(isset($_GET["social_create"]) && $_GET["social_create"] == 1 && isset($_GET["username"]) && isset($_GET["token"]) && isset($_GET["provider"])) {
?>
	<div id="account-create-container">
		<div id="account-create-welcome">
	    	 <h1>Welcome to Grumble!</h1>
	    </div>
	    <div id="login-grumble-info">
	        <p class="text-align-center">Before you can start using Grumble there is just a few more things to do.</p>
	        <p class="text-align-center">Entering a password will allow you to enter your account either with <strong><?php echo strip($_GET["provider"]);?></strong>, or by using your email/username and password.</p>
	    </div>
	    <div id="create-account-table" class="rounded-corners-large content-padding table-box-shadow">	
	        <form method='post' action='/php/transact-user.php' onsubmit="return checkForm(this)" name='userForm' id="social-form">
	        <ul>
		        <li>
		            <p class="column1"><label for="username">Username:</label> (<span class="help-callout colored-link-1" data-id="3" title="Tips for creating a username on Grumble."><b>?</b></span>)</p>
		            <p class="column2"><input type="text" id="username" class="textInput" name="username" maxlength="15" autocomplete="off" <?php if(isset($_GET["username"])) { echo "value='" . strip_tags($_GET["username"]) . "'";} ?>/></p>
		            <p class="column3"><img src="/images/ajax-loader.gif" width="16" height="16" class="gif-loader" style="display:none;"/><span id="usernameError"></span></p>
		        </li>
		        <li>
		            <p class="column1"><label for="userpassword">Password:</label> (<span class="help-callout colored-link-1" data-id="4" title="Tips for creating a password on Grumble."><b>?</b></span>)</p>
		            <p class="column2"><input type="password" id="userpassword" class="textInput" name="password" maxlength="50"/></p>
		            <p class="column3"><span id="passError"></span></p>
		        </li>
		        <li>
		            <p class="column1"><label for="userpassword2">Re-enter Password:</label></p> 
		            <p class="column2"><input type="password" id="userpassword2" class="textInput" name="password2" maxlength="50"/></p>
		            <p class="column3"><span id="pass2Error"></span></p>
		        </li>
		        <li>
		            <p class="column1"><label for="tz">Select Timezone:</label></p> 
		            <p class="column2">
		            	<select name="tz" id="tz">
		                	<option value="none">Select Timezone</option>
		                    <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
		                    <option value="America/Anchorage">(GMT-09:00) Alaska</option>
		                    <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
		                    <option value="America/Phoenix">(GMT-07:00) Arizona</option>
		                    <option value="America/Denver">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
		                    <option value="America/Chicago">(GMT-06:00) Central Time (US &amp; Canada)</option>
		                    <option value="America/New_York">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
		                    <option value="America/Indiana/Indianapolis">(GMT-05:00) Indiana (East)</option>
		                    <option disabled="disabled">&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;</option>
							<?php
		                    foreach($zonelist as $key => $value) {
		                        echo '		<option value="' . $key . '">' . $value . '</option>' . "\n";
		                    }
		                    ?>
		                </select>
		            </p>
		            <p class="column3"><span id="timezoneError"></span></p>
		        </li>
		        <li>
		        	<p class="column1"></p>
		            <p id="create-checkbox">
		            	<input type="checkbox" name="terms" id="terms"/><label for="terms" class="terms">Agree to <a href="terms-of-service.php" class="colored-link-1" target="_blank">Terms of Service</a> & <a href="terms-of-service.php" class="colored-link-1" target="_blank">Privacy Policy</a></label>
		            </p>
		            <p class="column3"><span id="termsError"></span></p>
		        </li>
		        <li>
		            <input type="hidden" name="token" value="<?php if(isset($_GET["token"])) { echo "value='" . strip_tags($_GET["token"]) . "'";} ?>" />
		            <input type="submit" class="button orange" name="action" value="Finish Registration"/>
		        </li>
	        </ul>
	        </form>
	    </div>
	</div>
<?php
		}
		//a regular user is creating an account
		else {
?>
<div id="account-create-container">
	<div id="account-create-welcome">
    	 <h1>Create an account on Grumble</h1>
    </div>
    <div id="login-grumble-info">
        <p>Creating an account on Grumble will give you access to its many features.</p>
        <p>Start new Grumble categories and inspire an action for change or simply Grumble about an issue that has been bothering you.</p>
        <p>Welcome to Grumble!</p>
        <p><a href="/php/transact-user.php?provider=facebook&action=sociallogin"><img src="/images/social/facebook.png" alt="Register with Facebook" title="Register with Facebook" /></a>
           <a href="/php/transact-user.php?provider=google&action=sociallogin"><img src="/images/social/google.png" alt="Register with Google" title="Register with Google" /></a></p>
    </div>
    <div id="create-account-table" class="rounded-corners-large content-padding table-box-shadow">	
        <form method='post' action='/php/transact-user.php' onsubmit="return checkForm(this)" name='userForm'>
        <ul>
	        <li>
	            <p class="column1"><label for="firstname">First name:</label></p>
	            <p class="column2"><input type="text" id="firstname" class="textInput" name="firstname" maxlength="50" <?php echo "value='" . $name[0] . "'"; ?>/></p>
	            <p class="column3"><span id="firstnameError"></span></p>
	        </li>
	        <li>
	            <p class="column1"><label for="lastname">Last name:</label></p>
	            <p class="column2"><input type="text" id="lastname" class="textInput" name="lastname" maxlength="50" <?php echo "value='" . $name[1] . "'"; ?>/></p>
	            <p class="column3"><span id="lastnameError"></span></p>
	        </li>
	        <li>
	            <p class="column1"><label for="username">Username:</label> (<span class="help-callout colored-link-1" data-id="3" title="Tips for creating a username on Grumble."><b>?</b></span>)</p>
	            <p class="column2"><input type="text" id="username" class="textInput" name="username" maxlength="15" autocomplete="off"<?php if(isset($_GET["username"])) { echo "value='" . strip_tags($_GET["username"]) . "'";} ?>/></p>
	            <p class="column3"><img src="/images/ajax-loader.gif" width="16" height="16" class="gif-loader" style="display:none;"/><span id="usernameError"></span></p>
	        </li>
	        <li>
	            <p class="column1"><label for="email">Email Address:</label></p>
	            <p class="column2"><input type="text" id="emails" class="textInput" name="email" maxlength="100" autocomplete="off" <?php if(isset($_POST["email"])) { echo "value='" . strip_tags($_POST["email"]) . "'";} else if(isset($_GET["email"])) {echo "value='" . strip_tags($_GET["email"]) . "'"; } ?>/></p>
	            <p class="column3"><img src="/images/ajax-loader.gif" width="16" height="16" class="gif-loader" style="display:none;"/><span id="emailError"></span></p>
	        </li>
	        <li>
	            <p class="column1"><label for="userpassword">Password:</label> (<span class="help-callout colored-link-1" data-id="4" title="Tips for creating a password on Grumble."><b>?</b></span>)</p>
	            <p class="column2"><input type="password" id="userpassword" class="textInput" name="password" maxlength="50"/></p>
	            <p class="column3"><span id="passError"></span></p>
	        </li>
	        <li>
	            <p class="column1"><label for="userpassword2">Re-enter Password:</label></p> 
	            <p class="column2"><input type="password" id="userpassword2" class="textInput" name="password2" maxlength="50"/></p>
	            <p class="column3"><span id="pass2Error"></span></p>
	        </li>
	        <li>
	            <p class="column1"><label for="tz">Select Timezone:</label></p> 
	            <p class="column2">
	            	<select name="tz" id="tz">
	                	<option value="none">Select Timezone</option>
	                    <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
	                    <option value="America/Anchorage">(GMT-09:00) Alaska</option>
	                    <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
	                    <option value="America/Phoenix">(GMT-07:00) Arizona</option>
	                    <option value="America/Denver">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
	                    <option value="America/Chicago">(GMT-06:00) Central Time (US &amp; Canada)</option>
	                    <option value="America/New_York">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
	                    <option value="America/Indiana/Indianapolis">(GMT-05:00) Indiana (East)</option>
	                    <option disabled="disabled">&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;</option>
						<?php
	                    foreach($zonelist as $key => $value) {
	                        echo '		<option value="' . $key . '">' . $value . '</option>' . "\n";
	                    }
	                    ?>
	                </select>
	            </p>
	            <p class="column3"><span id="timezoneError"></span></p>
	        </li>
	        <li>
	        	<p class="column1"></p>
	            <p id="create-checkbox">
	            	<input type="checkbox" name="terms" id="terms"/><label for="terms" class="terms">Agree to <a href="terms-of-service.php" class="colored-link-1" target="_blank">Terms of Service</a> & <a href="terms-of-service.php" class="colored-link-1" target="_blank">Privacy Policy</a></label>
	            </p>
	            <p class="column3"><span id="termsError"></span></p>
	        </li>
	        <li>
	            <input type="hidden" name="token" value="<?php echo $token; ?>" />
	            <input type="submit" class="button orange" name="action" value="Create Account"/>
	        </li>
        </ul>
        </form>
    </div>
</div>
<?php 
		}
}
//a user is logged in and shouldnt be able to access this page
else {
?>
<div id="account-create-container">
	<p class="content-padding text-align-center">Looks like you have already created an account on Grumble. Thanks! Now get out there and start Grumbling.</p>	
</div>
<?php
}
require_once "php/helpcallout.php";
require_once "php/footer.php"; 
?>
