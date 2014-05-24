<?php
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$galleries = $this->ilightbox_get_option('ilightbox_added_galleries');
			$gallery = $galleries[$id];
		} else $gallery = array();
?>
<div class="wrap" id="ilightbox_admin_wrap">
	<div class="ilightbox_admin_content clearfix">
	<?php require_once('ilightbox_menu.php');?>
			<form class="ajaxform<?php if(empty($gallery)) { ?> createGallery<?php } ?>">
<?php
if(!empty($gallery)) {
?>
				<div class="ilightbox_topbar clearfix">
					<a class="il-button lightblue-button" role="submit"><span>Save Changes</span></a>
					<a class="il-button darkred-button border" id="preview_gallery"><span>Preview</span></a>
					<a class="il-button green-button border" id="multiple_upload"><span>Multiple File Upload</span></a>
					<a class="il-button white-button" id="add_slide"><span>Add a slide</span></a>
					<h3>Edit gallery</h3>
				</div>
				<input type="hidden" name="_action" value="editGallery" />
				<input type="hidden" name="gid" value="<?php echo $id; ?>" />
<?php
} else {
?>
				<div class="ilightbox_topbar clearfix">
					<a class="il-button lightblue-button" role="submit"><span>Create Gallery</span></a>
					<a class="il-button darkred-button border" id="preview_gallery"><span>Preview</span></a>
					<a class="il-button green-button border" id="multiple_upload"><span>Multiple File Upload</span></a>
					<a class="il-button white-button" id="add_slide"><span>Add a slide</span></a>
					<h3>Create new gallery</h3>
				</div>
				<input type="hidden" name="_action" value="createGallery" />
				<input type="hidden" name="gid" value="-1" />
<?php
}
?>
				<div class="ilightbox_file_uploader">
					<div id="ilightbox_uploader"></div>
					<div id="ilightbox_file_uploader_content">
						<h2>Drag your files to here</h2>
						or<br>
						<a class="il-button white-button" id="select-files"><span>Select Files</span></a>
					</div>
					
					<div class="upload_loader">
						<div></div>
					</div>
				</div>

				<div class="row margintop clearfix">
					<ul class="item_listing">
						<li class="col span_1">
							<input type="text" name="gallery_name" size="30" value="<?php echo @$gallery['gallery_name']; ?>" placeholder="Enter gallery name here" title="Enter gallery name here" id="gallery_name" autocomplete="off">

							<div class="section clearfix">
								<label class="label" for="useConfiguration">Use Configuration Options</label>

								<div class="onoffswitch">
									<input type="checkbox" name="useConfiguration" class="onoffswitch-checkbox" id="useConfiguration"<?php if(@$gallery['useConfiguration']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="useConfiguration">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Use options from configurations page as default options for this gallery.</small>
							</div>

							<div class="section clearfix">
								<h3 class="title">General Options</h3>
								<label class="label" for="global_option_path">Path</label>
								
								<select name="path" id="global_option_path">
									<option value="">Vertical</option>
									<option value="horizontal"<?php if(@$gallery['path'] == 'horizontal') { echo " selected"; } ?>>Horizontal</option>
								</select>
								<div class="clear"></div>
								<small>Sets the path for switching windows, the default is '<code>vertical</code>'.</small>
								<hr>
								
								<label class="label" for="global_option_skin">Skin</label>
								
								<input type="text" name="skin" id="global_option_skin" class="small" value="<?php echo @$gallery['skin']; ?>" />
								<div class="clear"></div>
								<small>Sets the skin, the default is '<code>dark</code>'. Available skins are: <code>dark</code>, <code>light</code>, <code>parade</code>, <code>smooth</code>, <code>metro-black</code>, <code>metro-white</code> and <code>mac</code>.</small>
								<hr>
								
								<label class="label" for="global_option_linkId">Link ID</label>
								
								<input type="text" name="linkId" id="global_option_linkId" class="small" value="<?php echo @$gallery['linkId']; ?>" />
								<div class="clear"></div>
								<small>Sets the deeplinking id. This feature only works when you directly inserted the gallery.</small>
								<hr>
								
								<label class="label" for="global_option_startFrom">Start From</label>
								<div class="ilightbox_ui_slider">
									<input type="text" name="startFrom" id="global_option_startFrom" class="small" value="<?php echo @$gallery['startFrom']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>The position to open within the elements, defaults to <code>0</code>.</small>
								<hr>
								
								<label class="label" for="global_option_infinite">Infinite</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="infinite" class="onoffswitch-checkbox" id="global_option_infinite"<?php if(@$gallery['infinite']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_infinite">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the ability to infinite the group, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="global_option_randomStart">Random Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="randomStart" class="onoffswitch-checkbox" id="global_option_randomStart"<?php if(@$gallery['randomStart']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_randomStart">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>The random position to open within the elements, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="global_option_keepAspectRatio">Keep Aspect Ratio</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="keepAspectRatio" class="onoffswitch-checkbox" id="global_option_keepAspectRatio"<?php if(!@empty($gallery)) { if($gallery['keepAspectRatio']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_keepAspectRatio">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the resizing method used to keep aspect ratio within the viewport, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_mobileOptimizer">Mobile Optimizer</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="mobileOptimizer" class="onoffswitch-checkbox" id="global_option_mobileOptimizer"<?php if(!@empty($gallery)) { if(@$gallery['mobileOptimizer']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_mobileOptimizer">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Make lightboxes optimized for giving better experience with mobile devices, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_maxScale">Max Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="maxScale" id="global_option_maxScale" class="small" value="<?php echo @$gallery['maxScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the maximum viewport scale of the content, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="global_option_minScale">Min Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="minScale" id="global_option_minScale" class="small" value="<?php echo @$gallery['minScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the minimum viewport scale of the content, the default is <code>0.2</code>.</small>
								<hr>
								
								<label class="label" for="global_option_innerToolbar">Inner Toolbar</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="innerToolbar" class="onoffswitch-checkbox" id="global_option_innerToolbar"<?php if(@$gallery['innerToolbar']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_innerToolbar">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Bring buttons into windows, or let them be over the overlay with set to <code>ON</code>, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="global_option_smartRecognition">Smart Recognition</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="smartRecognition" class="onoffswitch-checkbox" id="global_option_smartRecognition"<?php if(@$gallery['smartRecognition']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_smartRecognition">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets content auto recognize from web pages, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="global_option_fullViewPort">Fullscreen One Slide</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="fullAlone" class="onoffswitch-checkbox" id="global_option_fullAlone"<?php if(!@empty($gallery)) { if(@$gallery['fullAlone']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_fullAlone">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Decide to fullscreen only one slide or hole gallery the fullscreen mode.</small>
								<hr>
								
								<label class="label" for="global_option_fullViewPort">Fullscreen Viewport</label>
								
								<select name="fullViewPort" id="global_option_fullViewPort">
									<option value="">Center</option>
									<option value="fit"<?php if(@$gallery['fullViewPort'] == 'fit') { echo " selected"; } ?>>Fit</option>
									<option value="fill"<?php if(@$gallery['fullViewPort'] == 'fill') { echo " selected"; } ?>>Fill</option>
									<option value="stretch"<?php if(@$gallery['fullViewPort'] == 'stretch') { echo " selected"; } ?>>Stretch</option>
								</select>
								<div class="clear"></div>
								<small>Sets the resizing method used to fit content within the fullscreen mode.</small>
								<hr>
								
								<label class="label" for="global_option_fullStretchTypes">Fullscreen Stretch Types</label>
								
								<input type="text" name="fullStretchTypes" id="global_option_fullStretchTypes" class="medium" value="<?php echo @$gallery['fullStretchTypes']; ?>" />
								<div class="clear"></div>
								<small>Sets the stretch resizing used to fit content within the fullscreen mode for specific content types. Possible values are: <code>image</code>, <code>video</code>, <code>flash</code>, <code>iframe</code>, <code>inline</code>, <code>ajax</code> and <code>html</code>. The default is '<code>flash, video</code>'.</small>
								<hr>
								
								<label class="label" for="global_option_showTitle">Show Title</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="show_title" class="onoffswitch-checkbox" id="global_option_showTitle"<?php if(!@empty($gallery)) { if($gallery['show_title']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_showTitle">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the titles of all slides will be visible or not, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_mobileOptimize">Mobile Optimization</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="mobileOptimize" class="onoffswitch-checkbox" id="global_option_mobileOptimize"<?php if(@$gallery['mobileOptimize']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_mobileOptimize">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By turning on this option your custom optimizations for mobile devices will be apply, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="global_option_tabletOptimize">Tablet Optimization</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="tabletOptimize" class="onoffswitch-checkbox" id="global_option_tabletOptimize"<?php if(@$gallery['tabletOptimize']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_tabletOptimize">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By turning on this option your custom optimizations for tablet devices will be apply, the default is <code>OFF</code>.</small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Commands</h3>
								<label class="label" for="ilightbox_overlayBlur">Overlay Blur</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="overlayBlur" class="onoffswitch-checkbox" id="ilightbox_overlayBlur"<?php if(!@empty($gallery)) { if($gallery['overlayBlur']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_overlayBlur">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not clicking on the dimmed background of the page hides the iLightBox and removes the dim, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_toolbar">Toolbar</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="toolbar" class="onoffswitch-checkbox" id="ilightbox_toolbar"<?php if(!@empty($gallery)) { if($gallery['toolbar']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_toolbar">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets buttons be available or not, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_fullscreen">Fullscreen</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="fullscreen" class="onoffswitch-checkbox" id="ilightbox_fullscreen"<?php if(!@empty($gallery)) { if($gallery['fullscreen']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_fullscreen">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the fullscreen button, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_arrows">Arrow Buttons</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="arrows" class="onoffswitch-checkbox" id="ilightbox_arrows"<?php if(@$gallery['arrows']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_arrows">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Enable the arrow buttons, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_thumbnail">Thumbnails</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="thumbnail" class="onoffswitch-checkbox" id="ilightbox_thumbnail"<?php if(!@empty($gallery)) { if(@$gallery['thumbnail']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_thumbnail">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the thumbnail navigation, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_keyboard">Keyboard</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="keyboard" class="onoffswitch-checkbox" id="ilightbox_keyboard"<?php if(!@empty($gallery)) { if($gallery['keyboard']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_keyboard">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the keyboard navigation, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_mousewheel">Mouse Wheel</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="mousewheel" class="onoffswitch-checkbox" id="ilightbox_mousewheel"<?php if(!@empty($gallery)) { if($gallery['mousewheel']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_mousewheel">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the mousewheel navigation, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_swipe">Swipe</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="swipe" class="onoffswitch-checkbox" id="ilightbox_swipe"<?php if(!@empty($gallery)) { if($gallery['swipe']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_swipe">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the swipe navigation, the default is <code>ON</code>.</small>
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Keyboard</h3>
								<label class="label" for="left">Left Key</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="left" class="onoffswitch-checkbox" id="left"<?php if(!@empty($gallery)) { if($gallery['left']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="left">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the <code>Left</code> key for keyboard navigation to moving to previous window, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="right">Right Key</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="right" class="onoffswitch-checkbox" id="right"<?php if(!@empty($gallery)) { if($gallery['right']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="right">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the <code>Right</code> key for keyboard navigation to moving to next window, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="up">Up Key</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="up" class="onoffswitch-checkbox" id="up"<?php if(!@empty($gallery)) { if($gallery['up']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="up">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the <code>Up</code> key for keyboard navigation to moving to previous window, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="down">Down Key</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="down" class="onoffswitch-checkbox" id="down"<?php if(!@empty($gallery)) { if($gallery['down']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="down">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the <code>Down</code> key for keyboard navigation to moving to next window, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="esc">Esc Key</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="esc" class="onoffswitch-checkbox" id="esc"<?php if(!@empty($gallery)) { if($gallery['esc']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="esc">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the <code>Escape</code> key for keyboard navigation to close iLightBox, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="shift_enter">Shift+Enter Key</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="shift_enter" class="onoffswitch-checkbox" id="shift_enter"<?php if(!@empty($gallery)) { if($gallery['shift_enter']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="shift_enter">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the <code>Shift+Enter</code> key for keyboard navigation to enter fullscreen, the default is <code>ON</code>.</small>
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Styles</h3>
								<label class="label" for="overlayOpacity">Overlay Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="overlayOpacity" id="overlayOpacity" class="small" value="<?php echo @$gallery['overlayOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the opacity of the dimmed background of the page, the default is <code>0.85</code>.</small>
								<hr>
								
								<label class="label" for="pageOffsetX">Page Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="pageOffsetX" id="pageOffsetX" class="small" value="<?php echo @$gallery['pageOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines page X offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="pageOffsetY">Page Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="pageOffsetY" id="pageOffsetY" class="small" value="<?php echo @$gallery['pageOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines page Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetX">Next Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="nextOffsetX" id="nextOffsetX" class="small" value="<?php echo @$gallery['nextOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetY">Next Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="nextOffsetY" id="nextOffsetY" class="small" value="<?php echo @$gallery['nextOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="nextOpacity">Next Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="nextOpacity" id="nextOpacity" class="small" value="<?php echo @$gallery['nextOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window opacity, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="nextScale">Next Scale</label>
								
								<div class="ilightbox_ui_slider" data-max="10" data-min="0" data-step="0.01">
									<input type="text" name="nextScale" id="nextScale" class="small" value="<?php echo @$gallery['nextScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window scale, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetX">Previous Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="prevOffsetX" id="prevOffsetX" class="small" value="<?php echo @$gallery['prevOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetY">Previous Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="prevOffsetY" id="prevOffsetY" class="small" value="<?php echo @$gallery['prevOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="prevOpacity">Previous Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="prevOpacity" id="prevOpacity" class="small" value="<?php echo @$gallery['prevOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window opacity, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="prevScale">Previous Scale</label>
								
								<div class="ilightbox_ui_slider" data-max="10" data-min="0" data-step="0.01">
									<input type="text" name="prevScale" id="prevScale" class="small" value="<?php echo @$gallery['prevScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window scale, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_maxWidth">Thumbnails Max Width</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="thumbnails_maxWidth" id="thumbnails_maxWidth" class="small" value="<?php echo @$gallery['thumbnails_maxWidth']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum width of the thumbnails, the default is <code>120</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_maxHeight">Thumbnails Max Height</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="thumbnails_maxHeight" id="thumbnails_maxHeight" class="small" value="<?php echo @$gallery['thumbnails_maxHeight']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum height of the thumbnails, the default is <code>80</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_normalOpacity">Thumbnails Normal Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="thumbnails_normalOpacity" id="thumbnails_normalOpacity" class="small" value="<?php echo @$gallery['thumbnails_normalOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the opacity of the thumbnails, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_activeOpacity">Active Thumbnail Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="thumbnails_activeOpacity" id="thumbnails_activeOpacity" class="small" value="<?php echo @$gallery['thumbnails_activeOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the opacity of the active window thumbnail, the default is <code>0.6</code>.</small>
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Effects</h3>
								<label class="label" for="show_effect">Show Effect</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="show_effect" class="onoffswitch-checkbox" id="show_effect"<?php if(!@empty($gallery)) { if($gallery['show_effect']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="show_effect">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not showing contents with effect, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="hide_effect">Hide Effect</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="hide_effect" class="onoffswitch-checkbox" id="hide_effect"<?php if(!@empty($gallery)) { if($gallery['hide_effect']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="hide_effect">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not hiding contents with effect, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="reposition">Reposition</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="reposition" class="onoffswitch-checkbox" id="reposition"<?php if(!@empty($gallery)) { if($gallery['reposition']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="reposition">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not browser resize with effect, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="show_speed">Show Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="show_speed" id="show_speed" class="small" value="<?php echo @$gallery['show_speed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the speed of the effect when showing contents, the default is <code>300</code>.</small>
								<hr>
								
								<label class="label" for="hide_speed">Hide Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="hide_speed" id="hide_speed" class="small" value="<?php echo @$gallery['hide_speed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the speed of the effect when hiding contents, the default is <code>300</code>.</small>
								<hr>
								
								<label class="label" for="repositionSpeed">Reposition Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="repositionSpeed" id="repositionSpeed" class="small" value="<?php echo @$gallery['repositionSpeed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the reposition effect speed, the default is <code>200</code>.</small>
								<hr>
								
								<label class="label" for="switchSpeed">Switch Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="switchSpeed" id="switchSpeed" class="small" value="<?php echo @$gallery['switchSpeed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the speed for switching effect between windows, the default is <code>500</code>.</small>
								<hr>
								
								<label class="label" for="loadedFadeSpeed">Loaded Fade Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="loadedFadeSpeed" id="loadedFadeSpeed" class="small" value="<?php echo @$gallery['loadedFadeSpeed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the fade effect speed for loaded contents, the default is <code>180</code>.</small>
								<hr>
								
								<label class="label" for="fadeSpeed">Fade Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="fadeSpeed" id="fadeSpeed" class="small" value="<?php echo @$gallery['fadeSpeed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the fade effect speed, the default is <code>200</code>.</small>
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Captions</h3>
								
								<label class="label" for="captionStart">Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="captionStart" class="onoffswitch-checkbox" id="captionStart"<?php if(!@empty($gallery)) { if(@$gallery['captionStart']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="captionStart">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not display captions on window preview, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_captionShow">Show Event</label>
								
								<select name="captionShow" id="global_option_captionShow">
									<option value="mouseenter"<?php if(@$gallery['captionShow'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="mouseleave"<?php if(@$gallery['captionShow'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="click"<?php if(@$gallery['captionShow'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$gallery['captionShow'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing caption, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_captionHide">Hide Event</label>
								
								<select name="captionHide" id="global_option_captionHide">
									<option value="mouseleave"<?php if(@$gallery['captionHide'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="mouseenter"<?php if(@$gallery['captionHide'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="click"<?php if(@$gallery['captionHide'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$gallery['captionHide'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding caption, the default is 'mouseleave'.</small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Socials</h3>
								
								<label class="label" for="socialStart">Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="socialStart" class="onoffswitch-checkbox" id="socialStart"<?php if(!@empty($gallery)) { if(@$gallery['socialStart']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="socialStart">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not display social buttons on window preview, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_socialShow">Show Event</label>
								
								<select name="socialShow" id="global_option_socialShow">
									<option value="mouseenter"<?php if(@$gallery['socialShow'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="mouseleave"<?php if(@$gallery['socialShow'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="click"<?php if(@$gallery['socialShow'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$gallery['socialShow'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing social buttons, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_socialHide">Hide Event</label>
								
								<select name="socialHide" id="global_option_socialHide">
									<option value="mouseleave"<?php if(@$gallery['socialHide'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="mouseenter"<?php if(@$gallery['socialHide'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="click"<?php if(@$gallery['socialHide'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$gallery['socialHide'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding social buttons, the default is 'mouseleave'.</small>
								<hr>
								
								<label class="label" for="global_option_socialButtons">Buttons</label>
								
								<textarea class="javascript medium" name="socialButtons"><?php echo htmlentities(stripslashes(@$gallery['socialButtons']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<div class="clear"></div>
								<small>Sets the social buttons. For get more information about this field refer: <a href="http://ilightbox.net/documentation.html#global_options_social" target="_blank">http://ilightbox.net/documentation.html#global_options_social</a></small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Slideshow</h3>
								
								<label class="label" for="slideshow">Enable</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="slideshow" class="onoffswitch-checkbox" id="slideshow"<?php if(@$gallery['slideshow']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="slideshow">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Enable the slideshow feature and button, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="pauseTime">Pause Time</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="pauseTime" id="pauseTime" class="small" value="<?php echo @$gallery['pauseTime']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Delay between cycles in milliseconds, the default is <code>5000</code>.</small>
								<hr>
								
								<label class="label" for="pauseOnHover">Pause On Hover</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="pauseOnHover" class="onoffswitch-checkbox" id="pauseOnHover"<?php if(@$gallery['pauseOnHover']) { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="pauseOnHover">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Whether to pause the cycling while the mouse is hovering over the lightboxes, the default is <code>OFF</code>.</small>
								<hr>
								
								<label class="label" for="startPaused">Start Paused</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="startPaused" class="onoffswitch-checkbox" id="startPaused"<?php if(!@empty($gallery)) { if(@$gallery['startPaused']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="startPaused">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>When slideshow is enabled, this will start the iLightBox in paused mode, the default is <code>ON</code>.</small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Callbacks</h3>
								
								<label class="label" for="onAfterChange">onAfterChange</label>
								<small>A function to call when the window changes.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onAfterChange"><?php echo htmlentities(stripslashes(@$gallery['onAfterChange']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onAfterLoad">onAfterLoad</label>
								<small>A function to call when the content loads.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onAfterLoad"><?php echo htmlentities(stripslashes(@$gallery['onAfterLoad']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onBeforeChange">onBeforeChange</label>
								<small>A function to call before the window changes.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onBeforeChange"><?php echo htmlentities(stripslashes(@$gallery['onBeforeChange']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onBeforeLoad">onBeforeLoad</label>
								<small>A function to call before the content loads.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onBeforeLoad"><?php echo htmlentities(stripslashes(@$gallery['onBeforeLoad']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onEnterFullScreen">onEnterFullScreen</label>
								<small>A function to call when the iLightBox enter to Fullscreen.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onEnterFullScreen"><?php echo htmlentities(stripslashes(@$gallery['onEnterFullScreen']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onExitFullScreen">onExitFullScreen</label>
								<small>A function to call when the iLightBox exit from Fullscreen.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onExitFullScreen"><?php echo htmlentities(stripslashes(@$gallery['onExitFullScreen']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onHide">onHide</label>
								<small>A function to call when the window hides.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onHide"><?php echo htmlentities(stripslashes(@$gallery['onHide']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onOpen">onOpen</label>
								<small>A function to call when the iLightBox opens.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onOpen"><?php echo htmlentities(stripslashes(@$gallery['onOpen']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onRender">onRender</label>
								<small>A function to call when the content renders.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onRender"><?php echo htmlentities(stripslashes(@$gallery['onRender']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onShow">onShow</label>
								<small>A function to call when the window comes into view.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="onShow"><?php echo htmlentities(stripslashes(@$gallery['onShow']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Labels</h3>
								<input type="text" class="full" name="close" value="<?php if(@$gallery['close']) { echo htmlentities(stripslashes($gallery['close']), ENT_QUOTES, 'UTF-8'); } else { ?>Close<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Close</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="enterFullscreen" value="<?php if(@$gallery['enterFullscreen']) { echo htmlentities(stripslashes($gallery['enterFullscreen']), ENT_QUOTES, 'UTF-8'); } else { ?>Enter Fullscreen (Shift+Enter)<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Enter Fullscreen (Shift+Enter)</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="exitFullscreen" value="<?php if(@$gallery['exitFullscreen']) { echo htmlentities(stripslashes($gallery['exitFullscreen']), ENT_QUOTES, 'UTF-8'); } else { ?>Exit Fullscreen (Shift+Enter)<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Exit Fullscreen (Shift+Enter)</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="slideShowLabel" value="<?php if(@$gallery['slideShowLabel']) { echo htmlentities(stripslashes(@$gallery['slideShowLabel']), ENT_QUOTES, 'UTF-8'); } else { ?>Slideshow<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Slideshow</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="nextLabel" value="<?php if(@$gallery['nextLabel']) { echo htmlentities(stripslashes(@$gallery['nextLabel']), ENT_QUOTES, 'UTF-8'); } else { ?>Next<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Next</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="previousLabel" value="<?php if(@$gallery['previousLabel']) { echo htmlentities(stripslashes(@$gallery['previousLabel']), ENT_QUOTES, 'UTF-8'); } else { ?>Previous<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Previous</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="loadImage" value="<?php if(@$gallery['loadImage']) { echo htmlentities(stripslashes(@$gallery['loadImage']), ENT_QUOTES, 'UTF-8'); } else { ?>An error occurred when trying to load photo.<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>An error occurred when trying to load photo.</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="loadContents" value="<?php if(@$gallery['loadContents']) { echo htmlentities(stripslashes(@$gallery['loadContents']), ENT_QUOTES, 'UTF-8'); } else { ?>An error occurred when trying to load contents.<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>An error occurred when trying to load contents.</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="missingPlugin" value="<?php if(@$gallery['missingPlugin']) { echo htmlentities(stripslashes(@$gallery['missingPlugin']), ENT_QUOTES, 'UTF-8'); } else { ?>The content your are attempting to view requires the <a href='{pluginspage}' target='_blank'>{type} plugin</a>.<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>The content your are attempting to view requires the &lt;a href='{pluginspage}' target='_blank'&gt;{type} plugin&lt;/a&gt;.</code>'.</small>
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Mobile Optimizations</h3>
								
								<label class="label" for="global_option_maxScale_mobileOpts">Max Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="mobileOpts[maxScale]" id="global_option_maxScale_mobileOpts" class="small" value="<?php echo @$gallery['mobileOpts']['maxScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the maximum viewport scale of the content, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="global_option_minScale_mobileOpts">Min Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="mobileOpts[minScale]" id="global_option_minScale_mobileOpts" class="small" value="<?php echo @$gallery['mobileOpts']['minScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the minimum viewport scale of the content, the default is <code>0.2</code>.</small>
								<hr>
								
								<label class="label" for="global_option_showTitle_mobileOpts">Show Title</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="mobileOpts[show_title]" class="onoffswitch-checkbox" id="global_option_showTitle_mobileOpts"<?php if(!@empty($gallery)) { if(@$gallery['mobileOpts']['show_title']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_showTitle_mobileOpts">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the titles of all slides will be visible or not, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_mobileOpts_thumbnail">Thumbnails</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="mobileOpts[thumbnail]" class="onoffswitch-checkbox" id="ilightbox_mobileOpts_thumbnail"<?php if(!@empty($gallery)) { if(@$gallery['mobileOpts']['thumbnail']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_mobileOpts_thumbnail">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the thumbnail navigation, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_mobileOpts_maxWidth">Thumbnails Max Width</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="mobileOpts[thumbnails_maxWidth]" id="thumbnails_mobileOpts_maxWidth" class="small" value="<?php echo @$gallery['mobileOpts']['thumbnails_maxWidth']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum width of the thumbnails, the default is <code>120</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_mobileOpts_maxHeight">Thumbnails Max Height</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="mobileOpts[thumbnails_maxHeight]" id="thumbnails_mobileOpts_maxHeight" class="small" value="<?php echo @$gallery['mobileOpts']['thumbnails_maxHeight']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum height of the thumbnails, the default is <code>80</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetX_mobileOpts">Next Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="mobileOpts[nextOffsetX]" id="nextOffsetX_mobileOpts" class="small" value="<?php echo @$gallery['mobileOpts']['nextOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetY_mobileOpts">Next Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="mobileOpts[nextOffsetY]" id="nextOffsetY_mobileOpts" class="small" value="<?php echo @$gallery['mobileOpts']['nextOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetX_mobileOpts">Previous Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="mobileOpts[prevOffsetX]" id="prevOffsetX_mobileOpts" class="small" value="<?php echo @$gallery['mobileOpts']['prevOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetY_mobileOpts">Previous Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="mobileOpts[prevOffsetY]" id="prevOffsetY_mobileOpts" class="small" value="<?php echo @$gallery['mobileOpts']['prevOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="captionStart_mobileOpts">Caption Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="mobileOpts[captionStart]" class="onoffswitch-checkbox" id="captionStart_mobileOpts"<?php if(!@empty($gallery)) { if(@$gallery['mobileOpts']['captionStart']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="captionStart_mobileOpts">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not display captions on window preview, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_captionShow_mobileOpts">Caption Show Event</label>
								
								<select name="mobileOpts[captionShow]" id="global_option_captionShow_mobileOpts">
									<option value="touchstart"<?php if(@$gallery['mobileOpts']['captionShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['mobileOpts']['captionShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['mobileOpts']['captionShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing caption, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_captionHide_mobileOpts">Caption Hide Event</label>
								
								<select name="mobileOpts[captionHide]" id="global_option_captionHide_mobileOpts">
									<option value="touchstart"<?php if(@$gallery['mobileOpts']['captionHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['mobileOpts']['captionHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['mobileOpts']['captionHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding caption, the default is 'mouseleave'.</small>
								<hr>
								
								<label class="label" for="socialStart_mobileOpts">Social Buttons Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="mobileOpts[socialStart]" class="onoffswitch-checkbox" id="socialStart_mobileOpts"<?php if(!@empty($gallery)) { if(@$gallery['mobileOpts']['socialStart']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="socialStart_mobileOpts">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not display social buttons on window preview, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_socialShow_mobileOpts">Social Buttons Show Event</label>
								
								<select name="mobileOpts[socialShow]" id="global_option_socialShow_mobileOpts">
									<option value="touchstart"<?php if(@$gallery['mobileOpts']['socialShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['mobileOpts']['socialShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['mobileOpts']['socialShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing social buttons, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_socialHide_mobileOpts">Social Buttons Hide Event</label>
								
								<select name="mobileOpts[socialHide]" id="global_option_socialHide_mobileOpts">
									<option value="touchstart"<?php if(@$gallery['mobileOpts']['socialHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['mobileOpts']['socialHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['mobileOpts']['socialHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding social buttons, the default is 'mouseleave'.</small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Tablet Optimizations</h3>
								
								<label class="label" for="global_option_maxScale_tabletOpts">Max Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="tabletOpts[maxScale]" id="global_option_maxScale_tabletOpts" class="small" value="<?php echo @$gallery['tabletOpts']['maxScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the maximum viewport scale of the content, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="global_option_minScale_tabletOpts">Min Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="tabletOpts[minScale]" id="global_option_minScale_tabletOpts" class="small" value="<?php echo @$gallery['tabletOpts']['minScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the minimum viewport scale of the content, the default is <code>0.2</code>.</small>
								<hr>
								
								<label class="label" for="global_option_showTitle_tabletOpts">Show Title</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="tabletOpts[show_title]" class="onoffswitch-checkbox" id="global_option_showTitle_tabletOpts"<?php if(!@empty($gallery)) { if(@$gallery['tabletOpts']['show_title']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="global_option_showTitle_tabletOpts">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the titles of all slides will be visible or not, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="ilightbox_tabletOpts_thumbnail">Thumbnails</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="tabletOpts[thumbnail]" class="onoffswitch-checkbox" id="ilightbox_tabletOpts_thumbnail"<?php if(!@empty($gallery)) { if(@$gallery['tabletOpts']['thumbnail']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="ilightbox_tabletOpts_thumbnail">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Sets the thumbnail navigation, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_tabletOpts_maxWidth">Thumbnails Max Width</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="tabletOpts[thumbnails_maxWidth]" id="thumbnails_tabletOpts_maxWidth" class="small" value="<?php echo @$gallery['tabletOpts']['thumbnails_maxWidth']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum width of the thumbnails, the default is <code>120</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_tabletOpts_maxHeight">Thumbnails Max Height</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="tabletOpts[thumbnails_maxHeight]" id="thumbnails_tabletOpts_maxHeight" class="small" value="<?php echo @$gallery['tabletOpts']['thumbnails_maxHeight']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum height of the thumbnails, the default is <code>80</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetX_tabletOpts">Next Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="tabletOpts[nextOffsetX]" id="nextOffsetX_tabletOpts" class="small" value="<?php echo @$gallery['tabletOpts']['nextOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetY_tabletOpts">Next Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="tabletOpts[nextOffsetY]" id="nextOffsetY_tabletOpts" class="small" value="<?php echo @$gallery['tabletOpts']['nextOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetX_tabletOpts">Previous Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="tabletOpts[prevOffsetX]" id="prevOffsetX_tabletOpts" class="small" value="<?php echo @$gallery['tabletOpts']['prevOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetY_tabletOpts">Previous Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="tabletOpts[prevOffsetY]" id="prevOffsetY_tabletOpts" class="small" value="<?php echo @$gallery['tabletOpts']['prevOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="captionStart_tabletOpts">Caption Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="tabletOpts[captionStart]" class="onoffswitch-checkbox" id="captionStart_tabletOpts"<?php if(!@empty($gallery)) { if(@$gallery['tabletOpts']['captionStart']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="captionStart_tabletOpts">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not display captions on window preview, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_captionShow_tabletOpts">Caption Show Event</label>
								
								<select name="tabletOpts[captionShow]" id="global_option_captionShow_tabletOpts">
									<option value="touchstart"<?php if(@$gallery['tabletOpts']['captionShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['tabletOpts']['captionShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['tabletOpts']['captionShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing caption, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_captionHide_tabletOpts">Caption Hide Event</label>
								
								<select name="tabletOpts[captionHide]" id="global_option_captionHide_tabletOpts">
									<option value="touchstart"<?php if(@$gallery['tabletOpts']['captionHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['tabletOpts']['captionHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['tabletOpts']['captionHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding caption, the default is 'mouseleave'.</small>
								<hr>
								
								<label class="label" for="socialStart_tabletOpts">Social Buttons Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="tabletOpts[socialStart]" class="onoffswitch-checkbox" id="socialStart_tabletOpts"<?php if(!@empty($gallery)) { if(@$gallery['tabletOpts']['socialStart']) { echo " checked"; } } else { echo " checked"; } ?> />
									<label class="onoffswitch-label" for="socialStart_tabletOpts">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Determines whether or not display social buttons on window preview, the default is <code>ON</code>.</small>
								<hr>
								
								<label class="label" for="global_option_socialShow_tabletOpts">Social Buttons Show Event</label>
								
								<select name="tabletOpts[socialShow]" id="global_option_socialShow_tabletOpts">
									<option value="touchstart"<?php if(@$gallery['tabletOpts']['socialShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['tabletOpts']['socialShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['tabletOpts']['socialShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing social buttons, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_socialHide_tabletOpts">Social Buttons Hide Event</label>
								
								<select name="tabletOpts[socialHide]" id="global_option_socialHide_tabletOpts">
									<option value="touchstart"<?php if(@$gallery['tabletOpts']['socialHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$gallery['tabletOpts']['socialHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$gallery['tabletOpts']['socialHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding social buttons, the default is 'mouseleave'.</small>
								
							</div>
							
						</li>
						<li class="col span_1" id="slides">

<?php
if(!@empty($gallery)) {
	$slides = (@$gallery['slides']) ? @$gallery['slides'] : array();
	
	foreach($slides as $key => $data){
?>
			<div class="slide" style="display: block;">
				<a class="remove_slide" title="Remove this slide"></a>
				
				<div class="dragger">
					<div class="slide_no" pattern="_i_|html"><?php echo $key+1; ?></div>
				</div>
				
				<div class="source clearfix">
					<div class="thumb insert_media" title="Add a Media"><?php if(@$data['thumbnail']) { ?><img src="<?php echo $data['thumbnail']; ?>" style="display: block;" width="48" height="48" /><?php } else { ?><img src="<?php echo $this->ILIGHTBOX_URL."/css/images/camera.png"; ?>" width="48" height="48" /><?php } ?></div>
					<div class="url"><input type="text" pattern="slides[_i_][source]|name" name="slides[<?php echo $key; ?>][source]" placeholder="URL" value="<?php echo @$data['source']; ?>" /></div>
				</div>
				
				<div class="section collapsed">
					<h3 class="title">Options</h3>
					
					<label class="label" pattern="slides[_i_][link]|for" for="slides[<?php echo $key; ?>][link]">Link</label>
					
					<input type="text" pattern="slides[_i_][link]|id,name" name="slides[<?php echo $key; ?>][link]" id="slides[<?php echo $key; ?>][link]" placeholder="URL" value="<?php echo @$data['link']; ?>" class="large" />
					<div class="clear"></div>
					<small>Sets a link to another URL for thumbnail.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][type]|for" for="slides[<?php echo $key; ?>][type]">Type</label>
					
					<select pattern="slides[_i_][type]|id,name" name="slides[<?php echo $key; ?>][type]" id="slides[<?php echo $key; ?>][type]">
						<option value="">Auto</option>
						<option value="image"<?php if(@$data['type'] == 'image') { echo " selected"; } ?>>Image</option>
						<option value="video"<?php if(@$data['type'] == 'video') { echo " selected"; } ?>>Video</option>
						<option value="flash"<?php if(@$data['type'] == 'flash') { echo " selected"; } ?>>Flash</option>
						<option value="iframe"<?php if(@$data['type'] == 'iframe') { echo " selected"; } ?>>iFrame</option>
						<option value="inline"<?php if(@$data['type'] == 'inline') { echo " selected"; } ?>>Inline</option>
						<option value="ajax"<?php if(@$data['type'] == 'ajax') { echo " selected"; } ?>>Ajax</option>
						<option value="html"<?php if(@$data['type'] == 'html') { echo " selected"; } ?>>HTML</option>
					</select>
					<div class="clear"></div>
					<small>iLightBox attempts to automatically detect the media type using the urls file extension. The type can also be set to one of the following values.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][thumbnail]|for" for="slides[<?php echo $key; ?>][thumbnail]">Thumbnail</label>
					
					<input type="text" pattern="slides[_i_][thumbnail]|id,name" name="slides[<?php echo $key; ?>][thumbnail]" id="slides[<?php echo $key; ?>][thumbnail]" placeholder="URL" value="<?php echo @$data['thumbnail']; ?>" class="large thumbnail" />
					<div class="clear"></div>
					<small>Sets a thumbnail image for use with the thumbnail controls. Images have a thumbnail based on their source image by default, this option can be used to set an alternative. For every other type this option will have to be set to generate a thumbnail.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][icon]|for" for="slides[<?php echo $key; ?>][icon]">Icon</label>
					
					<select pattern="slides[_i_][icon]|id,name" name="slides[<?php echo $key; ?>][icon]" id="slides[<?php echo $key; ?>][icon]">
						<option value="">Auto</option>
						<option value="0"<?php if(@$data['icon'] == '0') { echo " selected"; } ?>>None</option>
						<option value="video"<?php if(@$data['icon'] == 'video') { echo " selected"; } ?>>Video</option>
					</select>
					<div class="clear"></div>
					<small>It possible to set an icon type to overlay the thumbnail.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][caption]|for" for="slides[<?php echo $key; ?>][caption]">Caption</label>
					
					<input type="text" pattern="slides[_i_][caption]|id,name" name="slides[<?php echo $key; ?>][caption]" id="slides[<?php echo $key; ?>][caption]" placeholder="Text" value="<?php echo htmlentities(stripslashes(@$data['caption']), ENT_QUOTES, 'UTF-8'); ?>" class="large" />
					<div class="clear"></div>
					<small>The caption underneath the content.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][title]|for" for="slides[<?php echo $key; ?>][title]">Title</label>
					
					<input type="text" pattern="slides[_i_][title]|id,name" name="slides[<?php echo $key; ?>][title]" id="slides[<?php echo $key; ?>][title]" placeholder="Text" value="<?php echo htmlentities(stripslashes(@$data['title']), ENT_QUOTES, 'UTF-8'); ?>" class="large" />
					<div class="clear"></div>
					<small>The title above the window.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][skin]|for" for="slides[<?php echo $key; ?>][skin]">Skin</label>
					
					<input type="text" pattern="slides[_i_][skin]|id,name" name="slides[<?php echo $key; ?>][skin]" id="slides[<?php echo $key; ?>][skin]" placeholder="Text" value="<?php echo @$data['skin']; ?>" class="small" />
					<div class="clear"></div>
					<small>Sets the skin. Available skins are: <code>dark</code>, <code>light</code>, <code>parade</code>, <code>metro-black</code>, <code>metro-white</code> and <code>mac</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][class]|for" for="slides[<?php echo $key; ?>][class]">Custom Class</label>
					
					<input type="text" pattern="slides[_i_][class]|id,name" name="slides[<?php echo $key; ?>][class]" id="slides[<?php echo $key; ?>][class]" placeholder="Text" value="<?php echo @$data['class']; ?>" class="small" />
					<div class="clear"></div>
					<small>Sets the custom class for thumbnail in gallery grid overlay.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][width]|for" for="slides[<?php echo $key; ?>][width]">Width</label>
				
					<div class="ilightbox_ui_slider" data-max="5000" data-min="0" data-step="1">
						<input type="text" pattern="slides[_i_][width]|id,name" name="slides[<?php echo $key; ?>][width]" id="slides[<?php echo $key; ?>][width]" placeholder="Number" value="<?php echo @$data['width']; ?>" class="medium" />
						<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
					</div>
					<div class="clear"></div>
					<small>Sets a maximum width of the content.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][height]|for" for="slides[<?php echo $key; ?>][height]">Height</label>
				
					<div class="ilightbox_ui_slider" data-max="5000" data-min="0" data-step="1">
						<input type="text" pattern="slides[_i_][height]|id,name" name="slides[<?php echo $key; ?>][height]" id="slides[<?php echo $key; ?>][height]" placeholder="Number" value="<?php echo @$data['height']; ?>" class="medium" />
						<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
					</div>
					<div class="clear"></div>
					<small>Sets a maximum height of the content.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][fullViewPort]|for" for="slides[<?php echo $key; ?>][fullViewPort]">Fullscreen Viewport</label>
				
					<select pattern="slides[_i_][fullViewPort]|id,name" name="slides[<?php echo $key; ?>][fullViewPort]" id="slides[<?php echo $key; ?>][fullViewPort]">
						<option value="">Center</option>
						<option value="fit"<?php if(@$data['fullViewPort'] == 'fit') { echo " selected"; } ?>>Fit</option>
						<option value="fill"<?php if(@$data['fullViewPort'] == 'fill') { echo " selected"; } ?>>Fill</option>
						<option value="stretch"<?php if(@$data['fullViewPort'] == 'stretch') { echo " selected"; } ?>>Stretch</option>
					</select>
					<div class="clear"></div>
					<small>Sets the resizing method used to fit content within the fullscreen mode.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][mousewheel]|for" for="slides[<?php echo $key; ?>][mousewheel]">Mouse Wheel</label>
				
					<div class="onoffswitch">
						<input type="checkbox" pattern="slides[_i_][mousewheel]|id,name" name="slides[<?php echo $key; ?>][mousewheel]" id="slides[<?php echo $key; ?>][mousewheel]" class="onoffswitch-checkbox"<?php if($data['mousewheel']) { echo " checked"; } ?> />
						<label class="onoffswitch-label" pattern="slides[_i_][mousewheel]|for" for="slides[<?php echo $key; ?>][mousewheel]">
							<div class="onoffswitch-inner">
								<div class="onoffswitch-active">ON</div>
								<div class="onoffswitch-inactive">OFF</div>
							</div>
							<div class="onoffswitch-switch"></div>
						</label>
					</div>
					<div class="clear"></div>
					<small>Enables or disables the mousewheel navigation, the default is <code>ON</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][swipe]|for" for="slides[<?php echo $key; ?>][swipe]">Swipe</label>
				
					<div class="onoffswitch">
						<input type="checkbox" pattern="slides[_i_][swipe]|id,name" name="slides[<?php echo $key; ?>][swipe]" id="slides[<?php echo $key; ?>][swipe]" class="onoffswitch-checkbox"<?php if($data['swipe']) { echo " checked"; } ?> />
						<label class="onoffswitch-label" pattern="slides[_i_][swipe]|for" for="slides[<?php echo $key; ?>][swipe]">
							<div class="onoffswitch-inner">
								<div class="onoffswitch-active">ON</div>
								<div class="onoffswitch-inactive">OFF</div>
							</div>
							<div class="onoffswitch-switch"></div>
						</label>
					</div>
					<div class="clear"></div>
					<small>Enables or disables the swipe navigation, the default is <code>ON</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][smartRecognition]|for" for="slides[<?php echo $key; ?>][smartRecognition]">Smart Recognition</label>
				
					<div class="onoffswitch">
						<input type="checkbox" pattern="slides[_i_][smartRecognition]|id,name" name="slides[<?php echo $key; ?>][smartRecognition]" id="slides[<?php echo $key; ?>][smartRecognition]" class="onoffswitch-checkbox"<?php if(@$data['smartRecognition']) { echo " checked"; } ?> />
						<label class="onoffswitch-label" pattern="slides[_i_][smartRecognition]|for" for="slides[<?php echo $key; ?>][smartRecognition]">
							<div class="onoffswitch-inner">
								<div class="onoffswitch-active">ON</div>
								<div class="onoffswitch-inactive">OFF</div>
							</div>
							<div class="onoffswitch-switch"></div>
						</label>
					</div>
					<div class="clear"></div>
					<small>Sets content auto recognize from web pages, the default is <code>OFF</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][social]|for" for="slides[<?php echo $key; ?>][social]">Social Buttons</label>
					<small>Sets the social buttons. For get more information about this field refer: <a href="http://ilightbox.net/documentation.html#inline_options_social" target="_blank">http://ilightbox.net/documentation.html#inline_options_social</a></small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][social]|id,name" name="slides[<?php echo $key; ?>][social]" id="slides[<?php echo $key; ?>][social]"><?php echo htmlentities(stripslashes(@$data['social']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][ajax]|for" for="slides[<?php echo $key; ?>][ajax]">Ajax</label>
					<small>Allows extra options to be set when using ajax as your media type.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][ajax]|id,name" name="slides[<?php echo $key; ?>][ajax]" id="slides[<?php echo $key; ?>][ajax]"><?php echo htmlentities(stripslashes(@$data['ajax']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][html5video]|for" for="slides[<?php echo $key; ?>][html5video]">HTML5 Video</label>
					<small>Allows extra options to be set when using HTML5 Video.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][html5video]|id,name" name="slides[<?php echo $key; ?>][html5video]" id="slides[<?php echo $key; ?>][html5video]"><?php echo htmlentities(stripslashes(@$data['html5video']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][flashvars]|for" for="slides[<?php echo $key; ?>][flashvars]">Flashvars</label>
					<small>Sets flashvars on a flash movie using key/value pairs.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][flashvars]|id,name" name="slides[<?php echo $key; ?>][flashvars]" id="slides[<?php echo $key; ?>][flashvars]"><?php echo htmlentities(stripslashes(@$data['flashvars']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][html]|for" for="slides[<?php echo $key; ?>][html]">HTML</label>
					<small>Sets HTML Contents when you choose HTML type.</small>
					<div class="clear"></div>
					<textarea class="html medium" pattern="slides[_i_][html]|id,name" name="slides[<?php echo $key; ?>][html]" id="slides[<?php echo $key; ?>][html]"><?php echo htmlentities(stripslashes(@$data['html']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label">onAfterLoad</label>
					<small>A function to call when the content loads.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onAfterLoad]|name" name="slides[<?php echo $key; ?>][onAfterLoad]"><?php echo htmlentities(stripslashes(@$data['onAfterLoad']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label">onBeforeLoad</label>
					<small>A function to call before the content loads.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onBeforeLoad]|name" name="slides[<?php echo $key; ?>][onBeforeLoad]"><?php echo htmlentities(stripslashes(@$data['onBeforeLoad']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label">onRender</label>
					<small>A function to call when the content renders.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onRender]|name" name="slides[<?php echo $key; ?>][onRender]"><?php echo htmlentities(stripslashes(@$data['onRender']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<hr>
					
					<label class="label">onShow</label>
					<small>A function to call when the window comes into view.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onShow]|name" name="slides[<?php echo $key; ?>][onShow]"><?php echo htmlentities(stripslashes(@$data['onShow']), ENT_QUOTES, 'UTF-8'); ?></textarea>
					
				</div>
			</div>
<?php
	}
}
?>
						</li>
					</ul> <!-- .item_listing -->
				</div> <!-- .row -->
				
				<div class="clear"></div>
			</form>
			
			<div class="slide" id="slide">
				<a class="remove_slide" title="Remove this slide"></a>
				
				<div class="dragger">
					<div class="slide_no" pattern="_i_|html">__i__</div>
				</div>
				
				<div class="source clearfix">
					<div class="thumb insert_media" title="Add a Media"><img src="<?php echo $this->ILIGHTBOX_URL."/css/images/camera.png"; ?>" width="48" height="48" /></div>
					<div class="url"><input type="text" pattern="slides[_i_][source]|name" name="slides[__i__][source]" placeholder="URL" /></div>
				</div>
				
				<div class="section collapsed">
					<h3 class="title">Options</h3>
					
					<label class="label" pattern="slides[_i_][link]|for" for="slides[__i__][link]">Link</label>
					
					<input type="text" pattern="slides[_i_][link]|id,name" name="slides[__i__][link]" id="slides[__i__][link]" placeholder="URL" class="large" />
					<div class="clear"></div>
					<small>Sets a link to another URL for thumbnail.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][type]|for" for="slides[__i__][type]">Type</label>
					
					<select pattern="slides[_i_][type]|id,name" name="slides[__i__][type]" id="slides[__i__][type]">
						<option value="">Auto</option>
						<option value="image">Image</option>
						<option value="video">Video</option>
						<option value="flash">Flash</option>
						<option value="iframe">iFrame</option>
						<option value="inline">Inline</option>
						<option value="ajax">Ajax</option>
						<option value="html">HTML</option>
					</select>
					<div class="clear"></div>
					<small>iLightBox attempts to automatically detect the media type using the urls file extension. The type can also be set to one of the following values.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][thumbnail]|for" for="slides[__i__][thumbnail]">Thumbnail</label>
					
					<input type="text" pattern="slides[_i_][thumbnail]|id,name" name="slides[__i__][thumbnail]" id="slides[__i__][thumbnail]" placeholder="URL" class="large thumbnail" />
					<div class="clear"></div>
					<small>Sets a thumbnail image for use with the thumbnail controls. Images have a thumbnail based on their source image by default, this option can be used to set an alternative. For every other type this option will have to be set to generate a thumbnail.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][icon]|for" for="slides[__i__][icon]">Icon</label>
					
					<select pattern="slides[_i_][icon]|id,name" name="slides[__i__][icon]" id="slides[__i__][icon]">
						<option value="">Auto</option>
						<option value="0">None</option>
						<option value="video">Video</option>
					</select>
					<div class="clear"></div>
					<small>It possible to set an icon type to overlay the thumbnail.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][caption]|for" for="slides[__i__][caption]">Caption</label>
					
					<input type="text" pattern="slides[_i_][caption]|id,name" name="slides[__i__][caption]" id="slides[__i__][caption]" placeholder="Text" class="large" />
					<div class="clear"></div>
					<small>The caption underneath the content.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][title]|for" for="slides[__i__][title]">Title</label>
					
					<input type="text" pattern="slides[_i_][title]|id,name" name="slides[__i__][title]" id="slides[__i__][title]" placeholder="Text" class="large" />
					<div class="clear"></div>
					<small>The title above the window.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][skin]|for" for="slides[__i__][skin]">Skin</label>
					
					<input type="text" pattern="slides[_i_][skin]|id,name" name="slides[__i__][skin]" id="slides[__i__][skin]" placeholder="Text" class="small" />
					<div class="clear"></div>
					<small>Sets the skin. Available skins are: <code>dark</code>, <code>light</code>, <code>parade</code>, <code>smooth</code>, <code>metro-black</code>, <code>metro-white</code> and <code>mac</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][class]|for" for="slides[__i__][class]">Custom Class</label>
					
					<input type="text" pattern="slides[_i_][class]|id,name" name="slides[__i__][class]" id="slides[__i__][class]" placeholder="Text" class="small" />
					<div class="clear"></div>
					<small>Sets the custom class for thumbnail in gallery grid overlay.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][width]|for" for="slides[__i__][width]">Width</label>
				
					<div class="ilightbox_ui_slider" data-max="5000" data-min="0" data-step="1">
						<input type="text" pattern="slides[_i_][width]|id,name" name="slides[__i__][width]" id="slides[__i__][width]" placeholder="Number" class="medium" />
						<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
					</div>
					<div class="clear"></div>
					<small>Sets a maximum width of the content.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][height]|for" for="slides[__i__][height]">Height</label>
				
					<div class="ilightbox_ui_slider" data-max="5000" data-min="0" data-step="1">
						<input type="text" pattern="slides[_i_][height]|id,name" name="slides[__i__][height]" id="slides[__i__][height]" placeholder="Number" class="medium" />
						<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
					</div>
					<div class="clear"></div>
					<small>Sets a maximum height of the content.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][fullViewPort]|for" for="slides[__i__][fullViewPort]">Fullscreen Viewport</label>
				
					<select pattern="slides[_i_][fullViewPort]|id,name" name="slides[__i__][fullViewPort]" id="slides[__i__][fullViewPort]">
						<option value="">Center</option>
						<option value="fit">Fit</option>
						<option value="fill">Fill</option>
						<option value="stretch">Stretch</option>
					</select>
					<div class="clear"></div>
					<small>Sets the resizing method used to fit content within the fullscreen mode.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][mousewheel]|for" for="slides[__i__][mousewheel]">Mouse Wheel</label>
				
					<div class="onoffswitch">
						<input type="checkbox" pattern="slides[_i_][mousewheel]|id,name" name="slides[__i__][mousewheel]" id="slides[__i__][mousewheel]" class="onoffswitch-checkbox" checked />
						<label class="onoffswitch-label" pattern="slides[_i_][mousewheel]|for" for="slides[__i__][mousewheel]">
							<div class="onoffswitch-inner">
								<div class="onoffswitch-active">ON</div>
								<div class="onoffswitch-inactive">OFF</div>
							</div>
							<div class="onoffswitch-switch"></div>
						</label>
					</div>
					<div class="clear"></div>
					<small>Enables or disables the mousewheel navigation, the default is <code>ON</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][swipe]|for" for="slides[__i__][swipe]">Swipe</label>
				
					<div class="onoffswitch">
						<input type="checkbox" pattern="slides[_i_][swipe]|id,name" name="slides[__i__][swipe]" id="slides[__i__][swipe]" class="onoffswitch-checkbox" checked />
						<label class="onoffswitch-label" pattern="slides[_i_][swipe]|for" for="slides[__i__][swipe]">
							<div class="onoffswitch-inner">
								<div class="onoffswitch-active">ON</div>
								<div class="onoffswitch-inactive">OFF</div>
							</div>
							<div class="onoffswitch-switch"></div>
						</label>
					</div>
					<div class="clear"></div>
					<small>Enables or disables the swipe navigation, the default is <code>ON</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][smartRecognition]|for" for="slides[__i__][smartRecognition]">Smart Recognition</label>
				
					<div class="onoffswitch">
						<input type="checkbox" pattern="slides[_i_][smartRecognition]|id,name" name="slides[__i__][smartRecognition]" id="slides[__i__][smartRecognition]" class="onoffswitch-checkbox" />
						<label class="onoffswitch-label" pattern="slides[_i_][smartRecognition]|for" for="slides[__i__][smartRecognition]">
							<div class="onoffswitch-inner">
								<div class="onoffswitch-active">ON</div>
								<div class="onoffswitch-inactive">OFF</div>
							</div>
							<div class="onoffswitch-switch"></div>
						</label>
					</div>
					<div class="clear"></div>
					<small>Sets content auto recognize from web pages, the default is <code>OFF</code>.</small>
					<hr>
					
					<label class="label" pattern="slides[_i_][social]|for" for="slides[__i__][social]">Social Buttons</label>
					<small>Sets the social buttons. For get more information about this field refer: <a href="http://ilightbox.net/documentation.html#inline_options_social" target="_blank">http://ilightbox.net/documentation.html#inline_options_social</a></small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][social]|id,name" name="slides[__i__][social]" id="slides[__i__][social]"></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][ajax]|for" for="slides[__i__][ajax]">Ajax</label>
					<small>Allows extra options to be set when using ajax as your media type.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][ajax]|id,name" name="slides[__i__][ajax]" id="slides[__i__][ajax]"></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][html5video]|for" for="slides[__i__][html5video]">HTML5 Video</label>
					<small>Allows extra options to be set when using HTML5 Video.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][html5video]|id,name" name="slides[__i__][html5video]" id="slides[__i__][html5video]"></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][flashvars]|for" for="slides[__i__][flashvars]">Flashvars</label>
					<small>Sets flashvars on a flash movie using key/value pairs.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][flashvars]|id,name" name="slides[__i__][flashvars]" id="slides[__i__][flashvars]"></textarea>
					<hr>
					
					<label class="label" pattern="slides[_i_][html]|for" for="slides[__i__][html]">HTML</label>
					<small>Sets HTML Contents when you choose HTML type.</small>
					<div class="clear"></div>
					<textarea class="html medium" pattern="slides[_i_][html]|id,name" name="slides[__i__][html]" id="slides[__i__][html]"></textarea>
					<hr>
					
					<label class="label">onAfterLoad</label>
					<small>A function to call when the content loads.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onAfterLoad]|name" name="slides[__i__][onAfterLoad]"></textarea>
					<hr>
					
					<label class="label">onBeforeLoad</label>
					<small>A function to call before the content loads.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onBeforeLoad]|name" name="slides[__i__][onBeforeLoad]"></textarea>
					<hr>
					
					<label class="label">onRender</label>
					<small>A function to call when the content renders.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onRender]|name" name="slides[__i__][onRender]"></textarea>
					<hr>
					
					<label class="label">onShow</label>
					<small>A function to call when the window comes into view.</small>
					<div class="clear"></div>
					<textarea class="javascript medium" pattern="slides[_i_][onShow]|name" name="slides[__i__][onShow]"></textarea>
					
				</div>
			</div>
	
		</div>
	</div>
</div><!-- #ilightbox_admin_wrap -->