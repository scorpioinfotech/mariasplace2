<?php
/**
 * @package Atlas
 */
?>

<div class="last post-content">

	<?php if ( has_post_thumbnail()) { ?>
   		
   		<?php

			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, get_field('featured_image_width','option'), get_field('featured_image_height','option'), true ); //resize & crop the image

			?>

		<div class="post-image">

			<a href="<?php echo $img_url; ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
								<img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
							</a>
		</div>

	<?php } else { ?>

		<div class="post-image">

				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<img src="http://placehold.it/<?php the_field('featured_image_width','option')?>x<?php the_field('featured_image_height','option');?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
				</a>

		</div>

	<?php } ?>

	<h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

	<div class="meta-wrapper">

		<ul>
			<li>
				<span class="post-time"><i class="icon-calendar"></i><?php _e('Posted:','atlas'); ?></span> <?php the_time('M'); ?> <?php the_time('d, Y'); ?>
			</li>
			<li>
				<span><i class="icon-user"></i><?php echo __('By: ', 'atlas'); ?></span> <?php the_author_posts_link(); ?>
			</li>
			<li>
				<span><i class="icon-chat"></i><?php echo __('Comments: ','atlas');?></span> <?php comments_popup_link(__('0', 'atlas'), __('1', 'atlas'), '% '.''); ?>
			</li>
		</ul>

	</div>

	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'atlas' ) ); ?>

	<?php the_tags(); ?>
		
	<?php wp_link_pages( array('before' => '<div class="page-links">' . __( 'Pages:', 'atlas' ), 'after'  => '</div>', ) ); ?>
</div>

