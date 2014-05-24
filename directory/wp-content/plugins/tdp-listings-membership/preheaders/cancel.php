<?php
	global $besecure;
	$besecure = false;	
	
	global $current_user, $tdp_msg, $tdp_msgt, $tdp_confirm; 
	
	//if they don't have a membership, send them back to the subscription page
	if(empty($current_user->membership_level->ID))
	{
		wp_redirect(tdp_url("levels"));
	}		
	
	if(isset($_REQUEST['confirm']))
		$tdp_confirm = $_REQUEST['confirm'];
	else
		$tdp_confirm = false;
		
	if($tdp_confirm)
	{		
		$old_level_id = $current_user->membership_level->id;
		$worked = tdp_changeMembershipLevel(false, $current_user->ID);						
		if($worked === true)
		{			
			$tdp_msg = __("Your membership has been cancelled.", 'tdp');
			$tdp_msgt = "tdp_success";
			
			//send an email to the member
			$myemail = new TDpEmail();
			$myemail->sendCancelEmail();
			
			//send an email to the admin
			$myemail = new TDpEmail();
			$myemail->sendCancelAdminEmail($current_user, $old_level_id);			
		}
		else
		{
			global $tdp_error;
			$tdp_msg = $tdp_error;
			$tdp_msgt = "tdp_error";			
		}		
	}	