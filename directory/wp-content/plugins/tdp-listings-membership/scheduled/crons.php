<?php			
	/*
		Expiring Memberships		
	*/
	add_action("tdp_cron_expire_memberships", "tdp_cron_expire_memberships");		
	function tdp_cron_expire_memberships()
	{
		global $wpdb;
				
		//make sure we only run once a day
		$today = date("Y-m-d");
		
		//look for memberships that expired before today
		$sqlQuery = "SELECT mu.user_id, mu.membership_id, mu.startdate, mu.enddate FROM $wpdb->tdp_memberships_users mu WHERE mu.status = 'active' AND mu.enddate IS NOT NULL AND mu.enddate <> '' AND mu.enddate <> '0000-00-00 00:00:00' AND DATE(mu.enddate) <= '" . $today . "' ORDER BY mu.enddate";
						
		$expired = $wpdb->get_results($sqlQuery);
				
		foreach($expired as $e)
		{						
			//remove their membership
			tdp_changeMembershipLevel(false, $e->user_id);
			
			$send_email = apply_filters("tdp_send_expiration_email", true, $e->user_id);
			if($send_email)
			{
				//send an email
				$tdpemail = new TDpEmail();
				$euser = get_userdata($e->user_id);		
				$tdpemail->sendMembershipExpiredEmail($euser);
				
				printf(__("Membership expired email sent to %s. ", "tdp"), $euser->user_email);				
			}
		}
	}
	
	/*
		Expiration Warning Emails
	*/
	add_action("tdp_cron_expiration_warnings", "tdp_cron_expiration_warnings");
	function tdp_cron_expiration_warnings()
	{	
		global $wpdb;
		
		//make sure we only run once a day
		$today = date("Y-m-d 00:00:00");
		
		$tdp_email_days_before_expiration = apply_filters("tdp_email_days_before_expiration", 7);
				
		//look for memberships that are going to expire within one week (but we haven't emailed them within a week)
		$sqlQuery = "SELECT mu.user_id, mu.membership_id, mu.startdate, mu.enddate FROM $wpdb->tdp_memberships_users mu LEFT JOIN $wpdb->usermeta um ON um.user_id = mu.user_id AND um.meta_key = 'tdp_expiration_notice' WHERE mu.status = 'active' AND mu.enddate IS NOT NULL AND mu.enddate <> '' AND mu.enddate <> '0000-00-00 00:00:00' AND DATE_SUB(mu.enddate, INTERVAL " . $tdp_email_days_before_expiration . " Day) <= '" . $today . "' AND (um.meta_value IS NULL OR DATE_ADD(um.meta_value, INTERVAL " . $tdp_email_days_before_expiration . " Day) <= '" . $today . "') ORDER BY mu.enddate";

		$expiring_soon = $wpdb->get_results($sqlQuery);
				
		foreach($expiring_soon as $e)
		{				
			$send_email = apply_filters("tdp_send_expiration_warning_email", true, $e->user_id);
			if($send_email)
			{
				//send an email
				$tdpemail = new TDpEmail();
				$euser = get_userdata($e->user_id);		
				$tdpemail->sendMembershipExpiringEmail($euser);
				
				printf(__("Membership expiring email sent to %s. ", "tdp"), $euser->user_email);
			}
				
			//update user meta so we don't email them again
			update_user_meta($euser->ID, "tdp_expiration_notice", $today);
		}
	}
	
	/*
		Credit Card Expiring Warnings
	*/
	add_action("tdp_cron_credit_card_expiring_warnings", "tdp_cron_credit_card_expiring_warnings");	
	function tdp_cron_credit_card_expiring_warnings()
	{
		global $wpdb;
		
		$next_month_date = date("Y-m-01", strtotime("+2 months"));
		
		$sqlQuery = "SELECT mu.user_id
						FROM  $wpdb->tdp_memberships_users mu
							LEFT JOIN $wpdb->usermeta um1 ON mu.user_id = um1.user_id
								AND meta_key =  'tdp_ExpirationMonth'
							LEFT JOIN $wpdb->usermeta um2 ON mu.user_id = um2.user_id
								AND um2.meta_key =  'tdp_ExpirationYear'
							LEFT JOIN $wpdb->usermeta um3 ON mu.user_id = um3.user_id
								AND um3.meta_key = 'tdp_credit_card_expiring_warning'
						WHERE mu.status =  'active'
							AND mu.cycle_number >0
							AND CONCAT(um2.meta_value, '-', um1.meta_value, '-01') < '" . $next_month_date . "'
							AND (um3.meta_value IS NULL OR CONCAT(um2.meta_value, '-', um1.meta_value, '-01') <> um3.meta_value)
					";
			
		$cc_expiring_user_ids = $wpdb->get_col($sqlQuery);
				
		if(!empty($cc_expiring_user_ids))
		{
			require_once(ABSPATH . 'wp-includes/pluggable.php');
		
			foreach($cc_expiring_user_ids as $user_id)
			{
				//get user				
				$euser = get_userdata($user_id);		
								
				//make sure their level doesn't have a billing limit that's been reached
				$euser->membership_level = tdp_getMembershipLevelForUser($euser->ID);
				if(!empty($euser->membership_level->billing_limit))
				{
					/*
						There is a billing limit on this level, skip for now. 
						We should figure out how to tell if the limit has been reached
						and if not, email the user about the expiring credit card.
					*/
					continue;
				}
				
				//make sure they are using a credit card type billing method for their current membership level (check the last order)
				$last_order = new MemberOrder();
				$last_order->getLastMemberOrder($euser->ID);				
				if(empty($last_order->accountnumber))
					continue;
				
				//okay send them an email				
				$send_email = apply_filters("tdp_send_credit_card_expiring_email", true, $e->user_id);
				if($send_email)
				{
					//send an email
					$tdpemail = new TDpEmail();					
					$tdpemail->sendCreditCardExpiringEmail($euser);
					
					printf(__("Credit card expiring email sent to %s. ", "tdp"), $euser->user_email);				
				}
					
				//update user meta so we don't email them again
				update_user_meta($euser->ID, "tdp_credit_card_expiring_warning", $euser->tdp_ExpirationYear . "-" . $euser->tdp_ExpirationMonth . "-01");				
			}
		}
	}
	
	/*
		Trial Ending Emails
		Commented out as of version 1.7.2 since this caused issues on some sites
		and doesn't take into account the many "custom trial" solutions that are
		in the wild (e.g. some trials are actually a delay of the subscription start date)
	*/	
	//add_action("tdp_cron_trial_ending_warnings", "tdp_cron_trial_ending_warnings");	
	function tdp_cron_trial_ending_warnings()
	{
		global $wpdb;
				
		//make sure we only run once a day
		$today = date("Y-m-d 00:00:00");
		
		$tdp_email_days_before_trial_end = apply_filters("tdp_email_days_before_trial_end", 7);
		
		//look for memberships with trials ending soon (but we haven't emailed them within a week)
		$sqlQuery = "
		SELECT 
			mu.user_id, mu.membership_id, mu.startdate, mu.cycle_period, mu.trial_limit FROM $wpdb->tdp_memberships_users mu LEFT JOIN $wpdb->usermeta um ON um.user_id = mu.user_id AND um.meta_key = 'tdp_trial_ending_notice' 
		WHERE 
			mu.status = 'active' AND mu.trial_limit IS NOT NULL AND mu.trial_limit > 0 AND
			(
				(cycle_period = 'Day' AND DATE_ADD(mu.startdate, INTERVAL mu.trial_limit Day) <= DATE_ADD('" . $today . "', INTERVAL " . $tdp_email_days_before_trial_end . " Day)) OR
				(cycle_period = 'Week' AND DATE_ADD(mu.startdate, INTERVAL mu.trial_limit Week) <= DATE_ADD('" . $today . "', INTERVAL " . $tdp_email_days_before_trial_end . " Day)) OR
				(cycle_period = 'Month' AND DATE_ADD(mu.startdate, INTERVAL mu.trial_limit Month) <= DATE_ADD('" . $today . "', INTERVAL " . $tdp_email_days_before_trial_end . " Day)) OR
				(cycle_period = 'Year' AND DATE_ADD(mu.startdate, INTERVAL mu.trial_limit Year) <= DATE_ADD('" . $today . "', INTERVAL " . $tdp_email_days_before_trial_end . " Day)) 
			)		
						
			AND (um.meta_value IS NULL OR um.meta_value = '' OR DATE_ADD(um.meta_value, INTERVAL " . $tdp_email_days_before_trial_end . " Day) <= '" . $today . "') 
		ORDER BY mu.startdate";
				
		$trial_ending_soon = $wpdb->get_results($sqlQuery);
		
		foreach($trial_ending_soon as $e)
		{							
			$send_email = apply_filters("tdp_send_trial_ending_email", true, $e->user_id);
			if($send_email)
			{
				//send an email
				$tdpemail = new TDpEmail();
				$euser = get_userdata($e->user_id);		
				$tdpemail->sendTrialEndingEmail($euser);
				
				printf(__("Trial ending email sent to %s. ", "tdp"), $euser->user_email);				
			}
				
			//update user meta so we don't email them again
			update_user_meta($euser->ID, "tdp_trial_ending_notice", $today);
		}
	}
	
	
	
	
	
