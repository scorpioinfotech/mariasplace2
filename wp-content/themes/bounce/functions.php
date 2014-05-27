<?php

/////////////////////////////////////// Localisation ///////////////////////////////////////


load_theme_textdomain('gp_lang', get_template_directory() . '/languages');
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if(is_readable($locale_file)) require_once($locale_file);


/////////////////////////////////////// Theme Information ///////////////////////////////////////


$themename = get_option('current_theme'); // Theme Name
$dirname = 'bounce'; // Directory Name


/////////////////////////////////////// File Directories ///////////////////////////////////////


define("gp", get_template_directory() . '/');
define("gp_inc", get_template_directory() . '/lib/inc/');
define("gp_scripts", get_template_directory() . '/lib/scripts/');
define("gp_admin", get_template_directory() . '/lib/admin/inc/');
define("gp_bp", get_template_directory() . '/buddypress/');
define("BP_THEME_URL", get_template_directory_uri());


/////////////////////////////////////// Additional Functions ///////////////////////////////////////


// Main Theme Options
require_once(gp_admin . 'theme-options.php');
require(gp_inc . 'options.php');

// Meta Options
require_once(gp_admin . 'theme-meta-options.php');

// Other Options
if(is_admin()) { require_once(gp_admin . 'theme-other-options.php'); }

// Sidebars
require_once(gp_admin . 'theme-sidebars.php');

// Shortcodes
require_once(gp_admin . 'theme-shortcodes.php');

// Custom Post Types
require_once(gp_admin . 'theme-post-types.php');

// Envato Toolkit (Auto Updater)
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if(!is_plugin_active('envato-wordpress-toolkit-master/index.php') && is_admin()) { include_once (gp_admin . 'envato-wordpress-toolkit-master/index.php'); }

// TinyMCE
if(is_admin()) { require_once (gp_admin . 'tinymce/tinymce.php'); }

// WP Show IDs
if(is_admin()) { require_once(gp_admin . 'wp-show-ids/wp-show-ids.php'); }

// Import/Export Widgets
if(is_admin()) { require_once(gp_admin . 'widget-settings-importexport/widget-data.php'); }

// Auto Install
if(is_admin()) { require_once(gp_admin . 'theme-auto-install.php'); }

// Image Resizer
require_once(gp_scripts . 'aq_resizer/aq_resizer.php');

// BuddyPress Functions
if((function_exists('bp_is_active') OR function_exists('is_bbpress')) && file_exists(gp_bp.'functions-buddypress.php')) { require_once(gp_bp . 'functions-buddypress.php'); }

// Load Skins
if(isset($_GET['skin']) && $_GET['skin'] == "default") {
	$skin = $_COOKIE['SkinCookie']; 
	setcookie('SkinCookie', $skin, time()-3600);
	$skin = $theme_skin;
} elseif(isset($_GET['skin'])) {
	$skin = $_GET['skin'];
	setcookie('SkinCookie', $skin);			
} elseif(isset($_COOKIE['SkinCookie'])) {
	$skin = $_COOKIE['SkinCookie']; 
}


/////////////////////////////////////// Enqueue Styles ///////////////////////////////////////


function gp_enqueue_styles() { 
	if(!is_admin()){
	
		require(gp_inc . 'options.php'); global $post, $dirname, $skin;

		wp_enqueue_style('reset', get_template_directory_uri().'/lib/css/reset.css');

		wp_enqueue_style('gp-style', get_stylesheet_uri());

		if(get_option($dirname.'_responsive') == "0") wp_enqueue_style('responsive', get_template_directory_uri().'/responsive.css');
	
		wp_enqueue_style('prettyphoto', get_template_directory_uri().'/lib/scripts/prettyPhoto/css/prettyPhoto.css');

		wp_enqueue_style('lato', 'http://fonts.googleapis.com/css?family=Lato:400,300,100');

		wp_enqueue_style('raleway', 'http://fonts.googleapis.com/css?family=Raleway:100');

		if((isset($_GET['skin']) && $_GET['skin'] != "default") OR (isset($_COOKIE['SkinCookie']) && $_COOKIE['SkinCookie'] != "default")) {
			
			wp_enqueue_style('style-skin', get_template_directory_uri().'/style-'.$skin.'.css');		
		
		} else {

			if((is_singular() && !is_attachment() && !is_404()) && (get_post_meta($post->ID, 'ghostpool_skin', true) && get_post_meta($post->ID, 'ghostpool_skin', true) != "Default")) {

				wp_enqueue_style('style-skin', get_template_directory_uri().'/style-'.get_post_meta($post->ID, 'ghostpool_skin', true).'.css');		
	
			} else {
		
				wp_enqueue_style('style-skin', get_template_directory_uri().'/style-'.$theme_skin.'.css');
				
			}
		
		}
			
		if($theme_custom_stylesheet) wp_enqueue_style('style-theme-custom', get_template_directory_uri().'/'.$theme_custom_stylesheet);		
		
		if(is_singular() && get_post_meta($post->ID, 'ghostpool_custom_stylesheet', true)) wp_enqueue_style('style-page-custom', get_template_directory_uri().'/'.get_post_meta($post->ID, 'ghostpool_custom_stylesheet', true));
	
	}
}
add_action('wp_enqueue_scripts', 'gp_enqueue_styles');


/////////////////////////////////////// Enqueue Scripts ///////////////////////////////////////


function gp_enqueue_scripts() { 
	if(!is_admin()){
	
		require(gp_inc . 'options.php');

		wp_enqueue_script('gp-modernizr', get_template_directory_uri().'/lib/scripts/modernizr.js', array('jquery'), '', false);
						
		wp_enqueue_script('jquery-ui-accordion');
		
		wp_enqueue_script('jquery-ui-tabs');
		
		if(is_singular() && comments_open() && get_option('thread_comments')) wp_enqueue_script('comment-reply');
				
		wp_enqueue_script('swfobject', 'http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js');
		
		wp_enqueue_script('jwplayer', get_template_directory_uri().'/lib/scripts/mediaplayer/jwplayer.js', array('jquery'));
		
		wp_enqueue_script('flex-slider', get_template_directory_uri().'/lib/scripts/jquery.flexslider.js', array('jquery'));
		
		wp_enqueue_script('prettyphoto', get_template_directory_uri().'/lib/scripts/prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'));

		wp_enqueue_script('custom-js', get_template_directory_uri().'/lib/scripts/custom.js', array('jquery'));
						
	}
}
add_action('wp_enqueue_scripts', 'gp_enqueue_scripts');


/////////////////////////////////////// WP Header Hooks ///////////////////////////////////////


function gp_wp_header() {
	
	require(gp_inc . 'options.php'); global $dirname;
		
    if($theme_favicon_ico) echo '<link rel="shortcut icon" href="'.$theme_favicon_ico.'" /><link rel="icon" href="'.$theme_favicon_ico.'" type="image/vnd.microsoft.icon" />';
    
    if($theme_favicon_png) echo '<link rel="icon" type="image/png" href="'.$theme_favicon_png.'" />';
    
    if($theme_apple_icon) echo '<link rel="apple-touch-icon" href="'.$theme_apple_icon.'" />';
   
   	if($theme_custom_css) echo '<style>'.stripslashes($theme_custom_css).'</style>';

	echo stripslashes($theme_scripts);
	
	require_once(gp_inc . 'style-settings.php');
				
}
add_action('wp_head', 'gp_wp_header');


/////////////////////////////////////// Navigation Menus ///////////////////////////////////////


add_action('init', 'register_my_menus');
function register_my_menus() {
	register_nav_menus(array(
		'header-nav' => __('Header Navigation', 'gp_lang')
	));
}

/*************************************** Mobile Navigation Walker ***************************************/	

class gp_mobile_menu extends Walker_Nav_Menu {

	var $to_depth = -1;

    function start_lvl(&$output, $depth){
		$output .= '</option>';
    }

    function end_lvl(&$output, $depth){
		$indent = str_repeat("\t", $depth); // don't output children closing tag
    }

    function start_el(&$output, $item, $depth, $args){
		$indent = ($depth) ? str_repeat("- ", $depth) : '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'mobile-menu-item-' . $item->ID;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';
		$id = apply_filters('nav_menu_item_id', 'mobile-menu-item-'. $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
		$value = ' value="'. $item->url .'"';
		$output .= '<option'.$id.$value.$class_names.'>';
		$item_output = $args->before;
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$output .= $indent.$item_output;
    }

    function end_el(&$output, $item, $depth){
		if(substr($output, -9) != '</option>')
      		$output .= "</option>"; // replace closing </li> with the option tag
    }

}


/////////////////////////////////////// Other Features ///////////////////////////////////////


// Featured images
add_theme_support('post-thumbnails');
set_post_thumbnail_size(150, 150, true);

// Background customizer
add_theme_support('custom-background');

// This theme styles the visual editor with editor-style.css to match the theme style.
add_editor_style();

// Set the content width based on the theme's design and stylesheet.
if(!isset($content_width)) $content_width = 570;

// Add default posts and comments RSS feed links to <head>.
add_theme_support('automatic-feed-links');

// bbPress Support
if(is_admin() && function_exists('is_bbpress')) { add_theme_support('bbpress'); }

// WooCommerce Support
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support() {
	add_theme_support('woocommerce');
}


/////////////////////////////////////// Excerpts ///////////////////////////////////////


// Character Length
function new_excerpt_length($length) {
	return 10000;
}
add_filter('excerpt_length', 'new_excerpt_length');

function excerpt($count, $ellipsis = '...') {
	$excerpt = get_the_excerpt();
	$excerpt = strip_tags($excerpt);
	if(function_exists('mb_strlen') && function_exists('mb_substr')) { 
		if(mb_strlen($excerpt) > $count) {
			$excerpt = mb_substr($excerpt, 0, $count).$ellipsis;
		}
	} else {
		if(strlen($excerpt) > $count) {
			$excerpt = substr($excerpt, 0, $count).$ellipsis;
		}	
	}
	return $excerpt;
}

// Replace Excerpt Ellipsis
function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');
remove_filter('the_excerpt', 'wpautop');

// Content More Text
function new_more_link($more_link, $more_link_text) {
	return str_replace('more-link', 'more-link read-more', $more_link);
}
add_filter('the_content_more_link', 'new_more_link', 10, 2);


/////////////////////////////////////// Title Length ///////////////////////////////////////


function the_title_limit($count, $ellipsis = '...') {
	$title = the_title('','',FALSE);
	$title = strip_tags($title);
	if(function_exists('mb_strlen') && function_exists('mb_substr')) { 
		if(mb_strlen($title) > $count) {
			$title = mb_substr($title, 0, $count).$ellipsis;
		}
	} else {
		if(strlen($title) > $count) {
			$title = substr($title, 0, $count).$ellipsis;
		}	
	}
	return $title;
}


/////////////////////////////////////// Add Excerpt Support To Pages ///////////////////////////////////////


add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}


/////////////////////////////////////// Shortcode Support For Text Widget ///////////////////////////////////////


add_filter('widget_text', 'do_shortcode');


/////////////////////////////////////// Breadcrumbs ///////////////////////////////////////


function the_breadcrumb() {
global $post;
	if (!is_home()) {
		echo '<a href="'.home_url().'">'.__('Home', 'gp_lang').'</a>';
		if (is_category()) {
			echo " &rsaquo; ";
			echo single_cat_title();
		}
		elseif(is_singular('post') && !is_attachment()) {
			$cat = get_the_category(); $cat = $cat[0];
			echo " &rsaquo; ";
			if(get_the_category()) { 
				$cat = get_the_category(); $cat = $cat[0];
				echo get_category_parents($cat, TRUE, ' &rsaquo; ');
			}
			echo the_title_limit(40);
		}		
		elseif (is_search()) {
			echo " &rsaquo; ";
			_e('Search', 'gp_lang');
		}		
		elseif (is_page() && $post->post_parent) {
			echo ' &rsaquo; <a href="'.get_permalink($post->post_parent).'">';
			echo get_the_title($post->post_parent);
			echo "</a> &rsaquo; ";
			echo the_title_limit(40);
		}
		elseif (is_page() OR is_attachment()) {
			echo " &rsaquo; "; 
			echo the_title_limit(40);
		}
		
		elseif (is_author()) {
			echo wp_title(' &rsaquo; ', true, 'left');
			echo "'s ".__('Posts', 'gp_lang');
		}
		elseif (is_404()) {
			echo " &rsaquo; "; 
			_e('Page Not Found', 'gp_lang');;
		}
		elseif (is_archive()) {
			echo wp_title(' &rsaquo; ', true, 'left');
		}
	}
}


/////////////////////////////////////// Page Navigation ///////////////////////////////////////


function gp_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     
	 if (get_query_var('paged')) {
		 $paged = get_query_var('paged');
	 } elseif (get_query_var('page')) {
		 $paged = get_query_var('page');
	 } else {
		 $paged = 1;
	 }

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
	
     if(1 != $pages)
     {
        echo "<div class='clear'></div><div class='wp-pagenavi cat-navi'>";
		echo '<span class="pages">'.__('Page', 'gp_lang').' '.$paged.' '.__('of', 'gp_lang').' '.$pages.'</span>';
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


/////////////////////////////////////// Shortcode Empty Paragraph Fix ///////////////////////////////////////


// Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content)
{   
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);

	return $content;
}
////////////////////////////////////// custom code ///////////////////////////////////////////////////////////
/*
function post_type_tour() {

 register_post_type('tour',

  array(

    'labels' => array(

    'name' => __( 'Tour' ),

    'singular_name' => __( 'Tour' ),

    'add_new' => __( 'Add New Tour' ),

    'add_new_item' => __( 'Add New Tour' ),

    'edit' => __( 'Edit' ),

    'edit_item' => __( 'Edit Tour' ),

    'new_item' => __( 'New Tour' ),

    'view' => __( 'View Tour' ),

    'view_item' => __( 'View Tour' ),

    'search_items' => __( 'Search Tour' ),

    'not_found' => __( 'No Tour found' ),

    'not_found_in_trash' => __( 'No Tour found in Trash' ),

    'parent' => __( 'Parent Tour' ),

   ),

   'public' => true,

   'show_ui' => true,

   'rewrite' => array( 'slug' => 'Tour', 'with_front' => true ),

   'exclude_from_search' => false,

   'hierarchical' => false,

   'supports' => array( 'title', 'editor', 'thumbnail','custom-fields' ),
 
   'query_var' => true

   )

   );
 }

 add_action('init', 'post_type_tour');*/


add_action("bp_core_activated_user","bp_autologin_on_activation",40,3);
function bp_autologin_on_activation($user_id,$key,$user) {
global $bp, $wpdb;


                //simulate Bp activation
/* Check for an uploaded avatar and move that to the correct user folder, just do what bp does */
if ( is_multisite() )
$hashed_key = wp_hash( $key );
else
$hashed_key = wp_hash( $user_id );

/* Check if the avatar folder exists. If it does, move rename it, move it and delete the signup avatar dir */
if ( file_exists( BP_AVATAR_UPLOAD_PATH . '/avatars/signups/' . $hashed_key ) )
@rename( BP_AVATAR_UPLOAD_PATH . '/avatars/signups/' . $hashed_key, BP_AVATAR_UPLOAD_PATH . '/avatars/' . $user_id );

bp_core_add_message( __( 'Your account is now active!', 'buddypress' ) );

$bp->activation_complete = true;
//now login and redirect
              wp_set_auth_cookie($user_id,true,false);
            bp_core_redirect(apply_filters ("bpdev_autoactivate_redirect_url",bp_core_get_user_domain($user_id ),$user_id));
         // header('Location: http://mariasplace.com/activate/');      

}
// replacement for regular login – gets rif of wp-login.php page
function bp_authenticate_username_password($user, $username, $password) {
if ( is_a($user, 'WP_User') ) { return $user; }

if ( empty($username) || empty($password) ) {
bp_core_add_message( __('ERROR: Empty Username field or empty Password field. See the sidebar for log in support.', 'scg') , 'error' );
wp_redirect(get_option('siteurl'));
return false;
}

$userdata = get_userdatabylogin($username);

if ( !$userdata ) {
bp_core_add_message( __('ERROR: Incorrect Username. See the sidebar for log in support.', 'scg') , 'error' );
wp_redirect(get_option('siteurl'));
return false;
}

$userdata = apply_filters('wp_authenticate_user', $userdata, $password);

if ( is_wp_error($userdata) ) {
bp_core_add_message( __('ERROR: Invalid username or incorrect password.. See the sidebar for log in support.', 'scg') , 'error' );
wp_redirect(get_option('siteurl'));
return false;
}

if ( !wp_check_password($password, $userdata->user_pass, $userdata->ID) ) {
bp_core_add_message( __('ERROR: Incorrect Password. See the sidebar for log in support.', 'scg') , 'error' );
wp_redirect(get_option('siteurl'));
return false;
}

$user = new WP_User($userdata->ID);
return $user;
}

add_filter('authenticate', 'bp_authenticate_username_password', 10, 3);
remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);



function imath_bp_display_friends(){
    global $bp;
    $user_id = $bp->displayed_user->id;
    $user_all_friends_url = $bp->displayed_user->domain . BP_FRIENDS_SLUG;
    ?>
    <div id="friends-list" class="widget friends-list">
        <h3 class="widgettitle"><?php _e( 'Friends', 'buddypress' ) ?> - <a href="<?php echo $user_all_friends_url;?>">View All</a> - <span id="onoroffline"><a href="javascript:imathSwitchToOnlineFriends('online')">View Online</a></span></h3>
        <div id="friends-container">
        <?php if ( bp_has_members( 'user_id='.$user_id.'&per_page=10&max=10&populate_extras=0' ) ) : ?>
            <?php while ( bp_members() ) : bp_the_member(); ?>
                <div class="item-avatar">
                    <a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar() ?></a>
                </div>
            <?php endwhile; ?>
        <?php else:?>
            <p>No friends !</p>
        <?php endif;?>
        </div>
        <br style="clear:both"/>
    </div>
    <?php
} 

register_sidebar( array(
    'name'         => __( 'Popular Questions' ),
    'id'           => 'popular-questions',
    'description'  => __( 'Widgets in this area will be shown on Questions Page.' ),
    'before_title' => '<h1>',
    'after_title'  => '</h1>',
) );
register_sidebar( array(
    'name'         => __( 'New Questions' ),
    'id'           => 'new-questions',
    'description'  => __( 'Widgets in this area will be shown on Questions Page.' ),
    'before_title' => '<h1>',
    'after_title'  => '</h1>',
) );
register_sidebar( array(
    'name'         => __( 'Article Page Sidebar' ),
    'id'           => 'article',
    'description'  => __( 'Widgets in this area will be shown on Questions Page.' ),
    'before_title' => '<h1>',
    'after_title'  => '</h1>',
) );
?>