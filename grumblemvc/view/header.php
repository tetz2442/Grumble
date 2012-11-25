<!DOCTYPE html>  
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" href="/css/styles.min.css" rel="stylesheet" media="all">
	<?php //if the user does not have javascript enabled, redirect them ?>
	<noscript>
	    <meta http-equiv="Refresh" content="0; url=/noscript.php">
	</noscript>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!--
		getTitle and description do not currently work, most likely will be replaced by data returned from the view
	-->
	<title>Grumble | <?php //getTitle($filename); ?></title>
	<meta name="description" content="<?php //getDescription($filename); ?>">
	<link rel="Shortcut Icon" href="/favicon.ico">
	<?php //javascript files?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">
	!window.jQuery && document.write('<script src="javascript/jquery-1.8.1.min.js"><\/script>');
	</script>
</head>
<body>
<?php getUserNavigation(); ?>
<div id="maincolumn">