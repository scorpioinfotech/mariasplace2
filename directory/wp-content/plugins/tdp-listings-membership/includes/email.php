<?php
/*
	Nicer default emails
*/
function tdp_wp_mail_from_name($from_name)
{
	$tdp_from_name = tdp_getOption("from_name");
	if ($tdp_from_name)
		return $tdp_from_name;
	return $from_name;
}
function tdp_wp_mail_from($from_email)
{
	$tdp_from_email = tdp_getOption("from_email");
	if ($tdp_from_email && is_email( $tdp_from_email ) )
		return $tdp_from_email;
	return $from_email;
}
add_filter('wp_mail_from_name', 'tdp_wp_mail_from_name');
add_filter('wp_mail_from', 'tdp_wp_mail_from');

/*
	If the $email_member_notification option is empty, disable the wp_new_user_notification email at checkout.
*/
$email_member_notification = tdp_getOption("email_member_notification");
if(empty($email_member_notification))
	add_filter("tdp_wp_new_user_notification", "__return_false", 0);

/*
	Adds template files and changes content type to html if using PHPMailer directly.
*/
function tdp_send_html( $phpmailer ) {
	// Set the original plain text message
	$phpmailer->AltBody = wp_specialchars_decode($phpmailer->Body, ENT_QUOTES);
	// Clean < and > around text links in WP 3.1
	$phpmailer->Body = preg_replace('#<(http://[^*]+)>#', '$1', $phpmailer->Body);
	// Convert line breaks & make links clickable
	$phpmailer->Body = wpautop ( make_clickable ($phpmailer->Body) );

	// Add template to message
	if(file_exists(TEMPLATEPATH . "/email_header.html"))
	{
		$phpmailer->Body = file_get_contents(TEMPLATEPATH . "/email_header.html") . "\n" . $phpmailer->Body;
	}
	if(file_exists(TEMPLATEPATH . "/email_footer.html"))
	{
		$phpmailer->Body = $phpmailer->Body . "\n" . file_get_contents(TEMPLATEPATH . "/email_footer.html");
	}

	// Replace variables in email
	global $current_user;
	$data = array(
				"name" => $current_user->display_name,
				"sitename" => get_option("blogname"),
				"login_link" => tdp_url("account"),
				"display_name" => $current_user->display_name,
				"user_email" => $current_user->user_email,
				"subject" => $phpmailer->Subject
			);
	foreach($data as $key => $value)
	{
		$phpmailer->Body = str_replace("!!" . $key . "!!", $value, $phpmailer->Body);
	}

	do_action("tdp_after_phpmailer_init", $phpmailer);
	do_action("tdp_after_pmpmailer_init", $phpmailer);	//typo left in for backwards compatibility
}

function tdp_wp_mail_content_type( $content_type ) {
	add_action('phpmailer_init', 'tdp_send_html');

	//change to html if not already
	if( $content_type == 'text/plain')
	{			
		$content_type = 'text/html';
	}
	return $content_type;
}
add_filter('wp_mail_content_type', 'tdp_wp_mail_content_type');