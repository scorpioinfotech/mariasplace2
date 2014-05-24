<?php

// Load the default BuddyPress AJAX functions

if(function_exists('bp_is_active')) { require_once(BP_PLUGIN_DIR . '/bp-themes/bp-default/_inc/ajax.php'); }


// Add classes on BuddyPress pages

add_filter('body_class','gp_bp_class');
function gp_bp_class($classes) {
	if((function_exists('bp_is_active') && !bp_is_blog_page()) OR (function_exists('is_bbpress') && is_bbpress())) {
		if(is_rtl()) {
			$classes[] = 'bp-wrapper';
		} else {
			$classes[] = 'bp-wrapper';
		}
	}
	return $classes;
}


// Include BuddyPress JS and CSS functions

if(!function_exists('gp_bp_enqueue_defaults_init')) {		
	function gp_bp_enqueue_defaults_init() {
		if(!is_admin()) {
			wp_enqueue_style('buddypress', BP_THEME_URL . '/buddypress/bp.css', false, '0.1', 'screen');
			if(function_exists('bp_is_active')) { wp_enqueue_script('dtheme-ajax-js', BP_PLUGIN_URL . 'bp-themes/bp-default/_inc/global.js', array('jquery')); }
		}	
	}
}
add_action('init', 'gp_bp_enqueue_defaults_init', 1);



if(function_exists('bp_is_active')) { 


	// Sidebars
	
	register_sidebar(array('name'=> __('BuddyPress 1', 'gp_lang'), 'id' => 'buddypress-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'));  

	register_sidebar(array('name'=> __('BuddyPress 2', 'gp_lang'), 'id' => 'buddypress-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'));  

	register_sidebar(array('name'=> __('BuddyPress 3', 'gp_lang'), 'id' => 'buddypress-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'));  

	register_sidebar(array('name'=> __('BuddyPress 4', 'gp_lang'), 'id' => 'buddypress-4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'));  
	
	register_sidebar(array('name'=> __('BuddyPress 5', 'gp_lang'), 'id' => 'buddypress-5',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'));  

	register_sidebar(array('name'=> __('BuddyPress 6', 'gp_lang'), 'id' => 'buddypress-6',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'));  	


	// Avatar dimensions
	
	if(!defined('BP_AVATAR_THUMB_WIDTH'))
	define('BP_AVATAR_THUMB_WIDTH', 80); //change this with your desired thumb width
 
	if(!defined('BP_AVATAR_THUMB_HEIGHT'))
	define('BP_AVATAR_THUMB_HEIGHT', 80); //change this with your desired thumb height
 
	if(!defined('BP_AVATAR_FULL_WIDTH'))
	define('BP_AVATAR_FULL_WIDTH', 150); //change this with your desired full size,weel I changed it to 260 <img src="http://buddydev.com/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> 
 
	if(!defined('BP_AVATAR_FULL_HEIGHT'))
	define('BP_AVATAR_FULL_HEIGHT', 150); //change this to default height for full avatar
 
 
	// Modify the activity output
	
	if(!function_exists('gp_bp_activity_action')) {
		function gp_bp_activity_action() {
			$content = bp_get_activity_action();
			$content = str_replace('&middot;', '', $content); // no more dots between content
			$content = str_replace(': <span', '<span', $content); // get rid of the ":" before date
			$content = str_replace('started the forum topic', __('Started topic:', 'gp_lang'), $content);
			$content = str_replace('posted on the forum topic', __('Posted on:', 'gp_lang'), $content);
			$content = str_replace('</a> created', '</a> '. __('Created', 'gp_lang'), $content);	// capitalization fix
			$content = str_replace('</a> posted', '</a> '. __('Posted', 'gp_lang'), $content); // capitalization fix
			$content = str_replace('</a> started', '</a> '. __('Started', 'gp_lang'), $content); // capitalization fix
			$content = str_replace('in the group', __('in', 'gp_lang'), $content);
			echo $content;
		}
	}


	// Add words that we need to use in JS to the end of the page so they can be translated and still used
	
	if (!function_exists( 'bp_dtheme_enqueue_scripts')) {
		function bp_dtheme_enqueue_scripts() {
			$params = array(
				'my_favs'           => __('My Favorites', 'gp_lang'),
				'accepted'          => __('Accepted', 'gp_lang'),
				'rejected'          => __('Rejected', 'gp_lang'),
				'show_all_comments' => __('Show all comments for this thread', 'gp_lang'),
				'show_x_comments'   => __('Show all %d comments', 'gp_lang'),
				'show_all'          => __('Show all', 'gp_lang'),
				'comments'          => __('comments', 'gp_lang'),
				'close'             => __('Close', 'gp_lang'),
				'view'              => __('View', 'gp_lang'),
				'mark_as_fav'	    => __('Favorite', 'gp_lang'),
				'remove_fav'	    => __('Remove Favorite', 'gp_lang'),
				'unsaved_changes'   => __('Your profile has unsaved changes. If you leave the page, the changes will be lost.', 'gp_lang'),
			);	
			wp_localize_script('dtheme-ajax-js', 'BP_DTheme', $params);
		}
		add_action('wp_enqueue_scripts', 'bp_dtheme_enqueue_scripts');
	}


	// Member Buttons
	
	if(bp_is_active('friends'))
		add_action('bp_member_header_actions', 'bp_add_friend_button');

	if(bp_is_active('activity'))
		add_action('bp_member_header_actions', 'bp_send_public_message_button');

	if(bp_is_active('messages'))
		add_action('bp_member_header_actions', 'bp_send_private_message_button');


	// Group Buttons
	
	if(bp_is_active('groups')) {
		add_action('bp_group_header_actions', 'bp_group_join_button');
		add_action('bp_group_header_actions', 'bp_group_new_topic_button');
		add_action('bp_directory_groups_actions', 'bp_group_join_button');
	}


	// Blog Buttons
	
	if(bp_is_active('blogs'))
		add_action('bp_directory_blogs_actions',  'bp_blogs_visit_blog_button');

}


?>