<?php
/**
 * Template Name: Password Recovery Form
 *
 * @package Atlas
 */

global $wpdb, $user_ID;

function tg_validate_url() {
	global $post;
	$page_url = esc_url(get_permalink( $post->ID ));
	$urlget = strpos($page_url, "?");
	if ($urlget === false) {
		$concate = "?";
	} else {
		$concate = "&";
	}
	return $page_url.$concate;
}

if (!$user_ID) { //block logged in users

	if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
		$reset_key = $_GET['key'];
		$user_login = $_GET['login'];
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		if(!empty($reset_key) && !empty($user_data)) {
			$new_password = wp_generate_password(7, false);
				//echo $new_password; exit();
				wp_set_password( $new_password, $user_data->ID );
				//mailing reset details to the user
			$message = __('Your new password for the account at:') . "\r\n\r\n";
			$message .= get_option('siteurl') . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= sprintf(__('Password: %s'), $new_password) . "\r\n\r\n";
			$message .= __('You can now login with your new password at: ') . get_option('siteurl')."/login" . "\r\n\r\n";
			
			if ( $message && !wp_mail($user_email, 'Password Reset Request', $message) ) {
				echo "<div class='error'>Email failed to send for some unknown reason</div>";
				exit();
			}
			else {
				$redirect_to = get_field('recovery_success_url','option');
				wp_redirect($redirect_to);
				exit();
			}
		} 
		else exit('Not a Valid Key.');
		
	}
	//exit();

	if($_POST['action'] == "tg_pwd_reset"){
		if ( !wp_verify_nonce( $_POST['tg_pwd_nonce'], "tg_pwd_nonce")) {
		  exit("No trick please");
	   }  
		if(empty($_POST['user_input'])) {
			echo '<div class="alert-message error">'.__('Please enter your Username or E-mail address','atlas').'<span class="close" href="#"><i class="icon-cancel"></i></span></div>';
			exit();
		}
		//We shall SQL escape the input
		$user_input = $wpdb->escape(trim($_POST['user_input']));
		
		if ( strpos($user_input, '@') ) {
			$user_data = get_user_by_email($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				echo '<div class="alert-message error">'.__('Invalid Email Address','atlas').'<span class="close" href="#"><i class="icon-cancel"></i></span></div>';
				exit();
			}
		}
		else {
			$user_data = get_userdatabylogin($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				echo '<div class="alert-message error">'.__('Invalid Username','atlas').'<span class="close" href="#"><i class="icon-cancel"></i></span></div>';
				exit();
			}
		}
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		if(empty($key)) {
			//generate reset key
			$key = wp_generate_password(20, false);
			$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));	
		}
		
		//mailing reset details to the user
		$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
		$message .= get_option('siteurl') . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= tg_validate_url() . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login) . "\r\n";
		
		if ( $message && !wp_mail($user_email, 'Password Reset Request', $message) ) {
			echo '<div class="alert-message error">'.__('We just sent you an email.','atlas').'<span class="close" href="#"><i class="icon-cancel"></i></span></div>';
			exit();
		}
		else {
			echo '<div class="alert-message success">'.__('We just sent you an email.','atlas').'<span class="close" href="#"><i class="icon-cancel"></i></span></div>';
			exit();
		}
		
	} else {

get_header();
?>
<section id="breadcrumb">

	<div class="wrapper">
		
		<div class="one_half">
	
			<?php if (function_exists('tdp_breadcrumbs')) tdp_breadcrumbs(); ?>
	
		</div>

		<div class="one_half last">
		</div>

		<div class="clearboth"></div>

	</div>

</section>
<?php get_template_part( 'includes/top', 'singlepage' ); ?>
<section id="page-wrapper">

	<div id="page-content" class="wrapper">

		<?php if(get_field('inner_page_layout') == 'Sidebar Left') { ?>

			<div class="one_third" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Page Sidebar' ); ?>
			</div>

		<?php } ?>

		<div id="content-container" class="<?php if(get_field('inner_page_layout') == 'Sidebar Left') { echo 'two_third last'; } else if(get_field('inner_page_layout') == 'Sidebar Right') { echo 'two_third'; } ?>">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

						<div id="search-popup" class="front-form">

						        <h4><?php _e('Forgot your password?','atlas');?></h4>

						        <div class="search-content">

									<form class="user_form" id="wp_pass_reset" action="" method="post">
										<label><?php _e('Enter your username or email address','atlas');?></label>			
										<input type="text" class="text" name="user_input" value="" /><br />
										<input type="hidden" name="action" value="tg_pwd_reset" />
										<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
										<input type="submit" id="submitbtn" class="reset_password" name="submit" value="<?php _e('Reset Password','atlas');?>" />					
									</form>
									
									<div id="result"></div> <!-- To hold validation results -->
									
									<script type="text/javascript">  						
										$("#wp_pass_reset").submit(function() {			
											$('#result').html('<div class="alert-message info loading"><?php _e("Processing","atlas");?></div>').fadeIn();
											var input_data = $('#wp_pass_reset').serialize();
											$.ajax({
												type: "POST",
												url:  "<?php echo get_permalink( $post->ID ); ?>",
												data: input_data,
												success: function(msg){
												$('.loading').remove();
												$('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
											}
											});
											return false;
										});
									</script>

								</div>

						</div>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

		</div>

		<?php if(get_field('inner_page_layout') == 'Sidebar Right'  ) { ?>

			<div class="one_third last" id="sidebar-wrapper">
				<?php dynamic_sidebar( 'Page Sidebar' ); ?>
			</div>

		<?php } ?>

		<div class="clearboth"></div>

	</div>

</section>

<?php

get_footer();
	}
}
else {
	wp_redirect( home_url() ); exit;
	//redirect logged in user to home page
}?>