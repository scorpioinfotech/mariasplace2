<?php
/**
	* Module Name: Hangar - Login Branding
	* Module Description: Hangar - Login Branding automatically rebrands your Login screen with a custom logo.
	* Module Version: 1.0.0
	* Module Settings: hangar-login-branding
	*
	* @package Hangar
	* @subpackage Bundled
	* @author Patrick
	* @since 1.0.0
*/

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}

 /* Instantiate Login Branding */
 if ( class_exists( 'Hangar' ) ) {
	/* Include Login Branding Class*/
 	require_once('classes/hangar-login-branding.class.php');
 	$hangar_login_branding = new Hangar_Login_Branding();
 }