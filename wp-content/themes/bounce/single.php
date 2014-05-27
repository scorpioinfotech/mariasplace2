<?php get_header(); ?>

<div class="qa-left-side">
<?php
global $qa_general_settings;

if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
	dynamic_sidebar( 'Article Page Sidebar' );
?>
</div>


<div class="qa-right-side">

<div id="qa-page-wrapper">
	<div id="qa-content-wrapper">
<?php global $gp_settings; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<!-- END CONTENT -->


<div class="lft-content">
		<!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-537efa5854ef0739"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-537efa5854ef0739"></script>
<!-- AddThis Button END -->
		<!-- BEGIN FEATURED IMAGE -->
		
		<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?>
		
			<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
				<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)),  $gp_settings['image_width'], $gp_settings['image_height'], true, true, true); ?>
				<img src="<?php echo $image; ?>" width="<?php echo $gp_settings['image_width']; ?>" height="<?php echo $gp_settings['image_height']; ?>" style="width: <?php echo $gp_settings['image_width']; ?>px;<?php if($gp_settings['hard_crop'] == "Enable") { ?> height: <?php echo $gp_settings['image_height']; ?>px;<?php } ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />			
			</div><?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
		<?php } ?>
		
		<!-- END FEATURED IMAGE -->
		
		
		<!--BEGIN POST CONTENT -->
		
		<div id="post-content">
			
			<?php the_content(__('Read More &raquo;', 'gp_lang')); ?>
			
		</div>
		<div class="right">
		
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-537efa5854ef0739"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a></div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-537efa5854ef0739"></script>
<!-- AddThis Button END -->
		
		<!-- END POST CONTENT -->
		
		
		<!-- BEGIN POST NAV -->
		
		<?php wp_link_pages('before=<div class="clear"></div><div class="wp-pagenavi post-navi">&pagelink=<span>%</span>&after=</div><div class="clear"></div>'); ?>		

		<!-- END POST NAV -->


		<!-- BEGIN POST TAGS -->

		<?php if($gp_settings['meta_tags'] == "0") { ?><?php the_tags('<div class="post-meta post-tags"><span class="tag-icon">', ', ', '</span></div>'); ?><?php } ?>
		
		<!-- END POST TAGS -->
		
		
		<!-- BEGIN AUTHOR INFO PANEL -->
		
		<?php if($gp_settings['author_info'] == "0") { ?><?php echo do_shortcode('[author]'); ?><?php } ?>
		
		<!-- END AUTHOR INFO PANEL -->
		
		
		<!-- BEGIN RELATED ITEMS -->
		
		<?php if($gp_settings['related_items'] == "0") { ?>				
			<?php echo do_shortcode('[related_posts id="" cats="" images="true" image_width="'.$theme_post_related_image_width.'" image_height="'.$theme_post_related_image_height.'" image_wrap="false" cols="3" per_page="3" link="both" orderby="random" order="desc" offset="0" content_display="excerpt" excerpt_length="0" title="true" title_size="" meta="false" read_more="false" pagination="false" preload="false"]'); ?>			
		<?php } ?>	
		
		<!-- END RELATED ITEMS -->
						
		
		<!-- END CONTENT -->
		
		
		<!-- BEGIN COMMENTS -->
		
		<?php comments_template(); ?>
		
		<!-- END COMMENTS -->

	
	</div>
	

	<!-- END CONTENT -->
	
	
	
	

<?php endwhile; endif; ?>
</div>

</div>

</div>


<?php get_footer(); ?>