<?php 
/* 
 * Register scripts and styles 
 */

function invent_template_scripts() {
        //CSS Header
        wp_enqueue_style('main-style', get_stylesheet_uri());
        wp_enqueue_style('animate', get_template_directory_uri().'/css/animate.css');
        wp_enqueue_style('fontello', get_template_directory_uri().'/css/fontello.css');
        wp_enqueue_style('shortcodes-elements', get_template_directory_uri().'/css/shortcodes.css');       
        wp_enqueue_style('flex', get_template_directory_uri().'/css/flexslider.css');
        wp_enqueue_style('popup', get_template_directory_uri().'/css/magnific-popup.css');
        wp_enqueue_style('formsoverride', get_template_directory_uri().'/css/square/blue.css');
        wp_enqueue_style('responsive', get_template_directory_uri().'/css/responsive.css');

        if(get_field('add_rtl_support','option')) {
            wp_enqueue_style('rtl', get_template_directory_uri().'/rtl.css');
        }

        //JS Header
        wp_enqueue_script('jquery');
            
            if(get_field('enable_search_on_map','option')) {
                wp_enqueue_script( 'google-src', 'http://maps.google.com/maps/api/js?sensor=true&amp;libraries=places&amp;language=en' );
            } else {
                wp_enqueue_script( 'google-src', 'http://maps.google.com/maps/api/js?sensor=true&amp;language=en' );
            }
            wp_enqueue_script('gmap3', get_template_directory_uri().'/js/gmap3.min.js');
            wp_enqueue_script('infobox', get_template_directory_uri().'/js/infobox.js' );

            if(get_field('enable_ajax_map','option')) {
                wp_enqueue_script( 'google-clusterer', get_template_directory_uri().'/js/markerclusterer.js' );
            }

            // check if homepage search by address is available 
            if(get_field("homepage_tabs_generator",'option')) {

                while(has_sub_field("homepage_tabs_generator",'option')) {

                    if(get_row_layout() == "add_new_tab") {

                        if(get_sub_field("set_tab_content",'option') == 'Search Form') {

                            $translation_array = array( 'is_available' => 'yes');
                            wp_localize_script( 'google-src', 'search_by_address', $translation_array );

                        } 

                    } 

                }

            } else if(get_field('enable_search_on_map','option')) {

                $translation_array = array( 'is_available' => 'yes');
                wp_localize_script( 'google-src', 'search_by_address', $translation_array );

            } else {

                $translation_array = array( 'is_available' => 'no');
                wp_localize_script( 'google-src', 'search_by_address', $translation_array );

            }

        wp_enqueue_script( 'comment-reply' );
    
}
add_action('wp_enqueue_scripts', 'invent_template_scripts');

function tdp_enqueue_print() {
  if ( get_post_type() == 'listing' ) {
    wp_enqueue_style('listingcss', get_template_directory_uri().'/css/print.css', $deps = '', $ver = false, $media = 'print');
  }
}
add_action( 'wp_enqueue_scripts', 'tdp_enqueue_print' );

function dp_google_font() { 
    
        $font_url = get_field('google_font_url','option');
        $font_data = "@import url('".$font_url."');";
        $font_data .= "body {font-family: '".get_field('google_font_name', 'option')."', Helvetica Neue, Helvetica, Arial, sans-serif !important;}";
        wp_add_inline_style( 'main-style', $font_data );
    
}
    
add_action('wp_enqueue_scripts', 'dp_google_font');

function ie_head() { ?>
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

<?php }
add_action('wp_head','ie_head');

function dp_footer_scripts() {
    if (!is_admin()) {
        wp_enqueue_script( 'jquery-ui-tabs' );
        wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.js');
        wp_enqueue_script('easing', get_template_directory_uri().'/js/easing.js');
        wp_enqueue_script('fitvids', get_template_directory_uri().'/js/fitvids.js');
        wp_enqueue_script('flex', get_template_directory_uri().'/js/flexslider.js');
        wp_enqueue_script('functions', get_template_directory_uri().'/js/functions.js');
        wp_enqueue_script( 'popup-js', get_template_directory_uri().'/js/popup.js' );
        
        wp_enqueue_script('flot', get_template_directory_uri().'/js/jquery.flot.min.js');
        wp_enqueue_script('flot-stack', get_template_directory_uri().'/js/jquery.flot.stack.min.js');
        
        wp_enqueue_script('hover', get_template_directory_uri().'/js/hover.js');
        wp_enqueue_script('menu', get_template_directory_uri().'/js/superfish.js');
        wp_enqueue_script('shortcodes', get_template_directory_uri().'/js/shortcodes.js');
        //wp_enqueue_script('waypoints', get_template_directory_uri().'/js/waypoints.js');
        //wp_enqueue_script('waypoints-sticky', get_template_directory_uri().'/js/waypoints-sticky.js');
        wp_enqueue_script( 'carousel', get_template_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js');
        //wp_enqueue_script( 'mousewheel', get_template_directory_uri().'/js/jquery.mousewheel.min.js');
        wp_enqueue_script( 'touchSwipe', get_template_directory_uri().'/js/jquery.touchSwipe.min.js');
        //wp_enqueue_script( 'transit', get_template_directory_uri().'/js/jquery.transit.min.js');
        wp_enqueue_script( 'replace-forms', get_template_directory_uri().'/js/jquery.icheck.min.js');

        if(get_field('add_rtl_support','option')) {
            wp_enqueue_script('homesidebar-direction', get_template_directory_uri().'/js/rtl_sidebar.js' );
        } else {
            wp_enqueue_script('homesidebar-direction', get_template_directory_uri().'/js/ltr_sidebar.js' );
        }
        wp_enqueue_script('custom', get_template_directory_uri().'/js/custom.js' );
    }
}
add_action('wp_footer', 'dp_footer_scripts');


function dp_print_head_style() {

    // This needs to be here otherwise changing the option into the customizer won't refresh the preview.
    if(get_theme_mod( 'enable_custom_style' ) == 'skin2') {
    
       wp_enqueue_style( 'skin2' , get_template_directory_uri().'/css/'.'skin2'.'.css'); 
    
    } else if(get_theme_mod( 'enable_custom_style' ) == 'skin3') {
    
       wp_enqueue_style( 'skin3' , get_template_directory_uri().'/css/'.'skin3'.'.css'); 

    } else if(get_theme_mod( 'enable_custom_style' ) == 'skin4') {
    
       wp_enqueue_style( 'skin4' , get_template_directory_uri().'/css/'.'skin4'.'.css');

    } else if(get_theme_mod( 'enable_custom_style' ) == 'skin5') {
    
       wp_enqueue_style( 'skin5' , get_template_directory_uri().'/css/'.'skin5'.'.css'); 

    } else if(get_theme_mod( 'enable_custom_style' ) == 'skin6') {
    
       wp_enqueue_style( 'skin6' , get_template_directory_uri().'/css/'.'skin6'.'.css');

    } else if(get_theme_mod( 'enable_custom_style' ) == 'skin7') {
    
       wp_enqueue_style( 'skin7' , get_template_directory_uri().'/css/'.'skin7'.'.css'); 
    
    } 

    if(get_theme_mod( 'enable_custom_style' ) == 'custom') {

            $css_data = "

            #top-bar {
                background-color: ". get_option('topbar_1') .";
                background-repeat: repeat-x;
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(". get_option('topbar_1') ."), to(". get_option('topbar_2') ."));
                background: -webkit-linear-gradient(top, ". get_option('topbar_1') .", ". get_option('topbar_2') .");
                background: -moz-linear-gradient(top, ". get_option('topbar_1') .", ". get_option('topbar_2') .");
                background: -ms-linear-gradient(top, ". get_option('topbar_1') .", ". get_option('topbar_2') .");
                background: -o-linear-gradient(top, ". get_option('topbar_1') .", ". get_option('topbar_2') .");
            }

            #topintro {
                color: ". get_option('topbar_c') .";
            }

            #topintro a {
                color:". get_option('topbar_links') .";
            }

            #header-container, #header-border {
                background: ". get_option('header_color') .";
            }

            #header-container, #header-border {
                border-color:". get_option('header_color') .";
            }

            #navigation-wrapper ul li a {
                color: ". get_option('header_links') .";
            }

            #navigation-wrapper ul li.active a {
                color: ". get_option('header_active_links') .";
            }

            .tab-nav {
                background: ". get_option('homepage_sidebar_bg') .";
            }

            #home-sidebar {
                background: ". get_option('homepage_sidebar_cbg') .";
            }

            .tab-nav a {
                color: ". get_option('homepage_sidebar_tab1') .";
            }

            .tab-nav li.ui-state-active a {
                color: ". get_option('homepage_sidebar_tab2') .";
            }

            .tab-content h1, .tab-content h2, .tab-content h3, .tab-content h4, .tab-content h5, .tab-content h6 {
                color: ". get_option('homepage_sidebar_h') .";
            }

            /* BG */
            figure:hover .overlay .thumb-info, #sidebar-wrapper .sep, .link-wrapper, .marker-title, .cbp-vm-view-grid .single-image figure .thumb-info, .featured-star, #comments.reviews-comments #reply-title, .stats-rating, #search-popup h1, #front-login h1, .toggle-button:hover, .toggle-activator.hello-im-hidden .toggle-button, #open-search:hover {
                background: ". get_option('theme_main_color') .";
            }

            /* BDC */

            input:focus, textarea:focus, form.search-form > fieldset.has-focus, #content-container .featured-listing, #comments.reviews-comments #reply-title  {
                border-color:". get_option('theme_main_color') .";
            }

            /* C */
            .widget_tdp_listings_details li span, .tab-lister i, a.action-button span, a {
                color:". get_option('theme_main_color') .";
            }

            body {
                color:". get_option('body_font_color') .";
                background:". get_option('body_bg_color') .";
            }

            .cluster {
               background:". get_option('map_pulse_bg') ."; 
            }

            #top-footer {
                background:". get_option('top_footer_color') ."; 
            }

            #bottom-footer {
                background:". get_option('bottom_footer_color') .";
                border-color:". get_option('bottom_footer_border_color') .";
                color:". get_option('footer_font_color') .";
            }

            #top-footer .widget {
                color: ". get_option('footer_colors') ." !important;
            }";

            wp_add_inline_style( 'main-style', $css_data );

    }



}

add_action( 'wp_enqueue_scripts', 'dp_print_head_style' );

/**
 * Script to make it go
 */
add_action( 'wp_footer', 'tdp_vars' );
function tdp_vars() {
    ?>
    <script>
        var themepath = '<?php echo get_template_directory_uri(); ?>';
    </script>
    <?php
}

/* Hide elements in dashboard */

function tdp_admin_hide() { ?>
    
    <style type="text/css">

       #acf-listing_title, #acf-tdp_select_listing_category, #acf-testing_the_editor_field, #acf-tdp_select_listing_location_area, #acf-listing_tags {
        display: none;
       }

    </style>

<?php }

add_action( 'admin_head', 'tdp_admin_hide' );

function tdp_social_hide() {

    if(!is_admin() && get_field('disable_social_profiles','option')) { ?>

    <style type="text/css">
        #acf-facebook, #acf-twitter, #acf-gplus, #acf-instagram, #acf-foursquare {
            display: none;
        }
    </style>
    <?php }
       

}
add_action( 'wp_head', 'tdp_social_hide');

/* 
 * Ajax Detect Selected Vechicle And Show Child
 */
function tdp_implement_ajax() {
    
    if(isset($_POST['main_catid'])) {

        $args = array( 
                'taxonomy' => 'listings_categories',
                'child_of' => $_POST['main_catid'],
                'hide_empty' => 0
                );
        
        $categories = get_categories($args); 
        
            foreach ($categories as $cat) {
                

                $option .= '<option value="'.$cat->slug.'">';
                $option .= $cat->cat_name;
                $option .= ' ('.$cat->category_count.')';
                $option .= '</option>';

            }
            echo '<option value="" selected="selected">'.__('Select A Category','framework').'</option>'.$option;

            die();

        } // end if
}
add_action('wp_ajax_tdp_search_ajax_call', 'tdp_implement_ajax');
add_action('wp_ajax_nopriv_tdp_search_ajax_call', 'tdp_implement_ajax');//for users that are not logged in.

/* 
 * Ajax Detect Selected Vechicle And Show Child
 */
function tdp_implement_ajax2() {
    
    if(isset($_POST['main_catid2'])) {

        $args = array( 
                'taxonomy' => 'listings_location',
                'child_of' => $_POST['main_catid2'],
                'hide_empty' => 0
                );
        
        $categories = get_categories($args); 
        
            foreach ($categories as $cat) {
                

                $option .= '<option value="'.$cat->slug.'">';
                $option .= $cat->cat_name;
                $option .= ' ('.$cat->category_count.')';
                $option .= '</option>';

            }
            echo '<option value="" selected="selected">'.__('Select An Area','framework').'</option>'.$option;

            die();

        } // end if
}
add_action('wp_ajax_tdp_search_ajax_call2', 'tdp_implement_ajax2');
add_action('wp_ajax_nopriv_tdp_search_ajax_call2', 'tdp_implement_ajax2');//for users that are not logged in.

/* 
 * Ajax JS Detect Selected Category And Show Child
 */
function tdp_search_ajax() { ?>
    
    <script type="text/javascript">

        var popup_url = "<?php bloginfo('wpurl'); ?>";

        /* 
        * Ajax Request to get cats
        */
        jQuery(function(){
            jQuery('#main_cat').change(function(){
                jQuery('#status_loader').show();
                var jQuerymainCat=jQuery('#main_cat').val();
                // call ajax
                jQuery("#tax_listings_categories").empty();
                    jQuery.ajax({
                        url:"<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",     
                        type:'POST',
                        data:'action=tdp_search_ajax_call&main_catid=' + jQuerymainCat,
                        success:function(results) {
                        //  alert(results);
                        jQuery('#status_loader').hide();

                        jQuery('#tax_listings_categories')
                            .find('option')
                            .remove()
                            .end()
                        ;

                        jQuery("#tax_listings_categories").removeAttr("disabled");        
                                jQuery("#tax_listings_categories").append(results);
                        }
                    });
                }
            );
        });

        /* 
        * Ajax Request to get cats
        */
        jQuery(function(){
            jQuery('#main_loc').change(function(){
                jQuery('#status_loader2').show();
                var jQuerymainLoc=jQuery('#main_loc').val();
                // call ajax
                jQuery("#tax_listings_location").empty();
                    jQuery.ajax({
                        url:"<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",     
                        type:'POST',
                        data:'action=tdp_search_ajax_call2&main_catid2=' + jQuerymainLoc,
                        success:function(results) {
                        //  alert(results);
                        jQuery('#status_loader2').hide();

                        jQuery('#tax_listings_location')
                            .find('option')
                            .remove()
                            .end()
                        ;

                        jQuery("#tax_listings_location").removeAttr("disabled");        
                                jQuery("#tax_listings_location").append(results);
                        }
                    });
                }
            );
        });                                       
    </script>

<?php }

add_action('wp_head','tdp_search_ajax');

/* 
 * Register search form fields
 */
if(!function_exists('tdp_search_fields')) {
    function tdp_search_fields() {

        /* 
         * Generate Array of all main categories
         */
        $args = array(
            'type'                     => 'listing',
            'child_of'                 => 0,
            'parent'                   => 0,
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hide_empty'               => 0,
            'hierarchical'             => 1,
            'exclude'                  => '',
            'include'                  => '',
            'number'                   => '',
            'taxonomy'                 => 'listings_categories',
            'pad_counts'               => false 

        );

        $default_option = array('-1' => __('Select a Category &raquo;','atlas'));

        $output_categories = array();
        $categories=get_categories($args);
          foreach($categories as $category) { 
             $output_categories[$category->cat_ID] = $category->name ;
        }

        $all_categories = $default_option + $output_categories;

        /* 
         * Generate Array of all mainlocations
         */
        $args_loc = array(
            'type'                     => 'listing',
            'child_of'                 => 0,
            'parent'                   => 0,
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hide_empty'               => 0,
            'hierarchical'             => 1,
            'exclude'                  => '',
            'include'                  => '',
            'number'                   => '',
            'taxonomy'                 => 'listings_location',
            'pad_counts'               => false 

        );

        $default_option = array('-1' => __('Select A Location &raquo;','atlas'));

        $output_locations = array();
        $locations=get_categories($args_loc);
          foreach($locations as $location) { 
             $output_locations[$location->cat_ID] = $location->name ;
        }

        $all_locations = $default_option + $output_locations;

        $args = array();
        $args['form'] = array('action' => get_field('search_results_page','option'));
        
        $args['wp_query'] = array(
            'post_type' => 'listing',
            'posts_per_page' => get_field('results_per_page','option'),
            'order' => 'DESC',
            'orderby' => 'date'
        );

        if(!get_field('disable_search_input_text','option')) {
            $args['fields'][] = array(
                'type' => 'search',
                'label' => __('Search For Listings','atlas'),
                'placeholder' => __('What are you looking for ?','atlas'),
                'value' => ''
            );
        }

        if(!get_field('disable_listings_categories_field','option')) {

            // Lets add faceted search
            if(get_field('enable_faceted_search','option')) {

                $args['fields'][] = array(
                      'type' => 'generic',
                      'id' => 'main_cat',
                      'label' => __('Select A Category:','atlas'),
                      'format' => 'select',
                      'default' => '',
                      'values' => $all_categories,
                );

                $args['fields'][] = array(
                      'type' => 'generic',
                      'id' => 'tax_listings_categories',
                      'label' => __('Select A Subcategory','framework'),
                      'format' => 'select',
                      'default' => '',
                      'values' => array('' => __('Select A Category First','atlas')),
                );

            //normal search
            } else {

                $args['fields'][] = array(
                    'type' => 'taxonomy',
                    'label' => __('Listing Category','atlas'),
                    'taxonomy' => 'listings_categories',
                    "allow_null" => __('All Categories','atlas'),
                    'format' => 'select',
                    'operator' => 'IN'
                );

            }

        }

        if(!get_field('disable_listings_location_field','option')) {

            // Lets add faceted search
            if(get_field('enable_faceted_search','option')) {
                
                $args['fields'][] = array(
                      'type' => 'generic',
                      'id' => 'main_loc',
                      'label' => __('Select A Location','atlas'),
                      'format' => 'select',
                      'default' => '',
                      'values' => $all_locations,
                );

                $args['fields'][] = array(
                      'type' => 'generic',
                      'id' => 'tax_listings_location',
                      'label' => __('Select The Area','framework'),
                      'format' => 'select',
                      'default' => '',
                      'values' => array('' => __('Select A Location First','atlas')),
                );

            } else {
            
                $args['fields'][] = array(
                    'type' => 'taxonomy',
                    'label' => __('Listing Location','atlas'),
                    'taxonomy' => 'listings_location',
                    "allow_null" => __('All Locations','atlas'),
                    'format' => 'select',
                    'operator' => 'IN'
                );

            }

        }

        if(!get_field('disable_featured_listings_lookup_field','option')) {

            $args['fields'][] = array(
                'type' => 'meta_key',
                'label' => '',
                'meta_key' => 'listing_is_featured',
                'format' => 'radio',
                'values' => array('' => __('Display All Listings','atlas'), '1' => __('Display Only Featured Listings','atlas') ),
                'compare' => 'LIKE'
            );
        
        }   


         /* 
         * Add Custom Search Fields 
         */

        while(has_sub_field('search_form_custom_fields_builder','option')) {

            /* 
             * add some spacing
             */
            $args['fields'][] = array(
                    'type' => 'html',
                    'value' => '<div clas="clearboth"></div><br/><br/>'
            );

            /* 
             * Add Author Field
             */

            if(get_row_layout() == "author_field") {

                $args['fields'][] = array(
                    'type' => 'author',
                    'label' => get_sub_field("field_label"),
                    'format' => get_sub_field("field_format"),
                    'default' => get_sub_field('default_value'),
                    'authors' => array()
                );

            }

            /* 
             * Add html field
             */

            if(get_row_layout() == "html") {

                $args['fields'][] = array(
                    'type' => 'html',
                    'value' => get_sub_field('content')
                );

            }

            /* 
             * Add metakey field
             */

            if(get_row_layout() == "meta_key") {

                $has_values = array();

                if(get_sub_field("field_format") !== 'text') {

                    $querystring = get_sub_field("values");
                    $final = array();
                     
                    foreach( explode('%', $querystring) as $p ) {
                        list($key, $value) = explode('=', $p);
                        $final[$key] = $value;
                    }
                     
                    // Test it
                    //print_r($final);

                    $has_values = $final;

                }

                $args['fields'][] = array(
                    'type' => 'meta_key',
                    'label' => get_sub_field("field_label"),
                    'format' => get_sub_field("field_format"),
                    'meta_key' => get_sub_field("meta_key"),
                    'values' => $has_values,
                    'compare' => get_sub_field("compare"),
                    'data_type' => get_sub_field("data_type"),
                    'default' => get_sub_field("default"),
                );

            }

            /* 
             * Add taxonomuy field
             */

            if(get_row_layout() == "taxonomy") {

                $excluded_ids = get_sub_field('exclude_terms');
                $excluded_array=explode(",",$excluded_ids);

                $args['fields'][] = array(
                    'type' => 'taxonomy',
                    'label' => get_sub_field("field_label"),
                    'format' => get_sub_field("field_format"),
                    'taxonomy' => get_sub_field("taxonomy_name"),
                    'default' => get_sub_field('default'),
                    'operator' => get_sub_field("operator"),
                    'term_args' => array(
                                    'hide_empty' => true,
                                    'exclude' =>  $excluded_array
                                    )
                );

            }

            /* 
             * Add listings tags field
             */

            if(get_row_layout() == "listings_tags") {

                $args['fields'][] = array(
                    'type' => 'taxonomy',
                    'label' => get_sub_field("field_label"),
                    'format' => get_sub_field("field_format"),
                    'taxonomy' => 'listings_tags',
                    'operator' => 'IN'
                );

            }


        }


        $args['fields'][] = array(
            'type' => 'submit',
            'value' => __('Search For Listings','atlas')
        );
        return $args;
    }
}

$result = add_role(
    'basic_contributor'
    , 'Listing Contributor'
    , array(
        'read'         => true,  // True allows this capability
        'edit_posts'   => true,
        'delete_posts' => true, // Use false to explicitly deny
        'upload_files' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'edit_published_pages' => true,
        'edit_published_posts' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
    ) 
);

if(get_option( 'default_role' ) !== 'basic_contributor') {

    function tdp_userrole_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'Warning: to allow users to post from the front-end you need to change the default registration user role. Please navigate to "Settings" -> "General" and change the option "New User Default Role" to "Listing Contributor".', 'atlas' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'tdp_userrole_admin_notice' );

}


function dp_print_head_style2() {

    // This needs to be here otherwise changing the option into the customizer won't refresh the preview.
    if(get_field('skin_type','option') == 'skin2') {
    
       wp_enqueue_style( 'skin2' , get_template_directory_uri().'/css/'.'skin2'.'.css'); 
    
    } else if(get_field('skin_type','option') == 'skin3') {
    
       wp_enqueue_style( 'skin3' , get_template_directory_uri().'/css/'.'skin3'.'.css'); 

    } else if(get_field('skin_type','option') == 'skin4') {
    
       wp_enqueue_style( 'skin4' , get_template_directory_uri().'/css/'.'skin4'.'.css');

    } else if(get_field('skin_type','option') == 'skin5') {
    
       wp_enqueue_style( 'skin5' , get_template_directory_uri().'/css/'.'skin5'.'.css'); 

    } else if(get_field('skin_type','option') == 'skin6') {
    
       wp_enqueue_style( 'skin6' , get_template_directory_uri().'/css/'.'skin6'.'.css');

    } else if(get_field('skin_type','option') == 'skin7') {
    
       wp_enqueue_style( 'skin7' , get_template_directory_uri().'/css/'.'skin7'.'.css'); 
    
    } 

    if(get_field('skin_type','option') == 'Custom Skin') {

            $css_data = "

            #top-bar {
                background-color: ". get_field('topbar_gradient_start','option','option') .";
                background-repeat: repeat-x;
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(". get_field('topbar_gradient_start','option') ."), to(". get_field('topbar_gradient_end','option') ."));
                background: -webkit-linear-gradient(top, ". get_field('topbar_gradient_start','option') .", ". get_field('topbar_gradient_end','option') .");
                background: -moz-linear-gradient(top, ". get_field('topbar_gradient_start','option') .", ". get_field('topbar_gradient_end','option') .");
                background: -ms-linear-gradient(top, ". get_field('topbar_gradient_start','option') .", ". get_field('topbar_gradient_end','option') .");
                background: -o-linear-gradient(top, ". get_field('topbar_gradient_start','option') .", ". get_field('topbar_gradient_end','option') .");
            }

            #topintro {
                color: ". get_field('topbar_text_color','option','option') .";
            }

            #topintro a {
                color:". get_field('topbar_links_color','option','option') .";
            }

            #header-container, #header-border, #search-popup h4 {
                background: ". get_field('header_color','option') .";
            }

            #header-container, #header-border {
                border-color:". get_field('header_color','option') .";
            }

            #navigation-wrapper ul li a {
                color: ". get_field('header_links_color','option') .";
            }

            #navigation-wrapper ul li.active a {
                color: ". get_field('header_active_link_color','option') .";
            }

            .tab-nav {
                background: ". get_field('homepage_sidebar_bg_color','option') .";
            }

            #home-sidebar {
                background: ". get_field('homepage_sidebar_tabs_bg_color','option') .";
            }

            .tab-nav a {
                color: ". get_field('homepage_sidebar_tabs_icon_color','option') .";
            }

            .tab-nav li.ui-state-active a {
                color: ". get_field('homepage_sidebar_tabs_icon_active_color','option') .";
            }

            .tab-content h1, .tab-content h2, .tab-content h3, .tab-content h4, .tab-content h5, .tab-content h6 {
                color: ". get_field('homepage_sidebar_tabs_headings_color','option') .";
            }

            /* BG */
            figure:hover .overlay .thumb-info, #sidebar-wrapper .sep, .link-wrapper, .marker-title, .cbp-vm-view-grid .single-image figure .thumb-info, .featured-star, #comments.reviews-comments #reply-title, .stats-rating, #search-popup h1, #front-login h1, .toggle-button:hover, .toggle-activator.hello-im-hidden .toggle-button, #open-search:hover {
                background: ". get_field('theme_main_color','option') .";
            }

            /* BDC */

            input:focus, textarea:focus, form.search-form > fieldset.has-focus, #content-container .featured-listing, #comments.reviews-comments #reply-title  {
                border-color:". get_field('theme_main_color','option') .";
            }

            /* C */
            .widget_tdp_listings_details li span, .tab-lister i, a.action-button span, a {
                color:". get_field('theme_main_color','option') .";
            }

            body {
                color:". get_field('body_font_color','option') .";
                background:". get_field('body_background_color','option') .";
            }

            .cluster {
               background:". get_field('map_pulse_animation_bg_color','option') ."; 
            }

            #top-footer {
                background:". get_field('top_footer_background_color','option') ."; 
            }

            #bottom-footer {
                background:". get_field('bottom_footer_background_color','option') .";
                border-color:". get_field('bottom_footer_border_color','option') .";
                color:". get_field('footer_font_color','option') .";
            }

            #top-footer .widget {
                color: ". get_field('footer_font_color') ." !important;
            }";

            wp_add_inline_style( 'main-style', $css_data );

    }



}

add_action( 'wp_enqueue_scripts', 'dp_print_head_style2' );