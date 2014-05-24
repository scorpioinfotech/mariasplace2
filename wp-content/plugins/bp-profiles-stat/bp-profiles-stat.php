<?php
/**
 * Plugin Name: BP Profiles Statistics
 * Plugin URI:  http://ovirium.com
 * Description: Display extended statistics about members profiles data, their activity/registration time etc.
 * Author:      slaFFik
 * Version:     1.2.2
 * Author URI:  http://cosydale.com
 * Network:     true
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) die;

// Consts
if(!defined('BPPS_VERSION'))
    define('BPPS_VERSION', '1.2.2');

// On BuddyPress init, so wil not loaded at all without BP
add_action('bp_init', 'bpps_load');
function bpps_load(){
    // Smth I want to see only in wp-admin area
    if ( is_admin() && (is_super_admin() || is_network_admin()) ){
        // The main functionality
        include(dirname(__FILE__) . '/includes/bpps-core.php');

        // include the core
        include(dirname(__FILE__) . '/includes/bpps-admin.php');
        include(dirname(__FILE__) . '/includes/bpps-cssjs.php');

        // i18n support
        load_plugin_textdomain( 'bpps', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
    }
}

?>