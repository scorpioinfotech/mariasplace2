<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Atlas
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php 

	dp_head_common();

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	
    global $current_user;
	wp_head();
    
 
?>
</head>

<body <?php body_class(); ?>>