<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Hangar Maintenance Mode Settings Class
 *
 * @package WordPress
 * @subpackage Hangar
 * @category Downloadable
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * public $templates_dir
 * 
 * - __construct()
 * - init_sections()
 * - init_fields()
 * - find_templates()
 * - get_template_data()
 */
class Hangar_Maintenance_Mode_Settings extends Hangar_Settings_API {
	public $templates_dir;

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct () {
	    parent::__construct(); // Required in extended classes.
	} // End __construct()
	
	/**
	 * init_sections function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_sections () {
		$sections = array();
		
		$sections['general'] = array(
			'name' 			=> __( 'General Settings', 'hangar-maintenance-mode' ), 
			'description'	=> __( 'Determine who sees Maintenance Mode and who is allowed to view the website when logged in.', 'hangar-maintenance-mode' )
		);

		$sections['display'] = array(
			'name' 			=> __( 'Display Settings', 'hangar-maintenance-mode' ), 
			'description'	=> sprintf( __( 'The default option is to use a native error message on the front end of your website. You can customize this by entering a title and note below. To customize your own maintenance mode theme, you can add a %s file to your current theme (child theme, if you\'re using one).', 'hangar-maintenance-mode' ), '<code>503.php</code>' )
		);

		$sections['toggles'] = array(
			'name' 			=> __( 'Toggle Settings', 'hangar-maintenance-mode' ), 
			'description'	=> __( 'Whether or not to allow certain WordPress internal features to function when in Maintenance Mode.', 'hangar-maintenance-mode' )
		);
		
		$this->sections = $sections;
	} // End init_sections()
	
	/**
	 * init_fields function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_fields () {
	    $options = array( 'wp_die' => __( 'Use WordPress Default', 'hangar-maintenance-mode' ), 'theme-503' => __( '503.php in the current theme', 'hangar-maintenance-mode' ) );

	    $results = $this->find_templates();

		if ( is_array( $results ) && count( $results ) > 0 ) {
			foreach ( $results as $k => $v ) {
				$options[$k] = $v;
			}
		}

		// Allow themes/plugins to filter here.
	    $options = apply_filters( 'hangar_maintenance_mode_templates', $options );

	    $fields = array();
	    
		$fields['enable'] = array(
		    'name' => __( 'Enable', 'hangar-maintenance-mode' ), 
		    'description' => __( 'Turn on maintenance mode.', 'hangar-maintenance-mode' ), 
		    'type' => 'checkbox', 
		    'default' => false, 
		    'section' => 'general'
		);
	    
		$fields['role'] = array(
		    'name' => __( 'Bypass Capability Requirement', 'hangar-maintenance-mode' ), 
		    'description' => __( 'Determine which level of users can see the website when in Maintenance Mode.', 'hangar-maintenance-mode'), 
		    'type' => 'select', 
		    'default' => 'manage_options', 
		    'options'	=> array(
		    	'manage_options'	=> __( 'Administrator', 'hangar-maintenance-mode' ),
		    	'publish_pages'		=> __( 'Editor', 'hangar-maintenance-mode' ),
		    	'publish_posts'		=> __( 'Author', 'hangar-maintenance-mode' ),
		    	'edit_posts'		=> __( 'Contributor', 'hangar-maintenance-mode' ),
		    	'read'				=> __( 'Subscriber', 'hangar-maintenance-mode' )
		    ),
		    'section' => 'general'
		);
	    
		$fields['template'] = array(
		    'name' => __( 'Template', 'hangar-maintenance-mode' ), 
		    'description' => __( 'Choose the design to be used for your Maintenance Mode screen.', 'hangar-maintenance-mode' ), 
		    'type' => 'select', 
		    'default' => 'wp_die', 
		    'options'	=> $options,
		    'section' => 'display'
		);
	    
		$fields['page_title'] = array(
		    'name' => __( 'Maintenance Page Title', 'hangar-maintenance-mode' ), 
		    'description' => __( 'This is the page title for the Maintenance Mode page. Leave blank to use your website\'s title.', 'hangar-maintenance-mode' ), 
		    'type' => 'text', 
		    'default' => '', 
		    'section' => 'display'
		);

		$fields['title'] = array(
		    'name' => __( 'Maintenance Title', 'hangar-maintenance-mode' ), 
		    'description' => __( 'This is the HTML title of the Maintenance Mode page. Leave blank for the default.', 'hangar-maintenance-mode' ), 
		    'type' => 'text', 
		    'default' => '', 
		    'section' => 'display'
		);
	    
		$fields['note'] = array(
		    'name' => __( 'Maintenance Note', 'hangar-maintenance-mode' ), 
		    'description' => __( 'A brief note that will be included in the Maintenance Mode page. Leave blank for the default text.', 'hangar-maintenance-mode' ), 
		    'type' => 'textarea', 
		    'default' => '', 
		    'section' => 'display'
		);

		$fields['enable_feeds'] = array(
		    'name' => __( 'Allow Feeds', 'hangar-maintenance-mode' ), 
		    'description' => __( 'Allow feeds when in Maintenance Mode.', 'hangar-maintenance-mode' ), 
		    'type' => 'checkbox', 
		    'default' => true, 
		    'section' => 'toggles'
		);

		$fields['enable_trackbacks'] = array(
		    'name' => __( 'Allow Trackbacks', 'hangar-maintenance-mode' ), 
		    'description' => __( 'Allow trackbacks when in Maintenance Mode.', 'hangar-maintenance-mode' ), 
		    'type' => 'checkbox', 
		    'default' => true, 
		    'section' => 'toggles'
		);

		$fields['enable_xmlrpc'] = array(
		    'name' => __( 'Allow XML-RPC', 'hangar-maintenance-mode' ), 
		    'description' => __( 'Allow XML-RPC when in Maintenance Mode.', 'hangar-maintenance-mode' ), 
		    'type' => 'checkbox', 
		    'default' => true, 
		    'section' => 'toggles'
		);
		
		$this->fields = $fields;
	
	} // End init_fields()

	/**
 	 * find_templates function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return array $results
	 */
	private function find_templates () {
		$results = array();

		$files = Hangar_Utils::glob_php( '*.php', GLOB_MARK, $this->templates_dir );

		if ( is_array( $files ) && count( $files ) > 0 ) {
			foreach ( $files as $k => $v ) {
				$data = $this->get_template_data( $v );
				if ( is_object( $data ) && isset( $data->title ) ) {
					$results[$v] = $data->title;
				}
			}
		}

		return $results;
	} // End find_templates()

	/**
	 * get_template_data function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $file The path to the file to be scanned for template file data.
	 * @return object/boolean
	 */
	private function get_template_data ( $file ) {
		$headers = array(
			'title' => 'Template Name',
			'description' => 'Description', 
			'version' => 'Version'
		);
		$mod = get_file_data( $file, $headers );
		if ( ! empty( $mod['title'] ) ) {
			$obj = new StdClass();
			
			foreach ( $mod as $k => $v ) {
				$obj->$k = $v;
			}

			return $obj;
		}
		return false;
	} // End get_template_data()
} // End Class Hangar_Maintenance_Mode_Settings
?>