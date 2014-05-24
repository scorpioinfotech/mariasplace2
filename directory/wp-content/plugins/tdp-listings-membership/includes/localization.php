<?php
function tdp_load_textdomain()
{
    //get the locale
	$locale = apply_filters("plugin_locale", get_locale(), "tdp");
	$mofile = "tdp-" . $locale . ".mo";	
	
	//paths to local (plugin) and global (WP) language files
	$mofile_local  = dirname(__FILE__)."/../languages/" . $mofile;
	$mofile_global = WP_LANG_DIR . '/tdp/' . $mofile;
	
	//load global first
    load_textdomain("tdp", $mofile_global);

	//load local second
	load_textdomain("tdp", $mofile_local);	
}
add_action("init", "tdp_load_textdomain", 1);

function tdp_translate_billing_period($period, $number = 1)
{
	if($period == "Day")
		return _n("Day", "Days", $number, "tdp");
	elseif($period == "Week")
		return _n("Week", "Weeks", $number, "tdp");
	elseif($period == "Month")
		return _n("Month", "Months", $number, "tdp");
	elseif($period == "Year")
		return _n("Year", "Years", $number, "tdp");	
}