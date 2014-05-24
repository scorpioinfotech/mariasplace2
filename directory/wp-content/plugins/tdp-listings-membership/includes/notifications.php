<?php
/*
	This code calls the server at www.paidmembershipspro.com to see if there are any notifications to display to the user. Notifications are shown on the TDp settings pages in the dashboard.
*/
function tdp_notifications()
{
	if(current_user_can("manage_options"))
	{			
		delete_transient("tdp_notification_" . TDP_VERSION);
		
		$tdp_notification = get_transient("tdp_notification_" . TDP_VERSION);
		if(empty($tdp_notification))
		{
			if(is_ssl())
				$tdp_notification = wp_remote_retrieve_body(wp_remote_get("https://www.paidmembershipspro.com/notifications/?v=" . TDP_VERSION));
			else
				$tdp_notification = wp_remote_retrieve_body(wp_remote_get("http://www.paidmembershipspro.com/notifications/?v=" . TDP_VERSION));
				
			set_transient("tdp_notification_" . TDP_VERSION, $tdp_notification, 86400);
		}
		
		if($tdp_notification && $tdp_notification != "NULL")
		{
		?>
		<div id="tdp_notifications">
			<?php echo $tdp_notification; ?>
		</div>
		<?php
		}
	}
	
	//exit so we just show this content
	exit;
}
add_action('wp_ajax_tdp_notifications', 'tdp_notifications');	

/*
	Show Powered by Paid Memberships Pro comment (only visible in source) in the footer.
*/
function tdp_link()
{
?>
Memberships powered by Paid Memberships Pro v<?php echo TDP_VERSION?>.
<?php
}
function tdp_footer_link()
{
	if(!tdp_getOption("hide_footer_link"))
	{
		?>
		<!-- <?php echo tdp_link()?> -->
		<?php
	}
}
add_action("wp_footer", "tdp_footer_link");