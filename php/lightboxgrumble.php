<div id="grumble-lightbox">
<div class="lightbox-head">
    <h3 class="quick-compose-header">What's bothering you?</h3>
    <img src="/images/exit.png" alt="exit" width="15" height="15" class="close-quick-submit" onmouseover="this.src='/images/exitHover.png'" onmouseout="this.src='/images/exit.png'"/>
</div>
<div class="lightbox-grumble-padding">
<?php
	$token = md5(uniqid(rand(), true));
	$_SESSION['token4'] = $token;
?>
    <form action="/php/transact-grumble.php" method="post"><br/>
    	<label for="quick-description-grumblename">Grumble</label> (<span class="help-callout colored-link-1" data-id="1" title="How to write a great Grumble name."><b>?</b></span>)<br/>
        <input type="text" name="grumble" id="quick-description-grumblename" class="textInput"/><br/>
        <label for="quick-description-textarea">Grumble Description</label> (<span class="help-callout colored-link-1" data-id="2" title="How to write a great Grumble description."><b>?</b></span>)<br/>
        <textarea id="quick-description-textarea" class="textArea" title="Describe this Grumble" rows="3" name="description" placeholder="Description..."></textarea>
        <div id="lightbox-submit-padding">
        <select name="category" id="grumble-dropdown" <?php if(isset($_GET["cat"])) echo 'disabled="disabled"';?>>
        	
        	<option <?php if(!isset($_GET["cat"])) echo 'selected="selected"';?> value="0">Choose a Category</option>
            <?php
            	$id = 0;
				$sql = "SELECT category_id, category_name, category_url FROM categories_grumble ORDER BY category_name ASC";
				$result = mysql_query($sql, $conn);
				while($row = mysql_fetch_array($result)) {
					if(isset($_GET["cat"]) && $row["category_url"] == $_GET["cat"]) {
						echo '<option selected="selected" value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
						$id = $row["category_id"];
					}
					else 
						echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
				}
			?>
        </select>
        <?php if(isset($_GET["cat"])) echo '<input type="hidden" name="category" value="' . $id .'" />';?>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <input type="submit" id="quick-description-submit" class="btn-normal button" value="Submit Grumble" name="action"/>
        <span id="character-count">40</span>
        </div>
     </form>
 </div>
</div>
<?php require_once "php/helpcallout.php"; ?>