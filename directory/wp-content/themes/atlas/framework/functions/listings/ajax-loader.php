<?php 

/**
 * Use json to load all listings
 */
function tdp_listing_pins(){

    if(is_tax()) {

        $queried_object = get_queried_object(); 
        $taxonomy = $queried_object->taxonomy;
        $term_id = $queried_object->term_id;

        $args = array( 'post_type' => 'listing', 'posts_per_page' => -1, 'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'id',
                            'terms' => $term_id
                        )
                ));

    } else {

        $args = array(
            'post_type' => 'listing',
            'posts_per_page' => -1
        );

    }

    $json_loop = new WP_Query($args);

    while($json_loop->have_posts()): $json_loop->the_post();

        $the_id = get_the_ID();

        // we will use the first term to load ACF data from

        if(is_tax()) {

            if (is_tax('listings_location')) {

                // load all 'category' terms for the post
                $terms = get_the_terms($post->ID, 'listings_categories');

                // we will use the first term to load ACF data from
                if (!empty($terms)) {
                    $term = array_pop($terms);

                    if (get_field("listing_is_featured")) {
                        $custom_field = get_field('featured_marker', 'listings_categories_'.$term ->term_id);
                    } else {
                        $custom_field = get_field('marker_type', 'listings_categories_'.$term ->term_id);
                    }

                    $custom_marker = $custom_field;

                    // do something with $custom_field
                }

            } else {

                // load all 'categories' terms for the post
                $terms = get_the_terms($post->ID, 'listings_categories');
                // we will use the first term to load ACF data from
                if (!empty($terms)) {
                    $term = array_pop($terms);
                    // Checking if listing is featured, if so load another marker image.
                    if (get_field("listing_is_featured")) {
                        $custom_marker = get_field('featured_marker', 'listings_categories_'.$term->term_id);
                    } else {
                        $custom_marker = get_field('marker_type', 'listings_categories_'.$term->term_id);
                    }
                }

            }
            if($custom_marker == '') {
                $custom_marker = 'https://mts.googleapis.com/vt/icon/name=icons/spotlight/spotlight-poi.png&scale=1';
            }

        } else {
            
            $terms = get_the_terms($the_id, 'listings_categories');
            if( !empty($terms) )
            {
                $term = array_pop($terms);
                // Checking if listing is featured, if so load another marker image.
                if(get_field("listing_is_featured")) {
                    $custom_marker = get_field('featured_marker', 'listings_categories_' . $term->term_id );
                } else {
                    $custom_marker = get_field('marker_type', 'listings_categories_' . $term->term_id );
                }
            }
            if($custom_marker == '') {
                $custom_marker = 'https://mts.googleapis.com/vt/icon/name=icons/spotlight/spotlight-poi.png&scale=1';
            }

        }

        /* ACF Plugin doesn't work in json request so we use the default get_post_meta function to get the field details */
        $myvar = esc_html(get_post_meta($the_id, 'location', true));

        // Remove address from location string
        $coordinates = end(explode('|',$myvar));

        // Split address in array
        $latlng = explode(",", $coordinates);

        // Get Listing Address
        $popup_address = '<li><span class="icon-direction"></span>';
        if(get_field('map_tooltip_content','option') == 'Listing Address' || get_field('map_tooltip_content','option') == '') {
                if(get_field('override_generated_address')) {
                    $popup_address.= get_field('override_generated_address');
                } else {
                    $listing_address = get_field('location'); 
                    $popup_address .= str_replace("'", "", $listing_address['address']);
                }
        } else if(get_field('map_tooltip_content','option') == 'Listing Excerpt') {
            $text_pop = get_the_content(); 
            $trimmed_pop = wp_trim_words( $text_pop, $num_words = 20, $more = null ); 
            $popup_address .= addslashes($trimmed_pop);
        }
        $popup_address .= '</li>';

        //Get Listing Phone
        $popup_phone = '';
        if(get_field('telephone')) {
            $popup_phone .= '<li><span class="icon-phone"></span>';
                $popup_phone .= get_field('telephone');
            $popup_phone .= "</li>";
        }

        // Get Listing Mobile
        $popup_mobile = '';
        if(get_field('mobile_phone_number')) {
            $popup_mobile .= '<li><span class="icon-mobile"></span>';
                $popup_mobile .= get_field('mobile_phone_number');
            $popup_mobile .= "</li>";
        } 

        // Get Listing Website
        $popup_website = '';
        if(get_field('website')) {
            $popup_website .= '<li><span class="icon-link"></span>';
                $popup_website .= '<a rel="nofollow" target="_blank" href="' . get_field('website') . '">' . get_field('website') . '</a>';
            $popup_website .= "</li>";
        }

        //Get Listing Image
        $popup_image = '';
        if( has_post_thumbnail() ) {  
            $thumb = get_post_thumbnail_id(); 
            $img_url = wp_get_attachment_url( $thumb,"full" ); 
            $image = aq_resize( $img_url, 100, 100, true ); 

            if(get_field('override_hyperlink','option')) { 

                $popup_image .= '<div class="one_third last image-wrapper pop-image"><a href="' . get_field('website') . '" title="'. get_the_title() . '"> <img src="' . $image . '" alt="' . get_the_title() . '"/></a></div>' ;

            } else {
            
                $popup_image .= '<div class="one_third last image-wrapper pop-image"><a href="' . get_permalink() . '" title="'. get_the_title() . '"> <img src="' . $image . '" alt="' . get_the_title() . '"/></a></div>' ;

            }
        }

        // Get Listing Read More Button
        $popup_read_more = '';
        if(get_field('override_hyperlink','option')) {
            $popup_read_more .= '<div class="clearboth"></div><div class="linker"><a class="button black medium" href="' . get_field('website') . '">' . __('Read More &raquo;','atlas') .'</a></div>';
        } else {
            $popup_read_more .= '<div class="clearboth"></div><div class="linker"><a class="button black medium" href="' . get_permalink() . '">' . __('Read More &raquo;','atlas') .'</a></div>';
        }

        $place_markers = array();

        $place_markers[] = get_the_title();
        $place_markers[] = $latlng[0];
        $place_markers[] = $latlng[1];
        $place_markers[] = get_permalink();
        $place_markers[] = $the_id;
        $place_markers[] = $popup_address;
        $place_markers[] = $popup_phone;
        $place_markers[] = $popup_mobile;
        $place_markers[] = $popup_website;
        $place_markers[] = $popup_image;
        $place_markers[] = $popup_read_more;
        $place_markers[] = $custom_marker;

        $markers[] = $place_markers;

    endwhile; 
    wp_reset_query(); 
    return json_encode($markers);
}

/**
 * Json Map Loader
 */
function tdp_ajax_scripter() {

    //zoom
    if(get_field('adjust_zoom','option') !== '') { 
        $zoom = get_field('adjust_zoom','option'); 
    } else { 
        $zoom = '18'; 
    }

    //draggable 
    if(get_field('is_draggable','option')) {
        $draggable = true;
    } else {
        $draggable = false;
    }

    //map type control
    if(get_field('map_type_control','option')) {
        $maptypecontrol = true;
    } else {
        $maptypecontrol = false;
    }

    //scroll
    if(get_field('scrollwheel_control','option')) {
        $scrollwheel = true;
    } else {
        $scrollwheel = false;
    }

    //street view control
    if(get_field('street_view_control','option')) {
        $street_view_control = true;
    } else {
        $street_view_control = false;
    }

    //
    if(get_field('zoom_control','option')) {
        $zoom_control = true;
    } else {
        $zoom_control = false;
    }

    //keyboard

    if(get_field('keyboard_shortcuts','option')) {
        $keyboard = true;
    } else {
        $keyboard = false;
    }

    //check for geolocation
    if(get_field('enable_geolocation','option')) {
        $set_geolocation = 'yes';
    } else {
        $set_geolocation = 'no';
    }

    //check for clusters
    $cluster_enabled = 'yes';

    if(get_field('cluster_image','option')) {
        $cluster_image = get_field('cluster_image','option');
    } else {
        $cluster_image = get_template_directory_uri() . '/images/cluster.png';
    }

    if(get_field('enable_search_on_map','option') && get_field('display_homepage_sidebar','option') && !is_page_template('template-homepage-listings-content.php') && !is_page_template('template-homepage-map-search.php') && !is_tax()) { 
        $by_address = 'yes';
    } else {
        $by_address = 'no';
    }

    //check for poi
    if(get_field('disable_poi','option')) {
        $poi_disabled = 'yes';
    } else {
        $poi_disabled = 'no';
    }

    // main address
    // Split address in array
    $latlng = explode(",", get_field('custom_map_center','option'));

    if ( is_page_template( 'template-homepage.php' ) || is_page_template( 'template-homepage-listings-content.php' ) || is_page_template( 'template-homepage-map-search.php' ) || is_tax() ) {

        wp_enqueue_script('tdp_ajax_map', get_template_directory_uri().'/js/ajax_map.js',array('jquery'), '1.0', true);        

        wp_localize_script('tdp_ajax_map', 'tdp_ajax_map_vars', 
            array(  
                'general_latitude'  =>  $latlng[0],
                'general_longitude' =>  $latlng[1],
                'path'              =>  get_template_directory_uri().'/images',
                'markers'           =>  tdp_listing_pins(),
                'page_custom_zoom'  =>  $zoom,
                "draggable"         =>  $draggable,     
                "mapTypeControl"    =>  $maptypecontrol,
                "map_type"         =>   get_field('map_type_id','option'),
                "scrollwheel"       =>  $scrollwheel,
                "panControl"        =>  true,
                "rotateControl"     =>  false,
                "scaleControl"      =>  true,
                "streetViewControl" =>  $street_view_control,
                "zoomControl"       =>  $zoom_control,
                "keyboardShortcuts" =>  $keyboard,
                'geolocation'       =>  $set_geolocation,
                'geolocation_text'  =>  get_field('geolocation_text','option'),
                'geolocation_zoom'  =>  get_field('geolocation_zoom','option'),
                'geolocation_pin'   =>  get_field('geolocation_pin','option'),
                'enable_cluster'    =>  $cluster_enabled,
                'cluster_image'     =>  $cluster_image,
                'by_address'        =>  $by_address,
                'disable_poi'       =>  $poi_disabled
            )
        );

    }

}

add_action('wp_enqueue_scripts', 'tdp_ajax_scripter');


/**
 * Extend Map Api
 * Add ajax loader image
 */
function tdp_add_ajax_loader() {

    if(get_field('enable_ajax_map','option')) { ?>

        <div id="ajax-map-loader">

            <div id="floatingCirclesG">
                <div class="f_circleG" id="frotateG_01"></div>
                <div class="f_circleG" id="frotateG_02"></div>
                <div class="f_circleG" id="frotateG_03"></div>
                <div class="f_circleG" id="frotateG_04"></div>
                <div class="f_circleG" id="frotateG_05"></div>
                <div class="f_circleG" id="frotateG_06"></div>
                <div class="f_circleG" id="frotateG_07"></div>
                <div class="f_circleG" id="frotateG_08"></div>
            </div>

        </div> 

    <?php } 

}
add_action('tdp_after_homepage_map','tdp_add_ajax_loader');

/**
 * Extend Map Api
 * Add ajax loader image
 */
function tdp_add_ajax_loader_taxonomy() {

    if(get_field('enable_ajax_map','option')) { ?>

        <div id="ajax-map-loader" class="taxonomy-loader">

            <div id="floatingCirclesG">
                <div class="f_circleG" id="frotateG_01"></div>
                <div class="f_circleG" id="frotateG_02"></div>
                <div class="f_circleG" id="frotateG_03"></div>
                <div class="f_circleG" id="frotateG_04"></div>
                <div class="f_circleG" id="frotateG_05"></div>
                <div class="f_circleG" id="frotateG_06"></div>
                <div class="f_circleG" id="frotateG_07"></div>
                <div class="f_circleG" id="frotateG_08"></div>
            </div>

        </div> 

    <?php } 

}
add_action('tdp_after_taxonomy_map','tdp_add_ajax_loader_taxonomy');


/**
 * Extend Listings Loader
 */
add_action( 'wp_enqueue_scripts', 'tdp_register_ajax_view_loader', 1 );
function tdp_register_ajax_view_loader() {

    wp_register_script( 'functions-js', get_stylesheet_directory_uri() . '/js/ajaxview.js', array('jquery'), '1.0', true );
    
    /** Localize Scripts */
    $ajaxpath = array( 'admin_ajax' => admin_url( 'admin-ajax.php' ) );
    wp_localize_script( 'functions-js', 'ajaxpath', $ajaxpath );
 
}
 
/** Enqueue Scripts. */
add_action( 'wp_enqueue_scripts', 'tdp_enqueue_ajax_view_loader' );
function tdp_enqueue_ajax_view_loader() {
 
    /** Enqueue JavaScript Functions File */
    wp_enqueue_script( 'functions-js' );
 
}

/** Ajax Post */
add_action( 'wp_ajax_theme_post_example', 'theme_post_example_init' );
add_action( 'wp_ajax_nopriv_theme_post_example', 'theme_post_example_init' );
function theme_post_example_init() {
    
    // Get selected options through the sorting bar
    $term_id = $_POST[ 'term' ];
    $taxonomy = $_POST[ 'taxonomy' ];
    $sorting_method = $_POST[ 'sort' ];
    $paged = $_POST[ 'paged' ];
    $sort_query = $_POST[ 'sort_query' ];

    //get selected grid layout
    if(get_field('taxonomy_layout','option') !== 'Fullwidth') { 
        $grid_set_column = 'one_third';
        $row_num = 3;
    } else {
        $grid_set_column = 'one_fourth';
        $row_num = 4;
    }

    /**
     * Build The Query Based On Selected Parameters
     */
    if($sort_query == 'time_oldest') {

        /**
         * Order By Oldest First
         */
        $args = array(
            'post_type' => 'listing',
            'posts_per_page' => get_field('listings_per_page','option'),
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $term_id,
                    'operator' => 'IN'
                )
            ),
            'orderby' => 'date',
            'order' => 'ASC',
            'post_status' => 'publish'
        );

    } else if($sort_query == 'name_az') {

        /**
         * Order By Name A-Z
         */
        $args = array(
            'post_type' => 'listing',
            'posts_per_page' => get_field('listings_per_page','option'),
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $term_id,
                    'operator' => 'IN'
                )
            ),
            'orderby' => 'title',
            'order' => 'ASC',
            'post_status' => 'publish'
        );

    } else if($sort_query == 'name_za') {

        /**
         * Order By Name Z-A
         */
        $args = array(
            'post_type' => 'listing',
            'posts_per_page' => get_field('listings_per_page','option'),
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $term_id,
                    'operator' => 'IN'
                )
            ),
            'orderby' => 'title',
            'order' => 'DESC',
            'post_status' => 'publish'
        );

    } else if($sort_query == 'featured') {

        /**
         * Order By Name Z-A
         */
        $args = array(
            'post_type' => 'listing',
            'posts_per_page' => get_field('listings_per_page','option'),
            'paged' => $paged,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $term_id,
                    'operator' => 'IN'
                )
            ),
            'meta_query' => array(
                array(
                    'key' => 'listing_is_featured',
                    'value' => array(1),
                    'compare' => 'IN',
                )
            )
        );

    //Default to this query if something is wrong
    } else {

        $args = array(
            'post_type' => 'listing',
            'posts_per_page' => get_field('listings_per_page','option'),
            'paged' => $paged,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $term_id,
                    'operator' => 'IN'
                )
            ),
            'orderby' => 'meta_value',
            'meta_key' => 'listing_is_featured',
        );

        add_filter( 'posts_orderby', 'wpse_order_by' );

    }
    

    // Prepare query
    $ajax_taxonomy_query = new WP_Query( $args );

    //clearing alignment for grid view method
    $clear_row = '';
    $clear_row_end = '';

    if($ajax_taxonomy_query->have_posts()) {

        while( $ajax_taxonomy_query->have_posts() ) : $ajax_taxonomy_query->the_post(); $clear_row++; $clear_row_end++;
            
            //get selected sorting method
            if($sorting_method == 'list') {
                
                get_template_part( 'content', 'listing-list-view' );

            } else { ?>

                <div class="grid-column <?php echo $grid_set_column; ?> <?php if($clear_row == $row_num ) { echo " last"; $clear_row = 0; } ?>">
                    <?php get_template_part( 'content', 'listing-list-grid' ); ?>
                </div>

                <?php if($clear_row_end == $row_num) { echo '<div class="clear"></div>'; $clear_row_end = 0; } ?>

            <?php }

        endwhile;

    } else { ?>

        <h1 class="entry-title center-me">
            <span class="error-title"><i class="icon-attention"></i></span>
            <?php _e( 'Oops! It looks like nothing was found.', 'atlas' ); ?>
        </h1>

    <?php }

    exit;
}