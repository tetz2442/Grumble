<div id="user-navigation">
	<div id="nav-container">
        	<ul id="navigation">
                <li><a href="<?php echo "http://" . $_SERVER["HTTP_HOST"];?>">Home</a></li>
                <li id="nav-category" class="last">Categories<img src="/images/arrow.png" alt="arrow" class="drop-image" width="10" height="10"/>
                <ul id="sub-nav">
                <?php
					$sql = "SELECT category_id, category_name, category_url FROM categories_grumble ORDER BY category_name ASC";
					$result = mysql_query($sql, $conn);
					echo '<img id="sub-nav-dropdown-arrow" src="/images/dropdown-arrow.png" alt="arrow" width="15" height="8"/>';
					while($row = mysql_fetch_array($result)) {
						echo '<li><a href="/category/' . $row["category_url"] . '" rel="' . $row["category_id"] . '">' . $row["category_name"] . '</a></li>';
					}
				?>
                </ul>
                </li>
            </ul>
            <?php
                $loggedin = false;
                //if $_SESSION['username'] is false, we know the user is not logged in
                if(isset($_SESSION['username'])) {
                    $loggedin = true;
					date_default_timezone_set($_SESSION["timezone"]);
                }
                else {
                    $loggedin = false;	
                }
            ?>
        <a id="logo" href="<?php echo "http://" . $_SERVER["HTTP_HOST"]; ?>"><img src="/images/logo.png" height="51" width="275" alt="Grumble logo" title="Grumble home" onmouseover="this.src='/images/logo-hover.png'" onmouseout="this.src='/images/logo.png'"></a>
        <div id="user-info">
        <?php
        if(isset($_SESSION["username"])) {
            echo '<ul><span class="dropdown-shortlink dropdown-login">' . $_SESSION["username"] . '<img src="/images/arrow.png" alt="arrow" class="login-drop-image"/></span>';
            echo '<li id="dropdown-form">';
			echo '<img id="dropdown-arrow-short" alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/>';
            echo '<ul id="dropdown-sub-nav">';
            echo "<li><a href='/profile/" . $_SESSION["username"] . "'>Profile</a></li>";
			echo '<li class="divider light"></li>';
			echo "<li><a href='/contact'>Contact Us</a></li>";
            echo '<li class="divider light"></li>';
			echo "<li><a href='/profile/" . $_SESSION["username"] . "#settings' id='settings-dropdown'>Settings</a></li>";
            echo "<li><a href='/php/transact-user.php?action=Logout'>Logout</a></li>";
            echo '</ul>';
            echo '</li>';
            echo '</ul>';
        }
        else {
            echo '<ul><span class="dropdown-shortlink dropdown-login" title="Login/Register">Login<img src="/images/arrow.png" alt="arrow" class="login-drop-image" width="10" height="10"/></span>';
            echo '<li id="dropdown-form-login"><form action="/php/transact-user.php" method="post">';
			$token = md5(uniqid(rand(), true));
			$_SESSION['token'] = $token;
            ?>
            		<img id="dropdown-arrow" alt="arrow" src="/images/dropdown-arrow.png" width="15" height="8"/>
                    <ul>
                        <li>
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" maxlength="255" class="input-user-nav"/>
                        </li>
                        <li class="padding-top">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" maxlength="50" class="input-user-nav"/>
                            <?php
							$refer = "../" . basename($_SERVER['PHP_SELF']);
							if($_SERVER['QUERY_STRING'] != "") {
								$refer = $refer . "?" . $_SERVER['QUERY_STRING'];	
							}
							?>
                            <input type="hidden" name="referrer" value="<?php echo $refer; ?>"/>
                        </li>
                        <li class="padding-top">
                        	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                            <input type="checkbox" name="remember-box" id="remember-checkbox"/><label for="remember-checkbox" class="colored-link-1">Remember me</label>
                            <input type="submit" name="action" class="submit-login button" value="Sign In"/>
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