<?php 
	global $wpdb, $tdp_invoice, $tdp_msg, $tdp_msgt, $current_user, $tdp_currency_symbol;
	
	if($tdp_msg)
	{
	?>
	<div class="tdp_message <?php echo $tdp_msgt?>"><?php echo $tdp_msg?></div>
	<?php
	}
?>	

<?php 
	if($tdp_invoice) 
	{ 
		?>
		<?php
			$tdp_invoice->getUser();
			$tdp_invoice->getMembershipLevel();
		?>
		
		<h3>
			<?php printf(_x('Invoice #%s on %s', 'Invoice # header. E.g. Invoice #ABCDEF on 2013-01-01.', 'tdp'), $tdp_invoice->code, date(get_option('date_format'), $tdp_invoice->timestamp));?>	
		</h3>
		<a class="tdp_a-print" href="javascript:window.print()">Print</a>
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
		
		<?php
			//check instructions		
			if($tdp_invoice->gateway == "check" && !tdp_isLevelFree($tdp_invoice->membership_level))
				echo wpautop(tdp_getOption("instructions"));
		?>
			
		<table id="tdp_invoice_table" class="tdp_invoice" width="100%" cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
					<?php if(!empty($tdp_invoice->billing->name)) { ?>
						<th><?php _e('Billing Address', 'tdp');?></th>
					<?php } ?>
					<th><?php _e('Payment Method', 'tdp');?></th>
					<th><?php _e('Membership Level', 'tdp');?></th>
					<th align="center"><?php _e('Total Billed', 'tdp');?></th>
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
					<td align="center">
						<?php if($tdp_invoice->total != '0.00') { ?>
							<?php if(!empty($tdp_invoice->tax)) { ?>
								<?php _e('Subtotal', 'tdp');?>: <?php echo $tdp_currency_symbol?><?php echo number_format($tdp_invoice->subtotal, 2);?><br />
								<?php _e('Tax', 'tdp');?>: <?php echo $tdp_currency_symbol?><?php echo number_format($tdp_invoice->tax, 2);?><br />
								<?php if(!empty($tdp_invoice->couponamount)) { ?>
									<?php _e('Coupon', 'tdp');?>: (<?php echo $tdp_currency_symbol?><?php echo number_format($tdp_invoice->couponamount, 2);?>)<br />
								<?php } ?>
								<strong><?php _e('Total', 'tdp');?>: <?php echo $tdp_currency_symbol?><?php echo number_format($tdp_invoice->total, 2)?></strong>
							<?php } else { ?>
								<?php echo $tdp_currency_symbol?><?php echo number_format($tdp_invoice->total, 2)?>
							<?php } ?>						
						<?php } else { ?>
							<small class="tdp_grey"><?php echo $tdp_currency_symbol?>0</small>
						<?php } ?>		
					</td>
				</tr>
			</tbody>
		</table>
		<?php 
	} 
	else 
	{
		//Show all invoices for user if no invoice ID is passed	
		$invoices = $wpdb->get_results("SELECT *, UNIX_TIMESTAMP(timestamp) as timestamp FROM $wpdb->tdp_membership_orders WHERE user_id = '$current_user->ID' ORDER BY timestamp DESC");
		if($invoices)
		{
			?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
					<th><?php _e('Date', 'tdp'); ?></th>
					<th><?php _e('Invoice #', 'tdp'); ?></th>
					<th><?php _e('Total Billed', 'tdp'); ?></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($invoices as $invoice)
				{ 
					?>
					<tr>
						<td><?php echo date(get_option("date_format"), $invoice->timestamp)?></td>
						<td><a href="<?php echo tdp_url("invoice", "?invoice=" . $invoice->code)?>"><?php echo $invoice->code; ?></a></td>
						<td><?php echo $tdp_currency_symbol?><?php echo $invoice->total?></td>					
						<td><a href="<?php echo tdp_url("invoice", "?invoice=" . $invoice->code)?>"><?php _e('View Invoice', 'tdp'); ?></a></td>
					</tr>
					<?php
				}
			?>
			</tbody>
			</table>
			<?php
		}
		else
		{
			?>
			<p><?php _e('No invoices found.', 'tdp');?></p>
			<?php
		}
	} 
?>
<nav id="nav-below" class="navigation" role="navigation">
	<div class="nav-next alignright">
		<a href="<?php echo tdp_url("account")?>"><?php _e('View Your Membership Account &rarr;', 'tdp');?></a>
	</div>
	<?php if($tdp_invoice) { ?>
		<div class="nav-prev alignleft">
			<a href="<?php echo tdp_url("invoice")?>"><?php _e('&larr; View All Invoices', 'tdp');?></a>
		</div>
	<?php } ?>
</nav>
