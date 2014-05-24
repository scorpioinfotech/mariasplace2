<?php
/**
 * @package Atlas
 */
?>

<div class="last post-content">

	<?php if( has_post_thumbnail() ) { ?>

			<?php

			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, get_field('featured_image_width','option'), get_field('featured_image_height','option'), true ); //resize & crop the image

			?>

			<div class="post-image">
        		
				<figure>

					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<div class="overlay"><div class="thumb-info"><i class="icon-right-circled"></i></div></div>
						<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
					</a>

				</figure>

			</div>

	<?php } else { ?>
	<?php } ?>



	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'atlas' ) ); ?>
		
	<?php wp_link_pages( array('before' => '<div class="page-links">' . __( 'Pages:', 'atlas' ), 'after'  => '</div>', ) ); ?>
</div>

