<?php
/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/
function hangar_accordion($atts, $content=null, $code) {

	extract(shortcode_atts(array(
		'open' => '1'
	), $atts));

	if (!preg_match_all("/(.?)\[(accordion-item)\b(.*?)(?:(\/))?\](?:(.+?)\[\/accordion-item\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} 
	else {
		$output = '';
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
						
			$output .= '<div class="accordion-title"><a href="#">' . $matches[3][$i]['title'] . '</a></div><div class="accordion-inner">' . do_shortcode(trim($matches[5][$i])) .'</div>';
		}
		return '<div class="accordion" rel="'.$open.'">' . $output . '</div>';
		
	}
	
}

/*-----------------------------------------------------------------------------------*/
/*	Alert
/*-----------------------------------------------------------------------------------*/
function hangar_alert( $atts, $content = null) {

extract( shortcode_atts( array(
      'type' 	=> 'warning',
      'close'	=> 'true'
      ), $atts ) );
      
      if($close == 'false') {
		  $var1 = '';
	  }
	  else{
		  $var1 = '<span class="close" href="#"><i class="icon-cancel"></i></span>';
	  }
      
      return '<div class="alert-message ' . $type . '">' . do_shortcode($content) . '' . $var1 . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Br-Tag
/*-----------------------------------------------------------------------------------*/
function hangar_br() {
   return '<br />';
}

/*-----------------------------------------------------------------------------------*/
/* Buttons 
/*-----------------------------------------------------------------------------------*/
function hangar_buttons( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
        'size'    	=> 'medium',
		'target'    => '_self',
		'lightbox'  => 'false', 
		'color'     => 'white',
		'icon'		=> ''
    ), $atts));
    
    if($lightbox == 'true') {
    	$return = "prettyPhoto ";
    }
    else{
    	$return = " ";
    }
    if($icon == '') {
    	$return2 = "";
    }
    else{
    	$return2 = "<i class='icon-".$icon."'></i>";
    }

	$out = "<a href=\"" .$link. "\" target=\"" .$target. "\" class=\"".$return."button ".$color." ".$size."\" rel=\"slides[buttonlightbox]\">". $return2 . "". do_shortcode($content). "</a>";
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/* Callouts & Teaser 
/*-----------------------------------------------------------------------------------*/

function hangar_teaser( $atts, $content = null) {
extract( shortcode_atts( array(
      'img' => '',
      'url' => ''
      ), $atts ) );
      
      if($url == '') {
    	$return2 = "";
    	$return3 = "";
      } else{
    	$return2 = "<a href='".$url."'>";
    	$return3 = "</a>";
      }
      
      if($img == '') {
    	$return = "";
      } else{
    	$return = "<div class='teaser-img'>".$return2."<img src='".$img."' />".$return3."</div>";
      }
      
      return '<div class="teaser">' .$return. '' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/

function hangar_teaserbox( $atts, $content = null) {
extract( shortcode_atts( array(
      'title' => '',
      'button' => '',
      'buttonsize' => 'normal',
      'buttoncolor' => 'alternative-1',
      'link' => '',
      'target'  => '_self'
      ), $atts ) );
      return '<div class="teaserbox"><div class="border"><h2 class="highlight">' .$title. '</h2>' . do_shortcode($content) . '<br /><a class="button ' .$buttonsize. ' ' .$buttoncolor. '" href="' .$link. '" target="' .$target. '">' .$button. '</a></div></div>';
}

/*-----------------------------------------------------------------------------------*/

function hangar_callout( $atts, $content = null) {
extract( shortcode_atts( array(
      'title' => '',
      'button' => '',
      'buttonsize' => 'normal',
      'buttoncolor' => 'alternative-1',
      'link' => '',
      'target'  => '_self',
      'buttonmargin' => '0px'
      ), $atts ) );
      return '<div class="callout"><div class="border clearfix"><div class="callout-content">
      				<h2 class="highlight">' .$title. '</h2>' . do_shortcode($content) . '
      			</div><div class="callout-button" style="margin:' .$buttonmargin. ';">
      				<a class="button ' .$buttonsize. ' ' .$buttoncolor. '" href="' .$link. '" target="' .$target. '">' .$button. '</a>
      			</div><div class="clear"></div></div></div>';
}

function hangar_box( $atts, $content = null) {
extract( shortcode_atts( array(
      'style' => '1'
      ), $atts ) );
      return '<div class="description clearfix style-' .$style. '">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Google Font
/*-----------------------------------------------------------------------------------*/

function hangar_googlefont( $atts, $content = null) {
extract( shortcode_atts( array(
      	'font' => 'Swanky and Moo Moo',
      	'size' => '42px',
      	'margin' => '0px'
      ), $atts ) );
      
      $google = preg_replace("/ /","+",$font);
      
      return '<link href="http://fonts.googleapis.com/css?family='.$google.'&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese" rel="stylesheet" type="text/css">
      			<div class="googlefont" style="font-family:\'' .$font. '\', serif !important; font-size:' .$size. ' !important; margin: ' .$margin. ' !important;">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	HR Dividers
/*-----------------------------------------------------------------------------------*/
function hangar_hr( $atts, $content = null) {
extract( shortcode_atts( array(
      'style' => '1',
      'margin' => ''
      ), $atts ) );
      
    if($margin == '') {
    	$return = "";
    } else{
    	$return = "style='margin:".$margin." !important;'";
    }
      
    return '<div class="hr hr' .$style. '" ' .$return. '></div>';  
}


/*-----------------------------------------------------------------------------------*/
/*	Tagline
/*-----------------------------------------------------------------------------------*/
function hangar_tagline( $atts, $content = null) {
extract( shortcode_atts( array(
      'style' => '1',
      'margin' => ''
      ), $atts ) );
      
    return '<div class="tagline">' . do_shortcode($content) . '</div>';  
}

/*-----------------------------------------------------------------------------------*/
/*	Gap Dividers
/*-----------------------------------------------------------------------------------*/

function hangar_gap( $atts, $content = null) {

extract( shortcode_atts( array(
      'height' 	=> '10'
      ), $atts ) );
      
      if($height == '') {
		  $return = '';
	  }
	  else{
		  $return = 'style="height: '.$height.'px;"';
	  }
      
      return '<div class="gap" ' . $return . '></div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Clear-Tag
/*-----------------------------------------------------------------------------------*/
function hangar_clear() {  
    return '<div class="clear"></div>';  
}

/*-----------------------------------------------------------------------------------*/
/*	Columns
/*-----------------------------------------------------------------------------------*/
function hangar_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}

function hangar_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}

function hangar_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}

function hangar_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}

function hangar_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}

function hangar_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}

function hangar_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}

function hangar_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}

function hangar_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}

function hangar_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}

function hangar_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function hangar_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}

function hangar_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

/*-----------------------------------------------------------------------------------*/
/* Dropcap */
/*-----------------------------------------------------------------------------------*/
function hangar_dropcap($atts, $content = null) {
    extract(shortcode_atts(array(
        'style'      => ''
    ), $atts));
    
    if($style == '') {
    	$return = "";
    }
    else{
    	$return = "dropcap-".$style;
    }
    
	$out = "<span class='dropcap ". $return ."'>" .$content. "</span>";
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/* Media */
/*-----------------------------------------------------------------------------------*/

function hangar_video($atts) {
	extract(shortcode_atts(array(
		'type' 	=> '',
		'id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
		'autoplay' 	=> ''
	), $atts));
	
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = 315;
		$width = 560;
	}
	
	$autoplay = ($autoplay == 'yes' ? '1' : false);
		
	if($type == "vimeo") $return = "<div class='video-embed'><iframe src='http://player.vimeo.com/video/$id?autoplay=$autoplay&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";
	
	else if($type == "youtube") $return = "<div class='video-embed'><iframe src='http://www.youtube.com/embed/$id?HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";
	
	else if($type == "dailymotion") $return ="<div class='video-embed'><iframe src='http://www.dailymotion.com/embed/video/$id?width=$width&amp;autoPlay={$autoplay}&foreground=%23FFFFFF&highlight=%23CCCCCC&background=%23000000&logo=0&hideInfos=1' width='$width' height='$height' class='iframe'></iframe></div>";
		
	if (!empty($id)){
		return $return;
	}
}
/*-----------------------------------------------------------------------------------*/
/* Media */
/*-----------------------------------------------------------------------------------*/

function hangar_map($atts) {

	// default atts
	$atts = shortcode_atts(array(	
		'lat'   => '0', 
		'lon'    => '0',
		'id' => 'map',
		'z' => '1',
		'w' => '400',
		'h' => '300',
		'maptype' => 'ROADMAP',
		'address' => '',
		'kml' => '',
		'kmlautofit' => 'yes',
		'marker' => '',
		'markerimage' => '',
		'traffic' => 'no',
		'bike' => 'no',
		'fusion' => '',
		'start' => '',
		'end' => '',
		'infowindow' => '',
		'infowindowdefault' => 'yes',
		'directions' => '',
		'hidecontrols' => 'false',
		'scale' => 'false',
		'scrollwheel' => 'true',
		'style' => ''		
	), $atts);
									
	$returnme = '<div id="' .$atts['id'] . '" style="width:' . $atts['w'] . 'px;height:' . $atts['h'] . 'px;" class="google_map ' . $atts['style'] . '"></div>';
	
	//directions panel
	if($atts['start'] != '' && $atts['end'] != '') 
	{
		$panelwidth = $atts['w']-20;
		$returnme .= '<div id="directionsPanel" style="width:' . $panelwidth . 'px;height:' . $atts['h'] . 'px;border:1px solid gray;padding:10px;overflow:auto;"></div><br>';
	}

	$returnme .= '
	<script type="text/javascript">
		var latlng = new google.maps.LatLng(' . $atts['lat'] . ', ' . $atts['lon'] . ');
		var myOptions = {
			zoom: ' . $atts['z'] . ',
			center: latlng,
			scrollwheel: ' . $atts['scrollwheel'] .',
			scaleControl: ' . $atts['scale'] .',
			disableDefaultUI: ' . $atts['hidecontrols'] .',
			mapTypeId: google.maps.MapTypeId.' . $atts['maptype'] . '
		};
		var ' . $atts['id'] . ' = new google.maps.Map(document.getElementById("' . $atts['id'] . '"),
		myOptions);
		';
				
		//kml
		if($atts['kml'] != '') 
		{
			if($atts['kmlautofit'] == 'no') 
			{
				$returnme .= '
				var kmlLayerOptions = {preserveViewport:true};
				';
			}
			else
			{
				$returnme .= '
				var kmlLayerOptions = {preserveViewport:false};
				';
			}
			$returnme .= '
			var kmllayer = new google.maps.KmlLayer(\'' . html_entity_decode($atts['kml']) . '\',kmlLayerOptions);
			kmllayer.setMap(' . $atts['id'] . ');
			';
		}

		//directions
		if($atts['start'] != '' && $atts['end'] != '') 
		{
			$returnme .= '
			var directionDisplay;
			var directionsService = new google.maps.DirectionsService();
		    directionsDisplay = new google.maps.DirectionsRenderer();
		    directionsDisplay.setMap(' . $atts['id'] . ');
    		directionsDisplay.setPanel(document.getElementById("directionsPanel"));

				var start = \'' . $atts['start'] . '\';
				var end = \'' . $atts['end'] . '\';
				var request = {
					origin:start, 
					destination:end,
					travelMode: google.maps.DirectionsTravelMode.DRIVING
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					}
				});


			';
		}
		
		//traffic
		if($atts['traffic'] == 'yes')
		{
			$returnme .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(' . $atts['id'] . ');
			';
		}
	
		//bike
		if($atts['bike'] == 'yes')
		{
			$returnme .= '			
			var bikeLayer = new google.maps.BicyclingLayer();
			bikeLayer.setMap(' . $atts['id'] . ');
			';
		}
		
		//fusion tables
		if($atts['fusion'] != '')
		{
			$returnme .= '			
			var fusionLayer = new google.maps.FusionTablesLayer(' . $atts['fusion'] . ');
			fusionLayer.setMap(' . $atts['id'] . ');
			';
		}
	
		//address
		if($atts['address'] != '')
		{
			$returnme .= '
		    var geocoder_' . $atts['id'] . ' = new google.maps.Geocoder();
			var address = \'' . $atts['address'] . '\';
			geocoder_' . $atts['id'] . '.geocode( { \'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					' . $atts['id'] . '.setCenter(results[0].geometry.location);
					';
					
					if ($atts['marker'] !='')
					{
						//add custom image
						if ($atts['markerimage'] !='')
						{
							$returnme .= 'var image = "'. $atts['markerimage'] .'";';
						}
						$returnme .= '
						var marker = new google.maps.Marker({
							map: ' . $atts['id'] . ', 
							';
							if ($atts['markerimage'] !='')
							{
								$returnme .= 'icon: image,';
							}
						$returnme .= '
							position: ' . $atts['id'] . '.getCenter()
						});
						';

						//infowindow
						if($atts['infowindow'] != '') 
						{
							//first convert and decode html chars
							$thiscontent = htmlspecialchars_decode($atts['infowindow']);
							$returnme .= '
							var contentString = \'' . $thiscontent . '\';
							var infowindow = new google.maps.InfoWindow({
								content: contentString
							});
										
							google.maps.event.addListener(marker, \'click\', function() {
							  infowindow.open(' . $atts['id'] . ',marker);
							});
							';

							//infowindow default
							if ($atts['infowindowdefault'] == 'yes')
							{
								$returnme .= '
									infowindow.open(' . $atts['id'] . ',marker);
								';
							}
						}
					}
			$returnme .= '
				} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
			});
			';
		}

		//marker: show if address is not specified
		if ($atts['marker'] != '' && $atts['address'] == '')
		{
			//add custom image
			if ($atts['markerimage'] !='')
			{
				$returnme .= 'var image = "'. $atts['markerimage'] .'";';
			}

			$returnme .= '
				var marker = new google.maps.Marker({
				map: ' . $atts['id'] . ', 
				';
				if ($atts['markerimage'] !='')
				{
					$returnme .= 'icon: image,';
				}
			$returnme .= '
				position: ' . $atts['id'] . '.getCenter()
			});
			';

			//infowindow
			if($atts['infowindow'] != '') 
			{
				$returnme .= '
				var contentString = \'' . $atts['infowindow'] . '\';
				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});
							
				google.maps.event.addListener(marker, \'click\', function() {
				  infowindow.open(' . $atts['id'] . ',marker);
				});
				';
				//infowindow default
				if ($atts['infowindowdefault'] == 'yes')
				{
					$returnme .= '
						infowindow.open(' . $atts['id'] . ',marker);
					';
				}				
			}
		}
		
		$returnme .= '</script>';
		
		
		return $returnme;
}
add_shortcode('map', 'hangar_map');

/*-----------------------------------------------------------------------------------*/
/*	Icons & Iconbox
/*-----------------------------------------------------------------------------------*/

function hangar_icon( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'icon'      => 'icon-plus'
    ), $atts));
    
	$out = '<span class="'. $icon .'"></span>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/

function hangar_iconbox( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'icon'      => 'ok',
       	'title'		=> '',
       	'iconurl' 	=> ''
    ), $atts));
    
    $geticon = '';
    
    if($iconurl != ''){
	    $geticon = '<span class="iconbox-none"><img src="'.$iconurl.'" /></span>';
    }
    else{
	    $geticon = '<span class="'. $icon .'"></span>';
    }
    
	$out = '<div class="iconbox">'.$geticon.'<h3>'. $title .'</h3>'. do_shortcode($content) . '</div>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/

function hangar_miniicon( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'icon'      => 'icon-plus'
    ), $atts));
    
	$out = '<i class="'. $icon .'"></i>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/

function hangar_retinaicon( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'icon'      => 'ok',
       	'color'     => '#ffffff',
       	'background' => '#999999',
       	'circle'     => false,
       	'align'		=> 'center',
       	'size'      => 'small'
    ), $atts));
    
    if($size == 'large') {
    	$return = " retinaicon-large";
    }
    elseif($size == 'medium') {
    	$return = " retinaicon-medium";
    }
    elseif($size == 'small') {
    	$return = " retinaicon-small";
    }
    else{
    	$return = " retinaicon-small";
    }
    
    if($circle == true) {
    	$return2 = " retinaicon-circ";
    	$return3 = ' style="background-color:'.$background.'; color: '.$color.';"';
    	$return4 = ' style="text-align: '.$align.' !important;"';
    }
    else{
    	$return2 = "";
    	$return3 = ' style="background-color: transparent; color: '.$color.';"';
    	$return4 = ' style="text-align: '.$align.' !important;"';
    }
    
	$out = '<span class="retinaicon '. $return .''. $return2 .'" '. $return4 .'><span class="'. $icon .'"'. $return3 .'></span></span>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/

function hangar_retinaiconbox( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'icon'      => 'ok',
       	'title'		=> '',
       	'color'		=> '#999999',
       	'background' => '#efefef',
       	'circle'     => false
    ), $atts));
    
    if($circle == true) {
    	$return2 = " retinaicon-circ";
    	$return3 = ' style="background-color:'.$background.'; color: '.$color.';"';
    }
    else{
    	$return2 = "";
    	$return3 = ' style="background-color: transparent; color: '.$color.';"';
    }
    
	$out = '<div class="retinaiconbox"><span class="'. $icon .''. $return2 .'" '. $return3 .'></span><h3>'. $title .'</h3>'. do_shortcode($content) . '</div>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/*	Lists
/*-----------------------------------------------------------------------------------*/

function hangar_list( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	$out = '<ul class="styled-list">'. do_shortcode($content) . '</ul>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/

function hangar_item( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'icon'      => 'ok'
    ), $atts));
	$out = '<li><i class="icon-'.$icon.'"></i>'. do_shortcode($content) . '</li>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/*	Member
/*-----------------------------------------------------------------------------------*/

function hangar_member( $atts, $content = null) {
extract( shortcode_atts( array(
      'img' 	=> '',
      'name' 	=> '',
      'url'		=> '',
      'role'	=> '',
      'twitter' => '',
      'facebook' => '',
      'skype' => '',
      'google' => '',
      'linkedin' => '',
      'mail' => '',
      ), $atts ) );
      
      if($url != '') {
    	$returnurl = "<a href='".$url."'>";
    	$returnurl2 = "</a>";
      } else {
    	$returnurl = "";
    	$returnurl2 = "";
      }
      
      if($img == '') {
    	$return = "";
      } else{
    	$return = "<div class='member-img'>".$returnurl."<img src='".$img."' />".$returnurl2."</div>";
      }
      
      
      
      if( $twitter != '' || $facebook != '' || $skype != '' || $google != '' || $linkedin != '' || $mail != '' ){
	      $return8 = '<div class="member-social"><ul>';
	      $return9 = '</ul></div>';
	      
	      if($twitter != '') {
	    	$return2 = '<li class=""><a href="' .$twitter. '" target="_blank" title="Twitter"><span class="icon-twitter"></span></a></li>';
	      } else{
		     $return2 = ''; 
	      }
	      
	      if($facebook != '') {
	    	$return3 = '<li class=""><a href="' .$facebook. '" target="_blank" title="Facebook"><span class="icon-facebook"></span></a></li>';
	      } else{
		      $return3 = ''; 
	      }
	      
	      if($skype != '') {
	    	$return4 = '<li class=""><a href="' .$skype. '" target="_blank" title="Skype"><span class="icon-skype"></span></a></li>';
	      } else{
		      $return4 = ''; 
	      }
	      
	      if($google != '') {
	    	$return5 = '<li class=""><a href="' .$google. '" target="_blank" title="Google+"><span class="icon-gplus"></span></a></li>';
	      } else{
		      $return5 = ''; 
	      }
	      
	      
	      if($linkedin != '') {
	    	$return6 = '<li class=""><a href="' .$linkedin. '" target="_blank" title="LinkedIn"><span class="icon-linkedin"></span></a></li>';
	      }
	      else{
		      $return6 = ''; 
	      }
	      
	      if($mail != '') {
	    	$return7 = '<li class=""><a href="mailto:' .$mail. '" title="Mail"><span class="icon-mail"></span></a></li>';
	      }
	      else{
		      $return7 = ''; 
	      }
      }  else {
	      $return2 = '';
	      $return3 = ''; 
	      $return4 = ''; 
	      $return5 = ''; 
	      $return6 = ''; 
	      $return7 = '';
	      $return8 = ''; 
	      $return9 = ''; 
      }   
      return '<div class="member">' .$return. '
      	<h4>' .$name. '</h4>
      	<div class="member-role">' .$role. '</div>' . do_shortcode($content) . '' .$return8. '' .$return2. '' .$return3. '' .$return4. '' .$return5. '' .$return6. '' .$return7. '' .$return9. '</div>';
}

/*-----------------------------------------------------------------------------------*/

function hangar_skill( $atts, $content = null ) {
	extract(shortcode_atts(array(
       	'percentage' => '0',
       	'title'      => ''
    ), $atts));
	$out = '<div class="skill-title">' .$title. '</div><div class="skillbar" data-perc="' .$percentage. '"><div class="skill-percentage"></div></div>';
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/* Pricing Table */
/*-----------------------------------------------------------------------------------*/

function hangar_plan( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'name'      => 'Premium',
		'link'      => 'http://www.google.de',
		'linkname'      => 'Sign Up',
		'price'      => '39.00$',
		'per'      => false,
		'color'    => false, // grey, green, red, blue
		'featured' => ''
    ), $atts));
    
    if($featured != '') {
    	$return = "<div class='featured' style='background-color:".$color.";'>".$featured."</div>";
    }
    else{
	    $return = "";
    }

    if($per != false) {
    	$return3 = "".$per."";
    }
    else{
    	$return3 = "";
    }
    $return5 = "";
    if($color != false) {
    	if($featured == true){
    		$return5 = "style='color:".$color.";' ";
    	}
    	$return4 = "style='color:".$color.";' ";
    }
    else{
    	$return4 = "";
    }
	
	$out = "
		<div class='plan'>	
			".$return."
			<div class='plan-head'><h3 ".$return4.">".$name."</h3>
			<div class='price' ".$return4.">".$price." <span>".$return3."</span></div></div>
			<ul>" .do_shortcode($content). "</ul><div class='signup'><a class='button' href='".$link."'>".$linkname."<span></span></a></div>
		</div>";
    return $out;
}

/*-----------------------------------------------------------------------------------*/

function hangar_pricing( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'col'      => '3'
    ), $atts));
	
	$out = "<div class='pricing-table col-".$col."'>" .do_shortcode($content). "</div><div class='clear'></div>";
    return $out;
}

/*-----------------------------------------------------------------------------------*/
/*	Block & Pullquotes
/*-----------------------------------------------------------------------------------*/
function hangar_blockquote( $atts, $content = null) {
extract( shortcode_atts( array(), $atts ) );
      
	return '<blockquote><p>' . do_shortcode($content) . '</p></blockquote>';
}

/*-----------------------------------------------------------------------------------*/

function hangar_pullquote( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'align'      => 'left'
    ), $atts));
	
    return '<span class="pullquote align-'.$align.'">' . do_shortcode($content) . '</span>';
}

/*-----------------------------------------------------------------------------------*/
/* Responsive Images 
/*-----------------------------------------------------------------------------------*/

function hangar_responsive( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	
	return '<span class="responsive">' . do_shortcode($content) . '</span>';
}

/*-----------------------------------------------------------------------------------*/
/* Responsive Visibility 
/*-----------------------------------------------------------------------------------*/

function hangar_responsivevisibility( $atts, $content = null) {

extract( shortcode_atts( array(
      'show' => 'desktop'
      ), $atts ) );
      return '<div class="visibility-' . $show . '">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/* Social Icons 
/*-----------------------------------------------------------------------------------*/

function hangar_social( $atts, $content = null) {

extract( shortcode_atts( array(
      'icon' 	=> 'twitter',
      'url'		=> '#',
      'target' 	=> '_blank'
      ), $atts ) );
      
      $capital = ucfirst($icon);
      
      return '<div class="social-icon social-' . $icon . '"><a href="' . $url . '" title="' . $capital . '" target="' . $target . '">' . $capital . '</a></div>';
}

/*-----------------------------------------------------------------------------------*/
/* Styled Tables
/*-----------------------------------------------------------------------------------*/

function hangar_table( $atts, $content = null) {

extract( shortcode_atts( array(
      'style' 	=> '1'
      ), $atts ) );
      
      return '<div class="custom-table-' . $style . '">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/* Testimonial
/*-----------------------------------------------------------------------------------*/

function hangar_testimonial( $atts, $content = null) {
extract( shortcode_atts( array(
      'author' => ''
      ), $atts ) );
      return '<div class="testimonial">' . do_shortcode($content) . '</div><div class="testimonial-author">' .$author. '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/

function hangar_tabgroup( $atts, $content = null ) {
	$GLOBALS['tab_count'] = 0;
	$i = 1;
	$randomid = rand();

	do_shortcode( $content );

	if( is_array( $GLOBALS['tabs'] ) ){
	
		foreach( $GLOBALS['tabs'] as $tab ){	
			if( $tab['icon'] != '' ){
				$icon = '<i class="'.$tab['icon'].'"></i>';
			}
			else{
				$icon = '';
			}
			$tabs[] = '<li class="tab"><a href="#panel'.$randomid.$i.'">'.$icon . $tab['title'].'</a></li>';
			$panes[] = '<div class="panel" id="panel'.$randomid.$i.'"><p>'.$tab['content'].'</p></div>';
			$i++;
			$icon = '';
		}
		$return = '<div class="tabset"><ul class="tabs">'.implode( "\n", $tabs ).'</ul>'.implode( "\n", $panes ).'</div>';
	}
	return $return;
}
add_shortcode( 'tabgroup', 'hangar_tabgroup' );

function hangar_tab( $atts, $content = null) {
	extract(shortcode_atts(array(
			'title' => '',
			'icon'  => ''
	), $atts));
	
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'icon' => $icon, 'content' =>  $content );
	$GLOBALS['tab_count']++;
}
add_shortcode( 'tab', 'hangar_tab' );


/*-----------------------------------------------------------------------------------*/
/* Toggle */
/*-----------------------------------------------------------------------------------*/

function hangar_toggle( $atts, $content = null){
	extract(shortcode_atts(array(
        'title' => '',
        'icon' => '',
        'open' => "false"
    ), $atts));

	if($icon == '') {
    	$return = "";
    }
    else{
    	$return = "<i class='icon-".$icon."'></i>";
    }
    
    if($open == "true") {
	    $return2 = "active";
    }
    else{
	    $return2 = '';
    }
   
   return '<div class="toggle"><div class="toggle-title '.$return2.'">'.$return.''.$title.'<span class="icon-plus"></span></div><div class="toggle-inner"><p>'. do_shortcode($content) . '</p></div></div>';
}


/*-----------------------------------------------------------------------------------*/
/* Tooltip */
/*-----------------------------------------------------------------------------------*/

function hangar_tooltip( $atts, $content = null)
{
	extract(shortcode_atts(array(
        'text' => ''
    ), $atts));
   
   return '<span class="tooltips"><a href="#" rel="tooltip" title="'.$text.'">'. do_shortcode($content) . '</a></span>';
}

/*-----------------------------------------------------------------------------------*/
/* Separator */
/*-----------------------------------------------------------------------------------*/

function hangar_separator( $atts, $content = null){
	extract(shortcode_atts(array(
       	'headline'      => 'h3',
       	'title' => 'Title'
    ), $atts));
   
	return '<'.$headline.' class="title"><span>'.$title.'</span></'.$headline.'>';
}

/*-----------------------------------------------------------------------------------*/
/*	Latest Projects
/*-----------------------------------------------------------------------------------*/

function hangar_portfolio($atts){
	extract(shortcode_atts(array(
       	'projects'      => '4',
       	'title' => 'Portfolio',
       	'show_title' => 'yes',
       	'columns' => '4',
       	'filters' => 'all'
    ), $atts));
    
    global $post;

	$args = array(
		'post_type' => 'portfolio',
		'posts_per_page' => $projects,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post_status'    => 'publish'
    );
    
    if($filters != 'all'){
    	
    	// string to array
    	$str = $filters;
    	$arr = explode(',', $str);
    	//var_dump($arr);
    	
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'portfolio_filter',
			'field' 	=> 'slug',
			'terms' 	=> $arr
		);
	}
    
    
    $randomid = rand();

    query_posts( $args );
    $out = '';

	if( have_posts() ) :
		
		if($show_title == 'yes'){
			$out .= '<h3 class="title"><span>'.$title.'</span></h3>';
		}
		
		if($columns == '3'){
			$return = 'one-third';
		}
		elseif($columns == '2'){
			$return = 'eight';
		}
		else{
			$return = 'four';
		}

		
		$out .= '<div class="latest-portfolio negative-wrap">';	
		while ( have_posts() ) : the_post();
			
			$out .= '<div class="portfolio-item '.$return.' columns">';
			
			
			$embedd = '';
				
				if( get_post_meta( get_the_ID(), 'hangar_portfolio-lightbox', true ) == "true") { 
					$lightboxtype = '<span class="overlay-lightbox"></span>';
					if( get_post_meta( get_the_ID(), 'hangar_embed', true ) != "") {
							if ( get_post_meta( get_the_ID(), 'hangar_source', true ) == 'youtube' ) {
								$link = '<a href="http://www.youtube.com/watch?v='.get_post_meta( get_the_ID(), 'hangar_embed', true ).'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    				} else if ( get_post_meta( get_the_ID(), 'hangar_source', true ) == 'vimeo' ) {
		    					$link = '<a href="http://vimeo.com/'. get_post_meta( get_the_ID(), 'hangar_embed', true ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    				} else if ( get_post_meta( get_the_ID(), 'hangar_source', true ) == 'own' ) {
		    					$randomid = rand();
		    					$link = '<a href="#embedd-video-'.$randomid.'" class="prettyPhoto" title="'. get_the_title() .'" rel="prettyPhoto[portfolio]">';
		    					$embedd = '<div id="embedd-video-'.$randomid.'" class="embedd-video"><p>'. get_post_meta( get_the_ID(), 'hangar_embed', true ) .'</p></div>';
							}
					} else {
						$link = '<a href="'. wp_get_attachment_url( get_post_thumbnail_id() ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
		    		}
		    	}
				else{
					$lightboxtype = '<span class="overlay-link"></span>';
					$link = '<a href="'. get_permalink() .'" title="'. get_the_title() .'">';
					$embedd = '';
				} 
			
			
			if ( has_post_thumbnail()) {
			
					$portfolio_thumbnail= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'eight-columns' );
					
					if(get_post_meta( get_the_ID(), "hangar_subtitle", true ) != '' ) { 
						$subtitle = get_post_meta( get_the_ID(), "hangar_subtitle", true );
					} else {
						$subtitle = substr(get_the_excerpt(),0,25).'...';
					}
					
					$out .= '<div class="portfolio-it">
				  		'. $link . '<span class="portfolio-pic"><img src="'.$portfolio_thumbnail[0].'" /><div class="portfolio-overlay">'. $lightboxtype .'</div></span></a>
				  		<a href="'. get_permalink() .'" title="'. get_the_title() .'" class="portfolio-title"><h4>'. get_the_title() .'</h4><span>'.$subtitle.'</span></a>
				  	</div>';
				  	
				  	$out .= $embedd;
			
			}
			
		    $out .='</div>';
			
		endwhile;
		
		$out .='</div><div class="clear"></div>';
		
		 wp_reset_query();
	
	endif;

	return $out;
}
add_shortcode('portfolio', 'hangar_portfolio');


/*-----------------------------------------------------------------------------------*/
/*	Latest Blog
/*-----------------------------------------------------------------------------------*/

function hangar_bloglist($atts){
	extract(shortcode_atts(array(
       	'posts'      => '4',
       	'title' => 'Latest Blog Entries',
       	'show_title' => 'yes',
       	'categories' => 'all'
    ), $atts));
    
    global $post;

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post_status'    => 'publish'
    );
    
    if($categories != 'all'){
    	
    	// string to array
    	$str = $categories;
    	$arr = explode(',', $str);
    	//var_dump($arr);
    	
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'category',
			'field' 	=> 'slug',
			'terms' 	=> $arr
		);
	}

    query_posts( $args );
    $out = '';
    
   

	if( have_posts() ) :
		
		if($show_title == 'yes'){
			$out .= '<h3 class="title"><span>'.$title.'</span></h3>';
		}
		
		while ( have_posts() ) : the_post();
				
			$out .= '<div class="latest-blog-list clearfix"><div class="blog-list-item-date">'.get_the_time('d').'<span>'.get_the_time('M').'</span></div>
					<div class="blog-list-item-description">
						<h4><a href="'.get_permalink().'" title="' . get_the_title() . '">'.get_the_title() .'</a></h4>
						<span>'.get_comments_number().' '.__( 'Comments', 'hangar' ) .'</span>
						<div class="blog-list-item-excerpt">'.limit_words(get_the_excerpt(), '20').'... <a href="'. get_permalink() . '">' .__( 'Read More &rarr;', 'hangar' ) . '</a></div>
					</div>
					</div>';
			
		endwhile;
		
		$out .='<div class="clear"></div>';
		
		 wp_reset_query();
	
	endif;

	return $out;
}
add_shortcode('bloglist', 'hangar_bloglist');

/*-----------------------------------------------------------------------------------*/
/*	Latest Blog
/*-----------------------------------------------------------------------------------*/

function hangar_blog($atts){
	extract(shortcode_atts(array(
       	'posts'      => '4',
       	'title' => 'Latest From the Blog',
       	'show_title' => 'yes',
       	'categories' => 'all'
    ), $atts));
    
    global $post;

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post_status'    => 'publish'
    );
    
    if($categories != 'all'){
    	
    	// string to array
    	$str = $categories;
    	$arr = explode(',', $str);
    	//var_dump($arr);
    	
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'category',
			'field' 	=> 'slug',
			'terms' 	=> $arr
		);
	}

    query_posts( $args );
    $out = '';
    
   

	if( have_posts() ) :
		
		if($show_title == 'yes'){
			$out .= '<h3 class="title"><span>'.$title.'</span></h3>';
		}
		
		$out .= '<div class="latest-blog negative-wrap">';	
		
		while ( have_posts() ) : the_post();
		
			 //$text = strip_tags(hangar_excerpt(20));
			
			$out .= '<div class="blog-item one_fourth">';
			
			if ( has_post_thumbnail()) {
				$blog_thumbnail= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'eight-columns' );
				$out .= '<a href="'.get_permalink().'" title="' . get_the_title() . '" class="blog-pic"><img src="'.$blog_thumbnail[0].'" /><div class="blog-overlay">';
				
					if ( has_post_format( 'audio' )) {
						$out .= '<span class="post-icon audio"></span>';
					}
					if ( has_post_format( 'gallery' )) {
						$out .= '<span class="post-icon imagegallery"></span>';
					}
					if ( has_post_format( 'link' )) {
						$out .= '<span class="post-icon link"></span>';
					}
					if ( has_post_format( 'quote' )) {
						$out .= '<span class="post-icon quote"></span>';
					}
					if ( has_post_format( 'video' )) {
						$out .= '<span class="post-icon video"></span>';
					}
					if ( get_post_format() == false ) {
						$out .= '<span class="post-icon standard"></span>';
					}
				
				$out .= '</div></a>';
			}
			
			$out .= '<div class="blog-item-description">
						<h4><a href="'.get_permalink().'" title="' . get_the_title() . '">'.get_the_title() .'</a></h4>
						<span>'.get_the_date().' / '.get_comments_number().' '.__( 'Comments', 'hangar' ) .'</span>
					</div>';
		
		    $out .='<div class="blog-border"></div></div>';
			
		endwhile;
		
		$out .='</div><div class="clear"></div>';
		
		 wp_reset_query();
	
	endif;

	return $out;
}
add_shortcode('blog', 'hangar_blog');

/*-----------------------------------------------------------------------------------*/
/*	Section
/*-----------------------------------------------------------------------------------*/
function hangar_section( $atts, $content = null) {

extract( shortcode_atts( array(
	'bgcolor'		=> '#ffffff',
	'bgimage'		=> '',
	'parallax'	=> 'false',
	'padding' => '',
	'border' => 'none'
	), $atts ) );

	if($parallax == 'false') {
	  	$var1 = '';
	}
	else{
	  	$var1 = 'section-parallax';
	}

	$var2 = '';

	if($bgimage != ''){
		$var2 = 'background-image: url(' . $bgimage . ');';
	}
      
    return '<div class="section ' . $var1 . '" style="background-color: ' . $bgcolor . '; border: ' . $border . '; padding: ' . $padding . '; ' . $var2 . '"><div class="container clearfix"><div class="sixteen columns">' . do_shortcode($content) . '</div></div></div>';
}

// ADDITIONAL SB SHORTCODES

/*Separator
/*-------------------------------------------------------------------------------------------------------------*/

function mds_divider( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'style' => 'default',
		'length' => 'long',
		'alignment' => 'center',
		'contenttype' => 'default',
		'heading' => 'span',
		'icon' => '',
		'iconfont' => '',
		'fontsize' => '',
		'fontcolor' => '',
		'marginbottom' => '0',
		'margintop' => '0'
		
		
	),$atts));
	
	
	$iconFontCss = $fontsize && is_numeric($fontsize) ? 'style="font-size:'.$fontsize.'px;line-height:'.$fontsize.'px;'.($fontcolor ? 'color:'.$fontcolor . ';' : '').'"' : '';
	
	$marginbottom = $marginbottom && intval($marginbottom) ? 'margin-bottom:'.$marginbottom.'px;' : '';
	$margintop = $margintop && intval($margintop) ? 'margin-top:'.$margintop.'px;' : '';
	
	$css = ' style="' . $margintop . $marginbottom . '"';
	$html ='';	
	//$style =='default' || $style =='two-lines' || $style =='three-lines' || $style == 'dotted-line1' || $style == 'dotted-lines2' || $style == 'dotted-lines3' || $style == 'dashed-line1' || $style == 'dashed-lines2' || $style == 'dashed-lines3' || $style == 'stripes' || $style == 'right-stripes' || $style == 'left-stripes' || $style == 'zigzag' || $style == 'stitches1' || $style == 'stitches2' || $style == 'stitches3' || $style == 'stitches4'
	if($style =='breakline'){
		$html = '<div class="clear" '.$css.'></div>';
	}elseif($style =='back-to-top'){
		$html = '<div class="clear"></div><div class="mds-divider style-two-lines contenttype-back-to-top alignment-'.$alignment.'" '.$css.'><div class="divider"></div><span class="transparent-border" title="'.__('Back to top','framework').'"><span class="micon-top-up"></span></span></div>';
	}elseif($style =='shadow1' || $style =='shadow2'){
		$html = '<div class="clear"></div><div class="mds-divider contenttype-default style-'.$style.'" '.$css.'><div class="divider"></div></div>';
	}else{
		$type = '';
		if($contenttype == 'text'){
			$type = '<'.$heading.'>'.$title.'</'.$heading.'>';
		}elseif($contenttype == 'icon'){
			if ($icon || $iconfont) { 
				if(!$iconfont){
					$type = wp_get_attachment_image_src($icon, 'full'); 
					$type = '<img src="'. esc_url($type[0]) .'" alt="'.esc_attr($title).'"/>'; 
				}else{
					$type = $iconfont ? '<i class="' . $iconfont . '" '.$iconFontCss.'></i>' : '';
				}
			}else{
				$type = '';
			}
		}
		$html = '<div class="clear"></div><div class="mds-divider style-'. $style .' length-'.$length.' contenttype-'. $contenttype .' alignment-'.$alignment.'" '.$css.'>'.($contenttype != 'default' ? '<div class="content">'.$type.'</div>' : '').'<div class="divider"></div></div>';
	}
	
	return $html;
	
}
add_shortcode('divider', 'mds_divider');


/* ----------------------------------------------------- */
/* Pre Process Shortcodes */
/* ----------------------------------------------------- */

function pre_process_shortcode($content) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();
    
    add_shortcode('accordion', 'hangar_accordion');
    add_shortcode('alert', 'hangar_alert');
    add_shortcode('button', 'hangar_buttons');
    
    add_shortcode('teaserbox', 'hangar_teaserbox');
    add_shortcode('teaser', 'hangar_teaser');
    add_shortcode('callout', 'hangar_callout');
    add_shortcode('box', 'hangar_box');
    
    add_shortcode('googlefont', 'hangar_googlefont');
    
    add_shortcode('br', 'hangar_br');
    add_shortcode('clear', 'hangar_clear');
    add_shortcode('gap', 'hangar_gap');
    add_shortcode('hr', 'hangar_hr');
    
    add_shortcode('one_third', 'hangar_one_third');
	add_shortcode('one_third_last', 'hangar_one_third_last');
	add_shortcode('two_third', 'hangar_two_third');
	add_shortcode('two_third_last', 'hangar_two_third_last');
	add_shortcode('one_half', 'hangar_one_half');
	add_shortcode('one_half_last', 'hangar_one_half_last');
	add_shortcode('one_fourth', 'hangar_one_fourth');
	add_shortcode('one_fourth_last', 'hangar_one_fourth_last');
	add_shortcode('three_fourth', 'hangar_three_fourth');
	add_shortcode('three_fourth_last', 'hangar_three_fourth_last');
	add_shortcode('one_fifth', 'hangar_one_fifth');
	add_shortcode('one_fifth_last', 'hangar_one_fifth_last');
	add_shortcode('two_fifth', 'hangar_two_fifth');
	add_shortcode('two_fifth_last', 'hangar_two_fifth_last');
	add_shortcode('three_fifth', 'hangar_three_fifth');
	add_shortcode('three_fifth_last', 'hangar_three_fifth_last');
	add_shortcode('four_fifth', 'hangar_four_fifth');
	add_shortcode('four_fifth_last', 'hangar_four_fifth_last');
	add_shortcode('one_sixth', 'hangar_one_sixth');
	add_shortcode('one_sixth_last', 'hangar_one_sixth_last');
	add_shortcode('five_sixth', 'hangar_five_sixth');
	add_shortcode('five_sixth_last', 'hangar_five_sixth_last');
	
	add_shortcode('dropcap', 'hangar_dropcap');
	
	add_shortcode('video', 'hangar_video');
	
	add_shortcode('iconbox', 'hangar_iconbox');
	add_shortcode('icon', 'hangar_icon');
	add_shortcode('mini-icon', 'hangar_miniicon');
	add_shortcode('retinaicon', 'hangar_retinaicon');
	add_shortcode('retinaiconbox', 'hangar_retinaiconbox');
	
	add_shortcode( 'gal', 'hangar_gallery' );
	
	add_shortcode('list', 'hangar_list');
	add_shortcode('list_item', 'hangar_item');
	
	add_shortcode('member', 'hangar_member');
	add_shortcode('skill', 'hangar_skill');
	
	add_shortcode('plan', 'hangar_plan');
	add_shortcode('pricing-table', 'hangar_pricing');
	
	add_shortcode('blockquote', 'hangar_blockquote');
	add_shortcode('pullquote', 'hangar_pullquote');
	
	add_shortcode('responsive', 'hangar_responsive');
	add_shortcode('visibility', 'hangar_responsivevisibility');

	add_shortcode('section', 'hangar_section');
	
	add_shortcode('social', 'hangar_social');
	
	add_shortcode('custom_table', 'hangar_table');
	
	add_shortcode('testimonial', 'hangar_testimonial');
	
	add_shortcode('toggle', 'hangar_toggle');
	
	add_shortcode('tooltip', 'hangar_tooltip');
	add_shortcode('highlight', 'hangar_highlight');
	add_shortcode('separator', 'hangar_separator');
	
	add_shortcode('tagline', 'hangar_tagline');
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode($content);
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}

 
add_filter('the_content', 'pre_process_shortcode', 7);

// Allow Shortcodes in Widgets
add_filter('widget_text', 'pre_process_shortcode', 7);

/*-----------------------------------------------------------------------------------*/
/* Add TinyMCE Buttons to Editor */
/*-----------------------------------------------------------------------------------*/
add_action('init', 'add_button');

function add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'add_plugin');  
     add_filter('mce_buttons_3', 'register_button_3');
     add_filter('mce_buttons_4', 'register_button_4');  
   }  
}  

// Define Position of TinyMCE Icons
function register_button_3($buttons) {  
   array_push($buttons, "accordion", "alert", "button", "divider", "dropcap", "video", "maps", "gap", "clear", "icon", "miniicon", "iconbox", "retinaicon", "retinaiconbox", "member", "skill", "pricing", "projects", "blog", "bloglist", "testimonial");  
   return $buttons;  
} 
function register_button_4($buttons) {  
   array_push($buttons, "pullquote", "responsiveimage", "visibility", "socialmedia", "table", "tabs", "toggle", "tooltip", "list", "separatorheadline", "googlefont", "one_half", "one_third", "two_third", "one_fourth", "three_fourth", "one_fifth", "teaser", "teaserbox", "callout", "box", "section");  
   return $buttons;  
}  

function add_plugin($plugin_array) {  

	$file = '';
	
	if(current_theme_supports( 'hangar_accordion' )) {
		$plugin_array['accordion'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_alert' )) {
   		$plugin_array['alert'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_button' )) {
   		$plugin_array['button'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_divider' )) {
		$plugin_array['divider'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
		$plugin_array['dropcap'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_video' )) {
		$plugin_array['video'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_maps' )) {
		$plugin_array['maps'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_gap' )) {
		$plugin_array['gap'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_clear' )) {
		$plugin_array['clear'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_icon' )) {
		$plugin_array['icon'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_miniicon' )) {
   		 $plugin_array['miniicon'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}


	if(current_theme_supports( 'hangar_retinaicon' )) {
		$plugin_array['iconbox'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
		$plugin_array['retinaicon'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_retinaiconbox' )) {
		$plugin_array['retinaiconbox'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_list' )) {
		$plugin_array['list'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_member' )) {
		$plugin_array['member'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_skill' )) {
		$plugin_array['skill'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_pricing' )) {
		$plugin_array['pricing'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_pullquote' )) {
		$plugin_array['pullquote'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}	

	if(current_theme_supports( 'hangar_table' )) {
		$plugin_array['table'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_tabs' )) {
		$plugin_array['tabs'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_toggle' )) {
		$plugin_array['toggle'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_sep' )) {
		$plugin_array['separatorheadline'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}	

	if(current_theme_supports( 'hangar_googlefont' )) {
		$plugin_array['googlefont'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_columns' )) {
		$plugin_array['one_half'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
		$plugin_array['one_third'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	   $plugin_array['two_third'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	   $plugin_array['one_fourth'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	   $plugin_array['three_fourth'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	   $plugin_array['one_fifth'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_teaser' )) {
		$plugin_array['teaser'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	   $plugin_array['teaserbox'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	   $plugin_array['callout'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	   $plugin_array['box'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

	if(current_theme_supports( 'hangar_testimonial' )) {
		$plugin_array['testimonial'] = plugin_dir_url( $file ).'hangar/bundled/hangar-shortcodes/tinymce/tinymce.js';
	}

   return $plugin_array;  
}

?>