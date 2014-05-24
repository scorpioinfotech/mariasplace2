<?php
/**
 * @package Atlas
 */

$layout_nums = 35;

$layout_pic_resize = 260;

$overall_rating = tdp_get_rating(); 

?>

<div class="single-listing <?php if(get_field('listing_is_featured')) { echo "featured-listing";} ?> taxonomy-view-list <?php if($overall_rating !== 0 ) {echo 'has-rating'; } ?>" id="listing-<?php the_ID();?>">

	<?php if(get_field('listing_is_featured')) { ?>

		<div class="featured-star">
			<?php _e('Featured Listing','atlas');?>
			<span class="icon-ok"></span>
		</div>

	<?php } ?>

	<div class="one_fourth">

		<div class="single-image">
		<?php if( has_post_thumbnail() ) { ?>

			<?php

			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, $layout_pic_resize, 180, true ); //resize & crop the image

			?>
				<figure>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image ">
					</a>
				</figure>
		<?php } else { ?>
			<figure>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<img src="http://placehold.it/260x180" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image ">
					</a>
			</figure>
		<?php } ?>
		</div>

	</div>

	<div class="two_fourth item-content">
		
		<h4 class="single-title"><a href="<?php the_permalink();?>"><?php the_title();?> </a></h4>
		<h5 class="single-location"><?php $single_location = get_field('location');  echo $single_location['address']; ?></h5>

		<div class="single-desc">

			<?php $text_desc = get_the_content(); $trimmed_desc = wp_trim_words( $text_desc, $num_words = $layout_nums, $more = null ); echo stripslashes($trimmed_desc); ?>

		</div>

	</div>

	<div class="one_fourth last item-rating-container">

		<?php if(get_field('enable_ratings_system','option')) { ?>
				<ul class="rating-list">
                            <?php if($overall_rating == '1') { ?>
                                <li class="single-star"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '2') { ?>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '3') { ?>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '4') { ?>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '5') { ?>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                                <li class="single-star"><span class="icon-star"></span></li>
                            <?php } else { ?>
                            	<li class="item-no-rating"><?php _e('No rating yet.','atlas');?></li>
                           <?php } ?>
				</ul>
				<?php } ?>

		<a href="<?php the_permalink();?>" class="button medium black"><?php _e('Read More &raquo','atlas');?></a>

	</div>

	<div class="clear"></div>

</div>