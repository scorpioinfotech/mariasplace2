<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this screen directly. Thanks!' );
}

global $hangar;
?>
<div id="hangar" class="wrap <?php echo esc_attr( $this->token ); ?>">
	<h2><?php echo esc_html( $this->name ); ?></h2>
	<p class="powered-by-woo button"><?php _e( 'Powered by', 'hangar' ); ?><a href="http:www/themesdepot.org" title="ThemesDepot">ThemesDepot</a></p>
	
	<form action="options.php" method="post">
		<?php $this->settings_tabs(); ?>
		<?php settings_fields( $this->token ); ?>
		<?php do_settings_sections( $this->token ); ?>
		<?php submit_button(); ?>
	</form>
</div><!--/#hangar-->