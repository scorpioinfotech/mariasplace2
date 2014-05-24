<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}

/**
 * Hangar Frontend Class
 *
 * All functionality pertaining to the frontend sections of Hangar.
 *
 * @package WordPress
 * @subpackage Hangar
 * @category Frontend
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * - __construct()
 */
class Hangar_Frontend extends Hangar_Base {
	public function __construct() {
		parent::__construct();
	} // End __construct()
}
?>