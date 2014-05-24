<?php 
/**
 * Customize for textarea, extend the WP customizer
 *
 * @package    WordPress
 * @subpackage Wordpress-Theme-Customizer-Custom-Controls
 * @see        https://github.com/bueltge/Wordpress-Theme-Customizer-Custom-Controls
 * @since      10/16/2012
 * @author     Frank Bültge <frank@bueltge.de>
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

class Textarea_Custom_Control extends WP_Customize_Control {

	/**
	 * @access public
	 * @var    string
	 */
	public $type = 'textarea';

	/**
	 * @access public
	 * @var    array
	 */
	public $statuses;

	/**
	 * Constructor.
	 *
	 * If $args['settings'] is not defined, use the $id as the setting ID.
	 *
	 * @since   10/16/2012
	 * @uses    WP_Customize_Control::__construct()
	 * @param   WP_Customize_Manager $manager
	 * @param   string $id
	 * @param   array $args
	 * @return  void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		$this->statuses = array( '' => __( 'Default','atlas' ) );
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the control's content.
	 * 
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 * 
	 * @since   10/16/2012
	 * @return  void
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
				<?php echo esc_textarea( $this->value() ); ?>
			</textarea>
		</label>
		<?php
	}

}

// ===================== CUSTOM ===============================================================
	
function dp_customize_register( $wp_customize ) {

		$wp_customize->add_section('skin' , array(
	    'title' => __('Theme Skin','atlas'),
		));

		$wp_customize->add_setting('enable_custom_style', array());
		$wp_customize->add_control('enable_custom_style', array(
			'label'      => __('Theme Skin Style', 'atlas'),
			'section'    => 'skin',
			'settings'   => 'enable_custom_style',
			'type'       => 'select',
			'default'	 => 'default',
			'choices'    => array(
				'default'   => 'Default Skin',
				'skin2'  => 'Skin 2',
				'skin3'  => 'Skin 3',
				'skin4'  => 'Skin 4',
				'skin5'  => 'Skin 5',
				'skin6'  => 'Skin 6',
				'skin7'  => 'Skin 7',
				'custom'  => 'Enable Custom Controls (Below Here)',
			),
		));
	
		$wp_customize->remove_control('blogdescription');
		 
		// rename existing section
		$wp_customize->add_section( 'title_tagline' , array(
			'title'		=> __('Site Title','atlas'),
			'priority'	=> 20,
		));

		$colors = array();
		$colors[] = array(
			'slug'=>'topbar_1', 
			'default' => '#252525',
			'label' => __('Topbar Gradient Start', 'atlas')
		);

		$colors[] = array(
			'slug'=>'topbar_2', 
			'default' => '#393939',
			'label' => __('Topbar gradient end', 'atlas')
		);
		$colors[] = array(
			'slug'=>'topbar_c', 
			'default' => '#A7A7A7',
			'label' => __('Topbar text color', 'atlas')
		);
		$colors[] = array(
			'slug'=>'topbar_links', 
			'default' => '#fff',
			'label' => __('Topbar links color', 'atlas')
		);
		$colors[] = array(
			'slug'=>'header_color', 
			'default' => '#fff',
			'label' => __('Header Color', 'atlas')
		);
		$colors[] = array(
			'slug'=>'header_links', 
			'default' => '#979797',
			'label' => __('Header Links Color', 'atlas')
		);
		$colors[] = array(
			'slug'=>'header_active_links', 
			'default' => '#212121',
			'label' => __('Header Active Link Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'homepage_sidebar_bg', 
			'default' => '#262F3A',
			'label' => __('Homepage Sidebar Bg Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'homepage_sidebar_cbg', 
			'default' => '#fff',
			'label' => __('Homepage Sidebar Tabs Bg Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'homepage_sidebar_tab1', 
			'default' => '#8a8a8a',
			'label' => __('Homepage Sidebar Tabs Icon Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'homepage_sidebar_tab2', 
			'default' => '#fff',
			'label' => __('Homepage Sidebar Tabs Icon Active Color', 'atlas')
		);
		$colors[] = array(
			'slug'=>'homepage_sidebar_h', 
			'default' => '#212121',
			'label' => __('Homepage Sidebar Tabs Headings Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'theme_main_color', 
			'default' => '#212121',
			'label' => __('Theme Main Color (Use this option to change the color of various elements of the theme, quick and easy)', 'atlas')
		);

		$colors[] = array(
			'slug'=>'body_font_color', 
			'default' => '#616161',
			'label' => __('Body Font Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'body_bg_color', 
			'default' => '#ffffff',
			'label' => __('Body Background Color', 'atlas')
		);
		$colors[] = array(
			'slug'=>'map_pulse_bg', 
			'default' => '#a8a8a8',
			'label' => __('Map Pulse Animation Bg Color', 'atlas')
		);
		$colors[] = array(
			'slug'=>'top_footer_color', 
			'default' => '#171717',
			'label' => __('Top Footer Background Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'bottom_footer_color', 
			'default' => '#292929',
			'label' => __('Bottom Footer Background Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'bottom_footer_border_color', 
			'default' => '#353535',
			'label' => __('Bottom Footer Border Color', 'atlas')
		);

		$colors[] = array(
			'slug'=>'footer_font_color', 
			'default' => '#3a3a3a',
			'label' => __('Footer Font Color', 'atlas')
		);
		foreach( $colors as $color ) {
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 
					'edit_theme_options'
				)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array('label' => $color['label'], 
					'section' => 'colors',
					'settings' => $color['slug'])
				)
			);
		}


}
add_action( 'customize_register', 'dp_customize_register' );

?>