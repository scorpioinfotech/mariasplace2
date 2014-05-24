<?php 
if ( !defined( 'ABSPATH' ) ) exit;
/**
Plugin Name: BuddyPress MyMood
Plugin URI: webgarb.com/buddypress-mymood/
Description: Lets your BuddyPress member share there mood with there activity post.
Version: 1.7
Author: Ayush
Author URI: http://webgarb.com
**/

define("BP_MYMOOD_VERSION","1.7");
define("BP_MYMOOD_PATH",plugins_url("",__FILE__));
define("BP_MYMOOD_DIR",str_replace("\/","/",dirname(__FILE__)) );


//BuddyPress buddypress-activity-plus is active
define("BP_MYMOOD_BPFB_ACTIVE",in_array( 'buddypress-activity-plus/bpfb.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ));


function bp_mymood_language() {
if ( file_exists( dirname( __FILE__ ) . '/languages/buddypress-mymood-' . get_locale() . '.mo' ) ) {
load_textdomain( 'buddypress-mymood', dirname( __FILE__ ) . '/languages/buddypress-mymood-' . get_locale() . '.mo'  );
}
}
add_action('bp_include', 'bp_mymood_language');

function bp_mymood_init() {
	
	require( dirname( __FILE__ ) . '/buddypress-mymood.php' );
	
}
add_action( 'bp_include', 'bp_mymood_init' );

?>