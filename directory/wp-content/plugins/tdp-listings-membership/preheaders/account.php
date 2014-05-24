<?php
	global $wpdb, $current_user, $tdp_msg, $tdp_msgt;
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
	
	//if no user, redirect to levels page
	if(empty($current_user->ID))
	{		
		$redirect = apply_filters("tdp_account_preheader_no_user_redirect", tdp_url("levels"));
		if($redirect)
		{						
			wp_redirect($redirect);
			exit;
		}
	}
	
	//if no membership level, redirect to levels page
	if(empty($current_user->membership_level->ID))
	{
		$redirect = apply_filters("tdp_account_preheader_redirect", tdp_url("levels"));
		if($redirect)
		{			
			wp_redirect($redirect);
			exit;
		}
	}	
	
	global $tdp_levels;
	$tdp_levels = tdp_getAllLevels();