<?php
// Listing Driving Direction 
// Added in update 1.1

$list_loc_drive = get_field('location');

?>

<div class="tab-lister">

				<i class="icon-direction"></i>

					<?php echo do_shortcode( '[divider title="'.__('Get Directions','atlas').'" style="right-stripes" length="long" alignment="center" contenttype="text" heading="h4" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' ); ?>

					<script type="text/javascript">
						function displayMap() {
					          document.getElementById('map_canvas').style.display="block";
					           initialize();
					     }

					    var directionDisplay;
						var directionsService = new google.maps.DirectionsService();
						function initialize() {

						<?php if(get_field('coordinates_override')) { ?>
							var latlng = new google.maps.LatLng(<?php echo get_field('coordinates_override');?>);
						<?php } else { ?>
							var latlng = new google.maps.LatLng(<?php echo $list_loc_drive['coordinates']; ?>);
						<?php } ?>
						  // set direction render options
						  var rendererOptions = { draggable: true };
						  directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
						  var myOptions = {
						    zoom: 14,
						    center: latlng,
						    mapTypeId: google.maps.MapTypeId.ROADMAP,
						    mapTypeControl: false
						  };
						  // add the map to the map placeholder
						  var map2 = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
						  directionsDisplay.setMap(map2);
						  directionsDisplay.setPanel(document.getElementById("directionsPanel"));
						  // Add a marker to the map for the end-point of the directions.
						  var marker = new google.maps.Marker({
						    position: latlng, 
						    map: map2, 
						    title:"<?php the_title();?>"
						  }); 
    					 
						}
						function calcRoute() {
						  // get the travelmode, startpoint and via point from the form   
						  var travelMode = $('input[name="travelMode"]:checked').val();
						  var start = $("#routeStart").val();
						  var via = $("#routeVia").val();
						  
						  if (travelMode == 'TRANSIT') {
						    via = ''; // if the travel mode is transit, don't use the via waypoint because that will not work
						  }
						  var end = "<?php echo $list_loc_drive['coordinates']; ?>"; // endpoint is a geolocation
						  var waypoints = []; // init an empty waypoints array
						  if (via != '') {
						    // if waypoints (via) are set, add them to the waypoints array
						    waypoints.push({
						      location: via,
						      stopover: true
						    });
						  }
						  var request = {
						    origin: start,
						    destination: end,
						    waypoints: waypoints,
						    unitSystem: google.maps.UnitSystem.IMPERIAL,
						    travelMode: google.maps.DirectionsTravelMode[travelMode]
						  };
						  directionsService.route(request, function(response, status) {
						    if (status == google.maps.DirectionsStatus.OK) {
						      $('#directionsPanel').empty(); // clear the directions panel before adding new directions
						      directionsDisplay.setDirections(response);
						    } else {
						      // alert an error message when the route could nog be calculated.
						      if (status == 'ZERO_RESULTS') {
						        alert('No route could be found between the origin and destination.');
						      } else if (status == 'UNKNOWN_ERROR') {
						        alert('A directions request could not be processed due to a server error. The request may succeed if you try again.');
						      } else if (status == 'REQUEST_DENIED') {
						        alert('This webpage is not allowed to use the directions service.');
						      } else if (status == 'OVER_QUERY_LIMIT') {
						        alert('The webpage has gone over the requests limit in too short a period of time.');
						      } else if (status == 'NOT_FOUND') {
						        alert('At least one of the origin, destination, or waypoints could not be geocoded.');
						      } else if (status == 'INVALID_REQUEST') {
						        alert('The DirectionsRequest provided was invalid.');         
						      } else {
						        alert("There was an unknown error in your request. Requeststatus: nn"+status);
						      }
						    }
						  });
						}

						//google.maps.event.addDomListener(window, 'load', initialize);
					</script>

					 <div id="map_canvas"></div>    
					 
					 	<form action="" onSubmit="calcRoute();return false;" id="routeForm">

					 		<label><?php _e('From','atlas');?></label>
					 		<input type="text" id="routeStart" value="">

					 		<label><?php _e('Via (optional)','atlas');?></label>
					 		<input type="text" id="routeVia" value="">
					    
					     	
					     	<div class="label-float">
						        <label><?php _e('Travel Mode','atlas');?></label>
						        <label><input type="radio" name="travelMode" value="DRIVING" checked /> <?php _e('Driving','atlas');?></label>
						        <label><input type="radio" name="travelMode" value="BICYCLING" /> <?php _e('Bicycling','atlas');?></label>
						        <label><input type="radio" name="travelMode" value="TRANSIT" /> <?php _e('Public Transport','atlas');?></label>
						        <label><input type="radio" name="travelMode" value="WALKING" /> <?php _e('Walking','atlas');?></label>
					    	</div>

					        <div class="clear"></div>

					    	<input type="submit" value="<?php _e('Get Directions','atlas');?>">

					  </form>

					  <div id="directionsPanel"></div>
			</div>