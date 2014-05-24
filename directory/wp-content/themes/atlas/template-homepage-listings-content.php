<?php
/*
Template Name: Homepage With Map And Custom Content
 * @package Atlas
 */

get_header();

$sidebar_position = get_field('inner_page_layout');

?>

<section id="header-map" class="slidingDiv">

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

<div class="clear"></div>

<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<?php if($sidebar_position == 'Sidebar Left') { ?>

			<div class="one_third" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Page Sidebar' ); ?>
			</div>

		<?php } ?>


		<div id="content-container" class="<?php if($sidebar_position == 'Sidebar Left') { echo 'two_third last'; } else if($sidebar_position == 'Sidebar Right') { echo 'two_third'; } ?>">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

						<?php get_template_part( 'content', 'page' ); ?>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

		</div>

		<?php if($sidebar_position == 'Sidebar Right'  ) { ?>

			<div class="one_third last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Page Sidebar' ); ?>
			</div>

		<?php } ?>

		<div class="clearboth"></div>

	</div>

</section>

<?php get_template_part( 'includes/search', 'listings' );?>
<?php get_footer();?>