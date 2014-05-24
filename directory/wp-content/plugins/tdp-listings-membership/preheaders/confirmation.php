<?php
	global $current_user, $tdp_invoice;
	
	//must be logged in
	if(empty($current_user->ID) || (empty($current_user->membership_level->ID) && tdp_getOption("gateway") != "paypalstandard"))
		wp_redirect(home_url());
	
	//if membership is a paying one, get invoice from DB
	if(!empty($current_user->membership_level) && !tdp_isLevelFree($current_user->membership_level))
	{
		$tdp_invoice = new MemberOrder();
		$tdp_invoice->getLastMemberOrder($current_user->ID, apply_filters("tdp_confirmation_order_status", array("success", "pending")));
	}