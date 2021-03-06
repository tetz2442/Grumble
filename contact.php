<?php
require_once "php/conn.php";
require_once "php/functions.php";
require_once "php/header.php";
require_once "php/containerGrumbles.php";
?>
<div id="contact-page-container">
	<div class="text-align-center">
    	<h1>We want to hear from you.</h1>
        <p>Let us know what is on your mind; a question, a suggestion, whatever. We will respond as soon as we can.</p>
    </div>
    <div id="contact-form" class="rounded-corners-large content-padding table-box-shadow">	
    <?php
		if(isset($_SESSION["username"])) {
	?>
        <ul>
            <li>
                <textarea id="contact-textarea" class="textArea" title="Message" rows="10" placeholder="Message... 500 character limit"></textarea>
            </li>
            <li>
                <select class="contact-dropdown rounded-corners">
                	<option selected="selected">Send Message</option>
                    <option>Request Feature</option>
                    <option>Report Bug</option>
                </select>
                <input type="hidden" id="contact-username" value="<?php echo $_SESSION["username"]; ?>"/>
                <input type="submit" id="contact-send" class="push_button orange" name="action" value="Send Please!"/>
            </li>
        </ul>
    <?php
		}
		else {
	?>
    <ul>
        <li>
            <input type="text" id="fullname-contact" class="textInput" name="fullname" maxlength="50" placeholder="Name"/>
            <?php if(!$mobile) { ?>
                <p>Have an account? Make this easier and <a class="dropdown-shortlink colored-link-1">Sign in</a></p>
            <?php } ?>
        </li>
        <li>
            <input type="text" id="email-contact" class="textInput margin-top" name="email" maxlength="255" placeholder="Email"/>
        </li>
        <li>
            <textarea id="contact-textarea" class="margin-top textArea" title="Message" rows="10" name="message" placeholder="Message... 500 character limit"></textarea>
        </li>
        <li>
        	<select class="contact-dropdown rounded-corners">
        		<option selected="selected">Send Message</option>
        		<option>Request Feature</option>
                <option>Report Bug</option>
        	</select>
            <input type="submit" id="contact-send" class="push_button orange" name="action" value="Send Please!"/>
        </li>
    </ul>
    <?php
		}
	?>
    </div>
</div>
<?php	
getFooter($filename);
?>