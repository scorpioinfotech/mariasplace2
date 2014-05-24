<?php
/*
Plugin Name: TDP - Frontend Edit Profile
Version: 1.1
Description: Display a form on the frontend that allows you to modify the profile from the frontend. This plugin can be used in conjuction with the TDP Listings & Membership Plugin.
Author: ThemesDepot
Author URI: http://www.themesdepot.org
Plugin URI: http://www.themesdepot.org
*/

define("TDP_PROF_URL", WP_PLUGIN_URL . '/tdp-profile-edit/' );

if(!(function_exists('get_user_to_edit'))){
	require_once(ABSPATH.'/wp-admin/includes/user.php');
}

if(!(function_exists('_wp_get_user_contactmethods'))){
	require_once(ABSPATH.'/wp-includes/registration.php');
}

class FRONTEND_EDIT_PROFILE{
	
	var $wp_error;
		
	function __construct(){
		
		
		add_shortcode('editprofile',array($this,'shortcode'));
		add_shortcode('EDITPROFILE',array($this,'shortcode'));
		
		add_action('wp_print_styles',array($this,'form_style'));
		add_action('wp_print_scripts', array($this,'form_script'));
		add_action('init',array($this,'process_login_form'));	
		add_action('fep_loginform',array($this,'login_form'));
		add_action("init", array($this,"tdp_fep_load_textdomain"));

		
	}

	function tdp_fep_load_textdomain()
	{
	    //get the locale
		$locale = apply_filters("plugin_locale", get_locale(), "tdp");
		$mofile = "tdp-fep-" . $locale . ".mo";	
		
		//paths to local (plugin) and global (WP) language files
		$mofile_local  = dirname(__FILE__)."/langs/" . $mofile;
		$mofile_global = WP_LANG_DIR . '/tdp/' . $mofile;
		
		//load global first
	    load_textdomain("tdp-profile-edit", $mofile_global);

		//load local second
		load_textdomain("tdp-profile-edit", $mofile_local);	
	}
	
	function plugin_url(){
		$currentpath = dirname(__FILE__);
		$siteurl = get_option('siteurl').'/';
		$plugin_url = str_replace(ABSPATH,$siteurl,$currentpath);
		
		return $plugin_url;
	}
	

	
	function login_url( $url ){
		$fep_url = get_option('fep_loginurl');
		
		if(!empty($fep_url)){
			$url = $fep_url;
		}
		
		return $url;
	}
	
	function logout_url( $url ){
		
		if(is_admin()) return $url;
		
		$fep_url = get_option('fep_logouturl');
		
		if(!empty($fep_url)){
			$url = $fep_url;
		}
		
		return $url;
	}
	
	function lostpassword_url( $url ){
		$fep_url = get_option('fep_lostpasswordurl');
		
		if(!empty($fep_url)){
			$url = $fep_url;
		}
		
		return $url;
	}
	
	//
	// http://www.webcheatsheet.com/PHP/get_current_page_url.php
	//
	
	function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
	
	function form_style() {

		$style = get_option('fep_style');
		$passmeter = get_option('fep_passmeter_style');
		
		$src = TDP_PROF_URL .'fep.css';
		
		$plugin_url = self::plugin_url();
		$passmeter = $plugin_url.'/passmeter/simplePassMeter.css';
		wp_enqueue_style('fep-forms-passmeter',$passmeter,'','0.3');
	
		
	//End Function
	}
	
	function form_script(){
		
		$plugin_url = self::plugin_url();
		
		$src = $plugin_url.'/fep.js';
		$passmeter = $plugin_url."/passmeter/jquery.simplePassMeter-0.3.min.js";
		wp_enqueue_script('fep-forms-passmeter',$passmeter, array('jquery'),'0.3');
		wp_enqueue_script('fep-forms-script',$src,array('fep-forms-passmeter'),'1.0');
	}
	
	function process_form( $atts ){
		
		global $wpdb;
		
		error_reporting(0);
		
		$errors = new WP_ERROR();
		
		$current_user = wp_get_current_user();
		
		$user_id = $current_user->ID;
		
		do_action('personal_options_update', $user_id);
		
		$user = get_userdata( $user_id );
		
		// Update the email address in signups, if present.
		if ( $user->user_login && isset( $_POST[ 'email' ] ) && is_email( $_POST[ 'email' ] ) && $wpdb->get_var( $wpdb->prepare( "SELECT user_login FROM {$wpdb->signups} WHERE user_login = %s", $user->user_login ) ) )
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->signups} SET user_email = %s WHERE user_login = %s", $_POST[ 'email' ], $user_login ) );

		// WPMU must delete the user from the current blog if WP added him after editing.
		$delete_role = false;
		$blog_prefix = $wpdb->get_blog_prefix();
		if ( $user_id != $current_user->ID ) {
			$cap = $wpdb->get_var( "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = '{$user_id}' AND meta_key = '{$blog_prefix}capabilities' AND meta_value = 'a:0:{}'" );
			if ( null == $cap && $_POST[ 'role' ] == '' ) {
				$_POST[ 'role' ] = 'contributor';
				$delete_role = true;
			}
		}
		if ( !isset( $errors ) || ( isset( $errors ) && is_object( $errors ) && false == $errors->get_error_codes() ) )
			$errors = edit_user($user_id);
		if ( $delete_role ) // stops users being added to current blog when they are edited
			delete_user_meta( $user_id, $blog_prefix . 'capabilities' );
		
		if(is_wp_error( $errors ) ) {
			$message = $errors->get_error_message();
			$style = "error";
		}else{
			$message = __("<strong>Success</strong>: Profile updated");
			$style = "success";
		}
			$output  = "<div id=\"fep-message\" class=\"fep-message-".$style."\">".$message.'</div>';
			$output .= $this->build_form();
			
			return $output; 
	}
	
	function build_form( $data="" ){
		
		$current_user = wp_get_current_user();
		
		$user_id = $current_user->ID;
		
		$profileuser = get_user_to_edit($user_id);
		
		$show_pass_hint = true;
		
		$show_pass_indicator = true;
		
		$show_biographical = true;
		
		ob_start();
		?>

		

		<div class="tdp-wrap tdp-login ">
		
			<div class="tdp-inner tdp-login-wrapper">

				<div class="tdp-head">

					<div class="tdp-left">

						<div class="tdp-field-name tdp-field-name-wide login-heading" id="login-heading-1">
							<?php _e("Edit Your Profile", "tdp-profile-edit");?>
						</div>

					</div>

					<div class="tdp-right">
					</div>

					<div class="tdp_clear"></div>

				</div>

				<div class="tdp-main">

						<div class="fep">
							
							<form id="your-profile" action="#fep-message" method="post"<?php do_action('user_edit_form_tag'); ?>>
								
								<?php wp_nonce_field('update-user_' . $user_id) ?>
								<?php if ( $wp_http_referer ) : ?>
									<input type="hidden" name="wp_http_referer" value="<?php echo esc_url($wp_http_referer); ?>" />
								<?php endif; ?>
								<input type="hidden" name="from" value="profile" />
								<input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />

								<table class="form-table">
	
									<?php do_action('personal_options', $profileuser); ?>

								</table>

								<?php //do_action('profile_personal_options', $profileuser); ?>

								<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("Name", "tdp");?></div>

								<table class="form-table">
									<tr>
										<th><label for="user_login"><?php _e('Username','tdp-profile-edit'); ?></label></th>
										<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($profileuser->user_login); ?>" disabled="disabled" class="regular-text" /><br /><em><span class="description"><?php _e('Usernames cannot be changed.'); ?></span></em></td>
									</tr>
									<tr>
										<th><label for="first_name"><?php _e('First Name','tdp-profile-edit') ?></label></th>
										<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($profileuser->first_name) ?>" class="regular-text" /></td>
									</tr>

									<tr>
										<th><label for="last_name"><?php _e('Last Name','tdp-profile-edit') ?></label></th>
										<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($profileuser->last_name) ?>" class="regular-text" /></td>
									</tr>

									<tr>
										<th><label for="nickname"><?php _e('Nickname','tdp-profile-edit'); ?> <span class="description"><?php _e('(required)','tdp-profile-edit'); ?></span></label></th>
										<td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($profileuser->nickname) ?>" class="regular-text" /></td>
									</tr>

									<tr>
										<th><label for="display_name"><?php _e('Display to Public as','tdp-profile-edit') ?></label></th>
										<td>
											<select name="display_name" id="display_name">
											<?php
												$public_display = array();
												$public_display['display_username']  = $profileuser->user_login;
												$public_display['display_nickname']  = $profileuser->nickname;
												if ( !empty($profileuser->first_name) )
													$public_display['display_firstname'] = $profileuser->first_name;
												if ( !empty($profileuser->last_name) )
													$public_display['display_lastname'] = $profileuser->last_name;
												if ( !empty($profileuser->first_name) && !empty($profileuser->last_name) ) {
													$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
													$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
												}
												if ( !in_array( $profileuser->display_name, $public_display ) ) // Only add this if it isn't duplicated elsewhere
													$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;
												$public_display = array_map( 'trim', $public_display );
												$public_display = array_unique( $public_display );
												foreach ( $public_display as $id => $item ) {
											?>
												<option id="<?php echo $id; ?>" value="<?php echo esc_attr($item); ?>"<?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
											<?php
												}
											?>
											</select>
										</td>
									</tr>
								</table>

								<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("Contact Info", "tdp-profile-edit");?></div>

								<table class="form-table fields-lenght" id="fields-lenght">
									<tr>
										<th><label for="email"><?php _e('E-mail'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
										<td><input type="text" name="email" id="email" value="<?php echo esc_attr($profileuser->user_email) ?>" class="regular-text" />
										<?php
										$new_email = get_option( $current_user->ID . '_new_email' );
										if ( $new_email && $new_email != $current_user->user_email ) : ?>
										<div class="updated inline">
										<p><?php printf( __('There is a pending change of your e-mail to <code>%1$s</code>. <a href="%2$s">Cancel</a>','tdp-profile-edit'), $new_email['newemail'], esc_url(get_permalink().'?dismiss=' . $current_user->ID . '_new_email'  ) ); ?></p>
										</div>
										<?php endif; ?>
										</td>
									</tr>

									<tr>
										<th><label for="url"><?php _e('Website','tdp-profile-edit') ?></label></th>
										<td><input type="text" name="url" id="url" value="<?php echo esc_attr($profileuser->user_url) ?>" class="regular-text code" /></td>
									</tr>

									
									</table>
									<?php if( $show_biographical): ?>
									<div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e("About Yourself", "tdp-profile-edit");?></div>
									
									<?php endif; ?>

									<table class="form-table fields-lenght">
									<?php if( $show_biographical): ?>
									<tr>
										<th><label for="description" class="pos-me"><?php _e('Biographical Info','tdp-profile-edit'); ?></label></th>
										<td><textarea name="description" id="description" rows="5" cols="30"><?php echo esc_html($profileuser->description); ?></textarea><br />
										<span class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.','tdp-profile-edit'); ?></span></td>
									</tr>
									<?php endif; ?>
									
									<?php $show_password_fields = apply_filters('show_password_fields', true, $profileuser); if ( $show_password_fields ) : ?>
									
									<tr id="password">
										<th><label for="pass1"><?php _e('New Password','tdp-profile-edit'); ?></label><br /><br /><em><span class="description"><?php _e("If you would like to change the password type a new one. Otherwise leave this blank.",'tdp-profile-edit'); ?></span></em></th>
										<td>
											<input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /><br /><br />
											<input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" />&nbsp;<em><span class="description"><?php _e("Type your new password again.", 'tdp-profile-edit'); ?></span></em>
											
											<div id="pass-strength-result"><?php _e('Strength indicator','tdp-profile-edit'); ?></div>
											
											<p class="description indicator-hint">
											
											<?php _e('The password should be at least seven characters long.','tdp-profile-edit'); ?><br />
											<?php _e('To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).','tdp-profile-edit');?>
											
											</p>
										</td>
									</tr>
									<?php endif; ?>
									</table>

									<?php //do_action( 'show_user_profile', $profileuser ); ?>


									<p class="submit">
										<input type="hidden" name="action" value="update" />
										<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($user_id); ?>" />
										<input type="submit" class="button-primary" value="<?php _e('Update Profile','tdp-profile-edit'); ?>" name="submit" />
									</p>


							</form>

						</div>

						<script type="text/javascript" charset="utf-8">
							if (window.location.hash == '#password') {
								document.getElementById('pass1').focus();
							}
						</script>

				</div>

			</div>

		</div>





		<?php
		$form = ob_get_contents();
		ob_end_clean();
		
		return $form;
	}
	
	function process_login_form(){
		
		if(isset($_GET['action'])){
			$action = strtoupper($_GET['action']);
			switch($action){
				case "LOGOUT":
					if(is_user_logged_in()){
						wp_logout();
						$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : get_bloginfo('url').'/wp-login.php?loggedout=true';
						wp_safe_redirect( $redirect_to );
						exit();
					}else{
						$url = get_option('siteurl');
						wp_safe_redirect($url);
					}	
					
				break;
			}
		}
		
		if(!isset($_POST['fep_login'])) return;
		
		$userlogin = $_POST['log'];
		$userpass = $_POST['pwd'];
		$remember = $_POST['rememberme'];
		$creds = array();
		$creds['user_login'] = $userlogin;
		$creds['user_password'] = $userpass;
		$creds['remember'] = $remember;
		
		if(empty($userlogin)){
			$this->wp_error = new WP_ERROR("invalid_username",__('<strong>ERROR</strong>: Empty username'));
			return;
		}
		
		if(empty($userpass)){
			$this->wp_error = new WP_ERROR("incorrect_password",__('<strong>ERROR</strong>: Empty password'));
			return;
		}
		
		$user = wp_signon( $creds, false );
		
		if ( is_wp_error($user) ){
			$error_code = $user->get_error_code();
			switch(strtoupper($error_code)){
				case "INVALID_USERNAME":
				$this->wp_error = new WP_ERROR("invalid_username", __('<strong>ERROR</strong>: Invalid username'));
				break;
				case "INCORRECT_PASSWORD":
				$this->wp_error = new WP_ERROR("incorret_password", __('<strong>ERROR</strong>: Incorrect password'));
				break;
				default:
					$this->wp_error = $user;
				break;
			}
			
			return;
		}else{	
		 	$redirect = $this->curPageURL();
			wp_redirect($redirect);
			exit;
		}
	
	}
	
	function login_form( $url="" ){
		
		$wp_error = $this->wp_error;
			
		if( is_wp_error($wp_error)){
			echo "<div class=\"fep-message-error\">".$wp_error->get_error_message()."</div>";
		}
		
		?>
		<form method="post">
			<input type="hidden" name="fep_login" value="1" />
		    <p><label for="log"><?php _e('Username');?></label><br /><input type="text" name="log" id="log" value="" size="20" /> </p>

		    <p><label for="pwd"><?php _e('Password');?></label><br /><input type="password" name="pwd" id="pwd" size="20" /></p>

		    <p><input type="submit" name="submit" value="<?php _e('Logged me in');?>" class="button" /></p>

		    <p>
		       <label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php _e('Remember me');?></label>
		       <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		    </p>
		</form>
		
		<?php
	}
	
	function basic_form( $atts ){
		
		$text = get_option("fep_notlogin");
		$show_loginform = (get_option('fep_loginform') == "on")? true : false;	
			
		if( !(is_user_logged_in()) ){
			
			$login_url = wp_login_url();
			$lostpassword_url = wp_lostpassword_url();
			$text = str_replace("%LOGIN_URL%",$login_url,$text);
			$text = str_replace("%LOSTPASSWORD_URL%",$lostpassword_url,$text);
			
			_e($text);
			if($show_loginform){
				echo "<br /><br />";
				do_action('fep_loginform');
			}
			return;
		}
		
		if(isset($_POST['user_id'])) {
			$output = self::process_form($atts);	
			return $output;
		} else {
			$data = array();
			$form = self::build_form( $data );
			return $form;		
		}
		

	}
	
	function shortcode( $atts ){
		$function = self::basic_form( $atts );
		return $function;
	}
	
}
$fep = new FRONTEND_EDIT_PROFILE;
?>