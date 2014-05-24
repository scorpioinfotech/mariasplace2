<?php
	//only admins can get this
	if(!function_exists("current_user_can") || (!current_user_can("manage_options") && !current_user_can("tdp_memberslist")))
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
			
	require_once(dirname(__FILE__) . "/admin_header.php");		
?>

	<form id="posts-filter" method="get" action="">	
		<a target="_blank" href="<?php echo admin_url('admin-ajax.php');?>?action=memberslist_csv&s=<?php echo $s?>&l=<?php echo $l?>" class="button-primary"><?php _e('Export to CSV', 'tdp');?></a>
	
		<br/>
	<ul class="subsubsub">
		<li>			
			<?php _e('Show', 'tdp');?>
			<select name="l" onchange="jQuery('#posts-filter').submit();">
				<option value="" <?php if(!$l) { ?>selected="selected"<?php } ?>><?php _e('All Levels', 'tdp');?></option>
				<?php
					$levels = $wpdb->get_results("SELECT id, name FROM $wpdb->tdp_membership_levels ORDER BY name");
					foreach($levels as $level)
					{
				?>
					<option value="<?php echo $level->id?>" <?php if($l == $level->id) { ?>selected="selected"<?php } ?>><?php echo $level->name?></option>
				<?php
					}
				?>
			</select>			
		</li>
	</ul>
	<!--
	<p class="search-box">
		<label class="hidden" for="post-search-input"><?php _e('Search Members', 'tdp');?>:</label>
		<input type="hidden" name="page" value="tdp-memberslist" />		
		<input id="post-search-input" type="text" value="<?php echo $s?>" name="s"/>
		<input class="button" type="submit" value="<?php _e('Search Members', 'tdp');?>"/>
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
			$sqlQuery = "SELECT SQL_CALC_FOUND_ROWS u.ID, u.user_login, u.user_email, UNIX_TIMESTAMP(u.user_registered) as joindate, mu.membership_id, mu.initial_payment, mu.billing_amount, mu.cycle_period, mu.cycle_number, mu.billing_limit, mu.trial_amount, mu.trial_limit, UNIX_TIMESTAMP(mu.startdate) as startdate, UNIX_TIMESTAMP(mu.enddate) as enddate, m.name as membership FROM $wpdb->users u LEFT JOIN $wpdb->usermeta um ON u.ID = um.user_id LEFT JOIN $wpdb->tdp_memberships_users mu ON u.ID = mu.user_id LEFT JOIN $wpdb->tdp_membership_levels m ON mu.membership_id = m.id WHERE mu.status = 'active' AND mu.membership_id > 0 AND (u.user_login LIKE '%$s%' OR u.user_email LIKE '%$s%' OR um.meta_value LIKE '%$s%') ";
		
			if($l)
				$sqlQuery .= " AND mu.membership_id = '" . $l . "' ";					
				
			$sqlQuery .= "GROUP BY u.ID ORDER BY user_registered DESC LIMIT $start, $limit";
		}
		else
		{
			$sqlQuery = "SELECT SQL_CALC_FOUND_ROWS u.ID, u.user_login, u.user_email, UNIX_TIMESTAMP(u.user_registered) as joindate, mu.membership_id, mu.initial_payment, mu.billing_amount, mu.cycle_period, mu.cycle_number, mu.billing_limit, mu.trial_amount, mu.trial_limit, UNIX_TIMESTAMP(mu.startdate) as startdate, UNIX_TIMESTAMP(mu.enddate) as enddate, m.name as membership FROM $wpdb->users u LEFT JOIN $wpdb->tdp_memberships_users mu ON u.ID = mu.user_id LEFT JOIN $wpdb->tdp_membership_levels m ON mu.membership_id = m.id";
			$sqlQuery .= " WHERE mu.membership_id > 0  AND mu.status = 'active' ";
			if($l)
				$sqlQuery .= " AND mu.membership_id = '" . $l . "' ";
			$sqlQuery .= "GROUP BY u.ID ORDER BY user_registered DESC LIMIT $start, $limit";
		}

		$sqlQuery = apply_filters("tdp_members_list_sql", $sqlQuery);
		
		$theusers = $wpdb->get_results($sqlQuery);
		$totalrows = $wpdb->get_var("SELECT FOUND_ROWS() as found_rows");
		
		if($theusers)
		{
			$calculate_revenue = apply_filters("tdp_memberslist_calculate_revenue", false);
			if($calculate_revenue)
			{
				$initial_payments = tdp_calculateInitialPaymentRevenue($s, $l);
				$recurring_payments = tdp_calculateRecurringRevenue($s, $l);			
				?>
				<p class="clear"><?php echo strval($totalrows)?> members found. These members have paid <strong>$<?php echo number_format($initial_payments)?> in initial payments</strong> and will generate an estimated <strong>$<?php echo number_format($recurring_payments)?> in revenue over the next year</strong>, or <strong>$<?php echo number_format($recurring_payments/12)?>/month</strong>. <span class="tdp_lite">(This estimate does not take into account trial periods or billing limits.)</span></p>
				<?php
			}
			else
			{
			?>
			<p class="clear"><?php printf(__("%d members found.", "tdp"), $totalrows);?></span></p>			
			<?php
			}
		}		
	?>
	<table class="widefat">
		<thead>
			<tr class="thead">
				<th><?php _e('ID', 'tdp');?></th>
				<th><?php _e('Username', 'tdp');?></th>
				<th><?php _e('First&nbsp;Name', 'tdp');?></th>
				<th><?php _e('Last&nbsp;Name', 'tdp');?></th>
				<th><?php _e('Email', 'tdp');?></th>
				<?php do_action("tdp_memberslist_extra_cols_header", $theusers);?>
				<th><?php _e('Billing Address', 'tdp');?></th>
				<th><?php _e('Membership', 'tdp');?></th>	
				<th><?php _e('Fee', 'tdp');?></th>
				<th><?php _e('Joined', 'tdp');?></th>
				<th><?php _e('Expires', 'tdp');?></th>
			</tr>
		</thead>
		<tbody id="users" class="list:user user-list">	
			<?php	
				$count = 0;							
				foreach($theusers as $auser)
				{
					//get meta																					
					$theuser = get_userdata($auser->ID);	
					?>
						<tr <?php if($count++ % 2 == 0) { ?>class="alternate"<?php } ?>>
							<td><?php echo $theuser->ID?></td>
							<td>
								<?php echo get_avatar($theuser->ID, 32)?>
								<strong>
									<?php
										$userlink = '<a href="user-edit.php?user_id=' . $theuser->ID . '">' . $theuser->user_login . '</a>';
										$userlink = apply_filters("tdp_members_list_user_link", $userlink, $theuser);
										echo $userlink;
									?>									
								</strong>
							</td>
							<td><?php echo $theuser->first_name?></td>
							<td><?php echo $theuser->last_name?></td>
							<td><a href="mailto:<?php echo $theuser->user_email?>"><?php echo $theuser->user_email?></a></td>
							<?php do_action("tdp_memberslist_extra_cols_body", $theuser);?>
							<td>
								<?php 
									if(empty($theuser->tdp_bfirstname))
										$theuser->tdp_bfirstname = "";
									if(empty($theuser->tdp_blastname))
										$theuser->tdp_blastname = "";
									echo trim($theuser->tdp_bfirstname . " " . $theuser->tdp_blastname);
								?><br />
								<?php if(!empty($theuser->tdp_baddress1)) { ?>
									<?php echo $theuser->tdp_baddress1; ?><br />
									<?php if(!empty($theuser->tdp_baddress2)) echo $theuser->tdp_baddress2 . "<br />"; ?>										
									<?php if($theuser->tdp_bcity && $theuser->tdp_bstate) { ?>
										<?php echo $theuser->tdp_bcity?>, <?php echo $theuser->tdp_bstate?> <?php echo $theuser->tdp_bzipcode?>  <?php if(!empty($theuser->tdp_bcountry)) echo $theuser->tdp_bcountry?><br />												
									<?php } ?>
								<?php } ?>
								<?php if(!empty($theuser->tdp_bphone)) echo formatPhone($theuser->tdp_bphone);?>
							</td>
							<td><?php echo $auser->membership?></td>	
							<td>										
								<?php if((float)$auser->initial_payment > 0) { ?>
									<?php echo $tdp_currency_symbol; ?><?php echo $auser->initial_payment?>
								<?php } ?>
								<?php if((float)$auser->initial_payment > 0 && (float)$auser->billing_amount > 0) { ?>+<br /><?php } ?>
								<?php if((float)$auser->billing_amount > 0) { ?>
									<?php echo $tdp_currency_symbol; ?><?php echo $auser->billing_amount?>/<?php echo $auser->cycle_period?>
								<?php } ?>
								<?php if((float)$auser->initial_payment <= 0 && (float)$auser->billing_amount <= 0) { ?>
									-
								<?php } ?>
							</td>						
							<td><?php echo date("m/d/Y", strtotime($theuser->user_registered))?></td>
							<td>
								<?php 
									if($auser->enddate) 
										echo date(get_option('date_format'), $auser->enddate);
									else
										echo __("Never", "tdp");
								?>
							</td>
						</tr>
					<?php
				}
				
				if(!$theusers)
				{
				?>
				<tr>
					<td colspan="9"><p><?php _e("No members found.", "tdp");?> <?php if($l) { ?><a href="?page=tdp-memberslist&s=<?php echo $s?>"><?php _e("Search all levels", "tdp");?></a>.<?php } ?></p></td>
				</tr>
				<?php
				}
			?>		
		</tbody>
	</table>
	</form>
	
	<?php
	echo tdp_getPaginationString($pn, $totalrows, $limit, 1, get_admin_url(NULL, "/admin.php?page=tdp-memberslist&s=" . urlencode($s)), "&l=$l&limit=$limit&pn=");
	?>
	
<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>