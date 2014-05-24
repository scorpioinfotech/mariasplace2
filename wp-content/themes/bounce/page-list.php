<?php
/*
Template Name: Page List
*/
get_header(); global $gp_settings; ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<!-- BEGIN CONTENT -->


<div class="lft-content">
		
		<!-- BEGIN FEATURED IMAGE -->
		
		<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?>
		
			<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
				<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)),  $gp_settings['image_width'], $gp_settings['image_height'], true, true, true); ?>
				<img src="<?php echo $image; ?>" width="<?php echo $gp_settings['image_width']; ?>" height="<?php echo $gp_settings['image_height']; ?>" style="width: <?php echo $gp_settings['image_width']; ?>px;<?php if($gp_settings['hard_crop'] == "Enable") { ?> height: <?php echo $gp_settings['image_height']; ?>px;<?php } ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />			
			</div><?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
		<?php } ?>
		
		<!-- END FEATURED IMAGE -->
		

		<!-- BEGIN PAGE LIST -->
								
		<?php $children = wp_list_pages('depth=1&title_li=&child_of='.$post->ID.'&echo=0'); if($children) { ?>
		
			<ul class="page-list">
				<?php echo $children; ?>
			</ul>
			
		<?php } ?>
		
		<!-- END PAGE LIST -->


		<!-- BEGIN AUTHOR INFO PANEL -->

		<?php if($gp_settings['author_info'] == "0") { ?><?php echo do_shortcode('[author]'); ?><?php } ?>
		
		<!-- END AUHTOR INFO PANEL -->
		
		
		<!-- BEGIN COMMENTS -->
		
		<?php comments_template(); ?>
	
		<!-- END COMMENTS -->
		
	<?php get_sidebar(); ?>

	</div>
	
	<!-- END CONTENT -->
	

	


<?php endwhile; endif; ?>


<?php get_footer(); ?>