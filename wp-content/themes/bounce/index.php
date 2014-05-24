<?php get_header(); ?>


<!-- BEGIN CONTENT -->


<div class="lft-content">
	<h1 class="text-center"><?php _e('Why Am I Seeing This Page?', 'gp_lang'); ?></h1>
	
	<div class="sc-divider"></div>
	
	<h3 class="text-center"><?php _e('Go to', 'gp_lang'); ?> <a href="<?php echo admin_url(); ?>options-reading.php"><?php _e('<em>Settings -> Reading</em>', 'gp_lang'); ?></a><?php _e(', select "A static page" option and from the "Front page" drop down menu select the desired page (leave the Posts page drop down menu empty).', 'gp_lang'); ?></h3>
	
	<div class="sc-divider"></div>
	
	<h3 class="text-center"><?php _e('For more info on setting up the theme please read the', 'gp_lang'); ?> <a href="http://ghostpool.com/help/<?php echo $dirname; ?>/help.html" target="_blank"><?php _e('help file', 'gp_lang'); ?></a>.</h3>

</div>

<!-- END CONTENT -->


<?php get_footer(); ?>