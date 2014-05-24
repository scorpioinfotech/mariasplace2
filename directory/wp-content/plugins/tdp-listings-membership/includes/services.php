<?php
/*
	Loading a service?
*/
/*
	Note: The applydiscountcode goes through the site_url() instead of admin-ajax to avoid HTTP/HTTPS issues.
*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "applydiscountcode")
{		
	function tdp_applydiscountcode_init()
	{
		require_once(dirname(__FILE__) . "/../services/applydiscountcode.php");	
		exit;
	}
	add_action("init", "tdp_applydiscountcode_init");
}
function tdp_wp_ajax_authnet_silent_post()
{		
	require_once(dirname(__FILE__) . "/../services/authnet-silent-post.php");	
	exit;	
}
add_action('wp_ajax_nopriv_authnet_silent_post', 'tdp_wp_ajax_authnet_silent_post');
add_action('wp_ajax_authnet_silent_post', 'tdp_wp_ajax_authnet_silent_post');
function tdp_wp_ajax_getfile()
{
	require_once(dirname(__FILE__) . "/../services/getfile.php");	
	exit;	
}
add_action('wp_ajax_nopriv_getfile', 'tdp_wp_ajax_getfile');
add_action('wp_ajax_getfile', 'tdp_wp_ajax_getfile');
function tdp_wp_ajax_ipnhandler()
{
	require_once(dirname(__FILE__) . "/../services/ipnhandler.php");	
	exit;	
}
add_action('wp_ajax_nopriv_ipnhandler', 'tdp_wp_ajax_ipnhandler');
add_action('wp_ajax_ipnhandler', 'tdp_wp_ajax_ipnhandler');
function tdp_wp_ajax_stripe_webhook()
{
	require_once(dirname(__FILE__) . "/../services/stripe-webhook.php");	
	exit;	
}
add_action('wp_ajax_nopriv_stripe_webhook', 'tdp_wp_ajax_stripe_webhook');
add_action('wp_ajax_stripe_webhook', 'tdp_wp_ajax_stripe_webhook');
function tdp_wp_ajax_braintree_webhook()
{
	require_once(dirname(__FILE__) . "/../services/braintree-webhook.php");	
	exit;	
}
add_action('wp_ajax_nopriv_braintree_webhook', 'tdp_wp_ajax_braintree_webhook');
add_action('wp_ajax_braintree_webhook', 'tdp_wp_ajax_braintree_webhook');
function tdp_wp_ajax_memberlist_csv()
{
	require_once(dirname(__FILE__) . "/../adminpages/memberslist-csv.php");	
	exit;	
}
add_action('wp_ajax_memberslist_csv', 'tdp_wp_ajax_memberlist_csv');
function tdp_wp_ajax_orders_csv()
{
	require_once(dirname(__FILE__) . "/../adminpages/orders-csv.php");	
	exit;	
}
add_action('wp_ajax_orders_csv', 'tdp_wp_ajax_orders_csv');