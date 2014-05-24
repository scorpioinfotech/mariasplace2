<div class="wrap" id="ilightbox_admin_wrap">
	<div class="ilightbox_admin_content clearfix">
	<?php require_once('ilightbox_menu.php');?>
			<form method="post" class="ajaxform">
				<div class="ilightbox_topbar clearfix">
					<a class="il-button lightblue-button" role="submit"><span>Save Changes</span></a>
					<h3>Configurations</h3>
				</div>
				
				<input type="hidden" name="_action" value="saveConfigurations" />
				<div class="row margintop clearfix">
					<ul class="item_listing">
						<li class="col span_1">
							<div class="section clearfix">
								<h3 class="title">Common</h3>
								<label class="label" for="ilightbox_auto_enable">Enable on Photos Links</label>
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_auto_enable" class="onoffswitch-checkbox" id="ilightbox_auto_enable"<?php if($this->ilightbox_get_option('ilightbox_auto_enable') == "true"){?> checked<?php }?>>
									<label class="onoffswitch-label" for="ilightbox_auto_enable">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By enabling this feature, all links on your site that contains images will be automatically recognize by iLightBox.</small>
								<hr>
								
								<label class="label" for="ilightbox_auto_enable_videos">Enable on Videos Links</label>
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_auto_enable_videos" class="onoffswitch-checkbox" id="ilightbox_auto_enable_videos"<?php if($this->ilightbox_get_option('ilightbox_auto_enable_videos') == "true"){?> checked<?php }?>>
									<label class="onoffswitch-label" for="ilightbox_auto_enable_videos">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By enabling this feature, all links on your site that contains videos will be automatically recognize by iLightBox.</small>
								<hr>
								
								<label class="label" for="ilightbox_auto_enable_video_sites">Enable on Video Pages Links</label>
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_auto_enable_video_sites" class="onoffswitch-checkbox" id="ilightbox_auto_enable_video_sites"<?php if($this->ilightbox_get_option('ilightbox_auto_enable_video_sites') == "true"){?> checked<?php }?>>
									<label class="onoffswitch-label" for="ilightbox_auto_enable_video_sites">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By enabling this feature, all links on your site that contains video pages (YouTube, Vimeo, MetaCafe, Dailymotion, Hulu) will be automatically recognize by iLightBox.</small>
								<hr>
								
								<label class="label" for="ilightbox_gallery_shortcode">Enable on Gallery Shortcode</label>
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_gallery_shortcode" class="onoffswitch-checkbox" id="ilightbox_gallery_shortcode"<?php if($this->ilightbox_get_option('ilightbox_gallery_shortcode') == "true"){?> checked<?php }?>>
									<label class="onoffswitch-label" for="ilightbox_gallery_shortcode">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By enabling this feature, iLightBox will be available for Regular WordPress Gallery Shortcode (<a href="http://codex.wordpress.org/Gallery_Shortcode" target="_blank">Gallery Shortcode</a>).</small>
								<hr>
								
								<label class="label" for="ilightbox_jetpack">Enable on JetPack Galleries</label>
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_jetpack" class="onoffswitch-checkbox" id="ilightbox_jetpack"<?php if($this->ilightbox_get_option('ilightbox_jetpack') == "true"){?> checked<?php }?>>
									<label class="onoffswitch-label" for="ilightbox_jetpack">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By enabling this feature, iLightBox will be available for WordPress JetPack Galleries.</small>
								<hr>
								
								<label class="label" for="ilightbox_nextgen">Enable on nextGEN Galleries</label>
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_nextgen" class="onoffswitch-checkbox" id="ilightbox_nextgen"<?php if($this->ilightbox_get_option('ilightbox_nextgen') == "true"){?> checked<?php }?>>
									<label class="onoffswitch-label" for="ilightbox_nextgen">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>By enabling this feature, iLightBox will be available for nextGEN Galleries.</small>
								<hr>
								
								<label class="label" for="ilightbox_delete_table">Delete Data</label>
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_delete_table" class="onoffswitch-checkbox" id="ilightbox_delete_table"<?php if($this->ilightbox_get_option('ilightbox_delete_table') == "true"){?> checked<?php }?>>
									<label class="onoffswitch-label" for="ilightbox_delete_table">
										<div class="onoffswitch-inner">
											<div class="onoffswitch-active">ON</div>
											<div class="onoffswitch-inactive">OFF</div>
										</div>
										<div class="onoffswitch-switch"></div>
									</label>
								</div>
								<div class="clear"></div>
								<small>Delete all the data from the database. Even if you delete iLightBox from the plugin page, all the data stored in the database will be still available, so you won't lose your settings.<br>
								But if you want to permanently delete iLightBox and all the data stored in your database, before deactivating and deleting the plugin switch on this field</small>
							</div>
							
							<hr>
							
							<h3>iLightBox Global Options</h3>
							
							<?
								$global_options = $this->ilightbox_get_option('ilightbox_global_options');
							?>
							<div class="section collapsed clearfix">
								<h3 class="title">General Options</h3>
								<label class="label" for="global_option_path">Path</label>
								
								<select name="ilightbox_global_options[path]" id="global_option_path">
									<option value="">Vertical</option>
									<option value="horizontal"<?php if(@$global_options['path'] == 'horizontal') { echo " selected"; } ?>>Horizontal</option>
								</select>
								<div class="clear"></div>
								<small>Sets path for switching windows, the default is '<code>vertical</code>'.</small>
								<hr>
								
								<label class="label" for="global_option_skin">Skin</label>
								
								<input type="text" name="ilightbox_global_options[skin]" id="global_option_skin" class="small" value="<?php echo @$global_options['skin']; ?>" />
								<div class="clear"></div>
								<small>Sets the skin, the default is '<code>dark</code>'. Available skins are: <code>dark</code>, <code>light</code>, <code>parade</code>, <code>smooth</code>, <code>metro-black</code>, <code>metro-white</code> and <code>mac</code>.</small>
								<hr>
								
								<label class="label" for="global_option_linkId">Link ID</label>
								
								<input type="text" name="ilightbox_global_options[linkId]" id="global_option_linkId" class="small" value="<?php echo @$global_options['linkId']; ?>" />
								<div class="clear"></div>
								<small>Sets the deeplinking id.</small>
								<hr>
								
								<label class="label" for="global_option_infinite">Infinite</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[infinite]" class="onoffswitch-checkbox" id="global_option_infinite"<?php if(@$global_options['infinite']) { echo " checked"; } ?> />
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
								
								<label class="label" for="global_option_keepAspectRatio">Keep Aspect Ratio</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[keepAspectRatio]" class="onoffswitch-checkbox" id="global_option_keepAspectRatio"<?php if(!@empty($global_options)) { if(@$global_options['keepAspectRatio']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[mobileOptimizer]" class="onoffswitch-checkbox" id="global_option_mobileOptimizer"<?php if(!@empty($global_options)) { if(@$global_options['mobileOptimizer']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="text" name="ilightbox_global_options[maxScale]" id="global_option_maxScale" class="small" value="<?php echo @$global_options['maxScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the maximum viewport scale of the content, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="global_option_minScale">Min Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="ilightbox_global_options[minScale]" id="global_option_minScale" class="small" value="<?php echo @$global_options['minScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the minimum viewport scale of the content, the default is <code>0.2</code>.</small>
								<hr>
								
								<label class="label" for="global_option_innerToolbar">Inner Toolbar</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[innerToolbar]" class="onoffswitch-checkbox" id="global_option_innerToolbar"<?php if(@$global_options['innerToolbar']) { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[smartRecognition]" class="onoffswitch-checkbox" id="global_option_smartRecognition"<?php if(@$global_options['smartRecognition']) { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[fullAlone]" class="onoffswitch-checkbox" id="global_option_fullAlone"<?php if(!@empty($global_options)) { if(@$global_options['fullAlone']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								
								<select name="ilightbox_global_options[fullViewPort]" id="global_option_fullViewPort">
									<option value="">Center</option>
									<option value="fit"<?php if(@$global_options['fullViewPort'] == 'fit') { echo " selected"; } ?>>Fit</option>
									<option value="fill"<?php if(@$global_options['fullViewPort'] == 'fill') { echo " selected"; } ?>>Fill</option>
									<option value="stretch"<?php if(@$global_options['fullViewPort'] == 'stretch') { echo " selected"; } ?>>Stretch</option>
								</select>
								<div class="clear"></div>
								<small>Sets the resizing method used to fit content within the fullscreen mode.</small>
								<hr>
								
								<label class="label" for="global_option_fullStretchTypes">Fullscreen Stretch Types</label>
								
								<input type="text" name="ilightbox_global_options[fullStretchTypes]" id="global_option_fullStretchTypes" class="medium" value="<?php echo @$global_options['fullStretchTypes']; ?>" />
								<div class="clear"></div>
								<small>Sets the stretch resizing used to fit content within the fullscreen mode for specific content types. Possible values are: <code>image</code>, <code>video</code>, <code>flash</code>, <code>iframe</code>, <code>inline</code>, <code>ajax</code> and <code>html</code>. The default is '<code>flash, video</code>'.</small>
								<hr>
								
								<label class="label" for="global_option_showTitle">Show Title</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[show_title]" class="onoffswitch-checkbox" id="global_option_showTitle"<?php if(!@empty($global_options)) { if(@$global_options['show_title']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[mobileOptimize]" class="onoffswitch-checkbox" id="global_option_mobileOptimize"<?php if(@$global_options['mobileOptimize']) { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[tabletOptimize]" class="onoffswitch-checkbox" id="global_option_tabletOptimize"<?php if(@$global_options['tabletOptimize']) { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[overlayBlur]" class="onoffswitch-checkbox" id="ilightbox_overlayBlur"<?php if(!@empty($global_options)) { if(@$global_options['overlayBlur']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[toolbar]" class="onoffswitch-checkbox" id="ilightbox_toolbar"<?php if(!@empty($global_options)) { if(@$global_options['toolbar']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[fullscreen]" class="onoffswitch-checkbox" id="ilightbox_fullscreen"<?php if(!@empty($global_options)) { if(@$global_options['fullscreen']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[arrows]" class="onoffswitch-checkbox" id="ilightbox_arrows"<?php if(@$global_options['arrows']) { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[thumbnail]" class="onoffswitch-checkbox" id="ilightbox_thumbnail"<?php if(!@empty($global_options)) { if(@$global_options['thumbnail']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[keyboard]" class="onoffswitch-checkbox" id="ilightbox_keyboard"<?php if(!@empty($global_options)) { if(@$global_options['keyboard']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[mousewheel]" class="onoffswitch-checkbox" id="ilightbox_mousewheel"<?php if(!@empty($global_options)) { if(@$global_options['mousewheel']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[swipe]" class="onoffswitch-checkbox" id="ilightbox_swipe"<?php if(!@empty($global_options)) { if(@$global_options['swipe']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[left]" class="onoffswitch-checkbox" id="left"<?php if(!@empty($global_options)) { if(@$global_options['left']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[right]" class="onoffswitch-checkbox" id="right"<?php if(!@empty($global_options)) { if(@$global_options['right']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[up]" class="onoffswitch-checkbox" id="up"<?php if(!@empty($global_options)) { if(@$global_options['up']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[down]" class="onoffswitch-checkbox" id="down"<?php if(!@empty($global_options)) { if(@$global_options['down']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[esc]" class="onoffswitch-checkbox" id="esc"<?php if(!@empty($global_options)) { if(@$global_options['esc']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[shift_enter]" class="onoffswitch-checkbox" id="shift_enter"<?php if(!@empty($global_options)) { if(@$global_options['shift_enter']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="text" name="ilightbox_global_options[overlayOpacity]" id="overlayOpacity" class="small" value="<?php echo @$global_options['overlayOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the opacity of the dimmed background of the page, the default is <code>0.85</code>.</small>
								<hr>
								
								<label class="label" for="pageOffsetX">Page Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[pageOffsetX]" id="pageOffsetX" class="small" value="<?php echo @$global_options['pageOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines page X offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="pageOffsetY">Page Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[pageOffsetY]" id="pageOffsetY" class="small" value="<?php echo @$global_options['pageOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines page Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetX">Next Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[nextOffsetX]" id="nextOffsetX" class="small" value="<?php echo @$global_options['nextOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetY">Next Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[nextOffsetY]" id="nextOffsetY" class="small" value="<?php echo @$global_options['nextOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="nextOpacity">Next Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="ilightbox_global_options[nextOpacity]" id="nextOpacity" class="small" value="<?php echo @$global_options['nextOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window opacity, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="nextScale">Next Scale</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="ilightbox_global_options[nextScale]" id="nextScale" class="small" value="<?php echo @$global_options['nextScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window scale, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetX">Previous Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[prevOffsetX]" id="prevOffsetX" class="small" value="<?php echo @$global_options['prevOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetY">Previous Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[prevOffsetY]" id="prevOffsetY" class="small" value="<?php echo @$global_options['prevOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="prevOpacity">Previous Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="ilightbox_global_options[prevOpacity]" id="prevOpacity" class="small" value="<?php echo @$global_options['prevOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window opacity, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="prevScale">Previous Scale</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="ilightbox_global_options[prevScale]" id="prevScale" class="small" value="<?php echo @$global_options['prevScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window scale, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_maxWidth">Thumbnails Max Width</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="ilightbox_global_options[thumbnails_maxWidth]" id="thumbnails_maxWidth" class="small" value="<?php echo @$global_options['thumbnails_maxWidth']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum width of the thumbnails, the default is <code>120</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_maxHeight">Thumbnails Max Height</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="ilightbox_global_options[thumbnails_maxHeight]" id="thumbnails_maxHeight" class="small" value="<?php echo @$global_options['thumbnails_maxHeight']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum height of the thumbnails, the default is <code>80</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_normalOpacity">Thumbnails Normal Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="ilightbox_global_options[thumbnails_normalOpacity]" id="thumbnails_normalOpacity" class="small" value="<?php echo @$global_options['thumbnails_normalOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the opacity of the thumbnails, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_activeOpacity">Active Thumbnail Opacity</label>
								
								<div class="ilightbox_ui_slider" data-max="1" data-min="0" data-step="0.01">
									<input type="text" name="ilightbox_global_options[thumbnails_activeOpacity]" id="thumbnails_activeOpacity" class="small" value="<?php echo @$global_options['thumbnails_activeOpacity']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the opacity of the active window thumbnail, the default is <code>0.6</code>.</small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Effects</h3>
								<label class="label" for="show_effect">Show Effect</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[show_effect]" class="onoffswitch-checkbox" id="show_effect"<?php if(!@empty($global_options)) { if(@$global_options['show_effect']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[hide_effect]" class="onoffswitch-checkbox" id="hide_effect"<?php if(!@empty($global_options)) { if(@$global_options['hide_effect']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[reposition]" class="onoffswitch-checkbox" id="reposition"<?php if(!@empty($global_options)) { if(@$global_options['reposition']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="text" name="ilightbox_global_options[show_speed]" id="show_speed" class="small" value="<?php echo @$global_options['show_speed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the speed of the effect when showing contents, the default is <code>300</code>.</small>
								<hr>
								
								<label class="label" for="hide_speed">Hide Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="ilightbox_global_options[hide_speed]" id="hide_speed" class="small" value="<?php echo @$global_options['hide_speed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the speed of the effect when hiding contents, the default is <code>300</code>.</small>
								<hr>
								
								<label class="label" for="repositionSpeed">Reposition Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="ilightbox_global_options[repositionSpeed]" id="repositionSpeed" class="small" value="<?php echo @$global_options['repositionSpeed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the reposition effect speed, the default is <code>200</code>.</small>
								<hr>
								
								<label class="label" for="fadeSpeed">Fade Speed</label>
								
								<div class="ilightbox_ui_slider" data-max="50000" data-min="0" data-step="100">
									<input type="text" name="ilightbox_global_options[fadeSpeed]" id="fadeSpeed" class="small" value="<?php echo @$global_options['fadeSpeed']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets the fade effect speed, the default is <code>200</code>.</small>
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Captions</h3>
								
								<label class="label" for="captionStart">Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[captionStart]" class="onoffswitch-checkbox" id="captionStart"<?php if(!@empty($global_options)) { if(@$global_options['captionStart']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								
								<select name="ilightbox_global_options[captionShow]" id="global_option_captionShow">
									<option value="mouseenter"<?php if(@$global_options['captionShow'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="mouseleave"<?php if(@$global_options['captionShow'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="click"<?php if(@$global_options['captionShow'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$global_options['captionShow'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing caption, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_captionHide">Hide Event</label>
								
								<select name="ilightbox_global_options[captionHide]" id="global_option_captionHide">
									<option value="mouseleave"<?php if(@$global_options['captionHide'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="mouseenter"<?php if(@$global_options['captionHide'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="click"<?php if(@$global_options['captionHide'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$global_options['captionHide'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding caption, the default is 'mouseleave'.</small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Socials</h3>
								
								<label class="label" for="socialStart">Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[socialStart]" class="onoffswitch-checkbox" id="socialStart"<?php if(!@empty($global_options)) { if(@$global_options['socialStart']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								
								<select name="ilightbox_global_options[socialShow]" id="global_option_socialShow">
									<option value="mouseenter"<?php if(@$global_options['socialShow'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="mouseleave"<?php if(@$global_options['socialShow'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="click"<?php if(@$global_options['socialShow'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$global_options['socialShow'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing social buttons, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_socialHide">Hide Event</label>
								
								<select name="ilightbox_global_options[socialHide]" id="global_option_socialHide">
									<option value="mouseleave"<?php if(@$global_options['socialHide'] == 'mouseleave') { echo " selected"; } ?>>mouseleave</option>
									<option value="mouseenter"<?php if(@$global_options['socialHide'] == 'mouseenter') { echo " selected"; } ?>>mouseenter</option>
									<option value="click"<?php if(@$global_options['socialHide'] == 'click') { echo " selected"; } ?>>click</option>
									<option value="dblclick"<?php if(@$global_options['socialHide'] == 'dblclick') { echo " selected"; } ?>>dblclick</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding social buttons, the default is 'mouseleave'.</small>
								<hr>
								
								<label class="label" for="global_option_socialButtons">Buttons</label>
								
								<textarea class="javascript medium" name="ilightbox_global_options[socialButtons]"><?php echo htmlentities(stripslashes(@$global_options['socialButtons']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<div class="clear"></div>
								<small>Sets the social buttons. For get more information about this field refer: <a href="http://ilightbox.net/documentation.html#global_options_social" target="_blank">http://ilightbox.net/documentation.html#global_options_social</a></small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Slideshow</h3>
								
								<label class="label" for="slideshow">Enable</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[slideshow]" class="onoffswitch-checkbox" id="slideshow"<?php if(@$global_options['slideshow']) { echo " checked"; } ?> />
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
									<input type="text" name="ilightbox_global_options[pauseTime]" id="pauseTime" class="small" value="<?php echo @$global_options['pauseTime']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Delay between cycles in milliseconds, the default is <code>5000</code>.</small>
								<hr>
								
								<label class="label" for="pauseOnHover">Pause On Hover</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[pauseOnHover]" class="onoffswitch-checkbox" id="pauseOnHover"<?php if(@$global_options['pauseOnHover']) { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[startPaused]" class="onoffswitch-checkbox" id="startPaused"<?php if(!@empty($global_options)) { if(@$global_options['startPaused']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								<textarea class="javascript medium" name="ilightbox_global_options[onAfterChange]"><?php echo htmlentities(stripslashes(@$global_options['onAfterChange']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onAfterLoad">onAfterLoad</label>
								<small>A function to call when the content loads.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onAfterLoad]"><?php echo htmlentities(stripslashes(@$global_options['onAfterLoad']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onBeforeChange">onBeforeChange</label>
								<small>A function to call before the window changes.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onBeforeChange]"><?php echo htmlentities(stripslashes(@$global_options['onBeforeChange']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onBeforeLoad">onBeforeLoad</label>
								<small>A function to call before the content loads.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onBeforeLoad]"><?php echo htmlentities(stripslashes(@$global_options['onBeforeLoad']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onEnterFullScreen">onEnterFullScreen</label>
								<small>A function to call when the iLightBox enter to Fullscreen.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onEnterFullScreen]"><?php echo htmlentities(stripslashes(@$global_options['onEnterFullScreen']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onExitFullScreen">onExitFullScreen</label>
								<small>A function to call when the iLightBox exit from Fullscreen.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onExitFullScreen]"><?php echo htmlentities(stripslashes(@$global_options['onExitFullScreen']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onHide">onHide</label>
								<small>A function to call when the window hides.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onHide]"><?php echo htmlentities(stripslashes(@$global_options['onHide']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onOpen">onOpen</label>
								<small>A function to call when the iLightBox opens.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onOpen]"><?php echo htmlentities(stripslashes(@$global_options['onOpen']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onRender">onRender</label>
								<small>A function to call when the content renders.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onRender]"><?php echo htmlentities(stripslashes(@$global_options['onRender']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								<hr>
								
								<label class="label" for="onShow">onShow</label>
								<small>A function to call when the window comes into view.</small>
								<div class="clear"></div>
								<textarea class="javascript medium" name="ilightbox_global_options[onShow]"><?php echo htmlentities(stripslashes(@$global_options['onShow']), ENT_QUOTES, 'UTF-8'); ?></textarea>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Labels</h3>
								<input type="text" class="full" name="ilightbox_global_options[close]" value="<?php if(@$global_options['close']) { echo htmlentities(stripslashes(@$global_options['close']), ENT_QUOTES, 'UTF-8'); } else { ?>Close<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Close</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[enterFullscreen]" value="<?php if(@$global_options['enterFullscreen']) { echo htmlentities(stripslashes(@$global_options['enterFullscreen']), ENT_QUOTES, 'UTF-8'); } else { ?>Enter Fullscreen (Shift+Enter)<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Enter Fullscreen (Shift+Enter)</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[exitFullscreen]" value="<?php if(@$global_options['exitFullscreen']) { echo htmlentities(stripslashes(@$global_options['exitFullscreen']), ENT_QUOTES, 'UTF-8'); } else { ?>Exit Fullscreen (Shift+Enter)<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Exit Fullscreen (Shift+Enter)</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[slideShowLabel]" value="<?php if(@$global_options['slideShowLabel']) { echo htmlentities(stripslashes(@$global_options['slideShowLabel']), ENT_QUOTES, 'UTF-8'); } else { ?>Slideshow<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Slideshow</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[nextLabel]" value="<?php if(@$global_options['nextLabel']) { echo htmlentities(stripslashes(@$global_options['nextLabel']), ENT_QUOTES, 'UTF-8'); } else { ?>Next<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Next</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[previousLabel]" value="<?php if(@$global_options['previousLabel']) { echo htmlentities(stripslashes(@$global_options['previousLabel']), ENT_QUOTES, 'UTF-8'); } else { ?>Previous<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>Previous</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[loadImage]" value="<?php if(@$global_options['loadImage']) { echo htmlentities(stripslashes(@$global_options['loadImage']), ENT_QUOTES, 'UTF-8'); } else { ?>An error occurred when trying to load photo.<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>An error occurred when trying to load photo.</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[loadContents]" value="<?php if(@$global_options['loadContents']) { echo htmlentities(stripslashes(@$global_options['loadContents']), ENT_QUOTES, 'UTF-8'); } else { ?>An error occurred when trying to load contents.<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>An error occurred when trying to load contents.</code>'.</small>
								<hr>
								
								<input type="text" class="full" name="ilightbox_global_options[missingPlugin]" value="<?php if(@$global_options['missingPlugin']) { echo htmlentities(stripslashes(@$global_options['missingPlugin']), ENT_QUOTES, 'UTF-8'); } else { ?>The content your are attempting to view requires the <a href='{pluginspage}' target='_blank'>{type} plugin</a>.<?php } ?>" />
								<div class="clear"></div>
								<small>The default is '<code>The content your are attempting to view requires the &lt;a href='{pluginspage}' target='_blank'&gt;{type} plugin&lt;/a&gt;.</code>'.</small>
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Mobile Optimizations</h3>
								
								<label class="label" for="global_option_maxScale_mobileOpts">Max Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="ilightbox_global_options[mobileOpts][maxScale]" id="global_option_maxScale_mobileOpts" class="small" value="<?php echo @$global_options['mobileOpts']['maxScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the maximum viewport scale of the content, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="global_option_minScale_mobileOpts">Min Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="ilightbox_global_options[mobileOpts][minScale]" id="global_option_minScale_mobileOpts" class="small" value="<?php echo @$global_options['mobileOpts']['minScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the minimum viewport scale of the content, the default is <code>0.2</code>.</small>
								<hr>
								
								<label class="label" for="global_option_showTitle_mobileOpts">Show Title</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[mobileOpts][show_title]" class="onoffswitch-checkbox" id="global_option_showTitle_mobileOpts"<?php if(!@empty($global_options)) { if(@$global_options['mobileOpts']['show_title']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[mobileOpts][thumbnail]" class="onoffswitch-checkbox" id="ilightbox_mobileOpts_thumbnail"<?php if(!@empty($global_options)) { if(@$global_options['mobileOpts']['thumbnail']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="text" name="ilightbox_global_options[mobileOpts][thumbnails_maxWidth]" id="thumbnails_mobileOpts_maxWidth" class="small" value="<?php echo @$global_options['mobileOpts']['thumbnails_maxWidth']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum width of the thumbnails, the default is <code>120</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_mobileOpts_maxHeight">Thumbnails Max Height</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="ilightbox_global_options[mobileOpts][thumbnails_maxHeight]" id="thumbnails_mobileOpts_maxHeight" class="small" value="<?php echo @$global_options['mobileOpts']['thumbnails_maxHeight']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum height of the thumbnails, the default is <code>80</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetX_mobileOpts">Next Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[mobileOpts][nextOffsetX]" id="nextOffsetX_mobileOpts" class="small" value="<?php echo @$global_options['mobileOpts']['nextOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetY_mobileOpts">Next Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[mobileOpts][nextOffsetY]" id="nextOffsetY_mobileOpts" class="small" value="<?php echo @$global_options['mobileOpts']['nextOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetX_mobileOpts">Previous Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[mobileOpts][prevOffsetX]" id="prevOffsetX_mobileOpts" class="small" value="<?php echo @$global_options['mobileOpts']['prevOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetY_mobileOpts">Previous Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[mobileOpts][prevOffsetY]" id="prevOffsetY_mobileOpts" class="small" value="<?php echo @$global_options['mobileOpts']['prevOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="captionStart_mobileOpts">Caption Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[mobileOpts][captionStart]" class="onoffswitch-checkbox" id="captionStart_mobileOpts"<?php if(!@empty($global_options)) { if(@$global_options['mobileOpts']['captionStart']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								
								<select name="ilightbox_global_options[mobileOpts][captionShow]" id="global_option_captionShow_mobileOpts">
									<option value="touchstart"<?php if(@$global_options['mobileOpts']['captionShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['mobileOpts']['captionShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['mobileOpts']['captionShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing caption, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_captionHide_mobileOpts">Caption Hide Event</label>
								
								<select name="ilightbox_global_options[mobileOpts][captionHide]" id="global_option_captionHide_mobileOpts">
									<option value="touchstart"<?php if(@$global_options['mobileOpts']['captionHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['mobileOpts']['captionHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['mobileOpts']['captionHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding caption, the default is 'mouseleave'.</small>
								<hr>
								
								<label class="label" for="socialStart_mobileOpts">Social Buttons Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[mobileOpts][socialStart]" class="onoffswitch-checkbox" id="socialStart_mobileOpts"<?php if(!@empty($global_options)) { if(@$global_options['mobileOpts']['socialStart']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								
								<select name="ilightbox_global_options[mobileOpts][socialShow]" id="global_option_socialShow_mobileOpts">
									<option value="touchstart"<?php if(@$global_options['mobileOpts']['socialShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['mobileOpts']['socialShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['mobileOpts']['socialShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing social buttons, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_socialHide_mobileOpts">Social Buttons Hide Event</label>
								
								<select name="ilightbox_global_options[mobileOpts][socialHide]" id="global_option_socialHide_mobileOpts">
									<option value="touchstart"<?php if(@$global_options['mobileOpts']['socialHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['mobileOpts']['socialHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['mobileOpts']['socialHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding social buttons, the default is 'mouseleave'.</small>
								
							</div>
							
							<div class="section collapsed clearfix">
								<h3 class="title">Tablet Optimizations</h3>
								
								<label class="label" for="global_option_maxScale_tabletOpts">Max Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="ilightbox_global_options[tabletOpts][maxScale]" id="global_option_maxScale_tabletOpts" class="small" value="<?php echo @$global_options['tabletOpts']['maxScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the maximum viewport scale of the content, the default is <code>1</code>.</small>
								<hr>
								
								<label class="label" for="global_option_minScale_tabletOpts">Min Scale</label>
								<div class="ilightbox_ui_slider" data-max="10" data-min="0.1" data-step="0.05">
									<input type="text" name="ilightbox_global_options[tabletOpts][minScale]" id="global_option_minScale_tabletOpts" class="small" value="<?php echo @$global_options['tabletOpts']['minScale']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								<div class="clear"></div>
								<small>Sets the minimum viewport scale of the content, the default is <code>0.2</code>.</small>
								<hr>
								
								<label class="label" for="global_option_showTitle_tabletOpts">Show Title</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[tabletOpts][show_title]" class="onoffswitch-checkbox" id="global_option_showTitle_tabletOpts"<?php if(!@empty($global_options)) { if(@$global_options['tabletOpts']['show_title']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="checkbox" name="ilightbox_global_options[tabletOpts][thumbnail]" class="onoffswitch-checkbox" id="ilightbox_tabletOpts_thumbnail"<?php if(!@empty($global_options)) { if(@$global_options['tabletOpts']['thumbnail']) { echo " checked"; } } else { echo " checked"; } ?> />
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
									<input type="text" name="ilightbox_global_options[tabletOpts][thumbnails_maxWidth]" id="thumbnails_tabletOpts_maxWidth" class="small" value="<?php echo @$global_options['tabletOpts']['thumbnails_maxWidth']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum width of the thumbnails, the default is <code>120</code>.</small>
								<hr>
								
								<label class="label" for="thumbnails_tabletOpts_maxHeight">Thumbnails Max Height</label>
								
								<div class="ilightbox_ui_slider" data-max="500" data-min="0" data-step="1">
									<input type="text" name="ilightbox_global_options[tabletOpts][thumbnails_maxHeight]" id="thumbnails_tabletOpts_maxHeight" class="small" value="<?php echo @$global_options['tabletOpts']['thumbnails_maxHeight']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Sets a maximum height of the thumbnails, the default is <code>80</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetX_tabletOpts">Next Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[tabletOpts][nextOffsetX]" id="nextOffsetX_tabletOpts" class="small" value="<?php echo @$global_options['tabletOpts']['nextOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="nextOffsetY_tabletOpts">Next Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[tabletOpts][nextOffsetY]" id="nextOffsetY_tabletOpts" class="small" value="<?php echo @$global_options['tabletOpts']['nextOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines next window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetX_tabletOpts">Previous Offset X</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[tabletOpts][prevOffsetX]" id="prevOffsetX_tabletOpts" class="small" value="<?php echo @$global_options['tabletOpts']['prevOffsetX']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window X offset from browser edge, the default is <code>45</code>.</small>
								<hr>
								
								<label class="label" for="prevOffsetY_tabletOpts">Previous Offset Y</label>
								
								<div class="ilightbox_ui_slider" data-max="2000" data-min="-2000" data-step="1">
									<input type="text" name="ilightbox_global_options[tabletOpts][prevOffsetY]" id="prevOffsetY_tabletOpts" class="small" value="<?php echo @$global_options['tabletOpts']['prevOffsetY']; ?>" />
									<div class="ilightbox_slider_holder"><div class="ilightbox_slider_cursor"></div></div>
								</div>
								
								<div class="clear"></div>
								<small>Determines previous window Y offset from browser edge, the default is <code>0</code>.</small>
								<hr>
								
								<label class="label" for="captionStart_tabletOpts">Caption Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[tabletOpts][captionStart]" class="onoffswitch-checkbox" id="captionStart_tabletOpts"<?php if(!@empty($global_options)) { if(@$global_options['tabletOpts']['captionStart']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								
								<select name="ilightbox_global_options[tabletOpts][captionShow]" id="global_option_captionShow_tabletOpts">
									<option value="touchstart"<?php if(@$global_options['tabletOpts']['captionShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['tabletOpts']['captionShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['tabletOpts']['captionShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing caption, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_captionHide_tabletOpts">Caption Hide Event</label>
								
								<select name="ilightbox_global_options[tabletOpts][captionHide]" id="global_option_captionHide_tabletOpts">
									<option value="touchstart"<?php if(@$global_options['tabletOpts']['captionHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['tabletOpts']['captionHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['tabletOpts']['captionHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding caption, the default is 'mouseleave'.</small>
								<hr>
								
								<label class="label" for="socialStart_tabletOpts">Social Buttons Start</label>
								
								<div class="onoffswitch">
									<input type="checkbox" name="ilightbox_global_options[tabletOpts][socialStart]" class="onoffswitch-checkbox" id="socialStart_tabletOpts"<?php if(!@empty($global_options)) { if(@$global_options['tabletOpts']['socialStart']) { echo " checked"; } } else { echo " checked"; } ?> />
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
								
								<select name="ilightbox_global_options[tabletOpts][socialShow]" id="global_option_socialShow_tabletOpts">
									<option value="touchstart"<?php if(@$global_options['tabletOpts']['socialShow'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['tabletOpts']['socialShow'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['tabletOpts']['socialShow'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for showing social buttons, the default is 'mouseenter'.</small>
								<hr>
								
								<label class="label" for="global_option_socialHide_tabletOpts">Social Buttons Hide Event</label>
								
								<select name="ilightbox_global_options[tabletOpts][socialHide]" id="global_option_socialHide_tabletOpts">
									<option value="touchstart"<?php if(@$global_options['tabletOpts']['socialHide'] == 'touchstart') { echo " selected"; } ?>>touchstart</option>
									<option value="touchend"<?php if(@$global_options['tabletOpts']['socialHide'] == 'touchend') { echo " selected"; } ?>>touchend</option>
									<option value="itap"<?php if(@$global_options['tabletOpts']['socialHide'] == 'itap') { echo " selected"; } ?>>tap</option>
								</select>
								<div class="clear"></div>
								<small>Sets the event for hiding social buttons, the default is 'mouseleave'.</small>
								
							</div>
							
						</li>
						<li class="col span_1">
							<div class="section clearfix">
								<h3 class="title">Additional Styles</h3>
								<div class="description">Additional CSS styles</div>
								<textarea name="ilightbox_styles" id="ilightbox_styles"><?php echo htmlentities(stripslashes($this->ilightbox_get_option('ilightbox_styles')), ENT_QUOTES, 'UTF-8')?></textarea>
								<small>To create this code editor, use a plugin called CodeMirror, here is the official site: <a href="http://codemirror.net/" target="_blank">http://codemirror.net/</a>. Consider a donation</small>
							</div>
						</li>
					</ul> <!-- .item_listing -->
				</div> <!-- .row -->
				
			</form>
		</div>
	</div>
</div><!-- #ilightbox_admin_wrap -->