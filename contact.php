<?php
require_once "php/conn.php";
require_once "php/header.php";
require_once "php/containerWide.php";
$contactvalidation = true;
?>
<div id="contact-page-container">
	<div class="text-align-center">
    	<h1>We want to hear from you.</h1>
        <p>Let us know what is on your mind; a question, a suggestion, whatever. We will respond as soon as we can.</p>
    </div>
    <div id="contact-form">	
    <?php
		if(isset($_SESSION["username"])) {
	?>
        <table width="100%">
            <tr>
                <td colspan="2" id="contact-error"></td>
            </tr>
            <tr>
                <td colspan="2"><textarea id="contact-textarea" class="textArea" title="Message" rows="10" placeholder="Message"></textarea></td>
            </tr>
            <tr>
                <td>
                    <select class="contact-dropdown rounded-corners">
                        <option>Request Feature</option>
                        <option>Report Bug</option>
                        <option>Send Message</option>
                    </select>
                </td>
                <td align="right" class="table-padding-top">
                <input type="hidden" id="contact-username" value="<?php echo $_SESSION["username"]; ?>"/>
                <input type="submit" id="contact-send" class="push_button orange" name="action" value="Send Please!"/>
                </td>
            </tr>
        </table>
    <?php
		}
		else {
	?>
    <table>
        <tr>
            <td><input type="text" id="fullname-contact" class="textInput" name="fullname" maxlength="50" placeholder="Name"/></td>
            <td rowspan="2" align="center" id="contact-error">Have an account? Make this easier and <a class="dropdown-shortlink" href="#">Sign in</a></td>
        </tr>
        <tr>
            <td><input type="text" id="email-contact" class="textInput margin-top" name="email" maxlength="255" placeholder="Email"/></td>
        </tr>
        <tr>
            <td colspan="2"><textarea id="contact-textarea" class="margin-top textArea" title="Message" rows="10" name="message" placeholder="Message"></textarea></td>
        </tr>
        <tr>
        	<td>
            	<select class="contact-dropdown rounded-corners">
            		<option>Request Feature</option>
                    <option>Report Bug</option>
                    <option>Send Message</option>
            	</select>
            </td>
            <td align="right" class="table-padding-top">
            <input type="submit" id="contact-send" class="push_button orange" name="action" value="Send Please!"/>
            </td>
        </tr>
        </table>
    <?php
		}
	?>
    </div>
</div>
<?php	
require_once "php/lightboxthread.php";
require_once "php/footer.php"; 
?>