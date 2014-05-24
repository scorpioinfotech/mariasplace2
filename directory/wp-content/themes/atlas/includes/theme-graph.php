<?php 
global $current_user;
	/* 
	 * Request listings from user 
	 */
	$args = array(
	
		'post_type' => 'listing',
		'posts_per_page' => -1,
		'author' => $current_user->ID,
		'post_status' => array('publish'),
	
	);
	
	$user_listings = new WP_Query($args);
	
	if($user_listings->have_posts()) :

?>
	
<div id="user-views">

<h3><?php _e('Recent Page Views:', 'atlas'); ?></h3>

	<script type="text/javascript">

	jQuery(function() {

		var data = [ <?php while($user_listings->have_posts()) { $user_listings->the_post(); ?> ["<?php the_title();?>", <?php echo get_post_meta($post->ID,'post_views_count',true) ?>], <?php } ?> ];

		jQuery.plot("#placeholder", [ data ], {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			}
		});

	});

	</script>

	<div id="placeholder"></div>

</div>

<?php endif; ?>


