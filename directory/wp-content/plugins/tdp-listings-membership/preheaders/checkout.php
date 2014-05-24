<?php
	global $post, $gateway, $wpdb, $besecure, $discount_code, $tdp_level, $tdp_levels, $tdp_msg, $tdp_msgt, $tdp_review, $skip_account_fields, $tdp_paypal_token, $tdp_show_discount_code, $tdp_error_fields, $tdp_required_billing_fields, $tdp_required_user_fields, $wp_version;	
	
	//this var stores fields with errors so we can make them red on the frontend
	$tdp_error_fields = array();			
	
	//blank array for required fields, set below
	$tdp_required_billing_fields = array();
	$tdp_required_user_fields = array();
		
	//was a gateway passed?
	if(!empty($_REQUEST['gateway']))
		$gateway = $_REQUEST['gateway'];
	elseif(!empty($_REQUEST['review']))
		$gateway = "paypalexpress";
	else
		$gateway = tdp_getOption("gateway");			
		
	//set valid gateways - the active gateway in the settings and any gateway added through the filter will be allowed
	if(tdp_getOption("gateway", true) == "paypal")
		$valid_gateways = apply_filters("tdp_valid_gateways", array("paypal", "paypalexpress"));
	else
		$valid_gateways = apply_filters("tdp_valid_gateways", array(tdp_getOption("gateway", true)));
		
	//let's add an error now, if an invalid gateway is set
	if(!in_array($gateway, $valid_gateways))
	{	
		$tdp_msg = __("Invalid gateway.", 'tdp');
		$tdp_msgt = "tdp_error";
	}	
	
	//what level are they purchasing? (discount code passed)
	if(!empty($_REQUEST['level']) && !empty($_REQUEST['discount_code']))
	{
		$discount_code = preg_replace("/[^A-Za-z0-9]/", "", $_REQUEST['discount_code']);
		$discount_code_id = $wpdb->get_var("SELECT id FROM $wpdb->tdp_discount_codes WHERE code = '" . $discount_code . "' LIMIT 1");
		
		//check code
		$code_check = tdp_checkDiscountCode($discount_code, (int)$_REQUEST['level'], true);		
		if($code_check[0] == false)
		{
			//error
			$tdp_msg = $code_check[1];
			$tdp_msgt = "tdp_error";
			
			//don't use this code
			$use_discount_code = false;
		}
		else
		{			
			$sqlQuery = "SELECT l.id, cl.*, l.name, l.description, l.allow_signups FROM $wpdb->tdp_discount_codes_levels cl LEFT JOIN $wpdb->tdp_membership_levels l ON cl.level_id = l.id LEFT JOIN $wpdb->tdp_discount_codes dc ON dc.id = cl.code_id WHERE dc.code = '" . $discount_code . "' AND cl.level_id = '" . (int)$_REQUEST['level'] . "' LIMIT 1";			
			$tdp_level = $wpdb->get_row($sqlQuery);
			
			//if the discount code doesn't adjust the level, let's just get the straight level
			if(empty($tdp_level))
				$tdp_level = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_levels WHERE id = '" . (int)$_REQUEST['level'] . "' LIMIT 1");

			//filter adjustments to the level
			$tdp_level->code_id = $discount_code_id;
			$tdp_level = apply_filters("tdp_discount_code_level", $tdp_level, $discount_code_id);
			
			$use_discount_code = true;
		}	
	}
		
	//what level are they purchasing? (no discount code)
	if(empty($tdp_level) && !empty($_REQUEST['level']))
	{
		$tdp_level = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_levels WHERE id = '" . esc_sql($_REQUEST['level']) . "' AND allow_signups = 1 LIMIT 1");	
	}
	elseif(empty($tdp_level))
	{
		//check if a level is defined in custom fields
		$default_level = get_post_meta($post->ID, "tdp_default_level", true);
		if(!empty($default_level))
		{
			$tdp_level = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_levels WHERE id = '" . esc_sql($default_level) . "' AND allow_signups = 1 LIMIT 1");	
		}
	}
	
	//filter the level (for upgrades, etc)
	$tdp_level = apply_filters("tdp_checkout_level", $tdp_level);		
		
	if(empty($tdp_level->id))
	{
		wp_redirect(tdp_url("levels"));
		exit(0);
	}		
		
	global $wpdb, $current_user, $tdp_requirebilling;	
	//unless we're submitting a form, let's try to figure out if https should be used
	
	if(!tdp_isLevelFree($tdp_level) && $gateway != "check")
	{
		//require billing and ssl
		$pagetitle = __("Checkout: Payment Information", 'tdp');
		$tdp_requirebilling = true;
		$besecure = tdp_getOption("use_ssl");
		/*
		if($gateway != "paypalexpress" || (!empty($_REQUEST['gateway']) && $_REQUEST['gateway'] != "paypalexpress"))
			$besecure = true;			
		else
			$besecure = false;				
		*/
	}
	else
	{
		//no payment so we don't need ssl
		$pagetitle = __("Setup Your Account", 'tdp');
		$tdp_requirebilling = false;
		$besecure = false;		
	}
	
	//in case a discount code was used or something else made the level free, but we're already over ssl
	if(!$besecure && !empty($_REQUEST['submit-checkout']) && is_ssl())
		$besecure = true;	//be secure anyway since we're already checking out
	
	//code for stripe (unless the level is free)
	if($gateway == "stripe" && !tdp_isLevelFree($tdp_level))
	{
		//stripe js library
		wp_enqueue_script("stripe", "https://js.stripe.com/v1/", array(), NULL);
		
		//stripe js code for checkout
		function tdp_stripe_javascript()
		{
		?>
		<script type="text/javascript">
			// this identifies your website in the createToken call below			
			Stripe.setPublishableKey('<?php echo tdp_getOption("stripe_publishablekey"); ?>');
			
			var tdp_require_billing = true;
												
			jQuery(document).ready(function() {
				jQuery("#tdp_form, .tdp_form").submit(function(event) {
								
				//double check in case a discount code made the level free				
				if(tdp_require_billing)
				{
					Stripe.createToken({
						number: jQuery('#AccountNumber').val(),
						cvc: jQuery('#CVV').val(),
						exp_month: jQuery('#ExpirationMonth').val(),
						exp_year: jQuery('#ExpirationYear').val(),
						name: jQuery.trim(jQuery('#bfirstname').val() + ' ' + jQuery('#blastname').val())					
						<?php
							$tdp_stripe_verify_address = apply_filters("tdp_stripe_verify_address", true);
							if(!empty($tdp_stripe_verify_address))
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
				}
				else
					return true;	//not using Stripe anymore
				});
			});

			function stripeResponseHandler(status, response) {
				if (response.error) {
					// re-enable the submit button
                    jQuery('.tdp_btn-submit-checkout').removeAttr("disabled");

					//hide processing message
					jQuery('#tdp_processing_message').css('visibility', 'hidden');
					
					// show the errors on the form
					alert(response.error.message);
					jQuery(".payment-errors").text(response.error.message);
				} else {
					var form$ = jQuery("#tdp_form, .tdp_form");					
					// token contains id, last4, and card type
					var token = response['id'];					
					// insert the token into the form so it gets submitted to the server
					form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
										
					//insert fields for other card fields
					form$.append("<input type='hidden' name='CardType' value='" + response['card']['type'] + "'/>");
					form$.append("<input type='hidden' name='AccountNumber' value='XXXXXXXXXXXXX" + response['card']['last4'] + "'/>");
					form$.append("<input type='hidden' name='ExpirationMonth' value='" + ("0" + response['card']['exp_month']).slice(-2) + "'/>");
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
	
	//code for Braintree
	if($gateway == "braintree")
	{
		//don't require the CVV, but look for cvv (lowercase) that braintree sends
		function tdp_braintree_dont_require_CVV($fields)
		{
			unset($fields['CVV']);	
			$fields['cvv'] = true;
			return $fields;
		}
		add_filter("tdp_required_billing_fields", "tdp_braintree_dont_require_CVV");
	}
		
	//get all levels in case we need them
	global $tdp_levels;
	$tdp_levels = tdp_getAllLevels();	
	
	//should we show the discount code field?
	if($wpdb->get_var("SELECT id FROM $wpdb->tdp_discount_codes LIMIT 1"))
		$tdp_show_discount_code = true;
	else
		$tdp_show_discount_code = false;
	$tdp_show_discount_code = apply_filters("tdp_show_discount_code", $tdp_show_discount_code);
		
	//by default we show the account fields if the user isn't logged in
	if($current_user->ID)
	{
		$skip_account_fields = true;
	}
	else
	{
		$skip_account_fields = false;
	}	
	//in case people want to have an account created automatically
	$skip_account_fields = apply_filters("tdp_skip_account_fields", $skip_account_fields, $current_user);
	
	//some options
	global $tospage;
	$tospage = tdp_getOption("tospage");
	if($tospage)
		$tospage = get_post($tospage);
	
	//load em up (other fields)
	global $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear;
	
	if(isset($_REQUEST['order_id']))
		$order_id = $_REQUEST['order_id'];
	else
		$order_id = "";
	if(isset($_REQUEST['bfirstname']))
		$bfirstname = trim(stripslashes($_REQUEST['bfirstname']));	
	else
		$bfirstname = "";
	if(isset($_REQUEST['blastname']))
		$blastname = trim(stripslashes($_REQUEST['blastname']));	
	else
		$blastname = "";
	if(isset($_REQUEST['fullname']))
		$fullname = $_REQUEST['fullname'];		//honeypot for spammers
	if(isset($_REQUEST['baddress1']))
		$baddress1 = trim(stripslashes($_REQUEST['baddress1']));		
	else
		$baddress1 = "";
	if(isset($_REQUEST['baddress2']))
		$baddress2 = trim(stripslashes($_REQUEST['baddress2']));
	else
		$baddress2 = "";
	if(isset($_REQUEST['bcity']))
		$bcity = trim(stripslashes($_REQUEST['bcity']));
	else
		$bcity = "";
	if(isset($_REQUEST['bstate']))
		$bstate = trim(stripslashes($_REQUEST['bstate']));
	else
		$bstate = "";
	if(isset($_REQUEST['bzipcode']))
		$bzipcode = trim(stripslashes($_REQUEST['bzipcode']));
	else
		$bzipcode = "";
	if(isset($_REQUEST['bcountry']))
		$bcountry = trim(stripslashes($_REQUEST['bcountry']));
	else
		$bcountry = "";
	if(isset($_REQUEST['bphone']))
		$bphone = trim(stripslashes($_REQUEST['bphone']));
	else
		$bphone = "";
	if(isset($_REQUEST['bemail']))
		$bemail = trim(stripslashes($_REQUEST['bemail']));
	else
		$bemail = "";
	if(isset($_REQUEST['bconfirmemail_copy']))
		$bconfirmemail = $bemail;	
	elseif(isset($_REQUEST['bconfirmemail']))
		$bconfirmemail = trim(stripslashes($_REQUEST['bconfirmemail']));
	else
		$bconfirmemail = "";
		
	if(isset($_REQUEST['CardType']) && !empty($_REQUEST['AccountNumber']))
		$CardType = $_REQUEST['CardType'];
	else
		$CardType = "";
	if(isset($_REQUEST['AccountNumber']))
		$AccountNumber = trim($_REQUEST['AccountNumber']);
	else
		$AccountNumber = "";
	if(isset($_REQUEST['ExpirationMonth']))
		$ExpirationMonth = $_REQUEST['ExpirationMonth'];
	else
		$ExpirationMonth = "";
	if(isset($_REQUEST['ExpirationYear']))
		$ExpirationYear = $_REQUEST['ExpirationYear'];
	else
		$ExpirationYear = "";
	if(isset($_REQUEST['CVV']))
		$CVV = trim($_REQUEST['CVV']);
	else
		$CVV = "";
	
	if(isset($_REQUEST['discount_code']))
		$discount_code = trim($_REQUEST['discount_code']);
	else
		$discount_code = "";
	if(isset($_REQUEST['username']))
		$username = trim($_REQUEST['username']);
	else
		$username = "";
	if(isset($_REQUEST['password']))
		$password = $_REQUEST['password'];
	else
		$password = "";
	if(isset($_REQUEST['password2_copy']))
		$password2 = $password;	
	elseif(isset($_REQUEST['password2']))
		$password2 = $_REQUEST['password2'];
	else
		$password2 = "";
	if(isset($_REQUEST['tos']))
		$tos = $_REQUEST['tos'];		
	else
		$tos = "";
	
	//for stripe, load up token values
	if(isset($_REQUEST['stripeToken']))
	{
		$stripeToken = $_REQUEST['stripeToken'];				
	}
	
	//for Braintree, load up values
	if(isset($_REQUEST['number']) && isset($_REQUEST['expiration_date']) && isset($_REQUEST['cvv']))
	{
		$braintree_number = $_REQUEST['number'];
		$braintree_expiration_date = $_REQUEST['expiration_date'];
		$braintree_cvv = $_REQUEST['cvv'];
	}
	
	//_x stuff in case they clicked on the image button with their mouse
	if(isset($_REQUEST['submit-checkout']))
		$submit = $_REQUEST['submit-checkout'];
	if(empty($submit) && isset($_REQUEST['submit-checkout_x']) )
		$submit = $_REQUEST['submit-checkout_x'];	
	if(isset($submit) && $submit === "0") 
		$submit = true;	
	elseif(!isset($submit))
		$submit = false;
	
	//require fields
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
	$tdp_required_billing_fields = apply_filters("tdp_required_billing_fields", $tdp_required_billing_fields);		
	$tdp_required_user_fields = array(
		"username" => $username,
		"password" => $password,
		"password2" => $password2,
		"bemail" => $bemail,
		"bconfirmemail" => $bconfirmemail
	);
	$tdp_required_user_fields = apply_filters("tdp_required_user_fields", $tdp_required_user_fields);
	
	//check their fields if they clicked continue
	if($submit && $tdp_msgt != "tdp_error")
	{		
		//if we're skipping the account fields and there is no user, we need to create a username and password
		if($skip_account_fields && !$current_user->ID)
		{
			$username = tdp_generateUsername($bfirstname, $blastname, $bemail);
			if(empty($username))
				$username = tdp_getDiscountCode();
			$password = tdp_getDiscountCode() . tdp_getDiscountCode();	//using two random discount codes
			$password2 = $password;
		}	
				
		if($tdp_requirebilling && $gateway != "paypalexpress" && $gateway != "paypalstandard")
		{									
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
			foreach($tdp_required_billing_fields as $key => $field)
			{
				if(!$field)
				{																				
					$tdp_error_fields[] = $key;					
				}
			}
		}
		
		//check user fields
		if(empty($current_user->ID))
		{			
			foreach($tdp_required_user_fields as $key => $field)
			{
				if(!$field)
				{																				
					$tdp_error_fields[] = $key;					
				}
			}
		}
			
		if(!empty($tdp_error_fields))
		{			
			tdp_setMessage(__("Please complete all required fields.", "tdp"), "tdp_error");
		}				
		if(!empty($password) && $password != $password2)
		{			
			tdp_setMessage(__("Your passwords do not match. Please try again.", "tdp"), "tdp_error");
			$tdp_error_fields[] = "password";
			$tdp_error_fields[] = "password2";
		}
		if(!empty($bemail) && $bemail != $bconfirmemail)
		{
			tdp_setMessage(__("Your email addresses do not match. Please try again.", "tdp"), "tdp_error");
			$tdp_error_fields[] = "bemail";
			$tdp_error_fields[] = "bconfirmemail";			
		}		
		if(!empty($bemail) && !is_email($bemail))
		{
			tdp_setMessage(__("The email address entered is in an invalid format. Please try again.", "tdp"), "tdp_error");
			$tdp_error_fields[] = "bemail";
			$tdp_error_fields[] = "bconfirmemail";				
		}
		if(!empty($tospage) && empty($tos))
		{
			tdp_setMessage(sprintf(__("Please check the box to agree to the %s.", "tdp"), $tospage->post_title), "tdp_error");
			$tdp_error_fields[] = "tospage";					
		}
		if(!in_array($gateway, $valid_gateways))
		{
			tdp_setMessage(__("Invalid gateway.", "tdp"), "tdp_error");			
		}
		if(!empty($fullname))
		{
			tdp_setMessage(__("Are you a spammer?", "tdp"), "tdp_error");			
		}
		
		if($tdp_msgt == "tdp_error")
			$tdp_continue_registration = false;
		else
			$tdp_continue_registration = true;
		$tdp_continue_registration = apply_filters("tdp_registration_checks", $tdp_continue_registration);
		
		if($tdp_continue_registration)
		{											
			//if creating a new user, check that the email and username are available
			if(empty($current_user->ID))
			{
				$oldusername = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE user_login = '" . esc_sql($username) . "' LIMIT 1");
				$oldemail = $wpdb->get_var("SELECT user_email FROM $wpdb->users WHERE user_email = '" . esc_sql($bemail) . "' LIMIT 1");
				
				//this hook can be used to allow multiple accounts with the same email address
				$oldemail = apply_filters("tdp_checkout_oldemail", $oldemail);
			}
			
			if(!empty($oldusername))
			{
				tdp_setMessage(__("That username is already taken. Please try another.", "tdp"), "tdp_error");
				$tdp_error_fields[] = "username";				
			}
			
			if(!empty($oldemail))
			{
				tdp_setMessage(__("That email address is already taken. Please try another.", "tdp"), "tdp_error");
				$tdp_error_fields[] = "bemail";						
				$tdp_error_fields[] = "bconfirmemail";						
			}
			
			//only continue if there are no other errors yet
			if($tdp_msgt != "tdp_error")
			{								
				//check recaptcha first
				global $recaptcha;
				if(!$skip_account_fields && ($recaptcha == 2 || ($recaptcha == 1 && tdp_isLevelFree($tdp_level))))
				{
					global $recaptcha_privatekey;					
					$resp = recaptcha_check_answer($recaptcha_privatekey,
								$_SERVER["REMOTE_ADDR"],
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);
						
					if(!$resp->is_valid) 
					{
						$tdp_msg = sprintf(__("reCAPTCHA failed. (%s) Please try again.", "tdp"), $resp->error);
						$tdp_msgt = "tdp_error";
					} 
					else 
					{
						// Your code here to handle a successful verification
						if($tdp_msgt != "tdp_error")
							$tdp_msg = "All good!";
					}
				}
				else
				{
					if($tdp_msgt != "tdp_error")
						$tdp_msg = "All good!";										
				}
				
				//no errors yet
				if($tdp_msgt != "tdp_error")
				{				
					//save user fields for PayPal Express
					if($gateway == "paypalexpress" || $gateway == "paypalstandard")
					{
						if(!$current_user->ID)
						{
							$_SESSION['tdp_signup_username'] = $username;
							$_SESSION['tdp_signup_password'] = $password;
							$_SESSION['tdp_signup_email'] = $bemail;							
						}
						
						//can use this hook to save some other variables to the session
						do_action("tdp_paypalexpress_session_vars");							
					}
					
					//special check here now for the "check" gateway
					if($tdp_requirebilling || ($gateway == "check" && !tdp_isLevelFree($tdp_level)))
					{
						$morder = new MemberOrder();			
						$morder->membership_id = $tdp_level->id;
						$morder->membership_name = $tdp_level->name;
						$morder->discount_code = $discount_code;
						$morder->InitialPayment = $tdp_level->initial_payment;
						$morder->PaymentAmount = $tdp_level->billing_amount;
						$morder->ProfileStartDate = date("Y-m-d") . "T0:0:0";
						$morder->BillingPeriod = $tdp_level->cycle_period;
						$morder->BillingFrequency = $tdp_level->cycle_number;
								
						if($tdp_level->billing_limit)
							$morder->TotalBillingCycles = $tdp_level->billing_limit;
					
						if(tdp_isLevelTrial($tdp_level))
						{
							$morder->TrialBillingPeriod = $tdp_level->cycle_period;
							$morder->TrialBillingFrequency = $tdp_level->cycle_number;
							$morder->TrialBillingCycles = $tdp_level->trial_limit;
							$morder->TrialAmount = $tdp_level->trial_amount;
						}
						
						//credit card values
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
						
						//Braintree values
						if(isset($braintree_number))
						{
							$morder->braintree = new stdClass();
							$morder->braintree->number = $braintree_number;
							$morder->braintree->expiration_date = $braintree_expiration_date;
							$morder->braintree->cvv = $braintree_cvv;
						}
						
						//not saving email in order table, but the sites need it
						$morder->Email = $bemail;
						
						//sometimes we need these split up
						$morder->FirstName = $bfirstname;
						$morder->LastName = $blastname;						
						$morder->Address1 = $baddress1;
						$morder->Address2 = $baddress2;						
						
						//stripe lite code to get name from other sources if available
						if(!empty($tdp_stripe_lite) && empty($morder->FirstName) && empty($morder->LastName))
						{
							if(!empty($current_user->ID))
							{									
								$morder->FirstName = get_user_meta($current_user->ID, "first_name", true);
								$morder->LastName = get_user_meta($current_user->ID, "last_name", true);
							}
							elseif(!empty($_REQUEST['first_name']) && !empty($_REQUEST['last_name']))
							{
								$morder->FirstName = $_REQUEST['first_name'];
								$morder->LastName = $_REQUEST['last_name'];
							}
						}
						
						//other values
						$morder->billing = new stdClass();
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
													
						//setup level var
						$morder->getMembershipLevel();
						
						//tax
						$morder->subtotal = $morder->InitialPayment;
						$morder->getTax();						
													
						if($gateway == "paypalexpress")
						{
							$morder->payment_type = "PayPal Express";
							$morder->cardtype = "";
							$morder->ProfileStartDate = date("Y-m-d", strtotime("+ " . $morder->BillingFrequency . " " . $morder->BillingPeriod)) . "T0:0:0";
							$morder->ProfileStartDate = apply_filters("tdp_profile_start_date", $morder->ProfileStartDate, $morder);							
							$tdp_processed = $morder->Gateway->setExpressCheckout($morder);
						}
						else
						{
							$tdp_processed = $morder->process();
						}
													
						if(!empty($tdp_processed))
						{
							$tdp_msg = __("Payment accepted.", "tdp");
							$tdp_msgt = "tdp_success";	
							$tdp_confirmed = true;
						}			
						else
						{																								
							$tdp_msg = $morder->error;
							if(empty($tdp_msg))
								$tdp_msg = __("Unknown error generating account. Please contact us to setup your membership.", "tdp");
							$tdp_msgt = "tdp_error";								
						}	
													
					}		
					else // !$tdp_requirebilling
					{
						//must have been a free membership, continue							
						$tdp_confirmed = true;
					}
				}													
			}
		}	//endif($tdp_continue_registration)		
	}				
		
	//PayPal Express Call Backs
	if(!empty($_REQUEST['review']))
	{	
		if(!empty($_REQUEST['PayerID']))
			$_SESSION['payer_id'] = $_REQUEST['PayerID'];
		if(!empty($_REQUEST['paymentAmount']))
			$_SESSION['paymentAmount'] = $_REQUEST['paymentAmount'];
		if(!empty($_REQUEST['currencyCodeType']))
			$_SESSION['currCodeType'] = $_REQUEST['currencyCodeType'];
		if(!empty($_REQUEST['paymentType']))
			$_SESSION['paymentType'] = $_REQUEST['paymentType'];
		
		$morder = new MemberOrder();
		$morder->getMemberOrderByPayPalToken($_REQUEST['token']);
		$morder->Token = $morder->paypal_token; $tdp_paypal_token = $morder->paypal_token;				
		if($morder->Token)
		{
			if($morder->Gateway->getExpressCheckoutDetails($morder))
			{
				$tdp_review = true;
			}
			else
			{
				$tdp_msg = $morder->error;
				$tdp_msgt = "tdp_error";
			}		
		}
		else
		{
			$tdp_msg = __("The PayPal Token was lost.", "tdp");
			$tdp_msgt = "tdp_error";
		}
	}
	elseif(!empty($_REQUEST['confirm']))
	{		
		$morder = new MemberOrder();
		$morder->getMemberOrderByPayPalToken($_REQUEST['token']);
		$morder->Token = $morder->paypal_token; $tdp_paypal_token = $morder->paypal_token;	
		if($morder->Token)
		{		
			//setup values
			$morder->membership_id = $tdp_level->id;
			$morder->membership_name = $tdp_level->name;
			$morder->discount_code = $discount_code;
			$morder->InitialPayment = $tdp_level->initial_payment;
			$morder->PaymentAmount = $tdp_level->billing_amount;
			$morder->ProfileStartDate = date("Y-m-d") . "T0:0:0";
			$morder->BillingPeriod = $tdp_level->cycle_period;
			$morder->BillingFrequency = $tdp_level->cycle_number;
			$morder->Email = $bemail;
			
			//$gateway = tdp_getOption("gateway");																	
			
			//setup level var
			$morder->getMembershipLevel();			
			
			//tax
			$morder->subtotal = $morder->InitialPayment;
			$morder->getTax();				
			if($tdp_level->billing_limit)
				$morder->TotalBillingCycles = $tdp_level->billing_limit;
		
			if(tdp_isLevelTrial($tdp_level))
			{
				$morder->TrialBillingPeriod = $tdp_level->cycle_period;
				$morder->TrialBillingFrequency = $tdp_level->cycle_number;
				$morder->TrialBillingCycles = $tdp_level->trial_limit;
				$morder->TrialAmount = $tdp_level->trial_amount;
			}
						
			if($morder->process())
			{						
				$submit = true;
				$tdp_confirmed = true;
			
				if(!$current_user->ID)
				{
					//reload the user fields			
					$username = $_SESSION['tdp_signup_username'];
					$password = $_SESSION['tdp_signup_password'];
					$password2 = $password;
					$bemail = $_SESSION['tdp_signup_email'];
					
					//unset the user fields in session
					unset($_SESSION['tdp_signup_username']);
					unset($_SESSION['tdp_signup_password']);
					unset($_SESSION['tdp_signup_email']);
				}
			}
			else
			{								
				$tdp_msg = $morder->error;
				$tdp_msgt = "tdp_error";
			}
		}
		else
		{
			$tdp_msg = __("The PayPal Token was lost.", "tdp");
			$tdp_msgt = "tdp_error";
		}
	}
	
	//if payment was confirmed create/update the user.
	if(!empty($tdp_confirmed))
	{
		//do we need to create a user account?
		if(!$current_user->ID)
		{
			// create user
			if(version_compare($wp_version, "3.1") < 0)
				require_once( ABSPATH . WPINC . '/registration.php');	//need this for WP versions before 3.1
			$user_id = wp_insert_user(array(
							"user_login" => $username,							
							"user_pass" => $password,
							"user_email" => $bemail,
							"first_name" => $bfirstname,
							"last_name" => $blastname)
							);
			if (!$user_id) {
				$tdp_msg = __("Your payment was accepted, but there was an error setting up your account. Please contact us.", "tdp");
				$tdp_msgt = "tdp_error";
			} else {
			
				//check tdp_wp_new_user_notification filter before sending the default WP email
				if(apply_filters("tdp_wp_new_user_notification", true, $user_id, $tdp_level->id))
					wp_new_user_notification($user_id, $password);								
		
				$wpuser = new WP_User(0, $username);
		
				//make the user a subscriber
				$wpuser->set_role(get_option('default_role', 'subscriber'));
									
				//okay, log them in to WP							
				$creds = array();
				$creds['user_login'] = $username;
				$creds['user_password'] = $password;
				$creds['remember'] = true;
				$user = wp_signon( $creds, false );																	
			}
		}
		else
			$user_id = $current_user->ID;	
		
		if($user_id)
		{				
			//save user id and send PayPal standard customers to PayPal now
			if($gateway == "paypalstandard" && !empty($morder))
			{
				$morder->user_id = $user_id;				
				$morder->saveOrder();
				
				//save discount code use
				if(!empty($discount_code_id))
					$wpdb->query("INSERT INTO $wpdb->tdp_discount_codes_uses (code_id, user_id, order_id, timestamp) VALUES('" . $discount_code_id . "', '" . $user_id . "', '" . $morder->id . "', now())");	
				
				do_action("tdp_before_send_to_paypal_standard", $user_id, $morder);
				
				$morder->Gateway->sendToPayPal($morder);
			}
			
			//calculate the end date
			if(!empty($tdp_level->expiration_number))
			{
				$enddate = "'" . date("Y-m-d", strtotime("+ " . $tdp_level->expiration_number . " " . $tdp_level->expiration_period)) . "'";
			}
			else
			{
				$enddate = "NULL";
			}
			
			//update membership_user table.
			if(!empty($discount_code) && !empty($use_discount_code))
				$discount_code_id = $wpdb->get_var("SELECT id FROM $wpdb->tdp_discount_codes WHERE code = '" . $discount_code . "' LIMIT 1");
			else
				$discount_code_id = "";
			
			//set the start date to NOW() but allow filters
			$startdate = apply_filters("tdp_checkout_start_date", "NOW()", $user_id, $tdp_level);
			
			$custom_level = array(
				'user_id' => $user_id,
				'membership_id' => $tdp_level->id,
				'code_id' => $discount_code_id,
				'initial_payment' => $tdp_level->initial_payment,
				'billing_amount' => $tdp_level->billing_amount,
				'cycle_number' => $tdp_level->cycle_number,
				'cycle_period' => $tdp_level->cycle_period,
				'billing_limit' => $tdp_level->billing_limit,
				'trial_amount' => $tdp_level->trial_amount,
				'trial_limit' => $tdp_level->trial_limit,
				'startdate' => $startdate,
				'enddate' => $enddate);

			if(tdp_changeMembershipLevel($custom_level, $user_id))
			{
				//we're good
				//blank order for free levels
				if(empty($morder))
				{					
					$morder = new MemberOrder();						
					$morder->InitialPayment = 0;	
					$morder->Email = $bemail;
					$morder->gateway = "free";					
				}
				
				//add an item to the history table, cancel old subscriptions
				if(!empty($morder))
				{
					$morder->user_id = $user_id;
					$morder->membership_id = $tdp_level->id;					
					$morder->saveOrder();
				}
			
				//update the current user
				global $current_user;
				if(!$current_user->ID && $user->ID)
					$current_user = $user; //in case the user just signed up
				tdp_set_current_user();
			
				//add discount code use				
				if($discount_code && $use_discount_code)
				{
					if(!empty($morder->id))
						$code_order_id = $morder->id;
					else
						$code_order_id = "";
						
					$wpdb->query("INSERT INTO $wpdb->tdp_discount_codes_uses (code_id, user_id, order_id, timestamp) VALUES('" . $discount_code_id . "', '" . $user_id . "', '" . intval($code_order_id) . "', now())");										
				}
			
				//save billing info ect, as user meta																		
				$meta_keys = array("tdp_bfirstname", "tdp_blastname", "tdp_baddress1", "tdp_baddress2", "tdp_bcity", "tdp_bstate", "tdp_bzipcode", "tdp_bcountry", "tdp_bphone", "tdp_bemail", "tdp_CardType", "tdp_AccountNumber", "tdp_ExpirationMonth", "tdp_ExpirationYear");
				$meta_values = array($bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $CardType, hideCardNumber($AccountNumber), $ExpirationMonth, $ExpirationYear);						
				tdp_replaceUserMeta($user_id, $meta_keys, $meta_values);

				//$current_user_membership = $current_user->membership_level;

				//update posts allowance
				//update_usermeta( $user_id, 'allowance_limit', $current_user_membership->posts_limit );
				
				//save first and last name fields
				if(!empty($bfirstname))
				{
					$old_firstname = get_user_meta($user_id, "first_name", true);
					if(empty($old_firstname))
						update_user_meta($user_id, "first_name", $bfirstname);
				}
				if(!empty($blastname))
				{
					$old_lastname = get_user_meta($user_id, "last_name", true);
					if(empty($old_lastname))
						update_user_meta($user_id, "last_name", $blastname);
				}
						
				//show the confirmation
				$ordersaved = true;
				
				//for Stripe, let's save the customer id in user meta
				if($gateway == "stripe")
				{
					if(!empty($morder->Gateway->customer->id))
					{
						update_user_meta($user_id, "tdp_stripe_customerid", $morder->Gateway->customer->id);
					}
				}
								
				//hook
				do_action("tdp_after_checkout", $user_id);						
				
				//setup some values for the emails
				if(!empty($morder))
					$invoice = new MemberOrder($morder->id);						
				else
					$invoice = NULL;
				$current_user->membership_level = $tdp_level;		//make sure they have the right level info
				
				//send email to member
				$tdpemail = new TDpEmail();				
				$tdpemail->sendCheckoutEmail($current_user, $invoice);
												
				//send email to admin
				$tdpemail = new TDpEmail();
				$tdpemail->sendCheckoutAdminEmail($current_user, $invoice);
												
				//redirect to confirmation		
				$rurl = tdp_url("confirmation", "?level=" . $tdp_level->id);
				$rurl = apply_filters("tdp_confirmation_url", $rurl, $user_id, $tdp_level);
				wp_redirect($rurl);
				exit;
			}
			else
			{
				//uh oh. we charged them then the membership creation failed
				if(isset($morder) && $morder->cancel())
				{
					$tdp_msg = __("IMPORTANT: Something went wrong during membership creation. Your credit card authorized, but we cancelled the order immediately. You should not try to submit this form again. Please contact the site owner to fix this issue.", "tdp");
					$morder = NULL;
				}
				else
				{
					$tdp_msg = __("IMPORTANT: Something went wrong during membership creation. Your credit card was charged, but we couldn't assign your membership. You should not submit this form again. Please contact the site owner to fix this issue.", "tdp");
				}
			}
		}
	}	
	
	//default values
	if(empty($submit))
	{
		//show message if the payment gateway is not setup yet
		if($tdp_requirebilling && !tdp_getOption("gateway", true))
		{
			if(tdp_isAdmin())			
				$tdp_msg = sprintf(__('You must <a href="%s">setup a Payment Gateway</a> before any payments will be processed.', 'tdp'), get_admin_url(NULL, '/admin.php?page=tdp-membershiplevels&view=payment'));
			else
				$tdp_msg = __("A Payment Gateway must be setup before any payments will be processed.", "tdp");
			$tdp_msgt = "";
		}
		
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