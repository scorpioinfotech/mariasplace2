<?php
/* Make the theme available for translation.
 * Translations can be added to the LIB DIR /languages/ directory.
*/

/**
 * Load theme translation
 *
 * @link http://wordpress.stackexchange.com/a/33314 Translation Tutorial by the author
 * @return void
 */
 

// l18n translation files
$locale = get_locale();
$dir    = trailingslashit( get_template_directory() ) . 'languages/';
$mofile = "{$dir}{$locale}.mo";

// In themes/plugins/mu-plugins directory
load_textdomain( 'atlas', $mofile );