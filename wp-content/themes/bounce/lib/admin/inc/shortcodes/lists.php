<?php

//////////////////////////////////////// Lists ////////////////////////////////////////

function gp_list($atts, $content = null, $code) {
    extract(shortcode_atts(array(
		'type' => 'arrow'
    ), $atts));
    
    if($code=="list") {
		$out .= '<ul class="sc-list '.$type.'">'.do_shortcode($content).'</ul>';
	} elseif($code=="li") {
		$out .= '<li>'.do_shortcode($content).'</li>';
	}
	
   return $out;
   
}
add_shortcode("list", "gp_list");
add_shortcode("li", "gp_list");

?>