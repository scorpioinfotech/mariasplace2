<?php
/**
 * Module Name: Hangar - Social Widgets
 * Module Description: A collection of widgets to connect to your online social profiles.
 * Module Version: 1.1.3
 * Module Settings: hangar-social-widgets-settings
 *
 * @package Hangar
 * @subpackage Bundled
 * @author Matty
 * @since 1.0.0
 */

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}

/* Include Social Widgets Class*/
require_once( 'classes/hangar-social-widgets.class.php' );
/* Instantiate Social Widgets Class */
if ( class_exists( 'Hangar' ) ) {
	global $Hangar_Social_Widgets;
	$Hangar_Social_Widgets = new Hangar_Social_Widgets();
}
 /**
  * hangar_socialwidgets_register function.
  * 
  * @access public
  * @since 1.0.0
  * @return void
  */
 
if ( ! function_exists( 'hangar_socialwidgets_register' ) ) {
 	add_action( 'widgets_init', 'hangar_socialwidgets_register' );

	function hangar_socialwidgets_register () {
		global $hangar;
		$widgets = array();
		$widgets['Hangar_Widget_Tweets'] = 'widgets/widget-hangar-tweets.php';
	 	$widgets['Hangar_Widget_TwitterProfile'] = 'widgets/widget-hangar-twitter-profile.php';
	 	$widgets['Hangar_Widget_Instagram'] = 'widgets/widget-hangar-instagram.php';
	 	$widgets['Hangar_Widget_InstagramProfile'] = 'widgets/widget-hangar-instagram-profile.php';
	 	$widgets['Hangar_Widget_Gplus'] = 'widgets/widget-hangar-gplus.php';

		$widgets = apply_filters( 'hangar_socialwidgets_widgets', $widgets );

		if ( count( $widgets ) > 0 ) {
			foreach ( $widgets as $k => $v ) {
				if ( file_exists( $hangar->base->components_path . 'hangar-social-widgets/' . $v ) ) {
					require_once( $v );
					register_widget( $k );
				}
			}
		}
	} // End hangar_socialwidgets_register()
}
?>