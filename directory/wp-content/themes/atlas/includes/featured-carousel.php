<?php
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$args_carousel = array( 

	'post_type' => 'listing', 
	'posts_per_page' => get_field('listings_per_page','option'), 
	'tax_query' => array(
		array(
			'taxonomy' => $taxonomy,
			'field' => 'id',
			'terms' => $term_id
		)
	),

	'meta_query' => array(
		array(
			'key' => 'listing_is_featured',
			'value' => 1,
			'compare' => '=',
		)
	)

);
$loop_carousel = new WP_Query( $args_carousel );
if($loop_carousel->have_posts()) {
?>
<div class="mds-divider style-dashed-lines2 length-long contenttype-text alignment-center">
	<div class="content" id="cat-title">
		<h3><?php _e('Featured','atlas');?> <?php single_cat_title();?></h3>
	</div>
	<div class="divider"></div>
</div>

<div class="list_carousel responsive">
	
	<ul id="foo4">
			
		<?php  while ( $loop_carousel->have_posts() ) : $loop_carousel->the_post(); ?>

			<li class="featured-item">

				<?php if(get_field('listing_is_featured')) { ?>

					<div class="featured-star">
						<?php _e('Featured Listing','atlas');?>
						<span class="icon-ok"></span>
					</div>

				<?php } ?>


				<div class="single-image">
				<?php if( has_post_thumbnail() ) { ?>

					<?php

					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
					$image = aq_resize( $img_url, 300, 180, true ); //resize & crop the image

					?>
						<figure>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image ">
							</a>
						</figure>
				<?php } else { ?>
				<?php } ?>
				</div>
				<div class="carousel-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>

				<div class="carousel-desc"><?php $text_desc = get_the_content(); $trimmed_desc = wp_trim_words( $text_desc, $num_words = 14, $more = null ); echo addslashes($trimmed_desc); ?></div>

			</li>

		<?php endwhile; ?>

	</ul>

	<div class="clear"></div>

</div>

<?php } else { ?>
		<!-- no featured elements -->
<?php } ?>