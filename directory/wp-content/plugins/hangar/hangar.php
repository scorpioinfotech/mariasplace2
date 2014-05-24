<?php
/*
Plugin Name: Hangar
Plugin URI: http://themesdepot.org
Description: Hangar is a powerful collection of features to enhance your website. This plugin is compatible only if you are using a ThemesDepot theme.
Version: 1.1
Author: ThemesDepot
Author URI: http://themesdepot.org/
License: 
*/	
	
require_once( 'classes/hangar.class.php' );

$GLOBALS['hangar'] = new Hangar( __FILE__ );
$GLOBALS['hangar']->version = '1.0.0';

// Hangar is ready, now load supported theme features.

add_action('after_setup_theme', 'tdp_supported_components');
function tdp_supported_components(){

	if (version_compare(phpversion(), "5.3.0", ">=")) { 
    	
    	if(current_theme_supports( 'tdp_cpt' )) {
		require_once( 'supported/cpt.php' );
		}
		if(current_theme_supports( 'tdp_cpt_listings' )) {
			require_once( 'supported/listings_post_type.php' );
		}
		if(current_theme_supports( 'tdp_cpt_claim' )) {
			require_once( 'supported/listings_claiming.php' );
		}

	} else { 
	  
		function tdp_my_admin_notice() {
		    ?>
		    <div class="updated error">
		        <p><?php _e( 'Please note: your hosting server is using an outdated version of PHP you must contact your host and request to update your php version to at least 5.3.0. If you do not update your php version you will not be able to use the theme.', 'my-text-domain' ); ?></p>
		    </div>
		    <?php
		}
		add_action( 'admin_notices', 'tdp_my_admin_notice' );

	} 

}

?>