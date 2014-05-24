<?php
	global $current_user, $tdp_invoice;
	
	if(!is_user_logged_in())
	{
		wp_redirect(tdp_url("account"));
		exit;
	}
	
	//get invoice from DB
	if(!empty($_REQUEST['invoice']))
		$invoice_code = $_REQUEST['invoice'];
	else
		$invoice_code = NULL;
	
	if(!empty($invoice_code))	
	{
		$tdp_invoice = new MemberOrder($invoice_code);
		
		//var_dump($tdp_invoice);
		if(!$tdp_invoice->id)
		{
			wp_redirect(tdp_url("account")); //no match
			exit;
		}
		
		//make sure they have permission to view this
		if(!current_user_can("administrator") && $current_user->ID != $tdp_invoice->user_id)
		{
			wp_redirect(tdp_url("account")); //no permission
			exit;
		}
	}