<?php
/**
 * Template Name: All Listings
 *
 * @package Atlas
 */
get_header();

$layout_ini = get_field('taxonomy_layout','option');
$set_layout = str_replace(' ', '', $layout_ini);

// Set grid layout column size based on page layout

if(get_field('taxonomy_layout','option') !== 'Fullwidth') { 

	$grid_set_column = 'one_third';
	$row_num = 3;

} else {

	$grid_set_column = 'one_fourth';
	$row_num = 4;

}
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

		<?php if(get_field('taxonomy_layout','option') == 'Sidebar Left') { ?>

			<div class="one_third" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Listings Sidebar' ); ?>
			</div>

		<?php } ?>

		<div id="content-container" class="<?php if(get_field('taxonomy_layout','option') == 'Sidebar Left') { echo 'two_third last'; } else if(get_field('taxonomy_layout','option') == 'Sidebar Right') { echo 'two_third'; } ?>">

			<?php 

			$args = array( 'post_type' => 'listing', 'posts_per_page' => get_field('listings_per_page','option'));
			
			$listing_loop = new WP_Query( $args );

			if(

						$listing_loop->have_posts()) :

						$clear_row = '';
						$clear_row_end = '';

						while ( $listing_loop->have_posts() ) : $listing_loop->the_post(); $clear_row++; $clear_row_end++;

							//Lets check if the user has selected a different layout

							//display list view
							if (isset($_GET['listview']) && $_GET['listview'] == "list") {
    							
    							get_template_part( 'content', 'listing-list-view' );
							
							//Display grid view
							} else if (isset($_GET['listview']) && $_GET['listview'] == "grid") { ?>

							<div class="grid-column <?php echo $grid_set_column; ?> <?php if($clear_row == $row_num ) { echo " last"; $clear_row = 0; } ?>">
							<?php get_template_part( 'content', 'listing-list-grid' ); ?>
							</div>

							<?php if($clear_row_end == $row_num) { echo '<div class="clear"></div>'; $clear_row_end = 0; } ?>

							<?php } else {

								get_template_part( 'content', 'listing-list-view' );

							}

						endwhile;

						if(function_exists('wp_pagenavi')) {

							echo '<div class="clear"></div>';

							wp_pagenavi();

						} else {

							echo '<p>WP PAGE NAVI PLUGIN REQUIRED. Please Install it.</p>';

						}

					?>

					<?php else : ?>

						<h1 class="entry-title">

							<span class="error-title"><i class="icon-attention"></i></span>

							<?php _e( 'Oops! It looks like nothing was found.', 'atlas' ); ?>

						</h1>

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

					<?php endif; ?>

		</div>

		<?php if(get_field('taxonomy_layout','option') == 'Sidebar Right'  ) { ?>

			<div class="one_third last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Listings Sidebar' ); ?>
			</div>

		<?php } ?>

		<div class="clearboth"></div>

	</div>

</section>

<?php get_footer(); ?>