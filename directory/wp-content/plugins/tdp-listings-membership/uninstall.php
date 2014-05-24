<?php
/**
 * Leave no trace...
 * Use this file to remove all elements added by plugin, including database table
 */

// exit if uninstall/delete not called
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN'))
    exit();

// otherwise remove pages
$tdp_pages = array(
	'account' => get_option( 'tdp_account_page_id' ),
	'billing' => get_option( 'tdp_billing_page_id' ),
	'cancel' =>get_option( 'tdp_cancel_page_id' ),
	'checkout' => get_option( 'tdp_checkout_page_id' ),
	'confirmation' => get_option( 'tdp_confirmation_page_id' ),
	'invoice' => get_option( 'tdp_invoice_page_id' ),
	'levels' => get_option( 'tdp_levels_page_id' )
);

foreach ( $tdp_pages as $tdp_page_id => $tdp_page ) {
	$shortcode_prefix = 'tdp_';
	$shortcode = '[' . $shortcode_prefix . $tdp_page_id . ']';
	$post = get_post( $tdp_page );

	// If shortcode is found at the beginning of the page content and it is the only content that exists, remove the page
	if ( strpos( $post->post_content, $shortcode ) === 0 && strcmp( $post->post_content, $shortcode ) === 0 )
		wp_delete_post( $post->ID, true ); // Force delete (no trash)
}

// otherwise remove db tables
global $wpdb;

$tables = array(
    'tdp_discount_codes',
    'tdp_discount_codes_levels',
    'tdp_discount_codes_uses',
    'tdp_memberships_categories',
    'tdp_memberships_pages',
    'tdp_memberships_users',
    'tdp_membership_levels',
    'tdp_membership_orders'
);

foreach($tables as $table){
    $delete_table = $wpdb->prefix . $table;
    // setup sql query
    $sql = "DROP TABLE `$delete_table`";
    // run the query
    $wpdb->query($sql);
}

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

//delete options
global $wpdb;
$sqlQuery = "DELETE FROM $wpdb->options WHERE option_name LIKE 'tdp_%'";
$wpdb->query($sqlQuery);
