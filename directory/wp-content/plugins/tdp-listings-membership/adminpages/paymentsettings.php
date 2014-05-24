<?php
	//only admins can get this
	if(!function_exists("current_user_can") || (!current_user_can("manage_options") && !current_user_can("tdp_paymentsettings")))
	{
		die(__("You do not have permissions to perform this action.", "tdp"));
	}	
	
	global $wpdb, $tdp_currency_symbol, $msg, $msgt;
	
	//get/set settings	
	if(!empty($_REQUEST['savesettings']))
	{                   
		tdp_setOption("sslseal");
		tdp_setOption("nuclear_HTTPS");
			
		//gateway options
		tdp_setOption("gateway");					
		tdp_setOption("gateway_environment");
		tdp_setOption("gateway_email");
		tdp_setOption("payflow_partner");
		tdp_setOption("payflow_vendor");
		tdp_setOption("payflow_user");
		tdp_setOption("payflow_pwd");
		tdp_setOption("apiusername");
		tdp_setOption("apipassword");
		tdp_setOption("apisignature");
		tdp_setOption("loginname");
		tdp_setOption("transactionkey");
		tdp_setOption("stripe_secretkey");
		tdp_setOption("stripe_publishablekey");
		tdp_setOption("braintree_merchantid");
		tdp_setOption("braintree_publickey");
		tdp_setOption("braintree_privatekey");
		tdp_setOption("braintree_encryptionkey");
		
		//currency
		$currency_paypal = $_POST['currency_paypal'];
		$currency_stripe = $_POST['currency_stripe'];
		$currency_fixed = $_POST['currency_fixed'];

		if($_POST['gateway'] == "authorizenet" || $_POST['gateway'] == "payflowpro")
			tdp_setOption("currency", $currency_fixed);
		elseif($_POST['gateway'] == "stripe")
			tdp_setOption("currency", $currency_stripe);
		else
			tdp_setOption("currency", $currency_paypal);
			
		//credit cards
		$tdp_accepted_credit_cards = array();
		if(!empty($_REQUEST['creditcards_visa']))
			$tdp_accepted_credit_cards[] = "Visa";
		if(!empty($_REQUEST['creditcards_mastercard']))
			$tdp_accepted_credit_cards[] = "Mastercard";
		if(!empty($_REQUEST['creditcards_amex']))
			$tdp_accepted_credit_cards[] = "American Express";
		if(!empty($_REQUEST['creditcards_discover']))
			$tdp_accepted_credit_cards[] = "Discover";
		if(!empty($_REQUEST['creditcards_dinersclub']))
			$tdp_accepted_credit_cards[] = "Diners Club";
		if(!empty($_REQUEST['creditcards_enroute']))
			$tdp_accepted_credit_cards[] = "EnRoute";
		if(!empty($_REQUEST['creditcards_jcb']))
			$tdp_accepted_credit_cards[] = "JCB";
		
		//check instructions
		tdp_setOption("instructions");
		
		//use_ssl is based on gateway
		if($_REQUEST['gateway'] == "paypal" || $_REQUEST['gateway'] == "authorizenet" || $_REQUEST['gateway'] == "payflowpro")
			tdp_setOption("use_ssl", 1);			
		else
			tdp_setOption("use_ssl");				
		
		//tax
		tdp_setOption("tax_state");
		tdp_setOption("tax_rate");
		
		tdp_setOption("accepted_credit_cards", implode(",", $tdp_accepted_credit_cards));	

		//assume success
		$msg = true;
		$msgt = __("Your payment settings have been updated.", "tdp");			
	}
	
	$sslseal = tdp_getOption("sslseal");
	$nuclear_HTTPS = tdp_getOption("nuclear_HTTPS");
	
	$gateway = tdp_getOption("gateway");
	$gateway_environment = tdp_getOption("gateway_environment");
	$gateway_email = tdp_getOption("gateway_email");
	$payflow_partner = tdp_getOption("payflow_partner");
	$payflow_vendor = tdp_getOption("payflow_vendor");
	$payflow_user = tdp_getOption("payflow_user");
	$payflow_pwd = tdp_getOption("payflow_pwd");
	$apiusername = tdp_getOption("apiusername");
	$apipassword = tdp_getOption("apipassword");
	$apisignature = tdp_getOption("apisignature");
	$loginname = tdp_getOption("loginname");
	$transactionkey = tdp_getOption("transactionkey");
	$stripe_secretkey = tdp_getOption("stripe_secretkey");
	$stripe_publishablekey = tdp_getOption("stripe_publishablekey");		
	$braintree_merchantid = tdp_getOption("braintree_merchantid");
	$braintree_publickey = tdp_getOption("braintree_publickey");
	$braintree_privatekey = tdp_getOption("braintree_privatekey");
	$braintree_encryptionkey = tdp_getOption("braintree_encryptionkey");
	
	$currency = tdp_getOption("currency");
	
	$tdp_accepted_credit_cards = tdp_getOption("accepted_credit_cards");
	
	$instructions = tdp_getOption("instructions");
	
	$tax_state = tdp_getOption("tax_state");
	$tax_rate = tdp_getOption("tax_rate");		
	
	//make sure the tax rate is not > 1
	if((double)$tax_rate > 1)
	{
		//assume the entered X%
		$tax_rate = $tax_rate / 100;
		tdp_setOption("tax_rate", $tax_rate);
	}
	
	$use_ssl = tdp_getOption("use_ssl");	
	
	//default settings			
	if(empty($gateway_environment))
	{
		$gateway_environment = "sandbox";
		tdp_setOption("gateway_environment", $gateway_environment);
	}
	if(empty($tdp_accepted_credit_cards))
	{
		$tdp_accepted_credit_cards = "Visa,Mastercard,American Express,Discover";
		tdp_setOption("accepted_credit_cards", $tdp_accepted_credit_cards);		
	}
	
	$tdp_accepted_credit_cards = explode(",", $tdp_accepted_credit_cards);
						
	require_once(dirname(__FILE__) . "/admin_header.php");		
?>

	<form action="" method="post" enctype="multipart/form-data">         
		
		<div class="postbox" id="first-box">

				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle newhandle">
					<span>
						<?php _e('Payment Gateway & SSL Settings');?>
					</span>
				</h3>

				<div class="inside">

					<table class="form-table">
						
						<tbody>                		   
							<tr>
								<th scope="row" valign="top">	
									<label for="gateway"><?php _e('Payment Gateway', 'tdp');?>:</label>
								</th>
								<td>
									<select id="gateway" name="gateway" onchange="tdp_changeGateway(jQuery(this).val());">
										<option value="">Testing Only</option>
										<option value="check" <?php if($gateway == "check") { ?>selected="selected"<?php } ?>><?php _e('Pay by Check', 'tdp');?></option>
										<option value="stripe" <?php if($gateway == "stripe") { ?>selected="selected"<?php } ?>>Stripe</option>
										<option value="paypalstandard" <?php if($gateway == "paypalstandard") { ?>selected="selected"<?php } ?>>PayPal Standard</option>
										<!---<option value="paypalexpress" <?php if($gateway == "paypalexpress") { ?>selected="selected"<?php } ?>>PayPal Express</option>
										<option value="paypal" <?php if($gateway == "paypal") { ?>selected="selected"<?php } ?>>PayPal Website Payments Pro</option>
										<option value="payflowpro" <?php if($gateway == "payflowpro") { ?>selected="selected"<?php } ?>>PayPal Payflow Pro/PayPal Advanced</option>
										<option value="authorizenet" <?php if($gateway == "authorizenet") { ?>selected="selected"<?php } ?>>Authorize.net</option>
										<option value="braintree" <?php if($gateway == "braintree") { ?>selected="selected"<?php } ?>>Braintree Payments</option> -->
									</select>                        
								</td>
							</tr> 			
							<tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>				
								<td colspan="2">
									<strong><?php _e('Note', 'tdp');?>:</strong> <?php _e('Payflow Pro currently only supports one-time payments. Users will not be able to checkout for levels with recurring payments.', 'tdp');?>
								</td>
							</tr>
							<tr>
								<th scope="row" valign="top">
									<label for="gateway_environment"><?php _e('Gateway Environment', 'tdp');?>:</label>
								</th>
								<td>
									<select name="gateway_environment">
										<option value="sandbox" <?php if($gateway_environment == "sandbox") { ?>selected="selected"<?php } ?>><?php _e('Sandbox/Testing', 'tdp');?></option>
										<option value="live" <?php if($gateway_environment == "live") { ?>selected="selected"<?php } ?>><?php _e('Live/Production', 'tdp');?></option>
									</select>
									<script>
										function tdp_changeGateway(gateway)
										{							
											//hide all gateway options
											jQuery('tr.gateway').hide();
											jQuery('tr.gateway_'+gateway).show();
										}
										tdp_changeGateway(jQuery('#gateway').val());
									</script>
								</td>
						   </tr>
						   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
							   <th scope="row" valign="top">	
									<label for="payflow_partner"><?php _e('Partner', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="payflow_partner" size="60" value="<?php echo $payflow_partner?>" />
								</td>
						   </tr>
						   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
							   <th scope="row" valign="top">	
									<label for="payflow_vendor"><?php _e('Vendor', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="payflow_vendor" size="60" value="<?php echo $payflow_vendor?>" />
								</td>
						   </tr>
						   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
							   <th scope="row" valign="top">	
									<label for="payflow_user"><?php _e('User', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="payflow_user" size="60" value="<?php echo $payflow_user?>" />
								</td>
						   </tr>
						   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
							   <th scope="row" valign="top">	
									<label for="payflow_pwd"><?php _e('Password', 'tdp');?>:</label>
								</th>
								<td>
									<input type="password" name="payflow_pwd" size="60" value="<?php echo $payflow_pwd?>" />
								</td>
						   </tr>
						   <tr class="gateway gateway_paypal gateway_paypalexpress gateway_paypalstandard" <?php if($gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "paypalstandard") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">	
									<label for="gateway_email"><?php _e('Gateway Account Email', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="gateway_email" size="60" value="<?php echo $gateway_email?>" />
								</td>
							</tr>                
							<tr class="gateway gateway_paypal gateway_paypalexpress" <?php if($gateway != "paypal" && $gateway != "paypalexpress") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="apiusername"><?php _e('API Username', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="apiusername" size="60" value="<?php echo $apiusername?>" />
								</td>
							</tr>
							<tr class="gateway gateway_paypal gateway_paypalexpress" <?php if($gateway != "paypal" && $gateway != "paypalexpress") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="apipassword"><?php _e('API Password', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="apipassword" size="60" value="<?php echo $apipassword?>" />
								</td>
							</tr> 
							<tr class="gateway gateway_paypal gateway_paypalexpress" <?php if($gateway != "paypal" && $gateway != "paypalexpress") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="apisignature"><?php _e('API Signature', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="apisignature" size="60" value="<?php echo $apisignature?>" />
								</td>
							</tr> 
							
							<tr class="gateway gateway_authorizenet" <?php if($gateway != "authorizenet") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="loginname"><?php _e('Login Name', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="loginname" size="60" value="<?php echo $loginname?>" />
								</td>
							</tr>
							<tr class="gateway gateway_authorizenet" <?php if($gateway != "authorizenet") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="transactionkey"><?php _e('Transaction Key', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="transactionkey" size="60" value="<?php echo $transactionkey?>" />
								</td>
							</tr>
							
							<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="stripe_secretkey"><?php _e('Secret Key', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="stripe_secretkey" size="60" value="<?php echo $stripe_secretkey?>" />
								</td>
							</tr>
							<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="stripe_publishablekey"><?php _e('Publishable Key', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="stripe_publishablekey" size="60" value="<?php echo $stripe_publishablekey?>" />
								</td>
							</tr>
							
							<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="braintree_merchantid"><?php _e('Merchant ID', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="braintree_merchantid" size="60" value="<?php echo $braintree_merchantid?>" />
								</td>
							</tr>
							<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="braintree_publickey"><?php _e('Public Key', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="braintree_publickey" size="60" value="<?php echo $braintree_publickey?>" />
								</td>
							</tr>
							<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="braintree_privatekey"><?php _e('Private Key', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="braintree_privatekey" size="60" value="<?php echo $braintree_privatekey?>" />
								</td>
							</tr>
							<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="braintree_encryptionkey"><?php _e('Client-Side Encryption Key', 'tdp');?>:</label>
								</th>
								<td>
									<textarea id="braintree_encryptionkey" name="braintree_encryptionkey" rows="3" cols="80"><?php echo esc_textarea($braintree_encryptionkey)?></textarea>					
								</td>
							</tr>
							
							<tr class="gateway gateway_authorizenet gateway_payflowpro" <?php if($gateway != "authorizenet" && $gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="transactionkey"><?php _e('Currency', 'tdp');?>:</label>
								</th>
								<td>
									<input type="hidden" name="currency_fixed" size="60" value="USD" />
									USD
								</td>
							</tr>						
										
							<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="transactionkey"><?php _e('Currency', 'tdp');?>:</label>
								</th>
								<td>
									<select name="currency_stripe">
									<?php 
										global $tdp_stripe_currencies;
										foreach($tdp_stripe_currencies as $ccode => $cdescription)
										{
										?>
										<option value="<?php echo $ccode?>" <?php if($currency == $ccode) { ?>selected="selected"<?php } ?>><?php echo $cdescription?></option>
										<?php
										}
									?>
									</select>
								</td>
							</tr>
							
							<tr class="gateway gateway_ gateway_paypal gateway_paypalexpress gateway_paypalstandard gateway_braintree gateway_check" <?php if(!empty($gateway) && $gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "paypalstandard" && $gateway != "braintree" && $gateway !== 'check') { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="transactionkey"><?php _e('Currency', 'tdp');?>:</label>
								</th>
								<td>
									<select name="currency_paypal">
									<?php 
										global $tdp_currencies;
										foreach($tdp_currencies as $ccode => $cdescription)
										{
										?>
										<option value="<?php echo $ccode?>" <?php if($currency == $ccode) { ?>selected="selected"<?php } ?>><?php echo $cdescription?></option>
										<?php
										}
									?>
									</select>
								</td>
							</tr>
							
							<tr class="gateway gateway_ gateway_stripe gateway_authorizenet gateway_paypal gateway_payflowpro gateway_braintree" <?php if(!empty($gateway) && $gateway != "authorizenet" && $gateway != "paypal" && $gateway != "stripe" && $gateway != "payflowpro" && $gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="creditcards"><?php _e('Accepted Credit Card Types', 'tdp');?></label>
								</th>
								<td>
									<input type="checkbox" name="creditcards_visa" value="1" <?php if(in_array("Visa", $tdp_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> Visa<br />
									<input type="checkbox" name="creditcards_mastercard" value="1" <?php if(in_array("Mastercard", $tdp_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> Mastercard<br />
									<input type="checkbox" name="creditcards_amex" value="1" <?php if(in_array("American Express", $tdp_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> American Express<br />
									<input type="checkbox" name="creditcards_discover" value="1" <?php if(in_array("Discover", $tdp_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> Discover<br />					
									<input type="checkbox" name="creditcards_dinersclub" value="1" <?php if(in_array("Diners Club", $tdp_accepted_credit_cards)) {?>checked="checked"<?php } ?> /> Diner's Club<br />
									<input type="checkbox" name="creditcards_enroute" value="1" <?php if(in_array("EnRoute", $tdp_accepted_credit_cards)) {?>checked="checked"<?php } ?> /> EnRoute<br />					
									<input type="checkbox" name="creditcards_jcb" value="1" <?php if(in_array("JCB", $tdp_accepted_credit_cards)) {?>checked="checked"<?php } ?> /> JCB<br />
								</td>
							</tr>	
							<tr class="gateway gateway_check" <?php if($gateway != "check") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="instructions"><?php _e('Instructions', 'tdp');?></label>					
								</th>
								<td>
									<textarea id="instructions" name="instructions" rows="3" cols="80"><?php echo esc_textarea($instructions)?></textarea>
									<p><small><?php _e('Who to write the check out to. Where to mail it. Shown on checkout, confirmation, and invoice pages.', 'tdp');?></small></p>
								</td>
							</tr>
							<tr class="gateway gateway_ gateway_stripe gateway_authorizenet gateway_paypal gateway_paypalexpress gateway_check gateway_paypalstandard gateway_payflowpro gateway_braintree" <?php if(!empty($gateway) && $gateway != "stripe" && $gateway != "authorizenet" && $gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "check" && $gateway != "paypalstandard" && $gateway != "payflowpro" && $gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="tax"><?php _e('Sales Tax', 'tdp');?> <small>(<?php _e('optional', 'tdp');?>)</small></label>
								</th>
								<td>
									<?php _e('Tax State', 'tdp');?>:
									<input type="text" name="tax_state" size="4" value="<?php echo $tax_state?>" /> <small>(<?php _e('abbreviation, e.g. "PA"', 'tdp');?>)</small>
									&nbsp; Tax Rate:
									<input type="text" name="tax_rate" size="10" value="<?php echo $tax_rate?>" /> <small>(<?php _e('decimal, e.g. "0.06"', 'tdp');?>)</small>
									<p><small><?php _e('If values are given, tax will be applied for any members ordering from the selected state. For more complex tax rules, use the "tdp_tax" filter.', 'tdp');?></small></p>
								</td>
							</tr>
							<tr class="gateway gateway_ gateway_stripe gateway_paypalexpress gateway_check gateway_paypalstandard gateway_braintree" <?php if(!empty($gateway) && $gateway != "stripe" && $gateway != "paypalexpress" && $gateway != "check" && $gateway != "paypalstandard" && $gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="use_ssl"><?php _e('Use SSL', 'tdp');?>:</label>
								</th>
								<td>
									<select id="use_ssl" name="use_ssl">
										<option value="0" <?php if(empty($use_ssl)) { ?>selected="selected"<?php } ?>><?php _e('No', 'tdp');?></option>
										<option value="1" <?php if(!empty($use_ssl)) { ?>selected="selected"<?php } ?>><?php _e('Yes', 'tdp');?></option>						
									</select>
								</td>
							</tr>
							<tr class="gateway gateway_paypal gateway_authorizenet gateway_payflowpro" <?php if($gateway != "paypal" && $gateway != "authorizenet" && $gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label for="use_ssl"><?php _e('Use SSL', 'tdp');?>:</label>
								</th>
								<td>
									<?php _e('Yes', 'tdp');?>.
									(<?php _e('Required by this Gateway Option', 'tdp');?>)
								</td>
							</tr>
							<tr>
								<th scope="row" valign="top">
									<label for="sslseal"><?php _e('SSL Seal Code', 'tdp');?>:</label>
								</th>
								<td>
									<textarea id="sslseal" name="sslseal" rows="3" cols="80"><?php echo stripslashes($sslseal)?></textarea>
								</td>
						   </tr>		   
						   <tr>
								<th scope="row" valign="top">
									<label for="nuclear_HTTPS"><?php _e('HTTPS Nuclear Option', 'tdp');?>:</label>
								</th>
								<td>
									<input type="checkbox" id="nuclear_HTTPS" name="nuclear_HTTPS" value="1" <?php if(!empty($nuclear_HTTPS)) { ?>checked="checked"<?php } ?> /> <?php _e('Use the "Nuclear Option" to use secure (HTTPS) URLs on your secure pages. Check this if you are using SSL and have warnings on your checkout pages.', 'tdp');?>
								</td>
						   </tr>
						   <tr class="gateway gateway_paypal gateway_paypalexpress gateway_paypalstandard gateway_payflowpro" <?php if($gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "paypalstandard" && $gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label><?php _e('IPN Handler URL', 'tdp');?>:</label>
								</th>
								<td>
									<p><?php _e('To fully integrate with PayPal, be sure to set your IPN Handler URL to ', 'tdp');?> <pre><?php echo admin_url("admin-ajax.php") . "?action=ipnhandler";?></pre>.</p>
								</td>
							</tr>
							<tr class="gateway gateway_authorizenet" <?php if($gateway != "authorizenet") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label><?php _e('Silent Post URL', 'tdp');?>:</label>
								</th>
								<td>
									<p><?php _e('To fully integrate with Authorize.net, be sure to set your Silent Post URL to', 'tdp');?> <pre><?php echo admin_url("admin-ajax.php") . "?action=authnet_silent_post";?></pre>.</p>
								</td>
							</tr>
							<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label><?php _e('Web Hook URL', 'tdp');?>:</label>
								</th>
								<td>
									<p><?php _e('To fully integrate with Stripe, be sure to set your Web Hook URL to', 'tdp');?> <pre><?php echo admin_url("admin-ajax.php") . "?action=stripe_webhook";?></pre>.</p>
								</td>
							</tr>
							<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top">
									<label><?php _e('Web Hook URL', 'tdp');?>:</label>
								</th>
								<td>
									<p>
										<?php _e('To fully integrate with Braintree, be sure to set your Web Hook URL to', 'tdp');?> 
										<pre><?php 
											//echo admin_url("admin-ajax.php") . "?action=braintree_webhook";
											echo TDP_URL . "/services/braintree-webhook.php";
										?></pre>.
									</p>
								</td>
							</tr>
						</tbody>
						</table> 

				</div>


		</div>


		           
		<p class="submit">            
			<input name="savesettings" type="submit" class="button-primary" value="<?php _e('Save Settings', 'tdp');?>" /> 		                			
		</p>             
	</form>
		
<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>
