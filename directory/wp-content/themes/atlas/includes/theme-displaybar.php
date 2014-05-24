<?php 

$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$term_slug = $queried_object->term_slug;
$term_name = $queried_object->term_name;

$is_paged = get_query_var( 'paged' );

//display query sorter only if ajax is enabled
$set_sort_layout = null;
if(get_field('enable_ajax_map','option')) {
	$set_sort_layout = 'one_third';
} else {
	$set_sort_layout = 'three_fourth';
}

?>

<section id="display-bar">

	<div class="wrapper">

		<div class="<?php echo $set_sort_layout;?>" id="smart-breadcrumb">
			<?php if (function_exists('tdp_breadcrumbs')) tdp_breadcrumbs(); ?>
		</div>

		<?php if(get_field('enable_ajax_map','option')) { ?>

		<div class="one_third" id="query-changer">

			<select id="query-sort">
			
				<option value="time_newest"><?php _e('Order By: Newest First','atlas');?></option>
				<option value="time_oldest"><?php _e('Order By: Oldest First','atlas');?></option>
				<option value="name_az"><?php _e('Order By: Name A-Z','atlas');?></option>
				<option value="name_za"><?php _e('Order By: Name Z-A','atlas');?></option>
				<option value="featured"><?php _e('Featured Listings Only','atlas');?></option>

			</select>

			<i class="icon-sort"></i>

		</div>

		<?php } ?>

		<div class="<?php if($set_sort_layout == 'one_third') { echo $set_sort_layout; } else { echo 'one_fourth'; } ?> last" id="layout-changer">
			
			<?php if(get_field('enable_ajax_map','option')) { ?>

				<a href="#" class="ajax-sort" data-clicked="" data-sort="grid" data-term-id="<?php echo $term_id;?>" data-taxonomy="<?php echo $taxonomy;?>" data-paged="<?php echo $is_paged;?>"><span class="icon-th"></span><?php _e('Grid View','atlas');?></a>
				<a href="#" class="ajax-sort last-selector" data-clicked="" data-sort="list" data-term-id="<?php echo $term_id;?>" data-taxonomy="<?php echo $taxonomy;?>" data-paged="<?php echo $is_paged;?>"><span class="icon-th-list"></span><?php _e('List View','atlas');?></a>

			<?php } else { ?>

				<a href="<?php echo add_query_arg( 'listview', 'grid' );?>"><span class="icon-th"></span><?php _e('Grid View','atlas');?></a>
				<a href="<?php echo add_query_arg( 'listview', 'list' );?>"><span class="icon-th-list"></span><?php _e('List View','atlas');?></a>

			<?php } ?>
			
		</div>	

		<div class="clear"></div>

	</div>

</section>