<?php
	global $wpdb, $tdp_msg, $tdp_msgt, $tdp_levels, $current_user, $levels, $tdp_currency_symbol;
	
	//if a member is logged in, show them some info here (1. past invoices. 2. billing information with button to update.)
	if($current_user->membership_level->ID)
	{
	?>	
	

	<div class="tdp-wrap tdp-login ">
		
		<div class="tdp-inner tdp-login-wrapper">

			<div class="tdp-head">

				<div class="tdp-left">

					<div class="tdp-field-name tdp-field-name-wide login-heading" id="login-heading-1">
						<?php _e("Your membership is <strong>active</strong>.", "tdp");?>
					</div>

				</div>

				<div class="tdp-right">
					<?php _e("Membership", "tdp");?>:</strong> <?php echo $current_user->membership_level->name?>
				</div>

				<div class="tdp_clear"></div>

			</div>

			<div class="tdp-main">

				<ul>
				<?php if($current_user->membership_level->billing_amount > 0) { ?>
				<li><strong><?php _e("Membership Fee", "tdp");?>:</strong>
				<?php echo $tdp_currency_symbol?><?php echo $current_user->membership_level->billing_amount?>
				<?php if($current_user->membership_level->cycle_number > 1) { ?>
					<?php _e('per','tdp');?> <?php echo $current_user->membership_level->cycle_number?> <?php echo sornot($current_user->membership_level->cycle_period,$current_user->membership_level->cycle_number)?>
				<?php } elseif($current_user->membership_level->cycle_number == 1) { ?>
					<?php _e('per','tdp');?> <?php echo $current_user->membership_level->cycle_period?>
				<?php } ?>
				</li>
				<?php } ?>						
				
				<?php if($current_user->membership_level->billing_limit) { ?>
					<li><strong><?php _e("Duration", "tdp");?>:</strong> <?php echo $current_user->membership_level->billing_limit.' '.sornot($current_user->membership_level->cycle_period,$current_user->membership_level->billing_limit)?></li>
				<?php } ?>
				
				<?php if($current_user->membership_level->enddate) { ?>
					<li><strong><?php _e("Membership Expires", "tdp");?>:</strong> <?php echo date(get_option('date_format'), $current_user->membership_level->enddate)?></li>
				<?php } ?>
				
				<?php if($current_user->membership_level->trial_limit == 1) 
				{ 
					printf(__("Your first payment will cost %s.", "tdp"), $tdp_currency_symbol . $current_user->membership_level->trial_amount);
				}
				elseif(!empty($current_user->membership_level->trial_limit)) 
				{
					printf(__("Your first %d payments will cost %s.", "tdp"), $current_user->membership_level->trial_limit, $tdp_currency_symbol . $current_user->membership_level->trial_amount);
				}
				?>
				</ul>

				<div class="tdp_clear"></div>

				<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("My Account", "tdp");?></div>

				<div id="tdp_account-profile" class="tdp_box">	
					<?php get_currentuserinfo(); ?> 
					<?php if($current_user->user_firstname) { ?>
						<p><?php echo $current_user->user_firstname?> <?php echo $current_user->user_lastname?></p>
					<?php } ?>
					<ul>
						<li><strong><?php _e("Username", "tdp");?>:</strong> <?php echo $current_user->user_login?></li>
						<li><strong><?php _e("Email", "tdp");?>:</strong> <?php echo $current_user->user_email?></li>
					</ul>
					<div class="tdp_clear"></div>
					<p>
						<a href="<?php the_field('edit_profile_page','option');?>"><?php _e("Edit Profile", "tdp");?></a> |
						<a href="<?php the_field('edit_profile_page','option');?>"><?php _ex("Change Password", "As in 'change password'.", "tdp");?></a>
					</p>
					<br/>
				</div> <!-- end tdp_account-profile -->


				<?php
					//last invoice for current info
					//$ssorder = $wpdb->get_row("SELECT *, UNIX_TIMESTAMP(timestamp) as timestamp FROM $wpdb->tdp_membership_orders WHERE user_id = '$current_user->ID' AND membership_id = '" . $current_user->membership_level->ID . "' AND status = 'success' ORDER BY timestamp DESC LIMIT 1");				
					$ssorder = new MemberOrder();
					$ssorder->getLastMemberOrder();
					$invoices = $wpdb->get_results("SELECT *, UNIX_TIMESTAMP(timestamp) as timestamp FROM $wpdb->tdp_membership_orders WHERE user_id = '$current_user->ID' ORDER BY timestamp DESC LIMIT 6");				
					if(!empty($ssorder->id) && $ssorder->gateway != "check" && $ssorder->gateway != "paypalexpress")
					{
						//default values from DB (should be last order or last update)
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
						$AccountNumber = hideCardNumber(get_user_meta($current_user->ID, "tdp_AccountNumber", true), false);
						$ExpirationMonth = get_user_meta($current_user->ID, "tdp_ExpirationMonth", true);
						$ExpirationYear = get_user_meta($current_user->ID, "tdp_ExpirationYear", true);	
						?>	
						
						<div id="tdp_account-billing" class="tdp_box">
							<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("Billing Information", "tdp");?></div>
							<?php if(!empty($baddress1)) { ?>
							<p>
								<strong><?php _e("Billing Address", "tdp");?></strong><br />
								<?php echo $bfirstname . " " . $blastname?>
								<br />		
								<?php echo $baddress1?><br />
								<?php if($baddress2) echo $baddress2 . "<br />";?>
								<?php if($bcity && $bstate) { ?>
									<?php echo $bcity?>, <?php echo $bstate?> <?php echo $bzipcode?> <?php echo $bcountry?>
								<?php } ?>                         
								<br />
								<?php echo formatPhone($bphone)?>
							</p>
							<?php } ?>
							
							<?php if(!empty($AccountNumber)) { ?>
							<p>
								<strong><?php _e("Payment Method", "tdp");?></strong><br />
								<?php echo $CardType?>: <?php echo last4($AccountNumber)?> (<?php echo $ExpirationMonth?>/<?php echo $ExpirationYear?>)
							</p>
							<?php } ?>
							
							<?php 
								if((isset($ssorder->status) && $ssorder->status == "success") && (isset($ssorder->gateway) && in_array($ssorder->gateway, array("authorizenet", "paypal", "stripe")))) 
								{ 
									?>
									<p><a href="<?php echo tdp_url("billing", "")?>"><?php _e("Edit Billing Information", "tdp"); ?></a></p>
									<?php 
								} 
							?>
						</div> <!-- end tdp_account-billing -->				
					<?php
					}
				?>

				<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("Listings Allowance", "tdp");?></div>

				<?php printf(__("Original Membership Allowance <strong>%s</strong>.", "tdp"), $current_user->membership_level->posts_limit); ?>

				<p><?php printf(__("Your current listings allowance is of <strong>%s</strong>.",'tdp'), $current_user->allowance_limit ); ?></p>

				<ul>
					<li><a href="<?php echo get_field('listings_management_page','option');?>"><?php _e('Manage your listings','tdp');?></a></li>
						<li><a href="<?php echo get_field('submit_new_listing_page','option');?>"><?php _e('Publish New listing','tdp');?></a></li>

				</ul>

				<br/>

				<?php if(!empty($invoices)) { ?>
				<div id="tdp_account-invoices" class="tdp_box">
					<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("Past Invoices", "tdp");?></div>
					<ul>
						<?php 
							$count = 0;
							foreach($invoices as $invoice)
							{ 
								if($count++ > 5)
									break;
								?>
								<li><a href="<?php echo tdp_url("invoice", "?invoice=" . $invoice->code)?>"><?php echo date(get_option("date_format"), $invoice->timestamp)?> (<?php echo $tdp_currency_symbol?><?php echo $invoice->total?>)</a></li>
								<?php
							}
						?>
					</ul>
					<div class="tdp_clear"></div>
					<?php if($count == 6) { ?>
						<p><a href="<?php echo tdp_url("invoice"); ?>"><?php _e("View All Invoices", "tdp");?></a></p>
					<?php } ?>
				</div> <!-- end tdp_account-billing -->
				<br/>
				<?php } ?>


				<div id="tdp_account-links" class="tdp_box">
					<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("Member Links", "tdp");?></div>
					<ul>
						<?php 
							do_action("tdp_member_links_top");
						?>
						<?php if((isset($ssorder->status) && $ssorder->status == "success") && (isset($ssorder->gateway) && in_array($ssorder->gateway, array("authorizenet", "paypal", "stripe")))) { ?>
							<li><a href="<?php echo tdp_url("billing", "", "https")?>"><?php _e("Update Billing Information", "tdp");?></a></li>
						<?php } ?>
						<?php if(count($tdp_levels) > 1) { ?>
							<li><a href="<?php echo tdp_url("levels")?>"><?php _e("Change Membership Level", "tdp");?></a></li>
						<?php } ?>
						<li><a href="<?php echo tdp_url("cancel")?>"><?php _e("Cancel Membership", "tdp");?></a></li>

						<?php 
							do_action("tdp_member_links_bottom");
						?>
					</ul>
					<div class="tdp_clear"></div>
				</div> <!-- end tdp_account-links -->	

				<div class="clear"></div>
				</br>
			
			</div>

		</div>
	
	</div>


	<?php
	}
?>