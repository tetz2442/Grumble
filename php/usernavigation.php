<div id="user-navigation">
	<div id="nav-container">
    	<ul id="navigation">
            <li><a href="<?php echo "http://" . $_SERVER["HTTP_HOST"];?>">Home</a></li>
            <li id="nav-category">Categories<img src="/images/arrow-down.png" alt="arrow" class="drop-image" width="10" height="10"/>
                <ul id="sub-nav" class="rounded-corners-medium">
                    <li id="sub-nav-dropdown-arrow"><img src="/images/dropdown-arrow.png" alt="arrow" width="15" height="8"/></li>
                <?php
					$sql = "SELECT category_id, category_name, category_url FROM categories_grumble ORDER BY category_name ASC";
					$result = mysql_query($sql, $conn);
					while($row = mysql_fetch_array($result)) {
						echo '<li><a href="/category/' . $row["category_url"] . '">' . $row["category_name"] . '</a></li>';
					}
				?>
                </ul>
            </li>
        </ul>
        <a id="logo" href="<?php echo "http://" . $_SERVER["HTTP_HOST"]; ?>"><img src="/images/logo.png" height="51" width="275" alt="Grumble logo" title="Grumble home" onmouseover="this.src='/images/logo-hover.png'" onmouseout="this.src='/images/logo.png'"></a>
        <div id="user-info">
        <?php
        if(isset($_SESSION["username"])) {
        	require_once 'functions.php';
            echo '<ul>';
                $sql = "SELECT notification_id, notification_message, notification_url, notification_read, notification_created FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY notification_created DESC LIMIT 10";
				$result = mysql_query($sql, $conn);
				$sql = "SELECT COUNT(notification_id) as number FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " AND notification_read = 0";
				$number = mysql_query($sql, $conn);
				$row = mysql_fetch_array($number);
                echo '<li class="user-inline"><span id="notification-number" title="Notifications">' . $row["number"] . '</span>';
					echo '<ul id="notification-dropdown" class="rounded-corners-medium">';
					echo ' <li id="dropdown-arrow-notifications"><img alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/></li>';
					echo ' <li id="notification-header">Notifications</li>';
					if(mysql_num_rows($result) != 0) {
	                	while($row = mysql_fetch_array($result)) {
	                		$formatted_date = convertToTimeZone($_row["notification_created"], $_SESSION["timezone"]);
	                		if($row["notification_read"] == 0) {
								echo '<li data-id="' . $row["notification_id"] .'" class="ind-notification">';
									echo '<a href="' . $row["notification_url"] . '" class="colored-link-1 highlight">' . $row["notification_message"];
									echo '<small>' . $formatted_date . '</small>'. '</a>';
								echo '</li>';
							}
							else {
								echo '<li data-id="' . $row["notification_id"] .'" class="ind-notification">';
									echo '<a href="' . $row["notification_url"] . '" class="colored-link-1">' . $row["notification_message"];
									echo '<small>' . $formatted_date . '</small>'. '</a>';
								echo '</li>';
							}
						}
					}
					else {
						echo '<li class="content-padding">No notifications</li>';
					}
					if(mysql_num_rows($result) == 10) {
						echo ' <li id="notification-load"><a href="#" class="colored-link-1">Load more...</a></li>';
					}
					echo '</ul>';
				echo '</li>';
                echo '<li class="user-inline"><span class="dropdown-login dropdown-shortlink">' . $_SESSION["username"] . '<img src="/images/arrow-down.png" alt="arrow" class="login-drop-image"/></span>';
                    echo '<ul id="dropdown-sub-nav" class="rounded-corners-medium">';
                        echo '<li id="dropdown-arrow-short"><img alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/></li>';
                        echo "<li><a href='/profile/" . $_SESSION["username"] . "'>Profile</a></li>";
            			echo '<li class="divider light"></li>';
            			echo "<li><a href='/contact'>Contact Us</a></li>";
                        echo '<li class="divider light"></li>';
            			echo "<li><a href='/profile/" . $_SESSION["username"] . "#settings' id='settings-dropdown'>Settings</a></li>";
            			if($_SESSION["access_lvl"] == 3) {
            				echo "<li><a href='/gr-admin'>Admin</a></li>";
            			}
                        echo "<li><a href='/php/transact-user.php?action=Logout'>Logout</a></li>";
                    echo '</ul>';
                echo '</li>';
            echo '</ul>';
        }
        else {
            echo '<ul>';
            echo '<li class="dropdown-login">';
            echo '<span class="dropdown-shortlink" title="Login/Register">Login<img src="/images/arrow-down.png" alt="arrow" class="login-drop-image" width="10" height="10"/></span>';
            echo '<form action="/php/transact-user.php" method="post">';
			$token = md5(uniqid(rand(), true));
			$_SESSION['token'] = $token;
            ?>
                    <ul id="dropdown-form-login" class="rounded-corners-medium">
                        <li id="dropdown-arrow"><img alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/></li>
                        <li>
                            <label for="email">Email or Username</label>
                            <input type="text" id="email" name="email" maxlength="255" class="input-user-nav textInput"/>
                        </li>
                        <li class="padding-top">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" maxlength="50" class="input-user-nav textInput"/>
                            <?php
							/*$refer = "../" . basename($_SERVER['PHP_SELF']);
							if($_SERVER['QUERY_STRING'] != "") {
								$refer = $refer . "?" . $_SERVER['QUERY_STRING'];	
							}*/
							?>
                            <input type="hidden" name="referrer" id="login-refer" value=""/>
                        </li>
                        <li class="padding-top">
                        	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                            <input type="checkbox" name="remember-box" id="remember-checkbox"/><label for="remember-checkbox" class="colored-link-1">Remember me</label>
                            <input type="submit" name="action" class="submit-login button" value="Sign In"/>
                        </li>
                       <li class="padding-top"><p class="padding-top">OR login with</p></li>
                        <li class="padding-top social-login">
                        	<a href="/php/transact-user.php?provider=facebook&action=sociallogin"><img src="/images/social/facebook.png" alt="Login with Facebook" title="Login with Facebook" /></a>
                        	<a href="/php/transact-user.php?provider=google&action=sociallogin"><img src="/images/social/google.png" alt="Login with Google" title="Login with Google" /></a>
                        </li>
                         <li class="login-last">
                        	<a class="colored-link-1" href="/create-account">Create an account</a> | <a class="colored-link-1" href="/forgot-password">Forget password?</a>
                        </li>
                    </ul>
            <?php
            echo '</form></li>';
            echo '</ul>';
        }
        ?>
        </div>
    </div>
</div>