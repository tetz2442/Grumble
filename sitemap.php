<?php
require_once "php/conn.php";

header("Content-type: text/xml");
echo'<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
echo'   <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

//output default pages
?>
<url>
    <loc>http://www.grumbleonline.com</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/create-account</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/updates</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/contact</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/privacy</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/terms-of-service</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/forgot-password</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/how-it-works</loc>
</url>
<url>
    <loc>http://www.grumbleonline.com/about</loc>
</url>
<?php
//get categories
$sql = "SELECT category_url FROM categories_grumble";
$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());

while ($row = mysql_fetch_array($result)) { ?>
            <url>
                <loc>http://www.grumbleonline.com/category/<?php echo $row["category_url"]; ?></loc>
            </url>
<?php } ?>
<?php
//get grumbles
$sql = "SELECT scg.sub_category_url, scg.sub_category_id, cg.category_url FROM sub_category_grumble AS scg " .
	"LEFT OUTER JOIN categories_grumble AS cg ON cg.category_id = scg.category_id";
$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());

while ($row = mysql_fetch_array($result)) { ?>
            <url>
                <loc>http://www.grumbleonline.com/<?php echo $row["category_url"]; ?>/<?php echo $row["sub_category_url"]; ?>/<?php echo $row["sub_category_id"]; ?></loc>
            </url>
<?php } ?> 
<?php
//get profiles
$sql = "SELECT username FROM users_grumble";
$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());

while ($row = mysql_fetch_array($result)) { ?>
            <url>
                <loc>http://www.grumbleonline.com/profile/<?php echo $row["username"]; ?></loc>
            </url>
<?php } ?> 
<?php
//get statuses
$sql = "SELECT sg.status_id, ug.username FROM status_grumble AS sg " .
"LEFT OUTER JOIN users_grumble AS ug ON ug.user_id = sg.user_id " . 
"WHERE ug.user_verified = 1";
$result = mysql_query($sql, $conn) or die("Error: " . mysql_error());

while ($row = mysql_fetch_array($result)) { ?>
            <url>
                <loc>http://www.grumbleonline.com/profile/<?php echo $row["username"]; ?>/comment/<?php echo $row["status_id"]; ?></loc>
            </url>
<?php } ?> 
</urlset>
