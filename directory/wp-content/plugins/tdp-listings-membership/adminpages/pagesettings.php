<?php
	//only admins can get this
	if(!function_exists("current_user_can") || (!current_user_can("manage_options") && !current_user_can("tdp_pagesettings")))
	{
		die(__("You do not have permissions to perform this action.", "tdp"));
	}	
	
	global $wpdb, $msg, $msgt;
			
	//get/set settings
	global $tdp_pages;
	if(!empty($_REQUEST['savesettings']))
	{                   		
		//page ids
		tdp_setOption("account_page_id");
		tdp_setOption("billing_page_id");
		tdp_setOption("cancel_page_id");
		tdp_setOption("checkout_page_id");
		tdp_setOption("confirmation_page_id");
		tdp_setOption("invoice_page_id");
		tdp_setOption("levels_page_id");
		
		//update the pages array
		$tdp_pages["account"] = tdp_getOption("account_page_id");
		$tdp_pages["billing"] = tdp_getOption("billing_page_id");
		$tdp_pages["cancel"] = tdp_getOption("cancel_page_id");
		$tdp_pages["checkout"] = tdp_getOption("checkout_page_id");
		$tdp_pages["confirmation"] = tdp_getOption("confirmation_page_id");
		$tdp_pages["invoice"] = tdp_getOption("invoice_page_id");
		$tdp_pages["levels"] = tdp_getOption("levels_page_id");	

		//assume success
		$msg = true;
		$msgt = "Your page settings have been updated.";		
	}	
			
	//are we generating pages?
	if(!empty($_REQUEST['createpages']))
	{
		global $tdp_pages;
		
		$pages_created = array();
		
		//check the pages array
		foreach($tdp_pages as $tdp_page_name => $tdp_page_id)
		{
			if(!$tdp_page_id)
			{
				//no id set. create an array to store the page info
				$insert = array(
					'post_title' => __('Membership', 'tdp') . ' ' . ucwords($tdp_page_name),
					'post_status' => 'publish',
					'post_type' => 'page',
					'post_content' => '[tdp_' . $tdp_page_name . ']',
					'comment_status' => 'closed',
					'ping_status' => 'closed'
					);
					
				//make non-account pages a subpage of account
				if($tdp_page_name != "account")
				{
					$insert['post_parent'] = $tdp_pages['account'];
				}				
				
				//create the page
				$tdp_pages[$tdp_page_name] = wp_insert_post( $insert );
				
				//add besecure post option to pages that need it
				/* these pages are handling this themselves in the preheader
				if(in_array($tdp_page_name, array("billing", "checkout")))
					update_post_meta($tdp_pages[$tdp_page_name], "besecure", 1);								
				*/
					
				//update the option too
				tdp_setOption($tdp_page_name . "_page_id", $tdp_pages[$tdp_page_name]);
				$pages_created[] = $tdp_pages[$tdp_page_name];			
			}
		}
		
		if(!empty($pages_created))
		{
			$msg = true;
			$msgt = __("The following pages have been created for you", "tdp") . ": " . implode(", ", $pages_created) . ".";
		}
	}		
	
	require_once(dirname(__FILE__) . "/admin_header.php");		
	?>
	

	<form action="" method="post" enctype="multipart/form-data">        	        			
		<?php
			global $tdp_pages_ready;
			if($tdp_pages_ready)
			{
			?>
			<?php
			} 
			else 
			{ 
			?>	
			<div class="updated">
				<p><?php _e('Assign the WordPress pages for each required page or', 'tdp');?> <a href="?page=tdp-pagesettings&createpages=1"><?php _e('click here to let us generate them for you', 'tdp');?></a>.</p>
         	</div>
			<?php
			}
		?>       			        
		<table class="form-table">
		<tbody>                
			<tr>
				<th scope="row" valign="top">                        
					<label for="account_page_id"><?php _e('Account Page', 'tdp');?>:</label>
				</th>
				<td>
					<?php
						wp_dropdown_pages(array("name"=>"account_page_id", "show_option_none"=>"-- Choose One --", "selected"=>$tdp_pages['account']));
					?>	
					<?php if(!empty($tdp_pages['account'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $tdp_pages['account']?>&action=edit" class="tdp_page_edit"><?php _e('edit page', 'tdp');?></a>
					<?php } ?>
					<br /><small class="tdp_lite"><?php _e('Include the shortcode', 'tdp');?> [tdp_account].</small>
				</td>
			<tr>
				<th scope="row" valign="top">
					<label for="billing_page_id"><?php _e('Billing Information Page', 'tdp');?>:</label>
				</th>
				<td>
					<?php
						wp_dropdown_pages(array("name"=>"billing_page_id", "show_option_none"=>"-- Choose One --", "selected"=>$tdp_pages['billing']));
					?>
					<?php if(!empty($tdp_pages['billing'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $tdp_pages['billing']?>&action=edit" class="tdp_page_edit"><?php _e('edit page', 'tdp');?></a>
					<?php } ?>
					<br /><small class="tdp_lite"><?php _e('Include the shortcode', 'tdp');?> [tdp_billing].</small>
				</td>
			<tr>
				<th scope="row" valign="top">	
					<label for="cancel_page_id"><?php _e('Cancel Page', 'tdp');?>:</label>
				</th>
				<td>
					<?php
						wp_dropdown_pages(array("name"=>"cancel_page_id", "show_option_none"=>"-- Choose One --", "selected"=>$tdp_pages['cancel']));
					?>	
					<?php if(!empty($tdp_pages['cancel'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $tdp_pages['cancel']?>&action=edit" class="tdp_page_edit"><?php _e('edit page', 'tdp');?></a>
					<?php } ?>
					<br /><small class="tdp_lite"><?php _e('Include the shortcode', 'tdp');?> [tdp_cancel].</small>
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">	
					<label for="checkout_page_id"><?php _e('Checkout Page', 'tdp');?>:</label>
				</th>
				<td>
					<?php
						wp_dropdown_pages(array("name"=>"checkout_page_id", "show_option_none"=>"-- Choose One --", "selected"=>$tdp_pages['checkout']));
					?>
					<?php if(!empty($tdp_pages['checkout'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $tdp_pages['checkout']?>&action=edit" class="tdp_page_edit"><?php _e('edit page', 'tdp');?></a>
					<?php } ?>
					<br /><small class="tdp_lite"><?php _e('Include the shortcode', 'tdp');?> [tdp_checkout].</small>
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">		
					<label for="confirmation_page_id"><?php _e('Confirmation Page', 'tdp');?>:</label>
				</th>
				<td>
					<?php
						wp_dropdown_pages(array("name"=>"confirmation_page_id", "show_option_none"=>"-- Choose One --", "selected"=>$tdp_pages['confirmation']));
					?>	
					<?php if(!empty($tdp_pages['confirmation'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $tdp_pages['confirmation']?>&action=edit" class="tdp_page_edit"><?php _e('edit page', 'tdp');?></a>
					<?php } ?>
					<br /><small class="tdp_lite"><?php _e('Include the shortcode', 'tdp');?> [tdp_confirmation].</small>
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">	
					<label for="invoice_page_id"><?php _e('Invoice Page', 'tdp');?>:</label>
				</th>
				<td>
					<?php
						wp_dropdown_pages(array("name"=>"invoice_page_id", "show_option_none"=>"-- Choose One --", "selected"=>$tdp_pages['invoice']));
					?>
					<?php if(!empty($tdp_pages['invoice'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $tdp_pages['invoice']?>&action=edit" class="tdp_page_edit"><?php _e('edit page', 'tdp');?></a>
					<?php } ?>
					<br /><small class="tdp_lite"><?php _e('Include the shortcode', 'tdp');?> [tdp_invoice].</small>
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">	
					<label for="levels_page_id"><?php _e('Levels Page', 'tdp');?>:</label>
				</th>
				<td>
					<?php
						wp_dropdown_pages(array("name"=>"levels_page_id", "show_option_none"=>"-- Choose One --", "selected"=>$tdp_pages['levels']));
					?>
					<?php if(!empty($tdp_pages['levels'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $tdp_pages['levels']?>&action=edit" class="tdp_page_edit"><?php _e('edit page', 'tdp');?></a>
					<?php } ?>
					<br /><small class="tdp_lite"><?php _e('Include the shortcode', 'tdp');?> [tdp_levels].</small>
				</td>
			</tr>				
		</tbody>
		</table>
		<p class="submit">            
			<input name="savesettings" type="submit" class="button-primary" value="<?php _e('Save Settings', 'tdp');?>" /> 		                			
		</p> 			
	</form>
	
<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>
