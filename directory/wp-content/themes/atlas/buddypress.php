<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Atlas
 */
get_header();

?>
<section id="breadcrumb">

	<div class="wrapper">
		
		<div class="one_half">
	
			<?php if (function_exists('tdp_breadcrumbs')) tdp_breadcrumbs(); ?>
	
		</div>

		<div class="one_half last">
		</div>

		<div class="clearboth"></div>

	</div>

</section>
<?php get_template_part( 'includes/top', 'singlepage' ); ?>
<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<div id="content-container" class="two_third">

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

			<div class="one_third last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'BuddyPress Sidebar' ); ?>
			</div>

		<div class="clearboth"></div>

	</div>

</section>
<?php get_footer(); ?>