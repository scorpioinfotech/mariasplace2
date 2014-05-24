<?php
	//only admins can get this
	if(!function_exists("current_user_can") || (!current_user_can("manage_options") && !current_user_can("tdp_orders")))
	{
		die(__("You do not have permissions to perform this action.", "tdp"));
	}	
	
	//vars
	global $wpdb, $tdp_currency_symbol;
	if(isset($_REQUEST['s']))
		$s = $_REQUEST['s'];
	else
		$s = "";
	
	if(isset($_REQUEST['l']))
		$l = $_REQUEST['l'];
	else
		$l = false;
	
	//deleting?
	if(!empty($_REQUEST['delete']))
	{
		$dorder = new MemberOrder(intval($_REQUEST['delete']));
		if($dorder->deleteMe())
		{
			$tdp_msg = __("Order deleted successfully.", "tdp");
			$tdp_msgt = "success";
		}
		else
		{
			$tdp_msg = __("Error deleting order.", "tdp");
			$tdp_msgt = "error";
		}
	}
	
	//this array stores fields that should be read only
	$read_only_fields = apply_filters("tdp_orders_read_only_fields", array("code", "payment_transaction_id", "subscription_transaction_id"));
	
	//saving?
	if(!empty($_REQUEST['save']))
	{
		//start with old order if applicable
		$order_id = intval($_REQUEST['order']);
		if($order_id > 0)
			$order = new MemberOrder($order_id);
		else
			$order = new MemberOrder();
		
		//update values
		if(!in_array("code", $read_only_fields))
			$order->code = $_POST['code'];
		if(!in_array("user_id", $read_only_fields))
			$order->user_id = intval($_POST['user_id']);
		if(!in_array("membership_id", $read_only_fields))
			$order->membership_id = intval($_POST['membership_id']);
		if(!in_array("billing_name", $read_only_fields))
			$order->billing->name = stripslashes($_POST['billing_name']);
		if(!in_array("billing_street", $read_only_fields))		
			$order->billing->street = stripslashes($_POST['billing_street']);
		if(!in_array("billing_city", $read_only_fields))
			$order->billing->city = stripslashes($_POST['billing_city']);
		if(!in_array("billing_state", $read_only_fields))
			$order->billing->state = stripslashes($_POST['billing_state']);
		if(!in_array("billing_zip", $read_only_fields))
			$order->billing->zip = $_POST['billing_zip'];
		if(!in_array("billing_country", $read_only_fields))
			$order->billing->country = stripslashes($_POST['billing_country']);
		if(!in_array("billing_phone", $read_only_fields))
			$order->billing->phone = $_POST['billing_phone'];
		if(!in_array("subtotal", $read_only_fields))
			$order->subtotal = $_POST['subtotal'];
		if(!in_array("tax", $read_only_fields))
			$order->tax = $_POST['tax'];
		if(!in_array("couponamount", $read_only_fields))
			$order->couponamount = $_POST['couponamount'];
		if(!in_array("total", $read_only_fields))
			$order->total = $_POST['total'];
		if(!in_array("payment_type", $read_only_fields))
			$order->payment_type = $_POST['payment_type'];
		if(!in_array("cardtype", $read_only_fields))
			$order->cardtype = $_POST['cardtype'];
		if(!in_array("accountnumber", $read_only_fields))
			$order->accountnumber = $_POST['accountnumber'];
		if(!in_array("expirationmonth", $read_only_fields))
			$order->expirationmonth = $_POST['expirationmonth'];		
		if(!in_array("expirationyear", $read_only_fields))
			$order->expirationyear = $_POST['expirationyear'];
		if(!in_array("ExpirationDate", $read_only_fields))
			$order->ExpirationDate = $order->expirationmonth . $order->expirationyear;
		if(!in_array("status", $read_only_fields))
			$order->status = stripslashes($_POST['status']);
		if(!in_array("gateway", $read_only_fields))
			$order->gateway = $_POST['gateway'];
		if(!in_array("gateway_environment", $read_only_fields))
			$order->gateway_environment = $_POST['gateway_environment'];
		if(!in_array("payment_transaction_id", $read_only_fields))
			$order->payment_transaction_id = $_POST['payment_transaction_id'];
		if(!in_array("subscription_transaction_id", $read_only_fields))
			$order->subscription_transaction_id = $_POST['subscription_transaction_id'];
		if(!in_array("notes", $read_only_fields))
			$order->notes = stripslashes($_POST['notes']);
		
		//affiliate stuff
		$affiliates = apply_filters("tdp_orders_show_affiliate_ids", false);
		if(!empty($affiliates))
		{
			if(!in_array("affiliate_id", $read_only_fields))
				$order->affiliate_id = $_POST['affiliate_id'];
			if(!in_array("affiliate_subid", $read_only_fields))
				$order->affiliate_subid = $_POST['affiliate_subid'];
		}
		
		//save
		if($order->saveOrder() !== false)
		{		
			//handle timestamp
			if($order->updateTimestamp($_POST['ts_year'], $_POST['ts_month'], $_POST['ts_day']) !== false)
			{
				$tdp_msg = __("Order saved successfully.", "tdp");
				$tdp_msgt = "success";
			}
			else
			{
				$tdp_msg = __("Error updating order timestamp.", "tdp");
				$tdp_msgt = "error";
			}
		}	
		else
		{
			$tdp_msg = __("Error saving order.", "tdp");
			$tdp_msgt = "error";
		}
	}
	else
	{	
		//order passed?
		if(!empty($_REQUEST['order']))
		{
			$order_id = intval($_REQUEST['order']);
			if($order_id > 0)
				$order = new MemberOrder($order_id);
			elseif(!empty($_REQUEST['copy']))
			{
				$order = new MemberOrder(intval($_REQUEST['copy']));
				
				//new id
				$order->id = NULL;
				
				//new code
				$order->code = $order->getRandomCode();
			}
			else
			{
				$order = new MemberOrder();			//new order
				
				//defaults
				$order->code = $order->getRandomCode();
				$order->user_id = "";
				$order->membership_id = "";
				$order->billing->name = "";
				$order->billing->street = "";
				$order->billing->city = "";
				$order->billing->state = "";
				$order->billing->zip = "";
				$order->billing->country = "";
				$order->billing->phone = "";
				$order->subtotal = "";
				$order->tax = "";
				$order->couponamount = "";
				$order->total = "";
				$order->payment_type = "";
				$order->cardtype = "";
				$order->accountnumber = "";
				$order->expirationmonth = "";
				$order->expirationyear = "";				
				$order->status = "success";
				$order->gateway = tdp_getOption("gateway");
				$order->gateway_environment = tdp_getOption("gateway_environment");
				$order->payment_transaction_id = "";
				$order->subscription_transaction_id = "";
				$order->affiliate_id = "";
				$order->affiliate_subid = "";
				$order->notes = "";
			}
		}
	}
	
	require_once(dirname(__FILE__) . "/admin_header.php");	
?>

<?php if(!empty($order)) { ?>

	<h2>
		<?php if(!empty($order->id)) { ?>
			<?php _e('Order', 'tdp');?> #<?php echo $order->id?>: <?php echo $order->code?>
		<?php } else { ?>
			<?php _e('New Order', 'tdp');?>
		<?php } ?>
	</h2>
	
	<?php if(!empty($tdp_msg)) { ?>
		<div id="message" class="<?php if($tdp_msgt == "success") echo "updated fade"; else echo "error"; ?>"><p><?php echo $tdp_msg?></p></div>
	<?php } ?>
	
	<form method="post" action="">
		
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row" valign="top"><label>ID:</label></th>
					<td><?php if(!empty($order->id)) echo $order->id; else echo __("This will be generated when you save.", "tdp");?></td>
				</tr>								                
				
				<tr>
					<th scope="row" valign="top"><label for="code"><?php _e('Code', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("code", $read_only_fields)) { echo $order->code; } else { ?>
							<input id="code" name="code" type="text" size="50" value="<?php echo esc_attr($order->code);?>" />
						<?php } ?>
						<?php if($order_id < 0) { ?><small class="tdp_lite"><?php _e('Randomly generated for you.', 'tdp');?></small><?php } ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="user_id"><?php _e('User ID', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("user_id", $read_only_fields) && $order_id > 0) { echo $order->user_id; } else { ?>
							<input id="user_id" name="user_id" type="text" size="50" value="<?php echo esc_attr($order->user_id);?>" />
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="membership_id"><?php _e('Membership Level ID', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("membership_id", $read_only_fields) && $order_id > 0) { echo $order->membership_id; } else { ?>
							<input id="membership_id" name="membership_id" type="text" size="50" value="<?php echo esc_attr($order->membership_id);?>" />
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="billing_name"><?php _e('Billing Name', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("billing_name", $read_only_fields) && $order_id > 0) { echo $order->billing_name; } else { ?>
							<input id="billing_name" name="billing_name" type="text" size="50" value="<?php echo esc_attr($order->billing->name);?>" />
						<?php } ?>
					</td>
				</tr>				
				<tr>
					<th scope="row" valign="top"><label for="billing_street"><?php _e('Billing Street', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("billing_street", $read_only_fields) && $order_id > 0) { echo $order->billing_street; } else { ?>
							<input id="billing_street" name="billing_street" type="text" size="50" value="<?php echo esc_attr($order->billing->street);?>" /></td>
						<?php } ?>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="billing_city"><?php _e('Billing City', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("billing_city", $read_only_fields) && $order_id > 0) { echo $order->billing_city; } else { ?>
							<input id="billing_city" name="billing_city" type="text" size="50" value="<?php echo esc_attr($order->billing->city);?>" /></td>
						<?php } ?>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="billing_state"><?php _e('Billing State', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("billing_state", $read_only_fields) && $order_id > 0) { echo $order->billing_state; } else { ?>
							<input id="billing_state" name="billing_state" type="text" size="50" value="<?php echo esc_attr($order->billing->state);?>" /></td>
						<?php } ?>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="billing_zip"><?php _e('Billing Postal Code', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("billing_zip", $read_only_fields) && $order_id > 0) { echo $order->billing_zip; } else { ?>
							<input id="billing_zip" name="billing_zip" type="text" size="50" value="<?php echo esc_attr($order->billing->zip);?>" /></td>
						<?php } ?>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="billing_country"><?php _e('Billing Country', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("billing_country", $read_only_fields) && $order_id > 0) { echo $order->billing_country; } else { ?>
							<input id="billing_country" name="billing_country" type="text" size="50" value="<?php echo esc_attr($order->billing->country);?>" />
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="billing_phone"><?php _e('Billing Phone', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("billing_phone", $read_only_fields) && $order_id > 0) { echo $order->billing_phone; } else { ?>
							<input id="billing_phone" name="billing_phone" type="text" size="50" value="<?php echo esc_attr($order->billing->phone);?>" />
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="subtotal"><?php _e('Sub Total', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("subtotal", $read_only_fields) && $order_id > 0) { echo $order->subtotal; } else { ?>
							<input id="subtotal" name="subtotal" type="text" size="10" value="<?php echo esc_attr($order->subtotal);?>" />						
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="tax"><?php _e('Tax', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("tax", $read_only_fields) && $order_id > 0) { echo $order->tax; } else { ?>
							<input id="tax" name="tax" type="text" size="10" value="<?php echo esc_attr($order->tax);?>" />						
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="couponamount"><?php _e('Coupon Amount', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("couponamount", $read_only_fields) && $order_id > 0) { echo $order->couponamount; } else { ?>
							<input id="couponamount" name="couponamount" type="text" size="10" value="<?php echo esc_attr($order->couponamount);?>" />
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="total"><?php _e('Total', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("total", $read_only_fields) && $order_id > 0) { echo $order->total; } else { ?>							
							<input id="total" name="total" type="text" size="10" value="<?php echo esc_attr($order->total);?>" />
						<?php } ?>
						<small class="tdp_lite"><?php _e('Should be subtotal + tax - couponamount.', 'tdp');?></small>	
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="payment_type"><?php _e('Payment Type', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("payment_type", $read_only_fields) && $order_id > 0) { echo $order->payment_type; } else { ?>
							<input id="payment_type" name="payment_type" type="text" size="50" value="<?php echo esc_attr($order->payment_type);?>" />
						<?php } ?>
						<small class="tdp_lite"><?php _e('e.g. PayPal Express, PayPal Standard, Credit Card.', 'tdp');?></small>						
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="cardtype"><?php _e('Card Type', 'tdp');?></label></th>
					<td>
						<?php if(in_array("cardtype", $read_only_fields) && $order_id > 0) { echo $order->cardtype; } else { ?>
							<input id="cardtype" name="cardtype" type="text" size="50" value="<?php echo esc_attr($order->cardtype);?>" />
						<?php } ?>
						<small class="tdp_lite"><?php _e('e.g. Visa, MasterCard, AMEX, etc', 'tdp');?></small>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="accountnumber"><?php _e('Account Number', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("accountnumber", $read_only_fields) && $order_id > 0) { echo $order->accountnumber; } else { ?>
							<input id="accountnumber" name="accountnumber" type="text" size="50" value="<?php echo esc_attr($order->accountnumber);?>" />
						<?php } ?>
						<small class="tdp_lite"><?php _e('Obscure all but last 4 digits.', 'tdp');?></small>
					</td>
				</tr>
				<?php if(in_array("ExpirationDate", $read_only_fields) && $order_id > 0) { echo $order->ExpirationDate; } else { ?>
				<tr>
					<th scope="row" valign="top"><label for="expirationmonth"><?php _e('Expiration Month', 'tdp');?>:</label></th>
					<td>
						<input id="expirationmonth" name="expirationmonth" type="text" size="10" value="<?php echo esc_attr($order->expirationmonth);?>" />
						<small class="tdp_lite">MM</small>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="expirationyear"><?php _e('Expiration Year', 'tdp');?>:</label></th>
					<td>
						<input id="expirationyear" name="expirationyear" type="text" size="10" value="<?php echo esc_attr($order->expirationyear);?>" />
						<small class="tdp_lite">YYYY</small>
					</td>
				</tr>
				<?php } ?>				
				<tr>
					<th scope="row" valign="top"><label for="status"><?php _e('Status', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("status", $read_only_fields) && $order_id > 0) { echo $order->status; } else { ?>
						<?php
							$statuses = array();
							$default_statuses = array("", "success", "cancelled", "review", "token", "refunded");
							$used_statuses = $wpdb->get_col("SELECT DISTINCT(status) FROM $wpdb->tdp_membership_orders");
							$statuses = array_unique(array_merge($default_statuses, $used_statuses));
							asort($statuses);
							$statuses = apply_filters("tdp_order_statuses", $statuses);													
						?>
						<select id="status" name="status">
							<?php foreach($statuses as $status) { ?>
								<option value="<?php echo esc_attr($status);?>" <?php selected($order->status, $status);?>><?php echo $status;?></option>
							<?php } ?>
						</select>	
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="gateway"><?php _e('Gateway', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("gateway", $read_only_fields) && $order_id > 0) { echo $order->gateway; } else { ?>
						<select id="gateway" name="gateway" onchange="tdp_changeGateway(jQuery(this).val());">
							<option value="" <?php if(empty($order->gateway)) { ?>selected="selected"<?php } ?>><?php _e('Testing Only', 'tdp');?></option>
							<option value="check" <?php if($order->gateway == "check") { ?>selected="selected"<?php } ?>><?php _e('Pay by Check', 'tdp');?></option>
							<option value="stripe" <?php if($order->gateway == "stripe") { ?>selected="selected"<?php } ?>>Stripe</option>
							<option value="paypalstandard" <?php if($order->gateway == "paypalstandard") { ?>selected="selected"<?php } ?>>PayPal Standard</option>
							<option value="paypalexpress" <?php if($order->gateway == "paypalexpress") { ?>selected="selected"<?php } ?>>PayPal Express</option>
							<option value="paypal" <?php if($order->gateway == "paypal") { ?>selected="selected"<?php } ?>>PayPal Website Payments Pro</option>
							<option value="payflowpro" <?php if($order->gateway == "payflowpro") { ?>selected="selected"<?php } ?>>PayPal Payflow Pro</option>
							<option value="authorizenet" <?php if($order->gateway == "authorizenet") { ?>selected="selected"<?php } ?>>Authorize.net</option>
						</select>  
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="gateway_environment"><?php _e('Gateway Environment', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("gateway_environment", $read_only_fields) && $order_id > 0) { echo $order->gateway_environment; } else { ?>
						<select name="gateway_environment">
							<option value="sandbox" <?php if($order->gateway_environment == "sandbox") { ?>selected="selected"<?php } ?>><?php _e('Sandbox/Testing', 'tdp');?></option>
							<option value="live" <?php if($order->gateway_environment == "live") { ?>selected="selected"<?php } ?>><?php _e('Live/Production', 'tdp');?></option>
						</select>
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="payment_transaction_id"><?php _e('Payment Transaction ID', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("payment_transaction_id", $read_only_fields) && $order_id > 0) { echo $order->payment_transaction_id; } else { ?>
							<input id="payment_transaction_id" name="payment_transaction_id" type="text" size="50" value="<?php echo esc_attr($order->payment_transaction_id);?>" />
						<?php } ?>
						<small class="tdp_lite"><?php _e('Generated by the gateway. Useful to cross reference orders.', 'tdp');?></small>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="subscription_transaction_id"><?php _e('Subscription Transaction ID', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("code", $read_only_fields) && $order_id > 0) { echo $order->subscription_transaction_id; } else { ?>
							<input id="subscription_transaction_id" name="subscription_transaction_id" type="text" size="50" value="<?php echo esc_attr($order->subscription_transaction_id);?>" />
						<?php } ?>
						<small class="tdp_lite"><?php _e('Generated by the gateway. Useful to cross reference subscriptions.', 'tdp');?></small>
					</td>
				</tr>
				
				<tr>
					<th scope="row" valign="top"><label for="ts_month"><?php _e('Date', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("timestamp", $read_only_fields) && $order_id > 0) { echo date(option("date_format"), $order->timestamp); } else { ?>
						<?php
							//setup date vars
							if(!empty($order->timestamp))
								$timestamp = $order->timestamp;
							else
								$timestamp = time();
							
							$year = date("Y", $timestamp);
							$month = date("n", $timestamp);
							$day = date("j", $timestamp);
						?>
						<select id="ts_month" name="ts_month">
						<?php																
							for($i = 1; $i < 13; $i++)
							{
							?>
							<option value="<?php echo $i?>" <?php if($i == $month) { ?>selected="selected"<?php } ?>><?php echo date("M", strtotime($i . "/1/" . $year))?></option>
							<?php
							}
						?>
						</select>
						<input name="ts_day" type="text" size="2" value="<?php echo $day?>" />
						<input name="ts_year" type="text" size="4" value="<?php echo $year?>" />
						<?php } ?>
					</td>
				</tr>
				
				<?php 
					$affiliates = apply_filters("tdp_orders_show_affiliate_ids", false);
					if(!empty($affiliates)) {					
				?>
				<tr>
					<th scope="row" valign="top"><label for="affiliate_id"><?php _e('Affiliate ID', 'tdp');?>Affiliate ID:</label></th>
					<td>
						<?php if(in_array("affiliate_id", $read_only_fields) && $order_id > 0) { echo $order->affiliate_id; } else { ?>
							<input id="affiliate_id" name="affiliate_id" type="text" size="50" value="<?php echo esc_attr($order->affiliate_id);?>" />
						<?php } ?>
					</td>						
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="affiliate_subid"><?php _e('Affiliate SubID', 'tdp');?>Affiliate SubID:</label></th>
					<td>
						<?php if(in_array("affiliate_subid", $read_only_fields) && $order_id > 0) { echo $order->affiliate_subid; } else { ?>
							<input id="affiliate_subid" name="affiliate_subid" type="text" size="50" value="<?php echo esc_attr($order->affiliate_subid);?>" />
						<?php } ?>
					</td>
				</tr>
				<?php } ?>
				
				<tr>
					<th scope="row" valign="top"><label for="notes"><?php _e('Notes', 'tdp');?>:</label></th>
					<td>
						<?php if(in_array("notes", $read_only_fields) && $order_id > 0) { echo $order->notes; } else { ?>
							<textarea id="notes" name="notes" rows="5" cols="80"><?php echo esc_textarea($order->notes);?></textarea>
						<?php } ?>
					</td>
				</tr>
				
				<?php do_action("tdp_after_order_settings", $order); ?>								
				
			</tbody>
		</table>
		
		<p class="submit topborder">
			<input name="order" type="hidden" value="<?php if(!empty($order->id)) echo $order->id; else echo $order_id;?>" />
			<input name="save" type="submit" class="button-primary" value="<?php _e('Save Order', 'tdp');?>" /> 					
			<input name="cancel" type="button" value="<?php _e('Cancel', 'tdp');?>" onclick="location.href='<?php echo get_admin_url(NULL, '/admin.php?page=tdp-orders')?>';" />			
		</p>
		
	</form>

<?php } else { ?>
	
	<form id="posts-filter" method="get" action="">	
	<h2>
		<a href="admin.php?page=tdp-orders&order=-1" class="button add-new-h2">+ <?php _e('Add New Order', 'tdp');?></a>
		<a target="_blank" href="<?php echo admin_url('admin-ajax.php');?>?action=orders_csv&s=<?php echo $s?>&l=<?php echo $l?>" class="button add-new-h2"><?php _e('Export to CSV', 'tdp');?></a>
	</h2>	

	<?php if(!empty($tdp_msg)) { ?>
		<div id="message" class="<?php if($tdp_msgt == "success") echo "updated fade"; else echo "error"; ?>"><p><?php echo $tdp_msg?></p></div>
	<?php } ?>
	
	<ul class="subsubsub">
		<li>			
				
		</li>
	</ul>

	<!--

	<p class="search-box">
		<label class="hidden" for="post-search-input"><?php _e('Search Orders', 'tdp');?>:</label>
		<input type="hidden" name="page" value="tdp-orders" />		
		<input id="post-search-input" type="text" value="<?php echo $s?>" name="s"/>
		<input class="button" type="submit" value="<?php _e('Search Orders', 'tdp');?>"/>
	</p>

	-->

	<?php 
		//some vars for the search
		if(isset($_REQUEST['pn']))
			$pn = $_REQUEST['pn'];
		else
			$pn = 1;
			
		if(isset($_REQUEST['limit']))
			$limit = $_REQUEST['limit'];
		else
			$limit = 15;
		
		$end = $pn * $limit;
		$start = $end - $limit;				
					
		if($s)
		{
			$sqlQuery = "SELECT SQL_CALC_FOUND_ROWS o.id FROM $wpdb->tdp_membership_orders o LEFT JOIN $wpdb->users u ON o.user_id = u.ID LEFT JOIN $wpdb->tdp_membership_levels l ON o.membership_id = l.id ";
			
			$join_with_usermeta = apply_filters("tdp_orders_search_usermeta", false);
			if($join_with_usermeta)
				$sqlQuery .= "LEFT JOIN $wpdb->usermeta um ON o.user_id = um.user_id ";
			
			$sqlQuery .= "WHERE (1=2 ";
			
			$fields = array("o.id", "o.code", "o.billing_name", "o.billing_street", "o.billing_city", "o.billing_state", "o.billing_zip", "o.billing_phone", "o.payment_type", "o.cardtype", "o.accountnumber", "o.status", "o.gateway", "o.gateway_environment", "o.payment_transaction_id", "o.subscription_transaction_id", "u.user_login", "u.user_email", "u.display_name", "l.name");
			
			if($join_with_usermeta)
				$fields[] = "um.meta_value";
			
			$fields = apply_filters("tdp_orders_search_fields", $fields);
			
			foreach($fields as $field)
				$sqlQuery .= " OR " . $field . " LIKE '%" . esc_sql($s) . "%' ";
			$sqlQuery .= ") ";
			$sqlQuery .= "GROUP BY o.id ORDER BY o.id DESC, o.timestamp DESC ";
		}
		else
		{
			$sqlQuery = "SELECT SQL_CALC_FOUND_ROWS id FROM $wpdb->tdp_membership_orders ORDER BY id DESC, timestamp DESC ";
		}
		
		$sqlQuery .= "LIMIT $start, $limit";
				
		$order_ids = $wpdb->get_col($sqlQuery);
		$totalrows = $wpdb->get_var("SELECT FOUND_ROWS() as found_rows");
		
		if($order_ids)
		{		
		?>
		<p class="clear"><?php printf(__("%d orders found.", "tdp"), $totalrows);?></span></p>
		<?php
		}		
	?>
	<table class="widefat">
		<thead>
			<tr class="thead">
				<th><?php _e('ID', 'tdp');?></th>
				<th><?php _e('Code', 'tdp');?></th>
				<th><?php _e('User', 'tdp');?></th>
				<?php do_action("tdp_orders_extra_cols_header", $order_ids);?>
				<th><?php _e('Membership Level', 'tdp');?></th>
				<th><?php _e('Total', 'tdp');?></th>
				<th><?php _e('Payment', 'tdp');?></th>
				<th><?php _e('Gateway', 'tdp');?></th>
				<th><?php _e('Transaction IDs', 'tdp');?></th>	
				<th><?php _e('Status', 'tdp');?></th>
				<th><?php _e('Date', 'tdp');?></th>	
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody id="orders" class="list:order orders-list">	
			<?php	
				$count = 0;											
				foreach($order_ids as $order_id)
				{										
					$order = new MemberOrder();
					$order->nogateway = true;
					$order->getMemberOrderByID($order_id);
					?>
						<tr <?php if($count++ % 2 == 0) { ?>class="alternate"<?php } ?>>
							<td><a href="admin.php?page=tdp-orders&order=<?php echo $order->id?>"><?php echo $order->id;?></a></td>
							<td><a href="admin.php?page=tdp-orders&order=<?php echo $order->id?>"><?php echo $order->code;?></a></td>
							<td>
								<?php $order->getUser(); ?>		
								<?php if(!empty($order->user)) { ?>
									<a href="user-edit.php?user_id=<?php echo $order->user->ID?>"><?php echo $order->user->user_login?></a>
								<?php } else { ?>
									[<?php _e('deleted', 'tdp');?>]
								<?php } ?>
							</td>						
							<?php do_action("tdp_orders_extra_cols_body", $order);?>
							<td><?php echo $order->membership_id;?></td>
							<td><?php echo $tdp_currency_symbol . $order->total;?></td>
							<td>
								<?php if(!empty($order->payment_type)) echo $order->payment_type . "<br />";?>
								<?php if(!empty($order->accountnumber)) { ?>
									<?php echo $order->cardtype;?>: x<?php echo last4($order->accountnumber);?><br />
								<?php } ?>
								<?php if(!empty($order->billing->street)) { ?>
									<?php echo $order->billing->street; ?><br />																		
									<?php if( $order->billing->city &&  $order->billing->state) { ?>
										<?php echo  $order->billing->city?>, <?php echo  $order->billing->state?> <?php echo  $order->billing->zip?>  <?php if(!empty( $order->billing->country)) echo  $order->billing->country?><br />												
									<?php } ?>
								<?php } ?>
								<?php if(!empty($order->billing->phone)) echo formatPhone($order->billing->phone);?>
							</td>
							<td><?php echo $order->gateway;?><?php if($order->gateway_environment == "test") echo "(test)";?></td>
							<td>
								<?php _e('Payment', 'tdp');?>: <?php if(!empty($order->payment_transaction_id)) echo $order->payment_transaction_id; else echo "N/A";?>
								<br />
								<?php _e('Subscription', 'tdp');?>: <?php if(!empty($order->subscription_transaction_id)) echo $order->subscription_transaction_id; else echo "N/A";?>	
							</td>
							<td><?php echo $order->status;?></td>
							<td><?php echo date(get_option('date_format'), $order->timestamp);?></td>
							<td align="center">
								<a href="admin.php?page=tdp-orders&order=<?php echo $order->id;?>"><?php _e('edit', 'tdp');?></a>
							</td>
							<td align="center">
								<a href="admin.php?page=tdp-orders&order=-1&copy=<?php echo $order->id;?>"><?php _e('copy', 'tdp');?></a>
							</td>
							<td align="center">
								<a href="javascript:askfirst('<?php printf(__("Deleting orders is permanent and can affect active users. Are you sure you want to delete order %s?", "tdp"), str_replace("'", "", $order->code));?>', 'admin.php?page=tdp-orders&delete=<?php echo $order->id;?>'); void(0);"><?php _e('delete', 'tdp');?></a>
							</td>
						</tr>
					<?php
				}
				
				if(!$order_ids)
				{
				?>
				<tr>
					<td colspan="9"><p><?php _e('No orders found.', 'tdp');?></p></td>
				</tr>
				<?php
				}
			?>		
		</tbody>
	</table>
	</form>
	
	<?php
	echo tdp_getPaginationString($pn, $totalrows, $limit, 1, get_admin_url(NULL, "/admin.php?page=tdp-orders&s=" . urlencode($s)), "&l=$l&limit=$limit&pn=");
	?>

<?php } ?>
	
<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>
