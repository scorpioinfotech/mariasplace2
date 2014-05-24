<?php
/*
	Dashboard Menu
*/
function tdp_add_pages()
{
	global $wpdb;

	add_menu_page(__('Memberships', 'tdp'), __('Memberships', 'tdp'), 'manage_options', 'tdp-membershiplevels', 'tdp_membershiplevels', TDP_URL . '/images/menu_users.png');
	add_submenu_page('tdp-membershiplevels', __('Page Settings', 'tdp'), __('Page Settings', 'tdp'), 'manage_options', 'tdp-pagesettings', 'tdp_pagesettings');
	add_submenu_page('tdp-membershiplevels', __('Payment Settings', 'tdp'), __('Payment Settings', 'tdp'), 'manage_options', 'tdp-paymentsettings', 'tdp_paymentsettings');
	add_submenu_page('tdp-membershiplevels', __('Email Settings', 'tdp'), __('Email Settings', 'tdp'), 'manage_options', 'tdp-emailsettings', 'tdp_emailsettings');
	add_submenu_page('tdp-membershiplevels', __('Advanced Settings', 'tdp'), __('Advanced Settings', 'tdp'), 'manage_options', 'tdp-advancedsettings', 'tdp_advancedsettings');
	add_submenu_page('tdp-membershiplevels', __('Members List', 'tdp'), __('Members List', 'tdp'), 'manage_options', 'tdp-memberslist', 'tdp_memberslist');
	//add_submenu_page('tdp-membershiplevels', __('Reports', 'tdp'), __('Reports', 'tdp'), 'manage_options', 'tdp-reports', 'tdp_reports');	
	add_submenu_page('tdp-membershiplevels', __('Transactions', 'tdp'), __('Transactions', 'tdp'), 'manage_options', 'tdp-orders', 'tdp_orders');
	//add_submenu_page('tdp-membershiplevels', __('Discount Codes', 'tdp'), __('Discount Codes', 'tdp'), 'manage_options', 'tdp-discountcodes', 'tdp_discountcodes');		
	
	//rename the automatically added Memberships submenu item
	global $submenu;
	if(!empty($submenu['tdp-membershiplevels']))
	{
		$submenu['tdp-membershiplevels'][0][0] = "Membership Levels";
		$submenu['tdp-membershiplevels'][0][3] = "Membership Levels";
	}
}
add_action('admin_menu', 'tdp_add_pages');

/*
	Admin Bar
*/
function tdp_admin_bar_menu() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-listings-membership',
	'title' => __( 'Memberships', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-membershiplevels') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-membership-levels',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Membership Levels', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-membershiplevels') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-page-settings',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Page Settings', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-pagesettings') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-payment-settings',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Payment Settings', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-paymentsettings') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-email-settings',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Email Settings', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-emailsettings') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-advanced-settings',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Advanced Settings', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-advancedsettings') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-members-list',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Members List', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-memberslist') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-reports',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Reports', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-reports') ) );
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-orders',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Orders', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-orders') ) );
	
	/*
	$wp_admin_bar->add_menu( array(
	'id' => 'tdp-discount-codes',
	'parent' => 'tdp-listings-membership',
	'title' => __( 'Discount Codes', 'tdp'),
	'href' => get_admin_url(NULL, '/admin.php?page=tdp-discountcodes') ) );	
	*/
}
add_action('admin_bar_menu', 'tdp_admin_bar_menu', 1000);

/*
	Functions to load pages from adminpages directory
*/
function tdp_reports()
{
	require_once(TDP_DIR . "/adminpages/reports.php");
}

function tdp_memberslist()
{
	require_once(TDP_DIR . "/adminpages/memberslist.php");
}

function tdp_discountcodes()
{
	require_once(TDP_DIR . "/adminpages/discountcodes.php");
}

function tdp_membershiplevels()
{
	require_once(TDP_DIR . "/adminpages/membershiplevels.php");
}

function tdp_pagesettings()
{
	require_once(TDP_DIR . "/adminpages/pagesettings.php");
}

function tdp_paymentsettings()
{
	require_once(TDP_DIR . "/adminpages/paymentsettings.php");
}

function tdp_emailsettings()
{
	require_once(TDP_DIR . "/adminpages/emailsettings.php");
}

function tdp_advancedsettings()
{
	require_once(TDP_DIR . "/adminpages/advancedsettings.php");
}

function tdp_addons()
{
	require_once(TDP_DIR . "/adminpages/addons.php");
}

function tdp_orders()
{
	require_once(TDP_DIR . "/adminpages/orders.php");
}