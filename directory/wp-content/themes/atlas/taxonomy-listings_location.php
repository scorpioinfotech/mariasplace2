<?php
/**
 * The category file.
 *
 * @package Atlas
 */

get_header(); 

global $post;

// vars
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$term_slug = $queried_object->term_slug;
$term_name = $queried_object->term_name;
 
// load thumbnail for this taxonomy term
$category_description = get_field('taxonomy_description', $taxonomy . '_' . $term_id);

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

<?php if(get_field('display_map_in_taxonomies_pages','option') && $category_slider == '') { ?>
	
<section id="header-map" class="slidingDiv <?php if(!have_posts()) {echo 'nothing-found';} ?>">

	<a href="#search-popup" id="open-search"><span class="icon-search"></span></a>
	
	<div id="map"></div>

	<?php 

		//check if ajax map is enabled otherwise load normal map system

		if(get_field('enable_ajax_map','option')) {

			do_action('tdp_after_taxonomy_map');

		} else {

			get_template_part( 'includes/map', 'taxonomy' );

		}

	?>

</section>

<?php } ?>

<?php if($category_slider !== '') {

	echo do_shortcode( $category_slider );
}

?>

<?php get_template_part( 'includes/theme', 'displaybar' );?>

<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<?php if(get_field('display_featured_listings_carousel','option')) {
						get_template_part( 'includes/featured', 'carousel' );
					} ?>

		<?php if(get_field('taxonomy_layout','option') == 'Sidebar Left') { ?>

			<div class="one_fourth" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Listings Sidebar' ); ?>
			</div>

		<?php } ?>

		<div id="content-container" class="<?php echo "is-".$set_layout.' '; if(get_field('taxonomy_layout','option') == 'Sidebar Left') { echo 'three_fourth last'; } else if(get_field('taxonomy_layout','option') == 'Sidebar Right') { echo 'three_fourth'; } ?>">

					<div class="mds-divider style-dashed-lines2 length-long contenttype-text alignment-center">
						<div class="content" id="cat-title">
							<h3><?php single_cat_title();?></h3>
						</div>
						<div class="divider"></div>
					</div>

					<div class="category-desc">
						<?php echo $category_description; ?>
					</div>

					<?php do_action( 'after_listing_category_desc' ); ?>

					<div id="listings-wrapper">
					<?php if(

						have_posts()) :

						$clear_row = '';
						$clear_row_end = '';

						while ( have_posts() ) : the_post(); $clear_row++; $clear_row_end++;

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

					?>
					</div>

					<?php 
					if(function_exists('wp_pagenavi')) {
						echo '<div class="clear"></div>';
						wp_pagenavi();
					} else {
						echo '<p>WP PAGE NAVI PLUGIN REQUIRED. Please Install it.</p>';
					} ?>

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

			<div class="one_fourth last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Listings Sidebar' ); ?>
			</div>

		<?php } ?>

		<div class="clearboth"></div>

	</div>

</section>
<?php get_template_part( 'includes/search', 'listings' );?>

<?php get_footer();?>