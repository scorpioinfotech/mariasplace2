<?php
/*
Template Name: Search Results Page
*/

get_header(); 

define('WPAS_DEBUG', false);

$args = tdp_search_fields();
$my_search = new WP_Advanced_Search($args);
$temp_query = $wp_query;
$wp_query = $my_search->query();


if(get_field('enable_faceted_search','option')) {
	
	/*
	Modify the existing search query to set the selected option
	*/

	//detect which category field has been filled
	if(isset($_GET['tax_listings_categories']) && $_GET['tax_listings_categories'] !== '') {
		//uses category slug
		$get_category_by = 'slug';
		$get_category = $_GET['tax_listings_categories'];
	} else {
		//uses category ID
		$get_category_by = 'term_id';
		$get_category = $_GET['main_cat'];
	}

	//detect which location field has been filled
	if(isset($_GET['tax_listings_location']) && $_GET['tax_listings_location'] !== '') {
		//uses category slug
		$get_location_by = 'slug';
		$get_location = $_GET['tax_listings_location'];
	} else {
		//uses category ID
		$get_location_by = 'term_id';
		$get_location = $_GET['main_loc'];
	}

	$taxquery = array(
	        
	        array(
	            'taxonomy' => 'listings_categories',
	            'field' => $get_category_by,
	            'terms' => $get_category,
	            'operator'=> 'IN'
	        ),
	        array(
	            'taxonomy' => 'listings_location',
	            'field' => $get_location_by,
	            'terms' => $get_location,
	            'operator'=> 'IN'
	        ),
	);

	$wp_query->set( 'tax_query', $taxquery );

}



/* Search Form Query Detection Finished Now We Display the Query
-------------------------------------------------------------- */
$wp_query->query($wp_query->query_vars);

if(get_field('taxonomy_layout','option') !== 'Fullwidth') { 

	$grid_set_column = 'one_third';
	$row_num = 3;

} else {

	$grid_set_column = 'one_fourth';
	$row_num = 4;

}

$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
?>
<section id="header-map" class="slidingDiv <?php if(!have_posts()) {echo 'nothing-found';} ?>">

	<a href="#search-popup" id="open-search"><span class="icon-search"></span></a>

	<div id="map"></div>

</section>
<script type="text/javascript">

	var mapDiv, map, infobox;

	jQuery(document).ready(function($) {

		mapDiv = jQuery("#map");
		mapDiv.gmap3({
			
			map: {
				options: {
					"zoom": <?php if(get_field('adjust_zoom','option') !== '') { echo get_field('adjust_zoom','option'); } else { echo '18'; } ?>,
					"draggable": <?php if(get_field('is_draggable','option')) { echo "true"; } else { echo 'false'; } ?>,
					"mapTypeControl":<?php if(get_field('map_type_control','option')) { echo "true"; } else { echo 'false'; } ?>,
					"mapTypeId": google.maps.MapTypeId.<?php echo the_field('map_type_id','option');?>,
					"scrollwheel": <?php if(get_field('scrollwheel_control','option')) { echo "true"; } else { echo 'false'; } ?>,
					"panControl": true,
					"rotateControl": false,
					"scaleControl": true,
					"streetViewControl": <?php if(get_field('street_view_control','option')) { echo "true"; } else { echo 'false'; } ?>,
					"zoomControl": <?php if(get_field('zoom_control','option')) { echo "true"; } else { echo 'false'; } ?>,
					"keyboardShortcuts": <?php if(get_field('keyboard_shortcuts','option')) { echo "true"; } else { echo 'false'; } ?>,
					"zoomControlOptions": {
                    	style: google.maps.ZoomControlStyle.SMALL,
                	},

				}
			}
			,marker: {
				values: [

						<?php 

							while ( $wp_query->have_posts() ) : $wp_query->the_post(); 

							$address = get_field('location');

							global $post;
							// load all 'categories' terms for the post
							$terms = get_the_terms($post->ID, 'listings_categories');		 
							// we will use the first term to load ACF data from
							if( !empty($terms) )
							{
								$term = array_pop($terms);
								// Checking if listing is featured, if so load another marker image.
								if(get_field("listing_is_featured")) {
									$custom_marker = get_field('featured_marker', 'listings_categories_' . $term->term_id );
								} else {
									$custom_marker = get_field('marker_type', 'listings_categories_' . $term->term_id );
							 	}
							}

							if(!empty($address['coordinates'])) {

							?>

								{
										latLng: [<?php echo $address['coordinates'];?>],
										options: {
											<?php if($custom_marker !=='') { ?>
											icon: "<?php echo $custom_marker; ?>",
											<?php } else { ?>
											icon: "",
											<?php } ?>
											shadow: "",
										},
										data: '<div class="marker-wrapper <?php if(get_field("listing_is_featured")) { echo "featured-listing";} ?> animated fadeInDown"><div class="marker-title"> <a href="<?php the_permalink();?>"><?php the_title(); ?></a> </div><div class="marker-content"> <?php get_template_part( "includes/popup", "content" );?> <?php get_template_part( "includes/popup", "image" );?> <div class="clearboth"></div> <div class="close"><span class="icon-cancel"></span></div></div><span class="icon-down-dir"></span></div>'
									}<?php if ($wp_query->current_post +1 == $wp_query->post_count) { ?><?php } else {echo',';} ?>

							<?php } ?>
							
						<?php endwhile;  rewind_posts(); //wp_reset_query(); $wp_query = $my_search->query(); ?>
					
				],
				options:{
					draggable: false
				},
				
				cluster:{
              		radius: 20,
					// This style will be used for clusters with more than 0 markers
					0: {
						content: "<div class='cluster cluster-1 dp-button medium'>CLUSTER_COUNT</div>",
						width: 90,
						height: 80
					},
					// This style will be used for clusters with more than 20 markers
					20: {
						content: "<div class='cluster cluster-2 dp-button medium'>CLUSTER_COUNT</div>",
						width: 90,
						height: 80
					},
					// This style will be used for clusters with more than 50 markers
					50: {
						content: "<div class='cluster cluster-3 dp-button medium'>CLUSTER_COUNT</div>",
						width: 90,
						height: 80
					},
					events: {
						click: function(cluster) {
							map.panTo(cluster.main.getPosition());
							map.setZoom(map.getZoom() + 2);
						}
					}
              	},
				events: {
					click: function(marker, event, context){
						map.panTo(marker.getPosition());

						infobox.setContent(context.data);
						infobox.open(map,marker);

					}
				}
			},

			},"autofit");


		

		map = mapDiv.gmap3("get");
        infobox = new InfoBox({
        	pixelOffset: new google.maps.Size(-220, -310),
        	closeBoxURL: '',
        	enableEventPropagation: true
        });
        mapDiv.delegate('.infoBox .close','click',function () {
        	infobox.close();
        });

        <?php if(get_field('disable_poi','option') ) { ?>

        var styles = [
		  {
			featureType: 'poi',
			elementType: 'labels',
			stylers: [
				{ visibility: 'off' }
			]
			},{
		  	draggable: false }
		];
		map.setOptions({ styles: styles });

		<?php } ?>

	});
</script>
<?php if(get_field('display_breadcrumb','option')) { ?>
<section id="breadcrumb">

	<div class="wrapper">
		
		<div class="one_half">
	
			<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
				<span class="icon-location"></span>
				<span typeof="v:Breadcrumb">
					<a rel="v:url" property="v:title" href="<?php echo home_url();?>"><?php _e('Home','atlas');?></a>
				</span> » 
				<span class="current"><?php _e('Search Results','atlas')?></span></div>
	
		</div>

		<div class="one_half last">
		</div>

		<div class="clearboth"></div>

	</div>

</section>
<?php } ?>

<section id="listing-brief">

	<div class="wrapper">

		<div class="two_third">

			<div class="animated fadeInDown">

				<h1>
					<?php echo __('Displaying results ','atlas') . $my_search->results_range() . __('of ','atlas') . $wp_query->found_posts; ?>
					<?php if(isset($_GET['search_query']) && $_GET['search_query'] !== '') { _e('For: ','atlas'); echo $_GET['search_query']; } ?>
				</h1>

			</div>

		</div>

		<div class="one_third last" id="right-counter">

		</div>

		<div class="clearboth"></div>

	</div><!-- end wrapper -->

</section> <!-- end listing brief -->

<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<div id="content-container" class="">

			 <?php 
				
				if ( have_posts() ): 

					$clear_row = '';
					$clear_row_end = '';

				    while ( have_posts() ): the_post(); $clear_row++; $clear_row_end++; { ?>

				  	 <?php if(get_field('enable_grid_in_search_results','option')) { ?>

				  		<div class="grid-column <?php echo $grid_set_column; ?> <?php if($clear_row == $row_num ) { echo " last"; $clear_row = 0; } ?>">
							<?php get_template_part( 'content', 'single-result-grid' ); ?>
						</div>

						<?php if($clear_row_end == $row_num) { echo '<div class="clear"></div>'; $clear_row_end = 0; } ?>

					<?php } else { ?>

						<?php get_template_part( 'content', 'single-result' ); ?>

					<?php } ?>

				   <?php } endwhile;

				    $my_search->pagination(array('prev_text' => '«','next_text' => '»'));

				else : ?>

					<div id="content-container" class="error-container">

						<h1 class="entry-title">

							<span class="error-title"><i class="icon-attention-circled"></i></span>

							<?php _e( 'Oops! It looks like nothing was found.', 'atlas' ); ?>

						</h1>


						<p><?php _e( 'You might want to try with different search terms. ', 'atlas' ); ?></p>

						<a href="<?php echo home_url();?>" class="dp-button large"><?php _e('Back To The Homepage','atlas');?></a>

					</div>

				<?php endif;
				
				wp_reset_query();
				$wp_query = $temp_query;

            ?>

		</div>

		<div class="clearboth"></div>

	</div>

</section>

<?php get_template_part( 'includes/search', 'listings' );?>

<?php get_footer(); ?>