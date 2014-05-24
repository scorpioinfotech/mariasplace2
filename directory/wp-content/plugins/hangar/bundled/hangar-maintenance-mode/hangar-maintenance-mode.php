<?php
/**
 * Module Name: Hangar - Maintenance Mode
 * Module Description: Easily enable "maintenance mode" while performing various maintenance tasks or developing your website.
 * Module Version: 1.0.2
 * Module Settings: hangar-maintenance-mode
 *
 * @package Hangar
 * @author Patrick
 * @since 1.0.0
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 /* Instantiate Maintenance Mode */
 if ( class_exists( 'Hangar' ) ) {
 	require_once( 'classes/class-hangar-maintenance-mode.php' );
 	$hangar_maintenance_mode = new Hangar_Maintenance_Mode( __FILE__ );
 }
?>