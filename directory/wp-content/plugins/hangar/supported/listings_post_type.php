<?php 
/**
 * Create listings post type
 */
$listings = new CPT(
    'listing', array(
        'supports' => array('title', 'editor', 'thumbnail', 'comments', 'author','custom-fields','tags'),
        'menu_icon' => get_template_directory_uri() . '/images/listings_icon.png',
        'taxonomies' => array( 'post_tag')
));

/**
 * Taxonomy for listings
 */
$listings->register_taxonomy(array(
    'taxonomy_name' => 'listings_categories',
    'singular' => 'Listing Category',
    'plural' => 'Listing Categories',
    'slug' => 'listings'
    
));
$listings->register_taxonomy(array(
    'taxonomy_name' => 'listings_location',
    'singular' => 'Listing Location',
    'plural' => 'Listing Locations',
    'slug' => 'location'
));
// define the columns to appear on the admin edit screen
$listings->columns(array(
    'cb' => '<input type="checkbox" />',
    'title' => __('Listing Title'),
    'listings_categories' => __('Listing Categories','atlas'),
    'listings_location' => __('Listing Locations','atlas'),
    'rating' => __('Listing Rating','atlas'),
    'date' => __('Date','framework'),
    'author' => __('Author','framework'),
));
// populate the ratings column
$listings->populate_column('rating', function($column, $post) { ?>

    <?php if(get_field('enable_ratings_system','option')) { ?>
                    <?php 
                    $overall_rating = tdp_get_rating(); 
                    ?>
                        <ul class="admin-rating">
                            <?php if($overall_rating == '1') { ?>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '2') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '3') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '4') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '5') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } ?>
                        </ul>
                <?php } 
});
// make rating and price columns sortable
$listings->sortable(array(
    'price' => array('price', true),
    'rating' => array('rating', true)
));