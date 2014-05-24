<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Atlas
 */

get_header(); 

$post_thumbnail_id = get_post_thumbnail_id();
$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );

$overall_rating_g = tdp_get_rating();

$count_rev = get_comments_number();

?>

<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate" class="hidden-rating">
    <span itemprop="itemreviewed"><?php the_title();?></span>
    <img itemprop="photo" src="<?php echo $post_thumbnail_url;?>" />
    <span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
    <span itemprop="average"><?php echo $overall_rating_g;?></span>
    <span itemprop="best">5</span></span>
    <span itemprop="votes"><?php echo $count_rev; ?></span> 
    <span itemprop="count"><?php echo $count_rev; ?></span> 
</div>  

<?php if(get_field('display_google_map_below_the_header','option')) { ?>

<section id="header-map" class="slidingDiv">

	<div id="map"></div>

	<?php get_template_part( 'includes/map', 'single' );?>

</section><!-- end header map -->

<?php } ?> 

<section id="breadcrumb">

	<div class="wrapper">
		
		<div class="one_half" id="bd-content">
	
			<?php if (function_exists('tdp_breadcrumbs')) tdp_breadcrumbs(); ?>
	
		</div>

		<div class="one_half last" id="bd-button">

			<?php 
				
				if(get_field('enable_favorites_system','option') && is_user_logged_in()) {
					tdp_fav_link();
				} else if(get_field('enable_favorites_system','option') && !is_user_logged_in()) {
					echo '<span class="tdp_fav-span"><a href="#" class="button small black" id="fav-nonlogged"><i class="icon-star"></i>'.__('Add To Favorites','framework').'</a></span>';
				}
				
			?>

			<?php if(get_field('enable_claim_listing_component','option')) { ?>
			<a class="button small black" href="#search-popup" id="open-claim"><span class="icon-megaphone"></span> <?php _e('Claim Listing','atlas');?></a>
			<?php } ?>

			<?php if(get_field('enable_print_listing_button','option')) { ?>
			<a class="button small black" href="javascript:window.print()"><span class="icon-print"></span> <?php _e('Print Listing','atlas');?></a>
			<?php } ?>

			<?php if(get_field('display_google_map_below_the_header','option') && get_field('location')) { ?>
			<a href="#" class="show_hide button small black" id="" data-toggle="tooltip" title="<?php _e('Display Map','atlas');?>"><span class="icon-location"></span> <?php _e('Display Map','atlas');?></a>
			<?php } ?> 

		</div>

		<div class="clearboth"></div>

	</div>

</section> <!-- end breadcrumb -->

<!-- load top section -->

<?php get_template_part( 'includes/top', 'single' ); ?>

<!-- end top section -->

<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<?php if(get_field('enable_favorites_system','option') && !is_user_logged_in()) { ?>

			<div class="wrapper" id="fav-logged-message">
				<div class="alert-message error"><?php _e('Only registered users can save listings to their favorites','atlas');?><span class="close" href="#"><i class="icon-cancel"></i></span></div>
			</div>

		<?php } ?>

		<?php if(get_field('single_listing_page_layout','option') == 'Sidebar Left') { ?>

			<div class="one_third" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Single Listing Sidebar' ); ?>
			</div>

		<?php } ?>

		<div id="content-container" class="<?php if(get_field('single_listing_page_layout','option') == 'Sidebar Right' || get_field('single_listing_page_layout','option') == '') { echo 'two_third'; } else {echo "two_third last";} ?>">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'single-listing' );


					?>


					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() )
							
							if(get_field('enable_ratings_system','option')) { 
								comments_template( '/rev-comments.php' );
							} else {


								if ( in_array( 'gd-star-rating/gd-star-rating.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && !get_field('enable_ratings_system','option') && get_field('enable_multi_ratings_system','option') && get_field('multi_rating_box_position','option') == 'Above Comment Form' ) {
								    wp_gdsr_render_multi(
										$multi_set_id = get_field('multi_set_id_number','option'),
										$template_id = 20,
										$read_only = false,
										$post_id = get_the_ID(),
										$stars_set = "",
										$stars_size = 0,
										$stars_set_ie6 = "",
										$avg_stars_set = "oxygen",
										$avg_stars_size = 20,
										$avg_stars_set_ie6 = "oxygen_gif",
										$echo = true	  
									);
								}


								comments_template();
							}
					?>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

		</div>

		<?php if(get_field('single_listing_page_layout','option') == 'Sidebar Right' || get_field('single_listing_page_layout','option') == '') { ?>

			<div class="one_third last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Single Listing Sidebar' ); ?>
			</div>

		<?php } ?>

		<div class="clearboth"></div>

	</div>

</section><!-- end page wrapper -->

<?php 

if(get_field('enable_claim_listing_component','option')) {

get_template_part( 'includes/theme', 'claimingform' );

}

?>

<?php get_footer(); ?>