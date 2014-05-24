<?php	
	global $wpdb, $current_user, $tdp_msg, $tdp_msgt;
	global $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear;
	
	$gateway = tdp_getOption("gateway");
	
	//need to be secure?
	global $besecure, $show_paypal_link;
	$user_order = new MemberOrder();
	$user_order->getLastMemberOrder();
	if(empty($user_order->gateway))
	{
		//no order
		$besecure = false;
	}
	elseif($user_order->gateway == "paypalexpress")
	{
		$besecure = tdp_getOption("use_ssl");
		//still they might have website payments pro setup				
		if($gateway == "paypal")
		{		
			//$besecure = true;	
		}
		else
		{
			//$besecure = false;
			$show_paypal_link = true;
		}
	}
	else
	{		
		//$besecure = true;			
		$besecure = tdp_getOption("use_ssl");
	}
	
	//code for stripe
	if($gateway == "stripe")
	{
		//stripe js library
		wp_enqueue_script("stripe", "https://js.stripe.com/v1/", array(), "");
		
		//stripe js code for checkout
		function tdp_stripe_javascript()
		{
		?>
		<script type="text/javascript">
			// this identifies your website in the createToken call below
			Stripe.setPublishableKey('<?php echo tdp_getOption("stripe_publishablekey"); ?>');
			jQuery(document).ready(function() {
				jQuery(".tdp_form").submit(function(event) {
				
				Stripe.createToken({
					number: jQuery('#AccountNumber').val(),
					cvc: jQuery('#CVV').val(),
					exp_month: jQuery('#ExpirationMonth').val(),
					exp_year: jQuery('#ExpirationYear').val(),
					name: jQuery.trim(jQuery('#bfirstname').val() + ' ' + jQuery('#blastname').val())
					
					<?php
						$tdp_stripe_verify_address = apply_filters("tdp_stripe_verify_address", true);
						if(!empty($tdp_strip_verify_address))
						{
						?>
						,address_line1: jQuery('#baddress1').val(),
						address_line2: jQuery('#baddress2').val(),
						address_city: jQuery('#bcity').val(),					
						address_state: jQuery('#bstate').val(),					
						address_zip: jQuery('#bzipcode').val(),						
						address_country: jQuery('#bcountry').val()
					<?php
						}
					?>
					
				}, stripeResponseHandler);

				// prevent the form from submitting with the default action
				return false;
				});
			});

			function stripeResponseHandler(status, response) {
				if (response.error) {
					// re-enable the submit button
                    jQuery('.tdp_btn-submit').removeAttr("disabled");
					
					// show the errors on the form
					alert(response.error.message);
					jQuery(".payment-errors").text(response.error.message);
				} else {
					var form$ = jQuery(".tdp_form");					
					// token contains id, last4, and card type
					var token = response['id'];					
					// insert the token into the form so it gets submitted to the server
					form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
										
					//insert fields for other card fields
					form$.append("<input type='hidden' name='CardType' value='" + response['card']['type'] + "'/>");
					form$.append("<input type='hidden' name='AccountNumber' value='XXXXXXXXXXXXX" + response['card']['last4'] + "'/>");
					form$.append("<input type='hidden' name='ExpirationMonth' value='" + response['card']['exp_month'] + "'/>");
					form$.append("<input type='hidden' name='ExpirationYear' value='" + response['card']['exp_year'] + "'/>");							
					
					// and submit
					form$.get(0).submit();
				}
			}
		</script>
		<?php
		}
		add_action("wp_head", "tdp_stripe_javascript");
		
		//don't require the CVV
		function tdp_stripe_dont_require_CVV($fields)
		{
			unset($fields['CVV']);			
			return $fields;
		}
		add_filter("tdp_required_billing_fields", "tdp_stripe_dont_require_CVV");
	}
	
	//_x stuff in case they clicked on the image button with their mouse
	if(isset($_REQUEST['update-billing']))
		$submit = $_REQUEST['update-billing'];
	else
		$submit = false;		
	
	if(!$submit && isset($_REQUEST['update-billing_x']))
		$submit = $_REQUEST['update-billing_x'];	
	
	if($submit === "0") 
		$submit = true;
		
	//check their fields if they clicked continue
	if($submit)
	{		
		//load em up (other fields)	
		if(isset($_REQUEST['bfirstname']))
			$bfirstname = trim(stripslashes($_REQUEST['bfirstname']));	
		if(isset($_REQUEST['blastname']))
			$blastname = trim(stripslashes($_REQUEST['blastname']));	
		if(isset($_REQUEST['fullname']))
			$fullname = $_REQUEST['fullname'];		//honeypot for spammers
		if(isset($_REQUEST['baddress1']))
			$baddress1 = trim(stripslashes($_REQUEST['baddress1']));		
		if(isset($_REQUEST['baddress2']))
			$baddress2 = trim(stripslashes($_REQUEST['baddress2']));
		if(isset($_REQUEST['bcity']))
			$bcity = trim(stripslashes($_REQUEST['bcity']));
		if(isset($_REQUEST['bstate']))
			$bstate = trim(stripslashes($_REQUEST['bstate']));
		if(isset($_REQUEST['bzipcode']))
			$bzipcode = trim(stripslashes($_REQUEST['bzipcode']));
		if(isset($_REQUEST['bcountry']))
			$bcountry = trim(stripslashes($_REQUEST['bcountry']));
		if(isset($_REQUEST['bphone']))
			$bphone = trim(stripslashes($_REQUEST['bphone']));
		if(isset($_REQUEST['bemail']))
			$bemail = trim(stripslashes($_REQUEST['bemail']));
		if(isset($_REQUEST['bconfirmemail']))
				$bconfirmemail = trim(stripslashes($_REQUEST['bconfirmemail']));
		if(isset($_REQUEST['CardType']))
			$CardType = $_REQUEST['CardType'];
		if(isset($_REQUEST['AccountNumber']))
			$AccountNumber = trim($_REQUEST['AccountNumber']);
		if(isset($_REQUEST['ExpirationMonth']))
			$ExpirationMonth = $_REQUEST['ExpirationMonth'];
		if(isset($_REQUEST['ExpirationYear']))
			$ExpirationYear = $_REQUEST['ExpirationYear'];
		if(isset($_REQUEST['CVV']))
			$CVV = trim($_REQUEST['CVV']);
			
		//for stripe, load up token values
		if(isset($_REQUEST['stripeToken']))
		{
			$stripeToken = $_REQUEST['stripeToken'];				
		}	
		
		//avoid warnings for the required fields
		if(!isset($bfirstname))
			$bfirstname = "";
		if(!isset($blastname))
			$blastname = "";
		if(!isset($baddress1))
			$baddress1 = "";
		if(!isset($bcity))
			$bcity = "";
		if(!isset($bstate))
			$bstate = "";
		if(!isset($bzipcode))
			$bzipcode = "";
		if(!isset($bphone))
			$bphone = "";
		if(!isset($bemail))
			$bemail = "";
		if(!isset($bcountry))
			$bcountry = "";
		if(!isset($CardType))
			$CardType = "";
		if(!isset($AccountNumber))
			$AccountNumber = "";
		if(!isset($ExpirationMonth))
			$ExpirationMonth = "";
		if(!isset($ExpirationYear))
			$ExpirationYear = "";
		if(!isset($CVV))
			$CVV = "";		
		
		$tdp_required_billing_fields = array(
			"bfirstname" => $bfirstname,
			"blastname" => $blastname,
			"baddress1" => $baddress1,
			"bcity" => $bcity,
			"bstate" => $bstate,
			"bzipcode" => $bzipcode,
			"bphone" => $bphone,
			"bemail" => $bemail,
			"bcountry" => $bcountry,
			"CardType" => $CardType,
			"AccountNumber" => $AccountNumber,
			"ExpirationMonth" => $ExpirationMonth,
			"ExpirationYear" => $ExpirationYear,
			"CVV" => $CVV
		);
		
		//if using stripe lite, remove some fields from the required array
		$tdp_stripe_lite = apply_filters("tdp_stripe_lite", false);
		if($tdp_stripe_lite && $gateway == "stripe")
		{
			//some fields to remove
			$remove = array('bfirstname', 'blastname', 'baddress1', 'bcity', 'bstate', 'bzipcode', 'bphone', 'bcountry', 'CardType');
			
			//if a user is logged in, don't require bemail either				
			if(!empty($current_user->user_email))
			{
				$remove[] = 'bemail';
				$bemail = $current_user->user_email;
				$bconfirmemail = $bemail;
			}
			
			//remove the fields
			foreach($remove as $field)
				unset($tdp_required_billing_fields[$field]);
		}
		
		//filter
		$tdp_required_billing_fields = apply_filters("tdp_required_billing_fields", $tdp_required_billing_fields);		
		
		foreach($tdp_required_billing_fields as $key => $field)
		{
			if(!$field)
			{																		
				$missing_billing_field = true;										
				break;
			}
		}
		
		if(!empty($missing_billing_field))
		{			
			$tdp_msg = __("Please complete all required fields.", 'tdp');
			$tdp_msgt = "tdp_error";
		}		
		elseif($bemail != $bconfirmemail)
		{
			$tdp_msg = __("Your email addresses do not match. Please try again.", 'tdp');
			$tdp_msgt = "tdp_error";
		}		
		elseif(!is_email($bemail))
		{
			$tdp_msg = __("The email address entered is in an invalid format. Please try again.", 'tdp');	
			$tdp_msgt = "tdp_error";
		}			
		else
		{					
			//all good. update billing info.
			$tdp_msg = __("All good!", 'tdp');
						
			//change this
			$order_id = $wpdb->get_var("SELECT id FROM $wpdb->tdp_membership_orders WHERE user_id = '" . $current_user->ID . "' AND membership_id = '" . $current_user->membership_level->ID . "' AND status = 'success' ORDER BY id DESC LIMIT 1");			
			if($order_id)
			{
				$morder = new MemberOrder($order_id);											
						
				$morder->cardtype = $CardType;
				$morder->accountnumber = $AccountNumber;
				$morder->expirationmonth = $ExpirationMonth;
				$morder->expirationyear = $ExpirationYear;
				$morder->ExpirationDate = $ExpirationMonth . $ExpirationYear;
				$morder->ExpirationDate_YdashM = $ExpirationYear . "-" . $ExpirationMonth;
				$morder->CVV2 = $CVV;
			
				//stripeToken
				if(isset($stripeToken))
					$morder->stripeToken = $stripeToken;
			
				//not saving email in order table, but the sites need it
				$morder->Email = $bemail;
				
				//sometimes we need these split up
				$morder->FirstName = $bfirstname;
				$morder->LastName = $blastname;						
				$morder->Address1 = $baddress1;
				$morder->Address2 = $baddress2;						
				
				//other values
				$morder->billing->name = $bfirstname . " " . $blastname;
				$morder->billing->street = trim($baddress1 . " " . $baddress2);
				$morder->billing->city = $bcity;
				$morder->billing->state = $bstate;
				$morder->billing->country = $bcountry;
				$morder->billing->zip = $bzipcode;
				$morder->billing->phone = $bphone;		
				
				//$gateway = tdp_getOption("gateway");										
				$morder->gateway = $gateway;
				$morder->setGateway();					
								
				$worked = $morder->updateBilling();		

				if($worked)
				{
					//send email to member
					$tdpemail = new TDpEmail();
					$tdpemail->sendBillingEmail($current_user, $morder);	

					//send email to admin
					$tdpemail = new TDpEmail();
					$tdpemail->sendBillingAdminEmail($current_user, $morder);						
				}
			}
			else
				$worked = true;
			
			if($worked)
			{
				//update the user meta too
				$meta_keys = array("tdp_bfirstname", "tdp_blastname", "tdp_baddress1", "tdp_baddress2", "tdp_bcity", "tdp_bstate", "tdp_bzipcode", "tdp_bphone", "tdp_bemail", "tdp_CardType", "tdp_AccountNumber", "tdp_ExpirationMonth", "tdp_ExpirationYear");
				$meta_values = array($bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bphone, $bemail, $CardType, hideCardNumber($AccountNumber), $ExpirationMonth, $ExpirationYear);						
				tdp_replaceUserMeta($current_user->ID, $meta_keys, $meta_values);
				
				//message
				$tdp_msg = sprintf(__('Information updated. <a href="%s">&laquo; back to my account</a>', 'tdp'), tdp_url("account"));
				$tdp_msgt = "tdp_success";								
			}			
			else
			{
				$tdp_msg = $morder->error;
				if(!$tdp_msg)
					$tdp_msg = __("Error updating billing information.", 'tdp');
				$tdp_msgt = "tdp_error";
			}				
		}
	}
	else
	{
		//default values from DB
		$bfirstname = get_user_meta($current_user->ID, "tdp_bfirstname", true);		
		$blastname = get_user_meta($current_user->ID, "tdp_blastname", true);
		$baddress1 = get_user_meta($current_user->ID, "tdp_baddress1", true);
		$baddress2 = get_user_meta($current_user->ID, "tdp_baddress2", true);
		$bcity = get_user_meta($current_user->ID, "tdp_bcity", true);
		$bstate = get_user_meta($current_user->ID, "tdp_bstate", true);
		$bzipcode = get_user_meta($current_user->ID, "tdp_bzipcode", true);
		$bcountry = get_user_meta($current_user->ID, "tdp_bcountry", true);
		$bphone = get_user_meta($current_user->ID, "tdp_bphone", true);
		$bemail = get_user_meta($current_user->ID, "tdp_bemail", true);
		$bconfirmemail = get_user_meta($current_user->ID, "tdp_bconfirmemail", true);
		$CardType = get_user_meta($current_user->ID, "tdp_CardType", true);
		//$AccountNumber = hideCardNumber(get_user_meta($current_user->ID, "tdp_AccountNumber", true), false);
		$ExpirationMonth = get_user_meta($current_user->ID, "tdp_ExpirationMonth", true);
		$ExpirationYear = get_user_meta($current_user->ID, "tdp_ExpirationYear", true);			
	}