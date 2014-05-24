<?php
/*
Template Name: Seach Form Page
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

		<?php if(get_field('inner_page_layout') == 'Sidebar Left') { ?>

			<div class="one_third" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Page Sidebar' ); ?>
			</div>

		<?php } ?>

		<div id="content-container" class="<?php if(get_field('inner_page_layout') == 'Sidebar Left') { echo 'two_third last'; } else if(get_field('inner_page_layout') == 'Sidebar Right') { echo 'two_third'; } ?>">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

						<?php get_template_part( 'content', 'page' ); ?>

						<div id="search-popup" class="front-form">

						        <h4><?php _e('Search For Listings','atlas');?></h4>

						        <div class="search-content">

						           <?php
							
										$args = tdp_search_fields();
										$my_search = new WP_Advanced_Search($args);
										$my_search->the_form();
													
									?>
						            
						        </div>

						</div>


					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

		</div>

		<?php if(get_field('inner_page_layout') == 'Sidebar Right'  ) { ?>

			<div class="one_third last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Page Sidebar' ); ?>
			</div>

		<?php } ?>

		<div class="clearboth"></div>

	</div>

</section>

<?php get_footer(); ?>