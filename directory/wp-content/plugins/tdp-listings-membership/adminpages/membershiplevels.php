<?php
	//only admins can get this
	if(!function_exists("current_user_can") || (!current_user_can("manage_options") && !current_user_can("tdp_membershiplevels")))
	{
		die(__("You do not have permissions to perform this action.", "tdp"));
	}	
	
	global $wpdb, $msg, $msgt, $tdp_currency_symbol;

	//some vars
	$gateway = tdp_getOption("gateway");
	global $tdp_stripe_error, $tdp_braintree_error, $tdp_payflow_error, $wp_version;
	
	if(isset($_REQUEST['edit']))
		$edit = $_REQUEST['edit'];	
	else
		$edit = false;
	if(isset($_REQUEST['copy']))
		$copy = $_REQUEST['copy'];
	if(isset($_REQUEST['s']))
		$s = $_REQUEST['s'];
	else
		$s = "";
	
	if(isset($_REQUEST['action']))
		$action = $_REQUEST['action'];
	else
		$action = false;
		
	if(isset($_REQUEST['saveandnext']))
		$saveandnext = $_REQUEST['saveandnext'];

	if(isset($_REQUEST['saveid']))
		$saveid = $_REQUEST['saveid'];
	if(isset($_REQUEST['deleteid']))
		$deleteid = $_REQUEST['deleteid'];

	if($action == "save_membershiplevel")
	{
		$ml_name = addslashes($_REQUEST['name']);
		$ml_description = $_REQUEST['description'];
		$ml_confirmation = $_REQUEST['confirmation'];
		$ml_posts_limit = $_REQUEST['posts_limit'];
		$ml_initial_payment = addslashes($_REQUEST['initial_payment']);
		if(!empty($_REQUEST['recurring']))
			$ml_recurring = 1;
		else
			$ml_recurring = 0;
		$ml_billing_amount = addslashes($_REQUEST['billing_amount']);
		$ml_cycle_number = addslashes($_REQUEST['cycle_number']);
		$ml_cycle_period = addslashes($_REQUEST['cycle_period']);		
		$ml_billing_limit = addslashes($_REQUEST['billing_limit']);
		if(!empty($_REQUEST['custom_trial']))
			$ml_custom_trial = 1;
		else
			$ml_custom_trial = 0;
		$ml_trial_amount = addslashes($_REQUEST['trial_amount']);
		$ml_trial_limit = addslashes($_REQUEST['trial_limit']);  
		if(!empty($_REQUEST['expiration']))
			$ml_expiration = 1;
		else
			$ml_expiration = 0;
		$ml_expiration_number = addslashes($_REQUEST['expiration_number']);
		$ml_expiration_period = addslashes($_REQUEST['expiration_period']);
		$ml_categories = array();
		
		//reversing disable to allow here
		if(empty($_REQUEST['disable_signups']))
			$ml_allow_signups = 1;
		else
			$ml_allow_signups = 0;

		foreach ( $_REQUEST as $key => $value )
		{
			if ( $value == 'yes' && preg_match( '/^membershipcategory_(\d+)$/i', $key, $matches ) )
			{
				$ml_categories[] = $matches[1];
			}
		}

		//clearing out values if checkboxes aren't checked
		if(empty($ml_recurring))
		{
			$ml_billing_amount = $ml_cycle_number = $ml_cycle_period = $ml_billing_limit = $ml_trial_amount = $ml_trial_limit = 0;
		}
		elseif(empty($ml_custom_trial))
		{
			$ml_trial_amount = $ml_trial_limit = 0;
		}
		if(empty($ml_expiration))
		{
			$ml_expiration_number = $ml_expiration_period = 0;
		}

		if($saveid > 0)
		{
			$sqlQuery = " UPDATE {$wpdb->tdp_membership_levels}
						SET name = '" . esc_sql($ml_name) . "',
						  description = '" . esc_sql($ml_description) . "',
						  confirmation = '" . esc_sql($ml_confirmation) . "',
						  posts_limit = '" . esc_sql($ml_posts_limit) . "',
						  initial_payment = '" . esc_sql($ml_initial_payment) . "',
						  billing_amount = '" . esc_sql($ml_billing_amount) . "',
						  cycle_number = '" . esc_sql($ml_cycle_number) . "',
						  cycle_period = '" . esc_sql($ml_cycle_period) . "',
						  billing_limit = '" . esc_sql($ml_billing_limit) . "',
						  trial_amount = '" . esc_sql($ml_trial_amount) . "',
						  trial_limit = '" . esc_sql($ml_trial_limit) . "',                    
						  expiration_number = '" . esc_sql($ml_expiration_number) . "',
						  expiration_period = '" . esc_sql($ml_expiration_period) . "',
						  allow_signups = '" . esc_sql($ml_allow_signups) . "'
						WHERE id = '$saveid' LIMIT 1;";	 
			$wpdb->query($sqlQuery);
			
			tdp_updateMembershipCategories( $saveid, $ml_categories );
			if(!mysql_errno())
			{
				$edit = false;
				$msg = 2;
				$msgt = __("Membership level updated successfully.", "tdp");
			}
			else
			{     
				$msg = -2;
				$msg = true;
				$msgt = __("Error updating membership level.", "tdp");
				$msgt .= mysql_errno();
				$msgt .= mysql_error();
			}
		}
		else
		{
			$sqlQuery = " INSERT INTO {$wpdb->tdp_membership_levels}
						( name, description, confirmation, posts_limit, initial_payment, billing_amount, cycle_number, cycle_period, billing_limit, trial_amount, trial_limit, expiration_number, expiration_period, allow_signups)
						VALUES
						( '" . esc_sql($ml_name) . "', '" . esc_sql($ml_description) . "', '" . esc_sql($ml_confirmation) . "', '" . esc_sql($ml_posts_limit) . "', '" . esc_sql($ml_initial_payment) . "', '" . esc_sql($ml_billing_amount) . "', '" . esc_sql($ml_cycle_number) . "', '" . esc_sql($ml_cycle_period) . "', '" . esc_sql($ml_billing_limit) . "', '" . esc_sql($ml_trial_amount) . "', '" . esc_sql($ml_trial_limit) . "', '" . esc_sql($ml_expiration_number) . "', '" . esc_sql($ml_expiration_period) . "', '" . esc_sql($ml_allow_signups) . "' )";
			$wpdb->query($sqlQuery);
			if(!mysql_errno())
			{
				$saveid = $wpdb->insert_id;
				tdp_updateMembershipCategories( $saveid, $ml_categories );
				
				$edit = false;
				$msg = 1;
				$msgt = __("Membership level added successfully.", "tdp");
			}
			else
			{
				$msg = -1;				
				$msgt = __("Error adding membership level.", "tdp");
				$msgt .= mysql_errno();
				$msgt .= mysql_error();
			}
		}
		
		do_action("tdp_save_membership_level", $saveid);
	}	
	elseif($action == "delete_membership_level")
	{
		global $wpdb;

		$ml_id = $_REQUEST['deleteid'];
	  
		if($ml_id > 0)
		{	  
			//remove any categories from the ml
			$sqlQuery = "DELETE FROM $wpdb->tdp_memberships_categories WHERE membership_id = '$ml_id'";	  			
			$r1 = $wpdb->query($sqlQuery);
							
			//cancel any subscriptions to the ml
			$r2 = true;
			$user_ids = $wpdb->get_col("SELECT user_id FROM $wpdb->tdp_memberships_users WHERE membership_id = '$ml_id' AND status = 'active'");			
			foreach($user_ids as $user_id)
			{
				//change there membership level to none. that will handle the cancel
				if(tdp_changeMembershipLevel(0, $user_id))
				{
					//okay
				}
				else
				{
					//couldn't delete the subscription
					//we should probably notify the admin	
					$tdpemail = new TDpEmail();			
					$tdpemail->data = array("body"=>"<p>" . sprintf(__("There was an error canceling the subscription for user with ID=%d. You will want to check your payment gateway to see if their subscription is still active.", "tdp"), $user_id) . "</p>");
					$last_order = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_orders WHERE user_id = '" . $user_id . "' ORDER BY timestamp DESC LIMIT 1");
					if($last_order)
						$tdpemail->data["body"] .= "<p>" . __("Last Invoice", "tdp") . ":<br />" . nl2br(var_export($last_order, true)) . "</p>";
					$tdpemail->sendEmail(get_bloginfo("admin_email"));	

					$r2 = false;
				}	
			}					
			
			//delete the ml
			$sqlQuery = "DELETE FROM $wpdb->tdp_membership_levels WHERE id = '$ml_id' LIMIT 1";	  			
			$r3 = $wpdb->query($sqlQuery);
					
			if($r1 !== FALSE && $r2 !== FALSE && $r3 !== FALSE)
			{
				$msg = 3;
				$msgt = __("Membership level deleted successfully.", "tdp");
			}
			else
			{
				$msg = -3;
				$msgt = __("Error deleting membership level.", "tdp");	
			}
		}
		else
		{
			$msg = -3;
			$msgt = __("Error deleting membership level.", "tdp");
		}
	}  
		
	require_once(dirname(__FILE__) . "/admin_header.php");		
?>

<?php		
	if($edit)
	{			
	?>
		
	<div>
		<?php
			// get the level...
			if(!empty($edit) && $edit > 0)
			{
				$level = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_levels WHERE id = '$edit' LIMIT 1", OBJECT);
				$temp_id = $level->id;
			}
			elseif(!empty($copy) && $copy > 0)		
			{	
				$level = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_levels WHERE id = '$copy' LIMIT 1", OBJECT);
				$temp_id = $level->id;
				$level->id = NULL;
			}
			else

			// didn't find a membership level, let's add a new one...
			if(empty($level))
			{
				$level = new stdClass();
				$level->id = NULL;
				$level->name = NULL;
				$level->description = NULL;
				$level->confirmation = NULL;
				$level->billing_amount = NULL;
				$level->posts_limit = NULL;
				$level->trial_amount = NULL;
				$level->initial_payment = NULL;
				$level->billing_limit = NULL;
				$level->trial_limit = NULL;
				$level->expiration_number = NULL;
				$level->expiration_period = NULL;
				$edit = -1;
			}	

			//defaults for new levels
			if(empty($copy) && $edit == -1)
			{			
				$level->cycle_number = 1;
				$level->cycle_period = "Month";
			}
			
			// grab the categories for the given level...
			if(!empty($temp_id))
				$level->categories = $wpdb->get_col("SELECT c.category_id
												FROM $wpdb->tdp_memberships_categories c
												WHERE c.membership_id = '" . $temp_id . "'");       		
			if(empty($level->categories))
				$level->categories = array();	
			
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<input name="saveid" type="hidden" value="<?php echo $edit?>" />
			<input type="hidden" name="action" value="save_membershiplevel" />

			<div class="postbox" id="first-box">

				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle newhandle">
					<span>
						<?php
							if($edit > 0)
								echo __("Edit Membership Level", "tdp");
							else
								echo __("Add New Membership Level", "tdp");
						?>
					</span>
				</h3>

				<div class="inside">
					
					<table class="form-table">
					<tbody>
						<tr>
							<th scope="row" valign="top"><label><?php _e('ID', 'tdp');?>:</label></th>
							<td>
								<?php echo $level->id?>						
							</td>
						</tr>								                
						
						<tr>
							<th scope="row" valign="top"><label for="name"><?php _e('Name', 'tdp');?>:</label></th>
							<td><input name="name" type="text" size="50" value="<?php echo str_replace("\"", "&quot;", stripslashes($level->name))?>" /></td>
						</tr>
						
						<tr>
							<th scope="row" valign="top"><label for="description"><?php _e('Description', 'tdp');?>:</label></th>
							<td>
								<div id="poststuff" class="tdp_description">						
								<?php 							
									if(version_compare($wp_version, "3.3") >= 0)
										wp_editor(stripslashes($level->description), "description", array("textarea_rows"=>5)); 
									else
									{
									?>
									<textarea rows="10" cols="80" name="description" id="description"><?php echo stripslashes($level->description)?></textarea>
									<?php
									}
								?>	
								</div>    
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top"><label for="confirmation"><?php _e('Confirmation Message', 'tdp');?>:</label></th>
							<td>
								<div class="tdp_confirmation">					
								<?php 
									if(version_compare($wp_version, "3.3") >= 0)
										wp_editor(stripslashes($level->confirmation), "confirmation", array("textarea_rows"=>5)); 
									else
									{
									?>
									<textarea rows="10" cols="80" name="confirmation" id="confirmation"><?php echo stripslashes($level->confirmation)?></textarea>	
									<?php
									}
								?>	
								</div>    
							</td>
						</tr>
					</tbody>
					</table>

				</div>

			</div>

			
			<div class="postbox" id="first-box">

				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle newhandle">
					<span>
						<?php _e('Billing Details', 'tdp');?>
					</span>
				</h3>

				<div class="inside">

						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row" valign="top"><label for="initial_payment"><?php _e('Membership Fee', 'tdp');?>:</label></th>
									<td><?php echo $tdp_currency_symbol?><input name="initial_payment" type="text" size="20" value="<?php echo str_replace("\"", "&quot;", stripslashes($level->initial_payment))?>" /> <small><?php _e('The initial amount collected at registration.', 'tdp');?></small></td>
								</tr>
								
								<tr>
									<th scope="row" valign="top"><label><?php _e('Recurring Subscription', 'tdp');?>:</label></th>
									<td><input id="recurring" name="recurring" type="checkbox" value="yes" <?php if(tdp_isLevelRecurring($level)) { echo "checked='checked'"; } ?> onclick="if(jQuery('#recurring').is(':checked')) { jQuery('.recurring_info').show(); if(jQuery('#custom_trial').is(':checked')) {jQuery('.trial_info').show();} else {jQuery('.trial_info').hide();} } else { jQuery('.recurring_info').hide();}" /> <small><?php _e('Check if this level has a recurring subscription payment.', 'tdp');?></small></td>
								</tr>
								
								<tr class="recurring_info" <?php if(!tdp_isLevelRecurring($level)) {?>style="display: none;"<?php } ?>>
									<th scope="row" valign="top"><label for="billing_amount"><?php _e('Billing Amount', 'tdp');?>:</label></th>
									<td>
										<?php echo $tdp_currency_symbol?><input name="billing_amount" type="text" size="20" value="<?php echo str_replace("\"", "&quot;", stripslashes($level->billing_amount))?>" /> <small><?php _e('per', 'tdp');?></small>
										<input id="cycle_number" name="cycle_number" type="text" size="10" value="<?php echo str_replace("\"", "&quot;", stripslashes($level->cycle_number))?>" />
										<select id="cycle_period" name="cycle_period">
										  <?php
											$cycles = array( __('Day(s)', 'tdp') => 'Day', __('Week(s)', 'tdp') => 'Week', __('Month(s)', 'tdp') => 'Month', __('Year(s)', 'tdp') => 'Year' );
											foreach ( $cycles as $name => $value ) {
											  echo "<option value='$value'";
											  if ( $level->cycle_period == $value ) echo " selected='selected'";
											  echo ">$name</option>";
											}
										  ?>
										</select>
										<br /><small>							
											<?php _e('The amount to be billed one cycle after the initial payment.', 'tdp');?>							
											<?php if($gateway == "stripe") { ?>
												<br /><strong <?php if(!empty($tdp_stripe_error)) { ?>class="tdp_red"<?php } ?>><?php _e('Stripe integration currently only supports billing periods of "Month" or "Year".', 'tdp');?>
											<?php } elseif($gateway == "braintree") { ?>
												<br /><strong <?php if(!empty($tdp_braintree_error)) { ?>class="tdp_red"<?php } ?>><?php _e('Braintree integration currently only supports billing periods of "Month" or "Year".', 'tdp');?>						
											<?php } elseif($gateway == "payflowpro") { ?>
												<br /><strong <?php if(!empty($tdp_payflow_error)) { ?>class="tdp_red"<?php } ?>><?php _e('Payflow integration currently only supports billing frequencies of 1 and billing periods of "Week", "Month" or "Year".', 'tdp');?>
											<?php } ?>
										</small>	
										<?php if($gateway == "braintree" && $edit < 0) { ?>
											<p class="tdp_message"><strong><?php _e('Note', 'tdp');?>:</strong> <?php _e('After saving this level, make note of the ID and create a "Plan" in your Braintree dashboard with the same settings and the "Plan ID" set to <em>tdp_#</em>, where # is the level ID.', 'tdp');?></p>
										<?php } elseif($gateway == "braintree") { ?>
											<p class="tdp_message"><strong><?php _e('Note', 'tdp');?>:</strong> <?php _e('You will need to create a "Plan" in your Braintree dashboard with the same settings and the "Plan ID" set to', 'tdp');?> <em>tdp_<?php echo $level->id;?></em>.</p>
										<?php } ?>						
									</td>
								</tr>                                        
								
								<tr class="recurring_info" <?php if(!tdp_isLevelRecurring($level)) {?>style="display: none;"<?php } ?>>
									<th scope="row" valign="top"><label for="billing_limit"><?php _e('Billing Cycle Limit', 'tdp');?>:</label></th>
									<td>
										<input name="billing_limit" type="text" size="20" value="<?php echo $level->billing_limit?>" />
										<br /><small>
											<?php _e('The <strong>total</strong> number of recurring billing cycles for this level, including the trial period (if applicable) but not including the initial payment. Set to zero if membership is indefinite.', 'tdp');?>							
											<?php if($gateway == "stripe") { ?>
												<br /><strong <?php if(!empty($tdp_stripe_error)) { ?>class="tdp_red"<?php } ?>><?php _e('Stripe integration currently does not support billing limits. You can still set an expiration date below.', 'tdp');?></strong>							
											<?php } ?>
										</small>
									</td>
								</tr>            								

								
													 
							</tbody>
						</table>

				</div>

			</div>
		
			<div class="postbox" id="first-box">

				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle newhandle">
					<span>
						<?php _e('Other Settings', 'tdp');?>
					</span>
				</h3>

				<div class="inside">

					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row" valign="top"><label><?php _e('Disable New Signups', 'tdp');?>:</label></th>
								<td><input name="disable_signups" type="checkbox" value="yes" <?php if($level->id && !$level->allow_signups) { ?>checked="checked"<?php } ?> /> <?php _e('Check to hide this level from the membership levels page and disable registration.', 'tdp');?></td>
							</tr>
							
							<tr>
								<th scope="row" valign="top"><label><?php _e('Membership Expiration', 'tdp');?>:</label></th>
								<td><input id="expiration" name="expiration" type="checkbox" value="yes" <?php if(tdp_isLevelExpiring($level)) { echo "checked='checked'"; } ?> onclick="if(jQuery('#expiration').is(':checked')) { jQuery('.expiration_info').show(); } else { jQuery('.expiration_info').hide();}" /> <?php _e('Check this to set when membership access expires.', 'tdp');?></td>
							</tr>
							
							<tr class="expiration_info" <?php if(!tdp_isLevelExpiring($level)) {?>style="display: none;"<?php } ?>>
								<th scope="row" valign="top"><label for="billing_amount"><?php _e('Expires In', 'tdp');?>:</label></th>
								<td>							
									<input id="expiration_number" name="expiration_number" type="text" size="10" value="<?php echo str_replace("\"", "&quot;", stripslashes($level->expiration_number))?>" />
									<select id="expiration_period" name="expiration_period">
									  <?php
										$cycles = array( 'Day(s)' => 'Day', 'Week(s)' => 'Week', 'Month(s)' => 'Month', 'Year(s)' => 'Year' );
										foreach ( $cycles as $name => $value ) {
										  echo "<option value='$value'";
										  if ( $level->expiration_period == $value ) echo " selected='selected'";
										  echo ">$name</option>";
										}
									  ?>
									</select>
									<br /><small><?php _e('Set the duration of membership access. Note that the any future payments (recurring subscription, if any) will be cancelled when the membership expires.', 'tdp');?></small>							
								</td>
							</tr> 								
						</tbody>
					</table>

					<?php do_action("tdp_membership_level_after_other_settings"); ?>				

				</div>

			</div>


			<div class="postbox" id="first-box">

				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle newhandle">
					<span>
						<?php _e('Posts Allowance', 'tdp');?>
					</span>
				</h3>

				<div class="inside">
					
					<table class="form-table">
						<tbody>

							<!--
							<tr>
								<th scope="row" valign="top"><label><?php _e('Categories', 'tdp');?>:</label></th>
								<td>
									<?php
									$categories = get_categories( array( 'hide_empty' => 0 ) );
									echo "<ul>";
									foreach ( $categories as $cat )
									{                               								
										$checked = in_array( $cat->term_id, $level->categories ) ? "checked='checked'" : '';
										echo "<li><input name='membershipcategory_{$cat->term_id}' type='checkbox' value='yes' $checked /> {$cat->name}</li>\n";
									}
									echo "</ul>";
									?>
								</td>
							</tr>
							-->

							<tr>
								<th scope="row" valign="top"><label for="posts_limit"><?php _e('Posts Allowance', 'tdp');?>:</label></th>
								<td>
									<input name="posts_limit" type="text" size="50" value="<?php echo str_replace("\"", "&quot;", stripslashes($level->posts_limit))?>" />
									<small><?php _e('Enter the amount of posts that you wish to add to this membership level.','tdp');?></small>
								</td>
							</tr>

						</tbody>
					</table>	

				</div>

			</div>
					
			<p class="submit ">
				<input name="save" type="submit" class="button-primary" value="<?php _e('Save Membership','tdp');?>" /> 					
				<input name="cancel" type="button" value="<?php _e('Cancel','tdp');?>" class="button" onclick="location.href='<?php echo get_admin_url(NULL, '/admin.php?page=tdp-membershiplevels')?>';" /> 					
			</p>
		
		</form>
	
	</div>
		
	<?php
	}	
	else
	{
	?>							
	<br/><br/>		
	<a href="admin.php?page=tdp-membershiplevels&edit=-1" class="button-primary"><?php _e('Add New Membership Level', 'tdp');?></a>
	<form id="posts-filter" method="get" action="">			
			
	</form>	
	
	<br class="clear" />
	
	<table class="widefat">
	<thead>
		<tr>
			<th><?php _e('ID', 'tdp');?></th>
			<th><?php _e('Name', 'tdp');?></th>
			<th><?php _e('Membership Fee', 'tdp');?></th>
			<th><?php _e('Billing Cycle', 'tdp');?></th>        
			<!-- <th><?php _e('Trial Cycle', 'tdp');?></th> -->
			<th><?php _e('Expiration', 'tdp');?></th>
			<th><?php _e('Allow Signups', 'tdp');?></th>
			<th><?php _e('Posts Allowance', 'tdp');?></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sqlQuery = "SELECT * FROM $wpdb->tdp_membership_levels ";
			if($s)
				$sqlQuery .= "WHERE name LIKE '%$s%' ";
			$sqlQuery .= "ORDER BY id ASC";
			
			$levels = $wpdb->get_results($sqlQuery, OBJECT);
						
			foreach($levels as $level)
			{			
		?>
		<tr class="<?php if(!$level->allow_signups) { ?>tdp_gray<?php } ?> <?php if(!tdp_checkLevelForStripeCompatibility($level) || !tdp_checkLevelForBraintreeCompatibility($level) || !tdp_checkLevelForPayflowCompatibility($level)) { ?>tdp_error<?php } ?>">			
			<td><?php echo $level->id?></td>
			<td><?php echo $level->name?></td>
			<td>
				<?php if(tdp_isLevelFree($level)) { ?>
					<?php _e('FREE', 'tdp');?>
				<?php } else { ?>
					<?php echo $tdp_currency_symbol?><?php echo $level->initial_payment?>
				<?php } ?>
			</td>
			<td>
				<?php if(!tdp_isLevelRecurring($level)) { ?>
					--
				<?php } else { ?>						
					<?php echo $tdp_currency_symbol?><?php echo $level->billing_amount?> <?php _e('every', 'tdp');?> <?php echo $level->cycle_number.' '.sornot($level->cycle_period,$level->cycle_number)?>
					
					<?php if($level->billing_limit) { ?>(<?php _e('for', 'tdp');?> <?php echo $level->billing_limit?> <?php echo sornot($level->cycle_period,$level->billing_limit)?>)<?php } ?>
					
				<?php } ?>
			</td>		
			<!--		
			<td>
				<?php if(!tdp_isLevelTrial($level)) { ?>
					--
				<?php } else { ?>		
					<?php echo $tdp_currency_symbol?><?php echo $level->trial_amount?> <?php _e('for', 'tdp');?> <?php echo $level->trial_limit?> <?php echo sornot("payment",$level->trial_limit)?>
				<?php } ?>
			</td>
			-->
			<td>
				<?php if(!tdp_isLevelExpiring($level)) { ?>
					--
				<?php } else { ?>		
					<?php _e('After', 'tdp');?> <?php echo $level->expiration_number?> <?php echo sornot($level->expiration_period,$level->expiration_number)?>
				<?php } ?>
			</td>
			
			<td><?php if($level->allow_signups) { ?><?php _e('Yes', 'tdp');?><?php } else { ?><?php _e('No', 'tdp');?><?php } ?></td>
			<td>
				<?php echo $level->posts_limit?>
			</td>
			<td align="center"><a href="admin.php?page=tdp-membershiplevels&edit=<?php echo $level->id?>" class="edit button"><?php _e('Edit Membership', 'tdp');?></a></td>
			<td align="center"><a href="admin.php?page=tdp-membershiplevels&copy=<?php echo $level->id?>&edit=-1" class="edit button"><?php _e('Duplicate', 'tdp');?></a></td>
			<td align="center"><a href="javascript: askfirst('<?php printf(__("Are you sure you want to delete membership level &quot;%s&quot;? All subscriptions will be cancelled.", "tdp"), $level->name);?>','admin.php?page=tdp-membershiplevels&action=delete_membership_level&deleteid=<?php echo $level->id?>'); void(0);" class="delete button button-secondary deletion"><?php _e('Delete', 'tdp');?></a></td>
		</tr>
		<?php
			}
		?>
	</tbody>
	</table>	
	<?php
	}
	?>		
	
<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>

