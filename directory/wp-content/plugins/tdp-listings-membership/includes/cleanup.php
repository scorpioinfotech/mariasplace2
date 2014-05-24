<?php
/*
	Clean things up when deletes happen, etc. (This stuff needs a better home.)
*/
//deleting a user? remove their account info.
function tdp_delete_user($user_id = NULL)
{
	global $wpdb;

	//changing their membership level to 0 will cancel any subscription and remove their membership level entry
	//we don't remove the orders because it would affect reporting
	if(tdp_changeMembershipLevel(0, $user_id))
	{
		//okay
	}
	else
	{
		//couldn't delete the subscription
		//we should probably notify the admin
		global $tdp_error;
		if(!empty($tdp_error))
		{
			$tdpemail = new TDpEmail();
			$tdpemail->data = array("body"=>"<p>" . sprintf(__("There was an error canceling the subscription for user with ID=%s. You will want to check your payment gateway to see if their subscription is still active.", "tdp"), strval($user_id)) . "</p><p>Error: " . $tdp_error . "</p>");
			$last_order = $wpdb->get_row("SELECT * FROM $wpdb->tdp_membership_orders WHERE user_id = '" . $user_id . "' ORDER BY timestamp DESC LIMIT 1");
			if(!empty($last_order))
				$tdpemail->data["body"] .= "<p>Last Invoice:<br />" . nl2br(var_export($last_order, true)) . "</p>";
			$tdpemail->sendEmail(get_bloginfo("admin_email"));
		}
	}
}
add_action('delete_user', 'tdp_delete_user');
add_action('wpmu_delete_user', 'tdp_delete_user');

//deleting a category? remove any level associations
function tdp_delete_category($cat_id = NULL)
{
	global $wpdb;
	$sqlQuery = "DELETE FROM $wpdb->tdp_memberships_categories WHERE category_id = '" . $cat_id . "'";
	$wpdb->query($sqlQuery);
}
add_action('delete_category', 'tdp_delete_category');

//deleting a post? remove any level associations
function tdp_delete_post($post_id = NULL)
{
	global $wpdb;		
	$sqlQuery = "DELETE FROM $wpdb->tdp_memberships_pages WHERE page_id = '" . $post_id . "'";
	$wpdb->query($sqlQuery);
}
add_action('delete_post', 'tdp_delete_post');