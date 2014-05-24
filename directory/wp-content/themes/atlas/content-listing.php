<?php
/**
 * @package Atlas
 */
?>

<div class="single-listing <?php if(get_field('listing_is_featured')) { echo "featured-listing";} ?>" id="listing-<?php the_ID();?>">

	<?php if(get_field('listing_is_featured')) { ?>

		<div class="featured-star">
			<?php _e('Featured Listing','atlas');?>
			<span class="icon-star"></span>
		</div>

	<?php } ?>

	<div class="single-image">
		<?php if( has_post_thumbnail() ) { ?>

			<?php

			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 300, 200, true ); //resize & crop the image

			?>

				<figure>

					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<div class="overlay"><div class="thumb-info"><i class="icon-eye"></i></div></div>
						<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image ">
					</a>

				</figure>


	<?php } else { ?>
	<?php } ?>
	</div>

	<div class="single-content">

		<h3 class="single-title">

			<a href="<?php the_permalink();?>"><?php the_title();?></a>

			<span class="address">

				<?php $single_location = get_field('location'); 

					echo $single_location['address'];

				?>

			</span>

		</h3>

		<div class="single-desc">

			<?php $text_desc = get_the_content(); $trimmed_desc = wp_trim_words( $text_desc, $num_words = 35, $more = null ); echo stripslashes($trimmed_desc); ?>

		</div>

	</div>

	<div class="single-rating">

		<div class="top-layer">

			<?php if(get_field('enable_ratings_system','option')) { ?>
				<ul class="rating-list">
					<?php 
					$overall_rating = tdp_get_rating(); 
					?>
                            <?php if($overall_rating == '1') { ?>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '2') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '3') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '4') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '5') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else { ?>
                            	<li><?php _e('No rating yet.','atlas');?></li>
                           <?php } ?>
				</ul>
				<?php } ?>

		</div>

		<div class="bottom-layer">

			<a href="<?php the_permalink();?>" class="button medium black"><?php _e('Read More &raquo','atlas');?></a>

		</div>

	</div>

	<div class="clearboth"></div>

</div>