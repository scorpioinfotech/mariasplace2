<?php 
/*
Plugin Name: iLightBox
Plugin URI: http://ilightbox.net/
Description: iLightBox allows you to easily create the most beautiful overlay windows using the jQuery Javascript library. By combining support for a wide range of media with gorgeous skins and a user-friendly API, iLightBox aims to push the Lightbox concept as far as possible.
Version: 1.5.3
Author: Hemn Chawroka
Author URI: http://iprodev.com/
*/
ob_start();


if (!class_exists("iLightBox")) {
	
	require_once dirname( __FILE__ ) . '/ilightbox.php';	
	$iLightBox = new iLightBox(__FILE__);
	
	function get_ilightbox( $atts, $content = null ) {
		global $iLightBox;		
		return $iLightBox->_get_ilightbox( $atts, $content );
	}
}