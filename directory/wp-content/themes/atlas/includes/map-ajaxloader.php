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
                	}
				}
			},marker: {
				values: [
						
					my_stuff

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