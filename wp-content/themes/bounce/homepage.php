<style>
.sb-right #content {
float: none;
}
#content {
position: relative;
width: 92%;
margin: 0px auto;
}
</style>
<?php
/*
Template Name: Homepage
*/
get_header(); global $gp_settings; ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<!-- BEGIN CONTENT -->


<div class="lft-content">
		
		<!-- BEGIN FEATURED IMAGE -->
		
		<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?>
		
			<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
				<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), $gp_settings['image_width'], $gp_settings['image_height'], true, true, true); ?>
				<img src="<?php echo $image; ?>" width="<?php echo $gp_settings['image_width']; ?>" height="<?php echo $gp_settings['image_height']; ?>" style="width: <?php echo $gp_settings['image_width']; ?>px;<?php if($gp_settings['hard_crop'] == "Enable") { ?> height: <?php echo $gp_settings['image_height']; ?>px;<?php } ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />			
			</div><?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
			
		<?php } ?>
		
		<!-- END FEATURED IMAGE -->
		
		
		<!-- BEGIN POST CONTENT -->
		
		<div id="post-content">
<?php //echo get_post_meta($post->ID,'ghostpool_top_content',true);
?>
		
			<?php the_content(__('Read More &raquo;', 'gp_lang')); ?>
			
		</div>
		
		<!-- END POST CONTENT -->
		
		
		<!-- BEGIN POST NAV -->
		
		<?php wp_link_pages('before=<div class="clear"></div><div class="wp-pagenavi post-navi">&pagelink=<span>%</span>&after=</div>'); ?>		
		
		<!-- END POST NAV -->
		
		
		<!-- END CONTENT -->
		
		
		<!-- BEGIN AUTHOR INFO PANEL -->
		
		<?php if($gp_settings['author_info'] == "0") { ?><?php echo do_shortcode('[author]'); ?><?php } ?>
		
		<!-- END AUTHOR INFO PANEL -->
		
		
		<!-- BEGIN COMMENTS -->
		
		<?php comments_template(); ?>
	
		<!-- END COMMENTS -->
	
	
	</div>

	<!-- END CONTENT -->
	
	
	


<?php endwhile; endif; ?>

<?php get_footer(); ?>