<?php 
function bp_activity_bump_admin_get_role_capabilities() {
	global $wp_roles;

	$capabilities = array();

	foreach ( $wp_roles->role_objects as $key => $role ) {

		if ( is_array( $role->capabilities ) ) {

			foreach ( $role->capabilities as $cap => $grant )
				$capabilities[$cap] = $cap;
		}
	}

	return $capabilities;
}

function bp_activity_bump_admin_check_for_cap( $cap = '' ) {
	if ( !$cap )
		return false;
	$caps = bp_activity_bump_admin_get_role_capabilities();
	if ( in_array( $cap, $caps ) )
		return true;
	return false;
}

function bp_activity_bump_admin_unique_types( ) {
	global $bp, $wpdb;
	
	$count = $wpdb->get_results( "SELECT DISTINCT a.type FROM {$bp->activity->table_name} a ORDER BY a.date_recorded DESC" );
	
	return $count;
}

function bp_activity_bump_admin_type_check( $type, $currenttypes ) {
	if ( in_array( $type, $currenttypes) )
		echo 'checked';
		
	return;
}

function bp_activity_bump_admin() {
	global $bp;

	if ( isset( $_POST['submit'] ) && check_admin_referer('bp_activity_bump_admin') ) {
	
		if( isset($_POST['ab_activity_types'] ) && !empty($_POST['ab_activity_types']) ) {
			update_option( 'bp_activity_bump_denied_activity_types', $_POST['ab_activity_types'] );
		} else {
			update_option( 'bp_activity_bump_denied_activity_types', '' );
		}
		$data = maybe_unserialize( get_option( 'bp_activity_bump_denied_user_types') );
		$newrule = Array();	

		if ( isset( $_POST['ab_user_cap'] ) && !empty( $_POST['ab_user_cap'] ) ) {
			if ( bp_activity_bump_admin_check_for_cap( $_POST['ab_user_cap'] ) ) {
				$newrule['user_cap'] = $_POST['ab_user_cap'];
			} else {
				$newrule['user_cap'] = false;
				$error[] = '<div id="message" class="error"><p>Invalid user wp capability - please see <a href="http://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table">WP Roles and Capabilities</a>.</p></div>';
			}
		} else {
			$newrule['user_cap'] = false;
		}
		
		if( isset($_POST['ab_super_admin'] ) && !empty($_POST['ab_super_admin']) && (int)$_POST['ab_super_admin'] == 1 ) {
			$newrule['super_admin'] = true;
		} else {
			$newrule['super_admin'] = false;
		}		
		
		update_option( 'bp_activity_bump_denied_user_types', $newrule );
		
		$updated = true;
	}
	
	if ( isset( $_POST['submit_restore'] ) && check_admin_referer('etivite_bp_activity_bump_admin_restore') ) {
	
		global $wpdb;
		
		$bumpdates = $wpdb->get_results( $wpdb->prepare( "SELECT activity_id, meta_value FROM {$bp->activity->table_name_meta} WHERE meta_key = %d", 'bp_activity_bump_date_recorded' ) );

		if ($bumpdates) {

			foreach ($bumpdates as $bumpdate) { 
			
				$q = $wpdb->query( $wpdb->prepare( "UPDATE {$bp->activity->table_name} SET date_recorded = %s WHERE id = %d", $bumpdate->meta_value, $bumpdate->activity_id ) );
			
				wp_cache_delete( 'bp_activity_meta_bp_activity_bump_date_recorded_' . $bumpdate->activity_id, 'bp' );
				
			}			
			wp_cache_delete( 'bp_activity_sitewide_front', 'bp' );
			
			$d = $wpdb->query( $wpdb->prepare( "DELETE FROM {$bp->activity->table_name_meta} WHERE meta_key = %s", 'bp_activity_bump_date_recorded' ) );
			
			$convertupdated = true;
		}
		
	}
	
?>	
	<div class="wrap">
		<h2><?php _e( 'Activity Stream Bump Admin', 'bp-activity-bump' ); ?></h2>

		<?php if ( isset($updated) ) : echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-activity-bump' ) . "</p></div>"; endif;
		if ( isset($error) ) { 
			foreach( $error as $err) { 
				echo $err;
			} 
		}
		if ( isset($convertupdated) ) : echo "<div id='message' class='updated fade'><p>" . __( 'Activity Dates Restored. You may now uninstall this plugin.', 'bp-activity-bump' ) . "</p></div>"; endif; ?>
		<form action="<?php echo network_admin_url('/admin.php?page=bp-activity-bump-settings') ?>" name="bp-activity-bump-settings-form" id="bp-activity-bump-settings-form" method="post">

			<h4><?php _e( 'Activity Types to Exclude', 'bp-activity-bump' ); ?></h4>
			<p class="description">This list is dynamic depending on what plugins have created new activity types. Select the items below that you do not want to be bumped if a comment reply is made.</p>

			<table class="form-table">
				<?php
				$currenttypes = (array) get_option( 'bp_activity_bump_denied_activity_types');
				$uniquetypes = bp_activity_bump_admin_unique_types();

				foreach ($uniquetypes as $types) { ?>
					<tr>
						<th><label for="type-<?php echo $types->type ?>"><?php echo $types->type ?></label></th>
						<td><input id="type-<?php echo $types->type ?>" type="checkbox" <?php bp_activity_bump_admin_type_check( $types->type, $currenttypes ); ?> name="ab_activity_types[]" value="<?php echo $types->type ?>" /></td>
					</tr>
				<?php } ?>
			</table>

			<h4><?php _e( 'User Access', 'bp-activity-bump' ); ?></h4>
			<p class="description">Allow only certain user types to bump activity items</p>
<?php
$data = maybe_unserialize( get_option( 'bp_activity_bump_denied_user_types') );
?>
			<table class="form-table">
				<tr>
					<th><label for="ab_super_admin"><?php _e('Site Admins','bp-restrictgroups') ?></label></th>
					<td><input <?php if ( $data['super_admin'] ) { echo 'checked'; } ?> type="checkbox" name="ab_super_admin" id="ab_super_admin" value="1" /></td>
				</tr>
				
				<tr>
					<th><label for="ab_user_cap"><?php _e('User capability level','bp-restrictgroups') ?></label></th>
					<td><input type="text" name="ab_user_cap" id="ab_user_cap" value="<?php if ( $data['user_cap'] ) { echo $data['user_cap']; } ?>" /> </td>
				</tr>
			</table>
			
			<div class="description">
				<p>Default: All members may bump an activity item if nothing selected above</p>
				<p>Please refer to the <a href="http://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table">Codex for WP Caps</a></p>
			</div>
			
			<?php wp_nonce_field( 'bp_activity_bump_admin' ); ?>
			
			<p class="submit"><input type="submit" name="submit" value="Save Settings"/></p>
			
		</form>
		
		<h3>Restore Activity Dates</h3>
		<p class="description">If you want to uninstall this plugin - run this utility to restore the activity date_recorded values. Please note: Once you restore dates - you will lose all previous "bump" dates - even if you install this plugin again. Always backup your database first.</p>
		
		<?php if ( isset($convertupdated) ) : echo "<div id='message' class='updated fade'><p>" . __( 'Date Records Restored - You may uninstall this plugin now.', 'bp-activity-bump' ) . "</p>
		<p>Restored Bumped Activity Dates: ". count($bumpdates) ."</p></div>"; endif; ?>

		<form action="<?php echo network_admin_url('/admin.php?page=bp-activity-bump-settings') ?>" name="bp-activity-bump-restore-form" id="bp-activity-bump-restore-form" method="post">

			<?php wp_nonce_field( 'bp_activity_bump_admin_restore' ); ?>
			
			<p class="submit"><input style="color:red" id="bump_restore" type="submit" name="submit_restore" value="Restore Dates Now"/></p>
			
		</form>
		
		<h3>About:</h3>
		<div id="plugin-about" style="margin-left:15px;">
			
			<p>
			<a href="http://gladwinput.com/buddypress-bumping-activity-streams-to-top-with-new-comments/">Bump Activity Streams To Top About Page</a><br/> 
			</p>
			<p>
			<a href="http://gladwinput.com">Author's site</a><br/>
			</p>
		</div>
		
		<script type="text/javascript"> jQuery(document).ready( function() { jQuery("#bump_restore").click( function() { if ( confirm( '<?php _e( 'Are you sure?', 'buddypress' ) ?>' ) ) return true; else return false; }); });</script>
		
	</div>
<?php
}

?>
