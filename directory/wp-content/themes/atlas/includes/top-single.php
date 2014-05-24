<?php if(get_field('display_big_title','option')) { ?>
<section id="listing-brief" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">

	<div class="wrapper">

		<div class="two_third">

			<?php if(get_field('listing_is_featured') && get_field('display_featured_listing_tag','option')) { ?>
			<div class="featured-single">
				<?php _e('Featured Listing','atlas');?>
			</div>
			<?php } ?>

			<h1 itemprop="itemreviewed"><?php the_title();?></h1>

		</div>

		<div class="one_third last" id="right-counter">

		<?php 

			if ( in_array( 'gd-star-rating/gd-star-rating.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && !get_field('enable_ratings_system','option') && get_field('enable_multi_ratings_system','option') ) {

			echo '<div class="multi-rating-wrap">';
			wp_gdsr_multi_rating_average( 
				$multi_set_id = get_field('multi_set_id_number','option'),
				$post_id = get_the_ID(),
				$show = "total",
				$stars_set = "",
				$stars_size = 0,
				$stars_set_ie6 = "",
				$avg_stars_set = "oxygen",
				$avg_stars_size = 20,
				$avg_stars_set_ie6 = "oxygen_gif",
				$echo = true
			);

			echo "</div>";

			}

		?>	 

			<ul class="stats">

				<?php if(get_field('enable_ratings_system','option')) { ?>
				<li class="stats-rating">
					<?php 
					$overall_rating = tdp_get_rating(); 
					?>
						<ul>
							<li><?php _e('Rating','atlas');?></li>
                            <?php if($overall_rating == '1') { ?>
                                <li class="starpos"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '2') { ?>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '3') { ?>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '4') { ?>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                            <?php } else if($overall_rating == '5') { ?>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                                <li class="starpos"><span class="icon-star"></span></li>
                            <?php } else { ?>
                            	<li><?php _e('- Not Rated Yet','atlas');?></li>
                           <?php } ?>
                        </ul>
				</li>
				<?php } ?>



				<?php if(get_field('display_listings_views','option')) { ?>

				<li class="stats-counter">
					<?php 
						setPostViews(get_the_ID());
						echo getPostViews(get_the_ID()); 
					?>
				</li>

				<?php } ?>

			</ul>

			<span class="hidden-rating" itemprop="rating">
				<?php echo $overall_rating; ?>
			</span>

		</div>

		<div class="clearboth"></div>

	</div><!-- end wrapper -->


</section> <!-- end listing brief -->
<?php } ?>