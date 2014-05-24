<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}

/**
 * Hangar API Class
 *
 * All functionality pertaining to the Hangar API interactions.
 *
 * @package WordPress
 * @subpackage Hangar
 * @category API
 * @author WooThemes
 * @since 1.0.0
 *
 */
class Hangar_API {
	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct (  ) {
		

	} // End __construct()
	
	

	
	/**
	 * get_products_by_type function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $type (default: 'bundled')
	 * @return array $response
	 */
	public function get_products_by_type ( $type = 'bundled' ) {
		if ( ! in_array( $type, array( 'bundled' ) ) ) { return array(); }
		
		$response = array();
		$products = $this->get_products();
		
		if ( count( (array)$products ) > 0 ) {
			foreach ( (array)$products as $k => $v ) {
				if ( isset( $v->type ) && ( $v->type == $type ) ) {
					$slug = $v->slug;
					
					$filepath = $slug . '/' . $slug . '.php';
					$v->filepath = $filepath;
					$response[$slug] = $v;
				}
			}
		}

		return $response;
	} // End get_products_by_type()
	


	/**
	 * get_settings function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @uses $this->request()
	 * @return array $settings
	 */
	public function get_settings () {
		$settings = array();
		

		return $settings;
	} // End get_settings()

	
}
?>