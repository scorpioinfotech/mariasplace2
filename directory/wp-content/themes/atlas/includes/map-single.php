<?php 
$queried_object = get_queried_object(); 
$post_id = $queried_object->ID;
$taxonomy = $queried_object->taxonomy;
$set_marker = get_field('location');
?>
<script type="text/javascript">

	var mapDiv, map, infobox;

	jQuery(document).ready(function($) {

		mapDiv = jQuery("#map");
		mapDiv.gmap3({
			
			map: {

				options: {
					"address": "<?php echo $set_marker['address'];?>",
					"center": [<?php echo $set_marker['coordinates'];?>],
					"zoom": 15,
					"draggable": <?php if(get_field('is_draggable','option')) { echo "true"; } else { echo 'false'; } ?>,
					"mapTypeControl":<?php if(get_field('map_type_control','option')) { echo "true"; } else { echo 'false'; } ?>,
					"mapTypeId": google.maps.MapTypeId.<?php echo the_field('map_type_id','option');?>,
					"scrollwheel": <?php if(get_field('scrollwheel_control','option')) { echo "true"; } else { echo 'false'; } ?>,
					"panControl": true,
					"rotateControl": false,
					"scaleControl": true,
					"streetViewControl": <?php if(get_field('display_google_streetview_below_the_header','option')) { echo "true"; } else { echo 'false'; } ?>,
					"zoomControl": <?php if(get_field('zoom_control','option')) { echo "true"; } else { echo 'false'; } ?>,
					"keyboardShortcuts": <?php if(get_field('keyboard_shortcuts','option')) { echo "true"; } else { echo 'false'; } ?>,
					"zoomControlOptions": {
                    	<?php if(get_field('add_rtl_support','option')) { ?>
                    		style: google.maps.ZoomControlStyle.DEFAULT
                    	<?php } else { ?>
                    		style: google.maps.ZoomControlStyle.SMALL
                    	<?php } ?>
                	},

				}
			}
			,marker: {
				values: [

						<?php 

							$args = array( 'post_type' => 'listing', 'p' => $post_id );

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
								// Checking if listing is featured, if so load another marker image.
								if(get_field("listing_is_featured")) {
									$custom_marker = get_field('featured_marker', 'listings_categories_' . $term->term_id );
								} else {
									$custom_marker = get_field('marker_type', 'listings_categories_' . $term->term_id );
							 	}
							}

							if(!empty($address['coordinates']) || get_field('coordinates_override')) {

							?>
								{	

									<?php if(get_field('coordinates_override')) { ?>
										latLng: [<?php echo get_field('coordinates_override');?> <?php if(get_field('multiple_marker_address','option')) { echo "+ (Math.random() -.5) / 1500"; } ?>],
									<?php } else { ?>
										latLng: [<?php echo $address['coordinates'];?> <?php if(get_field('multiple_marker_address','option')) { echo "+ (Math.random() -.5) / 1500"; } ?>],
									<?php } ?>
										options: {
											<?php if($custom_marker !=='') { ?>
											icon: "<?php echo $custom_marker; ?>",
											<?php } else { ?>
											icon: "",
											<?php } ?>
											shadow: "",
										},
										data: '<div class="marker-wrapper <?php if(get_field("listing_is_featured")) { echo "featured-listing";} ?> animated fadeInDown"><div class="marker-title"> <a href="<?php the_permalink();?>"><?php the_title(); ?></a> </div><div class="marker-content"> <?php get_template_part( "includes/popup", "content" );?> <?php get_template_part( "includes/popup", "image" );?> <div class="clearboth"></div> <div class="close"><span class="icon-cancel"></span></div></div><span class="icon-down-dir"></span></div>'
									}
							
							<?php } ?>
							
						<?php endwhile; ?>
					
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
			}
			 		
		});

		map = mapDiv.gmap3("get");
        infobox = new InfoBox({
        	pixelOffset: new google.maps.Size(-220, -310),
        	closeBoxURL: '',
        	enableEventPropagation: true
        });
        mapDiv.delegate('.infoBox .close','click',function () {
        	infobox.close();
        });

        jQuery(".slidingDiv").hide();
			
		jQuery(".show_hide").show();
					 
		jQuery('.show_hide').click(function(){

			lastCenter=map.getCenter();

			jQuery(".slidingDiv").slideToggle();

			google.maps.event.trigger(map, 'resize');

			map.setCenter(lastCenter);
					        	
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