<?php
/**
 * Module Name: Hangar - Custom Code
 * Module Description: The Hangar Custom Code feature adds the facility to easy add custom CSS code to your website, as well as custom HTML code in the <head> section or before the </body> tag.
 * Module Version: 1.0.0
 * Module Settings: hangar-custom-code
 *
 * @package Hangar
 * @subpackage Bundled
 * @author WooThemes
 * @since 1.0.0
 */
 
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}

 /* Include Class */
 require_once( 'classes/hangar-custom-code.class.php' );
 /* Instantiate Class */
 if ( class_exists( 'Hangar' ) ) {
 	$hangar_custom_code = new Hangar_CustomCode();
 }
 
?>