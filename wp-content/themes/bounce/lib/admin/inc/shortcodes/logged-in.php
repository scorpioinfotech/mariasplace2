<?php

//////////////////////////////////////// Logged In ////////////////////////////////////////

function gp_logged_in($atts, $content = null) {
	if(is_user_logged_in()) {
		return do_shortcode($content);
	}
}
add_shortcode('logged_in', 'gp_logged_in');

?>