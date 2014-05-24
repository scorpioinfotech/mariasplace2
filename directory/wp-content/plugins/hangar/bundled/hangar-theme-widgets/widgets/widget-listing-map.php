<?php
/**
 * Actions and Filters
 *
 * Register any and all actions here. Nothing should actually be called
 * directly, the entire system will be based on these actions and hooks.
 */
 
/**
 * This is the class that you'll be working with. Duplicate this class as many times as you want. Make sure
 * to include an add_action call to each class, like the line above.
 *
 * @author tdp
 *
 */
class TDP_Listings_Map extends Empty_Widget_Abstract
{
	/**
	 * Widget settings
	 *
	 * Simply use the following field examples to create the WordPress Widget options that
	 * will display to administrators. These options can then be found in the $params
	 * variable within the widget method.
	 *
	 *
	 */
	protected $widget = array(
		// you can give it a name here, otherwise it will default
		// to the classes name. BTW, you should change the class
		// name each time you create a new widget. Just use find
		// and replace!
		'name' => '[TDP] - Listing Map',
 
		// this description will display within the administrative widgets area
		// when a user is deciding which widget to use.
		'description' => 'Use the following widget to display the current listing map. Note this widget works only into the sidebar of the single listing page.',
 
		// determines whether or not to use the sidebar _before and _after html
		'do_wrapper' => true,
 
		// determines whether or not to display the widgets title on the frontend
		'do_title'	=> true,
 
		// string : if you set a filename here, it will be loaded as the view
		// when using a file the following array will be given to the file :
		// array('widget'=>array(),'params'=>array(),'sidebar'=>array(),
		// alternatively, you can return an html string here that will be used
		'view' => false,
	
		// If you desire to change the size of the widget administrative options
		// area
		'width'	=> 350,
		'height' => 350,
	
		// Shortcode button row
		'buttonrow' => 4,
	
		// The image to use as a representation of your widget.
		// Whatever you place here will be used as the img src
		// so we have opted to use a basencoded image.
		'thumbnail' => '',
	
		/* The field options that you have available to you. Please
		 * contribute additional field options if you create any.
		 *
		 */
		'fields' => array(
			// You should always offer a widget title
			array(
				'name' => 'Title',
				'desc' => '',
				'id' => 'title',
				'type' => 'text',
				'default' => 'Listing Map'
			),
			
			
			
		)
	);
 
	/**
	 * Widget HTML
	 *
	 * If you want to have an all inclusive single widget file, you can do so by
	 * dumping your css styles with base_encoded images along with all of your
	 * html string, right into this method.
	 *
	 * @param array $widget
	 * @param array $params
	 * @param array $sidebar
	 */
	function html($widget = array(), $params = array(), $sidebar = array())
	{
		?>
		
		<?php 

			// Default Map Loader

			$set_marker = get_field('location');

			?>

			<script type="text/javascript">

				var mapDivWidget, mapWidget, infobox;

				jQuery(document).ready(function($) {

					mapDivWidget = jQuery("#single-map");
					mapDivWidget.gmap3({
						
						map: {

							options: {
								"address": "<?php echo $set_marker['address'];?>",
								"center": [<?php echo $set_marker['coordinates'];?>],
								"zoom": 18,
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

										$args = array( 'post_type' => 'listing', 'p' => get_the_ID() );

										$listing_marker_loop = new WP_Query( $args );

										while ( $listing_marker_loop->have_posts() ) : $listing_marker_loop->the_post(); 

										$address = get_field('location');

										global $post;
			 
										// load all 'categories' terms for the post
										$terms = get_the_terms($post->ID, 'listings_categories');
										 
										// we will use the first term to load ACF data from
										if( !empty($terms) )
										{
											$term = array_pop($terms);
										 
											$custom_marker = get_field('marker_type', 'listings_categories_' . $term->term_id );
										 
											// do something with $custom_field
										}

										?>

											{
													<?php if(get_field('coordinates_override')) { ?>
														latLng: [<?php echo get_field('coordinates_override');?> <?php if(get_field('multiple_marker_address','option')) { echo "+ (Math.random() -.5) / 1500"; } ?>],
													<?php } else { ?>
														latLng: [<?php echo $address['coordinates'];?> <?php if(get_field('multiple_marker_address','option')) { echo "+ (Math.random() -.5) / 1500"; } ?>],
													<?php } ?>
													options: {
														
														icon: "",
														shadow: "",
													},
													
												}
											,
										
									<?php endwhile; ?>
								
							],
							options:{
								draggable: false
							},
							
							
						}
						 		
					});

					<?php if(get_field('disable_poi','option') ) { ?>	

						mapWidget = mapDivWidget.gmap3("get");

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
						mapWidget.setOptions({ styles: styles });

					<?php } ?>


				});
			</script>

			<div id="single-map"></div>

		<?php 
	}
	
}