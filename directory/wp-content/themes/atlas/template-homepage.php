<?php
/*
Template Name: Homepage
 * @package Atlas
 */

	get_header();

	$extra_class = null;
	if(is_admin_bar_showing()) {
		$extra_class = 'admin-bar-showing';
	}

	$side_class = null;
	if(!get_field('display_topbar','option')) {
		$side_class = ' top-bar-hidden';
	}

?>

<?php if(get_field('display_homepage_sidebar','option')) { ?>

<section id="home-sidebar" class="header-left <?php echo $extra_class; echo $side_class; ?>">

	<div id="side-navigation">

		<?php if(get_field('home_sidebar_display_default_content','option')) { ?>
		
			<?php get_template_part( 'includes/default', 'tabs' );?>

		<?php } else { ?>

			<?php get_template_part( 'includes/custom', 'tabs' );?>

		<?php } ?>

	</div>

</section>

<?php } ?>

<section id="home-outer-wrap<?php if(!get_field('display_homepage_sidebar','option')) {echo "-noside"; } ?>">

	<?php if(get_field('display_homepage_sidebar','option')) { ?>

	<span class="toggle-activator <?php if(get_field('street_view_control','option')) { echo 'push1'; } ?>">

		<span class="toggle-button"></span>

	</span>

	<?php } ?>
	
	<a href="#search-popup" id="open-search" <?php if(get_field('street_view_control','option')) { echo 'class="push2"'; } ?>><span class="icon-search"></span></a>

	<div id="map"></div>

	<?php 

		//check if ajax map is enabled otherwise load normal map system

		if(get_field('enable_ajax_map','option')) {

			do_action('tdp_after_taxonomy_map');

		} else {

			get_template_part( 'includes/map', 'loader' );

		}

	?>

</section>

<?php get_template_part( 'includes/search', 'listings' );?>

<?php get_footer('mini');?>