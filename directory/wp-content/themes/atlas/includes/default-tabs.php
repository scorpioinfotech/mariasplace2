<?php 

global $current_user;

$membership = $current_user->membership_level;

$posts_allowance =  get_user_meta( $current_user->ID, 'allowance_limit' );

?>

	<ul class="tab-nav">

		<li><a href="#tabs-1" class=""><span class="icon-home"></span></a></li>
		<li><a href="#tabs-search" class=""><span class="icon-search"></span></a></li>
		<li><a href="#tabs-2" class=""><span class="icon-user"></span></a></li>
		<li><a href="#tabs-3" class=""><span class="icon-star"></span></a></li>
		<li><a href="#tabs-4" class=""><span class="icon-list"></span></a></li>

	</ul>

	<div id="tabs-1" class="tab-content">

		<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content();?>

				<?php endwhile; ?>


			<?php else : ?>

				<h1><?php _e('Looks like the homepage content is empty, please add some content to the homepage.', "atlas");?></h1>

			<?php endif; ?>

	</div>
		
	<div id="tabs-2" class="tab-content">

		<div class="default-tab-info">

			<span class="icon-gauge"></span>

			<h1 class="tab-title"><?php _e('User Area','atlas');?></h1>

			<div class="default-tab-inner2">

				<?php if(is_user_logged_in()) { ?>

					<p><?php _e('This is the user area here you can have a quick overwiew of your profile and manange your listings.','atlas');?></p>

					<?php if(tdp_hasMembershipLevel()) { ?>

					<h5><?php _e('Your Membership is:', "atlas");?> <?php echo $membership->name;?></h5>

					<h5><?php printf(__("You can still post %s more listings", "atlas"), $posts_allowance[0]);?></h5>

					<h5><?php _e('Membership Information:', "atlas");?></h5>

					<?php echo apply_filters( 'the_content', stripslashes($membership->description )); ?>

					<?php } else { ?>

						<?php _e('It seems that you don\'t a membership, please register for a membership by clicking the link below here'); ?>

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

					<a href="<?php echo tdp_url("levels")?>" class=""><?php _e('Register now if you don\'t have an account &raquo;','atlas');?></a><br/>

					<?php 

					/**
					 * Check if facebook plugin is active
					 **/
					if ( in_array( 'nextend-facebook-connect/nextend-facebook-connect.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					    // Put your plugin code here
					?>

					<a href="<?php echo wp_login_url(); ?>?loginFacebook=1&redirect=<?php echo home_url()?>"><?php _e('Login or Register With Facebook','atlas');?></a><br/>

					<?php } ?>

					<a href="<?php the_field('password_recovery_page_url','option'); ?>" title="Lost Password"><?php _e('Lost Password ?','atlas');?></a>

				<?php } ?>

				<div class="clearboth"></div>

				<br/>

			</div>

		</div>

	</div>
		
	<div id="tabs-3" class="tab-content listings-tab">

		<div class="default-tab-info">

			<span class="icon-star"></span>

			<h1 class="tab-title"><?php _e('Featured Listings','atlas');?></h1>

			<div class="default-tab-inner">

				<p><?php _e('This is our list of premier destinations.', "atlas");?></p>

				<a href="<?php echo the_field('submit_new_listing_page','option');?>" class="button small black"><?php _e('Submit your featured listing &raquo;','atlas');?></a>

				<div class="clearboth"></div>

				<br/>

			</div>

		</div>

		<div class="accordion" rel="0">

		<?php 

			$args = array( 

				'post_type' => 'listing', 
				'posts_per_page' => get_field('how_many_featured_listings','option'),
				'meta_key' => 'listing_is_featured', 
				'meta_value' => '1'

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

	<div id="tabs-4" class="tab-content listings-tab">

		<div class="default-tab-info">

			<span class="icon-list"></span>

			<h1 class="tab-title"><?php _e('Latest Listings','atlas');?></h1>

			<div class="default-tab-inner">

				<p><?php _e('This is our list of premier destinations.', "atlas");?></p>

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

	<div id="tabs-search" class="tab-content search-form-tab">

		<div class="default-tab-info">

			<span class="icon-search"></span>

			<h1 class="tab-title"><?php _e('Listings Search','atlas');?></h1>

			<div class="default-tab-inner">

				<p><?php _e('Are you looking for something special? Try looking through our listings', "atlas");?></p>

				<br/>

				<div class="clearboth"></div>

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