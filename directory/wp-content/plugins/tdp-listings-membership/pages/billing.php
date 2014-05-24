<?php 				
	global $wpdb, $current_user, $tdp_msg, $tdp_msgt, $tdp_currency_symbol, $show_paypal_link;
	global $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear;
	
	$gateway = tdp_getOption("gateway");
	
	//set to true via filter to have Stripe use the minimal billing fields
	$tdp_stripe_lite = apply_filters("tdp_stripe_lite", false);
	
	$level = $current_user->membership_level;
	if($level) 
	{ 
	?>
		<p><?php printf(__("Logged in as <strong>%s</strong>.", "tdp"), $current_user->user_login);?> <small><a href="<?php echo wp_logout_url(get_bloginfo("url") . "/membership-checkout/?level=" . $level->id);?>"><?php _e("logout", "tdp");?></a></small></p>
		<ul>
			<li><strong><?php _e("Level", "tdp");?>:</strong> <?php echo $level->name?></li>
		<?php if($level->billing_amount > 0) { ?>
			<li><strong><?php _e("Membership Fee", "tdp");?>:</strong>
			<?php echo $tdp_currency_symbol?><?php echo $level->billing_amount?>
			<?php if($level->cycle_number > 1) { ?>
				<?php _e('per','tdp');?> <?php echo $level->cycle_number?> <?php echo sornot($level->cycle_period,$level->cycle_number)?>
			<?php } elseif($level->cycle_number == 1) { ?>
				<?php _e('per','tdp');?> <?php echo $level->cycle_period?>
			<?php } ?>
			</li>
		<?php } ?>						
		
		<?php if($level->billing_limit) { ?>
			<li><strong><?php _e("Duration", "tdp");?>:</strong> <?php echo $level->billing_limit.' '.sornot($level->cycle_period,$level->billing_limit)?></li>
		<?php } ?>		
		</ul>
	<?php 
	} 
?>

<?php if(tdp_isLevelRecurring($level)) { ?>
	<?php if($show_paypal_link) { ?>
		
		<p><?php  _e('Your payment subscription is managed by PayPal. Please <a href="http://www.paypal.com">login to PayPal here</a> to update your billing information.', 'tdp');?></p>
		
	<?php } else { ?>
	
		<form class="tdp_form" action="<?php echo tdp_url("billing", "", "https")?>" method="post">

			<input type="hidden" name="level" value="<?php echo esc_attr($level->id);?>" />		
			<?php if($tdp_msg) 
				{
			?>
				<div class="tdp_message <?php echo $tdp_msgt?>"><?php echo $tdp_msg?></div>
			<?php
				}
			?>                        	                       	                       														          
										
			<?php if(empty($tdp_stripe_lite) || $gateway != "stripe") { ?>
			<table id="tdp_billing_address_fields" class="tdp_checkout" width="100%" cellpadding="0" cellspacing="0" border="0">
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
							<input id="bfirstname" name="bfirstname" type="text" class="input" size="20" value="<?php echo esc_attr($bfirstname);?>" /> 
						</div>	
						<div>
							<label for="blastname"><?php _e('Last Name', 'tdp');?></label>
							<input id="blastname" name="blastname" type="text" class="input" size="20" value="<?php echo esc_attr($blastname);?>" /> 
						</div>					
						<div>
							<label for="baddress1"><?php _e('Address 1', 'tdp');?></label>
							<input id="baddress1" name="baddress1" type="text" class="input" size="20" value="<?php echo esc_attr($baddress1);?>" /> 
						</div>
						<div>
							<label for="baddress2"><?php _e('Address 2', 'tdp');?></label>
							<input id="baddress2" name="baddress2" type="text" class="input" size="20" value="<?php echo esc_attr($baddress2);?>" /> <small class="lite">(<?php _e('optional', 'tdp');?>)</small>
						</div>
						
						<?php
							$longform_address = apply_filters("tdp_longform_address", false);
							if($longform_address)
							{
							?>
								<div>
									<label for="bcity"><?php _e('City', 'tdp');?>City</label>
									<input id="bcity" name="bcity" type="text" class="input" size="30" value="<?php echo esc_attr($bcity)?>" /> 
								</div>
								<div>
									<label for="bstate"><?php _e('State', 'tdp');?>State</label>
									<input id="bstate" name="bstate" type="text" class="input" size="30" value="<?php echo esc_attr($bstate)?>" /> 
								</div>
								<div>
									<label for="bzipcode"><?php _e('Postal Code', 'tdp');?></label>
									<input id="bzipcode" name="bzipcode" type="text" class="input" size="30" value="<?php echo esc_attr($bzipcode)?>" /> 
								</div>					
							<?php
							}
							else
							{
							?>
								<div>
									<label for="bcity_state_zip"><?php _e('City, State Zip', 'tdp');?></label>
									<input id="bcity" name="bcity" type="text" class="input" size="14" value="<?php echo esc_attr($bcity)?>" />, 
									<?php
										$state_dropdowns = apply_filters("tdp_state_dropdowns", false);							
										if($state_dropdowns === true || $state_dropdowns == "names")
										{
											global $tdp_states;
										?>
										<select name="bstate">
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
											<select name="bstate">
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
										<input id="bstate" name="bstate" type="text" class="input" size="2" value="<?php echo esc_attr($bstate)?>" /> 
										<?php
										}
									?>									
									<input id="bzipcode" name="bzipcode" type="text" class="input" size="5" value="<?php echo esc_attr($bzipcode)?>" /> 
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
							<select name="bcountry">
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
								<input type="hidden" id="bcountry" name="bcountry" value="US" />
							<?php
							}
						?>
						<div>
							<label for="bphone"><?php _e('Phone', 'tdp');?></label>
							<input id="bphone" name="bphone" type="text" class="input" size="20" value="<?php echo esc_attr($bphone)?>" /> 
						</div>		
						<?php if($current_user->ID) { ?>
						<?php
							if(!$bemail && $current_user->user_email)									
								$bemail = $current_user->user_email;
							if(!$bconfirmemail && $current_user->user_email)									
								$bconfirmemail = $current_user->user_email;									
						?>
						<div>
							<label for="bemail"><?php _e('E-mail Address', 'tdp');?></label>
							<input id="bemail" name="bemail" type="text" class="input" size="20" value="<?php echo esc_attr($bemail)?>" /> 
						</div>
						<div>
							<label for="bconfirmemail"><?php _e('Confirm E-mail', 'tdp');?></label>
							<input id="bconfirmemail" name="bconfirmemail" type="text" class="input" size="20" value="<?php echo esc_attr($bconfirmemail)?>" /> 

						</div>	                        
						<?php } ?>    
					</td>						
				</tr>											
			</tbody>
			</table>                   
			<?php } ?>
			
			<?php
				$tdp_accepted_credit_cards = tdp_getOption("accepted_credit_cards");
				$tdp_accepted_credit_cards = explode(",", $tdp_accepted_credit_cards);
				$tdp_accepted_credit_cards_string = tdp_implodeToEnglish($tdp_accepted_credit_cards);		
			?>
			
			<table id="tdp_payment_information_fields" class="tdp_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
					<th colspan="2"><span class="tdp_thead-msg"><?php printf(__('We accept %s', 'tdp'), $tdp_accepted_credit_cards_string);?></span><?php _e('Credit Card Information', 'tdp');?></th>
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
							<select id="CardType" <?php if($gateway != "stripe") { ?>name="CardType"<?php } ?>>
								<?php foreach($tdp_accepted_credit_cards as $cc) { ?>
									<option value="<?php echo $cc?>" <?php if($CardType == $cc) { ?>selected="selected"<?php } ?>><?php echo $cc?></option>
								<?php } ?>					
							</select> 
						</div>
						<?php } ?>
					
						<div>
							<label for="AccountNumber"><?php _e('Card Number', 'tdp');?></label>
							<input id="AccountNumber" <?php if($gateway != "stripe") { ?>name="AccountNumber"<?php } ?> class="input" type="text" size="25" value="<?php echo esc_attr($AccountNumber)?>" /> 
						</div>
					
						<div>
							<label for="ExpirationMonth"><?php _e('Expiration Date', 'tdp');?></label>
							<select id="ExpirationMonth" <?php if($gateway != "stripe") { ?>name="ExpirationMonth"<?php } ?>>
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
							</select>/<select id="ExpirationYear" <?php if($gateway != "stripe") { ?>name="ExpirationYear"<?php } ?>>
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
							<input class="input" id="CVV" <?php if($gateway != "stripe") { ?>name="CVV"<?php } ?> type="text" size="4" value="<?php if(!empty($_REQUEST['CVV'])) { echo esc_attr($_REQUEST['CVV']); }?>" />  <small>(<a href="#" onclick="javascript:window.open('<?php echo plugins_url( "/pages/popup-cvv.html", dirname(__FILE__))?>','cvv','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=600, height=475');"><?php _ex("what's this?", 'link to CVV help', 'tdp');?></a>)</small>
						</div>	
						<?php
							}
						?>
					</td>
				</tr>		
			</tbody>
			</table>																	
			
			<div align="center">
				<input type="hidden" name="update-billing" value="1" />
				<input type="submit" class="tdp_btn tdp_btn-submit" value="<?php _e('Update', 'tdp');?>" />
				<input type="button" name="cancel" class="tdp_btn tdp_btn-cancel" value="<?php _e('Cancel', 'tdp');?>" onclick="location.href='<?php echo tdp_url("account")?>';" />
			</div>	
										
		</form>	
		<script>
			// Find ALL <form> tags on your page
			jQuery('form').submit(function(){
				// On submit disable its submit button
				jQuery('input[type=submit]', this).attr('disabled', 'disabled');
				jQuery('input[type=image]', this).attr('disabled', 'disabled');
			});
		</script>
	<?php } ?>
<?php } else { ?>
	<p><?php _e("This subscription is not recurring. So you don't need to update your billing information.", "tdp");?></p>
<?php } ?>	
