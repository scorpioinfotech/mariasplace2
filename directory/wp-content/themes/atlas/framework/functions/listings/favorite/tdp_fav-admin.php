<?php
$tdp_fav_options = get_option('tdp_fav_options');
if ( isset($_POST['submit']) ) {
	if ( function_exists('current_user_can') && !current_user_can('manage_options') )
		die(__('Cheatin&#8217; uh?'));
    if ($_POST['show_remove_link'] == 'show_remove_link') $_POST['added'] = 'show remove link';
    if ($_POST['show_add_link'] == 'show_add_link') $_POST['removed'] = 'show add link';
	$tdp_fav_options['add_favorite'] = htmlspecialchars($_POST['add_favorite']);
	$tdp_fav_options['added'] = htmlspecialchars($_POST['added']);
	$tdp_fav_options['remove_favorite'] = htmlspecialchars($_POST['remove_favorite']);
	$tdp_fav_options['removed'] = htmlspecialchars($_POST['removed']);
	$tdp_fav_options['clear'] = htmlspecialchars($_POST['clear']);
	$tdp_fav_options['cleared'] = htmlspecialchars($_POST['cleared']);
	$tdp_fav_options['favorites_empty'] = htmlspecialchars($_POST['favorites_empty']);
	$tdp_fav_options['rem'] = htmlspecialchars($_POST['rem']);
	$tdp_fav_options['cookie_warning'] = htmlspecialchars($_POST['cookie_warning']);
	$tdp_fav_options['opt_only_registered'] = htmlspecialchars($_POST['opt_only_registered']);
	$tdp_fav_options['text_only_registered'] = htmlspecialchars($_POST['text_only_registered']);
	$tdp_fav_options['statics'] = htmlspecialchars($_POST['statics']);
	$tdp_fav_options['before_image'] = htmlspecialchars($_POST['before_image']);
	$tdp_fav_options['custom_before_image'] = htmlspecialchars($_POST['custom_before_image']);
	$tdp_fav_options['dont_load_js_file'] = htmlspecialchars($_POST['dont_load_js_file']);
	$tdp_fav_options['dont_load_css_file'] = htmlspecialchars($_POST['dont_load_css_file']);
	$tdp_fav_options['autoshow'] = htmlspecialchars($_POST['autoshow']);
	$tdp_fav_options['post_per_page'] = htmlspecialchars($_POST['post_per_page']);

	update_option('tdp_fav_options', $tdp_fav_options);
}
if ( isset($_GET['action'] ) ) {
	if ($_GET['action'] == 'reset-statics') {
		global $wpdb;
		    $results = $wpdb->get_results($query);
		$query = "DELETE FROM $wpdb->postmeta WHERE meta_key = 'tdp_fav_favorites'";
		
		$message = '<div class="updated below-h2" id="message"><p>';
		if ($wpdb->query($query)) {
			$message .= "All statistic data about wp favorite posts plugin have been <strong>deleted</strong>.";
		} else {
			$message .= "Something gone <strong>wrong</strong>. Data couldn't delete. Maybe thre isn't any data to delete?";
		}	
		$message .= '</p></div>';
	}
}
?>
<?php if ( !empty($_POST ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<?php screen_icon(); ?>
<h2><?php _e('Favorite Posts Configuration', 'tdp-fav-listings'); ?></h2>

<div class="metabox-holder" id="poststuff">
<div class="meta-box-sortables">
<script>
jQuery(document).ready(function($) {
	$('.postbox').children('h3, .handlediv').click(function(){ $(this).siblings('.inside').toggle();});
	$('#tdp_fav-reset-statics').click(function(){
		return confirm('All statistic data will be deleted, are you sure ?');
		});
});
</script>
<div class="postbox">
    <div title="<?php _e("Click to open/close", "tdp-fav-listings"); ?>" class="handlediv">
      <br>
    </div>
    <h3 class="hndle"><span><?php _e("Do you use it ?", "tdp-fav-listings"); ?></span></h3>
    <div class="inside" style="display: block;">
        <img src="../wp-content/plugins/tdp-fav-listings/img/icon_coffee.png" alt="buy me a coffee" style=" margin: 5px; float:left;" />
        <p>Hi! I'm <a href="http://nxsn.com?f=tdp_fav" target="_blank" title="Huseyin Berberoglu">Huseyin Berberoglu</a>, developer of this plugin.</p>
        <p>I've been spending many hours to develop this plugin. <br />If you like and use this plugin, you can <strong>buy me a cup of coffee</strong>.</p>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
            ">
            <input type="image" src="../wp-content/plugins/tdp-fav-listings/img/donate.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
        </form>
        <div style="clear:both;"></div>
    </div>
</div>
<?php echo $message; ?>
<form action="" method="post">


<div class="postbox">
    <div title="<?php _e("Click to open/close", "tdp-fav-listings"); ?>" class="handlediv">
      <br>
    </div>
    <h3 class="hndle"><span><?php _e("Options", "tdp-fav-listings"); ?></span></h3>
    <div class="inside" style="display: block;">

        <table class="form-table">
            <tr>
                <th><?php _e("Only <strong>registered users</strong> can favorite", "tdp-fav-listings") ?></th><td><input type="checkbox" name="opt_only_registered" value="1" <?php if (stripslashes($tdp_fav_options['opt_only_registered']) == "1") echo "checked='checked'"; ?> /></td>
            </tr>

            <tr>
                <th><?php _e("Auto show favorite link", "tdp-fav-listings") ?></th>
                <td>
                    <select name="autoshow">
                        <option value="custom" <?php if ($tdp_fav_options['autoshow'] == 'custom') echo "selected='selected'" ?>>Custom</option>
                        <option value="after" <?php if ($tdp_fav_options['autoshow'] == 'after') echo "selected='selected'" ?>>After post</option>
                        <option value="before" <?php if ($tdp_fav_options['autoshow'] == 'before') echo "selected='selected'" ?>>Before post</option>
                    </select>
                    (Custom: insert <strong>&lt;?php tdp_fav_link() ?&gt;</strong> wherever you want to show favorite link)
                </td>
            </tr>

            <tr>
                <th><?php _e("Before Link Image", "tdp-fav-listings") ?></th>
                <td>
                    <p>
                    <?php
                    $images[] = "star.png";
                    $images[] = "heart.png";
                    $images[] = "bullet_star.png";
                    foreach ($images as $img):
                    ?>
                    <label for="<?php echo $img ?>">
                        <input type="radio" name="before_image" id="<?php echo $img ?>" value="<?php echo $img ?>" <?php if ($tdp_fav_options['before_image'] == $img) echo "checked='checked'" ?> />
                        <img src="<?php echo TDP_FAV_PATH; ?>/img/<?php echo $img; ?>" alt="<?php echo $img; ?>" title="<?php echo $img; ?>" class="tdp_fav-img" />
                    </label>
                    <br />
                    <?php
                    endforeach;
                    ?>
                    <label for="custom">
                        <input type="radio" name="before_image" id="custom" value="custom" <?php if ($tdp_fav_options['before_image'] == 'custom') echo "checked='checked'" ?> />
                        Custom Image URL :
                    </label>
                    <input type="custom_before_image" name="custom_before_image" value="<?php echo stripslashes($tdp_fav_options['custom_before_image']); ?>" />
                    <br />
                    <label for="none">
                        <input type="radio" name="before_image" id="none" value="" <?php if ($tdp_fav_options['before_image'] == '') echo "checked='checked'" ?> />
                        No Image
                    </label>
                </td>
            </tr>

            <tr>
                <th><?php _e("Favorite post per page", "tdp-fav-listings") ?></th>
                <td>
                    <input type="text" name="post_per_page" size="2" value="<?php echo stripslashes($tdp_fav_options['post_per_page']); ?>" /> * This only works with default favorite post list page (tdp_fav-page-template.php).
                </td>
            </tr>
            <tr>
                <th><?php _e("Most favorited posts statics", "tdp-fav-listings") ?>*</th>
                <td>
                    <label for="stats-enabled"><input type="radio" name="statics" id="stats-enabled" value="1" <?php if ($tdp_fav_options['statics']) echo "checked='checked'" ?> /> Enabled</label>
                    <label for="stats-disabled"><input type="radio" name="statics" id="stats-disabled" value="0" <?php if (!$tdp_fav_options['statics']) echo "checked='checked'" ?> /> Disabled</label>
                </td>
            </tr>
        	<tr><td></td>
                <td>
                	<div class="submitbox">
	                	<div id="delete-action">
						<a href="?page=tdp-fav-listings&amp;action=reset-statics" id="tdp_fav-reset-statics" class="submitdelete deletion">Reset Statistic Data</a>
						</div>
					</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>* If statics enabled plugin will count how much a post added to favorites.<br />
                        You can show this statics with <a href="widgets.php" title="Go to widgets">"Most Favorited Posts" widget</a>.</p>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit" class="button" value="<?php _e('Update options &raquo;'); ?>" />
                </td>
            </tr>
        </table>

    </div>
</div>

<div class="postbox">
    <div title="" class="handlediv">
      <br>
    </div>
    <h3 class="hndle"><span><?php _e("Label Settings", "tdp-fav-listings") ?></span></h3>
    <div class="inside" style="display: block;">


        <table class="form-table">
            <tr>
                <th><?php _e("Text for add link", "tdp-fav-listings") ?></th><td><input type="text" name="add_favorite" value="<?php echo stripslashes($tdp_fav_options['add_favorite']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for added", "tdp-fav-listings") ?></th><td><input type="checkbox"  <?php if ($tdp_fav_options['added'] == 'show remove link') echo "checked='checked'"; ?> name="show_remove_link" onclick="jQuery('#added').val(''); jQuery('#added').toggle();" value="show_remove_link" id="show_remove_link" /> <label for="show_remove_link">Show remove link</label>
				<br /><input id="added" type="text" name="added" <?php if ($tdp_fav_options['added'] == 'show remove link') echo "style='display:none;'"; ?> value="<?php echo stripslashes($tdp_fav_options['added']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for remove link", "tdp-fav-listings") ?></th><td><input type="text" name="remove_favorite" value="<?php echo stripslashes($tdp_fav_options['remove_favorite']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for removed", "tdp-fav-listings") ?></th>
				<td><input type="checkbox" <?php if ($tdp_fav_options['removed'] == 'show add link') echo "checked='checked'"; ?> name="show_add_link" id="show_add_link" onclick="jQuery('#removed').val(''); jQuery('#removed').toggle();" value='show_add_link' /> <label for="show_add_link">Show add link</label>
				<br />
				<input id="removed" type="text" name="removed" <?php if ($tdp_fav_options['removed'] == 'show add link') echo "style='display:none;'"; ?> value="<?php echo stripslashes($tdp_fav_options['removed']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for clear link", "tdp-fav-listings") ?></th><td><input type="text" name="clear" value="<?php echo stripslashes($tdp_fav_options['clear']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for cleared", "tdp-fav-listings") ?></th><td><input type="text" name="cleared" value="<?php echo stripslashes($tdp_fav_options['cleared']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for favorites are empty", "tdp-fav-listings") ?></th><td><input type="text" name="favorites_empty" value="<?php echo stripslashes($tdp_fav_options['favorites_empty']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for [remove] link", "tdp-fav-listings") ?></th><td><input type="text" name="rem" value="<?php echo stripslashes($tdp_fav_options['rem']); ?>" /></td>
            </tr>
            <tr>
                <th><?php _e("Text for favorites saved to cookies", "tdp-fav-listings") ?></th><td><textarea name="cookie_warning" rows="3" cols="35"><?php echo stripslashes($tdp_fav_options['cookie_warning']); ?></textarea></td>
            </tr>
            <tr>
                <th><?php _e("Text for \"only registered users can favorite\" error message", "tdp-fav-listings") ?></th><td><textarea name="text_only_registered" rows="2" cols="35"><?php echo stripslashes($tdp_fav_options['text_only_registered']); ?></textarea></td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit" class="button" value="<?php _e('Update options &raquo;'); ?>" />
                </td>
            </tr>

        </table>
    </div>
</div>
<div class="postbox">
    <div title="<?php _e("Click to open/close", "tdp-fav-listings"); ?>" class="handlediv">
      <br>
    </div>
    <h3 class="hndle"><span><?php _e('Advanced Settings', 'tdp-fav-listings'); ?></span></h3>
    <div class="inside" style="display: block;">
        <table class="form-table">
            <tr>
                <td><input type="checkbox" value="1" <?php if ($tdp_fav_options['dont_load_js_file'] == '1') echo "checked='checked'"; ?> name="dont_load_js_file" id="dont_load_js_file" /> <label for="dont_load_js_file">Don't load js file</label></td>
            </tr>
            <tr>
                <td><input type="checkbox" value="1" <?php if ($tdp_fav_options['dont_load_css_file'] == '1') echo "checked='checked'"; ?> name="dont_load_css_file" id="dont_load_css_file" /> <label for="dont_load_css_file">Don't load css file</label></td>
            </tr>			
            <tr>
                <td>
                    <input type="submit" name="submit" class="button" value="<?php _e('Update options &raquo;'); ?>" />
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="postbox">
    <div title="<?php _e("Click to open/close", "tdp-fav-listings"); ?>" class="handlediv">
      <br>
    </div>
    <h3 class="hndle"><span><?php _e('Help', 'tdp-fav-listings'); ?></span></h3>
    <div class="inside" style="display: block;">
        If you need help about WP Favorite Posts plugin you can go <a href="http://wordpress.org/tags/tdp-fav-listings" target="_blank">plugin's wordpress support page</a>. I or someone else will help you.
    </div>
</div>
</form>
</div>
</div>
