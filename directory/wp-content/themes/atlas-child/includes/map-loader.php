<script type="text/javascript">
	var mapDiv, map, infobox;
	jQuery(document).ready(function($) {
		mapDiv = jQuery("#map");
		mapDiv.gmap3({
			
			map: {
				<?php //if(get_field('disable_map_autofit','option')) { ?>
					latLng: [<?php echo $_SESSION['lat'].','. $_SESSION['long']; ?>],
				<?php //} ?>
				options: {
					//"center": [<?php echo $_SESSION['lat'].','. $_SESSION['long']; ?>],
					//"zoom": <?php if(get_field('adjust_zoom','option') !== '') { echo get_field('adjust_zoom','option'); } else { echo '18'; } ?>, 
					//"zoom": <?php echo $_SESSION['accuracy_radius']; ?>, 
					"zoom": <?php if($_SESSION['accuracy_radius'] !== '') { echo $_SESSION['accuracy_radius']; } else { echo '18'; } ?>, 
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
                	}
				}
			},marker: {
				values: [
						<?php $city = $_SESSION['city']; $args = array( 'post_type' => 'listing', 'meta_query' => array(array('key' => 'city', 'value' => $city, 'compare' => '=')), 'posts_per_page' => 100);
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
											shadow: ""
										},
										data: '<div class="marker-wrapper <?php if(get_field("listing_is_featured")) { echo "featured-listing";} ?> animated fadeInDown"><div class="marker-title"> <a href="<?php the_permalink();?>"><?php the_title(); ?></a> </div><div class="marker-content"> <?php get_template_part( "includes/popup", "content" );?> <?php get_template_part( "includes/popup", "image" );?> <div class="clearboth"></div> <div class="close"><span class="icon-cancel"></span></div></div><span class="icon-down-dir"></span></div>'
									}<?php if ($listing_marker_loop->current_post +1 == $listing_marker_loop->post_count) { ?><?php } else {echo',';} ?>

							<?php } ?>
							
						<?php endwhile; ?>
					
				],
				
				
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
				//$('#map').gmap('get','map').setOptions({'center':<?php echo $_SESSION['lat'].','. $_SESSION['long']; ?>});
		map = mapDiv.gmap3("get");
		mgr = new MarkerManager(map);

		function showMarkers() {
		    var bounds = map.getBounds();
		}

		google.maps.event.addListener(map, 'idle', showMarkers);
        
        infobox = new InfoBox({
        	pixelOffset: new google.maps.Size(-220, -310),
        	closeBoxURL: '',
        	pane: "floatPane",
        	enableEventPropagation: true
        });
        mapDiv.delegate('.infoBox .close','click',function () {
        	infobox.close();
        });
        mapDiv.delegate('.infoBox .close','touchstart',function () {
        	infobox.close();
        });

		<?php if(get_field('enable_search_on_map','option') && get_field('display_homepage_sidebar','option') && !is_page_template('template-homepage-listings-content.php')) { ?>

        var input = /** @type {HTMLInputElement} */ (document.getElementById('searchTextField'));
		var autocomplete = new google.maps.places.Autocomplete(input);

		autocomplete.bindTo('bounds', map);

		var input2 = /** @type {HTMLInputElement} */ (document.getElementById('searchTextField2'));
		var autocomplete2 = new google.maps.places.Autocomplete(input2);

		autocomplete2.bindTo('bounds', map);

		jQuery( "#searchTextField" ).change(function() {
			jQuery('#search-popup').magnificPopup('close');
		});

		var infowindow = new google.maps.InfoWindow();
		var marker = new google.maps.Marker({
		    map: map
		});

		google.maps.event.addListener(autocomplete, 'place_changed', function () {
		    infowindow.close();
		    marker.setVisible(false);
		    input.className = '';
		    var place = autocomplete.getPlace();
		    if (!place.geometry) {
		        // Inform the user that the place was not found and return.
		        input.className = 'notfound';
		        return;
		    }

		    // If the place has a geometry, then present it on a map.
		    if (place.geometry.viewport) {
		        map.fitBounds(place.geometry.viewport);
		         map.setZoom(<?php echo get_field('adjust_zoom','option'); ?>);
		    } else {
		        map.setCenter(place.geometry.location);
		        map.setZoom(<?php echo get_field('adjust_zoom','option'); ?>); // Why 17? Because it looks good.
		    }
		    marker.setIcon( /** @type {google.maps.Icon} */ ({
		        url: place.icon,
		        size: new google.maps.Size(71, 71),
		        origin: new google.maps.Point(0, 0),
		        anchor: new google.maps.Point(17, 34),
		        scaledSize: new google.maps.Size(35, 35)
		    }));
		    marker.setPosition(place.geometry.location);
		    marker.setVisible(true);

		    var address = '';
		    if (place.address_components) {
		        address = [
		            (place.address_components[0] && place.address_components[0].short_name || ''), (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
		        ].join(' ');
		    }

		    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
		    infowindow.open(map, marker);
		});

		google.maps.event.addListener(autocomplete2, 'place_changed', function () {
		    infowindow.close();
		    marker.setVisible(false);
		    input.className = '';
		    var place = autocomplete2.getPlace();
		    if (!place.geometry) {
		        // Inform the user that the place was not found and return.
		        input.className = 'notfound';
		        return;
		    }

		    // If the place has a geometry, then present it on a map.
		    if (place.geometry.viewport) {
		        map.fitBounds(place.geometry.viewport);
		         map.setZoom(<?php echo get_field('adjust_zoom','option'); ?>);
		    } else {
		        map.setCenter(place.geometry.location);
		        map.setZoom(<?php echo get_field('adjust_zoom','option'); ?>); // Why 17? Because it looks good.
		    }
		    marker.setIcon( /** @type {google.maps.Icon} */ ({
		        url: place.icon,
		        size: new google.maps.Size(71, 71),
		        origin: new google.maps.Point(0, 0),
		        anchor: new google.maps.Point(17, 34),
		        scaledSize: new google.maps.Size(35, 35)
		    }));
		    marker.setPosition(place.geometry.location);
		    marker.setVisible(true);

		    var address = '';
		    if (place.address_components) {
		        address = [
		            (place.address_components[0] && place.address_components[0].short_name || ''), (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
		        ].join(' ');
		    }

		    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
		    infowindow.open(map, marker);
		});

		<?php } ?>		

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