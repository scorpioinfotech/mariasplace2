<?php
/*
Template Name: Edit Listing Page
 *
 * @package Atlas
 */
acf_form_head();
get_header(); 

global $wpdb, $tdp_levels, $tdp_currency_symbol;

$current_allowance_left = $current_user->allowance_limit;

$current_user_membership = $current_user->membership_level;

global $wp_query;

$postdata = get_post($_GET['pid'], ARRAY_A);
$authorID = $postdata['post_author'];

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

						<?php

						//lets check if the user is editing a post or if he is just visiting this page
						//if it's editing the post show the form
						if (isset($_GET['pid']) && !empty($_GET['pid'])) {

							//now we need to check if the current logged in user is the post author
							//we also need to check that he is not trying to hack the ID

							if($authorID == $current_user->ID) {
								
								$args_edit = array(
									'post_id' => $_GET['pid'],
									'field_groups' => array( 'acf_listing-settings', 'acf_listing-images' ),
									'submit_value' => __('Update This Listing &raquo;','atlas'), // value for submit field
								);

								acf_form( $args_edit ); 
							
							} else { ?>

								<div id="content-container" class="error-container">

									<h1 class="entry-title">

										<span class="error-title"><i class="icon-frown"></i></span>

										<?php _e( 'Unauthorized Access', 'atlas' ); ?>

									</h1>

									<p><?php _e('You are not allowed to edit this listing.','atlas');?></p>

								</div>

							<?php }

						} else if(isset($_GET['updated']) && $_GET['updated'] == 'true') { ?>

							<div id="content-container" class="error-container">

									<h1 class="entry-title">

										<span class="error-title"><i class="icon-ok"></i></span>

										<?php _e( 'Listing Successfully Edited', 'atlas' ); ?>

									</h1>

									<?php the_field('successful_listing_edit_confirmation_message','option'); ?>

									<?php if(is_user_logged_in()) { ?>
									<a href="<?php the_field('listings_management_page','option');?>" class="button black medium"><?php _e('Go to Listings Management &raquo;','atlas');?></a>
									<?php } ?>

							</div>

						<?php } else { ?>

							<div id="content-container" class="error-container">

									<h1 class="entry-title">

										<span class="error-title"><i class="icon-frown"></i></span>

										<?php _e( 'Unauthorized Access', 'atlas' ); ?>

									</h1>

									<p><?php _e('Visit the listings management page to modify a listing.','atlas');?></p>

									<?php if(is_user_logged_in()) { ?>
									<a href="<?php the_field('listings_management_page','option');?>" class="button black medium"><?php _e('Go to Listings Management &raquo;','atlas');?></a>
									<?php } ?>


							</div>

						<?php } ?>

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