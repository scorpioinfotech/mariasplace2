<?php 
	global $wpdb, $current_user, $tdp_invoice, $tdp_msg, $tdp_msgt, $tdp_currency_symbol;
	
	if($tdp_msg)
	{
	?>
		<div class="tdp_message <?php echo $tdp_msgt?>"><?php echo $tdp_msg?></div>
	<?php
	}
	
	if(empty($current_user->membership_level))
		$confirmation_message = "<p>" . __('Your payment has been submitted to PayPal. Your membership will be activated shortly.', 'tdp') . "</p>";
	else
		$confirmation_message = "<p>" . sprintf(__('Thank you for your membership to %s. Your %s membership is now active.', 'tdp'), get_bloginfo("name"), $current_user->membership_level->name) . "</p>";		
	
	//confirmation message for this level
	$level_message = $wpdb->get_var("SELECT l.confirmation FROM $wpdb->tdp_membership_levels l LEFT JOIN $wpdb->tdp_memberships_users mu ON l.id = mu.membership_id WHERE mu.status = 'active' AND mu.user_id = '" . $current_user->ID . "' LIMIT 1");
	if(!empty($level_message))
		$confirmation_message .= "\n" . stripslashes($level_message) . "\n";
?>	

<?php if($tdp_invoice) { ?>		
	
	<?php
		$tdp_invoice->getUser();
		$tdp_invoice->getMembershipLevel();			
				
		$confirmation_message .= "<p>" . sprintf(__('Below are details about your membership account and a receipt for your initial membership invoice. A welcome email with a copy of your initial membership invoice has been sent to %s.', 'tdp'), $tdp_invoice->user->user_email) . "</p>";
		
		//check instructions		
		if($tdp_invoice->gateway == "check" && !tdp_isLevelFree($tdp_invoice->membership_level))
			$confirmation_message .= wpautop(tdp_getOption("instructions"));
		
		$confirmation_message = apply_filters("tdp_confirmation_message", $confirmation_message, $tdp_invoice);				
		
		echo apply_filters("the_content", $confirmation_message);		
	?>
	
	
	<h3>
		<?php printf(_x('Invoice #%s on %s', 'Invoice # header. E.g. Invoice #ABCDEF on 2013-01-01.', 'tdp'), $tdp_invoice->code, date(get_option('date_format'), $tdp_invoice->timestamp));?>		
	</h3>
	<a class="tdp_a-print" href="javascript:window.print()"><?php _e('Print', 'tdp');?></a>
	<ul>
		<?php do_action("tdp_invoice_bullets_top", $tdp_invoice); ?>
		<li><strong><?php _e('Account', 'tdp');?>:</strong> <?php echo $tdp_invoice->user->display_name?> (<?php echo $tdp_invoice->user->user_email?>)</li>
		<li><strong><?php _e('Membership Level', 'tdp');?>:</strong> <?php echo $current_user->membership_level->name?></li>
		<?php if($current_user->membership_level->enddate) { ?>
			<li><strong><?php _e('Membership Expires', 'tdp');?>:</strong> <?php echo date(get_option('date_format'), $current_user->membership_level->enddate)?></li>
		<?php } ?>
		<?php if($tdp_invoice->getDiscountCode()) { ?>
			<li><strong><?php _e('Discount Code', 'tdp');?>:</strong> <?php echo $tdp_invoice->discount_code->code?></li>
		<?php } ?>
		<?php do_action("tdp_invoice_bullets_bottom", $tdp_invoice); ?>
	</ul>
	
	<table id="tdp_confirmation_table" class="tdp_invoice" width="100%" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<?php if(!empty($tdp_invoice->billing->name)) { ?>
				<th><?php _e('Billing Address', 'tdp');?></th>
				<?php } ?>
				<th><?php _e('Payment Method', 'tdp');?></th>
				<th><?php _e('Membership Level', 'tdp');?></th>
				<th><?php _e('Total Billed', 'tdp');?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php if(!empty($tdp_invoice->billing->name)) { ?>
				<td>
					<?php echo $tdp_invoice->billing->name?><br />
					<?php echo $tdp_invoice->billing->street?><br />						
					<?php if($tdp_invoice->billing->city && $tdp_invoice->billing->state) { ?>
						<?php echo $tdp_invoice->billing->city?>, <?php echo $tdp_invoice->billing->state?> <?php echo $tdp_invoice->billing->zip?> <?php echo $tdp_invoice->billing->country?><br />												
					<?php } ?>
					<?php echo formatPhone($tdp_invoice->billing->phone)?>
				</td>
				<?php } ?>
				<td>
					<?php if($tdp_invoice->accountnumber) { ?>
						<?php echo $tdp_invoice->cardtype?> <?php _e('ending in', 'credit card type {ending in} xxxx', 'tdp');?> <?php echo last4($tdp_invoice->accountnumber)?><br />
						<small><?php _e('Expiration', 'tdp');?>: <?php echo $tdp_invoice->expirationmonth?>/<?php echo $tdp_invoice->expirationyear?></small>
					<?php } elseif($tdp_invoice->payment_type) { ?>
						<?php echo $tdp_invoice->payment_type?>
					<?php } ?>
				</td>
				<td><?php echo $tdp_invoice->membership_level->name?></td>					
				<td><?php if($tdp_invoice->total) echo $tdp_currency_symbol . number_format($tdp_invoice->total, 2); else echo "---";?></td>
			</tr>
		</tbody>
	</table>		
<?php 
	} 
	else 
	{
		$confirmation_message .= "<p>" . sprintf(__('Below are details about your membership account. A welcome email with has been sent to %s.', 'tdp'), $current_user->user_email) . "</p>";
		
		$confirmation_message = apply_filters("tdp_confirmation_message", $confirmation_message, false);
		
		echo $confirmation_message;
	?>	
	<ul>
		<li><strong><?php _e('Account', 'tdp');?>:</strong> <?php echo $current_user->display_name?> (<?php echo $current_user->user_email?>)</li>
		<li><strong><?php _e('Membership Level', 'tdp');?>:</strong> <?php if(!empty($current_user->membership_level)) echo $current_user->membership_level->name; else _ex("Pending", "User without membership is in {pending} status.", "tdp");?></li>
	</ul>	
<?php 
	} 
?>  
<nav id="nav-below" class="navigation" role="navigation">
	<div class="nav-next alignright">
		<?php if(!empty($current_user->membership_level)) { ?>
			<a href="<?php echo tdp_url("account")?>"><?php _e('View Your Membership Account &rarr;', 'tdp');?></a>
		<?php } else { ?>
			<?php _e('If your account is not activated within a few minutes, please contact the site owner.', 'tdp');?>
		<?php } ?>
	</div>
</nav>
