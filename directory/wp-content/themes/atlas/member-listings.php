<?php
/**
 * The template for displaying all member's listing.
 *
 * @package Atlas
 */
get_header();

$user_is = bp_get_displayed_user_fullname();
$displayed = __('Listings Submitted By %s','atlas');

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

<section id="listing-brief">

	<div class="wrapper">

		<div class="two_third">

			<div class="animated fadeInDown">

				<h1><?php echo sprintf($displayed, $user_is);?> <a href="<?php global $bp; echo $bp->displayed_user->domain;?>" class="button">View Profile</a></h1>

			</div>

		</div>

		<div class="one_third last" id="right-counter">

		</div>

		<div class="clearboth"></div>

	</div><!-- end wrapper -->

</section> <!-- end listing brief -->

<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<?php if(get_field('inner_page_layout') == 'Sidebar Left') { ?>

			<div class="one_third" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Page Sidebar' ); ?>
			</div>

		<?php } ?>

		<div id="content-container" class="<?php if(get_field('inner_page_layout') == 'Sidebar Left') { echo 'two_third last'; } else if(get_field('inner_page_layout') == 'Sidebar Right') { echo 'two_third'; } ?>">

			<article <?php post_class();?>>

				<div class="styled-table">
           	 		<table id="dashboard-table" class="efe-table <?php echo $post_type; ?>" cellpadding="0" cellspacing="0">
                		<thead>
                    		<tr>
                    			 <th><?php _e('Listing Title','atlas');?></th>
                    			 <th><?php _e('View Listing','atlas');?></th>
                    		</tr>
                    	</thead>

                    	<tbody>
                    		
                    			<?php 

                    				global $bp;

                    				$efe_pagination = isset( $_GET['efe_pagination'] ) ? intval( $_GET['efe_pagination'] ) : 1;

                    				$args = array(
							            'author' => $bp->displayed_user->id,
							            'post_status' => array('publish'),
							            'post_type' => 'listing',
							            'posts_per_page' => get_field('efe_posts_per_page','option'),
							            'paged' => $efe_pagination
							        );

							        $dashboard_query = new WP_Query(  $args );

        						?>

        						<?php if ( $dashboard_query->have_posts() ) { ?>

        							<?php
				                    while ($dashboard_query->have_posts()) {
				                        $dashboard_query->the_post(); ?>

                    				<tr>
		                    			<td><a href="<?php the_permalink();?>"><?php the_title();?></a></td>
		                    			<td><a href="<?php the_permalink();?>" class="button normal"><?php _e('View Listing','atlas');?></a></td>
		                    		</tr>

		                    		<?php
				                    }
				                    wp_reset_postdata();
				                    ?>

				                <?php } ?>

                    	</tbody>

                    </table>

                    <div class="efe-pagination">
		                <?php
		                $pagination = paginate_links( array(
		                    'base' => add_query_arg( 'efe_pagination', '%#%' ),
		                    'format' => '',
		                    'prev_text' => __( '&laquo;', 'atlas' ),
		                    'next_text' => __( '&raquo;', 'atlas' ),
		                    'total' => $dashboard_query->max_num_pages,
		                    'current' => $efe_pagination
		                ) );

		                if ( $pagination ) {
		                    echo $pagination;
		                }
		                ?>
		            </div>					

			</article>

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