<?php // Custom Post Types

function post_type_slide() {

	/////////////////////////////////////// Slide Post Type ///////////////////////////////////////
	
	
	register_post_type('slide', array(
		'labels' => array(
			'name' => __('Slides', 'gp_lang'),
			'singular_name' => __('Slide', 'gp_lang'),
			'all_items' => __('All Slides', 'gp_lang'),
			'add_new' => _x('Add New', 'slide', 'gp_lang'),
			'add_new_item' => __('Add New Slide', 'gp_lang'),
			'edit_item' => __('Edit Slide', 'gp_lang'),
			'new_item' => __('New Slide', 'gp_lang'),
			'view_item' => __('View Slide', 'gp_lang'),
			'search_items' => __('Search Slides', 'gp_lang'),
			'menu_name' => __('Slides', 'gp_lang')
		),	
		'public' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array("slug" => "slide"),
		'menu_position' => 20,
		'with_front' => true,
		'supports' => array('title', 'thumbnail', 'editor', 'author', 'custom-fields')
	));
	
	
	/////////////////////////////////////// Slide Categories ///////////////////////////////////////
	
	
	register_taxonomy('slide_categories', 'slide', array(
		'labels' => array(
			'name' => __('Slide Categories', 'gp_lang'),
			'singular_name' => __('Slide Category', 'gp_lang'),
			'all_items' => __('All Slide Categories', 'gp_lang'),
			'add_new' => _x('Add New', 'slide', 'gp_lang'),
			'add_new_item' => __('Add New Slide Category', 'gp_lang'),
			'edit_item' => __('Edit Slide Category', 'gp_lang'),
			'new_item' => __('New Slide Category', 'gp_lang'),
			'view_item' => __('View Slide Category', 'gp_lang'),
			'search_items' => __('Search Slide Categories', 'gp_lang'),
			'menu_name' => __('Slide Categories', 'gp_lang')
		),
		'show_in_nav_menus' => false,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'slide-categories')
	));


	/////////////////////////////////////// Slide Page Layout ///////////////////////////////////////
	
	
	add_filter("manage_edit-slide_columns", "slide_edit_columns");
	add_action("manage_posts_custom_column",  "slide_custom_columns");
	
	function slide_edit_columns($columns){
			$columns = array(
				"cb" => "<input type=\"checkbox\" />",
				"title" => __('Title', 'gp_lang'),
				"slide_desc" => __('Description', 'gp_lang'),	
				"slide_categories" => __('Categories', 'gp_lang'),
				"slide_image" => __('Image', 'gp_lang'),				
				"date" => __('Date', 'gp_lang')
			);
	
			return $columns;
	}
	
	function slide_custom_columns($column){
			global $post, $gp_settings;
			switch ($column)
			{
				case "slide_desc":
					if(get_the_excerpt()) { echo excerpt(125); }
					break;
				case "slide_categories":
					echo get_the_term_list($post->ID, 'slide_categories', '', ', ', '');
					break;
				case "slide_image":
					if(has_post_thumbnail()) {
						$image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), 100, 100, true, true);
						echo '<img src="'.$image.'" width="50" height="50" alt="" />';
					}				
			}
	}

}

add_action('init', 'post_type_slide');


/////////////////////////////////////// Slide Order Menu ///////////////////////////////////////
	
	
function gp_enable_slide_sort() {
    add_submenu_page('edit.php?post_type=slide', __('Order Slides', 'gp_lang'), __('Order Slides', 'gp_lang'), 'edit_posts', basename(__FILE__), 'gp_sort_slides');
}
add_action('admin_menu' , 'gp_enable_slide_sort'); 
 
function gp_sort_slides() {
	
	$slides = new WP_Query('post_type=slide&posts_per_page=-1&orderby=menu_order&order=ASC');

?>
	<div id="gp-theme-options" class="wrap">
	
		<div id="icon-edit" class="icon32"><br></div> <h2><?php _e('Order Slides', 'gp_lang'); ?> <img src="<?php echo site_url(); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
		
		<ul id="sort-list">
		
			<?php if($slides->have_posts()) : while ($slides->have_posts()) : $slides->the_post(); 
			global $post, $gp_settings;
			$nonce = wp_create_nonce('my-nonce');
			require(gp_inc . 'options.php'); ?>
			
				<li id="<?php the_ID(); ?>">
					
					<?php if(has_post_thumbnail()) {
						$image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), 100, 100, true, true, true);
						echo '<img src="'.$image.'" width="50" height="50" alt="" />';
					} ?>
					
					<span>
						<h4 style="margin: 0 0 10px 0;"><?php the_title(); ?></h4>
						<a href="<?php echo site_url(); ?>/wp-admin/post.php?post=<?php the_ID(); ?>&action=edit"><?php _e('Edit', 'gp_lang'); ?></a>					
					</span>
					
					<div class="clear"></div>
				
				</li>	
				
			<?php endwhile; endif; wp_reset_query; ?>
			
		</ul>
		
	</div>
 
<?php
}

// Queue up administration CSS
function gp_slides_print_styles() {
	global $pagenow;
 
	$pages = array('edit.php', 'admin.php');
	if (in_array($pagenow, $pages))
		wp_enqueue_style('gp_slides', get_template_directory_uri().'/lib/admin/css/admin.css');
}
add_action('admin_print_styles', 'gp_slides_print_styles');

// Queue up administration JavaScript file
function gp_slides_print_scripts() {
	global $pagenow;
 
	$pages = array('edit.php', 'admin.php');
	if (in_array($pagenow, $pages)) {
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('gp_slides', get_template_directory_uri().'/lib/admin/scripts/sort-slides.js');
	}
}
add_action('admin_print_scripts', 'gp_slides_print_scripts');

function gp_save_slide_order() {
	global $wpdb;
 
	$order = explode(',', $_POST['order']);
	$counter = 0;
 
	foreach ($order as $slide_id) {
		$wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $slide_id));
		$counter++;
	}
	die(1);
}
add_action('wp_ajax_slide_sort', 'gp_save_slide_order');

?>