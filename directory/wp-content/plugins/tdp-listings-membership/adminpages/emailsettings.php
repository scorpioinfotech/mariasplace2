<?php
	//only admins can get this
	if(!function_exists("current_user_can") || (!current_user_can("manage_options") && !current_user_can("tdp_emailsettings")))
	{
		die(__("You do not have permissions to perform this action.", "tdp"));
	}	
	
	global $wpdb, $msg, $msgt;
	
	//get/set settings
	global $tdp_pages;
	if(!empty($_REQUEST['savesettings']))
	{                   		
		//email options
		tdp_setOption("from_email");
		tdp_setOption("from_name");

		tdp_setOption("email_admin_checkout");
		tdp_setOption("email_admin_changes");
		tdp_setOption("email_admin_cancels");
		tdp_setOption("email_admin_billing");
		
		tdp_setOption("email_member_notification");
		
		//assume success
		$msg = true;
		$msgt = "Your email settings have been updated.";		
	}
	
	$from_email = tdp_getOption("from_email");
	$from_name = tdp_getOption("from_name");
	
	$email_admin_checkout = tdp_getOption("email_admin_checkout");
	$email_admin_changes = tdp_getOption("email_admin_changes");
	$email_admin_cancels = tdp_getOption("email_admin_cancels");
	$email_admin_billing = tdp_getOption("email_admin_billing");	
	
	$email_member_notification = tdp_getOption("email_member_notification");
	
	if(empty($from_email))
	{
		$parsed = parse_url(home_url()); 
		$hostname = $parsed[host];
		$hostparts = split("\.", $hostname);				
		$email_domain = $hostparts[count($hostparts) - 2] . "." . $hostparts[count($hostparts) - 1];		
		$from_email = "wordpress@" . $email_domain;
		tdp_setOption("from_email", $from_email);
	}
	
	if(empty($from_name))
	{		
		$from_name = "WordPress";
		tdp_setOption("from_name", $from_name);
	}
				
	require_once(dirname(__FILE__) . "/admin_header.php");		
?>

	<form action="" method="post" enctype="multipart/form-data"> 
		
		<h3><?php _e('By default, system generated emails are sent from <em><strong>wordpress@yourdomain.com</strong></em>. You can update this from address using the fields below.', 'tdp');?></h3>
		
		<div class="postbox" id="first-box">

				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle newhandle">
					<span>
						<?php _e('Email Settings', 'tdp');?>
					</span>
				</h3>

				<div class="inside">

					<table class="form-table">
						<tbody>                
							<tr>
								<th scope="row" valign="top">
									<label for="from_email"><?php _e('From Email', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="from_email" size="60" value="<?php echo $from_email?>" />
								</td>
							</tr>
							<tr>
								<th scope="row" valign="top">
									<label for="from_name"><?php _e('From Name', 'tdp');?>:</label>
								</th>
								<td>
									<input type="text" name="from_name" size="60" value="<?php echo $from_name?>" />
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
						<?php _e('Send the site admin emails', 'tdp');?>
					</span>
				</h3>

				<div class="inside">

					<table class="form-table">
						<tbody>                
							<tr>
								<th scope="row" valign="top">
									<label for="email_admin_checkout"><?php _e('Checkout', 'tdp');?>:</label>
								</th>
								<td>
									<input type="checkbox" id="email_admin_checkout" name="email_admin_checkout" value="1" <?php if(!empty($email_admin_checkout)) { ?>checked="checked"<?php } ?> />
									<?php _e('when a member checks out.', 'tdp');?>
								</td>
							</tr>
							<tr>
								<th scope="row" valign="top">
									<label for="email_admin_changes"><?php _e('Admin Changes', 'tdp');?>:</label>
								</th>
								<td>
									<input type="checkbox" id="email_admin_changes" name="email_admin_changes" value="1" <?php if(!empty($email_admin_changes)) { ?>checked="checked"<?php } ?> />
									<?php _e('when an admin changes a user\'s membership level through the dashboard.', 'tdp');?>
								</td>
							</tr>
							<tr>
								<th scope="row" valign="top">
									<label for="email_admin_cancels"><?php _e('Cancellation', 'tdp');?>:</label>
								</th>
								<td>
									<input type="checkbox" id="email_admin_cancels" name="email_admin_cancels" value="1" <?php if(!empty($email_admin_cancels)) { ?>checked="checked"<?php } ?> />
									<?php _e('when a user cancels his or her account.', 'tdp');?>
								</td>
							</tr>
							<tr>
								<th scope="row" valign="top">
									<label for="email_admin_billing"><?php _e('Bill Updates', 'tdp');?>:</label>
								</th>
								<td>
									<input type="checkbox" id="email_admin_billing" name="email_admin_billing" value="1" <?php if(!empty($email_admin_billing)) { ?>checked="checked"<?php } ?> />
									<?php _e('when a user updates his or her billing information.', 'tdp');?>
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
						<?php _e('Send members emails', 'tdp');?>
					</span>
				</h3>

				<div class="inside">

					<table class="form-table">
						<tbody>                
							<tr>
								<th scope="row" valign="top">
									<label for="email_admin_checkout"><?php _e('New Users', 'tdp');?>:</label>
								</th>
								<td>
									<input type="checkbox" id="email_member_notification" name="email_member_notification" value="1" <?php if(!empty($email_member_notification)) { ?>checked="checked"<?php } ?> />
									<?php _e('Default WP notification email. (Recommended: Leave unchecked. Members will still get an email confirmation from TDp after checkout.)', 'tdp');?>
								</td>
							</tr>
						</tbody>
					</table>

				</div>
		
		</div>
		
		<p class="submit">            
			<input name="savesettings" type="submit" class="button-primary" value="Save Settings" /> 		                			
		</p>
		 
	</form>

<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>
