<?php
//checkout shortcode separated out so we can have multiple checkout pages
function tdp_checkout_shortcode($atts, $content=null, $code="")
{	
	ob_start();
	if(file_exists(get_stylesheet_directory() . "/tdp-listings-membership/pages/checkout.php"))
		include(get_stylesheet_directory() . "/tdp-listings-membership/pages/checkout.php");
	else
		include(plugin_dir_path(dirname(__FILE__)) . "/pages/checkout.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return apply_filters("tdp_pages_shortcode_checkout", $temp_content);			
}
add_shortcode("tdp_checkout", "tdp_checkout_shortcode");