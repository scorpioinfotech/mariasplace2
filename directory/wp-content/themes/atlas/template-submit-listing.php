<?php
/*
Template Name: Submit Listing Page
 *
 * @package Atlas
 */
if(isset($_GET["submitted"])) {
	wp_redirect( get_field('redirect_on_submission','option') ); exit;
}

acf_form_head();
get_header(); 
 
global $wpdb, $tdp_levels, $tdp_currency_symbol;

$current_allowance_left = $current_user->allowance_limit;

$current_user_membership = $current_user->membership_level;

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

						$args = array(
							'post_id' => 'new_listing',
							'field_groups' => array( 'acf_listing-settings', 'acf_listing-images' ),
							'submit_value' => __('Submit Your Listing &raquo;','atlas'), // value for submit field
						);

						if(tdp_hasMembershipLevel() && $current_allowance_left != 0 ) {
							
							acf_form( $args ); 

						} else { ?>

							<div id="content-container" class="error-container">

									<h1 class="entry-title">

										<span class="error-title"><i class="icon-attention"></i></span>

										<?php _e( 'Unauthorized Access', 'atlas' ); ?>

									</h1>

									<?php the_field('membership_required_submission_message','option'); ?>

									<a href="<?php the_field('login_page_url','option');?>" class="button black small"><?php _e('Login Now &raquo;','atlas');?></a>
									<a href="<?php echo tdp_url('account');?>" class="button black small"><?php _e('Register New Account &raquo;','atlas');?></a> 
									<a href="<?php echo tdp_url('levels');?>" class="button black small"><?php _e('Renew Your Membership &raquo;','atlas');?></a>

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