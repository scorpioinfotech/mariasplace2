<?php
/**
 * @package Atlas
 */

$images = get_field('upload_images');

$rows = get_field('custom_fields_builder');

// email to a friend processing code
if(get_field('enable_send_to_a_friend_form','option')) { 

	// Contact form processing
			$f_name_error = '';
			$f_email_error = '';
			$f_subject_error = '';
			$f_message_error = '';
			if (!isset($_REQUEST['f_submitted'])) 
			{
			//If not isset -> set with dumy value 
			$_REQUEST['f_submitted'] = ""; 
			$_REQUEST['f_name'] = "";
			$_REQUEST['f_email'] = "";
			$_REQUEST['f_message'] = "";
			}

			if($_REQUEST['f_submitted']){

				//check name
				if(trim($_REQUEST['f_name'] === "")){
					//it's empty
					
					$f_name_error = __('You forgot to fill in your name', 'atlas');
					$f_error = true;
				}else{
					//its ok
					$f_name = trim($_REQUEST['f_name']);
				}

				//check email
				if(trim($_REQUEST['f_email'] === "")){
					//it's empty
					$f_email_error = __('Your forgot to fill in the email address of your friend', 'atlas');
					$f_error = true;
				}else if(!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_REQUEST['f_email']))){
					//it's wrong format
					$f_email_error = __('Wrong email format', 'atlas');
					$f_error = true;
				}else{
					//it's ok
					$f_email = trim($_REQUEST['f_email']);
				}


				//check name
				if(trim($_REQUEST['f_message'] === "")){
					//it's empty
					$f_message_error = __('You forgot to fill in your message', 'atlas');
					$f_error = true;
				}else{
					//it's ok
					$f_message = trim($_REQUEST['f_message']);
				}

				//if no errors occured
				if($f_error != true) {

					$f_email_to =  $f_email;
					if (!isset($f_email_to) || ($f_email_to == '') ){
						$f_email_to = get_option('admin_email');
					}
					$f_subject = __('Message from ', 'atlas') . $f_name;
					$f_message_body = "\n\n$f_message";
					$f_headers = 'From: '.get_bloginfo('name').' <'.$f_email.'>';

					wp_mail($f_email_to, $f_subject, $f_message_body, $f_headers);

					$f_email_sent = true;
				}

			}

}

?>

<?php if( has_post_thumbnail() ) { ?>

			<?php

			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, get_field('single_listing_image_width','option'), get_field('single_listing_image_height','option'), true ); //resize & crop the image

			?>

			<div class="post-image">
        		
				<div class="flexslider">
  					
  					<ul class="slides">

  						<li>
  							<a href="<?php echo $img_url; ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
								<img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
							</a>
						</li>

						<?php if( get_field('listing_image_2') ): ?>
							<li>
	  							<a href="<?php the_field('listing_image_2'); ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
									<img src="<?php the_field('listing_image_2'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
								</a>
							</li>
						<?php endif; ?>

						<?php if( get_field('listing_image_3') ): ?>
							<li>
	  							<a href="<?php the_field('listing_image_3'); ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
									<img src="<?php the_field('listing_image_3'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
								</a>
							</li>
						<?php endif; ?>

						<?php if( get_field('listing_image_4') ): ?>
							<li>
	  							<a href="<?php the_field('listing_image_4'); ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
									<img src="<?php the_field('listing_image_4'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
								</a>
							</li>
						<?php endif; ?>

						<?php if( get_field('listing_image_5') ): ?>
							<li>
	  							<a href="<?php the_field('listing_image_5'); ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
									<img src="<?php the_field('listing_image_5'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
								</a>
							</li>
						<?php endif; ?>


  					</ul>
				
				</div>

			</div>

	<?php } else { ?>

		<div class="post-image">

			<figure>
        		
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<img src="http://placehold.it/<?php the_field('featured_image_width','option')?>x<?php the_field('featured_image_height','option');?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
				</a>

			</figure>

		</div>

<?php } ?>

<div class="listing-content">

	<div itemprop="description">
		<?php the_content();?>
	</div>

	<?php 

	if ( in_array( 'gd-star-rating/gd-star-rating.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && !get_field('enable_ratings_system','option') && get_field('enable_multi_ratings_system','option') && get_field('multi_rating_box_position','option') == 'Below Listing Content' ) {
	    wp_gdsr_render_multi(
			$multi_set_id = get_field('multi_set_id_number','option'),
			$template_id = 20,
			$read_only = false,
			$post_id = get_the_ID(),
			$stars_set = "",
			$stars_size = 0,
			$stars_set_ie6 = "",
			$avg_stars_set = "oxygen",
			$avg_stars_size = 20,
			$avg_stars_set_ie6 = "oxygen_gif",
			$echo = true	  
		);
	}

	?>

	<?php 

	if(get_field('insert_video') !== 'novideo') {

		$video_provider = get_field('insert_video');
		$video_id = get_field('enter_the_video_id');
		$height = 315;
		$width = 560;

		if($video_provider == 'vimeo') {
			echo "<div class='video-embed'><iframe src='http://player.vimeo.com/video/$video_id?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";
		}else if($video_provider == 'youtube') {
			echo "<div class='video-embed'><iframe src='http://www.youtube.com/embed/$video_id?HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";
		} else if($video_provider == 'dailymotion') {
			echo "<div class='video-embed'><iframe src='http://www.dailymotion.com/embed/video/$video_id?width=$width&amp;autoPlay={0}&foreground=%23FFFFFF&highlight=%23CCCCCC&background=%23000000&logo=0&hideInfos=1' width='$width' height='$height' class='iframe'></iframe></div>";
		}

	}

	echo do_shortcode( '[divider title="" style="dotted-lines2" length="long" alignment="center" contenttype="default" heading="span" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' );
	
	?>

	<?php if(get_field('display_social_sharing_icons','option')) { ?>

	<div class="item-share">
		
		<!-- facebook -->
		<div class="social-item fb">

			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<div class="fb-like" data-href="<?php the_permalink();?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>

		</div>
		<!-- twitter -->
		<div class="social-item">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink();?>" data-text="<?php the_field('sharing_text','option');?> <?php the_permalink();?>" data-lang="en"><?php _e('Share Listing','atlas');?></a>
			<script>!function(d,s,id){ var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){ js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<!-- google plus -->
		<!-- Place this tag where you want the +1 button to render. -->
		<div class="social-item">
			<div class="g-plusone"></div>
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</div>

		<div class="clearboth"></div>

	</div>

	<?php } ?>

	<?php 

	echo do_shortcode( '[divider title="" style="dotted-lines2" length="long" alignment="center" contenttype="default" heading="span" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' );
	
	?>

	<script type="text/javascript">
	jQuery(function() {
        jQuery( "#tabs-listing" ).tabs();
    });

	</script>

	<div id="tabs-listing">
		  
		  <ul>
		    <li><a href="#tabs-1"><?php _e('Contact Details','atlas');?></a></li>
		    <?php if(get_field('monday') !=='' || get_field('tuesday') !== '' || get_field('wednesday') !== '' || get_field('thursday') !=='' || get_field('friday') !=='' || get_field('saturday') !=='' || get_field('sunday') !=='') { ?>
		    <li><a href="#tabs-2"><?php _e('Opening Times','atlas');?></a></li>
		    <?php } ?>
		    <?php if($rows): ?>
		    <li><a href="#tabs-3"><?php _e('Other Information','atlas');?></a></li>
			<?php endif; ?>
			<?php if(get_field('enable_send_to_a_friend_form','option')) { ?>
		    <li><a href="#tabs-4"><?php _e('Send To A Friend','atlas');?></a></li>
		    <?php } ?>
		    <?php if(get_field('enable_get_directions_form','option') && get_field('location')) { ?>
		    <li onclick="displayMap()"><a href="#tabs-5"><?php _e('Get Directions','atlas');?></a></li>
		    <?php } ?>
		    <?php if(get_field('enable_promotions_system','option') && get_field('add_promotions_to_your_listing')) { ?>
		    <li><a href="#tabs-6"><?php _e('Promotions','atlas');?></a></li>
		    <?php } ?>
		  </ul>
		  
		  <div id="tabs-1" class="tab-cont">
		  	<?php get_template_part( 'includes/listing', 'tab1' );?>
		  </div>
		 
		  <?php if(get_field('monday') !=='' || get_field('tuesday') !== '' || get_field('wednesday') !== '' || get_field('thursday') !=='' || get_field('friday') !=='' || get_field('saturday') !=='' || get_field('sunday') !=='') { ?>
		  <div id="tabs-2" class="tab-cont">
		  	<?php get_template_part( 'includes/listing', 'tab2' );?>
		  </div>
		  <?php } ?>

		  <?php if($rows): ?>
		  <div id="tabs-3" class="tab-cont">
		  	<?php get_template_part( 'includes/listing', 'tab3' );?>
		  </div>
		  <?php endif; ?>

		  <?php if(get_field('enable_send_to_a_friend_form','option')) { ?>
		  <div id="tabs-4" class="tab-cont">
		  	<?php get_template_part( 'includes/listing', 'tab4' );?>
		  </div>
		  <?php } ?>
		  <?php if(get_field('enable_get_directions_form','option') && get_field('location')) { ?>
		  <div id="tabs-5" class="tab-cont">
		  	<?php get_template_part( 'includes/listing', 'drivingdirections' );?>
		  </div>
		  <?php } ?>
		  <?php if(get_field('enable_promotions_system','option') && get_field('add_promotions_to_your_listing')) { ?>
		  <div id="tabs-6" class="tab-cont">
		  	<?php get_template_part( 'includes/listing', 'promotions' );?>
		  </div>
		  <?php } ?>

	</div>

</div>