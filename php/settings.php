<?php
//get current settings
$sql = "SELECT sug.settings_email_thread, sug.settings_email_comment, ug.user_email FROM settings_user_grumble AS sug LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sug.user_id WHERE sug.user_id = " . $_SESSION["user_id"];
$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());
$row = mysql_fetch_array($result);
?>
<div id="settings-background"></div>
<div id="settings-holder">
	<div class="content-padding">
    	<h1>Settings</h1>
        <ul class="tabs">
            <li><a href='#tab5' class="active">Username</a></li>
            <li><a href='#tab6'>Email</a></li>
            <li><a href='#tab7'>Password</a></li>
            <li><a href='#tab8'>Timezone</a></li>
        </ul>
        <div class="content-padding">
            <div id='tab5'>
                <div id="username-change" class="padding-top">
                    <label for="username-change-input" title="Change your username">Change Username</label><img src="/images/exclamation-red_1.png" alt="validation" class="validation-settings" width="16" height="16"/>
                    <input type="text" name="username-change-input" id="username-change-input" class="textInput" maxlength="15" value="<?php echo strip_tags($_GET["id"]); ?>"/>
                </div>
                <div id="gravatar-change" class="padding-top">
                	<h4>Gravatar</h4>
                	<?php echo '<img class="settings-user-image rounded-corners-medium" src="' . getGravatar($row["user_email"], 80) . '" alt="' .  $row["username"] . '">'; ?>
					<p>To change the image used on your profile, visit <a href="http://www.gravatar.com" target="_blank" class="colored-link-1">Gravatar</a>.</p>      
					<small>Note: Use the email you provided Grumble with if you are a new user.</small>          	
                </div>
            </div>
            <div id='tab6'>
                <div id="email-change" class="padding-top">
                    <h4>Email Settings</h4>
                    <input type="checkbox" name="email-noti-thread" id="email-noti-thread" <?php if($row["settings_email_thread"] == 1) echo "checked='checked'";?>/><label for="email-noti-thread" class="colored-link-1" title="When your Grumble reaches a certian amount of Comments (15, 30, etc.)">On Grumbles</label>
                    <input type="checkbox" name="email-noti-comment" id="email-noti-comment" <?php if($row["settings_email_comment"] == 1) echo "checked='checked'";?>/><label for="email-noti-comment" class="colored-link-1" title="When someone replies to your Comment">On Comments</label>
                </div>
            </div>
            <div id='tab7'>
                <div id="password-change" class="padding-top">
                    <h4>Password Change</h4>
                    <label for="pass-current" title="Your current password">Current Password</label>
                    <input type="password" name="pass-current" id="pass-current" class="textInput" maxlength="50"/>
                    <label for="pass-change" title="Your new password">New Password</label><img src="/images/exclamation-red_1.png" alt="validation" class="validation-settings" width="16" height="16"/>
                    <input type="password" name="pass-change" id="pass-change" class="textInput" maxlength="50"/>
                    <label for="pass-change2" class="margin-top" title="Your new password again">Verify Password</label><img src="/images/exclamation-red_1.png" alt="validation" class="validation-settings" width="16" height="16"/>
                    <input type="password" name="pass-change2" id="pass-change2" class="textInput" maxlength="50"/>
                </div>
            </div>
            <div id='tab8'>
                <div id="timezone-change" class="padding-top">
                    <h4>Timezone Settings</h4>
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
                    <select name="tz" id="tz">
                        <?php
                        foreach($zonelist as $key => $value) {
                            if($_SESSION["timezone"] == $key)
                                echo '      <option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
                            else
                                echo '      <option value="' . $key . '">' . $value . '</option>' . "\n";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div id="button-controls">
        	<div class="divider light"></div>
            <button class="button large"/>Close</button>
        	<button class="button large orange"/>Save</button>
            <img src="/images/ajax-loader2.gif" id="gif-loader-settings" width="32" height="32"/>
        </div>
	</div>
</div>