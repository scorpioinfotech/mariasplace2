<?php
	require_once(dirname(__FILE__) . "/functions.php");
	
	if(isset($_REQUEST['page']))
		$view = $_REQUEST['page'];
	else
		$view = "";
	
$screen = get_current_screen();

	global $tdp_ready, $msg, $pagenow, $msgt;
	$tdp_ready = tdp_is_ready();
	if(!$tdp_ready)
	{
		global $tdp_level_ready, $tdp_gateway_ready, $tdp_pages_ready;		
		if(!isset($edit))
		{
			if(isset($_REQUEST['edit']))
				$edit = $_REQUEST['edit'];
			else
				$edit = false;
		}
		
		if(empty($msg))
			$msg = -1;		
		if(empty($tdp_level_ready) && empty($edit))
			$msgt .= " <a href=\"?page=tdp-membershiplevels&edit=-1\">" . __("Add a membership level to get started.", "tdp") . "</a>";
		elseif($tdp_level_ready && !$tdp_pages_ready && $view != "tdp-pagesettings")
			$msgt .= " <a href=\"?page=tdp-pagesettings\">" . __("Setup the membership pages", "tdp") . "</a>.";		
		elseif($tdp_level_ready && $tdp_pages_ready && !$tdp_gateway_ready && $view != "tdp-paymentsettings")
			$msgt .= " <a href=\"?page=tdp-paymentsettings\">" . __("Setup your SSL certificate and payment gateway", "tdp") . "</a>.";
			
		if(empty($msgt))
			$msg = false;
	}
	
	if(!tdp_checkLevelForStripeCompatibility())
	{		
		$msg = -1;
		$msgt = __("The billing details for some of your membership levels is not supported by Stripe.", "tdp");
		if($view == "tdp-membershiplevels" && !empty($_REQUEST['edit']) && $_REQUEST['edit'] > 0)
		{
			if(!tdp_checkLevelForStripeCompatibility($_REQUEST['edit']))
			{
				global $tdp_stripe_error;
				$tdp_stripe_error = true;
				$msg = -1;
				$msgt = __("The billing details for this level are not supported by Stripe. Please review the notes in the Billing Details section below.", "tdp");				
			}			
		}
		elseif($view == "tdp-membershiplevels")
			$msgt .= " " . __("The levels with issues are highlighted below.", "tdp");
		else
			$msgt .= " <a href=\"?page=tdp-membershiplevels\">" . __("Please edit your levels", "tdp") . "</a>.";			
	}
	
	if(!tdp_checkLevelForPayflowCompatibility())
	{				
		$msg = -1;
		$msgt = __("The billing details for some of your membership levels is not supported by Payflow.", "tdp");
		if($view == "tdp-membershiplevels" && !empty($_REQUEST['edit']) && $_REQUEST['edit'] > 0)
		{
			if(!tdp_checkLevelForPayflowCompatibility($_REQUEST['edit']))
			{
				global $tdp_payflow_error;
				$tdp_payflow_error = true;
				$msg = -1;
				$msgt = __("The billing details for this level are not supported by Payflow. Please review the notes in the Billing Details section below.", "tdp");
			}			
		}
		elseif($view == "tdp-membershiplevels")
			$msgt .= " " . __("The levels with issues are highlighted below.", "tdp");
		else
			$msgt .= " <a href=\"?page=tdp-membershiplevels\">" . __("Please edit your levels", "tdp") . "</a>.";			
	}
	
	if(!tdp_checkLevelForBraintreeCompatibility())
	{		
		$msg = -1;
		$msgt = __("The billing details for some of your membership levels is not supported by Braintree.", "tdp");
		if($view == "tdp-membershiplevels" && !empty($_REQUEST['edit']) && $_REQUEST['edit'] > 0)
		{
			if(!tdp_checkLevelForBraintreeCompatibility($_REQUEST['edit']))
			{
				global $tdp_braintree_error;
				$tdp_braintree_error = true;
				$msg = -1;
				$msgt = __("The billing details for this level are not supported by Braintree. Please review the notes in the Billing Details section below.", "tdp");
			}			
		}
		elseif($view == "tdp-membershiplevels")
			$msgt .= " " . __("The levels with issues are highlighted below.", "tdp");
		else
			$msgt .= " <a href=\"?page=tdp-membershiplevels\">" . __("Please edit your levels", "tdp") . "</a>.";			
	}
	
	if(!empty($msg))
	{
	?>
		<div id="message" class="<?php if($msg > 0) echo "updated fade"; else echo "error"; ?>"><p><?php echo $msgt?></p></div>
	<?php
	}		

?>

<div class="wrap about-wrap" style="max-width:100%; margin-bottom:-30px; margin-left:0px; padding-left:0px;">

<?php if($screen->base == 'memberships_page_tdp-memberslist') { ?>

<h1 style="margin-bottom:-20px;"><?php echo wp_get_theme();?> <?php _e('Members Overview','tdp');?></h1>

<?php } else if($screen->base == 'memberships_page_tdp-orders') { ?>

<h1 style="margin-bottom:-20px;"><?php echo wp_get_theme();?> <?php _e('Transactions Management','tdp');?></h1>

<?php } else { ?>

<h1 style="margin-bottom:-20px;"><?php echo wp_get_theme();?> <?php _e('Memberships Manager','tdp');?></h1>

<?php } ?>

<div class="about-text">

	<?php 

	if($screen->base == 'toplevel_page_tdp-membershiplevels'){

		_e('The membership system allows you to create different memberships required to post from the frontend.','tdp');

	} else if($screen->base == 'memberships_page_tdp-pagesettings'){ 

		_e('Here you can configure the required pages for the membership system to work.','tdp');

	} else if($screen->base == 'memberships_page_tdp-paymentsettings'){ 

		_e('Configure the payment method you want to use. And setup your SSL (Optional)','tdp');

	} else if($screen->base == 'memberships_page_tdp-emailsettings'){ 

		_e('Select when you want to send notifications.','tdp');

	} else if($screen->base == 'memberships_page_tdp-advancedsettings'){	

		_e('Manage Advanced Settings Here.','tdp');

	} else if($screen->base == 'memberships_page_tdp-memberslist'){

		_e('From this screen you can have an overwiew of your users for each membership level.','tdp');

	} else if($screen->base == 'memberships_page_tdp-orders'){

		_e('From this screen you can have an overwiew of your transations.','tdp');

	}

	?>

</div>

</div>

<div class="wrap tdp_admin">	
	
	<?php
		$settings_tabs = array("tdp-membershiplevels", "tdp-pagesettings", "tdp-paymentsettings", "tdp-emailsettings", "tdp-advancedsettings", "tdp-addons");
		if(in_array($view, $settings_tabs))
		{
	?>
	<h2 class="nav-tab-wrapper">
		<a href="admin.php?page=tdp-membershiplevels" class="nav-tab<?php if($view == 'tdp-membershiplevels') { ?> nav-tab-active<?php } ?>"><?php _e('Membership Levels', 'tdp');?></a>
		<a href="admin.php?page=tdp-pagesettings" class="nav-tab<?php if($view == 'tdp-pagesettings') { ?> nav-tab-active<?php } ?>"><?php _e('Pages Setup', 'tdp');?></a>
		<a href="admin.php?page=tdp-paymentsettings" class="nav-tab<?php if($view == 'tdp-paymentsettings') { ?> nav-tab-active<?php } ?>"><?php _e('Payment Gateways', 'tdp');?></a>
		<a href="admin.php?page=tdp-emailsettings" class="nav-tab<?php if($view == 'tdp-emailsettings') { ?> nav-tab-active<?php } ?>"><?php _e('Emails', 'tdp');?></a>
		<a href="admin.php?page=tdp-advancedsettings" class="nav-tab<?php if($view == 'tdp-advancedsettings') { ?> nav-tab-active<?php } ?>"><?php _e('Advanced', 'tdp');?></a>	
	</h2>
	<?php } ?>
