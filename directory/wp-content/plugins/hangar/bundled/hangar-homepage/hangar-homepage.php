<?php
/**
 * Module Name: Hangar - Easy Homepage Switch
 * Module Description: Easily set a page as homepage, this module will add a new setting into the page editor, allowing to set the current page as homepage.
 * Module Version: 1.0.0
 *
 * @package Hangar
 * @subpackage Bundled
 * @since 1.0.0
 */
 
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}
 
/**
 * Check if the theme supports the following widgets and then loads them.
 */
require_once( 'easy-homepage-switch.php' );


?>