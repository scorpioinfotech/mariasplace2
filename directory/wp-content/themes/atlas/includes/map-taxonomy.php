<?php 

$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;



?>
<script type="text/javascript">

	var mapDiv, map, infobox;

	jQuery(document).ready(function($) {

		mapDiv = jQuery("#map");
		mapDiv.gmap3({
			
			map: {
				<?php if(get_field('disable_map_autofit','option')) { ?>
					latLng: [<?php the_field('custom_map_center','option');?>],
				<?php } ?>
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

							$args = array( 'post_type' => 'listing', 'posts_per_page' => 99999, 'tax_query' => array(
											array(
												'taxonomy' => $taxonomy,
												'field' => 'id',
												'terms' => $term_id
											)
										));

							$listing_marker_loop = new WP_Query( $args );

							while ( $listing_marker_loop->have_posts() ) : $listing_marker_loop->the_post(); 

							$address = get_field('location');

							global $post;

								if(is_tax('listings_location')) {

									// load all 'category' terms for the post
									$terms = get_the_terms($post->ID, 'listings_categories');
									 
									// we will use the first term to load ACF data from
									if( !empty($terms) )
									{
										$term = array_pop($terms);
									 	
									 	if(get_field("listing_is_featured")) {
											$custom_field = get_field('featured_marker', 'listings_categories_' . $term->term_id);
										} else {
											$custom_field = get_field('marker_type', 'listings_categories_' . $term->term_id );
									 	}
									 	
										$custom_marker = $custom_field;

										// do something with $custom_field
									} 

								} else {

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
									}<?php if ($listing_marker_loop->current_post +1 == $listing_marker_loop->post_count) { ?><?php } else {echo',';} ?>
							

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
			},

			<?php if(get_field('enable_geolocation','option')){ ?>	
			getgeoloc:{
			    callback : function(latLng){
			      if (latLng){
			        jQuery(this).gmap3({
			          marker:{ 
			            latLng:latLng
			          },
			          map:{
			            options:{
			              zoom: <?php if(get_field('geolocation_zoom','option') !== '') { echo get_field('geolocation_zoom','option'); } else { echo '10'; } ?>,
			              center: latLng
			            }
			          }
			        });
			      }
			    }
			  },
			<?php } ?>

		<?php if(get_field('enable_geolocation','option') || get_field('disable_map_autofit','option')) { ?>
			
			});
		
		<?php } else { ?>

			},"autofit");

		<?php } ?>

		

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