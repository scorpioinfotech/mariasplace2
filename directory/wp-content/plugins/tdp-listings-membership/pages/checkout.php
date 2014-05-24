<?php		
	global $gateway, $tdp_review, $skip_account_fields, $tdp_paypal_token, $wpdb, $current_user, $tdp_msg, $tdp_msgt, $tdp_requirebilling, $tdp_level, $tdp_levels, $tospage, $tdp_currency_symbol, $tdp_show_discount_code, $tdp_error_fields;
	global $discount_code, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth,$ExpirationYear;	

	//set to true via filter to have Stripe use the minimal billing fields
	$tdp_stripe_lite = apply_filters("tdp_stripe_lite", false);		
?>

<form id="tdp_form" class="tdp_form" action="<?php if(!empty($_REQUEST['review'])) echo tdp_url("checkout", "?level=" . $tdp_level->id); ?>" method="post">

	<input type="hidden" id="level" name="level" value="<?php echo esc_attr($tdp_level->id) ?>" />		

	<div class="tdp-wrap tdp-login ">
		
		<div class="tdp-inner tdp-login-wrapper">

			<div class="tdp-head">

				<div class="tdp-left">

					<div class="tdp-field-name tdp-field-name-wide login-heading" id="login-heading-1">
						<?php _e("Signup now.", "tdp");?>
					</div>

				</div>

				<div class="tdp-right">

					<?php if(count($tdp_levels) > 1) { ?><span class="tdp_thead-msg"><a href="<?php echo tdp_url("levels"); ?>"><?php _e('Change Membership', 'tdp');?></a></span><?php } ?>

				</div>

				<div class="tdp_clear"></div>

			</div>

			<div class="tdp-main">


						<?php if($tdp_msg) 
							{
						?>
							<div id="tdp_message" class="tdp_message <?php echo $tdp_msgt?>"><?php echo $tdp_msg?></div>
						<?php
							}
							else
							{
						?>
							<div id="tdp_message" class="tdp_message" style="display: none;"></div>
						<?php
							}
						?>
						
						<?php if($tdp_review) { ?>
							<p><?php _e('Almost done. Review the membership information and pricing below then <strong>click the "Complete Payment" button</strong> to finish your order.', 'tdp');?></p>
						<?php } ?>

						<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php printf(__('You have selected the <strong>%s</strong> membership.', 'tdp'), $tdp_level->name);?></div>


						<?php
						if(!empty($tdp_level->description))
						echo apply_filters("the_content", stripslashes($tdp_level->description));
						?>

						<br/>
						
						<div id="tdp_level_cost">
							<?php if($discount_code && tdp_checkDiscountCode($discount_code)) { ?>
								<?php printf(__('<p>The <strong>%s</strong> code has been applied to your order.</p>', 'tdp'), $discount_code);?>
							<?php } ?>
							<?php echo wpautop(tdp_getLevelCost($tdp_level)); ?>
							<?php echo wpautop(tdp_getLevelExpiration($tdp_level)); ?>
						</div>
						
						<?php do_action("tdp_checkout_after_level_cost"); ?>				
						
						<?php if($tdp_show_discount_code) { ?>
						
							<?php if($discount_code && !$tdp_review) { ?>
								<p id="other_discount_code_p" class="tdp_small"><a id="other_discount_code_a" href="#discount_code"><?php _e('Click here to change your discount code', 'tdp');?></a>.</p>
							<?php } elseif(!$tdp_review) { ?>
								<p id="other_discount_code_p" class="tdp_small"><?php _e('Do you have a discount code?', 'tdp');?> <a id="other_discount_code_a" href="#discount_code"><?php _e('Click here to enter your discount code', 'tdp');?></a>.</p>
							<?php } elseif($tdp_review && $discount_code) { ?>
								<p><strong><?php _e('Discount Code', 'tdp');?>:</strong> <?php echo $discount_code?></p>
							<?php } ?>
						
						<?php } ?>


						<?php if(!$skip_account_fields && !$tdp_review) { ?>
							<table id="tdp_user_fields" class="tdp_checkout" width="100%" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<th>
										<span class="tdp_thead-msg"><?php _e('Already have an account?', 'tdp');?> <a href="<?php echo get_field('login_page_url','option'); ?>"><?php _e('Log in here', 'tdp');?></a>.</span><?php _e('Account Information', 'tdp');?>
									</th>						
								</tr>
							</thead>
							<tbody>                
								<tr>
									<td>
										<div>
											<label for="username"><?php _e('Username', 'tdp');?></label>
											<input id="username" name="username" type="text" class="input <?php echo tdp_getClassForField("username");?>" size="30" value="<?php echo esc_attr($username)?>" /> 
										</div>
										
										<?php
											do_action('tdp_checkout_after_username');
										?>
										
										<div>
											<label for="password"><?php _e('Password', 'tdp');?></label>
											<input id="password" name="password" type="password" class="input <?php echo tdp_getClassForField("password");?>" size="30" value="<?php echo esc_attr($password)?>" /> 
										</div>
										<?php
											$tdp_checkout_confirm_password = apply_filters("tdp_checkout_confirm_password", true);					
											if($tdp_checkout_confirm_password)
											{
											?>
											<div>
												<label for="password2"><?php _e('Confirm Password', 'tdp');?></label>
												<input id="password2" name="password2" type="password" class="input <?php echo tdp_getClassForField("password2");?>" size="30" value="<?php echo esc_attr($password2)?>" /> 
											</div>
											<?php
											}
											else
											{
											?>
											<input type="hidden" name="password2_copy" value="1" />
											<?php
											}
										?>
										
										<?php
											do_action('tdp_checkout_after_password');
										?>
										
										<div>
											<label for="bemail"><?php _e('E-mail Address', 'tdp');?></label>
											<input id="bemail" name="bemail" type="text" class="input <?php echo tdp_getClassForField("bemail");?>" size="30" value="<?php echo esc_attr($bemail)?>" /> 
										</div>
										<?php
											$tdp_checkout_confirm_email = apply_filters("tdp_checkout_confirm_email", true);					
											if($tdp_checkout_confirm_email)
											{
											?>
											<div>
												<label for="bconfirmemail"><?php _e('Confirm E-mail Address', 'tdp');?></label>
												<input id="bconfirmemail" name="bconfirmemail" type="text" class="input <?php echo tdp_getClassForField("bconfirmemail");?>" size="30" value="<?php echo esc_attr($bconfirmemail)?>" /> 

											</div>	                        
											<?php
											}
											else
											{
											?>
											<input type="hidden" name="bconfirmemail_copy" value="1" />
											<?php
											}
										?>			
										
										<?php
											do_action('tdp_checkout_after_email');
										?>
										
										<div class="tdp_hidden">
											<label for="fullname"><?php _e('Full Name', 'tdp');?></label>
											<input id="fullname" name="fullname" type="text" class="input <?php echo tdp_getClassForField("fullname");?>" size="30" value="" /> <strong><?php _e('LEAVE THIS BLANK', 'tdp');?></strong>
										</div>				

										<div class="tdp_captcha">
										<?php 																								
											global $recaptcha, $recaptcha_publickey;										
											if($recaptcha == 2 || ($recaptcha == 1 && tdp_isLevelFree($tdp_level))) 
											{											
												echo recaptcha_get_html($recaptcha_publickey, NULL, true);						
											}								
										?>								
										</div>
										
										<?php
											do_action('tdp_checkout_after_captcha');
										?>
										
									</td>
								</tr>
							</tbody>
							</table>   
							<?php } elseif($current_user->ID && !$tdp_review) { ?>                        	                       										
								
								<p>
									<?php printf(__('You are logged in as <strong>%s</strong>. If you would like to use a different account for this membership, <a href="%s">log out now</a>.', 'tdp'), $current_user->user_login, wp_logout_url($_SERVER['REQUEST_URI'])); ?>			
								</p>
							<?php } ?>

							<br/>

							<div class="tdp_clear"></div>


							<?php					
								if($tospage && !$tdp_review)
								{						
								?>
								<table id="tdp_tos_fields" class="tdp_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0">
								<thead>
								<tr>
									<th><?php echo $tospage->post_title?></th>
								</tr>
							</thead>
								<tbody>
									<tr class="odd">
										<td>								
											<div id="tdp_license">
						<?php echo wpautop($tospage->post_content)?>
											</div>								
											<input type="checkbox" name="tos" value="1" id="tos" /> <label for="tos"><?php printf(__('I agree to the %s', 'tdp'), $tospage->post_title);?></label>
										</td>
									</tr>
								</tbody>
								</table>
								<?php
								}
							?>
							
							<?php do_action("tdp_checkout_boxes"); ?>	
								
							<?php if(tdp_getOption("gateway", true) == "paypal" && empty($tdp_review)) { ?>
								<table id="tdp_payment_method" class="tdp_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" <?php if(!$tdp_requirebilling) { ?>style="display: none;"<?php } ?>>
								<thead>
									<tr>
										<th><?php _e('Choose your Payment Method', 'tdp');?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div>
												<input type="radio" name="gateway" value="paypal" <?php if(!$gateway || $gateway == "paypal") { ?>checked="checked"<?php } ?> />
													<a href="javascript:void(0);" class="tdp_radio"><?php _e('Check Out with a Credit Card Here', 'tdp');?></a> &nbsp;
												<input type="radio" name="gateway" value="paypalexpress" <?php if($gateway == "paypalexpress") { ?>checked="checked"<?php } ?> />
													<a href="javascript:void(0);" class="tdp_radio"><?php _e('Check Out with PayPal', 'tdp');?></a> &nbsp;					
											</div>
										</td>
									</tr>
								</tbody>
								</table>
							<?php } ?>
							
							<?php if(empty($tdp_stripe_lite) || $gateway != "stripe") { ?>
							<table id="tdp_billing_address_fields" class="tdp_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" <?php if(!$tdp_requirebilling || $gateway == "paypalexpress" || $gateway == "paypalstandard") { ?>style="display: none;"<?php } ?>>
							<thead>
								<tr>
									<th><?php _e('Billing Address', 'tdp');?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div>
											<label for="bfirstname"><?php _e('First Name', 'tdp');?></label>
											<input id="bfirstname" name="bfirstname" type="text" class="input <?php echo tdp_getClassForField("bfirstname");?>" size="30" value="<?php echo esc_attr($bfirstname)?>" /> 
										</div>	
										<div>
											<label for="blastname"><?php _e('Last Name', 'tdp');?></label>
											<input id="blastname" name="blastname" type="text" class="input <?php echo tdp_getClassForField("blastname");?>" size="30" value="<?php echo esc_attr($blastname)?>" /> 
										</div>					
										<div>
											<label for="baddress1"><?php _e('Address 1', 'tdp');?></label>
											<input id="baddress1" name="baddress1" type="text" class="input <?php echo tdp_getClassForField("baddress1");?>" size="30" value="<?php echo esc_attr($baddress1)?>" /> 
										</div>
										<div>
											<label for="baddress2"><?php _e('Address 2', 'tdp');?></label>
											<input id="baddress2" name="baddress2" type="text" class="input <?php echo tdp_getClassForField("baddress2");?>" size="30" value="<?php echo esc_attr($baddress2)?>" />
										</div>
										
										<?php
											$longform_address = apply_filters("tdp_longform_address", false);
											if($longform_address)
											{
										?>
											<div>
												<label for="bcity"><?php _e('City', 'tdp');?></label>
												<input id="bcity" name="bcity" type="text" class="input <?php echo tdp_getClassForField("bcity");?>" size="30" value="<?php echo esc_attr($bcity)?>" /> 
											</div>
											<div>
												<label for="bstate"><?php _e('State', 'tdp');?></label>																
												<input id="bstate" name="bstate" type="text" class="input <?php echo tdp_getClassForField("bcity");?>" size="30" value="<?php echo esc_attr($bstate)?>" /> 					
											</div>
											<div>
												<label for="bzipcode"><?php _e('Postal Code', 'tdp');?></label>
												<input id="bzipcode" name="bzipcode" type="text" class="input <?php echo tdp_getClassForField("bzipcode");?>" size="30" value="<?php echo esc_attr($bzipcode)?>" /> 
											</div>					
										<?php
											}
											else
											{
											?>
											<div>
												<label for="bcity_state_zip"><?php _e('City, State Zip', 'tdp');?></label>
												<input id="bcity" name="bcity" type="text" class="input <?php echo tdp_getClassForField("bcity");?>" size="14" value="<?php echo esc_attr($bcity)?>" />, 
												<?php
													$state_dropdowns = apply_filters("tdp_state_dropdowns", false);							
													if($state_dropdowns === true || $state_dropdowns == "names")
													{
														global $tdp_states;
													?>
													<select name="bstate" class=" <?php echo tdp_getClassForField("bstate");?>">
														<option value="">--</option>
														<?php 									
															foreach($tdp_states as $ab => $st) 
															{ 
														?>
															<option value="<?php echo esc_attr($ab);?>" <?php if($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo $st;?></option>
														<?php } ?>
													</select>
													<?php
													}
													elseif($state_dropdowns == "abbreviations")
													{
														global $tdp_states_abbreviations;
													?>
														<select name="bstate" class=" <?php echo tdp_getClassForField("bstate");?>">
															<option value="">--</option>
															<?php 									
																foreach($tdp_states_abbreviations as $ab) 
																{ 
															?>
																<option value="<?php echo esc_attr($ab);?>" <?php if($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo $ab;?></option>
															<?php } ?>
														</select>
													<?php
													}
													else
													{
													?>	
													<input id="bstate" name="bstate" type="text" class="input <?php echo tdp_getClassForField("bstate");?>" size="2" value="<?php echo esc_attr($bstate)?>" /> 
													<?php
													}
												?>
												<input id="bzipcode" name="bzipcode" type="text" class="input <?php echo tdp_getClassForField("bzipcode");?>" size="5" value="<?php echo esc_attr($bzipcode)?>" /> 
											</div>
											<?php
											}
										?>
										
										<?php
											$show_country = apply_filters("tdp_international_addresses", false);
											if($show_country)
											{
										?>
										<div>
											<label for="bcountry"><?php _e('Country', 'tdp');?></label>
											<select name="bcountry" class=" <?php echo tdp_getClassForField("bcountry");?>">
												<?php
													global $tdp_countries, $tdp_default_country;
													foreach($tdp_countries as $abbr => $country)
													{
														if(!$bcountry)
															$bcountry = $tdp_default_country;
													?>
													<option value="<?php echo $abbr?>" <?php if($abbr == $bcountry) { ?>selected="selected"<?php } ?>><?php echo $country?></option>
													<?php
													}
												?>
											</select>
										</div>
										<?php
											}
											else
											{
											?>
												<input type="hidden" name="bcountry" value="US" />
											<?php
											}
										?>
										<div>
											<label for="bphone"><?php _e('Phone', 'tdp');?></label>
											<input id="bphone" name="bphone" type="text" class="input <?php echo tdp_getClassForField("bphone");?>" size="30" value="<?php echo esc_attr($bphone)?>" /> 
											<?php echo formatPhone($bphone); ?>
										</div>		
										<?php if($skip_account_fields) { ?>
										<?php
											if($current_user->ID)
											{
												if(!$bemail && $current_user->user_email)									
													$bemail = $current_user->user_email;
												if(!$bconfirmemail && $current_user->user_email)									
													$bconfirmemail = $current_user->user_email;									
											}
										?>
										<div>
											<label for="bemail"><?php _e('E-mail Address', 'tdp');?></label>
											<input id="bemail" name="bemail" type="text" class="input <?php echo tdp_getClassForField("bemail");?>" size="30" value="<?php echo esc_attr($bemail)?>" /> 
										</div>
										<?php
											$tdp_checkout_confirm_email = apply_filters("tdp_checkout_confirm_email", true);					
											if($tdp_checkout_confirm_email)
											{
											?>
											<div>
												<label for="bconfirmemail"><?php _e('Confirm E-mail', 'tdp');?></label>
												<input id="bconfirmemail" name="bconfirmemail" type="text" class="input <?php echo tdp_getClassForField("bconfirmemail");?>" size="30" value="<?php echo esc_attr($bconfirmemail)?>" /> 

											</div>	                        
											<?php
												}
												else
												{
											?>
											<input type="hidden" name="bconfirmemail_copy" value="1" />
											<?php
												}
											?>
										<?php } ?>    
									</td>						
								</tr>											
							</tbody>
							</table>                   
							<?php } ?>
							
							<?php do_action("tdp_checkout_after_billing_fields"); ?>		
							
							<?php
								$tdp_accepted_credit_cards = tdp_getOption("accepted_credit_cards");
								$tdp_accepted_credit_cards = explode(",", $tdp_accepted_credit_cards);
								$tdp_accepted_credit_cards_string = tdp_implodeToEnglish($tdp_accepted_credit_cards);	
							?>
							
							<table id="tdp_payment_information_fields" class="tdp_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" <?php if(!$tdp_requirebilling || $gateway == "paypalexpress" || $gateway == "paypalstandard") { ?>style="display: none;"<?php } ?>>
							<thead>
								<tr>
									<th><span class="tdp_thead-msg"><?php printf(__('We Accept %s', 'tdp'), $tdp_accepted_credit_cards_string);?></span><?php _e('Payment Information', 'tdp');?></th>
								</tr>
							</thead>
							<tbody>                    
								<tr valign="top">		
									<td>	
										<?php
											$sslseal = tdp_getOption("sslseal");
											if($sslseal)
											{
											?>
												<div class="tdp_sslseal"><?php echo stripslashes($sslseal)?></div>
											<?php
											}
										?>
										<?php if(empty($tdp_stripe_lite) || $gateway != "stripe") { ?>
										<div>
											<label for="CardType"><?php _e('Card Type', 'tdp');?></label>
											<select id="CardType" <?php if($gateway != "stripe") { ?>name="CardType"<?php } ?> class=" <?php echo tdp_getClassForField("CardType");?>">
												<?php foreach($tdp_accepted_credit_cards as $cc) { ?>
													<option value="<?php echo $cc?>" <?php if($CardType == $cc) { ?>selected="selected"<?php } ?>><?php echo $cc?></option>
												<?php } ?>												
											</select> 
										</div>
										<?php } ?>
									
										<div>
											<label for="AccountNumber"><?php _e('Card Number', 'tdp');?></label>
											<input id="AccountNumber" <?php if($gateway != "stripe" && $gateway != "braintree") { ?>name="AccountNumber"<?php } ?> class="input <?php echo tdp_getClassForField("AccountNumber");?>" type="text" size="25" value="<?php echo esc_attr($AccountNumber)?>" <?php if($gateway == "braintree") { ?>data-encrypted-name="number"<?php } ?> /> 
										</div>
									
										<div>
											<label for="ExpirationMonth"><?php _e('Expiration Date', 'tdp');?></label>
											<select id="ExpirationMonth" <?php if($gateway != "stripe") { ?>name="ExpirationMonth"<?php } ?> class=" <?php echo tdp_getClassForField("ExpirationMonth");?>">
												<option value="01" <?php if($ExpirationMonth == "01") { ?>selected="selected"<?php } ?>>01</option>
												<option value="02" <?php if($ExpirationMonth == "02") { ?>selected="selected"<?php } ?>>02</option>
												<option value="03" <?php if($ExpirationMonth == "03") { ?>selected="selected"<?php } ?>>03</option>
												<option value="04" <?php if($ExpirationMonth == "04") { ?>selected="selected"<?php } ?>>04</option>
												<option value="05" <?php if($ExpirationMonth == "05") { ?>selected="selected"<?php } ?>>05</option>
												<option value="06" <?php if($ExpirationMonth == "06") { ?>selected="selected"<?php } ?>>06</option>
												<option value="07" <?php if($ExpirationMonth == "07") { ?>selected="selected"<?php } ?>>07</option>
												<option value="08" <?php if($ExpirationMonth == "08") { ?>selected="selected"<?php } ?>>08</option>
												<option value="09" <?php if($ExpirationMonth == "09") { ?>selected="selected"<?php } ?>>09</option>
												<option value="10" <?php if($ExpirationMonth == "10") { ?>selected="selected"<?php } ?>>10</option>
												<option value="11" <?php if($ExpirationMonth == "11") { ?>selected="selected"<?php } ?>>11</option>
												<option value="12" <?php if($ExpirationMonth == "12") { ?>selected="selected"<?php } ?>>12</option>
											</select>/<select id="ExpirationYear" <?php if($gateway != "stripe") { ?>name="ExpirationYear"<?php } ?> class=" <?php echo tdp_getClassForField("ExpirationYear");?>">
												<?php
													for($i = date("Y"); $i < date("Y") + 10; $i++)
													{
												?>
													<option value="<?php echo $i?>" <?php if($ExpirationYear == $i) { ?>selected="selected"<?php } ?>><?php echo $i?></option>
												<?php
													}
												?>
											</select> 					
										</div>
									
										<?php
											$tdp_show_cvv = apply_filters("tdp_show_cvv", true);
											if($tdp_show_cvv)
											{
										?>
										<div>
											<label for="CVV"><?php _ex('CVV', 'Credit card security code, CVV/CCV/CVV2', 'tdp');?></label>
											<input class="input" id="CVV" <?php if($gateway != "stripe" && $gateway != "braintree") { ?>name="CVV"<?php } ?> type="text" size="4" value="<?php if(!empty($_REQUEST['CVV'])) { echo esc_attr($_REQUEST['CVV']); }?>" class=" <?php echo tdp_getClassForField("CVV");?>" <?php if($gateway == "braintree") { ?>data-encrypted-name="cvv"<?php } ?> />  <small>(<a href="javascript:void(0);" onclick="javascript:window.open('<?php echo tdp_https_filter(TDP_URL)?>/pages/popup-cvv.html','cvv','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=600, height=475');"><?php _ex("what's this?", 'link to CVV help', 'tdp');?></a>)</small>
										</div>
										<?php
											}
										?>
										
										<?php if($tdp_show_discount_code) { ?>
										<div>
											<label for="discount_code"><?php _e('Discount Code', 'tdp');?></label>
											<input class="input <?php echo tdp_getClassForField("discount_code");?>" id="discount_code" name="discount_code" type="text" size="20" value="<?php echo esc_attr($discount_code)?>" />
											<input type="button" id="discount_code_button" name="discount_code_button" value="<?php _e('Apply', 'tdp');?>" />
											<p id="discount_code_message" class="tdp_message" style="display: none;"></p>
										</div>
										<?php } ?>
										
									</td>			
								</tr>
							</tbody>
							</table>	
							<script>
								//checking a discount code
								jQuery('#discount_code_button').click(function() {
									var code = jQuery('#discount_code').val();
									var level_id = jQuery('#level').val();
																		
									if(code)
									{									
										//hide any previous message
										jQuery('.tdp_discount_code_msg').hide();				
										
										//disable the apply button
										jQuery('#discount_code_button').attr('disabled', 'disabled');
										
										jQuery.ajax({
											url: '<?php echo admin_url()?>',type:'GET',timeout:<?php echo apply_filters("tdp_ajax_timeout", 5000, "applydiscountcode");?>,
											dataType: 'html',
											data: "action=applydiscountcode&code=" + code + "&level=" + level_id + "&msgfield=discount_code_message",
											error: function(xml){
												alert('Error applying discount code [1]');
												
												//enable apply button
												jQuery('#discount_code_button').removeAttr('disabled');
											},
											success: function(responseHTML){
												if (responseHTML == 'error')
												{
													alert('Error applying discount code [2]');
												}
												else
												{
													jQuery('#discount_code_message').html(responseHTML);
												}		
												
												//enable invite button
												jQuery('#discount_code_button').removeAttr('disabled');										
											}
										});
									}																		
								});
							</script>
							
							<?php
								if($gateway == "check")
								{
									$instructions = tdp_getOption("instructions");			
									echo '<div class="tdp_check_instructions">' . wpautop($instructions) . '</div>';
								}
							?>
							
							<?php if($gateway == "braintree") { ?>						  
								<input type='hidden' data-encrypted-name='expiration_date' id='credit_card_exp' />
								<input type='hidden' name='AccountNumber' id='BraintreeAccountNumber' />
								<script type="text/javascript" src="https://js.braintreegateway.com/v1/braintree.js"></script>
								<script type="text/javascript">
									//setup braintree encryption
									var braintree = Braintree.create('<?php echo tdp_getOption("braintree_encryptionkey"); ?>');
									braintree.onSubmitEncryptForm('tdp_form');

									//pass expiration dates in original format
									function tdp_updateBraintreeCardExp()
									{
										jQuery('#credit_card_exp').val(jQuery('#ExpirationMonth').val() + "/" + jQuery('#ExpirationYear').val());
									}
									jQuery('#ExpirationMonth, #ExpirationYear').change(function() {
										tdp_updateBraintreeCardExp();
									});
									tdp_updateBraintreeCardExp();
									
									//pass last 4 of credit card
									function tdp_updateBraintreeAccountNumber()
									{
										jQuery('#BraintreeAccountNumber').val('XXXXXXXXXXXXX' + jQuery('#AccountNumber').val().substr(jQuery('#AccountNumber').val().length - 4));
									}
									jQuery('#AccountNumber').change(function() {
										tdp_updateBraintreeAccountNumber();
									});
									tdp_updateBraintreeAccountNumber();
								</script>
							<?php } ?>
							
							<?php do_action("tdp_checkout_before_submit_button"); ?>			
								
							<div class="tdp_submit">
								<?php if($tdp_review) { ?>
									
									<span id="tdp_submit_span">
										<input type="hidden" name="confirm" value="1" />
										<input type="hidden" name="token" value="<?php echo esc_attr($tdp_paypal_token)?>" />
										<input type="hidden" name="gateway" value="<?php echo esc_attr($gateway); ?>" />
										<input type="submit" class="tdp_btn tdp_btn-submit-checkout" value="<?php _e('Complete Payment', 'tdp');?> &raquo;" />
									</span>
										
								<?php } else { ?>
											
									<?php if($gateway == "paypal" || $gateway == "paypalexpress" || $gateway == "paypalstandard") { ?>
									<span id="tdp_paypalexpress_checkout" <?php if(($gateway != "paypalexpress" && $gateway != "paypalstandard") || !$tdp_requirebilling) { ?>style="display: none;"<?php } ?>>
										<input type="hidden" name="submit-checkout" value="1" />		
										<input type="image" value="<?php _e('Check Out with PayPal', 'tdp');?> &raquo;" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" />
									</span>
									<?php } ?>
									
									<span id="tdp_submit_span" <?php if(($gateway == "paypalexpress" || $gateway == "paypalstandard") && $tdp_requirebilling) { ?>style="display: none;"<?php } ?>>
										<input type="hidden" name="submit-checkout" value="1" />		
										<input type="submit" class="tdp_btn tdp_btn-submit-checkout" value="<?php if($tdp_requirebilling) { _e('Submit and Check Out', 'tdp'); } else { _e('Submit and Confirm', 'tdp');}?> &raquo;" />				
									</span>
								<?php } ?>
								
								<span id="tdp_processing_message" style="visibility: hidden;">
									<?php 
										$processing_message = apply_filters("tdp_processing_message", __("Processing...", "tdp"));
										echo $processing_message;
									?>					
								</span>
							</div>	

							<div class="tdp_clear"></div>

			</div>

		</div>

	</div>

</form>

<?php if($gateway == "paypal" || $gateway == "paypalexpress") { ?>
<script>	
	//choosing payment method
	jQuery('input[name=gateway]').click(function() {		
		if(jQuery(this).val() == 'paypal')
		{
			jQuery('#tdp_paypalexpress_checkout').hide();
			jQuery('#tdp_billing_address_fields').show();
			jQuery('#tdp_payment_information_fields').show();			
			jQuery('#tdp_submit_span').show();
		}
		else
		{			
			jQuery('#tdp_billing_address_fields').hide();
			jQuery('#tdp_payment_information_fields').hide();			
			jQuery('#tdp_submit_span').hide();
			jQuery('#tdp_paypalexpress_checkout').show();
		}
	});
	
	//select the radio button if the label is clicked on
	jQuery('a.tdp_radio').click(function() {
		jQuery(this).prev().click();
	});
</script>
<?php } ?>

<script>	
	// Find ALL <form> tags on your page
	jQuery('form').submit(function(){
		// On submit disable its submit button
		jQuery('input[type=submit]', this).attr('disabled', 'disabled');
		jQuery('input[type=image]', this).attr('disabled', 'disabled');
		jQuery('#tdp_processing_message').css('visibility', 'visible');
	});
	
	//add required to required fields
	jQuery('.tdp_required').after('<span class="tdp_asterisk"> *</span>');
	
	//unhighlight error fields when the user edits them
	jQuery('.tdp_error').bind("change keyup input", function() {
		jQuery(this).removeClass('tdp_error');
	});
</script>
