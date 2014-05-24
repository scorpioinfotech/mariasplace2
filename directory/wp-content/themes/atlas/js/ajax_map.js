var gmarkers = [];
var vertical_pan = -190;
var vertical_off = 0;
var pins = '';
var markers = '';
var width_browser = null;
var infobox_width = null;
var infoBox = null;
var map = null;

var offset1 = -220;
var offset2 = -310;

function initialize() {
    "use strict";

    /* ------------------------------------------------------------------------ */
    /* Prepare map and get settings */
    /* ------------------------------------------------------------------------ */

    var mapOptions = {
        flat: false,
        noClear: false,
        zoom: parseInt(tdp_ajax_map_vars.page_custom_zoom),
        scrollwheel: tdp_ajax_map_vars.scrollwheel,
        draggable: tdp_ajax_map_vars.draggable,
        center: new google.maps.LatLng(tdp_ajax_map_vars.general_latitude, tdp_ajax_map_vars.general_longitude),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: tdp_ajax_map_vars.streetViewControl,
        keyboardShortcuts: tdp_ajax_map_vars.keyboardShortcuts,
        zoomControl: tdp_ajax_map_vars.zoomControl,
        styles: tdp_ajax_map_vars.snazzy_style,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
        }
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    google.maps.visualRefresh = true;

    //hide poi
    if(tdp_ajax_map_vars.disable_poi == 'yes') {

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

    }

    //hide ajax loader when map is ready
    google.maps.event.addListener(map, 'tilesloaded', function () {
        jQuery('#ajax-map-loader').remove();
        jQuery('.toggle-activator').show();
        jQuery('#open-search').show();
    });


    /* ------------------------------------------------------------------------ */
    /* Parse All The Pins */
    /* ------------------------------------------------------------------------ */

    pins = tdp_ajax_map_vars.markers;
    markers = jQuery.parseJSON(pins);
    setMarkers(map, markers);

    map_cluster();

    /* ------------------------------------------------------------------------ */
    /* Add Geolocation */
    /* ------------------------------------------------------------------------ */

    if (navigator.geolocation && tdp_ajax_map_vars.geolocation == 'yes') {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = new google.maps.LatLng(position.coords.latitude,
                position.coords.longitude);

            var infowindow = new google.maps.InfoWindow({
                map: map,
                position: pos,
                content: tdp_ajax_map_vars.geolocation_text
            });

            var marker = new google.maps.Marker({
                  position: pos,
                  map: map,
                  icon: tdp_ajax_map_vars.geolocation_pin,
                  title: tdp_ajax_map_vars.geolocation_text
            });

            var circle = new google.maps.Circle({
                center: pos,
                radius: position.coords.accuracy,
                map: map,
                fillColor: '#0000FF',
                fillOpacity: 0.2,
                strokeColor: '#0000FF',
                strokeOpacity: 1.0
            });
            
            map.fitBounds(circle.getBounds());

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });

            infowindow.open(map,marker);

            map.setCenter(pos);
            map.setZoom(parseInt(tdp_ajax_map_vars.geolocation_zoom));

        }, function () {
            handleNoGeolocation(true);
        });
    } 

    if(tdp_ajax_map_vars.by_address === 'yes') {

        var input = /** @type {HTMLInputElement} */ (document.getElementById('searchTextField'));
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var input2 = /** @type {HTMLInputElement} */ (document.getElementById('searchTextField2'));
        var autocomplete2 = new google.maps.places.Autocomplete(input2);

        autocomplete2.bindTo('bounds', map);

        jQuery("#searchTextField").change(function () {
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
                map.setZoom(parseInt(tdp_ajax_map_vars.page_custom_zoom));
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(parseInt(tdp_ajax_map_vars.page_custom_zoom)); // Why 17? Because it looks good.
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
                map.setZoom(parseInt(tdp_ajax_map_vars.page_custom_zoom));
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(parseInt(tdp_ajax_map_vars.page_custom_zoom)); // Why 17? Because it looks good.
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


    }

}

/* ------------------------------------------------------------------------ */
/* Function To Handle Geolocation */
/* ------------------------------------------------------------------------ */

function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Error: The Geolocation service failed.';
    } else {
        var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
        map: map,
        position: new google.maps.LatLng(tdp_ajax_map_vars.general_latitude, tdp_ajax_map_vars.general_longitude),
        content: content
    };

    var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}

////////////////////////////////////////////////////////////////////
/// set markers function
//////////////////////////////////////////////////////////////////////


function setMarkers(map, locations) {
    "use strict";

    var boxText = document.createElement("div");
    width_browser = jQuery(window).width();
    infobox_width = 700;
    vertical_pan = -215;
    if (width_browser < 900) {
        infobox_width = 500;
    }
    if (width_browser < 600) {
        infobox_width = 400;
    }
    if (width_browser < 400) {
        infobox_width = 200;
    }

    var myOptions = {
        content: boxText,
        boxClass: "mybox",
        zIndex: null,
        closeBoxURL: "",
        pixelOffset: new google.maps.Size(offset1, offset2),
        pane: "floatPane",
        enableEventPropagation: true
    };
    infoBox = new InfoBox(myOptions);


    for (var i = 0; i < locations.length; i++) {
        var item = locations[i];
        var myLatLng = new google.maps.LatLng(item[1], item[2]);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: item[0],
            link: item[3],
            address: item[5],
            phone: item[6],
            mobile: item[7],
            website: item[8],
            image: item[9],
            readmore: item[10],
            icon: item[11],
            infoWindowIndex: i
        });

        gmarkers.push(marker);

        google.maps.event.addListener(marker, 'click', function (event) {

            var ua = navigator.userAgent;
            var event = (ua.match(/iPad/i)) ? "touchstart" : "click";

            // prevent ghost clicks on ipad
            infoBox.setContent('<div class="marker-wrapper animated fadeInDown"><div class="marker-title"> <a href="'+ this.link +'">'+ this.title +'</a> </div><div class="marker-content"><div class="two_third popup-content"><ul>'+ this.address +''+ this.phone +''+ this.mobile +''+ this.website +'</ul></div>'+ this.image +''+ this.readmore +'<div class="clearboth"></div> <div class="close" onClick=\'javascript:infoBox.close();\'><span class="icon-cancel"></span></div></div><span class="icon-down-dir"></span></div>');

            infoBox.open(map, this);
            map.setCenter(this.position);
            map.panTo(this.position);


        }); // end click even
    } //end for

} // end setMarkers

function stopPropagation(myEvent) {
    if (!myEvent) {
        myEvent = window.event;
    }
    myEvent.cancelBubble = true;
    if (myEvent.stopPropagation) {
        myEvent.stopPropagation();
    }
}

function map_cluster() {

    if(tdp_ajax_map_vars.enable_cluster == 'yes') {

        var clusterStyles = [{
            url: tdp_ajax_map_vars.cluster_image,
            height: 56,
            width: 56,
            textSize: 15,

        }];
        var mcOptions = {
            gridSize: 50,
            styles: clusterStyles
        };
        var mc = new MarkerClusterer(map, gmarkers, mcOptions);
        
    }
}

google.maps.event.addDomListener(window, 'load', initialize);