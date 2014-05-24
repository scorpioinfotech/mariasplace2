<?php
/*
Template Name: Login Page
 */
get_header('mini');

?>

<div id="map"></div>

<div id="the-map-overlay">

	<div class="wrapper">

		<div id="front-login" class="animated fadeInDown">

			<h1><?php the_title();?></h1>

			<div class="front-login-content">

				<?php

					if(is_user_logged_in()) { ?>

						<div class="form-is-logged">

							<i class="icon-ok-circled"></i>

							<p><?php _e('It looks like you are already logged in.','atlas');?></p>

							<?php echo '<a href="'.home_url().'" class="button small black">'.__('Back to the website','atlas').'</a></div>'; ?>

						</div>

					<?php } else {

						if ( have_posts() ) :

						 	while ( have_posts() ) : the_post();

								the_content(); 

							endwhile;

						endif;

						$args = array(
									        
							'echo' => true,
							'redirect' => home_url(), 
							'form_id' => 'loginform',
							'label_username' => __( 'Username','atlas' ),
							'label_password' => __( 'Password','atlas' ),
							'label_remember' => __( 'Remember Me','atlas' ),
							'label_log_in' => __( 'Log In','atlas' ),
							'id_username' => 'user_login',
							'id_password' => 'user_pass',
							'id_remember' => 'rememberme',
							'id_submit' => 'wp-submit',
							'remember' => true,
							'value_username' => NULL,
							'value_remember' => false 

						);  

						 wp_login_form( $args ); 

						 echo '<div class="wrap-links"><a href="'.tdp_url('levels').'" class="button small black">'.__('Not Registered Yet ? Signup Now &raquo;','atlas').'</a> ';

						/**
						 * Check if facebook plugin is active
						 **/
						if ( in_array( 'nextend-facebook-connect/nextend-facebook-connect.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					    
							echo '<a href="'.wp_login_url().'?loginFacebook=1&redirect='.home_url().'"class="button small black">'.__('Login or Register With Facebook','atlas').'</a>';

						}

						echo '<a href="'.home_url().'" class="button small black">'.__('Back to the website','atlas').'</a>';

					} ?>

					<a href="<?php the_field('password_recovery_page_url','option'); ?>" class="button small black"><?php _e('Password Lost?','atlas');?></a>

					</div>
					
			</div>

		</div>

	</div>

</div>

<?php get_template_part( 'includes/map', 'loader' );?>

<?php get_footer('mini'); ?>