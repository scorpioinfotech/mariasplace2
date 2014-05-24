<?php
	//only admins can get this
	if(!function_exists("current_user_can") || !current_user_can("manage_options"))
	{
		die(__("You do not have permissions to perform this action.", "tdp"));
	}	
	
	global $wpdb, $msg, $msgt;
	
	//get/set settings	
	if(!empty($_REQUEST['savesettings']))
	{                   		
		//other settings
		tdp_setOption("nonmembertext");
		tdp_setOption("notloggedintext");
		tdp_setOption("rsstext");		
		tdp_setOption("showexcerpts");
		tdp_setOption("hideads");
		tdp_setOption("hideadslevels");
		tdp_setOption("redirecttosubscription");					
						
		//captcha
		tdp_setOption("recaptcha");
		tdp_setOption("recaptcha_publickey");
		tdp_setOption("recaptcha_privatekey");					
		
		//tos
		tdp_setOption("tospage");		
		
		//footer link
		tdp_setOption("hide_footer_link");
		
		//assume success
		$msg = true;
		$msgt = __("Your advanced settings have been updated.", "tdp");	
	}

	$nonmembertext = tdp_getOption("nonmembertext");
	$notloggedintext = tdp_getOption("notloggedintext");
	$rsstext = tdp_getOption("rsstext");	
	$hideads = tdp_getOption("hideads");
	$showexcerpts = tdp_getOption("showexcerpts");
	$hideadslevels = tdp_getOption("hideadslevels");
	
	if(is_multisite())
		$redirecttosubscription = tdp_getOption("redirecttosubscription");
	
	$recaptcha = tdp_getOption("recaptcha");
	$recaptcha_publickey = tdp_getOption("recaptcha_publickey");
	$recaptcha_privatekey = tdp_getOption("recaptcha_privatekey");
	
	$tospage = tdp_getOption("tospage");
	
	$hide_footer_link = tdp_getOption("hide_footer_link");
		
	//default settings
	if(!$nonmembertext)
	{
		$nonmembertext = "This content is for !!levels!! members only. <a href=\"" . wp_login_url() . "?action=register\">Register here</a>.";
		tdp_setOption("nonmembertext", $nonmembertext);
	}			
	if(!$notloggedintext)
	{
		$notloggedintext = "Please <a href=\"" . wp_login_url( get_permalink() ) . "\">login</a> to view this content. (<a href=\"" . wp_login_url() . "?action=register\">Register here</a>.)";
		tdp_setOption("notloggedintext", $notloggedintext);
	}			
	if(!$rsstext)
	{
		$rsstext = "This content is for members only. Visit the site and log in/register to read.";
		tdp_setOption("rsstext", $rsstext);
	}   				
		
	$levels = $wpdb->get_results( "SELECT * FROM {$wpdb->tdp_membership_levels}", OBJECT );
	
	require_once(dirname(__FILE__) . "/admin_header.php");		
?>

	<form action="" method="post" enctype="multipart/form-data"> 

		<div class="postbox" id="first-box">

				<div class="handlediv" title="Click to toggle"><br></div>

				<h3 class="hndle newhandle">
					<span>
						<?php _e('Advanced Settings', 'tdp');?>
					</span>
				</h3>

				<div class="inside">



					<table class="form-table">
					<tbody>    

						<tr>
							<th scope="row" valign="top">
								<label for="tospage"><?php _e('Require Terms of Service on signups?', 'tdp');?></label>
							</th>
							<td>
								<?php
									wp_dropdown_pages(array("name"=>"tospage", "show_option_none"=>"No", "selected"=>$tospage));
								?>
								<br />
								<small><?php _e('If yes, create a WordPress page containing your TOS agreement and assign it using the dropdown above.', 'tdp');?></small>
							</td>
						</tr> 

						<!---            
						<tr>
							<th scope="row" valign="top">
								<label for="nonmembertext"><?php _e('Message for Logged-in Non-members', 'tdp');?>:</label>
							</th>
							<td>
								<textarea name="nonmembertext" rows="3" cols="80"><?php echo stripslashes($nonmembertext)?></textarea><br />
								<small class="litegray"><?php _e('This message replaces the post content for non-members. Available variables', 'tdp');?>: !!levels!!, !!referrer!!</small>
							</td>
						</tr> 
						<tr>
							<th scope="row" valign="top">
								<label for="notloggedintext"><?php _e('Message for Logged-out Users', 'tdp');?>:</label>
							</th>
							<td>
								<textarea name="notloggedintext" rows="3" cols="80"><?php echo stripslashes($notloggedintext)?></textarea><br />
								<small class="litegray"><?php _e('This message replaces the post content for logged-out visitors.', 'tdp');?></small>
							</td>
						</tr> 
						<tr>
							<th scope="row" valign="top">
								<label for="rsstext"><?php _e('Message for RSS Feed', 'tdp');?>:</label>
							</th>
							<td>
								<textarea name="rsstext" rows="3" cols="80"><?php echo stripslashes($rsstext)?></textarea><br />
								<small class="litegray"><?php _e('This message replaces the post content in RSS feeds.', 'tdp');?></small>
							</td>
						</tr> 
						
						<tr>
							<th scope="row" valign="top">
								<label for="showexcerpts"><?php _e('Show Excerpts to Non-Members?', 'tdp');?></label>
							</th>
							<td>
								<select id="showexcerpts" name="showexcerpts">
									<option value="0" <?php if(!$showexcerpts) { ?>selected="selected"<?php } ?>><?php _e('No - Hide excerpts.', 'tdp');?></option>
									<option value="1" <?php if($showexcerpts == 1) { ?>selected="selected"<?php } ?>><?php _e('Yes - Show excerpts.', 'tdp');?></option>  
								</select>                        
							</td>
						</tr> 
						<tr>
							<th scope="row" valign="top">
								<label for="hideads">Hide Ads From Members?</label>
							</th>
							<td>
								<select id="hideads" name="hideads" onchange="tdp_updateHideAdsTRs();">
									<option value="0" <?php if(!$hideads) { ?>selected="selected"<?php } ?>><?php _e('No', 'tdp');?></option>
									<option value="1" <?php if($hideads == 1) { ?>selected="selected"<?php } ?>><?php _e('Hide Ads From All Members', 'tdp');?></option>
									<option value="2" <?php if($hideads == 2) { ?>selected="selected"<?php } ?>><?php _e('Hide Ads From Certain Members', 'tdp');?></option>
								</select>                        
							</td>
						</tr> 				
						<tr id="hideads_explanation" <?php if($hideads < 2) { ?>style="display: none;"<?php } ?>>
							<th scope="row" valign="top">&nbsp;</th>
							<td>
								<p class="top0em"><?php _e('Ads from the following plugins will be automatically turned off', 'tdp');?>: <em>Easy Adsense</em>, ...</p>
								<p><?php _e('To hide ads in your template code, use code like the following', 'tdp');?>:</p>
							<pre lang="PHP">
			if(tdp_displayAds())
			{
			//insert ad code here
			}
							</pre>                   
							</td>
						</tr>                           
						<tr id="hideadslevels_tr" <?php if($hideads != 2) { ?>style="display: none;"<?php } ?>>
							<th scope="row" valign="top">
								<label for="hideadslevels"><?php _e('Choose Levels to Hide Ads From', 'tdp');?>:</label>
							</th>
							<td>
								<div class="checkbox_box" <?php if(count($levels) > 5) { ?>style="height: 100px; overflow: auto;"<?php } ?>>
									<?php 																
										$hideadslevels = tdp_getOption("hideadslevels");
										if(!is_array($hideadslevels))
											$hideadslevels = explode(",", $hideadslevels);
										
										$sqlQuery = "SELECT * FROM $wpdb->tdp_membership_levels ";						
										$levels = $wpdb->get_results($sqlQuery, OBJECT);								
										foreach($levels as $level) 
										{ 
									?>
										<div class="clickable"><input type="checkbox" id="hideadslevels_<?php echo $level->id?>" name="hideadslevels[]" value="<?php echo $level->id?>" <?php if(in_array($level->id, $hideadslevels)) { ?>checked="checked"<?php } ?>> <?php echo $level->name?></div>
									<?php 
										} 
									?>
								</div> 
								<script>
									jQuery('.checkbox_box input').click(function(event) {
										event.stopPropagation()
									});

									jQuery('.checkbox_box div.clickable').click(function() {							
										var checkbox = jQuery(this).find(':checkbox');
										checkbox.attr('checked', !checkbox.attr('checked'));
									});
								</script>
							</td>
						</tr> 
						<?php if(is_multisite()) { ?>
						<tr>
							<th scope="row" valign="top">
								<label for="redirecttosubscription"><?php _e('Redirect all traffic from registration page to /susbcription/?', 'tdp');?>: <em>(<?php _e('multisite only', 'tdp');?>)</em></label>
							</th>
							<td>
								<select id="redirecttosubscription" name="redirecttosubscription">
									<option value="0" <?php if(!$redirecttosubscription) { ?>selected="selected"<?php } ?>><?php _e('No', 'tdp');?></option>
									<option value="1" <?php if($redirecttosubscription == 1) { ?>selected="selected"<?php } ?>><?php _e('Yes', 'tdp');?></option>                           
								</select>                        
							</td>
						</tr> 
						<?php } ?>	

						-->			
						<tr>
							<th scope="row" valign="top">
								<label for="recaptcha"><?php _e('Use reCAPTCHA?', 'tdp');?>:</label>
							</th>
							<td>
								<select id="recaptcha" name="recaptcha" onchange="tdp_updateRecaptchaTRs();">
									<option value="0" <?php if(!$recaptcha) { ?>selected="selected"<?php } ?>><?php _e('No', 'tdp');?></option>
									<option value="1" <?php if($recaptcha == 1) { ?>selected="selected"<?php } ?>><?php _e('Yes - Free memberships only.', 'tdp');?></option>    
									<option value="2" <?php if($recaptcha == 2) { ?>selected="selected"<?php } ?>><?php _e('Yes - All memberships.', 'tdp');?></option>
								</select><br />
								<small><?php _e('A free reCAPTCHA key is required.', 'tdp');?> <a href="https://www.google.com/recaptcha/admin/create"><?php _e('Click here to signup for reCAPTCHA', 'tdp');?></a>.</small>						
							</td>
						</tr> 
						<tr id="recaptcha_tr" <?php if(!$recaptcha) { ?>style="display: none;"<?php } ?>>
							<th scope="row" valign="top">&nbsp;</th>
							<td>                        
								<label for="recaptcha_publickey"><?php _e('reCAPTCHA Public Key', 'tdp');?>:</label>
								<input type="text" name="recaptcha_publickey" size="60" value="<?php echo $recaptcha_publickey?>" />
								<br /><br />
								<label for="recaptcha_privatekey"><?php _e('reCAPTCHA Private Key', 'tdp');?>:</label>
								<input type="text" name="recaptcha_privatekey" size="60" value="<?php echo $recaptcha_privatekey?>" />						
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="tospage"><?php _e('Require Terms of Service on signups?', 'tdp');?></label>
							</th>
							<td>
								<?php
									wp_dropdown_pages(array("name"=>"tospage", "show_option_none"=>"No", "selected"=>$tospage));
								?>
								<br />
								<small><?php _e('If yes, create a WordPress page containing your TOS agreement and assign it using the dropdown above.', 'tdp');?></small>
							</td>
						</tr> 
						
						<?php /*
						<tr>
							<th scope="row" valign="top">
								<label for="hide_footer_link">Hide the TDp Link in the Footer?</label>
							</th>
							<td>
								<select id="hide_footer_link" name="hide_footer_link">
									<option value="0" <?php if(!$hide_footer_link) { ?>selected="selected"<?php } ?>>No - Leave the link. (Thanks!)</option>
									<option value="1" <?php if($hide_footer_link == 1) { ?>selected="selected"<?php } ?>>Yes - Hide the link.</option>  
								</select>                        
							</td>
						</tr> 
						*/ ?>
					</tbody>
					</table>
					<script>
						function tdp_updateHideAdsTRs()
						{
							var hideads = jQuery('#hideads').val();
							if(hideads == 2) 
							{
								jQuery('#hideadslevels_tr').show();
							} 
							else
							{
								jQuery('#hideadslevels_tr').hide();
							}
							
							if(hideads > 0) 
							{
								jQuery('#hideads_explanation').show();
							} 
							else
							{
								jQuery('#hideads_explanation').hide();
							}
						}
						tdp_updateHideAdsTRs();
						
						function tdp_updateRecaptchaTRs()
						{
							var recaptcha = jQuery('#recaptcha').val();
							if(recaptcha > 0) 
							{
								jQuery('#recaptcha_tr').show();
							} 
							else
							{
								jQuery('#recaptcha_tr').hide();
							}										
						}
						tdp_updateRecaptchaTRs();
					</script>


				</div>

		</div>
		
		<p class="submit">            
			<input name="savesettings" type="submit" class="button-primary" value="<?php _e('Save Settings', 'tdp');?>" /> 		                			
		</p> 
	</form>

<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>
