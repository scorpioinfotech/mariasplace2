<?php
// Listing Tab 1

?>

<div class="tab-lister">

					<i class="icon-mail"></i>

					<?php echo do_shortcode( '[divider title="'.__('Contact Details','atlas').'" style="right-stripes" length="long" alignment="center" contenttype="text" heading="h4" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' ); ?>

					<ul class="item-address">
						
						<li class="address">
							<span><?php _e('Address:','atlas')?></span>
							<?php

								if(get_field('override_generated_address')) {
									the_field('override_generated_address');
								} else {
									$list_loc = get_field('location');
									echo $list_loc['address'];
								}
								
							?> 
						</li>
						
						<li class="address">
							<span><?php _e('GPS:','atlas')?></span>
							<?php

								$list_loc = get_field('location');
								echo $list_loc['coordinates'];

							?> 
						</li>
						
						<?php if(get_field('telephone')) { ?>
						<li>
							<span class="phone">
								<?php _e('Phone','atlas');?>:
							</span>

							<a href="tel:<?php the_field('telephone');?>"><?php the_field('telephone');?></a>
						</li>
						<?php } ?>

						<?php if(get_field('mobile_phone_number')) { ?>
						<li>
							<span class="phone">
								<?php _e('Mobile Phone','atlas');?>:
							</span>

							<?php the_field('mobile_phone_number');?>
						</li>
						<?php } ?>

						<?php if(get_field('website') && get_field('website') !== 'http://') { ?>
						<li>
							<span class="web">
								<?php _e('Website','atlas');?>:
							</span>

							<a rel="nofollow" target="_blank" href="<?php the_field('website');?>" rel="nofollow"><?php the_field('website');?></a>
						</li>
						<?php } ?>

						<?php if(get_field('facebook') || get_field('twitter') || get_field('gplus') || get_field('instagram') || get_field('foursquare')  ) { ?>

						<li class="social-listing">
							<span class="social">
								<?php _e('Social Profiles','atlas');?>:
							</span>

							<?php if(get_field('facebook')) { ?>

							<a href="<?php the_field('facebook');?>" rel="nofollow" target="_blank"><i class="icon-facebook"></i></a>

							<?php } ?>

							<?php if(get_field('twitter')) { ?>

							<a href="<?php the_field('twitter');?>" rel="nofollow" target="_blank"><i class="icon-twitter"></i></a>

							<?php } ?>

							<?php if(get_field('gplus')) { ?>

							<a href="<?php the_field('gplus');?>" rel="nofollow" target="_blank"><i class="icon-gplus"></i></a>

							<?php } ?>

							<?php if(get_field('instagram')) { ?>

							<a href="<?php the_field('instagram');?>" rel="nofollow" target="_blank"><i class="icon-instagramm"></i></a>

							<?php } ?>

							<?php if(get_field('foursquare')) { ?>

							<a href="<?php the_field('foursquare');?>" rel="nofollow" target="_blank"><i class="icon-foursquare"></i></a>

							<?php } ?>

						</li>
						
						<?php } ?>

					</ul>

			</div><!-- end tab content -->