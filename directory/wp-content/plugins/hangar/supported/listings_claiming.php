<?php
/**
 * Load claim listings module
 */

$listings_claiming = new CPT(
    'claimed_listing', array(
        'supports' => array('title', 'editor'),
        'menu_icon' => get_template_directory_uri() . '/images/claimed_listings_icon.png',
        'has_archive'         => false,
        'exclude_from_search' => true,
));