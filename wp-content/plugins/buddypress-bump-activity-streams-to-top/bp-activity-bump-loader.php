<?php
/*
Plugin Name: Buddypress Bump Activity Streams To Top
Plugin URI: http://wordpress.org/extend/plugins/buddypress-bump-activity-streams-to-top/
Description: Bumps an activity record to the top of the stream on activity comment replies
Author: David Gladwin
Author URI: http://gladwinput.com
License: GNU GENERAL PUBLIC LICENSE 3.0 http://www.gnu.org/licenses/gpl.txt
Version: 1.0.0
Text Domain: bp-activity-bump
Network: true
*/

function bp_activity_bump_init() {

	if ( file_exists( dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' ) )
		load_textdomain( 'bp-activity-bump', dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' );
		
	require( dirname( __FILE__ ) . '/bp-activity-bump.php' );
	
	add_action( bp_core_admin_hook(), 'bp_activity_bump_admin_add_admin_menu' );
	
}
add_action( 'bp_include', 'bp_activity_bump_init', 88 );

//add admin_menu page
function bp_activity_bump_admin_add_admin_menu() {
	global $bp;
	
	if ( !is_super_admin() )
		return false;

	//Add the component's administration tab under the "BuddyPress" menu for site administrators
	require ( dirname( __FILE__ ) . '/admin/bp-activity-bump-admin.php' );

	add_submenu_page( 'bp-general-settings', __( 'Activity Bump Admin', 'bp-activity-bump' ), __( 'Activity Bump', 'bp-activity-bump' ), 'manage_options', 'bp-activity-bump-settings', 'bp_activity_bump_admin' );	

}

/* Stolen from Welcome Pack - thanks, Paul! then stolen from boone*/
function bp_activity_bump_admin_add_action_link( $links, $file ) {
	if ( 'buddypress-activity-stream-bump-to-top/bp-activity-bump-loader.php' != $file )
		return $links;

	if ( function_exists( 'bp_core_do_network_admin' ) ) {
		$settings_url = add_query_arg( 'page', 'bp-activity-bump-settings', bp_core_do_network_admin() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' ) );
	} else {
		$settings_url = add_query_arg( 'page', 'bp-activity-bump-settings', is_multisite() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' ) );
	}

	$settings_link = '<a href="' . $settings_url . '">' . __( 'Settings', 'bp-activity-bump' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}
add_filter( 'plugin_action_links', 'bp_activity_bump_admin_add_action_link', 10, 2 );
?>
