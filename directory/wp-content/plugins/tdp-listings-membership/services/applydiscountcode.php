<?php
	global $isapage;
	$isapage = true;		
	
	//in case the file is loaded directly
	if(!defined("WP_USE_THEMES"))
	{
		define('WP_USE_THEMES', false);
		require_once(dirname(__FILE__) . '/../../../../wp-load.php');
	}
	
	//vars
	global $wpdb;
	if(!empty($_REQUEST['code']))
	{
		$discount_code = preg_replace("/[^A-Za-z0-9]/", "", $_REQUEST['code']);
		$discount_code_id = $wpdb->get_var("SELECT id FROM $wpdb->tdp_discount_codes WHERE code = '" . $discount_code . "' LIMIT 1");
	}
	else
	{
		$discount_code = "";
		$discount_code_id = "";
	}
	
	if(!empty($_REQUEST['level']))
		$level_id = (int)$_REQUEST['level'];
	else
		$level_id = NULL;
		
	if(!empty($_REQUEST['msgfield']))
		$msgfield = preg_replace("/[^A-Za-z0-9\_\-]/", "", $_REQUEST['msgfield']);
	else
		$msgfield = NULL;	
	
	//check that the code is valid
	$codecheck = tdp_checkDiscountCode($discount_code, $level_id, true);
	if($codecheck[0] == false)
	{
		//uh oh. show code error
		echo tdp_no_quotes($codecheck[1]);
		?>
		<script>			
			jQuery('#<?php echo $msgfield?>').show();
			jQuery('#<?php echo $msgfield?>').removeClass('tdp_success');
			jQuery('#<?php echo $msgfield?>').addClass('tdp_error');
			jQuery('#<?php echo $msgfield?>').addClass('tdp_discount_code_msg');
		</script>
		<?php
		
		exit(0);
	}			
	
	//okay, send back new price info
	$sqlQuery = "SELECT l.id, cl.*, l.name, l.description, l.allow_signups FROM $wpdb->tdp_discount_codes_levels cl LEFT JOIN $wpdb->tdp_membership_levels l ON cl.level_id = l.id LEFT JOIN $wpdb->tdp_discount_codes dc ON dc.id = cl.code_id WHERE dc.code = '" . $discount_code . "' AND cl.level_id = '" . $level_id . "' LIMIT 1";			
	$code_level = $wpdb->get_row($sqlQuery);
	
	//if the discount code doesn't adjust the level, let's just get the straight level
	if(empty($code_level))
		$code_level = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_levels WHERE id = '" . $level_id . "' LIMIT 1");

	//filter adjustments to the level
	$code_level = apply_filters("tdp_discount_code_level", $code_level, $discount_code_id);
	?>
	The discount code has been applied to your order.
	<script>		
		var code_level = <?php echo json_encode($code_level); ?>;				
		
		jQuery('#<?php echo $msgfield?>').show();
		jQuery('#<?php echo $msgfield?>').removeClass('tdp_error');
		jQuery('#<?php echo $msgfield?>').addClass('tdp_success');
		jQuery('#<?php echo $msgfield?>').addClass('tdp_discount_code_msg');
		
		jQuery('#other_discount_code_tr').hide();
		jQuery('#other_discount_code_p').html('<a id="other_discount_code_a" href="javascript:void(0);"><?php _e('Click here to change your discount code', 'tdp');?></a>.');
		jQuery('#other_discount_code_p').show();
		
		jQuery('#other_discount_code_a').click(function() {
			jQuery('#other_discount_code_tr').show();
			jQuery('#other_discount_code_p').hide();			
		});
		
		jQuery('#tdp_level_cost').html('<?php printf(__('The <strong>%s</strong> code has been applied to your order.', 'tdp'), $discount_code);?><?php echo tdp_no_quotes(tdp_getLevelCost($code_level), array('"', "'", "\n", "\r"))?>');
		
		<?php
			//tell gateway javascripts whether or not to fire (e.g. no Stripe on free levels)
			if(tdp_isLevelFree($code_level))
			{
			?>
				tdp_require_billing = false;
			<?php
			}			
			else
			{
			?>
				tdp_require_billing = true;
			<?php
			}
			
			//hide/show billing
			if(tdp_isLevelFree($code_level) || tdp_getOption("gateway") == "paypalexpress" || tdp_getOption("gateway") == "paypalstandard")
			{				
				?>
				jQuery('#tdp_billing_address_fields').hide();
				jQuery('#tdp_payment_information_fields').hide();			
				<?php
			}
			else			
			{
				?>			
				jQuery('#tdp_billing_address_fields').show();
				jQuery('#tdp_payment_information_fields').show();			
				<?php
			}
			
			//hide/show paypal button
			if(tdp_getOption("gateway") == "paypalexpress" || tdp_getOption("gateway") == "paypalstandard")			
			{
				if(tdp_isLevelFree($code_level))
				{
					?>					
					jQuery('#tdp_paypalexpress_checkout').hide();
					jQuery('#tdp_submit_span').show();
					<?php
				}
				else
				{
					?>					
					jQuery('#tdp_submit_span').hide();
					jQuery('#tdp_paypalexpress_checkout').show();				
					<?php
				}
			}
		?>
	</script>
