<?php
/*
	These functions add the "membership level" field to the edit user/profile page
*/


//add the fields
function tdp_membership_level_profile_fields($user)
{
	global $current_user, $tdp_currency_symbol;

	//print_r($current_user);

	$membership_level_capability = apply_filters("tdp_edit_member_capability", "manage_options");
	if(!current_user_can($membership_level_capability))
		return false;

	global $wpdb;
	/*$user->membership_level = $wpdb->get_row("SELECT l.id AS ID, l.name AS name
														FROM {$wpdb->tdp_membership_levels} AS l
														JOIN {$wpdb->tdp_memberships_users} AS mu ON (l.id = mu.membership_id)
														WHERE mu.user_id = " . $user->ID . "
														LIMIT 1");*/
	$user->membership_level = tdp_getMembershipLevelForUser($user->ID);

	$levels = $wpdb->get_results( "SELECT * FROM {$wpdb->tdp_membership_levels}", OBJECT );

	if(!$levels)
		return "";
?>
<h3><?php _e("Membership Level", "tdp"); ?></h3>
<table class="form-table">
    <?php
		$show_membership_level = true;
		$show_membership_level = apply_filters("tdp_profile_show_membership_level", $show_membership_level, $user);
		if($show_membership_level)
		{
		?>
		<tr>
			<th><label for="membership_level"><?php _e("Current Level", "tdp"); ?></label></th>
			<td>
				<select name="membership_level" onchange="tdp_mchange_warning();">
					<option value="" <?php if(empty($user->membership_level->ID)) { ?>selected="selected"<?php } ?>>-- <?php _e("None", "tdp");?> --</option>
				<?php
					foreach($levels as $level)
					{
						$current_level = ($user->membership_level->ID == $level->id);
				?>
					<option value="<?php echo $level->id?>" <?php if($current_level) { ?>selected="selected"<?php } ?>><?php echo $level->name?></option>
				<?php
					}
				?>
				</select>
				<script>
					var tdp_mchange_once = 0;
					function tdp_mchange_warning()
					{
						if(tdp_mchange_once == 0)
						{
							alert('Warning: The existing membership will be cancelled, and the new membership will be free.');
							tdp_mchange_once = 1;
						}
					}
				</script>
				<?php
					$membership_values = $wpdb->get_row("SELECT * FROM $wpdb->tdp_memberships_users WHERE status = 'active' AND user_id = '" . $user->ID . "' LIMIT 1");
					if(!empty($membership_values->billing_amount) || !empty($membership_values->trial_amount))
					{
					?>
						<?php if($membership_values->billing_amount > 0) { ?>
							<?php _e('at',"tdp");?> <?php echo $tdp_currency_symbol;?><?php echo $membership_values->billing_amount?>
							<?php if($membership_values->cycle_number > 1) { ?>
								<?php _e('per',"tdp");?> <?php echo $membership_values->cycle_number?> <?php echo sornot($membership_values->cycle_period,$membership_values->cycle_number)?>
							<?php } elseif($membership_values->cycle_number == 1) { ?>
								<?php _e('per',"tdp");?> <?php echo $membership_values->cycle_period?>
							<?php } ?>
						<?php } ?>

						<?php if($membership_values->billing_limit) { ?> <?php _e('for',"tdp");?> <?php echo $membership_values->billing_limit.' '.sornot($membership_values->cycle_period,$membership_values->billing_limit)?><?php } ?>.

						<?php if($membership_values->trial_limit) { ?>
							<?php _e('The first',"tdp");?> <?php echo $membership_values->trial_limit?> <?php echo sornot("payments",$membership_values->trial_limit)?> <?php _e('will cost',"tdp");?> <?php echo $tdp_currency_symbol;?><?php echo $membership_values->trial_amount?>.
						<?php } ?>
					<?php
					}
					else
					{
						_e("User is not paying.", "tdp");
					}
				?>
			</td>
		</tr>
		<tr>
			<th><label for="membership_posts_limitation"><?php _e("Original Membership Allowance", "tdp"); ?>:</label></th>
			<td><input type="text" name="membership_posts_limitation" id="membership_posts_limitation" value="<?php echo $user->membership_level->posts_limit;?>" class="regular-text"></td>
		</tr>
		<?php
		}
		
		$show_expiration = true;
		$show_expiration = apply_filters("tdp_profile_show_expiration", $show_expiration, $user);
		if($show_expiration)
		{					
			//is there an end date?
			$user->membership_level = tdp_getMembershipLevelForUser($user->ID);
			$end_date = !empty($user->membership_level->enddate);
			
			//some vars for the dates
			$current_day = date("j");			
			if($end_date)
				$selected_expires_day = date("j", $user->membership_level->enddate);
			else
				$selected_expires_day = $current_day;
				
			$current_month = date("M");			
			if($end_date)
				$selected_expires_month = date("m", $user->membership_level->enddate);
			else
				$selected_expires_month = date("m");
				
			$current_year = date("Y");									
			if($end_date)
				$selected_expires_year = date("Y", $user->membership_level->enddate);
			else
				$selected_expires_year = (int)$current_year + 1;
		?>
		<tr>
			<th><label for="expiration"><?php _e("Expires", "tdp"); ?></label></th>
			<td>
				<select id="expires" name="expires">
					<option value="0" <?php if(!$end_date) { ?>selected="selected"<?php } ?>><?php _e("No", "tdp");?></option>
					<option value="1" <?php if($end_date) { ?>selected="selected"<?php } ?>><?php _e("Yes", "tdp");?></option>
				</select>
				<span id="expires_date" <?php if(!$end_date) { ?>style="display: none;"<?php } ?>>
					on
					<select name="expires_month">
						<?php																
							for($i = 1; $i < 13; $i++)
							{
							?>
							<option value="<?php echo $i?>" <?php if($i == $selected_expires_month) { ?>selected="selected"<?php } ?>><?php echo date("M", strtotime($i . "/1/" . $current_year))?></option>
							<?php
							}
						?>
					</select>
					<input name="expires_day" type="text" size="2" value="<?php echo $selected_expires_day?>" />
					<input name="expires_year" type="text" size="4" value="<?php echo $selected_expires_year?>" />
				</span>
				<script>
					jQuery('#expires').change(function() {
						if(jQuery(this).val() == 1)
							jQuery('#expires_date').show();
						else
							jQuery('#expires_date').hide();
					});
				</script>
			</td>
		</tr>
		<?php
		}
		?>
</table>
<?php
}

//save the fields on update
function tdp_membership_level_profile_fields_update()
{
	//get the user id
	global $wpdb, $current_user, $user_ID;
	get_currentuserinfo();
	
	if(!empty($_REQUEST['user_id'])) 
		$user_ID = $_REQUEST['user_id'];

	$membership_level_capability = apply_filters("tdp_edit_member_capability", "manage_options");
	if(!current_user_can($membership_level_capability))
		return false;
		
	//level change
	if(isset($_REQUEST['membership_level']))
	{
		if(tdp_changeMembershipLevel($_REQUEST['membership_level'], $user_ID))
		{
			//it changed. send email
			$level_changed = true;
			

		}



	}

	if($_REQUEST['membership_posts_limitation'])
	{

		update_usermeta( $user_ID, 'allowance_limit', $_REQUEST['membership_posts_limitation'] );

	}
	

	//expiration change
	if(!empty($_REQUEST['expires']))
	{
		//update the expiration date
		$expiration_date = intval($_REQUEST['expires_year']) . "-" . intval($_REQUEST['expires_month']) . "-" . intval($_REQUEST['expires_day']);
		$sqlQuery = "UPDATE $wpdb->tdp_memberships_users SET enddate = '" . $expiration_date . "' WHERE status = 'active' AND user_id = '" . $user_ID . "' LIMIT 1";
		if($wpdb->query($sqlQuery))
			$expiration_changed = true;
	}
	elseif(isset($_REQUEST['expires']))
	{
		//already blank? have to check for null or '0000-00-00 00:00:00' or '' here.
		$sqlQuery = "SELECT user_id FROM $wpdb->tdp_memberships_users WHERE (enddate IS NULL OR enddate = '' OR enddate = '0000-00-00 00:00:00') AND status = 'active' AND user_id = '" . $user_ID . "' LIMIT 1";
		$blank = $wpdb->get_var($sqlQuery);
		
		if(empty($blank))
		{		
			//null out the expiration
			$sqlQuery = "UPDATE $wpdb->tdp_memberships_users SET enddate = NULL WHERE status = 'active' AND user_id = '" . $user_ID . "' LIMIT 1";
			if($wpdb->query($sqlQuery))
				$expiration_changed = true;
		}
	}
	
	//send email
	if(!empty($level_changed) || !empty($expiration_changed))
	{
		//email to member
		$tdpemail = new TDpEmail();
		if(!empty($expiration_changed))
			$tdpemail->expiration_changed = true;
		$tdpemail->sendAdminChangeEmail(get_userdata($user_ID));
		
		//email to admin
		$tdpemail = new TDpEmail();
		if(!empty($expiration_changed))
			$tdpemail->expiration_changed = true;
		$tdpemail->sendAdminChangeAdminEmail(get_userdata($user_ID));
	}
}
add_action( 'show_user_profile', 'tdp_membership_level_profile_fields' );
add_action( 'edit_user_profile', 'tdp_membership_level_profile_fields' );
add_action( 'profile_update', 'tdp_membership_level_profile_fields_update' );

/* TDP CUSTOM FIELD FOR FRONTEND */

add_action( 'show_user_profile', 'tdp_posts_allowance_field' );
add_action( 'edit_user_profile', 'tdp_posts_allowance_field' );

function tdp_posts_allowance_field( $user ) { ?>

	<h3><?php _e('Frontend Posting Allowance','tdp');?></h3>

	<table class="form-table">

		<tr>
			<th><label for="allowance_limit"><?php _e('Posts Left','tdp');?></label></th>

			<td>
				
				<?php echo get_the_author_meta( 'allowance_limit', $user->ID ); ?>
				

				<strong>
				<?php $is_available = get_the_author_meta( 'allowance_limit', $user->ID );

					if(empty($user->membership_level->ID)) {
					
						_e('It seems like that you don\'t have any post left, or any membership enabled.','tdp');

					} else {
						//echo $user->membership_level->posts_limit;
						//update_usermeta( $user->ID, 'allowance_limit', $user->membership_level->posts_limit );


					}

				?>
				</strong>

				</span>

			</td>
		</tr>

	</table>
<?php }

//add_action( 'personal_options_update', 'tdp_save_allowance_field' );
//add_action( 'edit_user_profile_update', 'tdp_save_allowance_field' );

function tdp_save_allowance_field( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	//update_usermeta( $user_id, 'allowance_limit', $user->membership_level->posts_limit );
	//update_usermeta( $user->ID, 'allowance_limit', $user->membership_level->posts_limit );
	//update_usermeta( $user_id, 'allowance_limit', $_GET['membership_posts_limitation'] );
}
