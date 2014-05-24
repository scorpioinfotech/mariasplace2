<?php
if ( !defined( 'ABSPATH' ) ) exit;

$bp_mymood_message = get_option("bp_mymood_message");
if($bp_mymood_message["wpined"] != "1") {
	add_action('admin_notices',create_function("",'
	echo \'<p>
	<h4>Message by BuddyPress MyMood :</h4>
	<center> 
	<h2>Checkout My New WordPress Plugin</h2> 
	<br />
	<a href="http://webgarb.com/wp-inline-edit/" target="_blank">
	<img src="http://webgarb.com/wp-content/uploads/2012/05/logo.png" alt="Logo" /></a><br />
	
	<a href="http://webgarb.com/wp-inline-edit/" target="_blank">WP Inline Edit</a> is a WordPress Plugin which will add ability to author/admin/editor to edit your post/page from page/post itself without going to wp-admin edit page. <br />
	<h3>View the working of this plugin on <a target="_blank" href="http://youtu.be/z49D40Ureao">Screencast at Youtube </a><br />
	See on Wp Extend : <a target="_blank" href="http://wordpress.org/extend/plugins/wp-inline-edit/">WP Inline Edit</a>
	 </h3></center></p>\';
	$bp_mymood_message = get_option("bp_mymood_message");
	$bp_mymood_message["wpined"] = "1";
	update_option("bp_mymood_message",$bp_mymood_message);
	'));  
}
	
?>