<?php
	require_once "php/conn.php";
	require_once "php/http.php";
	require_once "php/header.php";
	require_once "php/containerWide.php";
	$validation = true;
	$previousFill = false;
	$name =  array("", "");
	if(isset($_POST["fullname"]) && isset($_POST["email"])) {
		$previousFill = true;
		$name = explode(" ", strip_tags($_POST["fullname"]));
	}
	
	$token = md5(uniqid(rand(), true));
	$_SESSION['token2'] = $token;
	if(!isset($_SESSION["user_id"])) {
		if(isset($_GET["user_created"]) && $_GET["user_created"] == 1) {
?>
<div id="account-create-container">
	<p class="content-padding text-align-center"><b>An email has been sent to your entered email address. Before you can start using Grumble, you must verify this email.</b></p>
</div>
<?php
		}
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
    </div>
    <div id="create-account-table" class="rounded-corners-large content-padding">	
        <form method='post' action='/php/transact-user.php' onsubmit="return checkForm(this)" name='userForm'>
        <table>
        <tr>
            <th colspan="2" align="center"><h3>Enter user information</h3></th>
        </tr>
        <tr>
            <td align="right"><label for="firstname">First name:</label></td>
            <td><input type="text" id="firstname" class="textInput" name="firstname" maxlength="50" autocomplete="off" <?php echo "value='" . $name[0] . "'"; ?>/></td>
            <td width="290"><span id="firstnameError"></span></td>
        <tr>
        <tr>
            <td align="right"><label for="lastname">Last name:</label></td>
            <td><input type="text" id="lastname" class="textInput" name="lastname" maxlength="50" autocomplete="off" <?php echo "value='" . $name[1] . "'"; ?>/></td>
            <td><span id="lastnameError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="username">Username:</label> (<span class="help-callout colored-link-1" data-id="3" title="Tips for creating a username on Grumble."><b>?</b></span>)</td>
            <td><input type="text" id="username" class="textInput" name="username" maxlength="15" autocomplete="off"/></td>
            <td><img src="/images/ajax-loader.gif" width="16" height="16" class="gif-loader" style="display:none;"/><span id="usernameError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="email">Email Address:</label></td>
            <td><input type="text" id="emails" class="textInput" name="email" maxlength="100" autocomplete="off" <?php if(isset($_POST["email"])) { echo "value='" . strip_tags($_POST["email"]) . "'";}; ?>/></td>
            <td><img src="/images/ajax-loader.gif" width="16" height="16" class="gif-loader" style="display:none;"/><span id="emailError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="userpassword">Password:</label> (<span class="help-callout colored-link-1" data-id="4" title="Tips for creating a password on Grumble."><b>?</b></span>)</td>
            <td><input type="password" id="userpassword" class="textInput" name="password" maxlength="50"/></td>
            <td><span id="passError"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="userpassword2">Re-enter Password:</label></td> 
            <td><input type="password" id="userpassword2" class="textInput" name="password2" maxlength="50"/></td>
            <td><span id="pass2Error"></span></td>
        </tr>
        <tr>
            <td align="right"><label for="tz">Select Timezone:</label></td> 
            <td>
            <?php
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
				?>
            	<select name="tz" style="width:205px;" id="tz">
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
            </td>
            <td><span id="timezoneError"></span></td>
        </tr>
        <tr>
        	<td></td>
            <td width="205">
            	<input type="checkbox" name="terms" id="terms"/><label for="terms" class="terms">Agree to <a href="terms-of-service.php" target="_blank">Terms of Service</a> & <a href="terms-of-service.php" target="_blank">Privacy Policy</a></label>
            </td>
            <td><span id="termsError"></span></td>
        </tr>
        <tr>
            <td align="right" colspan="2">
            <input type="hidden" name="token" value="<?php echo $token; ?>" />
            <input type="submit" class="button orange" name="action" value="Create Account"/>
            </td>
        </tr>
        </table>
        </form>
    </div>
</div>
<?php 
		}
}
else {
?>
<div id="account-create-container">
	<p class="content-padding text-align-center"><b>Looks like you have already created an account on Grumble. Thanks! Now get out there and start Grumbling.</b></p>	
</div>
<?php
}
require_once "php/notificationbar.php";
require_once "php/helpcallout.php";
require_once "php/footer.php"; 
?>
