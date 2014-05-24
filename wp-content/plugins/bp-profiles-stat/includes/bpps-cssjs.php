<?php

function bpps_load_assets($page){
    add_action('admin_print_styles-'  . $page, 'bpps_admin_styles');
    add_action('admin_print_scripts-' . $page, 'bpps_admin_scripts');
}

function bpps_admin_styles(){
    wp_enqueue_style('bpps_admin_css');
}

function bpps_admin_scripts(){
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('bpps_admin_js');
    //wp_enqueue_script('bpps_js_sticky');
    wp_enqueue_script('bpps_js_flot');
}

add_action( 'admin_init', 'bpps_admin_init' );
function bpps_admin_init(){
    wp_register_style ('bpps_admin_css',   BPPS_URL . '/css/admin-styles.css' );
    wp_register_script('bpps_admin_js',    BPPS_URL . '/js/admin-scripts.js', array('jquery', 'jquery-ui-datepicker') );
    //wp_register_script('bpps_js_sticky',   BPPS_URL . '/js/jquery.sticky.min.js', array('jquery') );
    wp_register_script('bpps_js_flot',     BPPS_URL . '/js/jquery.flot.min.js', array('jquery') );
}

?>