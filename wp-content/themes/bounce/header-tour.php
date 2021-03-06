<?php ob_start();	session_start();?><!DOCTYPE html>
<!--[if !IE]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<!--[if IE 9]>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js ie9">
<![endif]-->
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js ie8">
<![endif]-->
<head>
<meta charset=<?php bloginfo('charset'); ?> />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php bloginfo('name'); ?> | <?php is_home() || is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php require(gp_inc . 'options.php'); ?>
<?php require(gp_inc . 'page-styling.php'); ?>
<?php if(get_option($dirname.'_responsive') == "0") { ?><meta name="viewport" content="width=device-width, initial-scale=1"><?php } ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/animate.min.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/jquery.onebyone.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">

<?php wp_head(); ?>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/modernizr.custom.49511.js"></script>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/jquery.onebyone.min.js"></script>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/jquery.touchwipe.min.js"></script>

<script type="text/javascript">
		jQuery( document ).ready( function() {
			jQuery( 'a.confirm').click( function() {
				if ( confirm( 'Are you sure?' ) )
					return true; else return false;
			});
			
		jQuery('#banner').oneByOne({
			className: 'oneByOne1',
			/* Please provide the width and height in the responsive
			version, for the slider will keep the ratio when resize
			depends on these size. */
			width: 640,
			height: 360,
			easeType: 'random',
			slideShow: false,
			responsive: true,
			minWidth: 260,
			autoHideButton: true
		});




jQuery(".page-inner").css('opacity','1');
   jQuery("ul.sub-menu").hover(function() {
      jQuery(".page-inner").stop().animate({ opacity: 0.3 });
   }, function() {
      jQuery(".page-inner").stop().animate({ opacity: 1 }); 
   });



// nav dropdown
 var pull 		= jQuery('#pull');
	menu 		= jQuery('#nav ul');
	menuHeight	= menu.height();

	jQuery(pull).on('click', function(e) {
	e.preventDefault();
	menu.slideToggle();
	});

	jQuery(window).resize(function(){
        var w = jQuery(window).width();
        if(w > 320 && menu.is(':hidden')) {
        menu.removeAttr('style');
        	}
    });






		});
	</script>
</head>

<?php global $gp_settings; ?>

<body <?php body_class($gp_settings['layout'].' '.$gp_settings['padding'].' '.$gp_settings['frame'].' '.$gp_settings['skin']); ?>>
 
 
<!-- BEGIN HEADER OUTER -->

<?php if(!is_page_template('blank-page.php')) { ?>


	<div id="header-outer" class="page-outer">
		
		
	<!-- BEGIN PAGE INNER -->
		
		
	
			
			<!-- BEGIN LOGIN/REGISTER LINKS -->
			
			<?php if($theme_bp_links == "0" && function_exists('bp_is_active')) { ?>
			
				<div id="bp-links">
				
					<?php if(is_user_logged_in()) { ?>	
										
						<a href="<?php echo wp_logout_url(esc_url($_SERVER['REQUEST_URI'])); ?>" class="bp-logout-link"><?php _e('Logout', 'gp_lang'); ?></a>
	
					<?php } else { ?>
						
						<a href="<?php if($theme_login_url) { echo $theme_login_url; } else { echo wp_login_url(); } ?>" class="bp-login-link"><?php _e('Login', 'gp_lang'); ?></a>
						
						<?php if(bp_get_signup_allowed()) { ?><a href="<?php echo bp_get_signup_page(false); ?>" class="bp-register-link"><?php _e('Register', 'gp_lang'); ?></a><?php } ?>
						
					<?php } ?>
				
				</div>
				
				<div class="clear"></div>
				
			<?php } ?>
			
			<!-- END LOGIN/REGISTER LINKS -->
			
					
			<!-- BEGIN HEADER INNER -->
			
			<div id="header-inner">		
			
				
				<!-- BEGIN HEADER LEFT -->
				
				<div id="header-left">
				
					
					<!-- BEGIN LOGO -->
					
					<<?php if($gp_settings['title'] == "Show") { ?>div<?php } else { ?>h1<?php } ?> id="logo" style="<?php if($theme_logo_top) { ?> margin-top: <?php echo $theme_logo_top; ?>px;<?php } ?><?php if($theme_logo_left) { ?> margin-left: <?php echo $theme_logo_left; ?>px;<?php } ?><?php if($theme_logo_bottom) { ?> margin-bottom: <?php echo $theme_logo_bottom; ?>px;<?php } ?>">
						
						<span class="logo-details"><?php bloginfo('name'); ?> | <?php is_home() || is_front_page() ? bloginfo('description') : wp_title(''); ?></span>
						
						<?php if($theme_logo) { ?><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo($theme_logo); ?>" alt="<?php bloginfo('name'); ?>" /></a><?php } else { ?><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><span class="default-logo"></span></a><?php } ?>
						
					</<?php if($gp_settings['title'] == "Show") { ?>div<?php } else { ?>h1<?php } ?>>
					
					<!-- END LOGO -->
					
				
				</div>
				
				<!-- END HEADER LEFT -->
				
				
				<!-- BEGIN HEADER RIGHT -->
				
				<div id="header-right">
					

					<!-- BEGIN CONTACT INFO -->
									
					<?php if($theme_contact_info) { ?>
						<div id="contact-info">
							<?php echo do_shortcode(stripslashes($theme_contact_info)); ?>
						</div>
					<?php } ?>
					
					<!-- END CONTACT INFO -->
				
									
					<!-- BEGIN NAV -->
					
					<div id="nav">
<a href="#" id="pull">Menu</a>
					
						<?php wp_nav_menu('sort_column=menu_order&container=ul&theme_location=header-nav&fallback_cb=null'); ?>
						
						<?php wp_nav_menu(array('theme_location' => 'header-nav', 'items_wrap' => '<select class="mobile-menu">%3$s</select>', 'container' => '', 'menu_class' => '', 'sort_column' => 'menu_order', 'fallback_cb' => 'null', 'walker' => new gp_mobile_menu)); ?>
								
						
                        
                        
						<!-- BEGIN SOCIAL ICONS -->
                        
                                            

											
						<span id="social-icons">
						
							<?php if($theme_rss_button == "1") {} else { ?><a href="<?php if($theme_rss) { ?><?php echo($theme_rss); ?><?php } else { ?><?php bloginfo('rss2_url'); ?><?php } ?>" class="rss-icon" title="<?php _e('RSS Feed', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_twitter) { ?><a href="<?php echo $theme_twitter; ?>" class="twitter-icon" title="<?php _e('Twitter', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_facebook) { ?><a href="<?php echo $theme_facebook; ?>" class="facebook-icon" title="<?php _e('Facebook', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_digg) { ?><a href="<?php echo $theme_digg; ?>" class="digg-icon" title="<?php _e('Digg', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
						
							<?php if($theme_delicious) { ?><a href="<?php echo $theme_delicious; ?>" class="delicious-icon" title="<?php _e('Delicious', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
				
							<?php if($theme_dribbble) { ?><a href="<?php echo $theme_dribbble; ?>" class="dribbble-icon" title="<?php _e('Dribbble', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_youtube) { ?><a href="<?php echo $theme_youtube; ?>" class="youtube-icon" title="<?php _e('YouTube', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
				
							<?php if($theme_vimeo) { ?><a href="<?php echo $theme_vimeo; ?>" class="vimeo-icon" title="<?php _e('Vimeo', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
		
							<?php if($theme_linkedin) { ?><a href="<?php echo $theme_linkedin; ?>" class="linkedin-icon" title="<?php _e('LinkedIn', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_googleplus) { ?><a href="<?php echo $theme_googleplus; ?>" class="googleplus-icon" title="<?php _e('Google+', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
												
							<?php if($theme_myspace) { ?><a href="<?php echo $theme_myspace; ?>" class="myspace-icon" title="<?php _e('MySpace', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
													
							<?php if($theme_flickr) { ?><a href="<?php echo $theme_flickr; ?>" class="flickr-icon" title="<?php _e('Flickr', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php echo stripslashes($theme_additional_social_icons); ?>
	
						</span>
						
						<!-- END SOCIAL ICONS -->
					

<div class="@import url('icomoon.css');

/*?

Theme Name: Bounce
Version: 1.9.7
Description: Designed by <a href="http://www.ghostpool.com">GhostPool.com</a>.
Author: GhostPool
Author URI: http://www.ghostpool.com
Theme URI: http://www.ghostpool.com
License:
License URI:
Tags: buddypress, dark, light, black, gray, green, orange, purple, brown, blue, one-column, two-columns, left-sidebar, right-sidebar, fixed-width, custom-background, custom-colors, custom-menu, editor-style, featured-images, full-width-template, sticky-post, theme-options, translation-ready

*/



/************************************ General Styling ************************************/

@font-face {
    font-family: 'open_sansregular';
    src: url('fonts/opensans-regular-webfont.eot');
    src: url('fonts/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/opensans-regular-webfont.woff') format('woff'),
         url('fonts/opensans-regular-webfont.ttf') format('truetype'),
         url('fonts/opensans-regular-webfont.svg#open_sansregular') format('svg');
    font-weight: normal;
    font-style: normal;

}






@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5),only screen and (min-resolution: 192dpi) {

#logo a{
background: url("http://mariasplace.com/wp-content/uploads/logo_maria@2x.png") no-repeat scroll center top / 90%;
height:365px;
}

}

@font-face
{
font-family: Arial Narrow;
src: url(images/ARIALN.TTF);
}



.bp-links{display:none !important;}

/* Page Styling */

* {

font-family: Helvetica, Arial, sans-serif;

outline: none;

}

html {

margin: 0;

padding: 0;

}

body {

background: -webkit-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Safari */

background: -o-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Opera 11.1 to 12.0 */

background: -moz-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Firefox 3.6 to 15 */

background: linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* Standard syntax (must be last) */

color: #333;

margin: 0;

padding: 0;

font-family: Helvetica, Arial, sans-serif;

font-size: 12px;

font-weight: normal;

text-align: center;

overflow-x: hidden;

}



/* Text Styling */

a {

text-decoration: none;

-webkit-transition: color 0.12s ease-out;

-moz-transition: color 0.12s ease-out;

-o-transition: color 0.12s ease-out;

-ms-transition: color 0.12s ease-out;

transition: color 0.12s ease-out;

}



a img{width:auto; max-width:100%}



@font-face {

    font-family: 'roboto_slabregular';

    src: url('css/RobotoSlab-Regular-webfont.eot');

    src: url('css/RobotoSlab-Regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/RobotoSlab-Regular-webfont.woff') format('woff'),

         url('css/RobotoSlab-Regular-webfont.ttf') format('truetype'),

         url('css/RobotoSlab-Regular-webfont.svg#roboto_slabregular') format('svg');

    font-weight: normal;

    font-style: normal;



}





@font-face {

    font-family: 'nunitoregular';

    src: url('css/nunito-regular-webfont.eot');

    src: url('css/nunito-regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/nunito-regular-webfont.woff') format('woff'),

         url('css/nunito-regular-webfont.ttf') format('truetype'),

         url('css/nunito-regular-webfont.svg#nunitoregular') format('svg');

    font-weight: normal;

    font-style: normal;



}









@font-face {

    font-family: 'open_sanssemibold_italic';

    src: url('css/opensans-semibolditalic-webfont.eot');

    src: url('css/opensans-semibolditalic-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/opensans-semibolditalic-webfont.woff') format('woff'),

         url('css/opensans-semibolditalic-webfont.ttf') format('truetype'),

         url('css/opensans-semibolditalic-webfont.svg#open_sanssemibold_italic') format('svg');

    font-weight: normal;

    font-style: normal;



}



@font-face {

    font-family: 'open_sansregular';

    src: url('css/opensans-regular-webfont.eot');

    src: url('css/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/opensans-regular-webfont.woff') format('woff'),

         url('css/opensans-regular-webfont.ttf') format('truetype'),

         url('css/opensans-regular-webfont.svg#open_sansregular') format('svg');

    font-weight: 400;

    font-style: normal;

}





@font-face {

    font-family: 'nunitolight';

    src: url('css/nunito-light-webfont.eot');

    src: url('css/nunito-light-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/nunito-light-webfont.woff') format('woff'),

         url('css/nunito-light-webfont.ttf') format('truetype'),

         url('css/nunito-light-webfont.svg#nunitolight') format('svg');

    font-weight: normal;

    font-style: normal;



}	







a:hover {

text-decoration: none;

}

h1, h2, h3, h4, h5, h6 {

font-family: 'Raleway', sans-serif;

color: #000;

margin: 0 0 20px 0;

padding: 0;

line-height: 130%;

text-shadow: none;

}

h1 {

font-size: 36px;

}

h2 {

font-size: 32px;

}

h3 {

font-size: 30px;

}

h4 {
font-family: nunitoregular, sans-serif;
font-size: 24px;
}

h5 {

font-family: 'Lato', sans-serif;

font-size: 20px;

}

h6 {

font-family: 'Lato', sans-serif;

font-size: 15px;

}

p {

line-height: 19px;

margin-bottom: 12px;
font-family: open-sansregular;
font-size: 1.2em;
}

p:first-child {

margin-bottom: 12px;

}

p:last-child {

margin-bottom: 0;

}

strong {

font-weight: bold;

}

em {

font-style: italic;

}

small {

font-size: xx-small;

line-height: 1em;

}

sup {

font-size: xx-small;

vertical-align: top;

line-height: 1em;

} 

sub {

font-size: xx-small;

vertical-align: bottom;

line-height: 1em;

} 

#profile-details-section{display:none !important;}

/* List Styling */

ol {

padding: 0;

margin: 0;

}

ol li {

list-style: decimal;

padding: 0 0 10px 0;

margin: 0 0 0 20px;

line-height: 19px;

}

ul {

padding: 0;

margin: 0;

}

ul li {

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

background-position: -115px -381px;

list-style-type: none;

margin: 0 0 10px 0;

padding: 0 0 0 20px;

line-height: 19px;

}

li:last-child {

margin-bottom: 0;

}



/* Form Styling */

input,

textarea,

input[type="password"] {

font-family: Helvetica, Arial, sans-serif;

font-size: 12px;

line-height: 12px;

padding: 7px;

margin: 0;

color: #000;

border: 1px solid #eee;

background: #fff;

-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

input:focus,

textarea:focus,

input[type="password"]:focus {

border: 1px solid #999;

}

textarea {

line-height: 19px;

resize: none;

width: 100%;

max-width: 100%;

height: 150px;

}

select {

padding: 2px 0;

}

input[type="button"],

input[type="submit"],

input[type="reset"] {

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

font-weight: bold;

padding: 8px 15px;

cursor: pointer;

border-width: 0;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-transition: border-color .2s linear;

-moz-transition: border-color .2s linear;

-ms-transition: border-color .2s linear;

-o-transition: border-color .2s linear;

transition: border-color .2s linear;

}

input[type="button"]:hover,

input[type="submit"]:hover,

input[type="reset"]:hover {

border-width: 0;

border-top-width: 1px;

-webkit-box-shadow: 0 0 5px rgba(0,153,255,0.5);

-moz-box-shadow: 0 0 5px rgba(0,153,255,0.5);

box-shadow: 0 0 5px rgba(0,153,255,0.5);

}

input[type="radio"],

input[type="checkbox"] {

background: transparent;

border: 0;

}

fieldset {

border: 1px solid #eee;

margin: 0;

padding: 20px;

}

legend {

font-size: 14px;

}



/* Table Styling */

table {

border: 1px solid #eee;

padding: 5px 10px;

line-height: 19px;

width: 100%;

}

table th {

font-weight: bold;

border-top: 1px solid #eee;

padding: 10px;

text-align: left;

}

table td {

border-top: 1px solid #eee;

padding: 10px;

}



/* Other Styling */

img {

max-width: 100%;

height: auto;

}

.ie8 img {

max-width: none;

}

.avatar img,

img.avatar {

position: relative;

/*padding: 1px;*/

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 50%;

-moz-border-radius: 50%;

border-radius: 50%;

}

object,

embed,

video,

iframe {

max-width: 100%;

}

cite {

float: right;

padding: 0 0 5px 0;

}

hr {

background: #eee;

border: 0;

clear: both;

width: 100%;

height: 1px;

padding: 0;

margin: 20px 0;

position: relative;

}

pre {

background: url(lib/images/code-bg.png);

border: 1px solid #eee;

padding: 5px 25px;

margin: 5px 0 20px 0;

font-family: "Courier New";

overflow: auto;

font-size: 12px;

line-height: 19px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

code {

background: url(lib/images/code-bg.png);

border: 1px solid #eee !important;

padding: 5px 25px;

margin: 5px 0 20px 0;

font-family: "Courier New";

clear: both;

display: block;

font-size: 12px;

line-height: 19px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

.preload {

display: none;

}

.no-js .preload {

display: block;

}



/* Alignment Styling */

.left {

float: left;

}

.right {

float: right;

}

.clear {

content: "";

clear: both;

line-height: 0;

padding: 0;

margin: 0;

height: 0;

display:block;

font-size:0;

width:100%;

}

.align-center,

.aligncenter {

position: relative;

margin: 20px auto;

display: block;

clear: both;

}

.align-left,

.alignleft {

position: relative;

float: left;

margin: 4px 20px 5px 0;

}

.align-right,

.alignright {

float: right;

position: relative;

margin: 4px 0 5px 20px;

}

.text-left {

text-align: left;

}

.text-right {

text-align: right;

}

.text-center {

text-align: center;

}

.text-justify {

text-align: justify;

}





/************************************ Content Areas ************************************/



/* Page Outer */

.page-outer { 

width: 100%;

}



/* Page Inner */

.page-inner {

margin: 0 auto;

width: 980px;

}



/* Content Wrapper */

#content-wrapper {
text-align: left;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
/*overflow: hidden;Disabled due to author info panel*/
/*overflow: auto; Might be necessary in IE*/
}

.frame #content-wrapper {

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 27px;

-moz-border-radius: 27px;

border-radius: 27px;

}

.padding #content-wrapper {

 padding: 0px; 

}



/* Main Content */

#content {
position: relative;
width: 92%;
margin: 0px  auto;

}

.sb-right #content {
/*float: left;*/

}

.sb-left #content {

/* float: right;  */

}
/*
.fullwidth #content {

float: left;

width: 100%;

}



 Sidebar */

#sidebar {

width: 290px;

}

.sb-right #sidebar {

float: right;

margin-left: 40px;

}

.sb-left #sidebar {

float: left;

margin-right: 40px;

}

.fullwidth #sidebar {

display: none;

}





/************************************ Header ************************************/



/* Header Outer */

#header-outer {

text-align: left;

position: relative;

background-position: right top;

background-repeat: no-repeat;

}

#bp-links {

display: none;

}



/* Header Inner */

#header-inner {

position: relative;

margin: 0 auto;

width: 100%;

}

#header-left {

float: left;
width:auto;

}

@-webkit-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-moz-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-webkit-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-o-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

#header-right {

float: right;

position: relative;

-webkit-animation: showMenu 1s;

-moz-animation: showMenu 1s;

-o-animation: showMenu 1s;

animation: showMenu 1s;

width:70%

}



/* Logo */

#logo {

background: no-repeat;

display: inline-block;

float: left;

position: relative;

margin: 0;

line-height: 0;

}
#logo a{
  	background:url(http://mariasplace.com/wp-content/uploads/logo_maria.png) no-repeat left top;
  	width:363px;
  	height:197px;
	float:left;
  }

.default-logo {

display: inline-block;

width: 230px;

height: 90px;

position: relative;

margin-top: 19px;

}

#logo img {

position: relative;

}

.logo-details {

display: block;

width: 1px;

height: 1px;

text-indent: -9999px;

}



/* Contact Info */

#contact-info {

position: relative;

top: 25px;

right: 0;

z-index: 1;

text-align: right;

color: #fff;

text-shadow: 1px 1px 2px rgba(0,0,0,0.1);

font-weight: bold;

font-size: 14px;

line-height: 14px;

-webkit-animation: showMenu 1s;

-moz-animation: showMenu 1s;

-o-animation: showMenu 1s;

animation: showMenu 1s;

display:none

}

#contact-info a {

color: #fff;

}

#contact-info a:hover {

text-decoration: underline;

}





/************************************ Navigation Menus ************************************/



/* Nav Wrapper */

#nav {

clear: both;

position: relative;

z-index: 20;

height: 36px;

margin: 98px 0 0 0;

/* border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.1);

-moz-box-shadow: 1px 1px 5px rgba(0,0,0,0.1);

box-shadow: 1px 1px 5px rgba(0,0,0,0.1); 

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px; */

text-align:center

}

.mobile-menu {

display: none;

}



/* Top Level Nav */

#nav ul.menu,

#nav ul ul {

float: none;

position: relative;

padding: 0;

margin: 0px 0 0 35px;

list-style-type:none;

list-style-position:outside;

display:inline-block;

}

#nav ul.menu:after {

content:".";

display:block;

height:0;

clear:both;

visibility:hidden;
padding-bottom:10px;

}

#nav ul.menu li {

float: left;

background: none;

position: relative;

margin: 0;

padding: 0;

display: block;

text-align: left;

}

#nav ul.menu li > a {

color: #2b3133;

padding: 12px 25px 16px 25px;


/*margin: -1px 0 10px 0;*/

line-height: 9px;

display: block;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

font-size:18px;

font-family:'nunitolight'

}

#nav ul.menu li:first-child > a {

border-left-width: 0;

-webkit-border-radius: 8px 8px 0 0px;

-moz-border-radius: 8px 8px 0 0px;

border-radius: 8px 8px 0 0px;

}

#nav ul.menu li.home a {

background: url(lib/images/sprite.png) no-repeat 15px -21px;

text-indent: -9999px;

width: 48px;



}

#nav ul.menu li > a:hover,

#nav ul.menu .current-menu-item > a,

#nav ul.menu .current-menu-ancestor > a,

#nav ul.menu li:hover > a {

background-color: #fff;

-webkit-border-radius: 8px 8px 0 0px;

-moz-border-radius: 8px 8px 0 0px;

border-radius: 8px 8px 0 0px;}


#nav  ul.menu  .sub-menu li > a:hover{background-color: #ceecf4; border-radius:0;}
#nav  ul.menu  .sub-menu li:last-child > a:hover{border-radius: 0 0px 8px 8px;}

/* Drop Down Menus */

#nav .sub-menu {

display: none;

position: absolute;

z-index: 20;

top: 36px;

left: auto;

width: 240px;

margin: 0;

/*padding: 20px 20px 10px 20px;

 border-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.3);

box-shadow: 0 0 10px rgba(0,0,0,0.3);

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;  */

}



#nav li:hover > .sub-menu {

display: block;}



#nav .sub-menu{

border-radius:0px 0px 0px;

}

#nav .sub-menu li:hover{border-radius:none !important; }

#nav .sub-menu a {

display: block;

height: auto;

float: left;

width: 240px;

/* border-width: 1px 0 0 0;

border-style: solid; */

}



#nav .sub-menu li:first-child > a{

border-radius:0px 8px 0px 0px !important;

}



#nav .sub-menu li{width:100%;}





#nav .sub-menu li:first-child > a {

border-top: 0;

}

#nav .sub-menu a:hover {



}

#nav li span {

font-size: 10px;

line-height: 10px;

margin-left: 5px;

display:none

}

#nav .left-nav .sub-menu {

left: 0;

}



/* Sub Drop Down Menus */

#nav ul.menu .sub-menu li ul {

top: auto;

left: 200px;

margin-top: -15px;

}

#nav .sub-menu li span {

font-size: 9px;

}

#nav .left-nav .sub-menu li ul {

left: -240px;

}





/************************************ Social Icons ************************************/



#social-icons {

display: block;

float: left;

padding: 14px 5px 11px 15px;

margin: 0;

/* border-left-width: 1px;

border-style: solid; */

}

#social-icons a {

display: inline-block;

margin-right: 10px;

width: 20px;

height: 16px;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

}

#social-icons a:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}

.youtube-icon {

background: url(lib/images/sprite.png) no-repeat 0 0;

}

.facebook-icon {

background: url(lib/images/sprite.png) no-repeat -36px 0;

}

.twitter-icon {

background: url(lib/images/sprite.png) no-repeat -72px 0;

}

.dribbble-icon {

background: url(lib/images/sprite.png) no-repeat -112px 0;

}

.digg-icon {

background: url(lib/images/sprite.png) no-repeat -141px 0;

}

.vimeo-icon {

background: url(lib/images/sprite.png) no-repeat -180px 0;

}

.delicious-icon {

background: url(lib/images/sprite.png) no-repeat -215px 0;

}

.rss-icon {

background: url(lib/images/sprite.png) no-repeat -248px 0;

}

.linkedin-icon {

background: url(lib/images/sprite.png) no-repeat -285px 0;

}

.googleplus-icon {

background: url(lib/images/sprite.png) no-repeat -320px 0;

}

.myspace-icon {

background: url(lib/images/sprite.png) no-repeat -357px 0;

}

.flickr-icon {

background: url(lib/images/sprite.png) no-repeat -393px 0;

}





/************************************ Top Content ************************************/



/* Top Content */

#top-content {

float: left;

position: relative;

text-shadow: 1px 1px 1px rgba(220,220,220,0.9);

width: 100%;

padding: 40px;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 4px 4px 0 0;

-moz-border-radius: 4px 4px 0 0;

border-radius: 4px 4px 0 0;

background-position: right bottom;

background-repeat: no-repeat;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content a {

color: #fff;

}

#top-content a:hover {

color: #ccc;

}

#top-content h1,

#top-content h2,

#top-content h3,

#top-content h4,

#top-content h5,

#top-content h6 {

color: #666;

text-shadow: 1px 1px 1px rgba(200,200,200,1);

}

#top-content.page-title-width .left,

#top-content.page-title-width .right {

width: 50%;

}

#top-content .avatar img,

#top-content img.avatar {

-webkit-box-shadow: 0 0 10px rgba(0,0,0,1);

-moz-box-shadow: 0 0 10px rgba(0,0,0,1);

box-shadow: 0 0 10px rgba(0,0,0,1);

}

#top-content .sc-divider {

background: url(lib/images/divider.png) repeat-x left bottom;

margin: 30px 0;

border: 0;

height: 2px;

}

#top-content .widget {

font-size: 11px;

border: 0;

background: url(lib/images/divider.png) repeat-x left top;

padding: 20px 0;

margin: 0;

}

#top-content .widget li {

line-height: 16px;

}

#top-content .widget:first-child {

background: none;

padding-top: 0;

}

#top-content .widget:last-child {

padding-bottom: 0;

}



/* Page Title */

.page-title {

color: #fff;

margin: 0;

}



/* Post Meta */

.post-meta {

margin-top: 5px;

font-size: 11px;

}

.post-meta a:hover {

color: #fff;

}

.post-meta span {

display: inline;

line-height: 20px;

padding: 5px 0 5px 25px;

margin: 0 20px 0 0;

}

.author-icon {

background: url(lib/images/sprite.png) no-repeat -79px -67px;

}

.clock-icon {

background: url(lib/images/sprite.png) no-repeat -60px -90px;

}

.folder-icon {

background: url(lib/images/sprite.png) no-repeat -40px -116px;

}

.speech-icon {

background: url(lib/images/sprite.png) no-repeat -19px -138px;

}

.tag-icon {

background: url(lib/images/sprite.png) no-repeat 0 -157px;

}



/* Breadcrumbs */

#breadcrumbs {

float: right;

color: #666;

font-weight: bold;

font-size: 11px;

line-height: 15px;

margin-top: 10px;

}

#breadcrumbs a {

font-weight: normal;

}

#breadcrumbs a:hover {

color: #4DB3A2;

}



/* Search Form */

#top-content #searchform {

position: relative;

float: right;

margin: 0 0 0 20px;

padding: 7px 15px;

border-bottom-width: 1px;

border-style: solid;

-webkit-box-shadow: inset 1px 1px 5px rgba(0,0,0,0.1);

-moz-box-shadow: inset 1px 1px 5px rgba(0,0,0,0.1);

box-shadow: inset 1px 1px 1px rgba(0,0,0,0.1);

-webkit-border-radius: 8px;

-moz-border-radius: 8px;

border-radius: 8px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

#top-content #searchbar {

float: left;

width: 100%;

background: none;

border: 0;

margin: 2px 0 0;

padding: 0 25px 0 0;

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content #searchsubmit {

position: absolute;

top: 7px;

right: 15px;

width: 15px;

height: 17px;

background-color: transparent !important;

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

text-indent: -9999px;

border: 0;

padding: 0;

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

}

#top-content #searchsubmit:hover {

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

}





/************************************ Page/Post Styling ************************************/



/* Posts */

.post-loop {

float: left;

width: 100%;

position: relative;

margin-top: 40px;

}

.spacing-small .post-loop {

margin-top: 20px;

}

.ie8 .spacing-small .post-loop {

margin-top: 5px;

}

.post-loop:first-child {

margin-top: 0;

}

.post-loop.post-columns {

margin: 20px 0 20px 4%;

}

.spacing-small .post-loop.post-columns {

margin: 10px 0 10px 4%;

}

.post-loop.first-column {

margin: 20px 0 20px 0;

}

.spacing-small .post-loop.first-column {

margin: 10px 0 10px 0;

}

.post-text h2 {

font-size: 26px;

margin-bottom: 10px;

}

.spacing-small .post-text h2 {

font-size: 12px;

margin-bottom: 5px;

}

.sticky {

}



/* Post Thumbnail */

.post-thumbnail {

float: left;

max-width: 100%;

line-height: 0;

position: relative;

overflow: hidden;

margin-bottom: 20px;

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.spacing-small .post-thumbnail {

margin-bottom: 10px;

}

.post-thumbnail.wrap {

margin: 0 20px 0 0;

}

.spacing-small .post-thumbnail.wrap {

margin: 0 10px 0 0;

}



/* Post Meta */

#content .post-meta {

width: 100%;

margin: 0 0 15px 0;

}

#content .post-meta.post-tags {

margin: 0 0 20px 0;

}

#content .post-wrapper .post-meta.post-tags {

margin: 0;

}

#content .post-meta,

#content .post-meta a {

color: #666;

}

#content .post-meta a:hover {

color: #999;

}



/* Post Content */

#post-content {

margin-bottom: 20px;



}

label[for*="pwbox"] {

float: left;

display: inline;

margin: 0 10px 0 0;

}



/* Attachments */

.attachment p {

margin-top: 12px;

}





/************************************ Lightbox ************************************/



.hover-image, 

.hover-video {

display: block;

position: absolute;

z-index: 10;

width: 100%;

height: 100%;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

cursor: pointer;

}

.hover-image {

background: url(lib/images/lightbox-image.png) no-repeat center center;

}

.hover-video {

background: url(lib/images/lightbox-video.png) no-repeat center center;

}

img:hover .hover-image, 

img:hover .hover-video {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=80);

opacity: 0.8;

}

.pp_gallery li {

background: none;

border: 0;

padding: 0;

}

.pp_gallery li.jwplayer a {

background: url(lib/scripts/prettyPhoto/images/prettyPhoto/default/default_thumb.png) no-repeat;

width: 50px;

height: 33px;

display: block;

}

.html5player {

width: 100%;

height: 100%;

}





/************************************ Shortcodes: Accordion ************************************/



.accordion .panel {

position: relative;

width: 100%;

margin-bottom: 10px;

overflow: hidden;

}

h3.accordion-title {

font-family: 'Lato', sans-serif;

font-size: 18px;

background-image: url(lib/images/sprite.png);

background-position: -100px -249px;

background-repeat: no-repeat;

padding: 0 0 10px 21px;

margin: 0;

}

h3.ui-state-active.accordion-title {

background-position: -80px -282px;

}

.panel-content {

padding: 0 0 20px 20px;

line-height: 19px;

}





/********************************************* Shortcodes: Activity Stream *********************************************/



#top-content .gp-activity-stream #activity-stream {

border: 0;

}

.gp-activity-stream .acomment-reply {

display: none !important;

}

.gp-activity-stream .load-more {

display: none;

}

.hide-activity-comments .activity-inreplyto,

.hide-activity-comments .activity-comments {

display: none;

}

.gp-activity-stream .wp-pagenavi {

width: 100%;

}

#top-content .gp-activity-stream .wp-pagenavi {

font-size: 11px;

}

.gp-activity-stream .pages {

float: left;

}

.gp-activity-stream .pagination-links {

float: right;

}





/************************************ Shortcodes: Author Info ************************************/



.author-info {

float: left;

position: relative;

width: 100%;

padding: 20px;

margin: 0 0 20px 0;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.sb-left .author-info {

float: right;

margin: 20px -48px 20px 0;

}

.frame .author-info {

margin: 20px 0 20px -48px;

-webkit-border-radius: 0 4px 4px 4px;

-moz-border-radius: 0 4px 4px 4px;

border-radius: 0 4px 4px 4px;

}

.author-info-fold {

display: none;

position: absolute;

top: -8px;

left: 0;

background: url(lib/images/author-info-fold.png) no-repeat;

width: 8px;

height: 8px;

}

.sb-left .author-info-fold {

left: auto;

right: 0;

-moz-transform: scaleX(-1);

-o-transform: scaleX(-1);

-webkit-transform: scaleX(-1);

transform: scaleX(-1);

filter: FlipH;

-ms-filter: "FlipH";

}

.frame .author-info-fold {

display: block;

}

.author-info .avatar {

float: left;

margin-right: 20px;

width: 50px;

height: 50px;

}

.author-info .author-meta {

margin-left: 80px;

}

.author-info .author-meta-top {

width: 100%;

float: left;

}

.author-info .author-name {

float: left;

color: #fff;

margin-bottom: 10px;

font-weight: bold;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

}

.author-info .author-links {

float: right;

font-size: 11px;

margin-bottom: 10px;

}

.author-info .author-links a {

color: #fff;

margin: 0 2px;

}

.author-info .author-desc {

line-height: 19px;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

}





/************************************ Shortcodes: Blockquotes ************************************/



blockquote {

font-size: 14px;

margin: 5px 20px 10px 20px;

padding: 10px 0 5px 25px;

overflow: hidden;

}

blockquote p {

line-height: 23px;

}

.blockquote-left {

float: left;

margin: 10px 20px 20px 0;

}

.blockquote-right {

float: right;

margin: 10px 0 20px 20px;

}

.blockquote-left,

.blockquote-right {

width: 30%;

font-size: 14px;

line-height: 23px;

padding: 10px 0 5px 25px;

}





/************************************ Shortcodes: Buttons ************************************/



/* Buttons */

.sc-button,

.sc-button:hover {

position: relative;

max-width: 100%;

border-top-width: 1px;

border-style: solid;

display: inline-block;

margin: 5px;

font-weight: bold;

-moz-border-radius: 40px;

-webkit-border-radius: 40px;

border-radius: 40px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow:  0 0 5px rgba(0,0,0,0.3);

}

.sc-button.small {

font-size: 11px;

line-height: 11px;

padding: 8px 12px;

}

.sc-button.medium {

font-size: 12px;

line-height: 12px;

padding: 12px 20px;

}

.sc-button.large {

font-size: 14px;

line-height: 14px;

padding: 15px 60px;

}

.columns.button-divider {

background: url(lib/images/divider.png) left center repeat-x;

}



/* Yellow Button */

.yellow.sc-button {

color: #5e471d !important;

text-shadow: 1px 1px 1px rgba(255,255,255,0.8);

border-color: #fff5d8;

background-color: #fcd971;

background-image: -moz-linear-gradient(#fcd971, #fbbd4e);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fcd971), to(#fbbd4e));

background-image: -webkit-linear-gradient(#fcd971, #fbbd4e);

background-image: -o-linear-gradient(#fcd971, #fbbd4e);

background-image: -ms-linear-gradient(#fcd971, #fbbd4e);

-pie-background: linear-gradient(#fcd971, #fbbd4e);

}

.yellow.sc-button:hover {

color: #5e471d !important;

background: #fbbd4e;

}



/* Grey */

.grey.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #838383;

background-color: #5c5c5c;

background-image: -moz-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#5c5c5c), to(#3d3d3d));

background-image: -webkit-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -o-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -ms-linear-gradient(#5c5c5c, #3d3d3d);

-pie-background: linear-gradient(#5c5c5c, #3d3d3d);

}

.grey.sc-button:hover {

color: #fff !important;

background: #3d3d3d;

}



/* Dark Grey Button */

.darkgrey.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #666;

background-color: #404040;

background-image: -moz-linear-gradient(#404040, #202020);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#404040), to(#202020));

background-image: -webkit-linear-gradient(#404040, #202020);

background-image: -o-linear-gradient(#404040, #202020);

background-image: -ms-linear-gradient(#404040, #202020);

-pie-background: linear-gradient(#404040, #202020);

}

.darkgrey.sc-button:hover {

color: #fff;

background: #202020;

}



/* Brown Button */

.brown.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #837268;

background-color: #685950;

background-image: -moz-linear-gradient(#685950, #453B35);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#685950), to(#453B35));

background-image: -webkit-linear-gradient(#685950, #453B35);

background-image: -o-linear-gradient(#685950, #453B35);

background-image: -ms-linear-gradient(#685950, #453B35);

-pie-background: linear-gradient(#685950, #453B35);

}

.brown.sc-button:hover {

color: #fff;

background: #453B35;

}



/* Blue Button */

.blue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #71c6ed;

background-color: #96d1f8;

background-image: -moz-linear-gradient(#09b0fe, #258df8);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#09b0fe), to(#258df8));

background-image: -webkit-linear-gradient(#09b0fe, #258df8);

background-image: -o-linear-gradient(#09b0fe, #258df8);

background-image: -ms-linear-gradient(#09b0fe, #258df8);

-pie-background: linear-gradient(#09b0fe, #258df8);

}

.blue.sc-button:hover {

color: #fff;

background: #258df8;

}



/* Medium Blue Button */

.mediumblue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #748894;

background-color: #505f68;

background-image: -moz-linear-gradient(#505f68, #353f45);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#505f68), to(#353f45));

background-image: -webkit-linear-gradient(#505f68, #353f45);

background-image: -o-linear-gradient(#505f68, #353f45);

background-image: -ms-linear-gradient(#505f68, #353f45);

-pie-background: linear-gradient(#505f68, #353f45);

}

.mediumblue.sc-button:hover {

color: #fff !important;

background: #353f45;

}



/* Dark Blue Button */

.darkblue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #4d5b64;

background-color: #364046;

background-image: -moz-linear-gradient(#364046, #15191b);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#364046), to(#15191b));

background-image: -webkit-linear-gradient(#364046, #15191b);

background-image: -o-linear-gradient(#364046, #15191b);

background-image: -ms-linear-gradient(#364046, #15191b);

-pie-background: linear-gradient(#364046, #15191b);

}

.darkblue.sc-button:hover {

color: #fff !important;

background: #15191b;

}



/* Lime Green Button */

.limegreen.sc-button {

color: #4C5629 !important;

text-shadow: 1px 1px 1px rgba(255,255,255,0.8);

border-color: #eaf5bc;

background-color: #d2e68d;

background-image: -moz-linear-gradient(#d2e68d, #94bd44);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#d2e68d), to(#94bd44));

background-image: -webkit-linear-gradient(#d2e68d, #94bd44);

background-image: -o-linear-gradient(#d2e68d, #94bd44);

background-image: -ms-linear-gradient(#d2e68d, #94bd44);

-pie-background: linear-gradient(#d2e68d, #94bd44);

}

.limegreen.sc-button:hover {

color: #4C5629 !important;

background: #94bd44;

}



/* Teal Button */

.teal.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #BACAC8;

background-color: #8CA6A3;

background-image: -moz-linear-gradient(#8CA6A3, #6A8A87);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#8CA6A3), to(#6A8A87));

background-image: -webkit-linear-gradient(#8CA6A3, #6A8A87);

background-image: -o-linear-gradient(#8CA6A3, #6A8A87);

background-image: -ms-linear-gradient(#8CA6A3, #6A8A87);

-pie-background: linear-gradient(#8CA6A3, #6A8A87);

}

.teal.sc-button:hover {

color: #fff !important;

background: #6A8A87;

}



/* Dark Green Button */

.darkgreen.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #5a7b85;

background-color: #366a7b;

background-image: -moz-linear-gradient(#366a7b, #23444b);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#366a7b), to(#23444b));

background-image: -webkit-linear-gradient(#366a7b, #23444b);

background-image: -o-linear-gradient(#366a7b, #23444b);

background-image: -ms-linear-gradient(#366a7b, #23444b);

-pie-background: linear-gradient(#366a7b, #23444b);

}

.darkgreen.sc-button:hover {

color: #fff !important;

background: #23444b;

}



/* Red Button */

.red.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #c2464c;

background-color: #93063b;

background-image: -moz-linear-gradient(#b03238, #940a11);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#b03238), to(#940a11));

background-image: -webkit-linear-gradient(#b03238, #940a11);

background-image: -o-linear-gradient(#b03238, #940a11);

background-image: -ms-linear-gradient(#b03238, #940a11);

-pie-background: linear-gradient(#b03238, #940a11);

}

.red.sc-button:hover {

color: #fff !important;

background: #940a11;

}



/* Dark Red Button */

.darkred.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #957578;

background-color: #685053;

background-image: -moz-linear-gradient(#685053, #453537);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#685053), to(#453537));

background-image: -webkit-linear-gradient(#685053, #453537);

background-image: -o-linear-gradient(#685053, #453537);

background-image: -ms-linear-gradient(#685053, #453537);

-pie-background: linear-gradient(#685053, #453537);

}

.darkred.sc-button:hover {

color: #fff !important;

background: #453537;

}



/* Orange Button */

.orange.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #f0a33e;

background-color: #ee8600;



background-image: -moz-linear-gradient(#ee8600, #b25f0f);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#ee8600), to(#b25f0f));

background-image: -webkit-linear-gradient(#ee8600, #b25f0f);

background-image: -o-linear-gradient(#ee8600, #b25f0f);

background-image: -ms-linear-gradient(#ee8600, #b25f0f);

-pie-background: linear-gradient(#ee8600, #b25f0f);

}

.orange.sc-button:hover {

color: #fff !important;

background: #b25f0f;

}





/************************************ Shortcodes: Captions ************************************/



.wp-caption {

position: relative;

padding: 0;

max-width: 100%;

}

.wp-caption img {

margin: 0;

}

.wp-caption-text {

margin: 5px 0 0;

font-size: 11px;

color: #666;

}





/************************************ Shortcodes: Columns ************************************/



/* General */

.columns {

float: left;

position: relative;

line-height: 19px;

margin-right: 4%;

}

.one {

width: 100%;

}

.two {

width: 48%;

}

.three {

width: 30.66%;

}

.four {

width: 22%;

}

.five {

width: 16.8%;

}

.onethird {

width: 32.64%;

}

.twothirds {

width: 63.36%;

}

.onefourth {

width: 24%;

}

.threefourths {

width: 72%;

}



/* Separate Columns */

.separate > div {

border: 1px solid #eee;

background: #fff;

position: relative;

padding: 20px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

}



/* Joint Columns */

.columns.joint {

margin: 0;

}

.joint > div {

border-width: 0 0 0 1px;

border-color: #eee;

border-style: solid;

position: relative;

padding: 20px;

}

.first.joint > div {

border-left-width: 0;

}

.one.joint {

width: 100%;

}

.two.joint {

width: 50%;

}

.three.joint {

width: 287px;

}

.middle.three.joint {

width: 326px;

}

.columns .three.joint,

.padding .three.joint {

width: 33% !important;

padding: 0;

}

.four.joint {

width: 25%;

}

.five.joint {

width: 20%;

}

.onethird.joint {

width: 33.33%;

}

.twothirds.joint {

width: 66.33%;

}

.onefourth.joint {

width: 25%;

}

.threefourths.joint {

width: 75%;

}



.last {

clear: right;

margin-right: 0;

}





/************************************ Shortcodes: Contact Form ************************************/

#content .padder{margin-bottom:20px;}

#contact-form {

float: left;

width: 100%;

margin-bottom: 12px;

}

#contact-form label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#contact-form .contact-verify {

float: left;

margin-right: 10px;

}

#contact-form .contact-verify label {

float: left;

margin: 10px 10px 0 0;

}

#contact-form .contact-submit {

float: left;

}

.required {

color: #3596ae;

}

#contact-form .loader {

display: none;

background: url(lib/images/loader.gif) no-repeat right bottom;

float: left;

padding: 4px 0 0 10px;

width: 16px;

height: 16px;

}

.contact-form.notify {

padding: 5px 10px;

margin-bottom: 10px;



}

#contact-form .input-error {

border: 1px solid #FBC2C4;

}





/************************************ Shortcodes: Dividers ************************************/



.sc-divider {

content: "";

border-top: 1px solid #ddd;

clear: both;

width: 100%;

height: 1px;

padding: 0;

margin: 40px 0;

position: relative;

}

.frame .sc-divider {

border-color: #eee;

}

.sc-divider.top a {

font-size: 10px;

float: right;

position: absolute;

top: -20px;

right: 0;

color: #999;

text-align: right;

cursor: pointer;

}

.sc-divider.small {

margin: 0;

}

.sc-divider.clear {

background: none !important;

border: 0;

margin: 20px 0 !important;

}

.sc-divider.small.clear {

border: 0;

margin: 0 !important;

}





/************************************ Shortcodes: Drop Caps ************************************/



.dropcap1 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 0 10px -8px 0;

padding: 0;

text-align: center;

}

.dropcap2 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

background: #eee;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.dropcap3 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

color: #999;

background: #404040;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.dropcap4 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

background: #eee;

-webkit-border-radius: 25px;

-moz-border-radius: 25px;

border-radius: 25px;

}

.dropcap5 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

color: #999;

background: #404040;

-webkit-border-radius: 25px;

-moz-border-radius: 25px;

border-radius: 25px;

}





/************************************ Shortcodes: Galleries ************************************/



.gallery-columns-1 .gallery-item {

width: 90%;

}

.gallery-columns-2 .gallery-item {

width: 45% !important;

padding-right: 4% !important;

}

.gallery-columns-3 .gallery-item {

width: 31% !important;

padding-right: 2% !important;

}

.gallery-columns-4 .gallery-item {

width: 23% !important;

padding-right: 2% !important;

}

.gallery-columns-5 .gallery-item {

width: 18% !important;

padding-right: 2% !important;

}

.gallery-columns-6 .gallery-item {

width: 14% !important;

padding-right: 2% !important;

}

.gallery-columns-7 .gallery-item {

width: 12% !important;

padding-right: 2% !important;

}

.gallery-columns-8 .gallery-item {

width: 10% !important;

padding-right: 2% !important;

}

.gallery-columns-9 .gallery-item {

width: 9% !important;

padding-right: 2% !important;

}

.gallery-item img {

max-width: 100% !important;

height: auto !important;

border: 0 !important;

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.gallery-caption {

float: left;

margin: 10px 0;

line-height: 14px;

}

div.gallery-item .gallery-icon {

display: inline-block;

position: relative;

width: 100%;

}

.gallery-item a, .gallery-caption {

width:100%;

}





/************************************ Shortcodes: Images ************************************/



/* Image */

.sc-image {

line-height: 0;

max-width: 100%;

height: auto !important;

}

.sc-image img {

max-width: 100%;

height: auto !important;

width: auto\9;

}

.sc-image a {

display: block;

margin: 0 auto;

}

.sc-image.aligncenter {

margin: 0 auto;

text-align: center;

}



.sc-image.alignleft {

margin: 0;

}

.sc-image.alignright {

margin: 0;

}

.sc-image.image-border {

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}





/************************************ Shortcodes: Lists ************************************/



.circle li {

background-position: -92px -402px;

}

.square li {

background-position: -72px -423px;

}

.tick li {

background-position: -50px -443px;

}

.large-tick li {

font-family: 'Lato', sans-serif;

font-weight: 300;

font-size: 18px;

margin-top: 20px;

padding-left: 25px;

background-position: -21px -463px;

}

.large-cross li {

font-family: 'Lato', sans-serif;

font-weight: 300;

font-size: 18px;

margin-top: 20px;

padding-left: 25px;

background-position: 0 -486px;

}





/************************************ Shortcodes: Login/Register Forms ************************************/



#loginform,

#registerform {

float: left;

margin: 0;

}

#loginform label,

#registerform label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#loginform .login-remember label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

padding: 0;

}





/************************************ Shortcodes: Notifications ************************************/



.notify {

position: relative;

margin: 10px 0;

-moz-border-radius: 4px;

-webkit-border-radius: 4px;

border-radius: 4px;

display: block;

line-height: 19px;

padding: 20px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

}

.notify-default {

color: #57481c;

background-color: #FFDF75;

}

.notify-help {

color: #184366;

background-color: #5FA6E5;

}

.notify-success {

color: #566621;

background-color: #B3D46F;

}

.notify-warning {

color: #6b3b17;

background-color: #E78F4B;

}

.notify-error {

color: #571111;

background-color: #D84F4F;

}





/************************************ Shortcodes: Price Box ************************************/



.sc-price-box {

text-align: center;

max-width: 100% !important;

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.5);

box-shadow: 0 0 10px rgba(0,0,0,0.5);

-webkit-border-radius: 8px;

-moz-border-radius: 8px;

border-radius: 8px;

}

.sc-price-box-inner {

padding: 20px 40px;

}

.sc-price-box-title {

font-family: 'Raleway', sans-serif;

font-size: 30px;

line-height: 30px;

color: #fff;

margin-bottom: 20px;

}

.sc-price-box .left {

text-align: center;

width: 100%;

}

.sc-price-box-price {

font-family: 'Raleway', sans-serif;

font-size: 90px;

line-height: 90px;

color: #fff;

}

.sc-price-box-unit {

font-family: 'Raleway', sans-serif;

font-size: 18px;

color: #fff;

}

.sc-price-divider {

float: left;

clear: both;

border-width: 1px 0;

border-style: solid;

height: 0;

width: 100%;

margin: 20px 0;

}

.sc-price-box-content {

float: left;

font-size: 12px;

line-height: 23px;

margin-bottom: 20px;

}

.sc-price-box-button {

float: left;

width: 100%;

text-align: center;

}





/************************************ Shortcodes: Pricing Table ************************************/



.sc-pricing-table table {

width: 100%;

}

.sc-pricing-table thead th {

font-family: 'Raleway', sans-serif;

text-align: center;

font-size: 28px;

color: #fff;

padding: 2%;

border-left-width: 1px;

border-style: solid;

}

.ie8 .sc-pricing-table thead th {

padding: 10px;

-pie-background: none;

}

.sc-pricing-table thead th:first-child {

border: 0;

background: none;

-pie-background: none;

}

.sc-pricing-table thead th.first {

border: 0;

-webkit-border-radius: 4px 0 0;

-moz-border-radius: 4px 0 0;

border-radius: 4px 0 0;

}

.sc-pricing-table thead th.last {

-webkit-border-radius: 0 4px 0 0;

-moz-border-radius: 0 4px 0;

border-radius: 0 4px 0 0;

}

.sc-pricing-table tfoot th {

border-top: 1px solid #eee;

text-align: center;

padding: 2% 0 0 0;

}

.sc-pricing-table .price {

font-size: 15px;

}

.sc-pricing-table tr {

background: #fff;

}

.sc-pricing-table tr:nth-child(even) {

background: #f8f8f8;

}

.sc-pricing-table thead tr,

.sc-pricing-table tfoot tr {

background: none;

}

.sc-pricing-table tr td {

text-align: center;

padding: 2% 1%;

border-width: 1px 1px 0 0;

border-style: solid;

border-color: #eee;

}

.sc-pricing-table tr td:first-child {

text-align: left;

border-left-width: 1px;

font-weight: bold;

}

.sc-pricing-table tr td .yes {

display: block;

margin: 0 auto;

width: 20px;

height: 13px;

background: url(lib/images/sprite.png) no-repeat -21px -467px;

}

.sc-pricing-table tr td .no {

display: block;

margin: 0 auto;

width: 15px;

height: 13px;

background: url(lib/images/sprite.png) no-repeat 0 -490px;

}







/************************************ Shortcodes: Related Posts ************************************/



/* Related Posts Container */

.related-posts {

float: left;

width: 100%;

margin-top: 20px;

}

.related-posts h3 {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 10px 0;

margin: 0;

}

.frame .related-posts h3 {

border-color: #eee;

}

.related-posts h2 {

font-size: 12px;

font-weight: bold;



font-family: Helvetica, Arial, sans-serif;

}





/************************************ Shortcodes: Slider ************************************/



/* Slider */

.flexslider {

position: relative;

width: 100%;

max-width: 100%;

margin: 0;

padding: 0;

zoom: 1;

}

.flexslider.aligncenter {

margin: 0 auto;

}



/* Slides */

.flexslider .slides {

zoom: 1;

}

.flexslider .slides > li {

position: relative;

list-style-type: none;

background: none;

display: none;

-webkit-backface-visibility: hidden;

margin: 0;

padding: 0;

}

.slides:after {

content: ".";

display: block;

clear: both;

visibility: hidden;

line-height: 0;

height: 0;

}

html[xmlns] .slides {

display: block;

}

* html .slides {

height: 1%;

}

.no-js .slides > li:first-child {

display: block;

}

.flexslider .slides img {

max-width: 100%;

display: block;

}

.flexslider.shadow .slides img,

.flexslider.shadow .slides .slide-video {

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.5);

box-shadow: 0 0 10px rgba(0,0,0,0.5);

}



/* Slide Video */

.video-image {

position: absolute;

top: 0;

left: 0;

z-index: 9;

display: block;

width: 100%;

height: 100%;

}

.video-autostart .video-image {

display: none !important;

}

.video-button {

position: absolute;

z-index: 9;

top: 0;

left: 0;

display: block;

background: url(lib/scripts/mediaplayer/fs39/display/playIcon.png) no-repeat center center;

cursor: pointer;

width: 100%;

height: 100%;

}

.video-player {

display: none;

}



/* Slide Caption */

.caption {

padding: 20px 20px 10px 20px;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

line-height: 19px;

position: absolute;

z-index: 10;

max-width: 60%;

max-height: 50%;

overflow: hidden;

}

.caption h2 {

font-family: 'Lato', sans-serif;

color: #fff;

font-size: 20px;

margin-bottom: 10px;

}

.caption p:first-child {

margin-bottom: 10px;

}

.caption.caption-topleft {

top: 20px;

left: 0;

}

.caption.caption-topright {

top: 20px;

right: 0;

}

.caption.caption-bottomleft {

bottom: 20px;

left: 0;

}

.caption.caption-bottomright {

bottom: 20px;

right: 0;

}



/* Slider Prev/Next */

.flex-direction-nav {

list-style: none;

background: none;

overflow: hidden;

margin: 5px 0 0 0;

padding: 0;

}

.flex-direction-nav li {

background: none;

display: inline-block;

list-style: none;

background: none;

margin: 0;

padding: 0;

}

.flex-direction-nav li a {

float: left;

position: relative;

text-indent: -9999px;

z-index: 11;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

width: 12px;

height: 12px;

cursor: pointer;

margin-right: 5px;

}

.flex-direction-nav li .flex-prev {

background: url(lib/images/sprite.png) no-repeat 0 -316px;

}

.flex-direction-nav li .flex-next {

background: url(lib/images/sprite.png) no-repeat -30px -316px;

}

.flex-direction-nav li .flex-prev:hover,

.flex-direction-nav li .flex-next:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}



/* Slider Buttons */

.flex-control-nav {

position: relative;

list-style: none;

background: none;

margin: 5px 0 0 0;

float: right;

}

.flex-control-nav li {

display: inline-block;

list-style: none;

background: none;

margin: 0;

padding: 0;

}

.flex-control-nav li a {

text-indent: -9999px;

float: left;

background: url(lib/images/sprite.png) no-repeat -60px -316px;

margin: 0 3px;

width: 12px;

height: 12px;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

cursor: pointer;

}

.flexslider:hover .flex-control-nav li a {

display: block;

}

.flex-control-nav li .flex-active,

.flex-control-nav li a:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}





/************************************ Shortcodes: Tabs ************************************/



.ui-tabs {

position: relative;

padding: 0;

top: -4px;

zoom: 1;

}

.ui-tabs .ui-tabs-nav {

display: block;

margin: 0;

padding: 0;

}

.ui-tabs .ui-tabs-nav li { 

z-index: 1;

background-image: none;

list-style: none;

background: none;

float: left;

position: relative;

top: 1px;

margin: 0;

border-bottom-width: 0;

padding: 0;

white-space: nowrap;

border: 0;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content .ui-tabs .ui-tabs-nav li {

top: 0;

}

.ui-tabs .ui-tabs-nav li a {

float: left;

font-weight: bold;

padding: 10px;

text-decoration: none;

}

.ui-tabs .ui-tabs-nav li.ui-state-active { 

z-index: 3;

border: 1px solid #eee;

background: #fff;

border-bottom-color: #fff;

}

#top-content .ui-tabs .ui-tabs-nav li.ui-state-active {

background: rgba(0,0,0,0.2);

border: 0;

}

.ui-tabs .ui-tabs-nav li.ui-state-active a,

.ui-tabs .ui-tabs-nav li.ui-state-disabled a,

.ui-tabs .ui-tabs-nav li.ui-state-processing a {

cursor: text;

color: #000;

}

.ui-tabs .ui-tabs-nav li.ui-state-hover a {

color: #000;

}

.ui-tabs .ui-tabs-nav li a,

.ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-state-active a {

color: #999;

cursor: pointer;

} 

.ui-tabs-nav .tabhead {

cursor:pointer;

font-size: 12px;

margin-bottom: 0;

display: block;

}

.sc-tab-panel {

z-index: 2;

width: 100%;

background: #fff;

position: relative;

height: inherit;

line-height: 19px;

overflow: hidden;

margin: 0 0 10px 0;

padding: 15px;

border: 1px solid #eee;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content .sc-tab-panel {

background: rgba(0,0,0,0.2);

border: 0;

}

.ui-tabs .ui-tabs-hide {

display: none !important;

position: absolute;

left: -10000px;

}





/************************************ Shortcodes: Text Boxes ************************************/



.text-box {

width: 100%;

max-width: 100%;

display: inline-block;

font-size: 14px;

line-height: 19px;

}

#content .text-box {

color: #000;

}

.text-box p {

line-height: inherit;

}

.text-box .testimonial-name {

font-weight: bold;

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}

.text-box .testimonial-company {

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}

.text-box .testimonial-comma {

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}





/************************************ Shortcodes: Toggle Box ************************************/



h3.toggle {

font-family: 'Lato', sans-serif;

font-size: 18px;

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

background-position: -140px -192px;

padding: 0 0 10px 21px;

margin: 0;

cursor: pointer;

}

h3.toggle a {

display: block;

}

h3.toggle-active {

background-position: -120px -221px;

}

.toggle-box {

clear:both;

margin: 0 0 10px 0;

overflow: hidden;

}

.no-js .toggle-box {

display: block !important;

}





/************************************ Shortcodes: Video ************************************/



.sc-video,

.sc-video div {

max-width: 100%;

}

.sc-video.aligncenter {

text-align: center;

}





/************************************ Footer ************************************/



/* Footer Container */

#footer {

display: inline-block;

text-align: left;

margin: 65px auto 0 auto;

width: 100%;

text-shadow: 1px 1px 1px rgba(255,255,255,1);

}



/* Footer Widgets */

#footer-widgets {

float: left;

width: 100%;

position: relative;

}

.footer-widget-outer .widgettitle {

font-family: Helvetica, "Lucida Sans Unicode", "Lucida Grande", Arial;

font-size: 12px;

font-weight: bold;

margin-bottom: 15px;

}

.footer-widget-outer {

float: left;

margin-left: 4%;

color: #989898;

}

.footer-widget-inner {

float: left;

width: 100%;

margin-bottom: 30px;

}

#footer-widgets div:first-child {

margin-left: 0;

}

.footer-whole {

width: 100%;

}

.footer-half {

width: 22%;

}

.footer-third {

width: 30.66%;

}

.footer-fourth {

width: 22%;

}



/* Footer Forms */

.footer-fourth #searchbar {

width: 100px;

}

.footer-widget-inner textarea {

height: 75px;

}

.footer-fourth #contact-form .textfield {

width: 125px;

}



/* Copyright */

#copyright {
/*
padding: 30px 0 20px 0;
height:100px;*/
background: url("images/m_image2.png") no-repeat scroll center top rgba(0, 0, 0, 0);
color: #000000;
float: left;
font-size: 12px;
margin: 35px 0 60px;
padding: 40px 0;
text-align: center;
width: 100%;
}


#copyright2 #copyright{background: url("images/m_image.png") no-repeat scroll center top;  padding: 55px 0;}



#copyright a{color:#304F62}





/************************************ Widgets ************************************/



/* General Widget Styling */

.widget {

float: left;

width: 100%;

padding-top: 40px;

margin-top: 40px;

border-top: 1px solid #ddd;

}

.frame .widget {

border-color: #eee;

}

.widget:first-child {

border: 0;

padding: 0;

margin: 0;

}

.widget .widgettitle,

.widget .widgettitle a,

.widget .widgettitle a:hover {

color: #000;

font-family: 'Lato', sans-serif;

font-size: 20px;

line-height: 20px;

margin-bottom: 15px;

}

.textwidget {

line-height: 19px;

}



/* Calendar Widget */

#wp-calendar {

margin: 0 auto;

}

#wp-calendar th {

font-weight: bold;

padding: 5px;

text-align: center;

}

#wp-calendar td {

padding: 5px;

text-align: center;

}

#wp-calendar caption {

text-align: right;

font-weight: bold;

margin-bottom: 10px;

}



/* Search Widget */

#searchsubmit {

margin: 0 0 0 10px;

}



/* Custom Menus Widget */

.widget_nav_menu li {

background: none;

margin: 0;

padding: 0;

border-bottom: none;
position:relative;

}
.widget_nav_menu ul li ul {
    left: 45%;
    position: absolute;
    top: 0px;
	z-index:100;
}

.widget_nav_menu li:last-child,

.widget_nav_menu li:hover {

border-bottom:none;

}

.widget_nav_menu a {

display: block;

padding: 0;

line-height:20px

}



/*

.widget_nav_menu a:hover,

.widget_nav_menu .current-menu-item > a {

font-weight: bold;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;


-moz-border-radius: 4px;

border-radius: 4px;

}

.widget_nav_menu .sub-menu li {

margin-left: 20px;

}



*/





/************************************ Comments Section ************************************/



/* Comment List */

#comments {

float: left;

width: 100%;

margin-top: 20px;

}

.padding #comments {

padding: 0;

}

h3.comments {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 10px 0;

margin: 0;

}

.frame h3.comments {

border-color: #eee;

}

#commentlist,

#commentlist li {

list-style: none;

background: none;

margin: 0;

padding: 0;

}



/* Comment Box */

#commentlist .comment-box {

padding: 20px 0;

}

.comment-avatar {

float: left;

width: auto;

}

.comment-author {

font-weight: bold;

padding-bottom: 5px;

}

.comment-date {

color: #666;

font-size: 11px;

}

.comment-body {

margin-left: 90px;

}

.comment-text {

margin: 10px 0 0 0;

}

.reply-link {

height: 11px;

}

.reply-link a {

float: right;

font-size: 11px;

}



/* Child Comments */

#commentlist .children {

padding: 0;

margin: 0;

}

#commentlist .children .comment {

margin-left: 20px;

padding-left: 20px;

background: url(lib/images/comment-reply.png) no-repeat left top;

}

#commentlist .children .comment-avatar img {

width: 40px;

height: 40px;

}

#commentlist .children .comment-body {

margin-left: 70px;

}



/* Comment Post Author */

#commentlist .post-author {

position: relative;

line-height: 1;

font-size: 11px;

line-height: 11px;

margin-top: 10px;

padding: 3px;

text-align: center;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

color: #333;

border: 1px solid #e1ca82;

background-color: #ffeaa6;

background-image: -moz-linear-gradient(#fff2c9, #ffeaa7);

background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fff2c9), color-stop(100%,#ffeaa7));

background-image: -webkit-linear-gradient(#fff2c9, #ffeaa7);

background-image: -ms-linear-gradient(#fff2c9, #ffeaa7);

background-image: -o-linear-gradient(#fff2c9, #ffeaa7);

-pie-background: linear-gradient(#fff2c9, #ffeaa7);

display: none;

}

#commentlist .bypostauthor > .comment-box .post-author {

display: block;

}



/* Comment Form */

#commentform {

float: left;

width: 100%;

margin-top: 10px;

}

#respond {

margin: 10px 0 20px 0;

}

#respond h3 {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 20px 0;

margin: 0 0 20px 0;

}

.frame #respond h3 {

border-color: #eee;

}

#respond label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#respond textarea {

margin: 10px 0 0;

}

#cancel-comment-reply-link {

font-family: Helvetica, Arial, sans-serif;

float: right;

display: block;

font-size: 11px;

margin-top: 5px;

}





/************************************ Page Navigation ************************************/



/* Page & Comments Navigation */

.wp-pagenavi {

margin: 20px 0 0 0;

float: right;

}

.wp-pagenavi.post-navi {

margin: 0 0 20px 0;

}

.wp-pagenavi span,

.wp-pagenavi.cat-navi a,

.wp-pagenavi.comment-navi a,

.wp-pagenavi.post-navi a span {

display: block;

float: left;

padding: 5px 10px;

margin-left: 5px;

text-align: center;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

font-weight: bold;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.wp-pagenavi .current,

.wp-pagenavi.cat-navi a:hover,

.wp-pagenavi.comment-navi a:hover,

.wp-pagenavi .page:hover,

.wp-pagenavi.post-navi span,

.wp-pagenavi.post-navi a span:hover {

-webkit-box-shadow: 0 0 5px rgba(0,153,255,1);

-moz-box-shadow: 0 0 5px rgba(0,153,255,1);

box-shadow: 0 0 5px rgba(0,153,255,1);

}





.header-tour{color:#000000 !important; font:35px 'open_sansregular' !important; }




.avatar{

float:right;		
margin-right:20px;
}



.avatar_name{

float:left;

font-size:17px;		

color:#FFF;

margin-top:-18px;

font-family:'nunitoregular'

}

.drop_arrow {color: #FFFFFF; float: right; font-size: 20px; height: 36px; margin-right: 5px; margin-top: 2px; text-align: right; width: 45px; cursor:pointer;}



.drop_arrow span{ color:#fff;}
.drop_arrow .sub-nav-wrap {background-color: #acd373; border-radius:0 0 30px 30px; display: none; float: right; margin:12px -90px 0 0px; width:245px;}
.drop_arrow .sub-nav-wrap ul{margin:0; float: left; padding:0px;}

.drop_arrow .sub-nav-wrap ul li {background: none ; display: inline; float: left; margin: 0; padding: 0; position: relative; text-align: left; width: 100%;}

.drop_arrow .sub-nav-wrap ul li a {color: #707070; display: block;  float: left;  font-family: 'nunitolight'; font-size: 18px; height: auto; line-height: 9px; padding: 12px 25px 12px 25px; width: 80%;}
.drop_arrow .sub-nav-wrap ul li:first-child a {border-left-width: 0; border-radius: 8px 8px 0 0;}
.drop_arrow .sub-nav-wrap ul li a:hover{color:#000;}
.drop_arrow:hover .sub-nav-wrap{display:block;}
/*
#register-page .oneall_social_login {
    display: none;
}
*/


.avatar_image{float:right; margin-top:-30px; padding:5px;}
.bullet-icon{float:left; width:15%; text-align:left; margin-top:15px}
.bullet-icon a, .bullet-icon a:hover{font:14px/55px 'FontAwesome'; color:#cbcbcb; margin-left:10px;}
[class^="icon-"], [class*=" icon-"]{color:#cbcbcb;}
.center-heading{width:70%; float:left; text-align:center}
.skiptour{float:right; /* margin-top: 10px; */ width:10%; text-align:right; margin-top:15px }
.skiptour a, .skiptour a:hover{font:14px/55px 'open_sansregular'; color:#b5b5b5; }



.focus_text{
width:92%;
margin:0px auto;
text-align:center;
margin-bottom:17px;
border-bottom:1px solid #cdcdcd; }


.focus_text cite{text-align:center; width:100%; line-height:58px; margin-top:19px; font-size:32px; font-family: 'open_sanssemibold_italic'; color:#b92927;}



.clear{clear:both; float:none}

.cont-wrap{width:100%;}



.left-content{float:left; width:23%;}

#se_main
	{
		width:900px;
		margin:0 auto 250px auto;
		padding:70px 0px 0px 0px;
		}
	
#se_main li {
    background-image: none;
    float: left;
    margin: 0 30px;
    padding: 0;
    width: 243px;
}
	
#se_main li:first-child { margin-left:28px;}
#se_main li:last-child { margin-right:0;}
	

.se_getstart {
    color: #C5D3D6;
    float: left;
    font-size: 32px;
    margin-bottom: 16px;
    text-align: center;
    width: 100%;
}
	
	
.se_wanttoknowmore {
    color: #C5D3D6;
    float: left;
    font-size: 30px;
    letter-spacing: -2px;
    margin: 0 0 16px;
    padding-top: 1px;
    text-align: center;
    width: 100%;
}
	
.se_basicmem {
    color: #2E7E25;
    float: left;
    font-size: 28px;
    margin-bottom: 21px;
    text-align: center;
    width: 100%;
}
	
.se_learnabout {
    color: #187EBE;
    float: left;
    font-size: 28px;
    margin-bottom: 21px;
    text-align: center;
    width: 100%;
}



	
#se_main li:last-child .se_basicmem{color:#7e4f23;}
#se_main li:last-child .se_isfree{font-size:36px;}
.se_isfree {
    color: #2E7E25;
    float: left;
    font-size:41px;
    margin-bottom: 11px;
    text-align: center;
    width: 100%;
}
	
.se_isfree span
	{
	color:#7e4f23;
	}
	
	
.se_mostoursite {
    color: #313A3F;
    float: left;
    font-size: 15px;
    margin-bottom: 1px;
    text-align: center;
    width: 100%;
    margin-top: 4px;
}
	
.createaccount_button {
    float: left;
    padding: 10px 0 0;
    width: 100%;
}
	
.createaccount_button a {
	width:99%;
	float:left;
	font-weight: bold;
   border: 0.5px solid #2C6500;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0f4207));
   background: -webkit-linear-gradient(top, #94e241, #175d0c);
   background: -moz-linear-gradient(top, #94e241, #175d0c);
   background: -ms-linear-gradient(top, #94e241, #175d0c);
   background: -o-linear-gradient(top, #94e241, #175d0c);
   padding: 17px 0;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;

   -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: #FFFFFF;
   font-size: 20px;
   font-family: open_sansregular;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
 


   
   
   
   
.createaccount_button a:hover {
   background: #2c6500;
   color: #ffffff;
   }
.createaccount_button a:active {
   background: #343536;
   }
   
 
 
 .se_pricing {
    color: #187EBE;
    float: left;
    font-size: 41px;
    margin-bottom: 11px;
    text-align: center;
    width: 100%;
}
	
 
 .checkpricing_button
	{
		width:100%;
		float:left;
		padding:10px 0px 0px 0px;
	}  
 .checkpricing_button a {
	width:99%;
	font-weight: bold;
	float:left;
   border: 0.5px solid #0D7D9B;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0891bf));
   background: -webkit-linear-gradient(top, #78c6f4, #0891bf);
   background: -moz-linear-gradient(top, #78c6f4, #0891bf);
   background: -ms-linear-gradient(top, #78c6f4, #0891bf);
   background: -o-linear-gradient(top, #78c6f4, #0891bf);
   padding: 17px 0;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: white;
   font-size: 20px;
   font-family: open_sansregular;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
 
 
   
.checkpricing_button a:hover {
    background: #0d7d9b;
   color: #ffffff;
   }
.checkpricing_button a:active {
    background: #343536;
   }
   
   
  .takehealth_button
	{
		width:100%;
		float:left;
		padding:10px 0px 0px 0px;
	}  
 .takehealth_button a {
	width:99%;

	float:left;
   border:0.5px solid #72400E;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#bd8d5d), to(#6c3b1d));
   background: -webkit-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -moz-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -ms-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -o-linear-gradient(top, #bd8d5d, #6c3b1d);
    -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;

      -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: #fff;
   font-size: 20px;
   font-family: open_sansregular;
   font-weight: bold;
   padding: 17px 0;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
    
   
.takehealth_button a:hover {
    background: #72400e;
   color: #ffffff;
   }
.takehealth_button a:active {
    background: #343536;
   }





#answer-form p .wp32 {
    float: left;
    height: 48px;
    margin: 0 15px 0 0;
    padding: 13px 0 0 10px;
    width: 451px;
}
#answer-form img {
    float: left;
    height: 48px;
    margin-right: 15px;
    width: 48px;
}
#answer-form .qa-edit-submit {
    float: left;
    margin-top: 7px;
}


.qa-action-links > a {
    color: #BFBFBF;
    margin-right: 16px;
    text-transform: capitalize;
}
.qa-action-links {
    color: rgba(0, 0, 0, 0);
    margin-top: 15px;
}
.qa-action-links > a:hover {
    color: #FF6600;
    font-weight: bold;
}
#answer-list > h2 {
    color: #FF6600;
    font-size: 24px;
    margin: 0;
}
#answer-list {
    border-bottom: 1px solid #D7D7D7;
}


.healthy

	{

		width:88%;

		float:right;

		font-size:44px;

		line-height:50px;

		color:#313b41;

		font-family: 'open_sansregular';

		text-align:right;

		margin-bottom:39px;

		font-weight:600;

		margin-top:35px;

	}

.sign_up

	{

		width:90%;

		float:right;

		border-radius:3px;

		height:47px;

		background: -webkit-linear-gradient(0deg, #038aac, #05bcea); /* For Safari */

		background: -o-linear-gradient(0deg, #038aac, #05bcea); /* For Opera 11.1 to 12.0 */

		background: -moz-linear-gradient(0deg, #038aac, #05bcea); /* For Firefox 3.6 to 15 */

		background: linear-gradient(0deg, #038aac, #05bcea); /* Standard syntax (must be last) */

		border:1px solid #497629;

		/* box-shadow: inset 1px 1px 5px #000;

		box-shadow:1px 1px 5px #000; */

		font-size:21px;

		color:#ffffff;

		font-family: 'roboto_slabregular';

		/* text-shadow: 1px 1px 9px #e0fbcb; */

		line-height:44px;

		text-align:center;

		cursor:pointer;



	}

/* ///////   Q&A Pages CSS     ////////    */
.qa-left-side{float:left; width:33%; font-family: 'open_sansregular';}
.qa-left-side #sidebar{margin-left:0px;}
.qa-left-side .widget{border:0; margin:0px; padding:0px;}
.qa-left-side .avatar_image1{float:left; }
.qa-left-side .avatar_image1 img{width:57px; height:57px;}
.qa-left-side .avatar_name1{float:left; padding-left:10px; color:#737373; font-size:18px; line-height:3.5; font-weight:bold;  text-transform: capitalize; }
.qa-left-side #nav_menu-6{float:left; }
.qa-left-side #nav_menu-6 ul{float:left; }
.qa-left-side #nav_menu-6 ul li {display: inline;    float: left;    padding-left:12%;    width: 80%;}
.qa-left-side #nav_menu-6 ul li a {color: #35393C; float: left; font-size: 18px; line-height:26px; text-transform: capitalize;}
.qa-left-side #nav_menu-6 ul li a:hover{color:#3f902a; }

.qa-left-side .search-box{float:left; margin-top: 30px;}

.qa-left-side #question_categories-2 {float: left; margin-top: 36px;font-family: 'open_sansregular';}
.qa-left-side #question_categories-2  h2{color:#3f902a; font-family: 'open_sansregular';  font-weight:bold; font-size:22px;}

.qa-left-side #question_categories-2 ul{float:left; }
.qa-left-side #question_categories-2 ul li {display: inline; background:none;    float: left;    padding-left:5%; margin-bottom:0;    width: 90%;}
.qa-left-side #question_categories-2 ul li a {color: #35393C; float: left; font-size: 19px; line-height: 26px; text-transform: capitalize;}
.qa-left-side #question_categories-2 ul li a:hover{color:#3f902a; }

.qa-left-side #searchbar {margin-top: 28px;  width: 70%;}



.qa-right-side{float:right; width:66%;}
.qa-right-side #qa-page-wrapper{margin-left:0px;}


/* /////// End  Q&A Pages CSS     ////////    */
	
.slider{float:right; width:74%; margin-top:15px; border-radius:5px}



.tour{width:100%; float:left; background:#bcdf81; min-height:45px; margin-top:53px;  border-radius: 0 0 27px 27px; text-align:center}



.take_tour_btn{

display:inline-block;

	/*min-width:20%;*/
	padding:0px 40px;
	float:none;
	border-radius:26px;
	height:47px;
	background: -webkit-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Safari */
	background: -o-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Opera 11.1 to 12.0 */
	background: -moz-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Firefox 3.6 to 15 */
	background: linear-gradient(0deg, #ffee23, #fcfcc3); /* Standard syntax (must be last) */
	border:1px solid #497629;
	/* box-shadow: inset 1px 1px 5px #000;*/
	box-shadow:5px px 6px #000; 
	font-size:22px;
	line-height:45px;
	text-align:center;
	cursor:pointer;
	position:relative;
	z-index:1;
	margin-top: -25px;
	}





.take_tour_btn a, .take_tour_btn a:hover{color:#313b41;

	font-family: 'roboto_slabregular';}





.oneByOne1{box-shadow:1px 1px 10px #ccc;

		border:1px solid #e1e2e3;

		background:#FFFFFF;

		border-radius:5px}


#nav a#pull {
	display: none;
	color: #fff;
	font-family: "Times New Roman", Times, serif;
	font-size: 16px;
	font-weight:bold;
	text-align:left;
	z-index: 100;
}






.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:410px !important; border-radius:5px !important}

.peKenBurns.neutral .peKb_slides{background-color:#fff !important; box-shadow:1px 1px 10px #ccc; border:1px solid #e1e2e3; background:#FFFFFF; border-radius:5px !important}

.peKenBurns .peKb_slides .peKb_caption{width:100% !important;}

.peKenBurns .peKb_slides{padding:0px}

.peKenBurns .peKb_shadow{display:none}

.peKenBurns ul li{background:none !important}


.start-explore{text-align:center}

.start-explore h3{color:#323b42; margin-top:40px; font: 37px/70px 'open_sansregular'}

.createaccount{width:22%; background:green; display:inline-block; 

        background: -webkit-linear-gradient(0deg, #318025, #9edf4d); /* For Safari */

	background: -o-linear-gradient(0deg, #318025, #9edf4d); /* For Opera 11.1 to 12.0 */

	background: -moz-linear-gradient(0deg, #318025, #9edf4d); /* For Firefox 3.6 to 15 */

	background: linear-gradient(0deg, #318025, #9edf4d); /* Standard syntax (must be last) */

	border:1px solid #7e946e;

	/* box-shadow: inset 1px 1px 5px #000;*/

	box-shadow:5px px 6px #000; 

border-radius:3px;

margin-top:10px}



.createaccount a{color:#fff; font:17px/41px 'open_sansregular'; }

.createaccount a:hover{color:#fff}



.or{width: 52%; display:inline-block; margin-top:50px; background:url(images/arrow-red.png) no-repeat 97% 65%; margin-bottom:60px }



.or p{font:24px/32px 'open_sansregular'; color:#31383e; width:70%; float:left; text-align:right}

.or p:first-child{text-align:center; width:100%; margin-bottom:30px}





.connect-tour{width:85%; margin:0px auto; margin-bottom:25px}

.mobile-menu{display:none !important}















@media all and (max-width: 1280px) {

#header-left{width:20%}

#header-right{width:68%}

.oneByOne1{width:100%}

}

@media all and (max-width: 980px){
#header-inner{text-align: center;}
#header-left, #header-right{float:none; display: inline-block; }
#header-right{width:98%}
#header-left {width: 38%;}
.slider{width:72%}
#nav{margin-top:35px}

}







@media all and (max-width: 960px)

{

#content{float:none; text-align:center; width:100% !important }

.left-content{display: inline-block;; float:none !important; width:80%}

.slider{display: inline-block; float: none !important;  margin-top: 15px; width: 85%;}

.healthy{width:100%; text-align:center !important; float:none !important; font-size: 37px;}

.sign_up{display:inline-block; width:35%; float:none}
.bullet-icon, .skiptour, .center-heading{float:none; width:100%; text-align:center !important }
.bullet-icon a, .skiptour a{line-height:30px !important}
.bullet-icon{padding-top:10px}
.focus_text cite{margin-top:10px !important}
}





@media all and (max-width: 800px)

{

.or{background:none}

.or p{width:100%; text-align:center; margin-bottom: 10px;}

.createaccount{width:26%}

}











@media all and (max-width: 768px)

{

#nav li > a{font-size:16px}

#nav ul.menu, #nav ul.menu ul{margin: 1px 0 0 17px;}

.slider {width:83%}

#header-left {width: 100%;}

.take_tour_btn{margin-right:0px} 

.or{ margin-bottom: 0px;}

}


@media all and (max-width: 755px)

{
#nav{padding:0px !important; background:#c8e8fa !important}
#nav ul.menu {display: none;	height: auto; margin: 0px;}
#nav a#pull {display: block; background:url("images/nav-icon.png") no-repeat scroll 85% 10px; padding: 12px 10px; position: relative;	padding-left: 25px; text-decoration:none; width:100%; color:#2B3133; font-family:'open_sansregular'; text-transform: uppercase; font-size:15px}
#nav ul.menu{width:100%}
#nav ul.menu li {float:none; width:100%; display:block; }
#nav ul.menu li a {text-align:center; padding:15px}
.sub-menu{display:none !important}
#nav ul.menu li:hover .sub-menu{width:100%; display:block !important; position:relative; top:0px }
#nav ul.menu li:hover .sub-menu a{width:100%; display:block;}
.widget_nav_menu ul li:hover .sub-menu{display:block !important}
}




@media all  and (max-width: 640px){



.slider {width: 79%;}

.sign_up {width: 55%;}

#logo{width:100%; float:left;}

#logo a {
    background: url("http://mariasplace.com/wp-content/uploads/logo_maria.png") no-repeat scroll center top / 100% auto rgba(0, 0, 0, 0);
    height: 160px;
    margin: 0 auto;
    width: 363px;
    display: block;
	float:none;
}

#footer-widgets {float:none; text-align:center}

#footer-widgets > div{width:100%; display: inline-block;}

.footer-widget-inner {display: inline-block; float: none; width: 75%;}

.tour {margin-top:0px}

.take_tour_btn{ margin-right:0px !important; float:none !important} 

.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:300px !important}

.peKb_slides, .peKb_timer{height:250px !important; width:100% !important}

peKb_timer canvas{display:none}

.or{ margin-bottom: 15px;}

.createaccount {width: 35%;}

}


a.mlw_qmn_quiz_link {
font-size:1.2em !important;
}

div.mlw_qmn_quiz input[type=submit]{
font-size:1.2em !important;
}


@media all and (max-width: 480px){

.avatar {
    display: block !important;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 1000;
}
.drop_arrow:hover .sub-nav-wrap {display:block;}

.drop_arrow .sub-nav-wrap {
    background-color: #ACD373;
    border-radius: 0;
    display: none;
    float: right;
    margin: 12px -90px 0 0;
    width: 245px;
}


#nav a#pull{width:40%;}
#nav ul.menu{display:none;}

#nav ul.menu, #nav ul ul{margin:0;}

.focus_text{font-size:24px}

.slider {width: 86%;}

#header-left{width:60%}

.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:250px !important}

.peKb_slides, .peKb_timer{height:200px !important; width:100% !important}

.peKenBurns.neutral .peKb_timer{display:none !important}

peKb_mainPanel{margin-left:70px}



.createaccount {width: 51%;}

.or {width:80%}

.peKenBurns .peKb_controls{display:none !important;}

.healthy{margin-top:0px}

.focus_text cite, .header-tour{font-size:28px !important}

 #logo a {    background: url("http://mariasplace.com/wp-content/uploads/logo_maria.png") no-repeat scroll center top / 90% auto rgba(0, 0, 0, 0);    float: left;    height: 145px;    width: 100%;}

}







@media all and (max-width: 360px)

{

.slider {width: 86%;}
.healthy{font-size:25px; line-height:30px}
.sign_up {width: 94%;}
#header-left {width: 100%;}
.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:225px !important}
.peKb_slides, .peKb_timer{height:175px !important; width:100% !important}
.createaccount { width: 60%;}
.or p{font-size:22px}

}

@media all and (max-width: 320px){
#logo img{display:none;}
.slider {width:90%;}
.healthy{font-size:22px}
#header-left {width: 80%;}
#nav ul.menu{display:none;}
#se_main li:first-child {margin-left:0px;}
#se_main li:last-child {margin-bottom:50px;}

.se_mostoursite{margin-bottom:6px;}
#se_main .createaccount_button {float: none; padding: 10px 0 0; width:100%;}
#se_main .checkpricing_button {float: none; padding: 10px 0 0; width: 100%;}
#se_main .takehealth_button {float: none; padding: 10px 0 0; width: 100%;}
#se_main {margin: 0 auto; padding: 70px 0 0; width: 92%;}

#se_main li.se_columns {display: block; margin: 20px 0 20px; width: 100%;}

}

/************************************ BuddyPress ************************************/


#gp-theme-options a[href="#5"] {

display: none !important;

}



@font-face {
	font-family: 'icomoon';
	src:url('fonts/icomoon.eot?-ldfnid');
	src:url('fonts/icomoon.eot?#iefix-ldfnid') format('embedded-opentype'),
		url('fonts/icomoon.woff?-ldfnid') format('woff'),
		url('fonts/icomoon.ttf?-ldfnid') format('truetype'),
		url('fonts/icomoon.svg?-ldfnid#icomoon') format('svg');
	font-weight: normal;
	font-style: normal;
}

[class^="icon-"], [class*=" icon-"],.fav,.unfav {
	font-family: 'icomoon';
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;

	/* Better Font Rendering =========== */
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
.icon-play:before {
	content: "\e601";
}

.icon-bubble:before {
	content: "\e600";
}
.icon-search:before {
	content: "\e681";
}
.icon-flag:before {
	content: "\e6c6";
}
.icon-flag:hover{
	content: "\e6c6";
	color:#000;
}
.unfav:before {
	content: "\e6d3";
	color:#fdc9cd;
}
.unfav:active{
	content: "\e6d3";
	color:#fdc9cd;
}
.fav:before {
	content: "\e6d4";
}
.fav:hover{
	color:#d42238;
}
.icon-close:before {
	content: "\e6ff";
}
.icon-add:before {
	content: "\e641";
}
.icon-cog:before {
	content: "\e690";
}
.icon-arrow-right:before {
	content: "\e723";
}
.icon-arrow-right2:before {
	content: "\e725";
}
.like{
color:#bc2723;
border:0 none;
}
.icon-flagged:before {
content: "\e6c6";
border:0 none;color:#d42238;
}
.activity-meta {position:relative;!important; width:400px; text-align:right;}

.activity-meta .unfav {
    float: left;
    position: absolute;
    width: auto;
    left: 0;
}

.activity-meta .unfav:hover {
	color:#497996!important;
}
.activity-meta .fav {
    float: left;
    position: absolute;
    width: auto;
    left: 0;
}
.activity-meta .reshare-button {
    float: left;
    position: absolute;
    top: 0;
    width: auto;
    left:137px;
}
.activity-meta .unlike { float: left;
    left: 179px;
    position: absolute;
    width: auto;
}
.activity-meta .like { float: left;
    left: 179px;
    position: absolute;
    width: auto;
}
.activity-meta .reshare-button {width:auto; float:left; left;197px; position:absolute;}
.activity-content .like {width:auto; float:left;}
.activity-content .fav {width:auto; float:left;}
.activity-content .acomment-reply {width:auto; float:left;}
.activity-content .bp-ap-selectbox {width:auto; float:left;}
.activity-content .reshare-button {width:auto; float:left;}
.activity-meta .like,.fav ,.acomment-reply,.bp-ap-selectbox,.reshare-button{display:none!important; width:auto; float:left;}
.activity-content:hover .like {display:block!important;}
.activity-content:hover .fav {display:block!important;}
.activity-content:hover .acomment-reply {display:block!important;}
.activity-content:hover .bp-ap-selectbox {display:block!important;}
.activity-content:hover .reshare-button {display:block!important; }
.activity-meta .customStyleSelectBox2 { display:none!important;}
.activity-content .acomment-reply {position: absolute;left: 64px;}
.bubble_font { color:#BCDF81!important; font-size:25px;}
.icon-bubble:before {	content: "\e600";}

.duplicate-unfav:before{ content: "\e6d3"; color:#fdc9cd;}
.activity-meta .duplicate-unfav{ display:block!important; }

.duplicate-fav:before{	content: "\e6d4";}
.duplicate-fav:hover{	color:#d42238; }
.activity-meta .duplicate-fav{ display:none!important;}

.activity-meta a{color:#CBCBCB}

.activity-meta .duplicate-flagged{display:block!important;}
.activity-meta .duplicate-flag{display:none!important;}
.footer-links{font-size:15px; font-weight:bold; margin-left: 32%;}


.qa-page-wrapper{float:left; width:65%;}

.create-post {
    float: right;
    font-size: 18px;
    margin-top: 16px;
	color: #BEBEBE;

}
.create-post span {
    border: 3px solid #BEBEBE;
    border-radius: 50%;
    
    margin-right: 6px;
    padding: 2px;
    text-align: center;
    font-size: 12px;
}
.create-post a{color:#313a41;}
.create-post:hover a{color:#ADD36C;}
.create-post:hover span{color:#ADD36C;border: 3px solid #ADD36C;}

.question-score:before{
 content:"\e600";
 font-family: 'icomoon';
}
.question-score {
    font-size: 53px;
    margin-top: -10px;
}

.question-status:before{
 content:"\e600";
 font-family: 'icomoon';
}
.question-status {
    font-size: 53px;
    margin-top: -10px;
}
.qa-voting-box{color:#bfbfbf;}
.qa-voting-box:hover{color:#bd262b;}

.qa-voting-box .vote-up-off:before{
content: "\e6d4";
font-family: 'icomoon';
}
.qa-voting-box .vote-up-on:before{
content: "\e6d3";
font-family: 'icomoon';
color:#FFC9CE;
}
.qa-voting-box .vote-up-on{

}

.qa-voting-box input.vote-up-off{
	position: absolute;
	z-index: 1000;
    /*background: url("images/btn-dot.png") no-repeat top left;*/
	
}
.qa-voting-box span.vote-up-off {
    left: 14px;
    position: absolute;
    top: -25px;
   
}

.qa-voting-box input[type="submit"]:hover{box-shadow:none;}

.commentshow {color: #BCBCBC;    cursor: pointer;    display: inline;    position: relative;}
.commentshow:hover{color:#079CC4;}

.question-status div{display:none;}
.question-status div.mini-count{display:block;}

.question-score div{display:none;}
.question-score div.mini-count{display:block;}

.bp-wrapper #item-header #latest-update, .bp-wrapper #item-header #item-meta {
font-family: open-sansregular;
font-size: 1.2em;
}
.bp-wrapper div#item-header h2 {
font-family: open-sansregular;
}

.bp-wrapper form.standard-form label, .bp-wrapper form.standard-form span.label {
font-family: open-sansregular;
font-size: 1.4em;
font-weight:bold;
}
.field-visibility-settings-notoggle{
font-family: open-sansregular;
}


.bp-wrapper div.item-list-tabs ul li a, .bp-wrapper div.item-list-tabs ul li span {
font-family: open-sansregular;
}
.bp-wrapper a.button, .button.submit, .bp-wrapper .generic-button a, .bp-wrapper ul.button-nav li a, 
.bp-wrapper .item-list a.button, .bp-wrapper .item-list .acomment-options a, .widget .item-options a, 
.widget .swa-wrap ul#activity-filter-links a, .widget .swa-activity-list li.mini div.swa-activity-meta a, 
.widget .swa-activity-list div.swa-activity-meta a.acomment-reply, 
.widget .swa-activity-list div.acomment-options a{
border: 0.5px solid #2C6500;
background: #0f4207;
background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0f4207));
background: -webkit-linear-gradient(top, #94e241, #175d0c);
background: -moz-linear-gradient(top, #94e241, #175d0c);
background: -ms-linear-gradient(top, #94e241, #175d0c);
background: -o-linear-gradient(top, #94e241, #175d0c);
padding: 5px 20px 5px 20px;
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
-webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
-moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
color: #FFFFFF;
font-size: 20px;
font-family: open_sansregular;
text-decoration: none;
vertical-align: middle;
text-align: center;
}
.bp-wrapper ul.button-nav li a:hover {
   background: #2c6500;
   color: #ffffff;
   border:none;  
   }
.bp-wrapper ul.item-list {
width: 100%;
border-bottom: 1px solid #eee;
}
.bp-wrapper #item-body h3 {
font-family: open-sansregular;
}
	.bp-wrapper table tr td, .bp-wrapper table tr th {
padding: 10px;
font-family: open-sansregular;
}
/**********Tours 5 **********************************/
.page-id-2606 .connect-tour {
    width: 100%;
}


*{
		padding:0px;
		margin:0px;
		outline:none;
		border:none;
		list-style:none;
	}
	



@import url('icomoon.css');

/*?

Theme Name: Bounce
Version: 1.9.7
Description: Designed by <a href="http://www.ghostpool.com">GhostPool.com</a>.
Author: GhostPool
Author URI: http://www.ghostpool.com
Theme URI: http://www.ghostpool.com
License:
License URI:
Tags: buddypress, dark, light, black, gray, green, orange, purple, brown, blue, one-column, two-columns, left-sidebar, right-sidebar, fixed-width, custom-background, custom-colors, custom-menu, editor-style, featured-images, full-width-template, sticky-post, theme-options, translation-ready

*/



/************************************ General Styling ************************************/

@font-face {
    font-family: 'open_sansregular';
    src: url('fonts/opensans-regular-webfont.eot');
    src: url('fonts/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/opensans-regular-webfont.woff') format('woff'),
         url('fonts/opensans-regular-webfont.ttf') format('truetype'),
         url('fonts/opensans-regular-webfont.svg#open_sansregular') format('svg');
    font-weight: normal;
    font-style: normal;

}






@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5),only screen and (min-resolution: 192dpi) {

#logo a{
background: url("http://mariasplace.com/wp-content/uploads/logo_maria@2x.png") no-repeat scroll center top / 90%;
height:365px;
}

}

@font-face
{
font-family: Arial Narrow;
src: url(images/ARIALN.TTF);
}



.bp-links{display:none !important;}

/* Page Styling */

* {

font-family: Helvetica, Arial, sans-serif;

outline: none;

}

html {

margin: 0;

padding: 0;

}

body {

background: -webkit-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Safari */

background: -o-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Opera 11.1 to 12.0 */

background: -moz-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Firefox 3.6 to 15 */

background: linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* Standard syntax (must be last) */

color: #333;

margin: 0;

padding: 0;

font-family: Helvetica, Arial, sans-serif;

font-size: 12px;

font-weight: normal;

text-align: center;

overflow-x: hidden;

}



/* Text Styling */

a {

text-decoration: none;

-webkit-transition: color 0.12s ease-out;

-moz-transition: color 0.12s ease-out;

-o-transition: color 0.12s ease-out;

-ms-transition: color 0.12s ease-out;

transition: color 0.12s ease-out;

}



a img{width:auto; max-width:100%}



@font-face {

    font-family: 'roboto_slabregular';

    src: url('css/RobotoSlab-Regular-webfont.eot');

    src: url('css/RobotoSlab-Regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/RobotoSlab-Regular-webfont.woff') format('woff'),

         url('css/RobotoSlab-Regular-webfont.ttf') format('truetype'),

         url('css/RobotoSlab-Regular-webfont.svg#roboto_slabregular') format('svg');

    font-weight: normal;

    font-style: normal;



}





@font-face {

    font-family: 'nunitoregular';

    src: url('css/nunito-regular-webfont.eot');

    src: url('css/nunito-regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/nunito-regular-webfont.woff') format('woff'),

         url('css/nunito-regular-webfont.ttf') format('truetype'),

         url('css/nunito-regular-webfont.svg#nunitoregular') format('svg');

    font-weight: normal;

    font-style: normal;



}









@font-face {

    font-family: 'open_sanssemibold_italic';

    src: url('css/opensans-semibolditalic-webfont.eot');

    src: url('css/opensans-semibolditalic-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/opensans-semibolditalic-webfont.woff') format('woff'),

         url('css/opensans-semibolditalic-webfont.ttf') format('truetype'),

         url('css/opensans-semibolditalic-webfont.svg#open_sanssemibold_italic') format('svg');

    font-weight: normal;

    font-style: normal;



}



@font-face {

    font-family: 'open_sansregular';

    src: url('css/opensans-regular-webfont.eot');

    src: url('css/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/opensans-regular-webfont.woff') format('woff'),

         url('css/opensans-regular-webfont.ttf') format('truetype'),

         url('css/opensans-regular-webfont.svg#open_sansregular') format('svg');

    font-weight: 400;

    font-style: normal;

}





@font-face {

    font-family: 'nunitolight';

    src: url('css/nunito-light-webfont.eot');

    src: url('css/nunito-light-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/nunito-light-webfont.woff') format('woff'),

         url('css/nunito-light-webfont.ttf') format('truetype'),

         url('css/nunito-light-webfont.svg#nunitolight') format('svg');

    font-weight: normal;

    font-style: normal;



}	







a:hover {

text-decoration: none;

}

h1, h2, h3, h4, h5, h6 {

font-family: 'Raleway', sans-serif;

color: #000;

margin: 0 0 20px 0;

padding: 0;

line-height: 130%;

text-shadow: none;

}

h1 {

font-size: 36px;

}

h2 {

font-size: 32px;

}

h3 {

font-size: 30px;

}

h4 {
font-family: nunitoregular, sans-serif;
font-size: 24px;
}

h5 {

font-family: 'Lato', sans-serif;

font-size: 20px;

}

h6 {

font-family: 'Lato', sans-serif;

font-size: 15px;

}

p {

line-height: 19px;

margin-bottom: 12px;
font-family: open-sansregular;
font-size: 1.2em;
}

p:first-child {

margin-bottom: 12px;

}

p:last-child {

margin-bottom: 0;

}

strong {

font-weight: bold;

}

em {

font-style: italic;

}

small {

font-size: xx-small;

line-height: 1em;

}

sup {

font-size: xx-small;

vertical-align: top;

line-height: 1em;

} 

sub {

font-size: xx-small;

vertical-align: bottom;

line-height: 1em;

} 

#profile-details-section{display:none !important;}

/* List Styling */

ol {

padding: 0;

margin: 0;

}

ol li {

list-style: decimal;

padding: 0 0 10px 0;

margin: 0 0 0 20px;

line-height: 19px;

}

ul {

padding: 0;

margin: 0;

}

ul li {

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

background-position: -115px -381px;

list-style-type: none;

margin: 0 0 10px 0;

padding: 0 0 0 20px;

line-height: 19px;

}

li:last-child {

margin-bottom: 0;

}



/* Form Styling */

input,

textarea,

input[type="password"] {

font-family: Helvetica, Arial, sans-serif;

font-size: 12px;

line-height: 12px;

padding: 7px;

margin: 0;

color: #000;

border: 1px solid #eee;

background: #fff;

-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

input:focus,

textarea:focus,

input[type="password"]:focus {

border: 1px solid #999;

}

textarea {

line-height: 19px;

resize: none;

width: 100%;

max-width: 100%;

height: 150px;

}

select {

padding: 2px 0;

}

input[type="button"],

input[type="submit"],

input[type="reset"] {

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

font-weight: bold;

padding: 8px 15px;

cursor: pointer;

border-width: 0;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-transition: border-color .2s linear;

-moz-transition: border-color .2s linear;

-ms-transition: border-color .2s linear;

-o-transition: border-color .2s linear;

transition: border-color .2s linear;

}

input[type="button"]:hover,

input[type="submit"]:hover,

input[type="reset"]:hover {

border-width: 0;

border-top-width: 1px;

-webkit-box-shadow: 0 0 5px rgba(0,153,255,0.5);

-moz-box-shadow: 0 0 5px rgba(0,153,255,0.5);

box-shadow: 0 0 5px rgba(0,153,255,0.5);

}

input[type="radio"],

input[type="checkbox"] {

background: transparent;

border: 0;

}

fieldset {

border: 1px solid #eee;

margin: 0;

padding: 20px;

}

legend {

font-size: 14px;

}



/* Table Styling */

table {

border: 1px solid #eee;

padding: 5px 10px;

line-height: 19px;

width: 100%;

}

table th {

font-weight: bold;

border-top: 1px solid #eee;

padding: 10px;

text-align: left;

}

table td {

border-top: 1px solid #eee;

padding: 10px;

}



/* Other Styling */

img {

max-width: 100%;

height: auto;

}

.ie8 img {

max-width: none;

}

.avatar img,

img.avatar {

position: relative;

/*padding: 1px;*/

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 50%;

-moz-border-radius: 50%;

border-radius: 50%;

}

object,

embed,

video,

iframe {

max-width: 100%;

}

cite {

float: right;

padding: 0 0 5px 0;

}

hr {

background: #eee;

border: 0;

clear: both;

width: 100%;

height: 1px;

padding: 0;

margin: 20px 0;

position: relative;

}

pre {

background: url(lib/images/code-bg.png);

border: 1px solid #eee;

padding: 5px 25px;

margin: 5px 0 20px 0;

font-family: "Courier New";

overflow: auto;

font-size: 12px;

line-height: 19px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

code {

background: url(lib/images/code-bg.png);

border: 1px solid #eee !important;

padding: 5px 25px;

margin: 5px 0 20px 0;

font-family: "Courier New";

clear: both;

display: block;

font-size: 12px;

line-height: 19px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

.preload {

display: none;

}

.no-js .preload {

display: block;

}



/* Alignment Styling */

.left {

float: left;

}

.right {

float: right;

}

.clear {

content: "";

clear: both;

line-height: 0;

padding: 0;

margin: 0;

height: 0;

display:block;

font-size:0;

width:100%;

}

.align-center,

.aligncenter {

position: relative;

margin: 20px auto;

display: block;

clear: both;

}

.align-left,

.alignleft {

position: relative;

float: left;

margin: 4px 20px 5px 0;

}

.align-right,

.alignright {

float: right;

position: relative;

margin: 4px 0 5px 20px;

}

.text-left {

text-align: left;

}

.text-right {

text-align: right;

}

.text-center {

text-align: center;

}

.text-justify {

text-align: justify;

}





/************************************ Content Areas ************************************/



/* Page Outer */

.page-outer { 

width: 100%;

}



/* Page Inner */

.page-inner {

margin: 0 auto;

width: 980px;

}



/* Content Wrapper */

#content-wrapper {
text-align: left;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
/*overflow: hidden;Disabled due to author info panel*/
/*overflow: auto; Might be necessary in IE*/
}

.frame #content-wrapper {

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 27px;

-moz-border-radius: 27px;

border-radius: 27px;

}

.padding #content-wrapper {

 padding: 0px; 

}



/* Main Content */

#content {
position: relative;
width: 92%;
margin: 0px  auto;

}

.sb-right #content {
/*float: left;*/

}

.sb-left #content {

/* float: right;  */

}
/*
.fullwidth #content {

float: left;

width: 100%;

}



 Sidebar */

#sidebar {

width: 290px;

}

.sb-right #sidebar {

float: right;

margin-left: 40px;

}

.sb-left #sidebar {

float: left;

margin-right: 40px;

}

.fullwidth #sidebar {

display: none;

}





/************************************ Header ************************************/



/* Header Outer */

#header-outer {

text-align: left;

position: relative;

background-position: right top;

background-repeat: no-repeat;

}

#bp-links {

display: none;

}



/* Header Inner */

#header-inner {

position: relative;

margin: 0 auto;

width: 100%;

}

#header-left {

float: left;
width:auto;

}

@-webkit-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-moz-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-webkit-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-o-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

#header-right {

float: right;

position: relative;

-webkit-animation: showMenu 1s;

-moz-animation: showMenu 1s;

-o-animation: showMenu 1s;

animation: showMenu 1s;

width:70%

}



/* Logo */

#logo {

background: no-repeat;

display: inline-block;

float: left;

position: relative;

margin: 0;

line-height: 0;

}
#logo a{
  	background:url(http://mariasplace.com/wp-content/uploads/logo_maria.png) no-repeat left top;
  	width:363px;
  	height:197px;
	float:left;
  }

.default-logo {

display: inline-block;

width: 230px;

height: 90px;

position: relative;

margin-top: 19px;

}

#logo img {

position: relative;

}

.logo-details {

display: block;

width: 1px;

height: 1px;

text-indent: -9999px;

}



/* Contact Info */

#contact-info {

position: relative;

top: 25px;

right: 0;

z-index: 1;

text-align: right;

color: #fff;

text-shadow: 1px 1px 2px rgba(0,0,0,0.1);

font-weight: bold;

font-size: 14px;

line-height: 14px;

-webkit-animation: showMenu 1s;

-moz-animation: showMenu 1s;

-o-animation: showMenu 1s;

animation: showMenu 1s;

display:none

}

#contact-info a {

color: #fff;

}

#contact-info a:hover {

text-decoration: underline;

}





/************************************ Navigation Menus ************************************/



/* Nav Wrapper */

#nav {

clear: both;

position: relative;

z-index: 20;

height: 36px;

margin: 98px 0 0 0;

/* border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.1);

-moz-box-shadow: 1px 1px 5px rgba(0,0,0,0.1);

box-shadow: 1px 1px 5px rgba(0,0,0,0.1); 

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px; */

text-align:center

}

.mobile-menu {

display: none;

}



/* Top Level Nav */

#nav ul.menu,

#nav ul ul {

float: none;

position: relative;

padding: 0;

margin: 0px 0 0 35px;

list-style-type:none;

list-style-position:outside;

display:inline-block;

}

#nav ul.menu:after {

content:".";

display:block;

height:0;

clear:both;

visibility:hidden;
padding-bottom:10px;

}

#nav ul.menu li {

float: left;

background: none;

position: relative;

margin: 0;

padding: 0;

display: block;

text-align: left;

}

#nav ul.menu li > a {

color: #2b3133;

padding: 12px 25px 16px 25px;


/*margin: -1px 0 10px 0;*/

line-height: 9px;

display: block;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

font-size:18px;

font-family:'nunitolight'

}

#nav ul.menu li:first-child > a {

border-left-width: 0;

-webkit-border-radius: 8px 8px 0 0px;

-moz-border-radius: 8px 8px 0 0px;

border-radius: 8px 8px 0 0px;

}

#nav ul.menu li.home a {

background: url(lib/images/sprite.png) no-repeat 15px -21px;

text-indent: -9999px;

width: 48px;



}

#nav ul.menu li > a:hover,

#nav ul.menu .current-menu-item > a,

#nav ul.menu .current-menu-ancestor > a,

#nav ul.menu li:hover > a {

background-color: #fff;

-webkit-border-radius: 8px 8px 0 0px;

-moz-border-radius: 8px 8px 0 0px;

border-radius: 8px 8px 0 0px;}


#nav  ul.menu  .sub-menu li > a:hover{background-color: #ceecf4; border-radius:0;}
#nav  ul.menu  .sub-menu li:last-child > a:hover{border-radius: 0 0px 8px 8px;}

/* Drop Down Menus */

#nav .sub-menu {

display: none;

position: absolute;

z-index: 20;

top: 36px;

left: auto;

width: 240px;

margin: 0;

/*padding: 20px 20px 10px 20px;

 border-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.3);

box-shadow: 0 0 10px rgba(0,0,0,0.3);

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;  */

}



#nav li:hover > .sub-menu {

display: block;}



#nav .sub-menu{

border-radius:0px 0px 0px;

}

#nav .sub-menu li:hover{border-radius:none !important; }

#nav .sub-menu a {

display: block;

height: auto;

float: left;

width: 240px;

/* border-width: 1px 0 0 0;

border-style: solid; */

}



#nav .sub-menu li:first-child > a{

border-radius:0px 8px 0px 0px !important;

}



#nav .sub-menu li{width:100%;}





#nav .sub-menu li:first-child > a {

border-top: 0;

}

#nav .sub-menu a:hover {



}

#nav li span {

font-size: 10px;

line-height: 10px;

margin-left: 5px;

display:none

}

#nav .left-nav .sub-menu {

left: 0;

}



/* Sub Drop Down Menus */

#nav ul.menu .sub-menu li ul {

top: auto;

left: 200px;

margin-top: -15px;

}

#nav .sub-menu li span {

font-size: 9px;

}

#nav .left-nav .sub-menu li ul {

left: -240px;

}





/************************************ Social Icons ************************************/



#social-icons {

display: block;

float: left;

padding: 14px 5px 11px 15px;

margin: 0;

/* border-left-width: 1px;

border-style: solid; */

}

#social-icons a {

display: inline-block;

margin-right: 10px;

width: 20px;

height: 16px;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

}

#social-icons a:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}

.youtube-icon {

background: url(lib/images/sprite.png) no-repeat 0 0;

}

.facebook-icon {

background: url(lib/images/sprite.png) no-repeat -36px 0;

}

.twitter-icon {

background: url(lib/images/sprite.png) no-repeat -72px 0;

}

.dribbble-icon {

background: url(lib/images/sprite.png) no-repeat -112px 0;

}

.digg-icon {

background: url(lib/images/sprite.png) no-repeat -141px 0;

}

.vimeo-icon {

background: url(lib/images/sprite.png) no-repeat -180px 0;

}

.delicious-icon {

background: url(lib/images/sprite.png) no-repeat -215px 0;

}

.rss-icon {

background: url(lib/images/sprite.png) no-repeat -248px 0;

}

.linkedin-icon {

background: url(lib/images/sprite.png) no-repeat -285px 0;

}

.googleplus-icon {

background: url(lib/images/sprite.png) no-repeat -320px 0;

}

.myspace-icon {

background: url(lib/images/sprite.png) no-repeat -357px 0;

}

.flickr-icon {

background: url(lib/images/sprite.png) no-repeat -393px 0;

}





/************************************ Top Content ************************************/



/* Top Content */

#top-content {

float: left;

position: relative;

text-shadow: 1px 1px 1px rgba(220,220,220,0.9);

width: 100%;

padding: 40px;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 4px 4px 0 0;

-moz-border-radius: 4px 4px 0 0;

border-radius: 4px 4px 0 0;

background-position: right bottom;

background-repeat: no-repeat;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content a {

color: #fff;

}

#top-content a:hover {

color: #ccc;

}

#top-content h1,

#top-content h2,

#top-content h3,

#top-content h4,

#top-content h5,

#top-content h6 {

color: #666;

text-shadow: 1px 1px 1px rgba(200,200,200,1);

}

#top-content.page-title-width .left,

#top-content.page-title-width .right {

width: 50%;

}

#top-content .avatar img,

#top-content img.avatar {

-webkit-box-shadow: 0 0 10px rgba(0,0,0,1);

-moz-box-shadow: 0 0 10px rgba(0,0,0,1);

box-shadow: 0 0 10px rgba(0,0,0,1);

}

#top-content .sc-divider {

background: url(lib/images/divider.png) repeat-x left bottom;

margin: 30px 0;

border: 0;

height: 2px;

}

#top-content .widget {

font-size: 11px;

border: 0;

background: url(lib/images/divider.png) repeat-x left top;

padding: 20px 0;

margin: 0;

}

#top-content .widget li {

line-height: 16px;

}

#top-content .widget:first-child {

background: none;

padding-top: 0;

}

#top-content .widget:last-child {

padding-bottom: 0;

}



/* Page Title */

.page-title {

color: #fff;

margin: 0;

}



/* Post Meta */

.post-meta {

margin-top: 5px;

font-size: 11px;

}

.post-meta a:hover {

color: #fff;

}

.post-meta span {

display: inline;

line-height: 20px;

padding: 5px 0 5px 25px;

margin: 0 20px 0 0;

}

.author-icon {

background: url(lib/images/sprite.png) no-repeat -79px -67px;

}

.clock-icon {

background: url(lib/images/sprite.png) no-repeat -60px -90px;

}

.folder-icon {

background: url(lib/images/sprite.png) no-repeat -40px -116px;

}

.speech-icon {

background: url(lib/images/sprite.png) no-repeat -19px -138px;

}

.tag-icon {

background: url(lib/images/sprite.png) no-repeat 0 -157px;

}



/* Breadcrumbs */

#breadcrumbs {

float: right;

color: #666;

font-weight: bold;

font-size: 11px;

line-height: 15px;

margin-top: 10px;

}

#breadcrumbs a {

font-weight: normal;

}

#breadcrumbs a:hover {

color: #4DB3A2;

}



/* Search Form */

#top-content #searchform {

position: relative;

float: right;

margin: 0 0 0 20px;

padding: 7px 15px;

border-bottom-width: 1px;

border-style: solid;

-webkit-box-shadow: inset 1px 1px 5px rgba(0,0,0,0.1);

-moz-box-shadow: inset 1px 1px 5px rgba(0,0,0,0.1);

box-shadow: inset 1px 1px 1px rgba(0,0,0,0.1);

-webkit-border-radius: 8px;

-moz-border-radius: 8px;

border-radius: 8px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

#top-content #searchbar {

float: left;

width: 100%;

background: none;

border: 0;

margin: 2px 0 0;

padding: 0 25px 0 0;

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content #searchsubmit {

position: absolute;

top: 7px;

right: 15px;

width: 15px;

height: 17px;

background-color: transparent !important;

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

text-indent: -9999px;

border: 0;

padding: 0;

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

}

#top-content #searchsubmit:hover {

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

}





/************************************ Page/Post Styling ************************************/



/* Posts */

.post-loop {

float: left;

width: 100%;

position: relative;

margin-top: 40px;

}

.spacing-small .post-loop {

margin-top: 20px;

}

.ie8 .spacing-small .post-loop {

margin-top: 5px;

}

.post-loop:first-child {

margin-top: 0;

}

.post-loop.post-columns {

margin: 20px 0 20px 4%;

}

.spacing-small .post-loop.post-columns {

margin: 10px 0 10px 4%;

}

.post-loop.first-column {

margin: 20px 0 20px 0;

}

.spacing-small .post-loop.first-column {

margin: 10px 0 10px 0;

}

.post-text h2 {

font-size: 26px;

margin-bottom: 10px;

}

.spacing-small .post-text h2 {

font-size: 12px;

margin-bottom: 5px;

}

.sticky {

}



/* Post Thumbnail */

.post-thumbnail {

float: left;

max-width: 100%;

line-height: 0;

position: relative;

overflow: hidden;

margin-bottom: 20px;

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.spacing-small .post-thumbnail {

margin-bottom: 10px;

}

.post-thumbnail.wrap {

margin: 0 20px 0 0;

}

.spacing-small .post-thumbnail.wrap {

margin: 0 10px 0 0;

}



/* Post Meta */

#content .post-meta {

width: 100%;

margin: 0 0 15px 0;

}

#content .post-meta.post-tags {

margin: 0 0 20px 0;

}

#content .post-wrapper .post-meta.post-tags {

margin: 0;

}

#content .post-meta,

#content .post-meta a {

color: #666;

}

#content .post-meta a:hover {

color: #999;

}



/* Post Content */

#post-content {

margin-bottom: 20px;



}

label[for*="pwbox"] {

float: left;

display: inline;

margin: 0 10px 0 0;

}



/* Attachments */

.attachment p {

margin-top: 12px;

}





/************************************ Lightbox ************************************/



.hover-image, 

.hover-video {

display: block;

position: absolute;

z-index: 10;

width: 100%;

height: 100%;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

cursor: pointer;

}

.hover-image {

background: url(lib/images/lightbox-image.png) no-repeat center center;

}

.hover-video {

background: url(lib/images/lightbox-video.png) no-repeat center center;

}

img:hover .hover-image, 

img:hover .hover-video {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=80);

opacity: 0.8;

}

.pp_gallery li {

background: none;

border: 0;

padding: 0;

}

.pp_gallery li.jwplayer a {

background: url(lib/scripts/prettyPhoto/images/prettyPhoto/default/default_thumb.png) no-repeat;

width: 50px;

height: 33px;

display: block;

}

.html5player {

width: 100%;

height: 100%;

}





/************************************ Shortcodes: Accordion ************************************/



.accordion .panel {

position: relative;

width: 100%;

margin-bottom: 10px;

overflow: hidden;

}

h3.accordion-title {

font-family: 'Lato', sans-serif;

font-size: 18px;

background-image: url(lib/images/sprite.png);

background-position: -100px -249px;

background-repeat: no-repeat;

padding: 0 0 10px 21px;

margin: 0;

}

h3.ui-state-active.accordion-title {

background-position: -80px -282px;

}

.panel-content {

padding: 0 0 20px 20px;

line-height: 19px;

}





/********************************************* Shortcodes: Activity Stream *********************************************/



#top-content .gp-activity-stream #activity-stream {

border: 0;

}

.gp-activity-stream .acomment-reply {

display: none !important;

}

.gp-activity-stream .load-more {

display: none;

}

.hide-activity-comments .activity-inreplyto,

.hide-activity-comments .activity-comments {

display: none;

}

.gp-activity-stream .wp-pagenavi {

width: 100%;

}

#top-content .gp-activity-stream .wp-pagenavi {

font-size: 11px;

}

.gp-activity-stream .pages {

float: left;

}

.gp-activity-stream .pagination-links {

float: right;

}





/************************************ Shortcodes: Author Info ************************************/



.author-info {

float: left;

position: relative;

width: 100%;

padding: 20px;

margin: 0 0 20px 0;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.sb-left .author-info {

float: right;

margin: 20px -48px 20px 0;

}

.frame .author-info {

margin: 20px 0 20px -48px;

-webkit-border-radius: 0 4px 4px 4px;

-moz-border-radius: 0 4px 4px 4px;

border-radius: 0 4px 4px 4px;

}

.author-info-fold {

display: none;

position: absolute;

top: -8px;

left: 0;

background: url(lib/images/author-info-fold.png) no-repeat;

width: 8px;

height: 8px;

}

.sb-left .author-info-fold {

left: auto;

right: 0;

-moz-transform: scaleX(-1);

-o-transform: scaleX(-1);

-webkit-transform: scaleX(-1);

transform: scaleX(-1);

filter: FlipH;

-ms-filter: "FlipH";

}

.frame .author-info-fold {

display: block;

}

.author-info .avatar {

float: left;

margin-right: 20px;

width: 50px;

height: 50px;

}

.author-info .author-meta {

margin-left: 80px;

}

.author-info .author-meta-top {

width: 100%;

float: left;

}

.author-info .author-name {

float: left;

color: #fff;

margin-bottom: 10px;

font-weight: bold;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

}

.author-info .author-links {

float: right;

font-size: 11px;

margin-bottom: 10px;

}

.author-info .author-links a {

color: #fff;

margin: 0 2px;

}

.author-info .author-desc {

line-height: 19px;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

}





/************************************ Shortcodes: Blockquotes ************************************/



blockquote {

font-size: 14px;

margin: 5px 20px 10px 20px;

padding: 10px 0 5px 25px;

overflow: hidden;

}

blockquote p {

line-height: 23px;

}

.blockquote-left {

float: left;

margin: 10px 20px 20px 0;

}

.blockquote-right {

float: right;

margin: 10px 0 20px 20px;

}

.blockquote-left,

.blockquote-right {

width: 30%;

font-size: 14px;

line-height: 23px;

padding: 10px 0 5px 25px;

}





/************************************ Shortcodes: Buttons ************************************/



/* Buttons */

.sc-button,

.sc-button:hover {

position: relative;

max-width: 100%;

border-top-width: 1px;

border-style: solid;

display: inline-block;

margin: 5px;

font-weight: bold;

-moz-border-radius: 40px;

-webkit-border-radius: 40px;

border-radius: 40px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow:  0 0 5px rgba(0,0,0,0.3);

}

.sc-button.small {

font-size: 11px;

line-height: 11px;

padding: 8px 12px;

}

.sc-button.medium {

font-size: 12px;

line-height: 12px;

padding: 12px 20px;

}

.sc-button.large {

font-size: 14px;

line-height: 14px;

padding: 15px 60px;

}

.columns.button-divider {

background: url(lib/images/divider.png) left center repeat-x;

}



/* Yellow Button */

.yellow.sc-button {

color: #5e471d !important;

text-shadow: 1px 1px 1px rgba(255,255,255,0.8);

border-color: #fff5d8;

background-color: #fcd971;

background-image: -moz-linear-gradient(#fcd971, #fbbd4e);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fcd971), to(#fbbd4e));

background-image: -webkit-linear-gradient(#fcd971, #fbbd4e);

background-image: -o-linear-gradient(#fcd971, #fbbd4e);

background-image: -ms-linear-gradient(#fcd971, #fbbd4e);

-pie-background: linear-gradient(#fcd971, #fbbd4e);

}

.yellow.sc-button:hover {

color: #5e471d !important;

background: #fbbd4e;

}



/* Grey */

.grey.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #838383;

background-color: #5c5c5c;

background-image: -moz-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#5c5c5c), to(#3d3d3d));

background-image: -webkit-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -o-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -ms-linear-gradient(#5c5c5c, #3d3d3d);

-pie-background: linear-gradient(#5c5c5c, #3d3d3d);

}

.grey.sc-button:hover {

color: #fff !important;

background: #3d3d3d;

}



/* Dark Grey Button */

.darkgrey.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #666;

background-color: #404040;

background-image: -moz-linear-gradient(#404040, #202020);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#404040), to(#202020));

background-image: -webkit-linear-gradient(#404040, #202020);

background-image: -o-linear-gradient(#404040, #202020);

background-image: -ms-linear-gradient(#404040, #202020);

-pie-background: linear-gradient(#404040, #202020);

}

.darkgrey.sc-button:hover {

color: #fff;

background: #202020;

}



/* Brown Button */

.brown.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #837268;

background-color: #685950;

background-image: -moz-linear-gradient(#685950, #453B35);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#685950), to(#453B35));

background-image: -webkit-linear-gradient(#685950, #453B35);

background-image: -o-linear-gradient(#685950, #453B35);

background-image: -ms-linear-gradient(#685950, #453B35);

-pie-background: linear-gradient(#685950, #453B35);

}

.brown.sc-button:hover {

color: #fff;

background: #453B35;

}



/* Blue Button */

.blue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #71c6ed;

background-color: #96d1f8;

background-image: -moz-linear-gradient(#09b0fe, #258df8);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#09b0fe), to(#258df8));

background-image: -webkit-linear-gradient(#09b0fe, #258df8);

background-image: -o-linear-gradient(#09b0fe, #258df8);

background-image: -ms-linear-gradient(#09b0fe, #258df8);

-pie-background: linear-gradient(#09b0fe, #258df8);

}

.blue.sc-button:hover {

color: #fff;

background: #258df8;

}



/* Medium Blue Button */

.mediumblue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #748894;

background-color: #505f68;

background-image: -moz-linear-gradient(#505f68, #353f45);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#505f68), to(#353f45));

background-image: -webkit-linear-gradient(#505f68, #353f45);

background-image: -o-linear-gradient(#505f68, #353f45);

background-image: -ms-linear-gradient(#505f68, #353f45);

-pie-background: linear-gradient(#505f68, #353f45);

}

.mediumblue.sc-button:hover {

color: #fff !important;

background: #353f45;

}



/* Dark Blue Button */

.darkblue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #4d5b64;

background-color: #364046;

background-image: -moz-linear-gradient(#364046, #15191b);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#364046), to(#15191b));

background-image: -webkit-linear-gradient(#364046, #15191b);

background-image: -o-linear-gradient(#364046, #15191b);

background-image: -ms-linear-gradient(#364046, #15191b);

-pie-background: linear-gradient(#364046, #15191b);

}

.darkblue.sc-button:hover {

color: #fff !important;

background: #15191b;

}



/* Lime Green Button */

.limegreen.sc-button {

color: #4C5629 !important;

text-shadow: 1px 1px 1px rgba(255,255,255,0.8);

border-color: #eaf5bc;

background-color: #d2e68d;

background-image: -moz-linear-gradient(#d2e68d, #94bd44);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#d2e68d), to(#94bd44));

background-image: -webkit-linear-gradient(#d2e68d, #94bd44);

background-image: -o-linear-gradient(#d2e68d, #94bd44);

background-image: -ms-linear-gradient(#d2e68d, #94bd44);

-pie-background: linear-gradient(#d2e68d, #94bd44);

}

.limegreen.sc-button:hover {

color: #4C5629 !important;

background: #94bd44;

}



/* Teal Button */

.teal.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #BACAC8;

background-color: #8CA6A3;

background-image: -moz-linear-gradient(#8CA6A3, #6A8A87);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#8CA6A3), to(#6A8A87));

background-image: -webkit-linear-gradient(#8CA6A3, #6A8A87);

background-image: -o-linear-gradient(#8CA6A3, #6A8A87);

background-image: -ms-linear-gradient(#8CA6A3, #6A8A87);

-pie-background: linear-gradient(#8CA6A3, #6A8A87);

}

.teal.sc-button:hover {

color: #fff !important;

background: #6A8A87;

}



/* Dark Green Button */

.darkgreen.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #5a7b85;

background-color: #366a7b;

background-image: -moz-linear-gradient(#366a7b, #23444b);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#366a7b), to(#23444b));

background-image: -webkit-linear-gradient(#366a7b, #23444b);

background-image: -o-linear-gradient(#366a7b, #23444b);

background-image: -ms-linear-gradient(#366a7b, #23444b);

-pie-background: linear-gradient(#366a7b, #23444b);

}

.darkgreen.sc-button:hover {

color: #fff !important;

background: #23444b;

}



/* Red Button */

.red.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #c2464c;

background-color: #93063b;

background-image: -moz-linear-gradient(#b03238, #940a11);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#b03238), to(#940a11));

background-image: -webkit-linear-gradient(#b03238, #940a11);

background-image: -o-linear-gradient(#b03238, #940a11);

background-image: -ms-linear-gradient(#b03238, #940a11);

-pie-background: linear-gradient(#b03238, #940a11);

}

.red.sc-button:hover {

color: #fff !important;

background: #940a11;

}



/* Dark Red Button */

.darkred.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #957578;

background-color: #685053;

background-image: -moz-linear-gradient(#685053, #453537);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#685053), to(#453537));

background-image: -webkit-linear-gradient(#685053, #453537);

background-image: -o-linear-gradient(#685053, #453537);

background-image: -ms-linear-gradient(#685053, #453537);

-pie-background: linear-gradient(#685053, #453537);

}

.darkred.sc-button:hover {

color: #fff !important;

background: #453537;

}



/* Orange Button */

.orange.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #f0a33e;

background-color: #ee8600;



background-image: -moz-linear-gradient(#ee8600, #b25f0f);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#ee8600), to(#b25f0f));

background-image: -webkit-linear-gradient(#ee8600, #b25f0f);

background-image: -o-linear-gradient(#ee8600, #b25f0f);

background-image: -ms-linear-gradient(#ee8600, #b25f0f);

-pie-background: linear-gradient(#ee8600, #b25f0f);

}

.orange.sc-button:hover {

color: #fff !important;

background: #b25f0f;

}





/************************************ Shortcodes: Captions ************************************/



.wp-caption {

position: relative;

padding: 0;

max-width: 100%;

}

.wp-caption img {

margin: 0;

}

.wp-caption-text {

margin: 5px 0 0;

font-size: 11px;

color: #666;

}





/************************************ Shortcodes: Columns ************************************/



/* General */

.columns {

float: left;

position: relative;

line-height: 19px;

margin-right: 4%;

}

.one {

width: 100%;

}

.two {

width: 48%;

}

.three {

width: 30.66%;

}

.four {

width: 22%;

}

.five {

width: 16.8%;

}

.onethird {

width: 32.64%;

}

.twothirds {

width: 63.36%;

}

.onefourth {

width: 24%;

}

.threefourths {

width: 72%;

}



/* Separate Columns */

.separate > div {

border: 1px solid #eee;

background: #fff;

position: relative;

padding: 20px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

}



/* Joint Columns */

.columns.joint {

margin: 0;

}

.joint > div {

border-width: 0 0 0 1px;

border-color: #eee;

border-style: solid;

position: relative;

padding: 20px;

}

.first.joint > div {

border-left-width: 0;

}

.one.joint {

width: 100%;

}

.two.joint {

width: 50%;

}

.three.joint {

width: 287px;

}

.middle.three.joint {

width: 326px;

}

.columns .three.joint,

.padding .three.joint {

width: 33% !important;

padding: 0;

}

.four.joint {

width: 25%;

}

.five.joint {

width: 20%;

}

.onethird.joint {

width: 33.33%;

}

.twothirds.joint {

width: 66.33%;

}

.onefourth.joint {

width: 25%;

}

.threefourths.joint {

width: 75%;

}



.last {

clear: right;

margin-right: 0;

}





/************************************ Shortcodes: Contact Form ************************************/

#content .padder{margin-bottom:20px;}

#contact-form {

float: left;

width: 100%;

margin-bottom: 12px;

}

#contact-form label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#contact-form .contact-verify {

float: left;

margin-right: 10px;

}

#contact-form .contact-verify label {

float: left;

margin: 10px 10px 0 0;

}

#contact-form .contact-submit {

float: left;

}

.required {

color: #3596ae;

}

#contact-form .loader {

display: none;

background: url(lib/images/loader.gif) no-repeat right bottom;

float: left;

padding: 4px 0 0 10px;

width: 16px;

height: 16px;

}

.contact-form.notify {

padding: 5px 10px;

margin-bottom: 10px;



}

#contact-form .input-error {

border: 1px solid #FBC2C4;

}





/************************************ Shortcodes: Dividers ************************************/



.sc-divider {

content: "";

border-top: 1px solid #ddd;

clear: both;

width: 100%;

height: 1px;

padding: 0;

margin: 40px 0;

position: relative;

}

.frame .sc-divider {

border-color: #eee;

}

.sc-divider.top a {

font-size: 10px;

float: right;

position: absolute;

top: -20px;

right: 0;

color: #999;

text-align: right;

cursor: pointer;

}

.sc-divider.small {

margin: 0;

}

.sc-divider.clear {

background: none !important;

border: 0;

margin: 20px 0 !important;

}

.sc-divider.small.clear {

border: 0;

margin: 0 !important;

}





/************************************ Shortcodes: Drop Caps ************************************/



.dropcap1 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 0 10px -8px 0;

padding: 0;

text-align: center;

}

.dropcap2 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

background: #eee;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.dropcap3 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

color: #999;

background: #404040;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.dropcap4 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

background: #eee;

-webkit-border-radius: 25px;

-moz-border-radius: 25px;

border-radius: 25px;

}

.dropcap5 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

color: #999;

background: #404040;

-webkit-border-radius: 25px;

-moz-border-radius: 25px;

border-radius: 25px;

}





/************************************ Shortcodes: Galleries ************************************/



.gallery-columns-1 .gallery-item {

width: 90%;

}

.gallery-columns-2 .gallery-item {

width: 45% !important;

padding-right: 4% !important;

}

.gallery-columns-3 .gallery-item {

width: 31% !important;

padding-right: 2% !important;

}

.gallery-columns-4 .gallery-item {

width: 23% !important;

padding-right: 2% !important;

}

.gallery-columns-5 .gallery-item {

width: 18% !important;

padding-right: 2% !important;

}

.gallery-columns-6 .gallery-item {

width: 14% !important;

padding-right: 2% !important;

}

.gallery-columns-7 .gallery-item {

width: 12% !important;

padding-right: 2% !important;

}

.gallery-columns-8 .gallery-item {

width: 10% !important;

padding-right: 2% !important;

}

.gallery-columns-9 .gallery-item {

width: 9% !important;

padding-right: 2% !important;

}

.gallery-item img {

max-width: 100% !important;

height: auto !important;

border: 0 !important;

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.gallery-caption {

float: left;

margin: 10px 0;

line-height: 14px;

}

div.gallery-item .gallery-icon {

display: inline-block;

position: relative;

width: 100%;

}

.gallery-item a, .gallery-caption {

width:100%;

}





/************************************ Shortcodes: Images ************************************/



/* Image */

.sc-image {

line-height: 0;

max-width: 100%;

height: auto !important;

}

.sc-image img {

max-width: 100%;

height: auto !important;

width: auto\9;

}

.sc-image a {

display: block;

margin: 0 auto;

}

.sc-image.aligncenter {

margin: 0 auto;

text-align: center;

}



.sc-image.alignleft {

margin: 0;

}

.sc-image.alignright {

margin: 0;

}

.sc-image.image-border {

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}





/************************************ Shortcodes: Lists ************************************/



.circle li {

background-position: -92px -402px;

}

.square li {

background-position: -72px -423px;

}

.tick li {

background-position: -50px -443px;

}

.large-tick li {

font-family: 'Lato', sans-serif;

font-weight: 300;

font-size: 18px;

margin-top: 20px;

padding-left: 25px;

background-position: -21px -463px;

}

.large-cross li {

font-family: 'Lato', sans-serif;

font-weight: 300;

font-size: 18px;

margin-top: 20px;

padding-left: 25px;

background-position: 0 -486px;

}





/************************************ Shortcodes: Login/Register Forms ************************************/



#loginform,

#registerform {

float: left;

margin: 0;

}

#loginform label,

#registerform label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#loginform .login-remember label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

padding: 0;

}





/************************************ Shortcodes: Notifications ************************************/



.notify {

position: relative;

margin: 10px 0;

-moz-border-radius: 4px;

-webkit-border-radius: 4px;

border-radius: 4px;

display: block;

line-height: 19px;

padding: 20px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

}

.notify-default {

color: #57481c;

background-color: #FFDF75;

}

.notify-help {

color: #184366;

background-color: #5FA6E5;

}

.notify-success {

color: #566621;

background-color: #B3D46F;

}

.notify-warning {

color: #6b3b17;

background-color: #E78F4B;

}

.notify-error {

color: #571111;

background-color: #D84F4F;

}





/************************************ Shortcodes: Price Box ************************************/



.sc-price-box {

text-align: center;

max-width: 100% !important;

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.5);

box-shadow: 0 0 10px rgba(0,0,0,0.5);

-webkit-border-radius: 8px;

-moz-border-radius: 8px;

border-radius: 8px;

}

.sc-price-box-inner {

padding: 20px 40px;

}

.sc-price-box-title {

font-family: 'Raleway', sans-serif;

font-size: 30px;

line-height: 30px;

color: #fff;

margin-bottom: 20px;

}

.sc-price-box .left {

text-align: center;

width: 100%;

}

.sc-price-box-price {

font-family: 'Raleway', sans-serif;

font-size: 90px;

line-height: 90px;

color: #fff;

}

.sc-price-box-unit {

font-family: 'Raleway', sans-serif;

font-size: 18px;

color: #fff;

}

.sc-price-divider {

float: left;

clear: both;

border-width: 1px 0;

border-style: solid;

height: 0;

width: 100%;

margin: 20px 0;

}

.sc-price-box-content {

float: left;

font-size: 12px;

line-height: 23px;

margin-bottom: 20px;

}

.sc-price-box-button {

float: left;

width: 100%;

text-align: center;

}





/************************************ Shortcodes: Pricing Table ************************************/



.sc-pricing-table table {

width: 100%;

}

.sc-pricing-table thead th {

font-family: 'Raleway', sans-serif;

text-align: center;

font-size: 28px;

color: #fff;

padding: 2%;

border-left-width: 1px;

border-style: solid;

}

.ie8 .sc-pricing-table thead th {

padding: 10px;

-pie-background: none;

}

.sc-pricing-table thead th:first-child {

border: 0;

background: none;

-pie-background: none;

}

.sc-pricing-table thead th.first {

border: 0;

-webkit-border-radius: 4px 0 0;

-moz-border-radius: 4px 0 0;

border-radius: 4px 0 0;

}

.sc-pricing-table thead th.last {

-webkit-border-radius: 0 4px 0 0;

-moz-border-radius: 0 4px 0;

border-radius: 0 4px 0 0;

}

.sc-pricing-table tfoot th {

border-top: 1px solid #eee;

text-align: center;

padding: 2% 0 0 0;

}

.sc-pricing-table .price {

font-size: 15px;

}

.sc-pricing-table tr {

background: #fff;

}

.sc-pricing-table tr:nth-child(even) {

background: #f8f8f8;

}

.sc-pricing-table thead tr,

.sc-pricing-table tfoot tr {

background: none;

}

.sc-pricing-table tr td {

text-align: center;

padding: 2% 1%;

border-width: 1px 1px 0 0;

border-style: solid;

border-color: #eee;

}

.sc-pricing-table tr td:first-child {

text-align: left;

border-left-width: 1px;

font-weight: bold;

}

.sc-pricing-table tr td .yes {

display: block;

margin: 0 auto;

width: 20px;

height: 13px;

background: url(lib/images/sprite.png) no-repeat -21px -467px;

}

.sc-pricing-table tr td .no {

display: block;

margin: 0 auto;

width: 15px;

height: 13px;

background: url(lib/images/sprite.png) no-repeat 0 -490px;

}







/************************************ Shortcodes: Related Posts ************************************/



/* Related Posts Container */

.related-posts {

float: left;

width: 100%;

margin-top: 20px;

}

.related-posts h3 {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 10px 0;

margin: 0;

}

.frame .related-posts h3 {

border-color: #eee;

}

.related-posts h2 {

font-size: 12px;

font-weight: bold;



font-family: Helvetica, Arial, sans-serif;

}





/************************************ Shortcodes: Slider ************************************/



/* Slider */

.flexslider {

position: relative;

width: 100%;

max-width: 100%;

margin: 0;

padding: 0;

zoom: 1;

}

.flexslider.aligncenter {

margin: 0 auto;

}



/* Slides */

.flexslider .slides {

zoom: 1;

}

.flexslider .slides > li {

position: relative;

list-style-type: none;

background: none;

display: none;

-webkit-backface-visibility: hidden;

margin: 0;

padding: 0;

}

.slides:after {

content: ".";

display: block;

clear: both;

visibility: hidden;

line-height: 0;

height: 0;

}

html[xmlns] .slides {

display: block;

}

* html .slides {

height: 1%;

}

.no-js .slides > li:first-child {

display: block;

}

.flexslider .slides img {

max-width: 100%;

display: block;

}

.flexslider.shadow .slides img,

.flexslider.shadow .slides .slide-video {

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.5);

box-shadow: 0 0 10px rgba(0,0,0,0.5);

}



/* Slide Video */

.video-image {

position: absolute;

top: 0;

left: 0;

z-index: 9;

display: block;

width: 100%;

height: 100%;

}

.video-autostart .video-image {

display: none !important;

}

.video-button {

position: absolute;

z-index: 9;

top: 0;

left: 0;

display: block;

background: url(lib/scripts/mediaplayer/fs39/display/playIcon.png) no-repeat center center;

cursor: pointer;

width: 100%;

height: 100%;

}

.video-player {

display: none;

}



/* Slide Caption */

.caption {

padding: 20px 20px 10px 20px;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

line-height: 19px;

position: absolute;

z-index: 10;

max-width: 60%;

max-height: 50%;

overflow: hidden;

}

.caption h2 {

font-family: 'Lato', sans-serif;

color: #fff;

font-size: 20px;

margin-bottom: 10px;

}

.caption p:first-child {

margin-bottom: 10px;

}

.caption.caption-topleft {

top: 20px;

left: 0;

}

.caption.caption-topright {

top: 20px;

right: 0;

}

.caption.caption-bottomleft {

bottom: 20px;

left: 0;

}

.caption.caption-bottomright {

bottom: 20px;

right: 0;

}



/* Slider Prev/Next */

.flex-direction-nav {

list-style: none;

background: none;

overflow: hidden;

margin: 5px 0 0 0;

padding: 0;

}

.flex-direction-nav li {

background: none;

display: inline-block;

list-style: none;

background: none;

margin: 0;

padding: 0;

}

.flex-direction-nav li a {

float: left;

position: relative;

text-indent: -9999px;

z-index: 11;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

width: 12px;

height: 12px;

cursor: pointer;

margin-right: 5px;

}

.flex-direction-nav li .flex-prev {

background: url(lib/images/sprite.png) no-repeat 0 -316px;

}

.flex-direction-nav li .flex-next {

background: url(lib/images/sprite.png) no-repeat -30px -316px;

}

.flex-direction-nav li .flex-prev:hover,

.flex-direction-nav li .flex-next:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}



/* Slider Buttons */

.flex-control-nav {

position: relative;

list-style: none;

background: none;

margin: 5px 0 0 0;

float: right;

}

.flex-control-nav li {

display: inline-block;

list-style: none;

background: none;

margin: 0;

padding: 0;

}

.flex-control-nav li a {

text-indent: -9999px;

float: left;

background: url(lib/images/sprite.png) no-repeat -60px -316px;

margin: 0 3px;

width: 12px;

height: 12px;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

cursor: pointer;

}

.flexslider:hover .flex-control-nav li a {

display: block;

}

.flex-control-nav li .flex-active,

.flex-control-nav li a:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}





/************************************ Shortcodes: Tabs ************************************/



.ui-tabs {

position: relative;

padding: 0;

top: -4px;

zoom: 1;

}

.ui-tabs .ui-tabs-nav {

display: block;

margin: 0;

padding: 0;

}

.ui-tabs .ui-tabs-nav li { 

z-index: 1;

background-image: none;

list-style: none;

background: none;

float: left;

position: relative;

top: 1px;

margin: 0;

border-bottom-width: 0;

padding: 0;

white-space: nowrap;

border: 0;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content .ui-tabs .ui-tabs-nav li {

top: 0;

}

.ui-tabs .ui-tabs-nav li a {

float: left;

font-weight: bold;

padding: 10px;

text-decoration: none;

}

.ui-tabs .ui-tabs-nav li.ui-state-active { 

z-index: 3;

border: 1px solid #eee;

background: #fff;

border-bottom-color: #fff;

}

#top-content .ui-tabs .ui-tabs-nav li.ui-state-active {

background: rgba(0,0,0,0.2);

border: 0;

}

.ui-tabs .ui-tabs-nav li.ui-state-active a,

.ui-tabs .ui-tabs-nav li.ui-state-disabled a,

.ui-tabs .ui-tabs-nav li.ui-state-processing a {

cursor: text;

color: #000;

}

.ui-tabs .ui-tabs-nav li.ui-state-hover a {

color: #000;

}

.ui-tabs .ui-tabs-nav li a,

.ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-state-active a {

color: #999;

cursor: pointer;

} 

.ui-tabs-nav .tabhead {

cursor:pointer;

font-size: 12px;

margin-bottom: 0;

display: block;

}

.sc-tab-panel {

z-index: 2;

width: 100%;

background: #fff;

position: relative;

height: inherit;

line-height: 19px;

overflow: hidden;

margin: 0 0 10px 0;

padding: 15px;

border: 1px solid #eee;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content .sc-tab-panel {

background: rgba(0,0,0,0.2);

border: 0;

}

.ui-tabs .ui-tabs-hide {

display: none !important;

position: absolute;

left: -10000px;

}





/************************************ Shortcodes: Text Boxes ************************************/



.text-box {

width: 100%;

max-width: 100%;

display: inline-block;

font-size: 14px;

line-height: 19px;

}

#content .text-box {

color: #000;

}

.text-box p {

line-height: inherit;

}

.text-box .testimonial-name {

font-weight: bold;

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}

.text-box .testimonial-company {

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}

.text-box .testimonial-comma {

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}





/************************************ Shortcodes: Toggle Box ************************************/



h3.toggle {

font-family: 'Lato', sans-serif;

font-size: 18px;

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

background-position: -140px -192px;

padding: 0 0 10px 21px;

margin: 0;

cursor: pointer;

}

h3.toggle a {

display: block;

}

h3.toggle-active {

background-position: -120px -221px;

}

.toggle-box {

clear:both;

margin: 0 0 10px 0;

overflow: hidden;

}

.no-js .toggle-box {

display: block !important;

}





/************************************ Shortcodes: Video ************************************/



.sc-video,

.sc-video div {

max-width: 100%;

}

.sc-video.aligncenter {

text-align: center;

}





/************************************ Footer ************************************/



/* Footer Container */

#footer {

display: inline-block;

text-align: left;

margin: 65px auto 0 auto;

width: 100%;

text-shadow: 1px 1px 1px rgba(255,255,255,1);

}



/* Footer Widgets */

#footer-widgets {

float: left;

width: 100%;

position: relative;

}

.footer-widget-outer .widgettitle {

font-family: Helvetica, "Lucida Sans Unicode", "Lucida Grande", Arial;

font-size: 12px;

font-weight: bold;

margin-bottom: 15px;

}

.footer-widget-outer {

float: left;

margin-left: 4%;

color: #989898;

}

.footer-widget-inner {

float: left;

width: 100%;

margin-bottom: 30px;

}

#footer-widgets div:first-child {

margin-left: 0;

}

.footer-whole {

width: 100%;

}

.footer-half {

width: 22%;

}

.footer-third {

width: 30.66%;

}

.footer-fourth {

width: 22%;

}



/* Footer Forms */

.footer-fourth #searchbar {

width: 100px;

}

.footer-widget-inner textarea {

height: 75px;

}

.footer-fourth #contact-form .textfield {

width: 125px;

}



/* Copyright */

#copyright {
/*
padding: 30px 0 20px 0;
height:100px;*/
background: url("images/m_image2.png") no-repeat scroll center top rgba(0, 0, 0, 0);
color: #000000;
float: left;
font-size: 12px;
margin: 35px 0 60px;
padding: 40px 0;
text-align: center;
width: 100%;
}


#copyright2 #copyright{background: url("images/m_image.png") no-repeat scroll center top;  padding: 55px 0;}



#copyright a{color:#304F62}





/************************************ Widgets ************************************/



/* General Widget Styling */

.widget {

float: left;

width: 100%;

padding-top: 40px;

margin-top: 40px;

border-top: 1px solid #ddd;

}

.frame .widget {

border-color: #eee;

}

.widget:first-child {

border: 0;

padding: 0;

margin: 0;

}

.widget .widgettitle,

.widget .widgettitle a,

.widget .widgettitle a:hover {

color: #000;

font-family: 'Lato', sans-serif;

font-size: 20px;

line-height: 20px;

margin-bottom: 15px;

}

.textwidget {

line-height: 19px;

}



/* Calendar Widget */

#wp-calendar {

margin: 0 auto;

}

#wp-calendar th {

font-weight: bold;

padding: 5px;

text-align: center;

}

#wp-calendar td {

padding: 5px;

text-align: center;

}

#wp-calendar caption {

text-align: right;

font-weight: bold;

margin-bottom: 10px;

}



/* Search Widget */

#searchsubmit {

margin: 0 0 0 10px;

}



/* Custom Menus Widget */

.widget_nav_menu li {

background: none;

margin: 0;

padding: 0;

border-bottom: none;
position:relative;

}
.widget_nav_menu ul li ul {
    left: 45%;
    position: absolute;
    top: 0px;
	z-index:100;
}

.widget_nav_menu li:last-child,

.widget_nav_menu li:hover {

border-bottom:none;

}

.widget_nav_menu a {

display: block;

padding: 0;

line-height:20px

}



/*

.widget_nav_menu a:hover,

.widget_nav_menu .current-menu-item > a {

font-weight: bold;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;


-moz-border-radius: 4px;

border-radius: 4px;

}

.widget_nav_menu .sub-menu li {

margin-left: 20px;

}



*/





/************************************ Comments Section ************************************/



/* Comment List */

#comments {

float: left;

width: 100%;

margin-top: 20px;

}

.padding #comments {

padding: 0;

}

h3.comments {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 10px 0;

margin: 0;

}

.frame h3.comments {

border-color: #eee;

}

#commentlist,

#commentlist li {

list-style: none;

background: none;

margin: 0;

padding: 0;

}



/* Comment Box */

#commentlist .comment-box {

padding: 20px 0;

}

.comment-avatar {

float: left;

width: auto;

}

.comment-author {

font-weight: bold;

padding-bottom: 5px;

}

.comment-date {

color: #666;

font-size: 11px;

}

.comment-body {

margin-left: 90px;

}

.comment-text {

margin: 10px 0 0 0;

}

.reply-link {

height: 11px;

}

.reply-link a {

float: right;

font-size: 11px;

}



/* Child Comments */

#commentlist .children {

padding: 0;

margin: 0;

}

#commentlist .children .comment {

margin-left: 20px;

padding-left: 20px;

background: url(lib/images/comment-reply.png) no-repeat left top;

}

#commentlist .children .comment-avatar img {

width: 40px;

height: 40px;

}

#commentlist .children .comment-body {

margin-left: 70px;

}



/* Comment Post Author */

#commentlist .post-author {

position: relative;

line-height: 1;

font-size: 11px;

line-height: 11px;

margin-top: 10px;

padding: 3px;

text-align: center;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

color: #333;

border: 1px solid #e1ca82;

background-color: #ffeaa6;

background-image: -moz-linear-gradient(#fff2c9, #ffeaa7);

background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fff2c9), color-stop(100%,#ffeaa7));

background-image: -webkit-linear-gradient(#fff2c9, #ffeaa7);

background-image: -ms-linear-gradient(#fff2c9, #ffeaa7);

background-image: -o-linear-gradient(#fff2c9, #ffeaa7);

-pie-background: linear-gradient(#fff2c9, #ffeaa7);

display: none;

}

#commentlist .bypostauthor > .comment-box .post-author {

display: block;

}



/* Comment Form */

#commentform {

float: left;

width: 100%;

margin-top: 10px;

}

#respond {

margin: 10px 0 20px 0;

}

#respond h3 {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 20px 0;

margin: 0 0 20px 0;

}

.frame #respond h3 {

border-color: #eee;

}

#respond label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#respond textarea {

margin: 10px 0 0;

}

#cancel-comment-reply-link {

font-family: Helvetica, Arial, sans-serif;

float: right;

display: block;

font-size: 11px;

margin-top: 5px;

}





/************************************ Page Navigation ************************************/



/* Page & Comments Navigation */

.wp-pagenavi {

margin: 20px 0 0 0;

float: right;

}

.wp-pagenavi.post-navi {

margin: 0 0 20px 0;

}

.wp-pagenavi span,

.wp-pagenavi.cat-navi a,

.wp-pagenavi.comment-navi a,

.wp-pagenavi.post-navi a span {

display: block;

float: left;

padding: 5px 10px;

margin-left: 5px;

text-align: center;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

font-weight: bold;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.wp-pagenavi .current,

.wp-pagenavi.cat-navi a:hover,

.wp-pagenavi.comment-navi a:hover,

.wp-pagenavi .page:hover,

.wp-pagenavi.post-navi span,

.wp-pagenavi.post-navi a span:hover {

-webkit-box-shadow: 0 0 5px rgba(0,153,255,1);

-moz-box-shadow: 0 0 5px rgba(0,153,255,1);

box-shadow: 0 0 5px rgba(0,153,255,1);

}





.header-tour{color:#000000 !important; font:35px 'open_sansregular' !important; }




.avatar{

float:right;		
margin-right:20px;
}



.avatar_name{

float:left;

font-size:17px;		

color:#FFF;

margin-top:-18px;

font-family:'nunitoregular'

}

.drop_arrow {color: #FFFFFF; float: right; font-size: 20px; height: 36px; margin-right: 5px; margin-top: 2px; text-align: right; width: 45px; cursor:pointer;}



.drop_arrow span{ color:#fff;}
.drop_arrow .sub-nav-wrap {background-color: #acd373; border-radius:0 0 30px 30px; display: none; float: right; margin:12px -90px 0 0px; width:245px;}
.drop_arrow .sub-nav-wrap ul{margin:0; float: left; padding:0px;}

.drop_arrow .sub-nav-wrap ul li {background: none ; display: inline; float: left; margin: 0; padding: 0; position: relative; text-align: left; width: 100%;}

.drop_arrow .sub-nav-wrap ul li a {color: #707070; display: block;  float: left;  font-family: 'nunitolight'; font-size: 18px; height: auto; line-height: 9px; padding: 12px 25px 12px 25px; width: 80%;}
.drop_arrow .sub-nav-wrap ul li:first-child a {border-left-width: 0; border-radius: 8px 8px 0 0;}
.drop_arrow .sub-nav-wrap ul li a:hover{color:#000;}
.drop_arrow:hover .sub-nav-wrap{display:block;}
/*
#register-page .oneall_social_login {
    display: none;
}
*/


.avatar_image{float:right; margin-top:-30px; padding:5px;}
.bullet-icon{float:left; width:15%; text-align:left; margin-top:15px}
.bullet-icon a, .bullet-icon a:hover{font:14px/55px 'FontAwesome'; color:#cbcbcb; margin-left:10px;}
[class^="icon-"], [class*=" icon-"]{color:#cbcbcb;}
.center-heading{width:70%; float:left; text-align:center}
.skiptour{float:right; /* margin-top: 10px; */ width:10%; text-align:right; margin-top:15px }
.skiptour a, .skiptour a:hover{font:14px/55px 'open_sansregular'; color:#b5b5b5; }



.focus_text{
width:92%;
margin:0px auto;
text-align:center;
margin-bottom:17px;
border-bottom:1px solid #cdcdcd; }


.focus_text cite{text-align:center; width:100%; line-height:58px; margin-top:19px; font-size:32px; font-family: 'open_sanssemibold_italic'; color:#b92927;}



.clear{clear:both; float:none}

.cont-wrap{width:100%;}



.left-content{float:left; width:23%;}

#se_main
	{
		width:900px;
		margin:0 auto 250px auto;
		padding:70px 0px 0px 0px;
		}
	
#se_main li {
    background-image: none;
    float: left;
    margin: 0 30px;
    padding: 0;
    width: 243px;
}
	
#se_main li:first-child { margin-left:28px;}
#se_main li:last-child { margin-right:0;}
	

.se_getstart {
    color: #C5D3D6;
    float: left;
    font-size: 32px;
    margin-bottom: 16px;
    text-align: center;
    width: 100%;
}
	
	
.se_wanttoknowmore {
    color: #C5D3D6;
    float: left;
    font-size: 30px;
    letter-spacing: -2px;
    margin: 0 0 16px;
    padding-top: 1px;
    text-align: center;
    width: 100%;
}
	
.se_basicmem {
    color: #2E7E25;
    float: left;
    font-size: 28px;
    margin-bottom: 21px;
    text-align: center;
    width: 100%;
}
	
.se_learnabout {
    color: #187EBE;
    float: left;
    font-size: 28px;
    margin-bottom: 21px;
    text-align: center;
    width: 100%;
}



	
#se_main li:last-child .se_basicmem{color:#7e4f23;}
#se_main li:last-child .se_isfree{font-size:36px;}
.se_isfree {
    color: #2E7E25;
    float: left;
    font-size:41px;
    margin-bottom: 11px;
    text-align: center;
    width: 100%;
}
	
.se_isfree span
	{
	color:#7e4f23;
	}
	
	
.se_mostoursite {
    color: #313A3F;
    float: left;
    font-size: 15px;
    margin-bottom: 1px;
    text-align: center;
    width: 100%;
    margin-top: 4px;
}
	
.createaccount_button {
    float: left;
    padding: 10px 0 0;
    width: 100%;
}
	
.createaccount_button a {
	width:99%;
	float:left;
	font-weight: bold;
   border: 0.5px solid #2C6500;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0f4207));
   background: -webkit-linear-gradient(top, #94e241, #175d0c);
   background: -moz-linear-gradient(top, #94e241, #175d0c);
   background: -ms-linear-gradient(top, #94e241, #175d0c);
   background: -o-linear-gradient(top, #94e241, #175d0c);
   padding: 17px 0;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;

   -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: #FFFFFF;
   font-size: 20px;
   font-family: open_sansregular;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
 


   
   
   
   
.createaccount_button a:hover {
   background: #2c6500;
   color: #ffffff;
   }
.createaccount_button a:active {
   background: #343536;
   }
   
 
 
 .se_pricing {
    color: #187EBE;
    float: left;
    font-size: 41px;
    margin-bottom: 11px;
    text-align: center;
    width: 100%;
}
	
 
 .checkpricing_button
	{
		width:100%;
		float:left;
		padding:10px 0px 0px 0px;
	}  
 .checkpricing_button a {
	width:99%;
	font-weight: bold;
	float:left;
   border: 0.5px solid #0D7D9B;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0891bf));
   background: -webkit-linear-gradient(top, #78c6f4, #0891bf);
   background: -moz-linear-gradient(top, #78c6f4, #0891bf);
   background: -ms-linear-gradient(top, #78c6f4, #0891bf);
   background: -o-linear-gradient(top, #78c6f4, #0891bf);
   padding: 17px 0;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: white;
   font-size: 20px;
   font-family: open_sansregular;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
 
 
   
.checkpricing_button a:hover {
    background: #0d7d9b;
   color: #ffffff;
   }
.checkpricing_button a:active {
    background: #343536;
   }
   
   
  .takehealth_button
	{
		width:100%;
		float:left;
		padding:10px 0px 0px 0px;
	}  
 .takehealth_button a {
	width:99%;

	float:left;
   border:0.5px solid #72400E;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#bd8d5d), to(#6c3b1d));
   background: -webkit-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -moz-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -ms-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -o-linear-gradient(top, #bd8d5d, #6c3b1d);
    -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;

      -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: #fff;
   font-size: 20px;
   font-family: open_sansregular;
   font-weight: bold;
   padding: 17px 0;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
    
   
.takehealth_button a:hover {
    background: #72400e;
   color: #ffffff;
   }
.takehealth_button a:active {
    background: #343536;
   }





#answer-form p .wp32 {
    float: left;
    height: 48px;
    margin: 0 15px 0 0;
    padding: 13px 0 0 10px;
    width: 451px;
}
#answer-form img {
    float: left;
    height: 48px;
    margin-right: 15px;
    width: 48px;
}
#answer-form .qa-edit-submit {
    float: left;
    margin-top: 7px;
}


.qa-action-links > a {
    color: #BFBFBF;
    margin-right: 16px;
    text-transform: capitalize;
}
.qa-action-links {
    color: rgba(0, 0, 0, 0);
    margin-top: 15px;
}
.qa-action-links > a:hover {
    color: #FF6600;
    font-weight: bold;
}
#answer-list > h2 {
    color: #FF6600;
    font-size: 24px;
    margin: 0;
}
#answer-list {
    border-bottom: 1px solid #D7D7D7;
}


.healthy

	{

		width:88%;

		float:right;

		font-size:44px;

		line-height:50px;

		color:#313b41;

		font-family: 'open_sansregular';

		text-align:right;

		margin-bottom:39px;

		font-weight:600;

		margin-top:35px;

	}

.sign_up

	{

		width:90%;

		float:right;

		border-radius:3px;

		height:47px;

		background: -webkit-linear-gradient(0deg, #038aac, #05bcea); /* For Safari */

		background: -o-linear-gradient(0deg, #038aac, #05bcea); /* For Opera 11.1 to 12.0 */

		background: -moz-linear-gradient(0deg, #038aac, #05bcea); /* For Firefox 3.6 to 15 */

		background: linear-gradient(0deg, #038aac, #05bcea); /* Standard syntax (must be last) */

		border:1px solid #497629;

		/* box-shadow: inset 1px 1px 5px #000;

		box-shadow:1px 1px 5px #000; */

		font-size:21px;

		color:#ffffff;

		font-family: 'roboto_slabregular';

		/* text-shadow: 1px 1px 9px #e0fbcb; */

		line-height:44px;

		text-align:center;

		cursor:pointer;



	}

/* ///////   Q&A Pages CSS     ////////    */
.qa-left-side{float:left; width:33%; font-family: 'open_sansregular';}
.qa-left-side #sidebar{margin-left:0px;}
.qa-left-side .widget{border:0; margin:0px; padding:0px;}
.qa-left-side .avatar_image1{float:left; }
.qa-left-side .avatar_image1 img{width:57px; height:57px;}
.qa-left-side .avatar_name1{float:left; padding-left:10px; color:#737373; font-size:18px; line-height:3.5; font-weight:bold;  text-transform: capitalize; }
.qa-left-side #nav_menu-6{float:left; }
.qa-left-side #nav_menu-6 ul{float:left; }
.qa-left-side #nav_menu-6 ul li {display: inline;    float: left;    padding-left:12%;    width: 80%;}
.qa-left-side #nav_menu-6 ul li a {color: #35393C; float: left; font-size: 18px; line-height:26px; text-transform: capitalize;}
.qa-left-side #nav_menu-6 ul li a:hover{color:#3f902a; }

.qa-left-side .search-box{float:left; margin-top: 30px;}

.qa-left-side #question_categories-2 {float: left; margin-top: 36px;font-family: 'open_sansregular';}
.qa-left-side #question_categories-2  h2{color:#3f902a; font-family: 'open_sansregular';  font-weight:bold; font-size:22px;}

.qa-left-side #question_categories-2 ul{float:left; }
.qa-left-side #question_categories-2 ul li {display: inline; background:none;    float: left;    padding-left:5%; margin-bottom:0;    width: 90%;}
.qa-left-side #question_categories-2 ul li a {color: #35393C; float: left; font-size: 19px; line-height: 26px; text-transform: capitalize;}
.qa-left-side #question_categories-2 ul li a:hover{color:#3f902a; }

.qa-left-side #searchbar {margin-top: 28px;  width: 70%;}



.qa-right-side{float:right; width:66%;}
.qa-right-side #qa-page-wrapper{margin-left:0px;}


/* /////// End  Q&A Pages CSS     ////////    */
	
.slider{float:right; width:74%; margin-top:15px; border-radius:5px}



.tour{width:100%; float:left; background:#bcdf81; min-height:45px; margin-top:53px;  border-radius: 0 0 27px 27px; text-align:center}



.take_tour_btn{

display:inline-block;

	/*min-width:20%;*/
	padding:0px 40px;
	float:none;
	border-radius:26px;
	height:47px;
	background: -webkit-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Safari */
	background: -o-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Opera 11.1 to 12.0 */
	background: -moz-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Firefox 3.6 to 15 */
	background: linear-gradient(0deg, #ffee23, #fcfcc3); /* Standard syntax (must be last) */
	border:1px solid #497629;
	/* box-shadow: inset 1px 1px 5px #000;*/
	box-shadow:5px px 6px #000; 
	font-size:22px;
	line-height:45px;
	text-align:center;
	cursor:pointer;
	position:relative;
	z-index:1;
	margin-top: -25px;
	}





.take_tour_btn a, .take_tour_btn a:hover{color:#313b41;

	font-family: 'roboto_slabregular';}





.oneByOne1{box-shadow:1px 1px 10px #ccc;

		border:1px solid #e1e2e3;

		background:#FFFFFF;

		border-radius:5px}


#nav a#pull {
	display: none;
	color: #fff;
	font-family: "Times New Roman", Times, serif;
	font-size: 16px;
	font-weight:bold;
	text-align:left;
	z-index: 100;
}






.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:410px !important; border-radius:5px !important}

.peKenBurns.neutral .peKb_slides{background-color:#fff !important; box-shadow:1px 1px 10px #ccc; border:1px solid #e1e2e3; background:#FFFFFF; border-radius:5px !important}

.peKenBurns .peKb_slides .peKb_caption{width:100% !important;}

.peKenBurns .peKb_slides{padding:0px}

.peKenBurns .peKb_shadow{display:none}

.peKenBurns ul li{background:none !important}


.start-explore{text-align:center}

.start-explore h3{color:#323b42; margin-top:40px; font: 37px/70px 'open_sansregular'}

.createaccount{width:22%; background:green; display:inline-block; 

        background: -webkit-linear-gradient(0deg, #318025, #9edf4d); /* For Safari */

	background: -o-linear-gradient(0deg, #318025, #9edf4d); /* For Opera 11.1 to 12.0 */

	background: -moz-linear-gradient(0deg, #318025, #9edf4d); /* For Firefox 3.6 to 15 */

	background: linear-gradient(0deg, #318025, #9edf4d); /* Standard syntax (must be last) */

	border:1px solid #7e946e;

	/* box-shadow: inset 1px 1px 5px #000;*/

	box-shadow:5px px 6px #000; 

border-radius:3px;

margin-top:10px}



.createaccount a{color:#fff; font:17px/41px 'open_sansregular'; }

.createaccount a:hover{color:#fff}



.or{width: 52%; display:inline-block; margin-top:50px; background:url(images/arrow-red.png) no-repeat 97% 65%; margin-bottom:60px }



.or p{font:24px/32px 'open_sansregular'; color:#31383e; width:70%; float:left; text-align:right}

.or p:first-child{text-align:center; width:100%; margin-bottom:30px}





.connect-tour{width:85%; margin:0px auto; margin-bottom:25px}

.mobile-menu{display:none !important}















@media all and (max-width: 1280px) {

#header-left{width:20%}

#header-right{width:68%}

.oneByOne1{width:100%}

}

@media all and (max-width: 980px){
#header-inner{text-align: center;}
#header-left, #header-right{float:none; display: inline-block; }
#header-right{width:98%}
#header-left {width: 38%;}
.slider{width:72%}
#nav{margin-top:35px}

}







@media all and (max-width: 960px)

{

#content{float:none; text-align:center; width:100% !important }

.left-content{display: inline-block;; float:none !important; width:80%}

.slider{display: inline-block; float: none !important;  margin-top: 15px; width: 85%;}

.healthy{width:100%; text-align:center !important; float:none !important; font-size: 37px;}

.sign_up{display:inline-block; width:35%; float:none}
.bullet-icon, .skiptour, .center-heading{float:none; width:100%; text-align:center !important }
.bullet-icon a, .skiptour a{line-height:30px !important}
.bullet-icon{padding-top:10px}
.focus_text cite{margin-top:10px !important}
}





@media all and (max-width: 800px)

{

.or{background:none}

.or p{width:100%; text-align:center; margin-bottom: 10px;}

.createaccount{width:26%}

}











@media all and (max-width: 768px)

{

#nav li > a{font-size:16px}

#nav ul.menu, #nav ul.menu ul{margin: 1px 0 0 17px;}

.slider {width:83%}

#header-left {width: 100%;}

.take_tour_btn{margin-right:0px} 

.or{ margin-bottom: 0px;}

}


@media all and (max-width: 755px)

{
#nav{padding:0px !important; background:#c8e8fa !important}
#nav ul.menu {display: none;	height: auto; margin: 0px;}
#nav a#pull {display: block; background:url("images/nav-icon.png") no-repeat scroll 85% 10px; padding: 12px 10px; position: relative;	padding-left: 25px; text-decoration:none; width:100%; color:#2B3133; font-family:'open_sansregular'; text-transform: uppercase; font-size:15px}
#nav ul.menu{width:100%}
#nav ul.menu li {float:none; width:100%; display:block; }
#nav ul.menu li a {text-align:center; padding:15px}
.sub-menu{display:none !important}
#nav ul.menu li:hover .sub-menu{width:100%; display:block !important; position:relative; top:0px }
#nav ul.menu li:hover .sub-menu a{width:100%; display:block;}
.widget_nav_menu ul li:hover .sub-menu{display:block !important}
}




@media all  and (max-width: 640px){



.slider {width: 79%;}

.sign_up {width: 55%;}

#logo{width:100%; float:left;}

#logo a {
    background: url("http://mariasplace.com/wp-content/uploads/logo_maria.png") no-repeat scroll center top / 100% auto rgba(0, 0, 0, 0);
    height: 160px;
    margin: 0 auto;
    width: 363px;
    display: block;
	float:none;
}

#footer-widgets {float:none; text-align:center}

#footer-widgets > div{width:100%; display: inline-block;}

.footer-widget-inner {display: inline-block; float: none; width: 75%;}

.tour {margin-top:0px}

.take_tour_btn{ margin-right:0px !important; float:none !important} 

.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:300px !important}

.peKb_slides, .peKb_timer{height:250px !important; width:100% !important}

peKb_timer canvas{display:none}

.or{ margin-bottom: 15px;}

.createaccount {width: 35%;}

}


a.mlw_qmn_quiz_link {
font-size:1.2em !important;
}

div.mlw_qmn_quiz input[type=submit]{
font-size:1.2em !important;
}


@media all and (max-width: 480px){

.avatar {
    display: block !important;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 1000;
}
.drop_arrow:hover .sub-nav-wrap {display:block;}

.drop_arrow .sub-nav-wrap {
    background-color: #ACD373;
    border-radius: 0;
    display: none;
    float: right;
    margin: 12px -90px 0 0;
    width: 245px;
}


#nav a#pull{width:40%;}
#nav ul.menu{display:none;}

#nav ul.menu, #nav ul ul{margin:0;}

.focus_text{font-size:24px}

.slider {width: 86%;}

#header-left{width:60%}

.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:250px !important}

.peKb_slides, .peKb_timer{height:200px !important; width:100% !important}

.peKenBurns.neutral .peKb_timer{display:none !important}

peKb_mainPanel{margin-left:70px}



.createaccount {width: 51%;}

.or {width:80%}

.peKenBurns .peKb_controls{display:none !important;}

.healthy{margin-top:0px}

.focus_text cite, .header-tour{font-size:28px !important}

 #logo a {    background: url("http://mariasplace.com/wp-content/uploads/logo_maria.png") no-repeat scroll center top / 90% auto rgba(0, 0, 0, 0);    float: left;    height: 145px;    width: 100%;}

}







@media all and (max-width: 360px)

{

.slider {width: 86%;}
.healthy{font-size:25px; line-height:30px}
.sign_up {width: 94%;}
#header-left {width: 100%;}
.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:225px !important}
.peKb_slides, .peKb_timer{height:175px !important; width:100% !important}
.createaccount { width: 60%;}
.or p{font-size:22px}

}

@media all and (max-width: 320px){
#logo img{display:none;}
.slider {width:90%;}
.healthy{font-size:22px}
#header-left {width: 80%;}
#nav ul.menu{display:none;}
#se_main li:first-child {margin-left:0px;}
#se_main li:last-child {margin-bottom:50px;}

.se_mostoursite{margin-bottom:6px;}
#se_main .createaccount_button {float: none; padding: 10px 0 0; width:100%;}
#se_main .checkpricing_button {float: none; padding: 10px 0 0; width: 100%;}
#se_main .takehealth_button {float: none; padding: 10px 0 0; width: 100%;}
#se_main {margin: 0 auto; padding: 70px 0 0; width: 92%;}

#se_main li.se_columns {display: block; margin: 20px 0 20px; width: 100%;}

}

/************************************ BuddyPress ************************************/


#gp-theme-options a[href="#5"] {

display: none !important;

}



@font-face {
	font-family: 'icomoon';
	src:url('fonts/icomoon.eot?-ldfnid');
	src:url('fonts/icomoon.eot?#iefix-ldfnid') format('embedded-opentype'),
		url('fonts/icomoon.woff?-ldfnid') format('woff'),
		url('fonts/icomoon.ttf?-ldfnid') format('truetype'),
		url('fonts/icomoon.svg?-ldfnid#icomoon') format('svg');
	font-weight: normal;
	font-style: normal;
}

[class^="icon-"], [class*=" icon-"],.fav,.unfav {
	font-family: 'icomoon';
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;

	/* Better Font Rendering =========== */
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
.icon-play:before {
	content: "\e601";
}

.icon-bubble:before {
	content: "\e600";
}
.icon-search:before {
	content: "\e681";
}
.icon-flag:before {
	content: "\e6c6";
}
.icon-flag:hover{
	content: "\e6c6";
	color:#000;
}
.unfav:before {
	content: "\e6d3";
	color:#fdc9cd;
}
.unfav:active{
	content: "\e6d3";
	color:#fdc9cd;
}
.fav:before {
	content: "\e6d4";
}
.fav:hover{
	color:#d42238;
}
.icon-close:before {
	content: "\e6ff";
}
.icon-add:before {
	content: "\e641";
}
.icon-cog:before {
	content: "\e690";
}
.icon-arrow-right:before {
	content: "\e723";
}
.icon-arrow-right2:before {
	content: "\e725";
}
.like{
color:#bc2723;
border:0 none;
}
.icon-flagged:before {
content: "\e6c6";
border:0 none;color:#d42238;
}
.activity-meta {position:relative;!important; width:400px; text-align:right;}

.activity-meta .unfav {
    float: left;
    position: absolute;
    width: auto;
    left: 0;
}

.activity-meta .unfav:hover {
	color:#497996!important;
}
.activity-meta .fav {
    float: left;
    position: absolute;
    width: auto;
    left: 0;
}
.activity-meta .reshare-button {
    float: left;
    position: absolute;
    top: 0;
    width: auto;
    left:137px;
}
.activity-meta .unlike { float: left;
    left: 179px;
    position: absolute;
    width: auto;
}
.activity-meta .like { float: left;
    left: 179px;
    position: absolute;
    width: auto;
}
.activity-meta .reshare-button {width:auto; float:left; left;197px; position:absolute;}
.activity-content .like {width:auto; float:left;}
.activity-content .fav {width:auto; float:left;}
.activity-content .acomment-reply {width:auto; float:left;}
.activity-content .bp-ap-selectbox {width:auto; float:left;}
.activity-content .reshare-button {width:auto; float:left;}
.activity-meta .like,.fav ,.acomment-reply,.bp-ap-selectbox,.reshare-button{display:none!important; width:auto; float:left;}
.activity-content:hover .like {display:block!important;}
.activity-content:hover .fav {display:block!important;}
.activity-content:hover .acomment-reply {display:block!important;}
.activity-content:hover .bp-ap-selectbox {display:block!important;}
.activity-content:hover .reshare-button {display:block!important; }
.activity-meta .customStyleSelectBox2 { display:none!important;}
.activity-content .acomment-reply {position: absolute;left: 64px;}
.bubble_font { color:#BCDF81!important; font-size:25px;}
.icon-bubble:before {	content: "\e600";}

.duplicate-unfav:before{ content: "\e6d3"; color:#fdc9cd;}
.activity-meta .duplicate-unfav{ display:block!important; }

.duplicate-fav:before{	content: "\e6d4";}
.duplicate-fav:hover{	color:#d42238; }
.activity-meta .duplicate-fav{ display:none!important;}

.activity-meta a{color:#CBCBCB}

.activity-meta .duplicate-flagged{display:block!important;}
.activity-meta .duplicate-flag{display:none!important;}
.footer-links{font-size:15px; font-weight:bold; margin-left: 32%;}


.qa-page-wrapper{float:left; width:65%;}

.create-post {
    float: right;
    font-size: 18px;
    margin-top: 16px;
	color: #BEBEBE;

}
.create-post span {
    border: 3px solid #BEBEBE;
    border-radius: 50%;
    
    margin-right: 6px;
    padding: 2px;
    text-align: center;
    font-size: 12px;
}
.create-post a{color:#313a41;}
.create-post:hover a{color:#ADD36C;}
.create-post:hover span{color:#ADD36C;border: 3px solid #ADD36C;}

.question-score:before{
 content:"\e600";
 font-family: 'icomoon';
}
.question-score {
    font-size: 53px;
    margin-top: -10px;
}

.question-status:before{
 content:"\e600";
 font-family: 'icomoon';
}
.question-status {
    font-size: 53px;
    margin-top: -10px;
}
.qa-voting-box{color:#bfbfbf;}
.qa-voting-box:hover{color:#bd262b;}

.qa-voting-box .vote-up-off:before{
content: "\e6d4";
font-family: 'icomoon';
}
.qa-voting-box .vote-up-on:before{
content: "\e6d3";
font-family: 'icomoon';
color:#FFC9CE;
}
.qa-voting-box .vote-up-on{

}

.qa-voting-box input.vote-up-off{
	position: absolute;
	z-index: 1000;
    /*background: url("images/btn-dot.png") no-repeat top left;*/
	
}
.qa-voting-box span.vote-up-off {
    left: 14px;
    position: absolute;
    top: -25px;
   
}

.qa-voting-box input[type="submit"]:hover{box-shadow:none;}

.commentshow {color: #BCBCBC;    cursor: pointer;    display: inline;    position: relative;}
.commentshow:hover{color:#079CC4;}

.question-status div{display:none;}
.question-status div.mini-count{display:block;}

.question-score div{display:none;}
.question-score div.mini-count{display:block;}

.bp-wrapper #item-header #latest-update, .bp-wrapper #item-header #item-meta {
font-family: open-sansregular;
font-size: 1.2em;
}
.bp-wrapper div#item-header h2 {
font-family: open-sansregular;
}

.bp-wrapper form.standard-form label, .bp-wrapper form.standard-form span.label {
font-family: open-sansregular;
font-size: 1.4em;
font-weight:bold;
}
.field-visibility-settings-notoggle{
font-family: open-sansregular;
}


.bp-wrapper div.item-list-tabs ul li a, .bp-wrapper div.item-list-tabs ul li span {
font-family: open-sansregular;
}
.bp-wrapper a.button, .button.submit, .bp-wrapper .generic-button a, .bp-wrapper ul.button-nav li a, 
.bp-wrapper .item-list a.button, .bp-wrapper .item-list .acomment-options a, .widget .item-options a, 
.widget .swa-wrap ul#activity-filter-links a, .widget .swa-activity-list li.mini div.swa-activity-meta a, 
.widget .swa-activity-list div.swa-activity-meta a.acomment-reply, 
.widget .swa-activity-list div.acomment-options a{
border: 0.5px solid #2C6500;
background: #0f4207;
background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0f4207));
background: -webkit-linear-gradient(top, #94e241, #175d0c);
background: -moz-linear-gradient(top, #94e241, #175d0c);
background: -ms-linear-gradient(top, #94e241, #175d0c);
background: -o-linear-gradient(top, #94e241, #175d0c);
padding: 5px 20px 5px 20px;
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
-webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
-moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
color: #FFFFFF;
font-size: 20px;
font-family: open_sansregular;
text-decoration: none;
vertical-align: middle;
text-align: center;
}
.bp-wrapper ul.button-nav li a:hover {
   background: #2c6500;
   color: #ffffff;
   border:none;  
   }
.bp-wrapper ul.item-list {
width: 100%;
border-bottom: 1px solid #eee;
}
.bp-wrapper #item-body h3 {
font-family: open-sansregular;
}
	.bp-wrapper table tr td, .bp-wrapper table tr th {
padding: 10px;
font-family: open-sansregular;
}
/**********Tours 5 **********************************/
.page-id-2606 .connect-tour {
    width: 100%;
}


*{
		padding:0px;
		margin:0px;
		outline:none;
		border:none;
		list-style:none;
	}
	



@import url('icomoon.css');

/*?

Theme Name: Bounce
Version: 1.9.7
Description: Designed by <a href="http://www.ghostpool.com">GhostPool.com</a>.
Author: GhostPool
Author URI: http://www.ghostpool.com
Theme URI: http://www.ghostpool.com
License:
License URI:
Tags: buddypress, dark, light, black, gray, green, orange, purple, brown, blue, one-column, two-columns, left-sidebar, right-sidebar, fixed-width, custom-background, custom-colors, custom-menu, editor-style, featured-images, full-width-template, sticky-post, theme-options, translation-ready

*/



/************************************ General Styling ************************************/

@font-face {
    font-family: 'open_sansregular';
    src: url('fonts/opensans-regular-webfont.eot');
    src: url('fonts/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/opensans-regular-webfont.woff') format('woff'),
         url('fonts/opensans-regular-webfont.ttf') format('truetype'),
         url('fonts/opensans-regular-webfont.svg#open_sansregular') format('svg');
    font-weight: normal;
    font-style: normal;

}






@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5),only screen and (min-resolution: 192dpi) {

#logo a{
background: url("http://mariasplace.com/wp-content/uploads/logo_maria@2x.png") no-repeat scroll center top / 90%;
height:365px;
}

}

@font-face
{
font-family: Arial Narrow;
src: url(images/ARIALN.TTF);
}



.bp-links{display:none !important;}

/* Page Styling */

* {

font-family: Helvetica, Arial, sans-serif;

outline: none;

}

html {

margin: 0;

padding: 0;

}

body {

background: -webkit-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Safari */

background: -o-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Opera 11.1 to 12.0 */

background: -moz-linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* For Firefox 3.6 to 15 */

background: linear-gradient(#8BCEF5 0%, #FFFFFF 30%, #FFFFFF 68%, #B0D572 97%); /* Standard syntax (must be last) */

color: #333;

margin: 0;

padding: 0;

font-family: Helvetica, Arial, sans-serif;

font-size: 12px;

font-weight: normal;

text-align: center;

overflow-x: hidden;

}



/* Text Styling */

a {

text-decoration: none;

-webkit-transition: color 0.12s ease-out;

-moz-transition: color 0.12s ease-out;

-o-transition: color 0.12s ease-out;

-ms-transition: color 0.12s ease-out;

transition: color 0.12s ease-out;

}



a img{width:auto; max-width:100%}



@font-face {

    font-family: 'roboto_slabregular';

    src: url('css/RobotoSlab-Regular-webfont.eot');

    src: url('css/RobotoSlab-Regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/RobotoSlab-Regular-webfont.woff') format('woff'),

         url('css/RobotoSlab-Regular-webfont.ttf') format('truetype'),

         url('css/RobotoSlab-Regular-webfont.svg#roboto_slabregular') format('svg');

    font-weight: normal;

    font-style: normal;



}





@font-face {

    font-family: 'nunitoregular';

    src: url('css/nunito-regular-webfont.eot');

    src: url('css/nunito-regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/nunito-regular-webfont.woff') format('woff'),

         url('css/nunito-regular-webfont.ttf') format('truetype'),

         url('css/nunito-regular-webfont.svg#nunitoregular') format('svg');

    font-weight: normal;

    font-style: normal;



}









@font-face {

    font-family: 'open_sanssemibold_italic';

    src: url('css/opensans-semibolditalic-webfont.eot');

    src: url('css/opensans-semibolditalic-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/opensans-semibolditalic-webfont.woff') format('woff'),

         url('css/opensans-semibolditalic-webfont.ttf') format('truetype'),

         url('css/opensans-semibolditalic-webfont.svg#open_sanssemibold_italic') format('svg');

    font-weight: normal;

    font-style: normal;



}



@font-face {

    font-family: 'open_sansregular';

    src: url('css/opensans-regular-webfont.eot');

    src: url('css/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/opensans-regular-webfont.woff') format('woff'),

         url('css/opensans-regular-webfont.ttf') format('truetype'),

         url('css/opensans-regular-webfont.svg#open_sansregular') format('svg');

    font-weight: 400;

    font-style: normal;

}





@font-face {

    font-family: 'nunitolight';

    src: url('css/nunito-light-webfont.eot');

    src: url('css/nunito-light-webfont.eot?#iefix') format('embedded-opentype'),

         url('css/nunito-light-webfont.woff') format('woff'),

         url('css/nunito-light-webfont.ttf') format('truetype'),

         url('css/nunito-light-webfont.svg#nunitolight') format('svg');

    font-weight: normal;

    font-style: normal;



}	







a:hover {

text-decoration: none;

}

h1, h2, h3, h4, h5, h6 {

font-family: 'Raleway', sans-serif;

color: #000;

margin: 0 0 20px 0;

padding: 0;

line-height: 130%;

text-shadow: none;

}

h1 {

font-size: 36px;

}

h2 {

font-size: 32px;

}

h3 {

font-size: 30px;

}

h4 {
font-family: nunitoregular, sans-serif;
font-size: 24px;
}

h5 {

font-family: 'Lato', sans-serif;

font-size: 20px;

}

h6 {

font-family: 'Lato', sans-serif;

font-size: 15px;

}

p {

line-height: 19px;

margin-bottom: 12px;
font-family: open-sansregular;
font-size: 1.2em;
}

p:first-child {

margin-bottom: 12px;

}

p:last-child {

margin-bottom: 0;

}

strong {

font-weight: bold;

}

em {

font-style: italic;

}

small {

font-size: xx-small;

line-height: 1em;

}

sup {

font-size: xx-small;

vertical-align: top;

line-height: 1em;

} 

sub {

font-size: xx-small;

vertical-align: bottom;

line-height: 1em;

} 

#profile-details-section{display:none !important;}

/* List Styling */

ol {

padding: 0;

margin: 0;

}

ol li {

list-style: decimal;

padding: 0 0 10px 0;

margin: 0 0 0 20px;

line-height: 19px;

}

ul {

padding: 0;

margin: 0;

}

ul li {

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

background-position: -115px -381px;

list-style-type: none;

margin: 0 0 10px 0;

padding: 0 0 0 20px;

line-height: 19px;

}

li:last-child {

margin-bottom: 0;

}



/* Form Styling */

input,

textarea,

input[type="password"] {

font-family: Helvetica, Arial, sans-serif;

font-size: 12px;

line-height: 12px;

padding: 7px;

margin: 0;

color: #000;

border: 1px solid #eee;

background: #fff;

-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

box-shadow: inset 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

input:focus,

textarea:focus,

input[type="password"]:focus {

border: 1px solid #999;

}

textarea {

line-height: 19px;

resize: none;

width: 100%;

max-width: 100%;

height: 150px;

}

select {

padding: 2px 0;

}

input[type="button"],

input[type="submit"],

input[type="reset"] {

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

font-weight: bold;

padding: 8px 15px;

cursor: pointer;

border-width: 0;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-transition: border-color .2s linear;

-moz-transition: border-color .2s linear;

-ms-transition: border-color .2s linear;

-o-transition: border-color .2s linear;

transition: border-color .2s linear;

}

input[type="button"]:hover,

input[type="submit"]:hover,

input[type="reset"]:hover {

border-width: 0;

border-top-width: 1px;

-webkit-box-shadow: 0 0 5px rgba(0,153,255,0.5);

-moz-box-shadow: 0 0 5px rgba(0,153,255,0.5);

box-shadow: 0 0 5px rgba(0,153,255,0.5);

}

input[type="radio"],

input[type="checkbox"] {

background: transparent;

border: 0;

}

fieldset {

border: 1px solid #eee;

margin: 0;

padding: 20px;

}

legend {

font-size: 14px;

}



/* Table Styling */

table {

border: 1px solid #eee;

padding: 5px 10px;

line-height: 19px;

width: 100%;

}

table th {

font-weight: bold;

border-top: 1px solid #eee;

padding: 10px;

text-align: left;

}

table td {

border-top: 1px solid #eee;

padding: 10px;

}



/* Other Styling */

img {

max-width: 100%;

height: auto;

}

.ie8 img {

max-width: none;

}

.avatar img,

img.avatar {

position: relative;

/*padding: 1px;*/

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 50%;

-moz-border-radius: 50%;

border-radius: 50%;

}

object,

embed,

video,

iframe {

max-width: 100%;

}

cite {

float: right;

padding: 0 0 5px 0;

}

hr {

background: #eee;

border: 0;

clear: both;

width: 100%;

height: 1px;

padding: 0;

margin: 20px 0;

position: relative;

}

pre {

background: url(lib/images/code-bg.png);

border: 1px solid #eee;

padding: 5px 25px;

margin: 5px 0 20px 0;

font-family: "Courier New";

overflow: auto;

font-size: 12px;

line-height: 19px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

code {

background: url(lib/images/code-bg.png);

border: 1px solid #eee !important;

padding: 5px 25px;

margin: 5px 0 20px 0;

font-family: "Courier New";

clear: both;

display: block;

font-size: 12px;

line-height: 19px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

.preload {

display: none;

}

.no-js .preload {

display: block;

}



/* Alignment Styling */

.left {

float: left;

}

.right {

float: right;

}

.clear {

content: "";

clear: both;

line-height: 0;

padding: 0;

margin: 0;

height: 0;

display:block;

font-size:0;

width:100%;

}

.align-center,

.aligncenter {

position: relative;

margin: 20px auto;

display: block;

clear: both;

}

.align-left,

.alignleft {

position: relative;

float: left;

margin: 4px 20px 5px 0;

}

.align-right,

.alignright {

float: right;

position: relative;

margin: 4px 0 5px 20px;

}

.text-left {

text-align: left;

}

.text-right {

text-align: right;

}

.text-center {

text-align: center;

}

.text-justify {

text-align: justify;

}





/************************************ Content Areas ************************************/



/* Page Outer */

.page-outer { 

width: 100%;

}



/* Page Inner */

.page-inner {

margin: 0 auto;

width: 980px;

}



/* Content Wrapper */

#content-wrapper {
text-align: left;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
/*overflow: hidden;Disabled due to author info panel*/
/*overflow: auto; Might be necessary in IE*/
}

.frame #content-wrapper {

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 27px;

-moz-border-radius: 27px;

border-radius: 27px;

}

.padding #content-wrapper {

 padding: 0px; 

}



/* Main Content */

#content {
position: relative;
width: 92%;
margin: 0px  auto;

}

.sb-right #content {
/*float: left;*/

}

.sb-left #content {

/* float: right;  */

}
/*
.fullwidth #content {

float: left;

width: 100%;

}



 Sidebar */

#sidebar {

width: 290px;

}

.sb-right #sidebar {

float: right;

margin-left: 40px;

}

.sb-left #sidebar {

float: left;

margin-right: 40px;

}

.fullwidth #sidebar {

display: none;

}





/************************************ Header ************************************/



/* Header Outer */

#header-outer {

text-align: left;

position: relative;

background-position: right top;

background-repeat: no-repeat;

}

#bp-links {

display: none;

}



/* Header Inner */

#header-inner {

position: relative;

margin: 0 auto;

width: 100%;

}

#header-left {

float: left;
width:auto;

}

@-webkit-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-moz-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-webkit-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@-o-keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

@keyframes showMenu {

from {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

top:-40px;

}

to {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";

filter:alpha(opacity=100);

opacity: 1;

}

}

#header-right {

float: right;

position: relative;

-webkit-animation: showMenu 1s;

-moz-animation: showMenu 1s;

-o-animation: showMenu 1s;

animation: showMenu 1s;

width:70%

}



/* Logo */

#logo {

background: no-repeat;

display: inline-block;

float: left;

position: relative;

margin: 0;

line-height: 0;

}
#logo a{
  	background:url(http://mariasplace.com/wp-content/uploads/logo_maria.png) no-repeat left top;
  	width:363px;
  	height:197px;
	float:left;
  }

.default-logo {

display: inline-block;

width: 230px;

height: 90px;

position: relative;

margin-top: 19px;

}

#logo img {

position: relative;

}

.logo-details {

display: block;

width: 1px;

height: 1px;

text-indent: -9999px;

}



/* Contact Info */

#contact-info {

position: relative;

top: 25px;

right: 0;

z-index: 1;

text-align: right;

color: #fff;

text-shadow: 1px 1px 2px rgba(0,0,0,0.1);

font-weight: bold;

font-size: 14px;

line-height: 14px;

-webkit-animation: showMenu 1s;

-moz-animation: showMenu 1s;

-o-animation: showMenu 1s;

animation: showMenu 1s;

display:none

}

#contact-info a {

color: #fff;

}

#contact-info a:hover {

text-decoration: underline;

}





/************************************ Navigation Menus ************************************/



/* Nav Wrapper */

#nav {

clear: both;

position: relative;

z-index: 20;

height: 36px;

margin: 98px 0 0 0;

/* border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.1);

-moz-box-shadow: 1px 1px 5px rgba(0,0,0,0.1);

box-shadow: 1px 1px 5px rgba(0,0,0,0.1); 

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px; */

text-align:center

}

.mobile-menu {

display: none;

}



/* Top Level Nav */

#nav ul.menu,

#nav ul ul {

float: none;

position: relative;

padding: 0;

margin: 0px 0 0 35px;

list-style-type:none;

list-style-position:outside;

display:inline-block;

}

#nav ul.menu:after {

content:".";

display:block;

height:0;

clear:both;

visibility:hidden;
padding-bottom:10px;

}

#nav ul.menu li {

float: left;

background: none;

position: relative;

margin: 0;

padding: 0;

display: block;

text-align: left;

}

#nav ul.menu li > a {

color: #2b3133;

padding: 12px 25px 16px 25px;


/*margin: -1px 0 10px 0;*/

line-height: 9px;

display: block;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

font-size:18px;

font-family:'nunitolight'

}

#nav ul.menu li:first-child > a {

border-left-width: 0;

-webkit-border-radius: 8px 8px 0 0px;

-moz-border-radius: 8px 8px 0 0px;

border-radius: 8px 8px 0 0px;

}

#nav ul.menu li.home a {

background: url(lib/images/sprite.png) no-repeat 15px -21px;

text-indent: -9999px;

width: 48px;



}

#nav ul.menu li > a:hover,

#nav ul.menu .current-menu-item > a,

#nav ul.menu .current-menu-ancestor > a,

#nav ul.menu li:hover > a {

background-color: #fff;

-webkit-border-radius: 8px 8px 0 0px;

-moz-border-radius: 8px 8px 0 0px;

border-radius: 8px 8px 0 0px;}


#nav  ul.menu  .sub-menu li > a:hover{background-color: #ceecf4; border-radius:0;}
#nav  ul.menu  .sub-menu li:last-child > a:hover{border-radius: 0 0px 8px 8px;}

/* Drop Down Menus */

#nav .sub-menu {

display: none;

position: absolute;

z-index: 20;

top: 36px;

left: auto;

width: 240px;

margin: 0;

/*padding: 20px 20px 10px 20px;

 border-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.3);

box-shadow: 0 0 10px rgba(0,0,0,0.3);

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;  */

}



#nav li:hover > .sub-menu {

display: block;}



#nav .sub-menu{

border-radius:0px 0px 0px;

}

#nav .sub-menu li:hover{border-radius:none !important; }

#nav .sub-menu a {

display: block;

height: auto;

float: left;

width: 240px;

/* border-width: 1px 0 0 0;

border-style: solid; */

}



#nav .sub-menu li:first-child > a{

border-radius:0px 8px 0px 0px !important;

}



#nav .sub-menu li{width:100%;}





#nav .sub-menu li:first-child > a {

border-top: 0;

}

#nav .sub-menu a:hover {



}

#nav li span {

font-size: 10px;

line-height: 10px;

margin-left: 5px;

display:none

}

#nav .left-nav .sub-menu {

left: 0;

}



/* Sub Drop Down Menus */

#nav ul.menu .sub-menu li ul {

top: auto;

left: 200px;

margin-top: -15px;

}

#nav .sub-menu li span {

font-size: 9px;

}

#nav .left-nav .sub-menu li ul {

left: -240px;

}





/************************************ Social Icons ************************************/



#social-icons {

display: block;

float: left;

padding: 14px 5px 11px 15px;

margin: 0;

/* border-left-width: 1px;

border-style: solid; */

}

#social-icons a {

display: inline-block;

margin-right: 10px;

width: 20px;

height: 16px;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

}

#social-icons a:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}

.youtube-icon {

background: url(lib/images/sprite.png) no-repeat 0 0;

}

.facebook-icon {

background: url(lib/images/sprite.png) no-repeat -36px 0;

}

.twitter-icon {

background: url(lib/images/sprite.png) no-repeat -72px 0;

}

.dribbble-icon {

background: url(lib/images/sprite.png) no-repeat -112px 0;

}

.digg-icon {

background: url(lib/images/sprite.png) no-repeat -141px 0;

}

.vimeo-icon {

background: url(lib/images/sprite.png) no-repeat -180px 0;

}

.delicious-icon {

background: url(lib/images/sprite.png) no-repeat -215px 0;

}

.rss-icon {

background: url(lib/images/sprite.png) no-repeat -248px 0;

}

.linkedin-icon {

background: url(lib/images/sprite.png) no-repeat -285px 0;

}

.googleplus-icon {

background: url(lib/images/sprite.png) no-repeat -320px 0;

}

.myspace-icon {

background: url(lib/images/sprite.png) no-repeat -357px 0;

}

.flickr-icon {

background: url(lib/images/sprite.png) no-repeat -393px 0;

}





/************************************ Top Content ************************************/



/* Top Content */

#top-content {

float: left;

position: relative;

text-shadow: 1px 1px 1px rgba(220,220,220,0.9);

width: 100%;

padding: 40px;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

-webkit-border-radius: 4px 4px 0 0;

-moz-border-radius: 4px 4px 0 0;

border-radius: 4px 4px 0 0;

background-position: right bottom;

background-repeat: no-repeat;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content a {

color: #fff;

}

#top-content a:hover {

color: #ccc;

}

#top-content h1,

#top-content h2,

#top-content h3,

#top-content h4,

#top-content h5,

#top-content h6 {

color: #666;

text-shadow: 1px 1px 1px rgba(200,200,200,1);

}

#top-content.page-title-width .left,

#top-content.page-title-width .right {

width: 50%;

}

#top-content .avatar img,

#top-content img.avatar {

-webkit-box-shadow: 0 0 10px rgba(0,0,0,1);

-moz-box-shadow: 0 0 10px rgba(0,0,0,1);

box-shadow: 0 0 10px rgba(0,0,0,1);

}

#top-content .sc-divider {

background: url(lib/images/divider.png) repeat-x left bottom;

margin: 30px 0;

border: 0;

height: 2px;

}

#top-content .widget {

font-size: 11px;

border: 0;

background: url(lib/images/divider.png) repeat-x left top;

padding: 20px 0;

margin: 0;

}

#top-content .widget li {

line-height: 16px;

}

#top-content .widget:first-child {

background: none;

padding-top: 0;

}

#top-content .widget:last-child {

padding-bottom: 0;

}



/* Page Title */

.page-title {

color: #fff;

margin: 0;

}



/* Post Meta */

.post-meta {

margin-top: 5px;

font-size: 11px;

}

.post-meta a:hover {

color: #fff;

}

.post-meta span {

display: inline;

line-height: 20px;

padding: 5px 0 5px 25px;

margin: 0 20px 0 0;

}

.author-icon {

background: url(lib/images/sprite.png) no-repeat -79px -67px;

}

.clock-icon {

background: url(lib/images/sprite.png) no-repeat -60px -90px;

}

.folder-icon {

background: url(lib/images/sprite.png) no-repeat -40px -116px;

}

.speech-icon {

background: url(lib/images/sprite.png) no-repeat -19px -138px;

}

.tag-icon {

background: url(lib/images/sprite.png) no-repeat 0 -157px;

}



/* Breadcrumbs */

#breadcrumbs {

float: right;

color: #666;

font-weight: bold;

font-size: 11px;

line-height: 15px;

margin-top: 10px;

}

#breadcrumbs a {

font-weight: normal;

}

#breadcrumbs a:hover {

color: #4DB3A2;

}



/* Search Form */

#top-content #searchform {

position: relative;

float: right;

margin: 0 0 0 20px;

padding: 7px 15px;

border-bottom-width: 1px;

border-style: solid;

-webkit-box-shadow: inset 1px 1px 5px rgba(0,0,0,0.1);

-moz-box-shadow: inset 1px 1px 5px rgba(0,0,0,0.1);

box-shadow: inset 1px 1px 1px rgba(0,0,0,0.1);

-webkit-border-radius: 8px;

-moz-border-radius: 8px;

border-radius: 8px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box;

}

#top-content #searchbar {

float: left;

width: 100%;

background: none;

border: 0;

margin: 2px 0 0;

padding: 0 25px 0 0;

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content #searchsubmit {

position: absolute;

top: 7px;

right: 15px;

width: 15px;

height: 17px;

background-color: transparent !important;

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

text-indent: -9999px;

border: 0;

padding: 0;

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

}

#top-content #searchsubmit:hover {

-webkit-box-shadow: none;

-moz-box-shadow: none;

box-shadow: none;

}





/************************************ Page/Post Styling ************************************/



/* Posts */

.post-loop {

float: left;

width: 100%;

position: relative;

margin-top: 40px;

}

.spacing-small .post-loop {

margin-top: 20px;

}

.ie8 .spacing-small .post-loop {

margin-top: 5px;

}

.post-loop:first-child {

margin-top: 0;

}

.post-loop.post-columns {

margin: 20px 0 20px 4%;

}

.spacing-small .post-loop.post-columns {

margin: 10px 0 10px 4%;

}

.post-loop.first-column {

margin: 20px 0 20px 0;

}

.spacing-small .post-loop.first-column {

margin: 10px 0 10px 0;

}

.post-text h2 {

font-size: 26px;

margin-bottom: 10px;

}

.spacing-small .post-text h2 {

font-size: 12px;

margin-bottom: 5px;

}

.sticky {

}



/* Post Thumbnail */

.post-thumbnail {

float: left;

max-width: 100%;

line-height: 0;

position: relative;

overflow: hidden;

margin-bottom: 20px;

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.spacing-small .post-thumbnail {

margin-bottom: 10px;

}

.post-thumbnail.wrap {

margin: 0 20px 0 0;

}

.spacing-small .post-thumbnail.wrap {

margin: 0 10px 0 0;

}



/* Post Meta */

#content .post-meta {

width: 100%;

margin: 0 0 15px 0;

}

#content .post-meta.post-tags {

margin: 0 0 20px 0;

}

#content .post-wrapper .post-meta.post-tags {

margin: 0;

}

#content .post-meta,

#content .post-meta a {

color: #666;

}

#content .post-meta a:hover {

color: #999;

}



/* Post Content */

#post-content {

margin-bottom: 20px;



}

label[for*="pwbox"] {

float: left;

display: inline;

margin: 0 10px 0 0;

}



/* Attachments */

.attachment p {

margin-top: 12px;

}





/************************************ Lightbox ************************************/



.hover-image, 

.hover-video {

display: block;

position: absolute;

z-index: 10;

width: 100%;

height: 100%;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";

filter:alpha(opacity=0);

opacity: 0;

cursor: pointer;

}

.hover-image {

background: url(lib/images/lightbox-image.png) no-repeat center center;

}

.hover-video {

background: url(lib/images/lightbox-video.png) no-repeat center center;

}

img:hover .hover-image, 

img:hover .hover-video {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=80);

opacity: 0.8;

}

.pp_gallery li {

background: none;

border: 0;

padding: 0;

}

.pp_gallery li.jwplayer a {

background: url(lib/scripts/prettyPhoto/images/prettyPhoto/default/default_thumb.png) no-repeat;

width: 50px;

height: 33px;

display: block;

}

.html5player {

width: 100%;

height: 100%;

}





/************************************ Shortcodes: Accordion ************************************/



.accordion .panel {

position: relative;

width: 100%;

margin-bottom: 10px;

overflow: hidden;

}

h3.accordion-title {

font-family: 'Lato', sans-serif;

font-size: 18px;

background-image: url(lib/images/sprite.png);

background-position: -100px -249px;

background-repeat: no-repeat;

padding: 0 0 10px 21px;

margin: 0;

}

h3.ui-state-active.accordion-title {

background-position: -80px -282px;

}

.panel-content {

padding: 0 0 20px 20px;

line-height: 19px;

}





/********************************************* Shortcodes: Activity Stream *********************************************/



#top-content .gp-activity-stream #activity-stream {

border: 0;

}

.gp-activity-stream .acomment-reply {

display: none !important;

}

.gp-activity-stream .load-more {

display: none;

}

.hide-activity-comments .activity-inreplyto,

.hide-activity-comments .activity-comments {

display: none;

}

.gp-activity-stream .wp-pagenavi {

width: 100%;

}

#top-content .gp-activity-stream .wp-pagenavi {

font-size: 11px;

}

.gp-activity-stream .pages {

float: left;

}

.gp-activity-stream .pagination-links {

float: right;

}





/************************************ Shortcodes: Author Info ************************************/



.author-info {

float: left;

position: relative;

width: 100%;

padding: 20px;

margin: 0 0 20px 0;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.sb-left .author-info {

float: right;

margin: 20px -48px 20px 0;

}

.frame .author-info {

margin: 20px 0 20px -48px;

-webkit-border-radius: 0 4px 4px 4px;

-moz-border-radius: 0 4px 4px 4px;

border-radius: 0 4px 4px 4px;

}

.author-info-fold {

display: none;

position: absolute;

top: -8px;

left: 0;

background: url(lib/images/author-info-fold.png) no-repeat;

width: 8px;

height: 8px;

}

.sb-left .author-info-fold {

left: auto;

right: 0;

-moz-transform: scaleX(-1);

-o-transform: scaleX(-1);

-webkit-transform: scaleX(-1);

transform: scaleX(-1);

filter: FlipH;

-ms-filter: "FlipH";

}

.frame .author-info-fold {

display: block;

}

.author-info .avatar {

float: left;

margin-right: 20px;

width: 50px;

height: 50px;

}

.author-info .author-meta {

margin-left: 80px;

}

.author-info .author-meta-top {

width: 100%;

float: left;

}

.author-info .author-name {

float: left;

color: #fff;

margin-bottom: 10px;

font-weight: bold;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

}

.author-info .author-links {

float: right;

font-size: 11px;

margin-bottom: 10px;

}

.author-info .author-links a {

color: #fff;

margin: 0 2px;

}

.author-info .author-desc {

line-height: 19px;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

}





/************************************ Shortcodes: Blockquotes ************************************/



blockquote {

font-size: 14px;

margin: 5px 20px 10px 20px;

padding: 10px 0 5px 25px;

overflow: hidden;

}

blockquote p {

line-height: 23px;

}

.blockquote-left {

float: left;

margin: 10px 20px 20px 0;

}

.blockquote-right {

float: right;

margin: 10px 0 20px 20px;

}

.blockquote-left,

.blockquote-right {

width: 30%;

font-size: 14px;

line-height: 23px;

padding: 10px 0 5px 25px;

}





/************************************ Shortcodes: Buttons ************************************/



/* Buttons */

.sc-button,

.sc-button:hover {

position: relative;

max-width: 100%;

border-top-width: 1px;

border-style: solid;

display: inline-block;

margin: 5px;

font-weight: bold;

-moz-border-radius: 40px;

-webkit-border-radius: 40px;

border-radius: 40px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow:  0 0 5px rgba(0,0,0,0.3);

}

.sc-button.small {

font-size: 11px;

line-height: 11px;

padding: 8px 12px;

}

.sc-button.medium {

font-size: 12px;

line-height: 12px;

padding: 12px 20px;

}

.sc-button.large {

font-size: 14px;

line-height: 14px;

padding: 15px 60px;

}

.columns.button-divider {

background: url(lib/images/divider.png) left center repeat-x;

}



/* Yellow Button */

.yellow.sc-button {

color: #5e471d !important;

text-shadow: 1px 1px 1px rgba(255,255,255,0.8);

border-color: #fff5d8;

background-color: #fcd971;

background-image: -moz-linear-gradient(#fcd971, #fbbd4e);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fcd971), to(#fbbd4e));

background-image: -webkit-linear-gradient(#fcd971, #fbbd4e);

background-image: -o-linear-gradient(#fcd971, #fbbd4e);

background-image: -ms-linear-gradient(#fcd971, #fbbd4e);

-pie-background: linear-gradient(#fcd971, #fbbd4e);

}

.yellow.sc-button:hover {

color: #5e471d !important;

background: #fbbd4e;

}



/* Grey */

.grey.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #838383;

background-color: #5c5c5c;

background-image: -moz-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#5c5c5c), to(#3d3d3d));

background-image: -webkit-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -o-linear-gradient(#5c5c5c, #3d3d3d);

background-image: -ms-linear-gradient(#5c5c5c, #3d3d3d);

-pie-background: linear-gradient(#5c5c5c, #3d3d3d);

}

.grey.sc-button:hover {

color: #fff !important;

background: #3d3d3d;

}



/* Dark Grey Button */

.darkgrey.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #666;

background-color: #404040;

background-image: -moz-linear-gradient(#404040, #202020);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#404040), to(#202020));

background-image: -webkit-linear-gradient(#404040, #202020);

background-image: -o-linear-gradient(#404040, #202020);

background-image: -ms-linear-gradient(#404040, #202020);

-pie-background: linear-gradient(#404040, #202020);

}

.darkgrey.sc-button:hover {

color: #fff;

background: #202020;

}



/* Brown Button */

.brown.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #837268;

background-color: #685950;

background-image: -moz-linear-gradient(#685950, #453B35);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#685950), to(#453B35));

background-image: -webkit-linear-gradient(#685950, #453B35);

background-image: -o-linear-gradient(#685950, #453B35);

background-image: -ms-linear-gradient(#685950, #453B35);

-pie-background: linear-gradient(#685950, #453B35);

}

.brown.sc-button:hover {

color: #fff;

background: #453B35;

}



/* Blue Button */

.blue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #71c6ed;

background-color: #96d1f8;

background-image: -moz-linear-gradient(#09b0fe, #258df8);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#09b0fe), to(#258df8));

background-image: -webkit-linear-gradient(#09b0fe, #258df8);

background-image: -o-linear-gradient(#09b0fe, #258df8);

background-image: -ms-linear-gradient(#09b0fe, #258df8);

-pie-background: linear-gradient(#09b0fe, #258df8);

}

.blue.sc-button:hover {

color: #fff;

background: #258df8;

}



/* Medium Blue Button */

.mediumblue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #748894;

background-color: #505f68;

background-image: -moz-linear-gradient(#505f68, #353f45);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#505f68), to(#353f45));

background-image: -webkit-linear-gradient(#505f68, #353f45);

background-image: -o-linear-gradient(#505f68, #353f45);

background-image: -ms-linear-gradient(#505f68, #353f45);

-pie-background: linear-gradient(#505f68, #353f45);

}

.mediumblue.sc-button:hover {

color: #fff !important;

background: #353f45;

}



/* Dark Blue Button */

.darkblue.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #4d5b64;

background-color: #364046;

background-image: -moz-linear-gradient(#364046, #15191b);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#364046), to(#15191b));

background-image: -webkit-linear-gradient(#364046, #15191b);

background-image: -o-linear-gradient(#364046, #15191b);

background-image: -ms-linear-gradient(#364046, #15191b);

-pie-background: linear-gradient(#364046, #15191b);

}

.darkblue.sc-button:hover {

color: #fff !important;

background: #15191b;

}



/* Lime Green Button */

.limegreen.sc-button {

color: #4C5629 !important;

text-shadow: 1px 1px 1px rgba(255,255,255,0.8);

border-color: #eaf5bc;

background-color: #d2e68d;

background-image: -moz-linear-gradient(#d2e68d, #94bd44);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#d2e68d), to(#94bd44));

background-image: -webkit-linear-gradient(#d2e68d, #94bd44);

background-image: -o-linear-gradient(#d2e68d, #94bd44);

background-image: -ms-linear-gradient(#d2e68d, #94bd44);

-pie-background: linear-gradient(#d2e68d, #94bd44);

}

.limegreen.sc-button:hover {

color: #4C5629 !important;

background: #94bd44;

}



/* Teal Button */

.teal.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #BACAC8;

background-color: #8CA6A3;

background-image: -moz-linear-gradient(#8CA6A3, #6A8A87);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#8CA6A3), to(#6A8A87));

background-image: -webkit-linear-gradient(#8CA6A3, #6A8A87);

background-image: -o-linear-gradient(#8CA6A3, #6A8A87);

background-image: -ms-linear-gradient(#8CA6A3, #6A8A87);

-pie-background: linear-gradient(#8CA6A3, #6A8A87);

}

.teal.sc-button:hover {

color: #fff !important;

background: #6A8A87;

}



/* Dark Green Button */

.darkgreen.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #5a7b85;

background-color: #366a7b;

background-image: -moz-linear-gradient(#366a7b, #23444b);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#366a7b), to(#23444b));

background-image: -webkit-linear-gradient(#366a7b, #23444b);

background-image: -o-linear-gradient(#366a7b, #23444b);

background-image: -ms-linear-gradient(#366a7b, #23444b);

-pie-background: linear-gradient(#366a7b, #23444b);

}

.darkgreen.sc-button:hover {

color: #fff !important;

background: #23444b;

}



/* Red Button */

.red.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #c2464c;

background-color: #93063b;

background-image: -moz-linear-gradient(#b03238, #940a11);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#b03238), to(#940a11));

background-image: -webkit-linear-gradient(#b03238, #940a11);

background-image: -o-linear-gradient(#b03238, #940a11);

background-image: -ms-linear-gradient(#b03238, #940a11);

-pie-background: linear-gradient(#b03238, #940a11);

}

.red.sc-button:hover {

color: #fff !important;

background: #940a11;

}



/* Dark Red Button */

.darkred.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #957578;

background-color: #685053;

background-image: -moz-linear-gradient(#685053, #453537);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#685053), to(#453537));

background-image: -webkit-linear-gradient(#685053, #453537);

background-image: -o-linear-gradient(#685053, #453537);

background-image: -ms-linear-gradient(#685053, #453537);

-pie-background: linear-gradient(#685053, #453537);

}

.darkred.sc-button:hover {

color: #fff !important;

background: #453537;

}



/* Orange Button */

.orange.sc-button {

color: #fff !important;

text-shadow: 1px 1px 1px rgba(0,0,0,0.8);

border-color: #f0a33e;

background-color: #ee8600;



background-image: -moz-linear-gradient(#ee8600, #b25f0f);

background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#ee8600), to(#b25f0f));

background-image: -webkit-linear-gradient(#ee8600, #b25f0f);

background-image: -o-linear-gradient(#ee8600, #b25f0f);

background-image: -ms-linear-gradient(#ee8600, #b25f0f);

-pie-background: linear-gradient(#ee8600, #b25f0f);

}

.orange.sc-button:hover {

color: #fff !important;

background: #b25f0f;

}





/************************************ Shortcodes: Captions ************************************/



.wp-caption {

position: relative;

padding: 0;

max-width: 100%;

}

.wp-caption img {

margin: 0;

}

.wp-caption-text {

margin: 5px 0 0;

font-size: 11px;

color: #666;

}





/************************************ Shortcodes: Columns ************************************/



/* General */

.columns {

float: left;

position: relative;

line-height: 19px;

margin-right: 4%;

}

.one {

width: 100%;

}

.two {

width: 48%;

}

.three {

width: 30.66%;

}

.four {

width: 22%;

}

.five {

width: 16.8%;

}

.onethird {

width: 32.64%;

}

.twothirds {

width: 63.36%;

}

.onefourth {

width: 24%;

}

.threefourths {

width: 72%;

}



/* Separate Columns */

.separate > div {

border: 1px solid #eee;

background: #fff;

position: relative;

padding: 20px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

}



/* Joint Columns */

.columns.joint {

margin: 0;

}

.joint > div {

border-width: 0 0 0 1px;

border-color: #eee;

border-style: solid;

position: relative;

padding: 20px;

}

.first.joint > div {

border-left-width: 0;

}

.one.joint {

width: 100%;

}

.two.joint {

width: 50%;

}

.three.joint {

width: 287px;

}

.middle.three.joint {

width: 326px;

}

.columns .three.joint,

.padding .three.joint {

width: 33% !important;

padding: 0;

}

.four.joint {

width: 25%;

}

.five.joint {

width: 20%;

}

.onethird.joint {

width: 33.33%;

}

.twothirds.joint {

width: 66.33%;

}

.onefourth.joint {

width: 25%;

}

.threefourths.joint {

width: 75%;

}



.last {

clear: right;

margin-right: 0;

}





/************************************ Shortcodes: Contact Form ************************************/

#content .padder{margin-bottom:20px;}

#contact-form {

float: left;

width: 100%;

margin-bottom: 12px;

}

#contact-form label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#contact-form .contact-verify {

float: left;

margin-right: 10px;

}

#contact-form .contact-verify label {

float: left;

margin: 10px 10px 0 0;

}

#contact-form .contact-submit {

float: left;

}

.required {

color: #3596ae;

}

#contact-form .loader {

display: none;

background: url(lib/images/loader.gif) no-repeat right bottom;

float: left;

padding: 4px 0 0 10px;

width: 16px;

height: 16px;

}

.contact-form.notify {

padding: 5px 10px;

margin-bottom: 10px;



}

#contact-form .input-error {

border: 1px solid #FBC2C4;

}





/************************************ Shortcodes: Dividers ************************************/



.sc-divider {

content: "";

border-top: 1px solid #ddd;

clear: both;

width: 100%;

height: 1px;

padding: 0;

margin: 40px 0;

position: relative;

}

.frame .sc-divider {

border-color: #eee;

}

.sc-divider.top a {

font-size: 10px;

float: right;

position: absolute;

top: -20px;

right: 0;

color: #999;

text-align: right;

cursor: pointer;

}

.sc-divider.small {

margin: 0;

}

.sc-divider.clear {

background: none !important;

border: 0;

margin: 20px 0 !important;

}

.sc-divider.small.clear {

border: 0;

margin: 0 !important;

}





/************************************ Shortcodes: Drop Caps ************************************/



.dropcap1 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 0 10px -8px 0;

padding: 0;

text-align: center;

}

.dropcap2 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

background: #eee;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.dropcap3 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

color: #999;

background: #404040;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.dropcap4 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

background: #eee;

-webkit-border-radius: 25px;

-moz-border-radius: 25px;

border-radius: 25px;

}

.dropcap5 {

display: block;

position: relative;

float: left;

font-size: 38px;

line-height: 38px;

margin: 4px 10px 0 0;

padding: 6px 12px;

text-align: center;

color: #999;

background: #404040;

-webkit-border-radius: 25px;

-moz-border-radius: 25px;

border-radius: 25px;

}





/************************************ Shortcodes: Galleries ************************************/



.gallery-columns-1 .gallery-item {

width: 90%;

}

.gallery-columns-2 .gallery-item {

width: 45% !important;

padding-right: 4% !important;

}

.gallery-columns-3 .gallery-item {

width: 31% !important;

padding-right: 2% !important;

}

.gallery-columns-4 .gallery-item {

width: 23% !important;

padding-right: 2% !important;

}

.gallery-columns-5 .gallery-item {

width: 18% !important;

padding-right: 2% !important;

}

.gallery-columns-6 .gallery-item {

width: 14% !important;

padding-right: 2% !important;

}

.gallery-columns-7 .gallery-item {

width: 12% !important;

padding-right: 2% !important;

}

.gallery-columns-8 .gallery-item {

width: 10% !important;

padding-right: 2% !important;

}

.gallery-columns-9 .gallery-item {

width: 9% !important;

padding-right: 2% !important;

}

.gallery-item img {

max-width: 100% !important;

height: auto !important;

border: 0 !important;

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

.gallery-caption {

float: left;

margin: 10px 0;

line-height: 14px;

}

div.gallery-item .gallery-icon {

display: inline-block;

position: relative;

width: 100%;

}

.gallery-item a, .gallery-caption {

width:100%;

}





/************************************ Shortcodes: Images ************************************/



/* Image */

.sc-image {

line-height: 0;

max-width: 100%;

height: auto !important;

}

.sc-image img {

max-width: 100%;

height: auto !important;

width: auto\9;

}

.sc-image a {

display: block;

margin: 0 auto;

}

.sc-image.aligncenter {

margin: 0 auto;

text-align: center;

}



.sc-image.alignleft {

margin: 0;

}

.sc-image.alignright {

margin: 0;

}

.sc-image.image-border {

padding: 5px;

background: #fff;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.3);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.3);

box-shadow: 0 0 5px rgba(0,0,0,0.3);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}





/************************************ Shortcodes: Lists ************************************/



.circle li {

background-position: -92px -402px;

}

.square li {

background-position: -72px -423px;

}

.tick li {

background-position: -50px -443px;

}

.large-tick li {

font-family: 'Lato', sans-serif;

font-weight: 300;

font-size: 18px;

margin-top: 20px;

padding-left: 25px;

background-position: -21px -463px;

}

.large-cross li {

font-family: 'Lato', sans-serif;

font-weight: 300;

font-size: 18px;

margin-top: 20px;

padding-left: 25px;

background-position: 0 -486px;

}





/************************************ Shortcodes: Login/Register Forms ************************************/



#loginform,

#registerform {

float: left;

margin: 0;

}

#loginform label,

#registerform label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#loginform .login-remember label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

padding: 0;

}





/************************************ Shortcodes: Notifications ************************************/



.notify {

position: relative;

margin: 10px 0;

-moz-border-radius: 4px;

-webkit-border-radius: 4px;

border-radius: 4px;

display: block;

line-height: 19px;

padding: 20px;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.1);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.1);

box-shadow: 0 0 5px rgba(0,0,0,0.1);

}

.notify-default {

color: #57481c;

background-color: #FFDF75;

}

.notify-help {

color: #184366;

background-color: #5FA6E5;

}

.notify-success {

color: #566621;

background-color: #B3D46F;

}

.notify-warning {

color: #6b3b17;

background-color: #E78F4B;

}

.notify-error {

color: #571111;

background-color: #D84F4F;

}





/************************************ Shortcodes: Price Box ************************************/



.sc-price-box {

text-align: center;

max-width: 100% !important;

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.5);

box-shadow: 0 0 10px rgba(0,0,0,0.5);

-webkit-border-radius: 8px;

-moz-border-radius: 8px;

border-radius: 8px;

}

.sc-price-box-inner {

padding: 20px 40px;

}

.sc-price-box-title {

font-family: 'Raleway', sans-serif;

font-size: 30px;

line-height: 30px;

color: #fff;

margin-bottom: 20px;

}

.sc-price-box .left {

text-align: center;

width: 100%;

}

.sc-price-box-price {

font-family: 'Raleway', sans-serif;

font-size: 90px;

line-height: 90px;

color: #fff;

}

.sc-price-box-unit {

font-family: 'Raleway', sans-serif;

font-size: 18px;

color: #fff;

}

.sc-price-divider {

float: left;

clear: both;

border-width: 1px 0;

border-style: solid;

height: 0;

width: 100%;

margin: 20px 0;

}

.sc-price-box-content {

float: left;

font-size: 12px;

line-height: 23px;

margin-bottom: 20px;

}

.sc-price-box-button {

float: left;

width: 100%;

text-align: center;

}





/************************************ Shortcodes: Pricing Table ************************************/



.sc-pricing-table table {

width: 100%;

}

.sc-pricing-table thead th {

font-family: 'Raleway', sans-serif;

text-align: center;

font-size: 28px;

color: #fff;

padding: 2%;

border-left-width: 1px;

border-style: solid;

}

.ie8 .sc-pricing-table thead th {

padding: 10px;

-pie-background: none;

}

.sc-pricing-table thead th:first-child {

border: 0;

background: none;

-pie-background: none;

}

.sc-pricing-table thead th.first {

border: 0;

-webkit-border-radius: 4px 0 0;

-moz-border-radius: 4px 0 0;

border-radius: 4px 0 0;

}

.sc-pricing-table thead th.last {

-webkit-border-radius: 0 4px 0 0;

-moz-border-radius: 0 4px 0;

border-radius: 0 4px 0 0;

}

.sc-pricing-table tfoot th {

border-top: 1px solid #eee;

text-align: center;

padding: 2% 0 0 0;

}

.sc-pricing-table .price {

font-size: 15px;

}

.sc-pricing-table tr {

background: #fff;

}

.sc-pricing-table tr:nth-child(even) {

background: #f8f8f8;

}

.sc-pricing-table thead tr,

.sc-pricing-table tfoot tr {

background: none;

}

.sc-pricing-table tr td {

text-align: center;

padding: 2% 1%;

border-width: 1px 1px 0 0;

border-style: solid;

border-color: #eee;

}

.sc-pricing-table tr td:first-child {

text-align: left;

border-left-width: 1px;

font-weight: bold;

}

.sc-pricing-table tr td .yes {

display: block;

margin: 0 auto;

width: 20px;

height: 13px;

background: url(lib/images/sprite.png) no-repeat -21px -467px;

}

.sc-pricing-table tr td .no {

display: block;

margin: 0 auto;

width: 15px;

height: 13px;

background: url(lib/images/sprite.png) no-repeat 0 -490px;

}







/************************************ Shortcodes: Related Posts ************************************/



/* Related Posts Container */

.related-posts {

float: left;

width: 100%;

margin-top: 20px;

}

.related-posts h3 {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 10px 0;

margin: 0;

}

.frame .related-posts h3 {

border-color: #eee;

}

.related-posts h2 {

font-size: 12px;

font-weight: bold;



font-family: Helvetica, Arial, sans-serif;

}





/************************************ Shortcodes: Slider ************************************/



/* Slider */

.flexslider {

position: relative;

width: 100%;

max-width: 100%;

margin: 0;

padding: 0;

zoom: 1;

}

.flexslider.aligncenter {

margin: 0 auto;

}



/* Slides */

.flexslider .slides {

zoom: 1;

}

.flexslider .slides > li {

position: relative;

list-style-type: none;

background: none;

display: none;

-webkit-backface-visibility: hidden;

margin: 0;

padding: 0;

}

.slides:after {

content: ".";

display: block;

clear: both;

visibility: hidden;

line-height: 0;

height: 0;

}

html[xmlns] .slides {

display: block;

}

* html .slides {

height: 1%;

}

.no-js .slides > li:first-child {

display: block;

}

.flexslider .slides img {

max-width: 100%;

display: block;

}

.flexslider.shadow .slides img,

.flexslider.shadow .slides .slide-video {

-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 10px rgba(0,0,0,0.5);

box-shadow: 0 0 10px rgba(0,0,0,0.5);

}



/* Slide Video */

.video-image {

position: absolute;

top: 0;

left: 0;

z-index: 9;

display: block;

width: 100%;

height: 100%;

}

.video-autostart .video-image {

display: none !important;

}

.video-button {

position: absolute;

z-index: 9;

top: 0;

left: 0;

display: block;

background: url(lib/scripts/mediaplayer/fs39/display/playIcon.png) no-repeat center center;

cursor: pointer;

width: 100%;

height: 100%;

}

.video-player {

display: none;

}



/* Slide Caption */

.caption {

padding: 20px 20px 10px 20px;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

line-height: 19px;

position: absolute;

z-index: 10;

max-width: 60%;

max-height: 50%;

overflow: hidden;

}

.caption h2 {

font-family: 'Lato', sans-serif;

color: #fff;

font-size: 20px;

margin-bottom: 10px;

}

.caption p:first-child {

margin-bottom: 10px;

}

.caption.caption-topleft {

top: 20px;

left: 0;

}

.caption.caption-topright {

top: 20px;

right: 0;

}

.caption.caption-bottomleft {

bottom: 20px;

left: 0;

}

.caption.caption-bottomright {

bottom: 20px;

right: 0;

}



/* Slider Prev/Next */

.flex-direction-nav {

list-style: none;

background: none;

overflow: hidden;

margin: 5px 0 0 0;

padding: 0;

}

.flex-direction-nav li {

background: none;

display: inline-block;

list-style: none;

background: none;

margin: 0;

padding: 0;

}

.flex-direction-nav li a {

float: left;

position: relative;

text-indent: -9999px;

z-index: 11;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

width: 12px;

height: 12px;

cursor: pointer;

margin-right: 5px;

}

.flex-direction-nav li .flex-prev {

background: url(lib/images/sprite.png) no-repeat 0 -316px;

}

.flex-direction-nav li .flex-next {

background: url(lib/images/sprite.png) no-repeat -30px -316px;

}

.flex-direction-nav li .flex-prev:hover,

.flex-direction-nav li .flex-next:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}



/* Slider Buttons */

.flex-control-nav {

position: relative;

list-style: none;

background: none;

margin: 5px 0 0 0;

float: right;

}

.flex-control-nav li {

display: inline-block;

list-style: none;

background: none;

margin: 0;

padding: 0;

}

.flex-control-nav li a {

text-indent: -9999px;

float: left;

background: url(lib/images/sprite.png) no-repeat -60px -316px;

margin: 0 3px;

width: 12px;

height: 12px;

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=50)";

filter:alpha(opacity=50);

opacity: 0.5;

cursor: pointer;

}

.flexslider:hover .flex-control-nav li a {

display: block;

}

.flex-control-nav li .flex-active,

.flex-control-nav li a:hover {

-ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=80)";

filter:alpha(opacity=80);

opacity: 0.8;

}





/************************************ Shortcodes: Tabs ************************************/



.ui-tabs {

position: relative;

padding: 0;

top: -4px;

zoom: 1;

}

.ui-tabs .ui-tabs-nav {

display: block;

margin: 0;

padding: 0;

}

.ui-tabs .ui-tabs-nav li { 

z-index: 1;

background-image: none;

list-style: none;

background: none;

float: left;

position: relative;

top: 1px;

margin: 0;

border-bottom-width: 0;

padding: 0;

white-space: nowrap;

border: 0;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content .ui-tabs .ui-tabs-nav li {

top: 0;

}

.ui-tabs .ui-tabs-nav li a {

float: left;

font-weight: bold;

padding: 10px;

text-decoration: none;

}

.ui-tabs .ui-tabs-nav li.ui-state-active { 

z-index: 3;

border: 1px solid #eee;

background: #fff;

border-bottom-color: #fff;

}

#top-content .ui-tabs .ui-tabs-nav li.ui-state-active {

background: rgba(0,0,0,0.2);

border: 0;

}

.ui-tabs .ui-tabs-nav li.ui-state-active a,

.ui-tabs .ui-tabs-nav li.ui-state-disabled a,

.ui-tabs .ui-tabs-nav li.ui-state-processing a {

cursor: text;

color: #000;

}

.ui-tabs .ui-tabs-nav li.ui-state-hover a {

color: #000;

}

.ui-tabs .ui-tabs-nav li a,

.ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-state-active a {

color: #999;

cursor: pointer;

} 

.ui-tabs-nav .tabhead {

cursor:pointer;

font-size: 12px;

margin-bottom: 0;

display: block;

}

.sc-tab-panel {

z-index: 2;

width: 100%;

background: #fff;

position: relative;

height: inherit;

line-height: 19px;

overflow: hidden;

margin: 0 0 10px 0;

padding: 15px;

border: 1px solid #eee;

-webkit-box-sizing: border-box;

-moz-box-sizing: border-box;

box-sizing: border-box; 

}

#top-content .sc-tab-panel {

background: rgba(0,0,0,0.2);

border: 0;

}

.ui-tabs .ui-tabs-hide {

display: none !important;

position: absolute;

left: -10000px;

}





/************************************ Shortcodes: Text Boxes ************************************/



.text-box {

width: 100%;

max-width: 100%;

display: inline-block;

font-size: 14px;

line-height: 19px;

}

#content .text-box {

color: #000;

}

.text-box p {

line-height: inherit;

}

.text-box .testimonial-name {

font-weight: bold;

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}

.text-box .testimonial-company {

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}

.text-box .testimonial-comma {

font-size: 12px;

font-family: Helvetica, Arial, sans-serif;

}





/************************************ Shortcodes: Toggle Box ************************************/



h3.toggle {

font-family: 'Lato', sans-serif;

font-size: 18px;

background-image: url(lib/images/sprite.png);

background-repeat: no-repeat;

background-position: -140px -192px;

padding: 0 0 10px 21px;

margin: 0;

cursor: pointer;

}

h3.toggle a {

display: block;

}

h3.toggle-active {

background-position: -120px -221px;

}

.toggle-box {

clear:both;

margin: 0 0 10px 0;

overflow: hidden;

}

.no-js .toggle-box {

display: block !important;

}





/************************************ Shortcodes: Video ************************************/



.sc-video,

.sc-video div {

max-width: 100%;

}

.sc-video.aligncenter {

text-align: center;

}





/************************************ Footer ************************************/



/* Footer Container */

#footer {

display: inline-block;

text-align: left;

margin: 65px auto 0 auto;

width: 100%;

text-shadow: 1px 1px 1px rgba(255,255,255,1);

}



/* Footer Widgets */

#footer-widgets {

float: left;

width: 100%;

position: relative;

}

.footer-widget-outer .widgettitle {

font-family: Helvetica, "Lucida Sans Unicode", "Lucida Grande", Arial;

font-size: 12px;

font-weight: bold;

margin-bottom: 15px;

}

.footer-widget-outer {

float: left;

margin-left: 4%;

color: #989898;

}

.footer-widget-inner {

float: left;

width: 100%;

margin-bottom: 30px;

}

#footer-widgets div:first-child {

margin-left: 0;

}

.footer-whole {

width: 100%;

}

.footer-half {

width: 22%;

}

.footer-third {

width: 30.66%;

}

.footer-fourth {

width: 22%;

}



/* Footer Forms */

.footer-fourth #searchbar {

width: 100px;

}

.footer-widget-inner textarea {

height: 75px;

}

.footer-fourth #contact-form .textfield {

width: 125px;

}



/* Copyright */

#copyright {
/*
padding: 30px 0 20px 0;
height:100px;*/
background: url("images/m_image2.png") no-repeat scroll center top rgba(0, 0, 0, 0);
color: #000000;
float: left;
font-size: 12px;
margin: 35px 0 60px;
padding: 40px 0;
text-align: center;
width: 100%;
}


#copyright2 #copyright{background: url("images/m_image.png") no-repeat scroll center top;  padding: 55px 0;}



#copyright a{color:#304F62}





/************************************ Widgets ************************************/



/* General Widget Styling */

.widget {

float: left;

width: 100%;

padding-top: 40px;

margin-top: 40px;

border-top: 1px solid #ddd;

}

.frame .widget {

border-color: #eee;

}

.widget:first-child {

border: 0;

padding: 0;

margin: 0;

}

.widget .widgettitle,

.widget .widgettitle a,

.widget .widgettitle a:hover {

color: #000;

font-family: 'Lato', sans-serif;

font-size: 20px;

line-height: 20px;

margin-bottom: 15px;

}

.textwidget {

line-height: 19px;

}



/* Calendar Widget */

#wp-calendar {

margin: 0 auto;

}

#wp-calendar th {

font-weight: bold;

padding: 5px;

text-align: center;

}

#wp-calendar td {

padding: 5px;

text-align: center;

}

#wp-calendar caption {

text-align: right;

font-weight: bold;

margin-bottom: 10px;

}



/* Search Widget */

#searchsubmit {

margin: 0 0 0 10px;

}



/* Custom Menus Widget */

.widget_nav_menu li {

background: none;

margin: 0;

padding: 0;

border-bottom: none;
position:relative;

}
.widget_nav_menu ul li ul {
    left: 45%;
    position: absolute;
    top: 0px;
	z-index:100;
}

.widget_nav_menu li:last-child,

.widget_nav_menu li:hover {

border-bottom:none;

}

.widget_nav_menu a {

display: block;

padding: 0;

line-height:20px

}



/*

.widget_nav_menu a:hover,

.widget_nav_menu .current-menu-item > a {

font-weight: bold;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;


-moz-border-radius: 4px;

border-radius: 4px;

}

.widget_nav_menu .sub-menu li {

margin-left: 20px;

}



*/





/************************************ Comments Section ************************************/



/* Comment List */

#comments {

float: left;

width: 100%;

margin-top: 20px;

}

.padding #comments {

padding: 0;

}

h3.comments {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 10px 0;

margin: 0;

}

.frame h3.comments {

border-color: #eee;

}

#commentlist,

#commentlist li {

list-style: none;

background: none;

margin: 0;

padding: 0;

}



/* Comment Box */

#commentlist .comment-box {

padding: 20px 0;

}

.comment-avatar {

float: left;

width: auto;

}

.comment-author {

font-weight: bold;

padding-bottom: 5px;

}

.comment-date {

color: #666;

font-size: 11px;

}

.comment-body {

margin-left: 90px;

}

.comment-text {

margin: 10px 0 0 0;

}

.reply-link {

height: 11px;

}

.reply-link a {

float: right;

font-size: 11px;

}



/* Child Comments */

#commentlist .children {

padding: 0;

margin: 0;

}

#commentlist .children .comment {

margin-left: 20px;

padding-left: 20px;

background: url(lib/images/comment-reply.png) no-repeat left top;

}

#commentlist .children .comment-avatar img {

width: 40px;

height: 40px;

}

#commentlist .children .comment-body {

margin-left: 70px;

}



/* Comment Post Author */

#commentlist .post-author {

position: relative;

line-height: 1;

font-size: 11px;

line-height: 11px;

margin-top: 10px;

padding: 3px;

text-align: center;

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

color: #333;

border: 1px solid #e1ca82;

background-color: #ffeaa6;

background-image: -moz-linear-gradient(#fff2c9, #ffeaa7);

background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fff2c9), color-stop(100%,#ffeaa7));

background-image: -webkit-linear-gradient(#fff2c9, #ffeaa7);

background-image: -ms-linear-gradient(#fff2c9, #ffeaa7);

background-image: -o-linear-gradient(#fff2c9, #ffeaa7);

-pie-background: linear-gradient(#fff2c9, #ffeaa7);

display: none;

}

#commentlist .bypostauthor > .comment-box .post-author {

display: block;

}



/* Comment Form */

#commentform {

float: left;

width: 100%;

margin-top: 10px;

}

#respond {

margin: 10px 0 20px 0;

}

#respond h3 {

font-size: 20px;

border-bottom: 1px solid #ddd;

padding: 0 0 20px 0;

margin: 0 0 20px 0;

}

.frame #respond h3 {

border-color: #eee;

}

#respond label {

display: block;

font-weight: bold;

margin: 0 0 5px 0;

}

#respond textarea {

margin: 10px 0 0;

}

#cancel-comment-reply-link {

font-family: Helvetica, Arial, sans-serif;

float: right;

display: block;

font-size: 11px;

margin-top: 5px;

}





/************************************ Page Navigation ************************************/



/* Page & Comments Navigation */

.wp-pagenavi {

margin: 20px 0 0 0;

float: right;

}

.wp-pagenavi.post-navi {

margin: 0 0 20px 0;

}

.wp-pagenavi span,

.wp-pagenavi.cat-navi a,

.wp-pagenavi.comment-navi a,

.wp-pagenavi.post-navi a span {

display: block;

float: left;

padding: 5px 10px;

margin-left: 5px;

text-align: center;

color: #fff;

text-shadow: 1px 1px 1px rgba(0,0,0,0.1);

font-weight: bold;

border-top-width: 1px;

border-style: solid;

-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);

-moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

box-shadow: 0 0 5px rgba(0,0,0,0.5);

-webkit-border-radius: 4px;

-moz-border-radius: 4px;

border-radius: 4px;

}

.wp-pagenavi .current,

.wp-pagenavi.cat-navi a:hover,

.wp-pagenavi.comment-navi a:hover,

.wp-pagenavi .page:hover,

.wp-pagenavi.post-navi span,

.wp-pagenavi.post-navi a span:hover {

-webkit-box-shadow: 0 0 5px rgba(0,153,255,1);

-moz-box-shadow: 0 0 5px rgba(0,153,255,1);

box-shadow: 0 0 5px rgba(0,153,255,1);

}





.header-tour{color:#000000 !important; font:35px 'open_sansregular' !important; }




.avatar{

float:right;		
margin-right:20px;
}



.avatar_name{

float:left;

font-size:17px;		

color:#FFF;

margin-top:-18px;

font-family:'nunitoregular'

}

.drop_arrow {color: #FFFFFF; float: right; font-size: 20px; height: 36px; margin-right: 5px; margin-top: 2px; text-align: right; width: 45px; cursor:pointer;}



.drop_arrow span{ color:#fff;}
.drop_arrow .sub-nav-wrap {background-color: #acd373; border-radius:0 0 30px 30px; display: none; float: right; margin:12px -90px 0 0px; width:245px;}
.drop_arrow .sub-nav-wrap ul{margin:0; float: left; padding:0px;}

.drop_arrow .sub-nav-wrap ul li {background: none ; display: inline; float: left; margin: 0; padding: 0; position: relative; text-align: left; width: 100%;}

.drop_arrow .sub-nav-wrap ul li a {color: #707070; display: block;  float: left;  font-family: 'nunitolight'; font-size: 18px; height: auto; line-height: 9px; padding: 12px 25px 12px 25px; width: 80%;}
.drop_arrow .sub-nav-wrap ul li:first-child a {border-left-width: 0; border-radius: 8px 8px 0 0;}
.drop_arrow .sub-nav-wrap ul li a:hover{color:#000;}
.drop_arrow:hover .sub-nav-wrap{display:block;}
/*
#register-page .oneall_social_login {
    display: none;
}
*/


.avatar_image{float:right; margin-top:-30px; padding:5px;}
.bullet-icon{float:left; width:15%; text-align:left; margin-top:15px}
.bullet-icon a, .bullet-icon a:hover{font:14px/55px 'FontAwesome'; color:#cbcbcb; margin-left:10px;}
[class^="icon-"], [class*=" icon-"]{color:#cbcbcb;}
.center-heading{width:70%; float:left; text-align:center}
.skiptour{float:right; /* margin-top: 10px; */ width:10%; text-align:right; margin-top:15px }
.skiptour a, .skiptour a:hover{font:14px/55px 'open_sansregular'; color:#b5b5b5; }



.focus_text{
width:92%;
margin:0px auto;
text-align:center;
margin-bottom:17px;
border-bottom:1px solid #cdcdcd; }


.focus_text cite{text-align:center; width:100%; line-height:58px; margin-top:19px; font-size:32px; font-family: 'open_sanssemibold_italic'; color:#b92927;}



.clear{clear:both; float:none}

.cont-wrap{width:100%;}



.left-content{float:left; width:23%;}

#se_main
	{
		width:900px;
		margin:0 auto 250px auto;
		padding:70px 0px 0px 0px;
		}
	
#se_main li {
    background-image: none;
    float: left;
    margin: 0 30px;
    padding: 0;
    width: 243px;
}
	
#se_main li:first-child { margin-left:28px;}
#se_main li:last-child { margin-right:0;}
	

.se_getstart {
    color: #C5D3D6;
    float: left;
    font-size: 32px;
    margin-bottom: 16px;
    text-align: center;
    width: 100%;
}
	
	
.se_wanttoknowmore {
    color: #C5D3D6;
    float: left;
    font-size: 30px;
    letter-spacing: -2px;
    margin: 0 0 16px;
    padding-top: 1px;
    text-align: center;
    width: 100%;
}
	
.se_basicmem {
    color: #2E7E25;
    float: left;
    font-size: 28px;
    margin-bottom: 21px;
    text-align: center;
    width: 100%;
}
	
.se_learnabout {
    color: #187EBE;
    float: left;
    font-size: 28px;
    margin-bottom: 21px;
    text-align: center;
    width: 100%;
}



	
#se_main li:last-child .se_basicmem{color:#7e4f23;}
#se_main li:last-child .se_isfree{font-size:36px;}
.se_isfree {
    color: #2E7E25;
    float: left;
    font-size:41px;
    margin-bottom: 11px;
    text-align: center;
    width: 100%;
}
	
.se_isfree span
	{
	color:#7e4f23;
	}
	
	
.se_mostoursite {
    color: #313A3F;
    float: left;
    font-size: 15px;
    margin-bottom: 1px;
    text-align: center;
    width: 100%;
    margin-top: 4px;
}
	
.createaccount_button {
    float: left;
    padding: 10px 0 0;
    width: 100%;
}
	
.createaccount_button a {
	width:99%;
	float:left;
	font-weight: bold;
   border: 0.5px solid #2C6500;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0f4207));
   background: -webkit-linear-gradient(top, #94e241, #175d0c);
   background: -moz-linear-gradient(top, #94e241, #175d0c);
   background: -ms-linear-gradient(top, #94e241, #175d0c);
   background: -o-linear-gradient(top, #94e241, #175d0c);
   padding: 17px 0;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;

   -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: #FFFFFF;
   font-size: 20px;
   font-family: open_sansregular;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
 


   
   
   
   
.createaccount_button a:hover {
   background: #2c6500;
   color: #ffffff;
   }
.createaccount_button a:active {
   background: #343536;
   }
   
 
 
 .se_pricing {
    color: #187EBE;
    float: left;
    font-size: 41px;
    margin-bottom: 11px;
    text-align: center;
    width: 100%;
}
	
 
 .checkpricing_button
	{
		width:100%;
		float:left;
		padding:10px 0px 0px 0px;
	}  
 .checkpricing_button a {
	width:99%;
	font-weight: bold;
	float:left;
   border: 0.5px solid #0D7D9B;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0891bf));
   background: -webkit-linear-gradient(top, #78c6f4, #0891bf);
   background: -moz-linear-gradient(top, #78c6f4, #0891bf);
   background: -ms-linear-gradient(top, #78c6f4, #0891bf);
   background: -o-linear-gradient(top, #78c6f4, #0891bf);
   padding: 17px 0;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: white;
   font-size: 20px;
   font-family: open_sansregular;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
 
 
   
.checkpricing_button a:hover {
    background: #0d7d9b;
   color: #ffffff;
   }
.checkpricing_button a:active {
    background: #343536;
   }
   
   
  .takehealth_button
	{
		width:100%;
		float:left;
		padding:10px 0px 0px 0px;
	}  
 .takehealth_button a {
	width:99%;

	float:left;
   border:0.5px solid #72400E;
   background: #0f4207;
   background: -webkit-gradient(linear, left top, left bottom, from(#bd8d5d), to(#6c3b1d));
   background: -webkit-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -moz-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -ms-linear-gradient(top, #bd8d5d, #6c3b1d);
   background: -o-linear-gradient(top, #bd8d5d, #6c3b1d);
    -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;

      -webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   -moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
   text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
   color: #fff;
   font-size: 20px;
   font-family: open_sansregular;
   font-weight: bold;
   padding: 17px 0;
   text-decoration: none;
   vertical-align: middle;
   text-align:center;
   }
    
   
.takehealth_button a:hover {
    background: #72400e;
   color: #ffffff;
   }
.takehealth_button a:active {
    background: #343536;
   }





#answer-form p .wp32 {
    float: left;
    height: 48px;
    margin: 0 15px 0 0;
    padding: 13px 0 0 10px;
    width: 451px;
}
#answer-form img {
    float: left;
    height: 48px;
    margin-right: 15px;
    width: 48px;
}
#answer-form .qa-edit-submit {
    float: left;
    margin-top: 7px;
}


.qa-action-links > a {
    color: #BFBFBF;
    margin-right: 16px;
    text-transform: capitalize;
}
.qa-action-links {
    color: rgba(0, 0, 0, 0);
    margin-top: 15px;
}
.qa-action-links > a:hover {
    color: #FF6600;
    font-weight: bold;
}
#answer-list > h2 {
    color: #FF6600;
    font-size: 24px;
    margin: 0;
}
#answer-list {
    border-bottom: 1px solid #D7D7D7;
}


.healthy

	{

		width:88%;

		float:right;

		font-size:44px;

		line-height:50px;

		color:#313b41;

		font-family: 'open_sansregular';

		text-align:right;

		margin-bottom:39px;

		font-weight:600;

		margin-top:35px;

	}

.sign_up

	{

		width:90%;

		float:right;

		border-radius:3px;

		height:47px;

		background: -webkit-linear-gradient(0deg, #038aac, #05bcea); /* For Safari */

		background: -o-linear-gradient(0deg, #038aac, #05bcea); /* For Opera 11.1 to 12.0 */

		background: -moz-linear-gradient(0deg, #038aac, #05bcea); /* For Firefox 3.6 to 15 */

		background: linear-gradient(0deg, #038aac, #05bcea); /* Standard syntax (must be last) */

		border:1px solid #497629;

		/* box-shadow: inset 1px 1px 5px #000;

		box-shadow:1px 1px 5px #000; */

		font-size:21px;

		color:#ffffff;

		font-family: 'roboto_slabregular';

		/* text-shadow: 1px 1px 9px #e0fbcb; */

		line-height:44px;

		text-align:center;

		cursor:pointer;



	}

/* ///////   Q&A Pages CSS     ////////    */
.qa-left-side{float:left; width:33%; font-family: 'open_sansregular';}
.qa-left-side #sidebar{margin-left:0px;}
.qa-left-side .widget{border:0; margin:0px; padding:0px;}
.qa-left-side .avatar_image1{float:left; }
.qa-left-side .avatar_image1 img{width:57px; height:57px;}
.qa-left-side .avatar_name1{float:left; padding-left:10px; color:#737373; font-size:18px; line-height:3.5; font-weight:bold;  text-transform: capitalize; }
.qa-left-side #nav_menu-6{float:left; }
.qa-left-side #nav_menu-6 ul{float:left; }
.qa-left-side #nav_menu-6 ul li {display: inline;    float: left;    padding-left:12%;    width: 80%;}
.qa-left-side #nav_menu-6 ul li a {color: #35393C; float: left; font-size: 18px; line-height:26px; text-transform: capitalize;}
.qa-left-side #nav_menu-6 ul li a:hover{color:#3f902a; }

.qa-left-side .search-box{float:left; margin-top: 30px;}

.qa-left-side #question_categories-2 {float: left; margin-top: 36px;font-family: 'open_sansregular';}
.qa-left-side #question_categories-2  h2{color:#3f902a; font-family: 'open_sansregular';  font-weight:bold; font-size:22px;}

.qa-left-side #question_categories-2 ul{float:left; }
.qa-left-side #question_categories-2 ul li {display: inline; background:none;    float: left;    padding-left:5%; margin-bottom:0;    width: 90%;}
.qa-left-side #question_categories-2 ul li a {color: #35393C; float: left; font-size: 19px; line-height: 26px; text-transform: capitalize;}
.qa-left-side #question_categories-2 ul li a:hover{color:#3f902a; }

.qa-left-side #searchbar {margin-top: 28px;  width: 70%;}



.qa-right-side{float:right; width:66%;}
.qa-right-side #qa-page-wrapper{margin-left:0px;}


/* /////// End  Q&A Pages CSS     ////////    */
	
.slider{float:right; width:74%; margin-top:15px; border-radius:5px}



.tour{width:100%; float:left; background:#bcdf81; min-height:45px; margin-top:53px;  border-radius: 0 0 27px 27px; text-align:center}



.take_tour_btn{

display:inline-block;

	/*min-width:20%;*/
	padding:0px 40px;
	float:none;
	border-radius:26px;
	height:47px;
	background: -webkit-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Safari */
	background: -o-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Opera 11.1 to 12.0 */
	background: -moz-linear-gradient(0deg, #ffee23, #fcfcc3); /* For Firefox 3.6 to 15 */
	background: linear-gradient(0deg, #ffee23, #fcfcc3); /* Standard syntax (must be last) */
	border:1px solid #497629;
	/* box-shadow: inset 1px 1px 5px #000;*/
	box-shadow:5px px 6px #000; 
	font-size:22px;
	line-height:45px;
	text-align:center;
	cursor:pointer;
	position:relative;
	z-index:1;
	margin-top: -25px;
	}





.take_tour_btn a, .take_tour_btn a:hover{color:#313b41;

	font-family: 'roboto_slabregular';}





.oneByOne1{box-shadow:1px 1px 10px #ccc;

		border:1px solid #e1e2e3;

		background:#FFFFFF;

		border-radius:5px}


#nav a#pull {
	display: none;
	color: #fff;
	font-family: "Times New Roman", Times, serif;
	font-size: 16px;
	font-weight:bold;
	text-align:left;
	z-index: 100;
}






.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:410px !important; border-radius:5px !important}

.peKenBurns.neutral .peKb_slides{background-color:#fff !important; box-shadow:1px 1px 10px #ccc; border:1px solid #e1e2e3; background:#FFFFFF; border-radius:5px !important}

.peKenBurns .peKb_slides .peKb_caption{width:100% !important;}

.peKenBurns .peKb_slides{padding:0px}

.peKenBurns .peKb_shadow{display:none}

.peKenBurns ul li{background:none !important}


.start-explore{text-align:center}

.start-explore h3{color:#323b42; margin-top:40px; font: 37px/70px 'open_sansregular'}

.createaccount{width:22%; background:green; display:inline-block; 

        background: -webkit-linear-gradient(0deg, #318025, #9edf4d); /* For Safari */

	background: -o-linear-gradient(0deg, #318025, #9edf4d); /* For Opera 11.1 to 12.0 */

	background: -moz-linear-gradient(0deg, #318025, #9edf4d); /* For Firefox 3.6 to 15 */

	background: linear-gradient(0deg, #318025, #9edf4d); /* Standard syntax (must be last) */

	border:1px solid #7e946e;

	/* box-shadow: inset 1px 1px 5px #000;*/

	box-shadow:5px px 6px #000; 

border-radius:3px;

margin-top:10px}



.createaccount a{color:#fff; font:17px/41px 'open_sansregular'; }

.createaccount a:hover{color:#fff}



.or{width: 52%; display:inline-block; margin-top:50px; background:url(images/arrow-red.png) no-repeat 97% 65%; margin-bottom:60px }



.or p{font:24px/32px 'open_sansregular'; color:#31383e; width:70%; float:left; text-align:right}

.or p:first-child{text-align:center; width:100%; margin-bottom:30px}





.connect-tour{width:85%; margin:0px auto; margin-bottom:25px}

.mobile-menu{display:none !important}















@media all and (max-width: 1280px) {

#header-left{width:20%}

#header-right{width:68%}

.oneByOne1{width:100%}

}

@media all and (max-width: 980px){
#header-inner{text-align: center;}
#header-left, #header-right{float:none; display: inline-block; }
#header-right{width:98%}
#header-left {width: 38%;}
.slider{width:72%}
#nav{margin-top:35px}

}







@media all and (max-width: 960px)

{

#content{float:none; text-align:center; width:100% !important }

.left-content{display: inline-block;; float:none !important; width:80%}

.slider{display: inline-block; float: none !important;  margin-top: 15px; width: 85%;}

.healthy{width:100%; text-align:center !important; float:none !important; font-size: 37px;}

.sign_up{display:inline-block; width:35%; float:none}
.bullet-icon, .skiptour, .center-heading{float:none; width:100%; text-align:center !important }
.bullet-icon a, .skiptour a{line-height:30px !important}
.bullet-icon{padding-top:10px}
.focus_text cite{margin-top:10px !important}
}





@media all and (max-width: 800px)

{

.or{background:none}

.or p{width:100%; text-align:center; margin-bottom: 10px;}

.createaccount{width:26%}

}











@media all and (max-width: 768px)

{

#nav li > a{font-size:16px}

#nav ul.menu, #nav ul.menu ul{margin: 1px 0 0 17px;}

.slider {width:83%}

#header-left {width: 100%;}

.take_tour_btn{margin-right:0px} 

.or{ margin-bottom: 0px;}

}


@media all and (max-width: 755px)

{
#nav{padding:0px !important; background:#c8e8fa !important}
#nav ul.menu {display: none;	height: auto; margin: 0px;}
#nav a#pull {display: block; background:url("images/nav-icon.png") no-repeat scroll 85% 10px; padding: 12px 10px; position: relative;	padding-left: 25px; text-decoration:none; width:100%; color:#2B3133; font-family:'open_sansregular'; text-transform: uppercase; font-size:15px}
#nav ul.menu{width:100%}
#nav ul.menu li {float:none; width:100%; display:block; }
#nav ul.menu li a {text-align:center; padding:15px}
.sub-menu{display:none !important}
#nav ul.menu li:hover .sub-menu{width:100%; display:block !important; position:relative; top:0px }
#nav ul.menu li:hover .sub-menu a{width:100%; display:block;}
.widget_nav_menu ul li:hover .sub-menu{display:block !important}
}




@media all  and (max-width: 640px){



.slider {width: 79%;}

.sign_up {width: 55%;}

#logo{width:100%; float:left;}

#logo a {
    background: url("http://mariasplace.com/wp-content/uploads/logo_maria.png") no-repeat scroll center top / 100% auto rgba(0, 0, 0, 0);
    height: 160px;
    margin: 0 auto;
    width: 363px;
    display: block;
	float:none;
}

#footer-widgets {float:none; text-align:center}

#footer-widgets > div{width:100%; display: inline-block;}

.footer-widget-inner {display: inline-block; float: none; width: 75%;}

.tour {margin-top:0px}

.take_tour_btn{ margin-right:0px !important; float:none !important} 

.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:300px !important}

.peKb_slides, .peKb_timer{height:250px !important; width:100% !important}

peKb_timer canvas{display:none}

.or{ margin-bottom: 15px;}

.createaccount {width: 35%;}

}


a.mlw_qmn_quiz_link {
font-size:1.2em !important;
}

div.mlw_qmn_quiz input[type=submit]{
font-size:1.2em !important;
}


@media all and (max-width: 480px){

.avatar {
    display: block !important;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 1000;
}
.drop_arrow:hover .sub-nav-wrap {display:block;}

.drop_arrow .sub-nav-wrap {
    background-color: #ACD373;
    border-radius: 0;
    display: none;
    float: right;
    margin: 12px -90px 0 0;
    width: 245px;
}


#nav a#pull{width:40%;}
#nav ul.menu{display:none;}

#nav ul.menu, #nav ul ul{margin:0;}

.focus_text{font-size:24px}

.slider {width: 86%;}

#header-left{width:60%}

.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:250px !important}

.peKb_slides, .peKb_timer{height:200px !important; width:100% !important}

.peKenBurns.neutral .peKb_timer{display:none !important}

peKb_mainPanel{margin-left:70px}



.createaccount {width: 51%;}

.or {width:80%}

.peKenBurns .peKb_controls{display:none !important;}

.healthy{margin-top:0px}

.focus_text cite, .header-tour{font-size:28px !important}

 #logo a {    background: url("http://mariasplace.com/wp-content/uploads/logo_maria.png") no-repeat scroll center top / 90% auto rgba(0, 0, 0, 0);    float: left;    height: 145px;    width: 100%;}

}







@media all and (max-width: 360px)

{

.slider {width: 86%;}
.healthy{font-size:25px; line-height:30px}
.sign_up {width: 94%;}
#header-left {width: 100%;}
.peKenBurns neutral peActiveWidget, .peKenBurns{width:100% !important; height:225px !important}
.peKb_slides, .peKb_timer{height:175px !important; width:100% !important}
.createaccount { width: 60%;}
.or p{font-size:22px}

}

@media all and (max-width: 320px){
#logo img{display:none;}
.slider {width:90%;}
.healthy{font-size:22px}
#header-left {width: 80%;}
#nav ul.menu{display:none;}
#se_main li:first-child {margin-left:0px;}
#se_main li:last-child {margin-bottom:50px;}

.se_mostoursite{margin-bottom:6px;}
#se_main .createaccount_button {float: none; padding: 10px 0 0; width:100%;}
#se_main .checkpricing_button {float: none; padding: 10px 0 0; width: 100%;}
#se_main .takehealth_button {float: none; padding: 10px 0 0; width: 100%;}
#se_main {margin: 0 auto; padding: 70px 0 0; width: 92%;}

#se_main li.se_columns {display: block; margin: 20px 0 20px; width: 100%;}

}

/************************************ BuddyPress ************************************/


#gp-theme-options a[href="#5"] {

display: none !important;

}



@font-face {
	font-family: 'icomoon';
	src:url('fonts/icomoon.eot?-ldfnid');
	src:url('fonts/icomoon.eot?#iefix-ldfnid') format('embedded-opentype'),
		url('fonts/icomoon.woff?-ldfnid') format('woff'),
		url('fonts/icomoon.ttf?-ldfnid') format('truetype'),
		url('fonts/icomoon.svg?-ldfnid#icomoon') format('svg');
	font-weight: normal;
	font-style: normal;
}

[class^="icon-"], [class*=" icon-"],.fav,.unfav {
	font-family: 'icomoon';
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;

	/* Better Font Rendering =========== */
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
.icon-play:before {
	content: "\e601";
}

.icon-bubble:before {
	content: "\e600";
}
.icon-search:before {
	content: "\e681";
}
.icon-flag:before {
	content: "\e6c6";
}
.icon-flag:hover{
	content: "\e6c6";
	color:#000;
}
.unfav:before {
	content: "\e6d3";
	color:#fdc9cd;
}
.unfav:active{
	content: "\e6d3";
	color:#fdc9cd;
}
.fav:before {
	content: "\e6d4";
}
.fav:hover{
	color:#d42238;
}
.icon-close:before {
	content: "\e6ff";
}
.icon-add:before {
	content: "\e641";
}
.icon-cog:before {
	content: "\e690";
}
.icon-arrow-right:before {
	content: "\e723";
}
.icon-arrow-right2:before {
	content: "\e725";
}
.like{
color:#bc2723;
border:0 none;
}
.icon-flagged:before {
content: "\e6c6";
border:0 none;color:#d42238;
}
.activity-meta {position:relative;!important; width:400px; text-align:right;}

.activity-meta .unfav {
    float: left;
    position: absolute;
    width: auto;
    left: 0;
}

.activity-meta .unfav:hover {
	color:#497996!important;
}
.activity-meta .fav {
    float: left;
    position: absolute;
    width: auto;
    left: 0;
}
.activity-meta .reshare-button {
    float: left;
    position: absolute;
    top: 0;
    width: auto;
    left:137px;
}
.activity-meta .unlike { float: left;
    left: 179px;
    position: absolute;
    width: auto;
}
.activity-meta .like { float: left;
    left: 179px;
    position: absolute;
    width: auto;
}
.activity-meta .reshare-button {width:auto; float:left; left;197px; position:absolute;}
.activity-content .like {width:auto; float:left;}
.activity-content .fav {width:auto; float:left;}
.activity-content .acomment-reply {width:auto; float:left;}
.activity-content .bp-ap-selectbox {width:auto; float:left;}
.activity-content .reshare-button {width:auto; float:left;}
.activity-meta .like,.fav ,.acomment-reply,.bp-ap-selectbox,.reshare-button{display:none!important; width:auto; float:left;}
.activity-content:hover .like {display:block!important;}
.activity-content:hover .fav {display:block!important;}
.activity-content:hover .acomment-reply {display:block!important;}
.activity-content:hover .bp-ap-selectbox {display:block!important;}
.activity-content:hover .reshare-button {display:block!important; }
.activity-meta .customStyleSelectBox2 { display:none!important;}
.activity-content .acomment-reply {position: absolute;left: 64px;}
.bubble_font { color:#BCDF81!important; font-size:25px;}
.icon-bubble:before {	content: "\e600";}

.duplicate-unfav:before{ content: "\e6d3"; color:#fdc9cd;}
.activity-meta .duplicate-unfav{ display:block!important; }

.duplicate-fav:before{	content: "\e6d4";}
.duplicate-fav:hover{	color:#d42238; }
.activity-meta .duplicate-fav{ display:none!important;}

.activity-meta a{color:#CBCBCB}

.activity-meta .duplicate-flagged{display:block!important;}
.activity-meta .duplicate-flag{display:none!important;}
.footer-links{font-size:15px; font-weight:bold; margin-left: 32%;}


.qa-page-wrapper{float:left; width:65%;}

.create-post {
    float: right;
    font-size: 18px;
    margin-top: 16px;
	color: #BEBEBE;

}
.create-post span {
    border: 3px solid #BEBEBE;
    border-radius: 50%;
    
    margin-right: 6px;
    padding: 2px;
    text-align: center;
    font-size: 12px;
}
.create-post a{color:#313a41;}
.create-post:hover a{color:#ADD36C;}
.create-post:hover span{color:#ADD36C;border: 3px solid #ADD36C;}

.question-score:before{
 content:"\e600";
 font-family: 'icomoon';
}
.question-score {
    font-size: 53px;
    margin-top: -10px;
}

.question-status:before{
 content:"\e600";
 font-family: 'icomoon';
}
.question-status {
    font-size: 53px;
    margin-top: -10px;
}
.qa-voting-box{color:#bfbfbf;}
.qa-voting-box:hover{color:#bd262b;}

.qa-voting-box .vote-up-off:before{
content: "\e6d4";
font-family: 'icomoon';
}
.qa-voting-box .vote-up-on:before{
content: "\e6d3";
font-family: 'icomoon';
color:#FFC9CE;
}
.qa-voting-box .vote-up-on{

}

.qa-voting-box input.vote-up-off{
	position: absolute;
	z-index: 1000;
    /*background: url("images/btn-dot.png") no-repeat top left;*/
	
}
.qa-voting-box span.vote-up-off {
    left: 14px;
    position: absolute;
    top: -25px;
   
}

.qa-voting-box input[type="submit"]:hover{box-shadow:none;}

.commentshow {color: #BCBCBC;    cursor: pointer;    display: inline;    position: relative;}
.commentshow:hover{color:#079CC4;}

.question-status div{display:none;}
.question-status div.mini-count{display:block;}

.question-score div{display:none;}
.question-score div.mini-count{display:block;}

.bp-wrapper #item-header #latest-update, .bp-wrapper #item-header #item-meta {
font-family: open-sansregular;
font-size: 1.2em;
}
.bp-wrapper div#item-header h2 {
font-family: open-sansregular;
}

.bp-wrapper form.standard-form label, .bp-wrapper form.standard-form span.label {
font-family: open-sansregular;
font-size: 1.4em;
font-weight:bold;
}
.field-visibility-settings-notoggle{
font-family: open-sansregular;
}


.bp-wrapper div.item-list-tabs ul li a, .bp-wrapper div.item-list-tabs ul li span {
font-family: open-sansregular;
}
.bp-wrapper a.button, .button.submit, .bp-wrapper .generic-button a, .bp-wrapper ul.button-nav li a, 
.bp-wrapper .item-list a.button, .bp-wrapper .item-list .acomment-options a, .widget .item-options a, 
.widget .swa-wrap ul#activity-filter-links a, .widget .swa-activity-list li.mini div.swa-activity-meta a, 
.widget .swa-activity-list div.swa-activity-meta a.acomment-reply, 
.widget .swa-activity-list div.acomment-options a{
border: 0.5px solid #2C6500;
background: #0f4207;
background: -webkit-gradient(linear, left top, left bottom, from(#94e241), to(#0f4207));
background: -webkit-linear-gradient(top, #94e241, #175d0c);
background: -moz-linear-gradient(top, #94e241, #175d0c);
background: -ms-linear-gradient(top, #94e241, #175d0c);
background: -o-linear-gradient(top, #94e241, #175d0c);
padding: 5px 20px 5px 20px;
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
-webkit-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
-moz-box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.8);
text-shadow: 1px 0 5px rgba(0, 0, 0, 0.4);
color: #FFFFFF;
font-size: 20px;
font-family: open_sansregular;
text-decoration: none;
vertical-align: middle;
text-align: center;
}
.bp-wrapper ul.button-nav li a:hover {
   background: #2c6500;
   color: #ffffff;
   border:none;  
   }
.bp-wrapper ul.item-list {
width: 100%;
border-bottom: 1px solid #eee;
}
.bp-wrapper #item-body h3 {
font-family: open-sansregular;
}
	.bp-wrapper table tr td, .bp-wrapper table tr th {
padding: 10px;
font-family: open-sansregular;
}
/**********Tours 5 **********************************/
.page-id-2606 .connect-tour {
    width: 100%;
}


*{
		padding:0px;
		margin:0px;
		outline:none;
		border:none;
		list-style:none;
	}
	



">
	<div class="avatar_name">HI Ryan <br>
 <div class="drop_arrow">
              <svg class="svg-triangle" fill="white">
                <polygon points="0,0 18,0 10,13"/>
              </svg>
            </div><!-- end of drop arrow -->
</div><!-- end of ryan_name -->

 <div class="avatar_image">
<img src="<?php bloginfo('template_url'); ?>/images/ryan_image.png" alt="image" />
 </div><!-- end of ryan_image -->

</div><!-- end of ryan -->	
                        
                        
					</div>
					
					<!-- END NAV -->
					
				</div>
				
				<!-- BEGIN HEADER RIGHT -->
				
			
				<!-- BEGIN TOP CONTENT -->
				
				<?php if($gp_settings['top_content_panel'] == "Show") { ?>
					
					<div id="top-content" class="<?php if(get_post_meta($post->ID, 'ghostpool_top_content', true)) { ?> top-content-stripes<?php } ?><?php if($gp_settings['title'] == "Show") { ?> page-title-width<?php } ?>">
						
						
						<!-- BEGIN TOP CONTENT LEFT -->
						
						<?php if($gp_settings['title'] == "Show") { ?>
						
						
							<div class="left">
							
							
								<!-- BEGIN TITLE -->
	
								<h1 class="page-title">
									<?php if(is_single() OR is_page()) { ?>
										<?php the_title(); ?>
									<?php } elseif(is_search()) { ?>
										<?php echo $wp_query->found_posts; ?> <?php _e('search results for', 'gp_lang'); ?> "<?php echo esc_html($s); ?>"
									<?php } elseif(is_category()) { ?>
										<?php single_cat_title(); ?>
									<?php } elseif(is_tag()) { ?>
										<?php single_tag_title(); ?>
									<?php } elseif(is_author()) { ?>
										<?php wp_title(''); ?><?php _e('\'s Posts'); ?>
									<?php } elseif(is_404()) { ?>
										<?php _e('Page Not Found', 'gp_lang'); ?>
									<?php } elseif(function_exists('is_bbpress') && is_bbpress()) { ?>
										<?php wp_title(''); ?>									
									<?php } elseif(is_archive()) { ?>
										<?php _e('Archives', 'gp_lang'); ?> <?php wp_title(' / '); ?>			
									<?php } ?>
								</h1>	
								
								<!-- END TITLE -->
												
			
								<!-- BEGIN POST META -->
	
								<?php if(is_singular() && ($gp_settings['meta_date'] == "0" OR $gp_settings['meta_author'] == "0" OR $gp_settings['meta_cats'] == "0" OR $gp_settings['meta_comments'] == "0")) { ?>
									<div class="post-meta">
										<?php if($gp_settings['meta_author'] == "0") { ?><span class="author-icon"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_meta('display_name', $post->post_author); ?></a></span><?php } ?>
										<?php if($gp_settings['meta_date'] == "0") { ?><span class="clock-icon"><?php the_time(get_option('date_format')); ?></span><?php } ?>
										<?php if($gp_settings['meta_cats'] == "0") { ?><span class="folder-icon"><?php the_category(', '); ?></span><?php } ?>
										<?php if($gp_settings['meta_comments'] == "0" && 'open' == $post->comment_status) { ?><span class="speech-icon"><?php comments_popup_link(__('0', 'gp_lang'), __('1', 'gp_lang'), __('%', 'gp_lang'), 'comments-link', ''); ?></span><?php } ?>
									</div>
								<?php } ?>
								
								<!-- END POST META -->
						
						
							</div>
							
						
						<?php } ?>
						
						<!-- END TOP CONTENT LEFT -->
						
						
						<!-- BEGIN TOP CONTENT RIGHT -->
						
						<?php if($gp_settings['search'] == "Show" OR $gp_settings['breadcrumbs'] == "Show") { ?>
						
						
							<div class="right">
								
								
								<!-- BEGIN SEARCH FORM -->
								
								<?php if($gp_settings['search'] == "Show") { ?>
								
									<?php if(function_exists('bp_is_active')) { ?>
		
										<form action="<?php echo bp_search_form_action(); ?>" method="post" id="searchform" class="bp-searchform">
											<input type="text" id="searchbar" name="search-terms" value="<?php echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" />
											<?php echo bp_search_form_type_select(); ?>
											<input type="submit" name="searchsubmit" id="searchsubmit" value="<?php _e( 'Search', 'buddypress' ); ?>" />
											<?php wp_nonce_field( 'bp_search_form' ); ?>
										</form>
										
									<?php } else { ?>
									
										<?php get_search_form(); ?>
									
									<?php } ?>
									
								<?php } ?>
								
								<!-- END SEARCH FORM -->
								
								
								<!-- BEGIN BREADCRUMBS -->
								
								<?php if($gp_settings['breadcrumbs'] == "Show") { ?>
									<div id="breadcrumbs"><?php echo the_breadcrumb(); ?></div>
								<?php } ?>
								
								<!-- END BREADCRUMBS -->
								
							
							</div>
						
						
						<?php } ?>
						
						<!-- END TOP CONTENT RIGHT -->
						
							
						<div class="clear"></div>
						
						
						<?php echo stripslashes(do_shortcode(get_post_meta($post->ID, 'ghostpool_top_content', true))); ?>
						
			
					</div>
				
				<?php } ?>
				
				<!-- END TOP CONTENT -->
				
				
				<div class="clear"></div>
		
			</div>
			
			<!-- BEGIN HEADER INNER -->
			
		
		
	
	
	</div>


	<!-- END HEADER OUTER -->


	<!-- BEGIN PAGE OUTER -->
	
	<div class="page-outer">
	
		
		<!-- BEGIN PAGE INNER -->
		
		<div class="page-inner">
		
			
			<!-- BEGIN CONTENT WRAPPER -->
			
	<div id="content-wrapper">


<div class="focus_text">

<cite class="header-tour"><?php the_title() ?>
<div class="bullet-icon">
<?php	$id;	$varID;		$i						=	0;	$current_page_odr 		= 	$post->menu_order;	$_SESSION['child_id'] 	=	'';	$flag               	= 	'true';	$_SESSION['next'] 		= 	'';		if($post->post_parent!=0){		$varID=$post->post_parent;	}else{		$varID=$post->ID;	}		$mypages 			= get_pages( array( 'child_of' => $varID, 'sort_column' => 'menu_order', 'sort_order' => 'asc' ) );	foreach( $mypages as $page ) {				if($i==0){				$_SESSION['child_id'] = $page->ID;				$i++;			}		$content = $page->post_content;		if ( ! $content ) // Check for empty page			continue;		$content = apply_filters( 'the_content', $content );		$order = $page->menu_order;	?>	<a href="<?php echo get_page_link( $page->ID ); ?>"  class="<?php if($page->ID == $varID ){echo 'icon-circle';} else {echo'icon-circle-blank';} ?>"></a><?php	if($order > $current_page_odr && $flag == 'true'){		if(get_page_link( $page->ID )){			$_SESSION['next'] = get_page_link( $page->ID );		}		$flag = 'false';	}		$last = get_page_link( $page->ID );	}	//echo $_SESSION['child_id'];exit;?>
</div><!-- bullet-icon -->				<div class="skiptour">				<span><a href="<?php echo $last; ?>">Skip Tour</a></span>				</div><!-- skiptour --> </cite>    <div class="clear"></div></div>

<?php } ?>	