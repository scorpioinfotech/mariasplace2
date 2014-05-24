<?php
// Include the shortcode support for the text widget
add_filter('widget_text', 'do_shortcode');
	
// Add support to post and comment RSS feed links to head
add_theme_support( 'automatic-feed-links' );	
	
// Set the max content width
if ( ! isset( $content_width ) ){ $content_width = 960; }		
	
// enable featured image
if(function_exists('add_theme_support')){
	add_theme_support('post-thumbnails');
}
	
// enable navigation menu
if(function_exists('add_theme_support')){
	add_theme_support('menus');
	//register_nav_menus(array('main_menu' =>'Main Navigation Menu'));
}	
	
// Enable and register custom sidebar
if (function_exists('register_sidebar')){	
	
	// default sidebar array
	$sidebar_attr = array(
		'name' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clearboth"></div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3><div class="sep"></div>'
	);

	$sidebar_id = 0;
	$dp_sidebar = array("Blog Sidebar", "Page Sidebar", "Listings Sidebar", "Single Listing Sidebar", "Footer 1", "Footer 2", "Footer 3", "Footer 4","BuddyPress Sidebar");

	foreach( $dp_sidebar as $sidebar_name ){
		$sidebar_attr['name'] = $sidebar_name;
		//$sidebar_attr['id'] = sanitize_title('gdl-' . $sidebar_name);
		$sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++ ;
		register_sidebar($sidebar_attr);
	}

}

// Flush rewrite rules for custom post types.
add_action( 'load-themes.php', 'dp_flush_rewrite_rules' );
function dp_flush_rewrite_rules() {
	global $pagenow, $wp_rewrite;
	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){
		$wp_rewrite->flush_rules();
	}
}

// excerpt filter
add_filter('excerpt_length','dp_excerpt_length');
function dp_excerpt_length(){ return 1000; }
	
// feed excerpt filter
add_filter('the_excerpt_rss', 'dp_excerpt_rss');
function dp_excerpt_rss($excerpt) {
	return mb_substr($excerpt, 0, 300) . '...';
}		
// Translate the wpml shortcode -> [wpml_translate lang=en]LANG EN[/wpml_translate]
add_shortcode('wpml_translate', 'dp_lang_test');	
function dp_lang_test( $atts, $content = null ) {
	extract(shortcode_atts(array( 'lang' => '' ), $atts));
		
	$lang_active = ICL_LANGUAGE_CODE;
	if($lang == $lang_active){
		return $content;
	}
}
/*--------------------------------------------------------------------*/                							
/*  ADD CUSTOM CLASSES TO THE ARRAY OF BODY CLASSES					                							
/*--------------------------------------------------------------------*/
function dp_browser_body_class($classes) {

	global $post, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
		
	$classes[] = '';
	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) {
	    $classes[] = 'ie';
	    $browser = $_SERVER[ 'HTTP_USER_AGENT' ];
	    if( preg_match( "/MSIE 7.0/", $browser ) ) {
	        $classes[] = 'ie7';
	    }
	    if( preg_match( "/MSIE 10.0/", $browser ) ) {
	        $classes[] = 'ie10';
	    }
    }
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}	
		
	return $classes;
}
add_filter('body_class','dp_browser_body_class');
/*--------------------------------------------------------------------*/                							
/*  ADD HOME LINK TO MENU					                							
/*--------------------------------------------------------------------*/
if ( !function_exists('dp_home_page_menu_args') ) {

	function dp_home_page_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}
	add_filter( 'wp_page_menu_args', 'dp_home_page_menu_args' );

}
/*--------------------------------------------------------------------*/                							
/*  GET ALL REGISTERED MENU					                							
/*--------------------------------------------------------------------*/

if( !function_exists( 'dp_get_registered_nav_menus' ) ) {
    /**
     * Retireve all registered menus
     * 
     * @return array
     * @since 1.0.0
     */
    function dp_get_registered_nav_menus() {
        $menus = get_terms( 'nav_menu' );
        $return = array();
        
        foreach( $menus as $menu ) {
            array_push( $return, $menu->name );
        }
        
        return $return;
    }
}
/*--------------------------------------------------------------------*/                							
/*  FIX EMPTY PARAGRAPH WITH ADJACENT SHORTCODES					                							
/*--------------------------------------------------------------------*/

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

/*--------------------------------------------------------------------*/                							
/*  ADD SUPPORT FORUM LINK					                							
/*--------------------------------------------------------------------*/
add_action('admin_menu', 'create_theme_style_page');
function create_theme_style_page() {
  add_theme_page(
    'Support Desk',
    'Support Desk',
    'administrator',
    'themes.php?goto=dp-support-desk'
  );
}

add_action('after_setup_theme', 'redirect_from_admin_menu');
function redirect_from_admin_menu($value) {
  global $pagenow;
  if ($pagenow=='themes.php' && !empty($_GET['goto'])) {
    switch ($_GET['goto']) {
      case 'dp-support-desk':
        wp_redirect("http://support.themesdepot.org");
        break;
      default:
        wp_safe_redirect('/wp-admin/');
        break;
    }
    exit;
  }
}

/*--------------------------------------------------------------------*/                							
/*  ADD THEME OPTIONS BUTTON TO ADMIN HEADER			                							
/*--------------------------------------------------------------------*/
add_action('admin_bar_menu', 'dp_add_toolbar_items', 100);
function dp_add_toolbar_items($admin_bar){
	$admin_bar->add_menu( array(
		'id'    => 'theme-options',
		'title' => 'Theme Options',
		'href'  => ''.get_admin_url().'admin.php?page=acf-options-theme-options',	
		'meta'  => array(
		'title' => __('Theme Options','atlas'),			
		),
	));

	$admin_bar->add_menu( array(
		'id'    => 'theme-customizer',
		'title' => 'Customize Layout',
		'href'  => ''.get_admin_url().'admin.php?page=acf-options-skin-customization',	
		'meta'  => array(
		'title' => __('Customize Layout','atlas'),			
		),
	));
}
?>