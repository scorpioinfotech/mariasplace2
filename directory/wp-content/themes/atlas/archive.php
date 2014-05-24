<?php
/**
 * The category file.
 *
 * @package Atlas
 */

get_header(); ?>

<?php if(get_field('blog_header_image','option')) { ?>

<script type="text/javascript">
jQuery(window).load(function() {
	jQuery("#intro-section").backstretch("<?php the_field('blog_image_url','option');?>");
});
</script>

<section id="intro-section"class="header-with-img">

<?php } else { ?>

<section id="intro-section">

<?php } ?>

	<div class="wrapper">
		
		<div class="animated fadeInDown">
		<?php the_field('blog_intro_text','option');?>
		</div>

	</div>

</section>

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

<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<?php if(get_field('blog_sidebar_position','option') == 'Sidebar Left') { ?>

			<div class="one_third" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Blog Sidebar' ); ?>
			</div>

		<?php } ?>



		<div id="content-container" class="<?php if(get_field('blog_sidebar_position','option') == 'Sidebar Right' || get_field('blog_sidebar_position','option') == '') { echo 'two_third'; } else {echo "two_third last";} ?>">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

		</div>

		<?php if(get_field('blog_sidebar_position','option') == 'Sidebar Right' || get_field('blog_sidebar_position','option') == '') { ?>

			<div class="one_third last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Blog Sidebar' ); ?>
			</div>

		<?php } ?>

		<div class="clearboth"></div>

	</div>

</section>

<?php get_footer(); ?>