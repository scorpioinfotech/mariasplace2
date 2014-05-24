<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'Please do not load this screen directly. Thanks!' );
}

/**
 * Hangar - Social Widget
 *
 * Base class for the Hangar - Social Widgets feature.
 *
 * @package WordPress
 * @subpackage Hangar
 * @category Bundled
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * var $service
 * var $token
 * var $settings_screen
 *
 * - __construct()
 * - load_settings_screen()
 */
class Hangar_Social_Widgets{

	/* Variable Declarations */
	var $token;
	var $settings_screen;
	var $page_slug;
	var $settings_url;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct () {
		/* Class Settings */
		$this->token = 'hangar-social-widgets';
		if ( is_admin() ) {
			$this->name		= __( 'Hangar Social Widgets', 'hangar' );
			$this->menu_label	= __( 'Social Widgets', 'hangar' );
			$this->page_slug	= 'hangar-social-widgets-settings';
		}
		/* Settings Screen */
		$this->load_settings_screen();
		add_action( 'admin_init', array( $this, 'admin_notices' ) );
	} // End __construct()

	/**
	 * load_settings_screen function.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_settings_screen () {
		/* Settings Screen */
		require_once( 'settings.class.php' );
		$this->settings_screen = new Hangar_SocialWidgets_Settings();

		/* Setup shortlinks data */
		$this->settings_screen->token = $this->token;
		if ( is_admin() ) {
			$this->settings_screen->name = __( 'Hangar Social Widgets', 'hangar' );
			$this->settings_screen->menu_label = __( 'Social Widgets', 'hangar' );
			$this->settings_screen->page_slug = 'hangar-social-widgets-settings';
		}
		$this->settings_screen->setup_settings();
	} // End load_settings_screen()

	/**
	 * admin_notices function.
	 *
	 * @access public
	 * @since 1.5.3
	 * @return void
	 */
	function admin_notices() {
		$this->settings_url = 
		print $this->settings_url;
		add_action( 'admin_notices', array( $this, 'twitter_api_admin_notice' ) );
	}

	/**
	 * twitter_api_admin_notice function.
	 *
	 * @access public
	 * @since 1.5.3
	 * @return void
	 */
	function twitter_api_admin_notice() {
		$api_settings = $this->settings_screen->get_settings();
		$url = add_query_arg( array( 'page' => 'hangar-social-widgets-settings' ), admin_url( 'admin.php') );
		if ( ! isset( $api_settings['consumer_key'] ) || $api_settings['consumer_key'] == '' || ! isset( $api_settings['consumer_secret'] ) || $api_settings['consumer_secret'] == '' || ! isset( $api_settings['access_key'] ) || $api_settings['access_key'] == '' || ! isset( $api_settings['access_secret'] ) || $api_settings['access_secret'] == '' ) {
	?>
		    <div class="updated">
		        <p><?php echo sprintf( __( '<strong>The Hangar Tweets Widget is almost ready.</strong> You must enter your <a href="%s">Twitter API Settings</a> for it to work.', 'hangar' ), $url ); ?></p>
		    </div>
    <?php
		}
	}

} // End Class
?>