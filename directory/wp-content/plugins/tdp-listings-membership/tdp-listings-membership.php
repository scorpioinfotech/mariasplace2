<?php
/*
Plugin Name: TDP Listings & Membership
Plugin URI: http://themesdepot.org
Description: The Listings & Membership plugin allows you to create, edit and delete listings from the frontend. The membership system included within the plugin allows you to create different membership levels needed to submit from the frontend.
Version: 1.2
Author: ThemesDepot
Author URI: http://themesdepot.org
*/
/*
	Copyright 2011	Stranger Studios - Modified 2013 ThemesDepot
	The plugin has been modifed to work with the ThemesDepot listings themes.
	Please do not attempt to use this plugin without using a listing theme from themesdepot.
	It won't work.
*/

//if the session has been started yet, start it (ignore if running from command line)
if(defined('STDIN') )
{
	//command line
}
else
{
	if(!session_id())
		session_start();
}

/*
	Includes
*/
define("TDP_DIR", dirname(__FILE__));
require_once(TDP_DIR . "/includes/localization.php");			//localization functions
require_once(TDP_DIR . "/includes/lib/name-parser.php");		//parses "Jason Coleman" into firstname=>Jason, lastname=>Coleman
require_once(TDP_DIR . "/includes/functions.php");			//misc functions used by the plugin
require_once(TDP_DIR . "/includes/upgradecheck.php");			//database and other updates

require_once(TDP_DIR . "/scheduled/crons.php");				//crons for expiring members, sending expiration emails, etc

//require_once(TDP_DIR . "/classes/class.tdpgateway.php");	//loaded by memberorder class when needed
require_once(TDP_DIR . "/classes/class.memberorder.php");		//class to process and save orders
require_once(TDP_DIR . "/classes/class.tdpemail.php");		//setup and filter emails sent by TDp

require_once(TDP_DIR . "/includes/filters.php");				//filters, hacks, etc, moved into the plugin
require_once(TDP_DIR . "/includes/reports.php");				//load reports for admin (reports may also include tracking code, etc)
require_once(TDP_DIR . "/includes/adminpages.php");			//dashboard pages
require_once(TDP_DIR . "/includes/services.php");				//services loaded by AJAX and via webhook, etc
//require_once(TDP_DIR . "/includes/metaboxes.php");			//metaboxes for dashboard
require_once(TDP_DIR . "/includes/profile.php");				//edit user/profile fields
require_once(TDP_DIR . "/includes/https.php");				//code related to HTTPS/SSL
//require_once(TDP_DIR . "/includes/notifications.php");		//check for notifications at TDp, shown in TDp settings
require_once(TDP_DIR . "/includes/init.php");					//code run during init, set_current_user, and wp hooks
require_once(TDP_DIR . "/includes/content.php");				//code to check for memebrship and protect content
require_once(TDP_DIR . "/includes/email.php");				//code related to email
require_once(TDP_DIR . "/includes/recaptcha.php");			//load recaptcha files if needed
require_once(TDP_DIR . "/includes/cleanup.php");				//clean things up when deletes happen, etc.
require_once(TDP_DIR . "/includes/login.php");				//code to redirect away from login/register page

require_once(TDP_DIR . "/shortcodes/checkout.php");			//[tdp_checkout] shortcode for checkout pages
require_once(TDP_DIR . "/shortcodes/checkout_button.php");	//[checkout_button] shortcode to show link to checkout for a level
require_once(TDP_DIR . "/shortcodes/membership.php");			//[membership] shortcode to hide/show member content

/*
	Setup the DB and check for upgrades
*/
global $wpdb;

//check if the DB needs to be upgraded
if(is_admin())
	tdp_checkForUpgrades();

/*
	Definitions
*/
define("SITENAME", str_replace("&#039;", "'", get_bloginfo("name")));
$urlparts = explode("//", home_url());
define("SITEURL", $urlparts[1]);
define("SECUREURL", str_replace("http://", "https://", get_bloginfo("wpurl")));
define("TDP_URL", WP_PLUGIN_URL . "/tdp-listings-membership");
define("TDP_VERSION", "1.7.2.1");
define("TDP_DOMAIN", tdp_getDomainFromURL(site_url()));

/*
	Globals
*/
global $gateway_environment;
$gateway_environment = tdp_getOption("gateway_environment");

//when checking levels for users, we save the info here for caching. each key is a user id for level object for that user.
global $all_membership_levels; 

//we sometimes refer to this array of levels
global $membership_levels;
$membership_levels = $wpdb->get_results( "SELECT * FROM {$wpdb->tdp_membership_levels}", OBJECT );

/*
	Activation/Deactivation
*/
function tdp_activation()
{
	wp_schedule_event(time(), 'daily', 'tdp_cron_expiration_warnings');
	//wp_schedule_event(time(), 'daily', 'tdp_cron_trial_ending_warnings');		//this warning has been deprecated since 1.7.2
	wp_schedule_event(time(), 'daily', 'tdp_cron_expire_memberships');
	wp_schedule_event(time(), 'monthly', 'tdp_cron_credit_card_expiring_warnings');
}
function tdp_deactivation()
{
	wp_clear_scheduled_hook('tdp_cron_expiration_warnings');
	wp_clear_scheduled_hook('tdp_cron_trial_ending_warnings');
	wp_clear_scheduled_hook('tdp_cron_expire_memberships');
	wp_clear_scheduled_hook('tdp_cron_credit_card_expiring_warnings');
}
register_activation_hook(__FILE__, 'tdp_activation');
register_deactivation_hook(__FILE__, 'tdp_deactivation');