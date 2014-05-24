<?php
/**
 * Module Name: Hangar - Theme Widgets
 * Module Description: This module loads additional widgets support by ThemesDepot Themes.
 * Module Version: 1.0.0
 *
 * @package Hangar
 * @subpackage Bundled
 * @since 1.0.0
 */
 
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}
 
/**
 * Check if the theme supports the following widgets and then loads them.
 */
require_once( 'classes/widgets-class.php' );

function hangar_load_widgets_files(){

  if(current_theme_supports( 'tdp_widget_subscribe' )) {
      require_once( 'widgets/widget-subscribe.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_details' )) {
      require_once( 'widgets/widget-listings-details.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_contact' )) {
      require_once( 'widgets/widget-contact-form.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_map' )) {
      require_once( 'widgets/widget-listing-map.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_categories' )) {
      require_once( 'widgets/widget-listings-categories.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_locations' )) {
    require_once( 'widgets/widget-listings-location.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_featured_author' )) {
    require_once( 'widgets/widget-featured-author.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_listings' )) {
    require_once( 'widgets/widget-latest-listings.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_featured' )) {
    require_once( 'widgets/widget-featured-listings.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_search' )) {
    require_once( 'widgets/widget-listings-search.php' );
  }
  if(current_theme_supports( 'tdp_widget_l_profile' )) {
    require_once( 'widgets/widget-listings-profile.php' );
  }

}
add_action( 'after_setup_theme', 'hangar_load_widgets_files');

// Register widget
if ( ! function_exists( 'hangar_register_theme_widget' ) ) {
    
  function hangar_register_theme_widget() {
    
    if(current_theme_supports( 'tdp_widget_subscribe' )) {
      register_widget( 'Hangar_Subscribe_Widget' );
    }
    if(current_theme_supports( 'tdp_widget_l_details' )) {
      register_widget( 'TDP_Listings_Details' );
    }
    if(current_theme_supports( 'tdp_widget_l_contact' )) {
      register_widget( 'TDP_Listings_Contact' );
    }
    if(current_theme_supports( 'tdp_widget_l_map' )) {
      register_widget( 'TDP_Listings_Map' );
    }
    if(current_theme_supports( 'tdp_widget_l_categories' )) {
      register_widget( 'TDP_Listings_Categories' );
    }
    if(current_theme_supports( 'tdp_widget_l_locations' )) {
      register_widget( 'TDP_Listings_Locations' );
    }
    if(current_theme_supports( 'tdp_widget_l_featured_author' )) {
      register_widget( 'TDP_Featured_Author' );
    }
    if(current_theme_supports( 'tdp_widget_l_listings' )) {
      register_widget( 'TDP_Latest_Listings' );
    }
    if(current_theme_supports( 'tdp_widget_l_featured' )) {
      register_widget( 'TDP_Featured_Listings' );
    }
    if(current_theme_supports( 'tdp_widget_l_search' )) {
      register_widget( 'TDP_Listings_Search' );
    }
    if(current_theme_supports( 'tdp_widget_l_profile' )) {
      register_widget( 'TDP_Listings_Profile' );
    }
    
  }

  add_action( 'widgets_init', 'hangar_register_theme_widget', 1 );
  
}

?>