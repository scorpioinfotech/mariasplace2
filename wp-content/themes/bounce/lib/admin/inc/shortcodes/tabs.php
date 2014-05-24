<?php

//////////////////////////////////////// Tabs ////////////////////////////////////////

function gp_tabs($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));

	if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
		
	} else {
	
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		
		$output = '<ul>';
		
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<li><div class="tabhead"><a href="#tab-'.preg_replace('/[^a-zA-Z0-9]/', '', $matches[3][$i]['title'] ).'">' . $matches[3][$i]['title'] . '</a></div></li>';
		}
		
		$output .= '</ul><div class="clear"></div>';

		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<div id="tab-'.preg_replace('/[^a-zA-Z0-9]/', '', $matches[3][$i]['title']).'" class="sc-tab-panel">'.do_shortcode(trim($matches[5][$i])).'</div>';
		}
		
		return '<div class="sc-tabs">'.$output.'</div>';
	}
	
}

add_shortcode("tabs", "gp_tabs");

?>