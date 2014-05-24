<?php 

//////////////////////////////////////// Slider ////////////////////////////////////////

function gp_slider($atts, $content = null) {
    extract(shortcode_atts(array(
		'content' => 'slide',
		'cats' => '',
		'ids' => '',
        'width' => '900',
        'height' => '400',
        'hard_crop' => 'false',
        'slides' => '-1',
        'effect' => 'fade',
        'timeout' => '6',
        'orderby' => 'menu_order',
        'order' => 'asc',
        'arrows' => 'true',
        'buttons' => 'true',
        'shadow' => 'true',
        'content_display' => 'excerpt',
        'excerpt_length' => '300',
        'title' => 'true',       
        'title_length' => '40',        
		'margins' => '',
        'align' => 'alignleft',
        'preload' => 'false'
    ), $atts));

	require(gp_inc . 'options.php'); global $post, $is_IE, $is_gecko, $gp_settings;
	
	
	// Unique Name
	
	STATIC $i = 0;
	$i++;
	$name = 'slider'.$i;

	
	// Categories
	
	if($cats) { 
		$cats = array('taxonomy' => 'slide_categories', 'terms' => explode(',', $cats), 'field' => 'id');
	} else {
		$cats = null;
	}
	

	// IDs
	
	if($ids) { 
		$ids = explode(',', $ids);
	} else {
		$ids = null;
	}
		
	
	// Shadow
	
	if($shadow == "true") {
		$shadow = " shadow";
	} else {
		$shadow = "";
	}
	
	
	// Margins
	
	if($margins != "") {
		if(preg_match('/%/', $margins) OR preg_match('/em/', $margins) OR preg_match('/px/', $margins)) {
			$margins = str_replace(",", " ", $margins);
			$margins = 'margin: '.$margins.'; ';	
		} else {
			$margins = str_replace(",", "px ", $margins);
			$margins = 'margin: '.$margins.'px; ';		
		}
		$margins = str_replace("autopx", "auto", $margins);
	} else {
		$margins = "";
	}
	
	
	// Preload
	
	if($preload == "true") {
		$preload = " preload";
	} else {
		$preload = "";
	}
	
	
	// Slider Query	

	$args=array(
	'post_type' => explode(',', $content),
	'posts_per_page' => $slides,
	'post__in' => $ids,
	'ignore_sticky_posts' => 0,
	'orderby' => $orderby,
	'order' => $order,
	'tax_query' => array('relation' => 'OR', $cats)
	);
	
	$featured_query = new wp_query($args);
	
	ob_start(); ?>
	
	
	<?php if ($featured_query->have_posts()) : $slide_counter = ""; ?>
	
	
	<!-- BEGIN SLIDER WRAPPER -->
	
	<div id="<?php echo $name; ?>" class="flexslider <?php echo $align; ?><?php echo $shadow; ?><?php echo $preload; ?>" style="width: <?php echo $width; ?>px; <?php echo $margins; ?>">
		
		
		<!-- BEGIN SLIDER -->
		
		<ul class="slides">


			<?php while ($featured_query->have_posts()) : $featured_query->the_post(); $slide_counter++; 


			// Caption Position
			
			$slide_caption_position = get_post_meta($post->ID, 'ghostpool_slide_caption_position', true);

			if($slide_caption_position == "Top Left Overlay") {
				$caption_class = " caption-topleft";
			} elseif($slide_caption_position == "Top Right Overlay") {
				$caption_class = " caption-topright";
			} elseif($slide_caption_position == "Bottom Left Overlay") {
				$caption_class = " caption-bottomleft ";
			} else {
				$caption_class = " caption-bottomright";
			}
					
								
			// Video Type
			
			$vimeo = strpos(get_post_meta($post->ID, 'ghostpool_slide_video', true),"vimeo.com");
			$yt1 = strpos(get_post_meta($post->ID, 'ghostpool_slide_video', true),"youtube.com");
			$yt2 = strpos(get_post_meta($post->ID, 'ghostpool_slide_video', true),"youtu.be"); 
						
						
			?>

				<li class="slide<?php if($slide_counter != "1") {} elseif(get_post_meta($post->ID, 'ghostpool_slide_autostart_video', true)) { ?> video-autostart<?php } ?>" id="<?php echo $name; ?>-slide-<?php the_ID(); ?>">
					
					
					<!-- BEGIN CAPTION -->
					
					<?php if((!get_post_meta($post->ID, 'ghostpool_slide_title', true) && $title == "true") OR ($post->post_content && $excerpt_length != "0")) { ?>
						
						<div class="caption<?php echo $caption_class; ?>">
							
							
							<!-- BEGIN SLIDER TITLE -->
							
							<?php if(!get_post_meta($post->ID, 'ghostpool_slide_title', true) && $title == "true") { ?><h2><?php the_title(); ?></h2><?php } ?>

							<!-- END SLIDER TITLE -->
							
								
							<!-- BEGIN POST CONTENT -->
							
							<?php if($content_display == "full") { ?>	
							
								<?php global $more; $more = 0; the_content(__('Read More &raquo;', 'gp_lang')); ?>
								
							<?php } else { ?>
							
								<?php if($excerpt_length != "0") { ?><p><?php echo excerpt($excerpt_length); ?></p><?php } ?>
								
							<?php } ?>
							
							<!-- END POST CONTENT -->
							
							
						</div>
					
					<?php } ?>
					
					<!-- END CAPTION -->
					
					
					<!-- BEGIN CONTENT -->	
					
					<?php if(get_post_meta($post->ID, 'ghostpool_slide_video', true) OR get_post_meta($post->ID, 'ghostpool_webm_mp4_slide_video', true) OR get_post_meta($post->ID, 'ghostpool_ogg_slide_video', true)) { ?>

						
						<!-- VIDEO IMAGE-->
												
						<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), $width, $height, true, true, true); ?>
									
						<?php if(wp_is_mobile()) { ?><a href="#lightbox-<?php echo $name; ?>-<?php the_ID(); ?>" rel="prettyPhoto"><?php } ?>
															
						<?php if(wp_is_mobile()) { ?><a href="file=<?php if($is_gecko && get_post_meta($post->ID, 'ghostpool_ogg_slide_video', true)) { echo get_post_meta($post->ID, 'ghostpool_ogg_slide_video', true); } elseif(get_post_meta($post->ID, 'ghostpool_webm_mp4_slide_video', true)) { echo get_post_meta($post->ID, 'ghostpool_webm_mp4_slide_video', true); } else { echo get_post_meta($post->ID, 'ghostpool_slide_video', true); } ?>" rel="prettyPhoto"><?php } ?>
								
							<div class="video-image">
					
								<div class="video-button"></div>
						
								<?php if(has_post_thumbnail()) { ?>
						
									<img src="<?php echo $image; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" style="width: <?php echo $width; ?>px;<?php if($hard_crop == "true") { ?> height: <?php echo $height; ?>px;<?php } ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', 	true); } else { echo get_the_title(); } ?>" />
							
								<?php } ?>
							
							</div>
												
						<?php if(wp_is_mobile()) { ?></a><?php } ?>
							
						<!-- END VIDEO IMAGE -->
						
						
						<!-- BEGIN VIDEO -->
		
						<?php if(!wp_is_mobile()) { ?>
							
							<?php if($vimeo) { ?>
						
						
								<!-- BEGIN VIMEO VIDEO -->
								
								<?php if(preg_match('/www.vimeo/', get_post_meta($post->ID, 'ghostpool_slide_video', true))) {							
									$vimeoid = trim(get_post_meta($post->ID, 'ghostpool_slide_video', true),'http://www.vimeo.com/');
								} else {							
									$vimeoid = trim(get_post_meta($post->ID, 'ghostpool_slide_video', true),'http://vimeo.com/');
								} ?>
								
								<div class="video-player">
							
									<iframe src="http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=<?php if($slide_counter != "1") { ?>0<?php } elseif(get_post_meta($post->ID, 'ghostpool_slide_autostart_video', true)) { ?>1<?php } else { ?>0<?php } ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

								</div>
								
									<script>		
									jQuery(window).load(function() {
							
										// Play Vimeo Player
								
										jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image").click(function(){
										  var thePage = jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player");
										  thePage.html(thePage.html().replace('http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=0', 'http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=1'));
										  jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').show();
										});
								
										// Stop Vimeo Player
								
										jQuery("#<?php echo $name; ?> .flex-control-nav li a").click(function(){
										  var thePage = jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player");
										  thePage.html(thePage.html().replace('http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=1', 'http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=0'));
										  jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').hide();
										});
								
									});
									</script>	
								
								<!-- END VIMEO VIDEO -->
														
							
							<?php } else { ?>								

								
								<!-- BEGIN JWPLAYER VIDEO -->
								
								<div class="video-player">
									<div id="<?php echo $name; ?>-player-<?php the_ID(); ?>" class="video-player"></div>															
								</div>
								
								<script>
								//<![CDATA[

								jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").setup({
									image: "<?php echo get_template_directory_uri(); ?>/lib/images/black.gif",
									icons: "true",
									autostart: "<?php if($slide_counter != '1') { ?>false<?php } elseif(get_post_meta($post->ID, 'ghostpool_slide_autostart_video', true)) { ?>true<?php } else { ?>false<?php } ?>",
									stretching: "fill",
									controlbar: "<?php if(get_post_meta($post->ID, 'ghostpool_slide_video_controls', true) == 'Over') { ?>over<?php } elseif(get_post_meta($post->ID, 'ghostpool_slide_video_controls', true) == 'Bottom') { ?>bottom<?php } else { ?>none<?php } ?>",
									skin: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/fs39/fs39.xml",
									width: "100%",
									height: "<?php echo $height; ?>",
									screencolor: "000000",
									modes:
										[
										<?php if($is_IE OR get_post_meta($post->ID, 'ghostpool_slide_video_priority', true) == 'Flash') { ?>
											{type: "flash", src: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/player.swf", config: {file: "<?php echo get_post_meta($post->ID, 'ghostpool_slide_video', true); ?>"}},					
											{type: "html5", config: {file: "<?php if($is_gecko && get_post_meta($post->ID, 'ghostpool_ogg_slide_video', true)) { echo get_post_meta($post->ID, 'ghostpool_ogg_slide_video', true); } elseif(get_post_meta($post->ID, 'ghostpool_webm_mp4_slide_video', true)) { echo get_post_meta($post->ID, 'ghostpool_webm_mp4_slide_video', true); } else { echo get_post_meta($post->ID, 'ghostpool_slide_video', true); } ?>"}}
										<?php } else { ?>
											{type: "html5", config: {file: "<?php if($is_gecko && get_post_meta($post->ID, 'ghostpool_ogg_slide_video', true)) { echo get_post_meta($post->ID, 'ghostpool_ogg_slide_video', true); } elseif(get_post_meta($post->ID, 'ghostpool_webm_mp4_slide_video', true)) { echo get_post_meta($post->ID, 'ghostpool_webm_mp4_slide_video', true); } else { echo get_post_meta($post->ID, 'ghostpool_slide_video', true); } ?>"}},
											{type: "flash", src: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/player.swf", config: {file: "<?php echo get_post_meta($post->ID, 'ghostpool_slide_video', true); ?>"}}
										<?php } ?>
										],
									plugins: {}
								});
							
							
								// Play JW Player
											
								jQuery(document).ready(function(){
									jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image").click(function() {
										jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').show();
										jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").play();
									});	
								});
							
							
								// Stop JW Player
							
								jQuery(window).load(function() {	
									jQuery("#<?php echo $name; ?> .flex-control-nav li a").click(function() {
										if(jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").getState() === "PLAYING") {
											jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').hide();
											jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").stop();
										}
									});
								});	
							
							
								//]]>
								</script>
							
							<!-- END JWPLAYER VIDEO -->
				
					
						<?php } ?>
						
						<?php } ?>

						<!-- END VIDEO -->
					
						
						<?php if(!wp_is_mobile()) { ?>
						
						<script>
						
						jQuery(document).ready(function() {
					
							// Hide Video Image/Play Button

							jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image").click(function() {
								jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image').hide();
								jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .caption').hide();
							});	
						
						});
													
						</script>
						
						<?php } ?>	

					
					<?php } else { ?>
						
						
						<!-- BEGIN FEATURED IMAGE -->
						
						<?php if(has_post_thumbnail()) { ?>

							<?php if(get_post_meta($post->ID, 'ghostpool_slide_url', true) OR  get_post_meta($post->ID, 'ghostpool_slide_link_type', true) != "None") { ?>
							<a href="<?php if(get_post_meta($post->ID, 'ghostpool_slide_link_type', true) == "Lightbox Video") { ?>file=<?php echo get_post_meta($post->ID, 'ghostpool_slide_url', true); } elseif(get_post_meta($post->ID, 'ghostpool_slide_link_type', true) == "Lightbox Image") { if(get_post_meta($post->ID, 'ghostpool_slide_url', true)) { echo get_post_meta($post->ID, 'ghostpool_slide_url', true); } else { echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); }} else { if(get_post_meta($post->ID, 'ghostpool_slide_url', true)) { echo get_post_meta($post->ID, 'ghostpool_slide_url', true); } else { the_permalink(); }} ?>" title="<?php the_title(); ?>"<?php if(get_post_meta($post->ID, 'ghostpool_slide_link_type', true) != "Page") { ?> rel="prettyPhoto"<?php } ?>>
							<?php } ?>
														
								<?php if(get_post_meta($post->ID, 'ghostpool_slide_link_type', true) == "Lightbox Image") { ?><span class="hover-image"></span><?php } elseif(get_post_meta($post->ID, 'ghostpool_slide_link_type', true) == "Lightbox Video") { ?><span class="hover-video"></span><?php } ?>							
							
								<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), $width, $height, true, true, true); ?>	
							
								<img src="<?php echo $image; ?>" style="width: <?php echo $width; ?>px;<?php if($hard_crop == "true") { ?> height: <?php echo $height; ?>px;<?php } ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />
							
							<?php if(get_post_meta($post->ID, 'ghostpool_slide_url', true) OR  get_post_meta($post->ID, 'ghostpool_slide_link_type', true) != "None") { ?></a><?php } ?>
						
						<?php } ?>

						<!-- END FEATURED IMAGE -->
						
	
					<?php } ?>

					<!-- END CONTENT -->
					

				</li>

		
			<?php endwhile; ?>
		
		
			</ul>
			
			<!-- END SLIDER -->
		
		
		</div>
		
		<!-- END SLIDER WRAPPER -->

		
	<?php endif; wp_reset_query(); ?>
		
		
	<script>
	jQuery(document).ready(function(){
		
		jQuery("#<?php echo $name; ?>.flexslider").flexslider({ 
			animation: "<?php echo $effect; ?>",
			slideshowSpeed: <?php if($timeout == 0) { echo "9999999"; } else { echo $timeout*1000; } ?>,
			animationDuration: 600,
			directionNav: <?php if($arrows == "true") { ?>true<?php } else { ?>false<?php } ?>,			
			controlNav: <?php if($buttons == "true") { ?>true<?php } else { ?>false<?php } ?>,				
			pauseOnAction: true, 
			pauseOnHover: false,
			start: function(slider) {

				// Pause Slider
				jQuery("#<?php echo $name; ?> .flex-control-nav li a, #<?php echo $name; ?> .video-image").click(function() { 
					slider.pause(); 
				});
											
			}
			
		});
		
					
		// Resize Video Player
	
		jQuery(window).load(function(){
			resizePlayer();
			jQuery(window).resize(function() {
				resizePlayer();
			});	
		});

		function resizePlayer() {
			parentContainer = jQuery("#<?php echo $name; ?> .slides").parent().attr('id');
			sliderWidth = jQuery('#'+parentContainer).width();
			newVideoWidth = sliderWidth;
			newVideoHeight = (sliderWidth * <?php echo $height; ?>) / <?php echo $width; ?>;
			jQuery("#<?php echo $name; ?>.flexslider .slides > li, #<?php echo $name; ?>.flexslider .video-image, #<?php echo $name; ?>.flexslider iframe, #<?php echo $name; ?>.flexslider video, #<?php echo $name; ?>.flexslider object, #<?php echo $name; ?>.flexslider embed").width(newVideoWidth).height(newVideoHeight);						
		}

								
		// Show All Video Images & Captions

		jQuery("#<?php echo $name; ?> .flex-control-nav li a").click(function() {
			jQuery('#<?php echo $name; ?> .video-image').show();
			jQuery('#<?php echo $name; ?> .video-player').hide();
			jQuery('#<?php echo $name; ?> .caption').show();
		});
		
	});
	</script>
	
	
<?php

	$output_string = ob_get_contents();
	ob_end_clean(); 
	
	return $output_string;

}
add_shortcode('slider', 'gp_slider');

?>