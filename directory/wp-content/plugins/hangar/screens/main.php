<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}

global $hangar;
if ( $this->model->current_action_response == 'cred' ) {
	return;
}
?>



<div id="hangar" class="wrap about-wrap">
	<h1><?php echo esc_html( $this->name ); ?> <span class="version"><?php echo esc_html( $hangar->version ); ?></span></h1>
	<p class="powered-by-woo button"><?php _e( 'Powered by', 'hangar' ); ?> <a href="http://www.themesdepot.org" title="ThemesDepot">ThemesDepot</a></p>
	<div class="about-text"><?php _e( 'Hangar is a powerful toolkit of features to enhance your website. Select only the functionality that you need, without unnecessary code. Hangar Is compatible only with ThemesDepot themes.', 'hangar' ); ?></div>
	

	
	<ul class="subsubsub  hide-if-no-js open-close-all">
		<li><a href="#open-all" class="button"><?php _e( 'Open All Modules', 'hangar' ); ?></a></li>
		<li><a href="#close-all" class="button"><?php _e( 'Collapse All Modules', 'hangar' ); ?></a></li>
	</ul>
	
	<br class="clear"/>
	
	<?php
		foreach ( $this->model->components as $k => $v ) {
			if ( count( $v ) > 0 ) {
				include( $this->screens_path . 'main/section.php' );
			}
		}
	?>
	<br class="clear" />
</div><!--/#hangar .wrap-->