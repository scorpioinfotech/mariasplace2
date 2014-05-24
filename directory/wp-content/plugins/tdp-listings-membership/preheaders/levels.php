<?php
	//is there a default level to redirect to?	
	if(defined("TDP_DEFAULT_LEVEL"))
		$default_level = intval(TDP_DEFAULT_LEVEL);
	else
		$default_level = false;
		
	if($default_level)
	{
		wp_redirect(tdp_url("checkout", "?level=" . $default_level));
		exit;
	}
	
	global $wpdb, $tdp_msg, $tdp_msgt;
	if (isset($_REQUEST['msg']))
	{
		if ($_REQUEST['msg']==1)
		{
			$tdp_msg = __('Your membership status has been updated - Thank you!', 'tdp');
		}
		else
		{
			$tdp_msg = __('Sorry, your request could not be completed - please try again in a few moments.', 'tdp');
			$tdp_msgt = "tdp_error";
		}
	}
	else
	{
		$tdp_msg = false;
	}
	
	global $tdp_levels;
	$tdp_levels = tdp_getAllLevels();	
	$tdp_levels = apply_filters("tdp_levels_array", $tdp_levels);