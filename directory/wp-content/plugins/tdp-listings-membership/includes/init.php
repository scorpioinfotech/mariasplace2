<?php
/*
	Code that runs on the init, set_current_user, or wp hooks to setup TDp
*/
//init code
function tdp_init()
{
	require_once(TDP_DIR . "/includes/countries.php");
	require_once(TDP_DIR . "/includes/states.php");
	require_once(TDP_DIR . "/includes/currencies.php");

	wp_enqueue_script('ssmemberships_js', plugins_url('js/tdp-listings-membership.js',dirname(__FILE__) ), array('jquery'));

	if(is_admin())
	{
		if(file_exists(get_stylesheet_directory() . "/tdp-listings-membership/css/admin.css"))
			$admin_css = get_stylesheet_directory_uri() . "/tdp-listings-membership/css/admin.css";
		elseif(file_exists(get_template_directory() . "/tdp-listings-membership/admin.css"))
			$admin_css = get_template_directory_uri() . "/tdp-listings-membership/admin.css";
		else
			$admin_css = plugins_url('css/admin.css',dirname(__FILE__) );		
		wp_enqueue_style('tdp_admin', $admin_css, array(), TDP_VERSION, "screen");
	}
	else
	{		
		if(file_exists(get_stylesheet_directory() . "/tdp-listings-membership/css/frontend.css"))
			$frontend_css = get_stylesheet_directory_uri() . "/tdp-listings-membership/css/frontend.css";
		elseif(file_exists(get_template_directory() . "/tdp-listings-membership/frontend.css"))
			$frontend_css = get_template_directory_uri() . "/tdp-listings-membership/frontend.css";
		else
			$frontend_css = plugins_url('css/frontend.css',dirname(__FILE__) );	
		wp_enqueue_style('tdp_frontend', $frontend_css, array(), TDP_VERSION, "screen");
		
		if(file_exists(get_stylesheet_directory() . "/tdp-listings-membership/css/print.css"))
			$print_css = get_stylesheet_directory_uri() . "/tdp-listings-membership/css/print.css";
		elseif(file_exists(get_template_directory() . "/tdp-listings-membership/print.css"))
			$print_css = get_template_directory_uri() . "/tdp-listings-membership/print.css";
		else
			$print_css = plugins_url('css/print.css',dirname(__FILE__) );
		wp_enqueue_style('tdp_print', $print_css, array(), TDP_VERSION, "print");
	}
	
	global $tdp_pages, $tdp_ready, $tdp_currency, $tdp_currency_symbol;
	$tdp_pages = array();
	$tdp_pages["account"] = tdp_getOption("account_page_id");
	$tdp_pages["billing"] = tdp_getOption("billing_page_id");
	$tdp_pages["cancel"] = tdp_getOption("cancel_page_id");
	$tdp_pages["checkout"] = tdp_getOption("checkout_page_id");
	$tdp_pages["confirmation"] = tdp_getOption("confirmation_page_id");
	$tdp_pages["invoice"] = tdp_getOption("invoice_page_id");
	$tdp_pages["levels"] = tdp_getOption("levels_page_id");

	$tdp_ready = tdp_is_ready();

	//set currency
	$tdp_currency = tdp_getOption("currency");
	if(!$tdp_currency)
	{
		global $tdp_default_currency;
		$tdp_currency = $tdp_default_currency;
	}

	//figure out what symbol to show for currency
	if(in_array($tdp_currency, array("USD", "AUD", "BRL", "CAD", "HKD", "MXN", "NZD", "SGD")))
		$tdp_currency_symbol = "&#36;";
	elseif($tdp_currency == "ZAR")
		$tdp_currency_symbol = "R";
	elseif($tdp_currency == "EGP")
		$tdp_currency_symbol = "E&pound;";
	elseif($tdp_currency == "EUR")
		$tdp_currency_symbol = "&euro;";
	elseif($tdp_currency == "GBP")
		$tdp_currency_symbol = "&pound;";
	elseif($tdp_currency == "JPY")
		$tdp_currency_symbol = "&yen;";
	else
		$tdp_currency_symbol = $tdp_currency . " ";	//just use the code			
}
add_action("init", "tdp_init");

//this code runs after $post is set, but before template output
function tdp_wp()
{
	if(!is_admin())
	{
		global $post, $tdp_pages, $tdp_page_name, $tdp_page_id, $tdp_body_classes;		
		
		//run the appropriate preheader function
		foreach($tdp_pages as $tdp_page_name => $tdp_page_id)
		{			
			if($tdp_page_name == "checkout")
			{								
				continue;		//we do the checkout shortcode every time now
			}
				
			if(!empty($post->ID) && $tdp_page_id == $post->ID)
			{
				//preheader
				require_once(TDP_DIR . "/preheaders/" . $tdp_page_name . ".php");
				
				//add class to body
				$tdp_body_classes[] = "tdp-" . str_replace("_", "-", $tdp_page_name);
				
				//shortcode
				function tdp_pages_shortcode($atts, $content=null, $code="")
				{
					global $tdp_page_name;
					ob_start();
					if(file_exists(get_stylesheet_directory() . "/tdp-listings-membership/pages/" . $tdp_page_name . ".php"))
						include(get_stylesheet_directory() . "/tdp-listings-membership/pages/" . $tdp_page_name . ".php");
					else
						include(TDP_DIR . "/pages/" . $tdp_page_name . ".php");
					
					$temp_content = ob_get_contents();
					ob_end_clean();
					return apply_filters("tdp_pages_shortcode_" . $tdp_page_name, $temp_content);
				}
				add_shortcode("tdp_" . $tdp_page_name, "tdp_pages_shortcode");
				break;	//only the first page found gets a shortcode replacement
			}
		}
		
		//make sure you load the preheader for the checkout page. the shortcode for checkout is loaded below		
		if(!empty($post->post_content) && strpos($post->post_content, "[tdp_checkout]") !== false)
		{
			$tdp_body_classes[] = "tdp-checkout";
			require_once(TDP_DIR . "/preheaders/checkout.php");	
		}
	}
}
add_action("wp", "tdp_wp", 1);

/*
	Add TDp page names to the BODY class.
*/
function tdp_body_class($classes)
{
	global $tdp_body_classes;
	
	if(is_array($tdp_body_classes))
		$classes = array_merge($tdp_body_classes, $classes);

	return $classes;
}
add_filter("body_class", "tdp_body_class");

//add membership level to current user object
function tdp_set_current_user()
{
	//this code runs at the beginning of the plugin
	global $current_user, $wpdb;
	get_currentuserinfo();
	$id = intval($current_user->ID);
	if($id)
	{
		$current_user->membership_level = tdp_getMembershipLevelForUser($current_user->ID);
		if(!empty($current_user->membership_level))
		{
			$current_user->membership_level->categories = tdp_getMembershipCategories($current_user->membership_level->ID);
		}
		$current_user->membership_levels = tdp_getMembershipLevelsForUser($current_user->ID);
	}

	//hiding ads?
	$hideads = tdp_getOption("hideads");
	$hideadslevels = tdp_getOption("hideadslevels");
	if(!is_array($hideadslevels))
		$hideadslevels = explode(",", $hideadslevels);
	if($hideads == 1 && tdp_hasMembershipLevel() || $hideads == 2 && tdp_hasMembershipLevel($hideadslevels))
	{
		//disable ads in ezAdsense
		if(class_exists("ezAdSense"))
		{
			global $ezCount, $urCount;
			$ezCount = 100;
			$urCount = 100;
		}
		
		//disable ads in Easy Adsense (newer versions)
		if(class_exists("EzAdSense"))
		{
			global $ezAdSense;
			$ezAdSense->ezCount = 100;
			$ezAdSense->urCount = 100;
		}

		//set a global variable to hide ads
		global $tdp_display_ads;
		$tdp_display_ads = false;
	}
	else
	{
		global $tdp_display_ads;
		$tdp_display_ads = true;
	}

	do_action("tdp_after_set_current_user");
}
add_action('set_current_user', 'tdp_set_current_user');