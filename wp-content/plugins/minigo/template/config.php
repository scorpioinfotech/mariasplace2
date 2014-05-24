<?php


//
// Mailing list settings
// --------------------------------------------------------------------------------------------

// Set to true if you want to use Mailchimp to collect addresses. Otherwise, set to false.
$use_Mailchimp = $premiothemes_comingsoon_minigo['subscribe-use_Mailchimp'];

// Fill in you API Key here if the above option is true
$mailchimp_API_Key = $premiothemes_comingsoon_minigo['subscribe-Mailchimp_API_Key'];

// The ID of the mailchimp list where you want to save the contacts
$mailchimp_list_ID = $premiothemes_comingsoon_minigo['subscribe-Mailchimp_list_ID'];

// If set to true, it enables Double Opt-in. See the following link for reference on how it works: http://kb.mailchimp.com/article/how-does-confirmed-optin-or-double-optin-work/
$mailchimp_double_optin = $premiothemes_comingsoon_minigo['subscribe-Mailchimp_double_optin'];

// If Double Opt-in is disabled, you can still send a Welcome message by setting the following to true
$mailchimp_send_welcome = $premiothemes_comingsoon_minigo['subscribe-Mailchimp_send_welcome'];

// The emails are saved to this file if not using Mailchimp. Use a random name that can't be easily guessed.
//$maillist_file = 'mail-list_FJdfjfk4FGeWR.txt';



//
// Contact form settings
// -------------------------------------------------------------------------------------------

// This is the email address where you'll receive the contact form messages
$target_address = $premiothemes_comingsoon_minigo['contact-target-address'];

// By default, the Contact form FROM email is the same as the $target_address. However, some hosting providers won't allow email being sent from an address that isn't configured on the host's Mail service.
// If you are not getting emails from the form try setting this to an address that is properly configured on your host.
$from_address = $premiothemes_comingsoon_minigo['contact-from-address'];;

// Prefix for the email subject. Useful for filtering mail.
$subject_prefix = $premiothemes_comingsoon_minigo['contact-subject-prefix'];
?>