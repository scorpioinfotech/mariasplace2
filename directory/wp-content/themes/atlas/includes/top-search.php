<section id="listing-brief">

	<div class="wrapper">

		<div class="two_third">

			<h1><?php if($search_params !="") { echo __('Searching: ', 'atlas'); echo $search_params; } else { echo __('Searching all listings', 'atlas'); } ?> - <?php $total_results = $wp_query->found_posts; echo $total_results; ?> <?php if($total_results != '1') { ?><?php _e('listings found', 'atlas'); ?><?php } else { ?><?php _e('listing found', 'atlas'); ?><?php } ?></h1>

		</div>

		<div class="clearboth"></div>

	</div><!-- end wrapper -->


</section> <!-- end listing brief -->