<?php
global $current_user;

$membership = $current_user->membership_level;

$posts_allowance =  get_user_meta( $current_user->ID, 'allowance_limit' );
?>

<ul class="tab-nav">
<?php 
 
/*
*  Loop through a Flexible Content field and display it's content with different views for different layouts
*/

$tab_counter = '';
 
while(has_sub_field("homepage_tabs_generator",'option')): $tab_counter++; ?>
 
	<?php if(get_row_layout() == "add_new_tab"): // layout: Content  ?>
 
		<li><a href="#tab-<?php echo $tab_counter;?>" class=""><span class="<?php the_sub_field("tab_icon",'option'); ?>"></span></a></li>
 
	<?php endif; ?>
 
<?php endwhile; ?>
</ul>

<?php 
 
/*
*  Loop through a Flexible Content field and display it's content with different views for different layouts
*/
 
$content_counter = '';

while(has_sub_field("homepage_tabs_generator",'option')): $content_counter++; ?>
 
	<?php if(get_row_layout() == "add_new_tab"): // layout: Content 

	?>
 		
		<?php if(get_sub_field("set_tab_content",'option') == 'Custom Content') { ?>

		<div id="tab-<?php echo $content_counter;?>" class="tab-content">
				
				<div class="default-tab-info">

					<span class="<?php the_sub_field("tab_icon",'option'); ?>"></span>

					<div class="default-tab-inner">

							<?php 

							//echo do_shortcode(get_sub_field("tab_content",'option')); 

							// First get value as normal
							$fieldValue = get_sub_field("tab_content",'option');
							 
							// Then apply a filter to it, which will execute all shortcodes
							$filtered = apply_filters('the_content', $fieldValue);
							 
							// Print it out
							echo get_sub_field("tab_content",'option');
	

							?>


					</div>

				</div>

		</div>

		<?php } else if(get_sub_field("set_tab_content",'option') == 'Latest Listings') { ?>

			<div id="tab-<?php echo $content_counter;?>" class="tab-content listings-tab">

				<div class="default-tab-info">

					<span class="<?php the_sub_field("tab_icon",'option'); ?>"></span>

					<div class="default-tab-inner">

								<?php the_sub_field("tab_content",'option'); ?>

						<a href="<?php echo the_field('submit_new_listing_page','option');?>" class="button small black"><?php _e('Submit your featured listing &raquo;','atlas');?></a>

						<div class="clearboth"></div>

						<br/>


				</div>

			</div>

			<div class="accordion" rel="0">

			<?php 

				$args = array( 

					'post_type' => 'listing', 
					'posts_per_page' => get_field('how_many_normal_listings','option'),
					
				);

				$featured_loop = new WP_Query( $args );

				while ( $featured_loop->have_posts() ) : $featured_loop->the_post(); 	

			?>

			<div class="accordion-title"><a href="#"><?php the_title();?></a></div>
			<div class="accordion-inner">

				<div class="featured-listing">

					<?php 

						echo "<ul >";

						echo '<li><span class="icon-direction"></span>';

							if(get_field('map_tooltip_content','option') == 'Listing Address' || get_field('map_tooltip_content','option') == '') {

							$listing_address = get_field('location'); echo $listing_address['address'];

							} else if(get_field('map_tooltip_content','option') == 'Listing Excerpt') {

							$text_pop = get_the_content(); $trimmed_pop = wp_trim_words( $text_pop, $num_words = 20, $more = null ); echo addslashes($trimmed_pop);

							}

						echo "</li>";

						if(get_field('telephone')) {

						echo '<li><span class="icon-phone"></span>';

							echo get_field('telephone');

						echo "</li>";

						}

						if(get_field('mobile_phone_number')) {

						echo '<li><span class="icon-mobile"></span>';

							echo get_field('mobile_phone_number');

						echo "</li>";

						} if(get_field('website')) {

						echo '<li><span class="icon-link"></span>';

							echo '<a rel="nofollow" target="_blank" href="' . get_field('website') . '">' . get_field('website') . '</a>';

						echo "</li>";

						}

					echo "</ul>";

					?>

					<a href="<?php the_permalink();?>" class="button medium black featured-button"><?php _e('Read More &raquo;','atlas');?></a>

				</div>

			</div>

			<?php endwhile; ?>

			</div><!-- end accordion --> 

		</div>

		<?php } else if(get_sub_field("set_tab_content",'option') == 'Single Taxonomy') { ?>

			<div id="tab-<?php echo $content_counter;?>" class="tab-content listings-tab">

				<div class="default-tab-info">

					<span class="<?php the_sub_field("tab_icon",'option'); ?>"></span>

					<div class="default-tab-inner">

								<?php the_sub_field("tab_content",'option'); ?>

						<a href="<?php echo the_field('submit_new_listing_page','option');?>" class="button small black"><?php _e('Submit your featured listing &raquo;','atlas');?></a>

						<div class="clearboth"></div>

						<br/>


				</div>

			</div>

			<div class="accordion" rel="0">

			<?php 

				$args = array( 

					'post_type' => 'listing', 
					'posts_per_page' => get_field('how_many_normal_listings','option'),
					'tax_query' => array(
						array(
							'taxonomy' => 'listings_categories',
							'field' => 'id',
							'terms' => get_sub_field("single_tax_id",'option')
						)
					)
					
				);

				$featured_loop = new WP_Query( $args );

				while ( $featured_loop->have_posts() ) : $featured_loop->the_post(); 	

			?>

			<div class="accordion-title"><a href="#"><?php the_title();?></a></div>
			<div class="accordion-inner">

				<div class="featured-listing">

					<?php 

						echo "<ul >";

						echo '<li><span class="icon-direction"></span>';

							if(get_field('map_tooltip_content','option') == 'Listing Address' || get_field('map_tooltip_content','option') == '') {

							$listing_address = get_field('location'); echo $listing_address['address'];

							} else if(get_field('map_tooltip_content','option') == 'Listing Excerpt') {

							$text_pop = get_the_content(); $trimmed_pop = wp_trim_words( $text_pop, $num_words = 20, $more = null ); echo addslashes($trimmed_pop);

							}

						echo "</li>";

						if(get_field('telephone')) {

						echo '<li><span class="icon-phone"></span>';

							echo get_field('telephone');

						echo "</li>";

						}

						if(get_field('mobile_phone_number')) {

						echo '<li><span class="icon-mobile"></span>';

							echo get_field('mobile_phone_number');

						echo "</li>";

						} if(get_field('website')) {

						echo '<li><span class="icon-link"></span>';

							echo '<a rel="nofollow" target="_blank" href="' . get_field('website') . '">' . get_field('website') . '</a>';

						echo "</li>";

						}

					echo "</ul>";

					?>

					<a href="<?php the_permalink();?>" class="button medium black featured-button"><?php _e('Read More &raquo;','atlas');?></a>

				</div>

			</div>

			<?php endwhile; ?>

			</div><!-- end accordion --> 

		</div>

		<?php } else if(get_sub_field("set_tab_content",'option') == 'Featured Listings') { ?>

			<div id="tab-<?php echo $content_counter;?>" class="tab-content listings-tab">

					<div class="default-tab-info">

						<span class="<?php the_sub_field("tab_icon",'option'); ?>"></span>

						<div class="default-tab-inner">

							<?php the_sub_field("tab_content",'option'); ?>

							<a href="<?php the_field('submit_new_listing_page','option');?>" class="button small black"><?php _e('Submit your featured listing &raquo;','atlas');?></a>

							<div class="clearboth"></div>

							<br/>

						</div>

					</div>

					<div class="accordion" rel="0">

					<?php 

						$args = array( 

							'post_type' => 'listing', 
							'posts_per_page' => get_field('how_many_normal_listings','option'),
							'meta_key' => 'listing_is_featured', 
							'meta_value' => '1'


						);

						$listings_normal_loop = new WP_Query( $args );

						while ( $listings_normal_loop->have_posts() ) : $listings_normal_loop->the_post(); 	

					?>

					<div class="accordion-title"><a href="#"><?php the_title();?></a></div>
					<div class="accordion-inner">

						<div class="featured-listing">

							<?php 

								echo "<ul >";

								echo '<li><span class="icon-direction"></span>';

									if(get_field('map_tooltip_content','option') == 'Listing Address' || get_field('map_tooltip_content','option') == '') {

									$listing_address = get_field('location'); echo $listing_address['address'];

									} else if(get_field('map_tooltip_content','option') == 'Listing Excerpt') {

									$text_pop = get_the_content(); $trimmed_pop = wp_trim_words( $text_pop, $num_words = 20, $more = null ); echo addslashes($trimmed_pop);

									}

								echo "</li>";

								if(get_field('telephone')) {

								echo '<li><span class="icon-phone"></span>';

									echo get_field('telephone');

								echo "</li>";

								}

								if(get_field('mobile_phone_number')) {

								echo '<li><span class="icon-mobile"></span>';

									echo get_field('mobile_phone_number');

								echo "</li>";

								} if(get_field('website')) {

								echo '<li><span class="icon-link"></span>';

									echo '<a rel="nofollow" target="_blank" href="' . get_field('website') . '">' . get_field('website') . '</a>';

								echo "</li>";

								}

							echo "</ul>";

							?>

							<a href="<?php the_permalink();?>" class="button medium black featured-button"><?php _e('Read More &raquo;','atlas');?></a>

						</div>

					</div>

					<?php endwhile; ?>

					</div><!-- end accordion -->

			</div>

		<?php } else if(get_sub_field("set_tab_content",'option') == 'User Area') { ?>

			<div id="tab-<?php echo $content_counter;?>" class="tab-content listings-tab">

					<div class="default-tab-info">

						<span class="<?php the_sub_field("tab_icon",'option'); ?>"></span>

						<div class="default-tab-inner">

							<?php the_sub_field("tab_content",'option'); ?>

							<?php if(is_user_logged_in()) { ?>

								<p><?php _e('This is the user area here you can have a quick overwiew of your profile and manange your listings.','atlas');?></p>

								<?php if(tdp_hasMembershipLevel()) { ?>

								<h5><?php _e('Your Membership is:', "atlas");?> <?php echo $membership->name;?></h5>

								<h5><?php printf(__("You can still post %s more listings", "atlas"), $posts_allowance[0]);?></h5>

								<h5><?php _e('Membership Information:', "atlas");?></h5>

								<?php echo apply_filters( 'the_content', stripslashes($membership->description ));  ?>

								<?php } else { ?>

									<?php _e('It seems that you don\'t a membership, please register for a membership by clicking the link below here', "atlas"); ?>

									<br/><br/>
									
									<a href="<?php echo tdp_url("account")?>" class="button medium "><?php _e("Register For A Membership", "atlas");?></a>

								<?php } ?>
								<br/><br/>
								<a href="<?php echo get_field('listings_management_page','option'); ?>" class="button medium "><?php _e("Visit Your Dashboard &raquo;", "atlas");?></a>

								<br/><br/>
								

								<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout" class="button medium "><?php _e('Logout','atlas');?></a>


							<?php } else { ?>

								<p><?php _e('This is our login area, if you have an account please login here.','atlas');?></p>

								<?php 

								$args = array(
							        
							        'echo' => true,
							        'redirect' => site_url( $_SERVER['REQUEST_URI'] ), 
							        'form_id' => 'loginform',
							        'label_username' => __( 'Username' , 'atlas' ),
							        'label_password' => __( 'Password', 'atlas' ),
							        'label_remember' => __( 'Remember Me' , 'atlas'),
							        'label_log_in' => __( 'Log In' , 'atlas'),
							        'id_username' => 'user_login',
							        'id_password' => 'user_pass',
							        'id_remember' => 'rememberme',
							        'id_submit' => 'wp-submit',
							        'remember' => true,
							        'value_username' => NULL,
							        'value_remember' => false 

							    );

								wp_login_form(); 


								?>

								<a href="<?php echo tdp_url("levels")?>" class=""><?php _e('Register now if you don\'t have an account &raquo;','atlas');?></a>

								<?php 

								/**
								 * Check if facebook plugin is active
								 **/
								if ( in_array( 'nextend-facebook-connect/nextend-facebook-connect.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
								?>

								<a href="<?php echo wp_login_url(); ?>?loginFacebook=1&redirect=<?php echo home_url()?>"><?php _e('Login or Register With Facebook','atlas');?></a><br/>

								<?php } ?>

								<a href="<?php the_field('password_recovery_page_url','option'); ?>" title="Lost Password"><?php _e('Lost Password ?','atlas');?></a>

							<?php } ?>

							<div class="clearboth"></div>

						</div>

					</div>

			</div>

		<?php } else if(get_sub_field("set_tab_content",'option') == 'Search Form') { ?>

			<div id="tab-<?php echo $content_counter;?>" class="tab-content search-form-tab">

				<div class="default-tab-info">

					<span class="<?php the_sub_field("tab_icon",'option'); ?>"></span>

					<div class="default-tab-inner">

								<?php the_sub_field("tab_content",'option'); ?>

						<div class="clearboth"></div>

						<br/>

					</div>

				</div>

					
				<?php if(get_field('enable_search_on_map','option')) { ?>

				<div class="tabset">
					
					<ul class="tabs">
					<li class="tab"><a href="#panel3" class="selected"><?php _e('Search Listings','atlas');?></a></li>
					<li class="tab"><a href="#panel4" class=""><?php _e('By Address','atlas');?></a></li>
					</ul>

					<div class="panel" id="panel3" style="display: block;">
						
						<?php
		
						$args = tdp_search_fields();
						$my_search = new WP_Advanced_Search($args);
						$my_search->the_form();
									
					?>

					</div>

					<div class="panel" id="panel4" style="display: none;">
						
						<label><?php _e('Start Typing','atlas');?></label>
						<input id="searchTextField2" type="text" placeholder="<?php _e('Enter an address, zipcode or city','atlas');?>"/>

						<br/><br/>

					</div>

				</div>

				<?php } else { ?>

					<?php
				
						$args = tdp_search_fields();
						$my_search = new WP_Advanced_Search($args);
						$my_search->the_form();
											
					?>

				<?php } ?>
					

			</div>


		<?php } ?>
 
	<?php endif; ?>
 
<?php endwhile; ?>