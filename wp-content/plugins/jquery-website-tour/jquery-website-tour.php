<?php

/**
Plugin Name: jQuery Website Tour for WordPress
Plugin URI: http://plugins.righthere.com/jquery-website-tour/
Description: This plugin allows you to create multiple tours on your website with jQuery. This can be very useful if you want to explain your users the features of your website in an interactive way. You can create tours that are spanning over multiple pages and link tours together. Easily add your tour slides with our point and click interface.
Version: 1.1.5 rev36710
Author: (RightHere LLC)
Author URI: http://plugins.righthere.com
**/

define('JWT_VERSION','1.1.5'); 
define('JWT_PATH', plugin_dir_path(__FILE__) ); 
define("JWT_URL", plugin_dir_url(__FILE__) );
define("CURRENT_USER_LOGIN_TAG","{current_user_login}");

require_once JWT_PATH.'includes/class.plugin_website_tour.php';
$jwt_plugin = new plugin_website_tour();

?>