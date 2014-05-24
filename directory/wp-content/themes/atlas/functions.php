<?php
/**
 * functions and definitions
 *
 * @package Atlas
 */

define('TDP_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/');
define('TDP_FRAMEWORK_VERSION', '2.3.0');

//define( 'ACF_LITE', true );

/**
 * Required: check for required plugins.
 */
require_once('framework/functions/class-tgm-plugin-activation.php' );

/**
 * Required: include Custom Fields Framework.
 */
require_once('framework/custom-fields/acf.php' );
require_once('framework/metaboxes/acf-flexible-content/acf-flexible-content.php' );
require_once('framework/metaboxes/acf-gallery/acf-gallery.php' );
require_once('framework/metaboxes/acf-repeater/acf-repeater.php' );
require_once('framework/metaboxes/acf-location-field-master/acf-location.php' );

/**
 * Required: include Main Options.
 */
require_once('framework/admin/acf-options-page/acf-options-page.php' );

// load more pages
if(function_exists("register_options_page"))
{
    register_options_page('Theme Options');
    register_options_page('Listings Settings');
    register_options_page('User Dashboard');
    register_options_page('Emails Setup');
    register_options_page('Fields Restrictions');
    register_options_page('Search Form Fields');
    register_options_page('Skin Customization');
}

if( function_exists('acf_set_options_page_title') )
{
    acf_set_options_page_title( __('Theme Options') );
}

/**
 * Required: include framework and theme functions.
 */
require_once('framework/fields/theme_options.php' );
//locate_template('/framework/fields/listings_post.php' );

add_action('init', 'load_exported_fields');
function load_exported_fields(){
    require_once( trailingslashit( get_stylesheet_directory() ) . 'framework/fields/listings_post.php' );
}

require_once('framework/fields/page_fields.php' );

require_once('framework/functions/required_plugins.php' );
require_once('framework/functions/core-functions.php' );
require_once('framework/functions/theme-functions.php' );
require_once('framework/functions/theme-setup.php' );
//require_once('framework/functions/walker/walker.php' );
require_once('framework/functions/theme-customizer.php' );
if(!class_exists(‘Aq_Resize’)) {
    require_once('framework/functions/aq_resizer.php' );
}
require_once('framework/functions/i18n.php' ); 

/**
 * Theme Extra Module
 */
require_once('framework/functions/listings/theme-specific.php' );
require_once('framework/functions/frontend_dashboard.php');
require_once('framework/functions/wpas.php');
require_once('framework/functions/listings/favorite/wp-favorite-posts.php');
if(get_field('enable_ajax_map','option')) {
    require_once('framework/functions/listings/ajax-loader.php');
}
new EFE_Frontend_Dashboard();


/**
 * Add theme components from hangar plugin
 */

//Load additional modules
add_theme_support( 'tdp_cpt' );
add_theme_support( 'tdp_cpt_listings' );
add_theme_support( 'tdp_cpt_claim' );

//Add theme widgets
add_theme_support( 'tdp_widget_subscribe' );
add_theme_support( 'tdp_widget_l_details' );
add_theme_support( 'tdp_widget_l_contact' );
add_theme_support( 'tdp_widget_l_map' );
add_theme_support( 'tdp_widget_l_categories' );
add_theme_support( 'tdp_widget_l_locations' );
add_theme_support( 'tdp_widget_l_featured_author' );
add_theme_support( 'tdp_widget_l_listings' );
add_theme_support( 'tdp_widget_l_featured' );
add_theme_support( 'tdp_widget_l_search' );
add_theme_support( 'tdp_widget_l_profile' );

//Add shortcode support
add_theme_support( 'hangar_accordion' );
add_theme_support( 'hangar_alert' );
add_theme_support( 'hangar_button' );
add_theme_support( 'hangar_divider' );
add_theme_support( 'hangar_video' );
add_theme_support( 'hangar_maps' );
add_theme_support( 'hangar_gap' );
add_theme_support( 'hangar_clear' );
add_theme_support( 'hangar_icon' );
add_theme_support( 'hangar_miniicon' );
add_theme_support( 'hangar_retinaicon' );
add_theme_support( 'hangar_retinaiconbox' );
add_theme_support( 'hangar_list' );
add_theme_support( 'hangar_member' );
add_theme_support( 'hangar_skill' );
add_theme_support( 'hangar_pricing' );
add_theme_support( 'hangar_pullquote' );
add_theme_support( 'hangar_table' );
add_theme_support( 'hangar_tabs' );
add_theme_support( 'hangar_toggle' );
add_theme_support( 'hangar_sep' );
add_theme_support( 'hangar_googlefont' );
add_theme_support( 'hangar_columns' );
add_theme_support( 'hangar_teaser' );
add_theme_support( 'hangar_testimonial' );

/*
function acf_translate_fields( $field )
{
	$field['label' ] = __( $field['label' ], 'atlas'  );
	$field['instructions' ] = __( $field['instructions' ], 'atlas'  );

	return $field;
}
add_filter('acf/load_field' , 'acf_translate_fields' );
*/

add_action( 'after_setup_theme', 'dp_lang_setup' );
function dp_lang_setup() {
    load_theme_textdomain('atlas', get_template_directory()); 
}

// Register your custom function to override some LayerSlider data
add_action('layerslider_ready', 'my_layerslider_overrides');
 
function my_layerslider_overrides() {
 
// Disable auto-updates
$GLOBALS['lsAutoUpdateBox'] = false;

}

function tdp_fix_editor( $value, $post_id, $field )
{
    // run the_content filter on all textarea values
    $value = apply_filters('the_content',$value); 
 
    return $value;
}
 
// acf/load_value - filter for every value load
add_filter('acf/load_value/key=field_51e1444d75d73', 'tdp_fix_editor', 10, 3);