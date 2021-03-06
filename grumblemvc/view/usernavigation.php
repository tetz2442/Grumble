<nav>
	<div>
    	<ul id="navigation">
            <?php if(!MOBILE) {?>
            <li id="nav-home"><a href="<?php echo SITE_URL;?>">Home</a></li>
            <?php } ?>
            <li id="nav-category">Categories<img src="<?php echo TEMPLATE_PATH; ?>/images/arrow-down.png" alt="arrow" class="drop-image" width="10" height="10"/>
                <ul class="dropdown rounded-corners-medium">
                    <li><img src="<?php echo TEMPLATE_PATH; ?>/images/dropdown-arrow.png" alt="arrow" width="15" height="8"/></li>
                <?php
	                foreach ($categories as $category) {
						echo '<li><a href="/category/' . $category["category_url"] . '">' . $category["category_name"] . '</a></li>';
	                }
				?>
                </ul>
            </li>
        </ul>
        <a id="logo" href="<?php echo SITE_URL; ?>"><img src="<?php echo TEMPLATE_PATH; ?>/images/logo.png" alt="Grumble logo" title="Grumble home" onmouseover="this.src='<?php echo TEMPLATE_PATH; ?>/images/logo-hover.png'" onmouseout="this.src='<?php echo TEMPLATE_PATH; ?>/images/logo.png'"></a>
        <div id="user-info">
        <?php
        /*if(isset($_SESSION["username"])) {
            echo '<ul>';
                $sql = "SELECT notification_id, notification_message, notification_url, notification_created, notification_read FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY notification_created DESC LIMIT 10";
				$result = mysql_query($sql, $conn);
				$sql = "SELECT COUNT(notification_id) AS number FROM notifications_grumble WHERE user_id = " . $_SESSION["user_id"] . " AND notification_read = 0";
				$number = mysql_query($sql, $conn);
				$row = mysql_fetch_array($number);
                echo '<li class="user-inline">';
					if ($row["number"] > 0) {
						echo '<img id="notification-number" title="Notifications" src="/images/icons/notification.png" alt="notifications">';
					} else {
						echo '<img id="notification-number" title="Notifications" src="/images/icons/notification-none.png" alt="notifications">';
					}
					echo '<ul id="notification-dropdown" class="dropdown rounded-corners-medium">';
					echo ' <li id="dropdown-arrow-notifications"><img alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/></li>';
					echo ' <li id="notification-header"><span>Notifications (' . $row["number"] . ' new)</span>';
						echo '<a href="/profile/' . $_SESSION["username"] . '/notifications" class="colored-link-1">See all</a>';
					echo '</li>';
					if(mysql_num_rows($result) != 0) 
						outputNotifications($result);
					else {
						echo '<li class="content-padding">No notifications</li>';
					}
					if(mysql_num_rows($result) == 10) {
						echo ' <li id="notification-load"><a href="#" class="colored-link-1">Load more...</a></li>';
					}
					echo '</ul>';
				echo '</li>';
				//if mobile, do an icon instead of the username
				 echo '<li class="user-inline"><span class="dropdown-login dropdown-shortlink">' . $_SESSION["username"] . '<img src="/images/arrow-down.png" alt="arrow" class="login-drop-image"/>
				 </span><img id="mobile-dropdown" class="dropdown-shortlink" title="User dropdown" src="/images/icons/user-big.png" alt="user dropdown">';
                    echo '<ul id="dropdown-sub-nav" class="dropdown rounded-corners-medium">';
                        echo '<li id="dropdown-arrow-short"><img alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/></li>';
                        echo '<li><a href="/profile/' . $_SESSION["username"] . '"><span id="profile-span">Profile</span></a></li>';
            			echo '<li class="divider light"></li>';
            			echo '<li><a href="/contact"><span id="contact-span">Contact Us</span></a></li>';
                        echo '<li class="divider light"></li>';
            			echo '<li><a href="/profile/' . $_SESSION["username"] . '#settings" id="settings-dropdown"><span id="settings-span">Settings</span></a></li>';
            			if($_SESSION["access_lvl"] == 3) {
            				echo '<li><a href="/gr-admin"><span id="admin-span">Admin</span></a></li>';
            			}
                        echo '<li><a href="/php/transact-user.php?action=Logout"><span id="logout-span">Logout</span></a></li>';
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
                    <ul id="dropdown-form-login" class="dropdown rounded-corners-medium">
                        <li id="dropdown-arrow"><img alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/></li>
                       <li class="social-login">
					       <a href="/php/transact-user.php?provider=facebook&action=sociallogin" class="zocial facebook"><span>Login with Facebook</span></a>
					       <a href="/php/transact-user.php?provider=google&action=sociallogin" class="zocial google"><span>Login with Google</span></a>
					       <a href="/login" class="zocial grumble grumble-login"><span>Login with Grumble</span></a>
                       </li>
                       <li class="login-last">
                       		<a class="colored-link-1" href="/create-account">Create an account</a> | <a class="colored-link-1" href="/forgot-password">Forget password?</a>
                       </li>
                       <li class="hidden">
                       	<ul>
                       		<li>
	                            <label for="email">Email or Username</label>
	                            <input type="text" id="email" name="email" maxlength="255" class="input-user-nav textInput"/>
	                        </li>
	                        <li class="padding-top">
	                            <label for="password">Password</label>
	                            <input type="password" name="password" id="password" maxlength="50" class="input-user-nav textInput"/>
	                            <input type="hidden" name="referrer" id="login-refer" value=""/>
	                        </li>
	                        <li class="padding-top">
	                        	<input type="hidden" name="token" value="<?php echo $token; ?>" />
	                            <input type="checkbox" name="remember-box" id="remember-checkbox"/><label for="remember-checkbox" class="colored-link-1">Remember me</label>
	                            <input type="submit" name="action" class="submit-login button" value="Sign In"/>
	                        </li>
	                    </ul>
                       </li>
                    </ul>
            <?php
            echo '</form></li>';
            echo '</ul>';
        }*/
        ?>
        </div>
    </div>
</nav>