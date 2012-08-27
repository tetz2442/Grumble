<div id="user-navigation">
	<div id="nav-container">
        <div id="header-grumble">
        	<ul id="navigation">
                <a href="<?php echo "http://" . $_SERVER["HTTP_HOST"];?>"><li>Home</li></a>
                <li id="nav-category" class="last">Categories<img src="/images/arrow.png" class="drop-image" width="10" height="10"/>
                <ul id="sub-nav">
                <?php
					$sql = "SELECT category_id, category_name, category_url FROM categories_grumble ORDER BY category_name ASC";
					$result = mysql_query($sql, $conn);
					echo '<img id="sub-nav-dropdown-arrow" src="/images/dropdown-arrow.png" width="15" height="8"/>';
					while($row = mysql_fetch_array($result)) {
						echo '<a href="/category/' . $row["category_url"] . '" rel="' . $row["category_id"] . '"><li>' . $row["category_name"] . '</li>';
						echo '</a>'; 					
					}
				?>
                </ul>
                </li>
            </ul>
            <?php
                $loggedin = false;
                //if $_SESSION['username'] is false, we know the user us not logged in
                if(isset($_SESSION['username'])) {
                    $loggedin = true;
                }
                else {
                    $loggedin = false;	
                }
            ?>
        </div>
        <a href="<?php echo "http://" . $_SERVER["HTTP_HOST"]; ?>"><img id="logo" src="/images/logo.png" height="51" width="275" alt="Grumble logo" title="Grumble home" onmouseover="this.src='/images/logo-hover.png'" onmouseout="this.src='/images/logo.png'"></a>
        <div id="user-info">
        <?php
        if(isset($_SESSION["username"])) {
            echo '<ul><span class="dropdown-shortlink dropdown-login">' . $_SESSION["username"] . '<img src="/images/arrow.png" class="login-drop-image"/></span>';
            echo '<li id="dropdown-form">';
			echo '<img id="dropdown-arrow-short" src="/images/dropdown-arrow.png" width="15" height="8"/>';
            echo '<ul id="dropdown-sub-nav">';
            echo "<a href='/profile/" . $_SESSION["username"] . "'><li>Profile</li></a>";
			echo "<a href='/profile/" . $_SESSION["username"] . "#settings'><li>Settings</li></a>";
			echo "<a href='/contact'><li>Contact Us</li></a>";
            echo '<li class="divider light"></li>';
            echo "<a href='/php/transact-user.php?action=Logout'><li>Logout</li></a>";
            echo '</ul>';
            echo '</li>';
            echo '</ul>';
        }
        else {
            echo '<ul><span class="dropdown-shortlink dropdown-login" title="Login/Register">Login<img src="/images/arrow.png" class="login-drop-image" width="10" height="10"/></span>';
            echo '<li id="dropdown-form-login"><form action="/php/transact-user.php" method="post">';
			$token = md5(uniqid(rand(), true));
			$_SESSION['token'] = $token;
            ?>
            		<img id="dropdown-arrow" src="/images/dropdown-arrow.png" width="15" height="8"/>
                    <table width="100%">
                        <tr>
                            <td class="table-padding"><label for="email">Email</label><br/>
                            <input type="text" id="email" name="email" maxlength="255" class="input-user-nav"/></td>
                        </tr>
                        <tr>
                            <td class="table-padding"><label for="password">Password</label><br/>
                            <input type="password" name="password" id="password" maxlength="50" class="input-user-nav"/>
                            <?php
							$refer = "../" . basename($_SERVER['PHP_SELF']);
							if($_SERVER['QUERY_STRING'] != "") {
								$refer = $refer . "?" . $_SERVER['QUERY_STRING'];	
							}
							?>
                            <input type="hidden" name="referrer" value="<?php echo $refer; ?>"/>
                            </td>
                        </tr>
                        <tr>
                        	<td class="padding-top">
                            	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                                <input type="checkbox" name="remember-box" id="remember-checkbox"/><label for="remember-checkbox" class="colored-link-1">Remember me</label>
                                <input type="submit" name="action" class="submit-login button" value="Sign In"/>
                            </td>
                        </tr>
                         <tr>
                        	<td class="padding-top"><a class="colored-link-1" href="/create-account">Create an account</a> | <a class="colored-link-1" href="/forgot-password">Forget password?</a></td>
                        </tr>
                    </table>
            <?php
            echo '</form></li>';
            echo '</ul>';
        }
        ?>
        </div>
    </div>
</div>