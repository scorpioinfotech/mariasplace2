<?php
// look up for the path
require_once('../config.php');
// check for rights
if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') )
	wp_die(__("You are not allowed to be here"));
	
    global $wpdb;
	$galleries = $iLightBox->ilightbox_get_option('ilightbox_added_galleries');
	krsort($galleries);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>iLightBox Shortcode Panel</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $iLightBox->ILIGHTBOX_URL ?>/scripts/tinymce.js"></script>
	<base target="_self" />
<style type="text/css">
<!-- 
select#ilshortcode_tag optgroup { font:bold 11px Tahoma, Verdana, Arial, Sans-serif;}
select#ilshortcode_tag optgroup option { font:normal 11px/18px Tahoma, Verdana, Arial, Sans-serif; padding-top:1px; padding-bottom:1px;}
-->
.tabs ul li {
	cursor: pointer;
}
</style>
</head>
<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';
document.getElementById('ilshortcode_tag').focus();" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="il_tabs" action="#">
	<div class="tabs">
		<ul>
	<li id="il_tab" class="current" onclick="mcTabs.displayTab('il_tab','ilshortcode_panel');"><span>Insert a Gallery</span></li>
	<li id="il_tab2" onclick="mcTabs.displayTab('il_tab2','ilshortcode_binds');"><span>Bind a Gallery</span></li>

		</ul>
	</div>
	
	<div class="panel_wrapper">
		<!-- gallery panel -->
		<div id="ilshortcode_panel" class="panel current">
		<br />
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="ilshortcode_tag">Select a Gallery</label></td>
            <td>
				<select id="ilshortcode_tag" name="ilshortcode_tag" style="width: 200px">
<?php
	foreach($galleries as $key => $data){
?>
					<option value="<?php echo $key; ?>"><?php echo (@$data['gallery_name']) ? $data['gallery_name'] : '(no name)'; ?></option>
<?php
	}
?>
				</select>
			</td>
          </tr>
         
        </table>
		</div>
		
		<!-- binds panel -->
		<div id="ilshortcode_binds" class="panel">
		<br />
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="ilshortcode_tag">Select a Gallery</label></td>
            <td>
				<select id="ilshortcode_tag2" name="ilshortcode_tag2" style="width: 200px">
<?php
	foreach($galleries as $key => $data){
?>
					<option value="<?php echo $key; ?>"><?php echo (@$data['gallery_name']) ? $data['gallery_name'] : '(no name)'; ?></option>
<?php
	}
?>
				</select>
			</td>
          </tr>
         
        </table>
		</div>
		
	</div>
		
	
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onClick="ilshortcodesubmit();" />
		</div>
	</div>
</form>
</body>
</html>
