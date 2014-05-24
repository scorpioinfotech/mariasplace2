<?php

//////////////////////////////////////// Activity Stream ////////////////////////////////////////

function gp_activity($atts, $content = null) {
	extract(shortcode_atts(array(
        'per_page' => '5',
        'comments' => 'threaded',
        'order' => 'desc',
        'pagination' => 'true'
    ), $atts));
	
	ob_start(); ?>
	
	<?php if(function_exists('bp_is_active')) { ?>
			
		<div class="bp-wrapper gp-activity-stream activity post-wrapper<?php if($comments == "none") { ?> hide-activity-comments<?php } ?>">
	
			<?php 
			
			require_once(BP_PLUGIN_DIR . '/bp-themes/bp-default/_inc/ajax.php');
			
			do_action( 'bp_before_activity_loop' ); ?>
			
			<?php if ( bp_has_activities("per_page=$per_page&display_comments=$comments&sort=$order")  ) : ?>
			
				<?php if ( empty( $_POST['page'] ) ) : ?>
			
					<ul id="activity-stream" class="activity-list item-list test">
			
				<?php endif; ?>
			
				<?php while ( bp_activities() ) : bp_the_activity(); ?>
			
					<?php include( TEMPLATEPATH.'/activity/entry.php' ); ?>
			
				<?php endwhile; ?>
				
				<?php if($pagination == 'true') : ?>
				
					<div class="wp-pagenavi cat-navi">
						<div class="pages"><?php bp_activity_pagination_count(); ?></div>
						<div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
					</div>
			
				<?php endif; ?>
			
				<?php if ( empty( $_POST['page'] ) ) : ?>
			
					</ul>
			
				<?php endif; ?>
			
			<?php else : ?>
			
				<div id="message" class="info">
					<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'buddypress' ); ?></p>
				</div>
			
			<?php endif; ?>
			
			<?php do_action( 'bp_after_activity_loop' ); ?>
			
			<form action="" name="activity-loop-form" id="activity-loop-form" method="post">
			
				<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>
			
			</form>
	
		</div>

	<?php } ?>
			
<?php 

	$output_string = ob_get_contents();
	ob_end_clean(); 
	
	return $output_string;

}

add_shortcode("activity", "gp_activity");

?>