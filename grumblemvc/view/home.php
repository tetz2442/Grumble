<?php getHeader(); ?>
<ul>
	<?php foreach($viewmodel as $item) { ?>
	<li><?php echo $item; ?></li>
	<?php } ?>
</ul>
<?php getFooter(); ?>