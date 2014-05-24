<?php
/*
Plugin Name: MiniGO
Plugin URI: http://themeforest.net/user/PremioThemes?ref=PremioThemes
Description: MiniGO - Uber Minimal Flat Coming Soon WP Plugin
Version: 1.0.3
Author: Premio Themes
Author URI: http://www.premiothemes.com
License: Commercial
Copyright 2014  Premio Themes
*/

$minigo_version = '1.0.3';

/**
 * Init
 *
 * @package WordPress
 * @subpackage MiniGO
 * @since 1.0
 */

/**
 * Require config to get our initial values
 */

/**
 * Upon activation of the plugin, see if we are running the required version and deploy theme in defined.
 *
 * @since 1.0
 */

$minigo_path = plugin_dir_path(__FILE__);
$minigo_url = plugin_dir_url(__FILE__);

//[minigo-logo]
function minigo_logo_shortcode(){
    global $premiothemes_comingsoon_minigo;

    if(empty($premiothemes_comingsoon_minigo['logo']['url'])) {
        return '';
    }

    return '<div class="grid">
                <div class="grid__item one-whole push--bottom">
                    <img src="'.$premiothemes_comingsoon_minigo['logo']['url'].'" alt="'.htmlspecialchars($premiothemes_comingsoon_minigo['site-title']).'" width="'.$premiothemes_comingsoon_minigo['logo-width'].'" height="'.$premiothemes_comingsoon_minigo['logo-height'].'">
                </div>
            </div>';
}
add_shortcode( 'minigo-logo', 'minigo_logo_shortcode' );

//[minigo-countdown]
function minigo_countdown_shortcode( ){
    global $premiothemes_comingsoon_minigo;

    if(!$premiothemes_comingsoon_minigo['countdown-enabled']) {
        return;
    }

    return '<div class="grid">
                <div class="grid__item one-whole">
                    <div class="clock" data-labels="'.htmlspecialchars($premiothemes_comingsoon_minigo['countdown-labels']).'"></div>
                </div>
            </div>';
}
add_shortcode( 'minigo-countdown', 'minigo_countdown_shortcode' );

//[minigo-subscribe-form]
function minigo_subscribe_form_shortcode( ){
    global $premiothemes_comingsoon_minigo;
    return '<div class="grid">
                <div class="grid__item one-whole push--top">
                    <div class="form-flip push--top">
                        <button class="form-flip__enabler btn btn--full">'.$premiothemes_comingsoon_minigo['subscribe-form-title'].'</button>

                        <div class="form-flip__target">
                            <form class="form-ajax" data-success-response="success" action="" method="post">
                                <div class="input-group">
                                    <input class="text-input" name="email" type="email" placeholder="'.htmlspecialchars($premiothemes_comingsoon_minigo['subscribe-form-email-label']).'" data-msg-required="'.htmlspecialchars($premiothemes_comingsoon_minigo['form-validation-required']).'" data-msg-email="'.htmlspecialchars($premiothemes_comingsoon_minigo['form-validation-email']).'" required>
                                    <div class="input-group-addon">
                                        <button class="btn btn--font-black" type="submit" autocomplete="off"><span>'.$premiothemes_comingsoon_minigo['subscribe-form-button-label'].'</span><i class="form-spinner fa fa-spinner"></i></button>
                                    </div>
                                </div>
                                <input type="hidden" name="minigo_subscribe">
                                <input type="text" name="important-info">
                                '.wp_nonce_field( 'minigo', '_wpnonce', true, false).'
                            </form>
                        </div>

                        <button class="form-flip__close btn btn--full">'.$premiothemes_comingsoon_minigo['subscribe-form-success-message'].'</button>
                    </div>
                </div>
            </div>';
}
add_shortcode( 'minigo-subscribe-form', 'minigo_subscribe_form_shortcode' );

//[minigo-contact-info]
function minigo_contact_info_shortcode( ){
    global $premiothemes_comingsoon_minigo;

    if(empty($premiothemes_comingsoon_minigo['contact_info']) || count($premiothemes_comingsoon_minigo['contact_info']) < 1) {
        return;
    }

    $contact_info = array_values($premiothemes_comingsoon_minigo['contact_info']);

    if(empty($premiothemes_comingsoon_minigo['contact_info'][0]['title'])) {
        return;
    }


    $html = '
<div class="grid">
    <div class="grid__item one-whole">';


    for ($i=0, $cnt = count($contact_info); $i < $cnt; $i++) {
        $item = $contact_info[$i];

        if(!empty($item['force_row']) && $i !== 0) {
            $html .= '
    </div>
    <div class="grid__item one-whole push-half--top">';
        }

        $html .= '
        <div class="contact-info"><i class="fa '.$item['select'].'"></i>'.(!empty($item['url']) ? '<a href="'.$item['url'].'">' : '').$item['title'].(!empty($item['url']) ? '</a>' : '').'</div>'."\n";

    //     if(!empty($item['force_row']) && $i+1 !== $cnt) {
    //         $html .= '
    // </div>';
    //     }

    //     if(!empty($item['force_row']) && $i+1 !== $cnt) {
    //         $html .= '
    // <div class="grid__item one-whole push-half--top">';
    //     }
    }

    $html .= '
    </div>
</div>';

    return $html;
}
add_shortcode( 'minigo-contact-info', 'minigo_contact_info_shortcode' );

//[minigo-contact-form]
function minigo_contact_form_shortcode() {
    global $premiothemes_comingsoon_minigo;

    return '<form id="contactForm" data-msg-success="'.htmlspecialchars($premiothemes_comingsoon_minigo['contact-form-success-message']).'" class="form-ajax" data-success-response="success" action="" method="post">
                <div class="grid">
                    <div class="grid__item one-half palm-one-whole push--top">
                        <input class="text-input" name="name" type="text" placeholder="'.htmlspecialchars($premiothemes_comingsoon_minigo['contact-form-name-label']).'" data-msg-required="'.htmlspecialchars($premiothemes_comingsoon_minigo['form-validation-required']).'" required>
                    </div>
                    <div class="grid__item one-half palm-one-whole push--top">
                        <input class="text-input" name="email" type="email" placeholder="'.htmlspecialchars($premiothemes_comingsoon_minigo['contact-form-email-label']).'" data-msg-required="'.htmlspecialchars($premiothemes_comingsoon_minigo['form-validation-required']).'" data-msg-email="'.htmlspecialchars($premiothemes_comingsoon_minigo['form-validation-email']).'" required>
                    </div>
                    <div class="grid__item one-whole push--top">
                        <textarea rows="6" name="message" placeholder="'.htmlspecialchars($premiothemes_comingsoon_minigo['contact-form-message-label']).'" data-msg-required="'.htmlspecialchars($premiothemes_comingsoon_minigo['form-validation-required']).'" required></textarea>
                    </div>
                    <div class="grid__item one-whole push--top">
                        <button class="btn btn--font-bold" type="submit" autocomplete="off"><span>'.$premiothemes_comingsoon_minigo['contact-form-button-label'].'</span><i class="form-spinner fa fa-spinner"></i></button>
                    </div>
                </div>
                <input type="hidden" name="minigo_contact">
                <input type="text" name="important-info">
                '.wp_nonce_field( 'minigo', '_wpnonce', true, false).'
            </form>';
}
add_shortcode( 'minigo-contact-form', 'minigo_contact_form_shortcode' );

/**
 * Config
 */

if ( ! class_exists( 'PremioThemes_ComingSoon' ) ) {
    class PremioThemes_ComingSoon {

        function __construct() {
            global $premiothemes_comingsoon_minigo;

            if(!empty($premiothemes_comingsoon_minigo['comingsoon-enabled']) || isset($_GET['cs_preview'])){
                if(function_exists('bp_is_active')){
                    add_action('template_redirect', array($this,'render_comingsoon_page'),9);
                }else{
                    add_action('template_redirect', array($this,'render_comingsoon_page'));
                }
            }

            if(!empty($premiothemes_comingsoon_minigo['comingsoon-enabled'])) {
                add_action( 'admin_bar_menu',array( $this, 'admin_bar_menu' ), 1000 );
                if ( is_user_logged_in() ) {
                    wp_enqueue_style( 'premiothemes-comingsoon-minigo-admin', plugins_url('inc/admin/admin.css', __FILE__) , array(), $minigo_version, 'screen');
                }
            }

            if(isset($_POST['minigo_subscriber_list'])) {
                update_option( 'minigo_subscriber_list', $_POST['minigo_subscriber_list'] );
                header('Location: '.$_SERVER['REQUEST_URI']);
            }
        }

        /**
        * Display admin bar when active
        */
        function admin_bar_menu($str){
            global $wp_admin_bar;
            global $premiothemes_comingsoon_minigo;

            $msg = '';
            if ($premiothemes_comingsoon_minigo['comingsoon-enabled'] == 'maintenance_mode') {
                $msg = __('Maintenance Mode Active','seedprod');
            } elseif ($premiothemes_comingsoon_minigo['comingsoon-enabled'] == 'coming_soon') {
                $msg = __('Coming Soon Mode Active','seedprod');
            }
            //Add the main siteadmin menu item
            $wp_admin_bar->add_menu( array(
                'id'     => 'premiothemes-comingsoon-notice',
                'href' => admin_url().'admin.php?page=minigo_options',
                'parent' => 'top-secondary',
                'title'  => $msg,
                'meta'   => array( 'class' => 'premiothemes-comingsoon-active' ),
            ) );
        }

        /**
         * Display the coming soon page
         */
        function render_comingsoon_page() {
                global $premiothemes_comingsoon_minigo;

                // Return if a login page
                if(preg_match("/login/i",$_SERVER['REQUEST_URI']) > 0){
                    return false;
                }

                if(!isset($_GET['cs_preview']) && !empty($premiothemes_comingsoon_minigo['whitelist-ips'])) {
                    $ips = explode("\n", str_replace("\r\n", "\n", trim($premiothemes_comingsoon_minigo['whitelist-ips'])));

                    if(!empty($ips) && in_array($_SERVER['REMOTE_ADDR'], $ips)) {
                        return false;
                    }
                }

                if(!is_admin()){
                    if(!is_feed()){
                        if ( !is_user_logged_in() || (isset($_GET['cs_preview']))) {
                            if(!empty($_POST)) {
                                if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'minigo' ) ) {
                                    exit('nonce failed');
                                }
                                ob_start();
                                $protocol = "HTTP/1.0";
                                if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] ) {
                                    $protocol = "HTTP/1.1";
                                }

                                header( "$protocol 200 OK", true, 200 );
                                include plugin_dir_path(__FILE__).'template/mailListHandler.php';
                                ob_end_flush();
                                exit;
                            }
                            ob_start();
                            if ($premiothemes_comingsoon_minigo['comingsoon-enabled'] == 'maintenance_mode' && !isset($_GET['cs_preview'])) {
                                $this->send_503();
                            }

                            show_admin_bar(false);
                            remove_action('wp_head', '_admin_bar_bump_cb');

                            $file = plugin_dir_path(__FILE__).'template/comingsoon.php';
                            include($file);
                            ob_end_flush();
                            exit();
                        }
                    }
                }
        }

        function send_503() {
            global $premiothemes_comingsoon_minigo;

            $protocol = "HTTP/1.0";
            if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] ) {
                $protocol = "HTTP/1.1";
            }
            $retryAfter = strtotime($premiothemes_comingsoon_minigo['countdown-targetDate'].' '.$premiothemes_comingsoon_minigo['countdown-targetHour'].':'.$premiothemes_comingsoon_minigo['countdown-targetMinutes']) - time();

            if($retryAfter < 0) {
                $retryAfter = 3600;
            }

            header( "Content-type: text/html; charset=UTF-8" );
            header( "$protocol 503 Service Unavailable", true, 503 );
            header( "Retry-After: $retryAfter" );
        }
    }
}

    if ( !function_exists('wp_set_current_user') ) {
        require_once( ABSPATH . WPINC . '/pluggable.php' );
    }

    if ( !class_exists( 'redux-framework' ) && file_exists( plugin_dir_path(__FILE__) . 'inc/redux-framework/ReduxCore/framework.php' ) ) {
        require_once( plugin_dir_path(__FILE__) . 'inc/redux-framework/ReduxCore/framework.php' );
        require_once( plugin_dir_path(__FILE__) . 'inc/field-contact-info/field_contact_info.php' );
        require_once( plugin_dir_path(__FILE__) . 'inc/field-footer-links/field-footer-links.php' );
    }


    if ( file_exists( plugin_dir_path(__FILE__) . 'inc/admin/config.php' ) ) {
        require_once( plugin_dir_path(__FILE__) . 'inc/admin/config.php' );
        require_once( plugin_dir_path(__FILE__) . 'inc/admin/font-awesome/font-awesome-icons.php' );
        new PremioThemes_ComingSoon_Admin();
        new PremioThemes_ComingSoon();
    }


function minigo_icon_font() {

    wp_enqueue_script(
        'field-awesome-select-js',
        plugins_url( 'inc/admin/font-awesome/select2-font-awesome.js' , __FILE__ ),
        array('jquery', 'select2-js'),
        time(),
        true
    );

    wp_register_style(
        'redux-font-awesome',
        '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
        array(),
        time(),
        'all'
    );
    wp_enqueue_style( 'redux-font-awesome' );
}
// This example assumes your opt_name is set to premiothemes_comingsoon_minigo, replace with your opt_name value
add_action( 'redux/page/premiothemes_comingsoon_minigo/enqueue', 'minigo_icon_font' );

function minigo_addPanelCSS() {
    wp_register_style(
        'minigo-redux-custom-css',
        plugins_url( 'inc/admin/custom.css' , __FILE__ ),
        array( 'redux-css' ), // Be sure to include redux-css so it's appended after the core css is applied
        time(),
        'all'
    );
    wp_enqueue_style('minigo-redux-custom-css');
}
// This example assumes your opt_name is set to premiothemes_comingsoon_minigo, replace with your opt_name value
add_action( 'redux/page/premiothemes_comingsoon_minigo/enqueue', 'minigo_addPanelCSS' );

function minigo_addPanelJS() {
    wp_enqueue_script(
        'minigo-redux-custom-js',
        plugins_url( 'inc/admin/custom.js' , __FILE__ ),
        array('jquery', 'select2-js'),
        time(),
        true
    );
}
// This example assumes your opt_name is set to premiothemes_comingsoon_minigo, replace with your opt_name value
add_action( 'redux/page/premiothemes_comingsoon_minigo/enqueue', 'minigo_addPanelJS' );


/* Fix for wrong wp_editor height */
function minigo_fix_editor_height_filter($in)
{
    $in['min_height'] = 300;
    return $in;
}
function minigo_fix_editor_height() {
    add_filter('tiny_mce_before_init', 'minigo_fix_editor_height_filter' );
}
add_action( 'redux/page/premiothemes_comingsoon_minigo/load', 'minigo_fix_editor_height' );

// Creates NONCE field value
wp_create_nonce( 'minigo' );