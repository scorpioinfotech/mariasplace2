<div class="wrap" id="ilightbox_admin_wrap">
	<div class="ilightbox_admin_content clearfix">
	<?php require_once('ilightbox_menu.php');?>
			<div>
				<div class="ilightbox_topbar clearfix">
					<div class="ilightbox_navbar">
						<div>
							<a href="#usage">Usage</a>
							<a href="#manage">Manage</a>
							<a href="#faq">FAQ</a>
							<a href="#changelog">Changelog</a>
							<a href="#credits">Credits</a>
						</div>
					</div>
				</div>
				
				<div class="ilightbox_documentation">
				<p>Thanks for purchasing iLightBox for WordPress. If you have any questions that are beyond the scope of this help page,
				you've found a bug, need new feature, or you just want me to show your website using this plugin,
				please feel free to email me via <a href="http://goo.gl/sDPAa">contact form</a> on my profile.</p>
				<p>To get notified about plugin updates or my new releases follow me on <a href="http://twitter.com/chawroka" target='_blank'>Twitter</a> or become a fan of <a href="https://facebook.com/iprofessionaldev" target='_blank'>my facebook page</a>.</p>

				<h1 id="usage">Usage</h1>
				<p>See the <a href="http://iprodev.com/ilightbox/documentation.html" target="_blank">jQuery documentation</a> for more on it, this section will cover just the WordPress approach.</p>
				<p>The easiest way to use iLightBox is by adding the attribute <code>rel="ilightbox"</code> to a link.</p>
				
				<textarea class="html"><a href="image.jpg" rel="ilightbox">Show image</a></textarea>
				
				<h3>Embedding</h3>
				<p>There are three ways to embed iLightBox into your site - using shortcode, using php function, or bind it on elements.</p>
				
				<h4>Shortcode</h4>
				<p>Use shortcode to insert the gallery.</p>
				<textarea class="css">[ilightbox id="7" columns="4" class="custom_class"][/ilightbox]</textarea>
				
				<p>To create an inline gallery use shortcode with some content.</p>
				<textarea class="css">[ilightbox id="7"]<b>Show Inline Gallery</b>[/ilightbox]</textarea>
				
				<p>To insert multiple galleries.</p>
				<textarea class="css">[ilightbox ids="0,1,2,3" columns="2"][/ilightbox]</textarea>
				
				<p>Use Gallery Shortcode to insert the gallery (Refer to <a href="http://codex.wordpress.org/Gallery_Shortcode" target="_blank">Gallery Shortcode</a>).</p>
				<textarea class="css">[gallery ids="729,732,731,720" order="DESC" orderby="ID" columns="4" size="medium" link="file"]</textarea>
				
				<h4>PHP Function</h4>
				<p>Use PHP function to insert the gallery.</p>
				<textarea class="php">&lt;?php echo get_ilightbox( array( "id" => 7, "columns" => 4, "class" => "custom_class" ) ); ?&gt;</textarea>
				<p class="description">OR</p>
				<textarea class="php">&lt;?php echo do_shortcode( '[ilightbox id="7" columns="4" class="custom_class"][/ilightbox]' ); ?&gt;</textarea>
				
				<p>To create an inline gallery use PHP function with content attribute.</p>
				<textarea class="php">&lt;?php echo get_ilightbox( array( "id" => 7 ), "<b>Show Inline Gallery</b>" ); ?&gt;</textarea>
				<p class="description">OR</p>
				<textarea class="php">&lt;?php echo do_shortcode( '[ilightbox id="7"]<b>Show Inline Gallery</b>[/ilightbox]' ); ?&gt;</textarea>
				
				<p>To insert multiple galleries via PHP function.</p>
				<textarea class="php">&lt;?php echo get_ilightbox( array( "ids" => "0,1,2,3", "columns" => 2 ) ); ?&gt;</textarea>
				<p class="description">OR</p>
				<textarea class="php">&lt;?php echo do_shortcode( '[ilightbox ids="0,1,2,3" columns="2"][/ilightbox]' ); ?&gt;</textarea>
				
				<h4>Bind</h4>
				<p>Attach a gallery to an event for the elements. For get more information about this option refer to <a href="http://api.jquery.com/bind/" target="_blank">jQuery Bind</a>.</p>
				
				<p><b>Bind</b> button available on thumbnails when the mouse is over on them.</p>
				
				<img src="<?php echo $this->ILIGHTBOX_URL."css/images/documentation/0.jpg"; ?>" />
				
				<p>To attach a gallery to <code>double click</code> event for the <code>document</code>:</p>
				
				<img src="<?php echo $this->ILIGHTBOX_URL."css/images/documentation/1.png"; ?>" />
				
				<p>To attach a gallery to <code>click</code> event for the site title link element:</p>
				
				<img src="<?php echo $this->ILIGHTBOX_URL."css/images/documentation/2.png"; ?>" />
				
				
				<h1 id="manage">Manage</h1>
				<p>Here are details about gallery options and fields.</p>
				
				<h3>GENERAL OPTIONS</h3>
				
				<div class="ilightbox_inner">
					<h4>Path</h4>
					<p>Sets path for switching windows, the default is <em>'vertical'</em>.</p>
					
					<h4>Skin <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the skin, the default is <em>'dark'</em>. Available skins are: <code>dark</code>, <code>light</code>, <code>parade</code>, <code>smooth</code>, <code>metro-black</code>, <code>metro-white</code> and <code>mac</code>.</p>
					
					<h4>Link ID <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the deeplinking id. This feature only works when you directly inserted the gallery.</p>
					
					<h4>Start From <div class="types"><span class="type type_number">number</span></div></h4>
					<p>The position to open within the elements, defaults to <code>0</code>.</p>
					
					<h4>Infinite <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the ability to infinite the group, the default is <code>OFF</code>.</p>
					
					<h4>Random Start <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>The random position to open within the elements, the default is <code>OFF</code>.</p>
					
					<h4>Keep Aspect Ratio <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the resizing method used to keep aspect ratio within the viewport, the default is <code>ON</code>.</p>
					
					<h4>Mobile Optimizer <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Make lightboxes optimized for giving better experience with mobile devices, the default is <code>ON</code>.</p>
					
					<h4>Max Scale <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the maximum viewport scale of the content, the default is <code>1</code>.</p>
					
					<h4>Min Scale <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the minimum viewport scale of the content, the default is <code>0.2</code>.</p>
					
					<h4>Inner Toolbar <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Bring buttons into windows, or let them be over the overlay with set to <code>ON</code>, the default is <code>OFF</code>.</p>
					
					<h4>Smart Recognition <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets content auto recognize from web pages, the default is <code>OFF</code>.</p>
					
					<h4>Fullscreen Viewport</h4>
					<p>Sets the resizing method used to fit content within the fullscreen mode.</p>
					
					<h4>Fullscreen Stretch Types <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the stretch resizing used to fit content within the fullscreen mode for specific content types. Possible values are: <code>image</code>, <code>video</code>, <code>flash</code>, <code>iframe</code>, <code>inline</code>, <code>ajax</code> and <code>html</code>. The default is '<code>flash, video</code>'.<br>Separate them by comma.</p>
					
					<h4>Show Title <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the titles of all slides will be visible or not, the default is <code>ON</code>.</p>
					
					<h4>Mobile Optimization <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>By turning on this option your custom optimizations for mobile devices will be apply, the default is <code>OFF</code>.</p>
					
					<h4>Tablet Optimization <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>By turning on this option your custom optimizations for tablet devices will be apply, the default is <code>OFF</code>.</p>
				</div>
				
				<h3>COMMANDS</h3>
				
				<div class="ilightbox_inner">
					<h4>Overlay Blur <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Determines whether or not clicking on the dimmed background of the page hides the iLightBox and removes the dim, the default is <code>ON</code>.</p>
					
					<h4>Toolbar <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets buttons be available or not, the default is <code>ON</code>.</p>
					
					<h4>Fullscreen <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the fullscreen button, the default is <code>ON</code>.</p>
					
					<h4>Arrow Buttons <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Enable the arrow buttons, the default is <code>OFF</code>.</p>
					
					<h4>Thumbnails <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the thumbnail navigation, the default is <code>ON</code>.</p>
					
					<h4>Keyboard <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the keyboard navigation, the default is <code>ON</code>.</p>
					
					<h4>Mouse Wheel <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the mousewheel navigation, the default is <code>ON</code>.</p>
					
					<h4>Swipe <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the swipe navigation, the default is <code>ON</code>.</p>
				</div>
				
				<h3>KEYBOARD</h3>
				
				<div class="ilightbox_inner">
					<h4>Left Key <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the <code>Left</code> key for keyboard navigation to moving to previous window, the default is <code>ON</code>.</p>
					
					<h4>Right Key <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the <code>Right</code> key for keyboard navigation to moving to next window, the default is <code>ON</code>.</p>
					
					<h4>Up Key <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the <code>Up</code> key for keyboard navigation to moving to previous window, the default is <code>ON</code>.</p>
					
					<h4>Down Key <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the <code>Down</code> key for keyboard navigation to moving to next window, the default is <code>ON</code>.</p>
					
					<h4>Esc Key <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the <code>Escape</code> key for keyboard navigation to close iLightBox, the default is <code>ON</code>.</p>
					
					<h4>Shift+Enter Key <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Sets the <code>Shift+Enter</code> key for keyboard navigation to enter fullscreen, the default is <code>ON</code>.</p>
				</div>
				
				<h3>STYLES</h3>
				
				<div class="ilightbox_inner">
					<h4>Overlay Opacity <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the opacity of the dimmed background of the page, the default is <code>0.85</code>.</p>
					
					<h4>Page Offset X <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines page X offset from browser edge, the default is <code>0</code>.</p>
					
					<h4>Page Offset Y <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines page Y offset from browser edge, the default is <code>0</code>.</p>
					
					<h4>Next Offset X <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines next window X offset from browser edge, the default is <code>45</code>.</p>
					
					<h4>Next Offset Y <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines next window Y offset from browser edge, the default is <code>0</code>.</p>
					
					<h4>Next Opacity <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines next window opacity, the default is <code>1</code>.</p>
					
					<h4>Next Scale <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines next window scale, the default is <code>1</code>.</p>
					
					<h4>Previous Offset X <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines previous window X offset from browser edge, the default is <code>45</code>.</p>
					
					<h4>Previous Offset Y <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines previous window Y offset from browser edge, the default is <code>0</code>.</p>
					
					<h4>Previous Opacity <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines previous window opacity, the default is <code>1</code>.</p>
					
					<h4>Previous Scale <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Determines previous window scale, the default is <code>1</code>.</p>
					
					<h4>Thumbnails Max Width <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets a maximum width of the thumbnails, the default is <code>120</code>.</p>
					
					<h4>Thumbnails Max Height <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets a maximum height of the thumbnails, the default is <code>80</code>.</p>
					
					<h4>Thumbnails Normal Opacity <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the opacity of the thumbnails, the default is <code>1</code>.</p>
					
					<h4>Active Thumbnail Opacity <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the opacity of the active window thumbnail, the default is <code>0.6</code>.</p>
				</div>
				
				<h3>EFFECTS</h3>
				
				<div class="ilightbox_inner">
					<h4>Show Effect <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Determines whether or not showing contents with effect, the default is <code>ON</code>.</p>
					
					<h4>Hide Effect <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Determines whether or not hiding contents with effect, the default is <code>ON</code>.</p>
					
					<h4>Reposition <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Determines whether or not browser resize with effect, the default is <code>ON</code>.</p>
					
					<h4>Show Speed <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the speed of the effect when showing contents, the default is <code>300</code>.</p>
					
					<h4>Hide Speed <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the speed of the effect when hiding contents, the default is <code>300</code>.</p>
					
					<h4>Reposition Speed <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the reposition effect speed, the default is <code>200</code>.</p>
					
					<h4>Switch Speed <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the speed for switching effect between windows, the default is <code>500</code>.</p>
					
					<h4>Loaded Fade Speed <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the fade effect speed for loaded contents, the default is <code>180</code>.</p>
					
					<h4>Fade Speed <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets the fade effect speed, the default is <code>200</code>.</p>
				</div>
				
				<h3>CAPTIONS</h3>
				
				<div class="ilightbox_inner">
					<h4>Start <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Determines whether or not display captions on window preview, the default is <code>ON</code>.</p>
					
					<h4>Show Event <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the event for showing caption, the default is <code>'mouseenter'</code>.</p>
					
					<h4>Hide Event <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the event for hiding caption, the default is <code>'mouseleave'</code>.</p>
					
				</div>
				
				<h3>SOCIALS</h3>
				
				<div class="ilightbox_inner">
					<h4>Start <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Determines whether or not display social buttons on window preview, the default is <code>ON</code>.</p>
					
					<h4>Show Event <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the event for showing social buttons, the default is <code>'mouseenter'</code>.</p>
					
					<h4>Hide Event <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the event for hiding social buttons, the default is <code>'mouseleave'</code>.</p>
					
					<h4>Buttons <div class="types"><span class="type type_object">object</span></div></h4>
					<p>Sets the social buttons.</p>
<textarea class="javascript">{
  facebook: true,
  twitter: true,
  googleplus: true,
  reddit: true,
  digg: true,
  delicious: true
}</textarea>

					<p>You can customize buttons in your personal way:</p>
<textarea class="javascript">{
  facebook: {
    URL: "http://example.com/path/",
    text: "Share it on your Timeline"
  },
  twitter: true
}</textarea>

					<p>And also you can add another custom button:</p>
<textarea class="javascript">{
  custom_button: {
    source: "http://example.com/share?url={URL}",
    text: "Share on Custom Button",
    width: 720,
    height: 420
  }
}</textarea>
					
				</div>
				
				<h3>SLIDESHOW</h3>
				
				<div class="ilightbox_inner">
					<h4>Enable <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Enable the slideshow feature and button, the default is <code>OFF</code>.</p>
					
					<h4>Pause Time <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Delay between cycles in milliseconds, the default is <code>5000</code>.</p>
					
					<h4>Pause On Hover <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>Whether to pause the cycling while the mouse is hovering over the lightboxes, the default is <code>OFF</code>.</p>
					
					<h4>Start Paused <div class="types"><span class="type type_boolean">boolean</span></div></h4>
					<p>When slideshow is enabled, this will start the iLightBox in paused mode, the default is <code>ON</code>.</p>
					
				</div>
				
				<h3>Callbacks</h3>
				
				<div class="ilightbox_inner">
					<h4>onAfterChange <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the window changes.</p>
<textarea class="javascript">function(api, position) {
  $(api.currentElement).css({ opacity: .5 });
  alert("You've reached position " + position);
}</textarea>
					
					<h4>onAfterLoad <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the content loads.</p>
<textarea class="javascript">function(api, position) {
  alert('Event "onAfterLoad" fired for item ' + position + '.');
}</textarea>
					
					<h4>onBeforeChange <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call before the window changes.</p>
<textarea class="javascript">function(api) {
  alert('Event "onBeforeChange" fired.');
}</textarea>
					
					<h4>onBeforeLoad <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call before the content loads.</p>
<textarea class="javascript">function(api, position) {
  alert('Event "onBeforeLoad" fired for item '+position+'.');
}</textarea>
					
					<h4>onEnterFullScreen <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the iLightBox enter to Fullscreen.</p>
<textarea class="javascript">function() {
  alert('Event "onEnterFullScreen" fired.');
}</textarea>
					
					<h4>onExitFullScreen <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the iLightBox exit from Fullscreen.</p>
<textarea class="javascript">function() {
  alert('Event "onExitFullScreen" fired.');
}</textarea>
					
					<h4>onHide <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the window hides.</p>
<textarea class="javascript">function() {
  alert('Event "onHide" fired.');
}</textarea>
					
					<h4>onOpen <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the iLightBox opens.</p>
<textarea class="javascript">function() {
  alert('Event "onOpen" fired.');
}</textarea>
					
					<h4>onRender <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the content renders.</p>
<textarea class="javascript">function(api, position) {
  alert('Event "onRender" fired for item ' + position + '.');
}</textarea>
					
					<h4>onShow <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the window comes into view.</p>
<textarea class="javascript">function(api, position) {
  $(api.currentElement).css({ 'background': '#C00' });
  alert('Event "onShow" fired for item ' + position + '.');
}</textarea>

				</div>
				
				<br><br>
				<hr>
				
				<h3>Manage your slides</h3>
				<p>On the right column, in this section, you can add your slides by clickig the "Add a slide" button.
				After adding a slide you can start customizing it.</p>
				
				<p>The first field is for adding source for slide. You can upload it or select it from the media library by using the camera thumbnail beside of the field.</p>
				
				<h3>OPTIONS</h3>
				
				<div class="ilightbox_inner">
					<h4>Link <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets a link to another URL for thumbnail.</p>
					
					<h4>Type <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Specifies the media type. Required when the type cannot be detected based on the urls file extension. 
					One of: <code>image</code>, <code>video</code>, <code>flash</code>, <code>iframe</code>, <code>inline</code>, <code>ajax</code> or <code>html</code></p>
					
					<h4>Thumbnail <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets a thumbnail image for use with the thumbnail controls. Images have a thumbnail based on their source image by default, this option can be used to set an alternative.
					For every other type this option will have to be set to generate a thumbnail.</p>
					
					<h4>Icon</h4>
					<p>It possible to set an icon type to overlay the thumbnail.</p>
					
					<h4>Caption <div class="types"><span class="type type_string">string</span><span class="type type_htmlelement">HTMLElement</span></div></h4>
					<p>The caption underneath the content.</p>
					
					<h4>Title <div class="types"><span class="type type_string">string</span><span class="type type_htmlelement">HTMLElement</span></div></h4>
					<p>The title above the window.</p>
					
					<h4>Skin <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the skin. Available skins are: <code>dark</code>, <code>light</code>, <code>parade</code>, <code>smooth</code>, <code>metro-black</code>, <code>metro-white</code> and <code>mac</code>.</p>
					
					<h4>Custom Class <div class="types"><span class="type type_string">string</span></div></h4>
					<p>Sets the custom class for thumbnail in gallery grid overlay.</p>
					
					<h4>Width <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets a maximum width of the content.</p>
					
					<h4>Height <div class="types"><span class="type type_number">number</span></div></h4>
					<p>Sets a maximum height of the content.</p>
					
					<h4>Fullscreen Viewport</h4>
					<p>Sets the resizing method used to fit content within the fullscreen mode.</p>
					
					<h4>Mouse Wheel</h4>
					<p>Enables or disables the mousewheel navigation, the default is <code>ON</code>.</p>
					
					<h4>Swipe</h4>
					<p>Enables or disables the swipe navigation, the default is <code>ON</code>.</p>
					
					<h4>Social Buttons <div class="types"><span class="type type_object">object</span></div></h4>
					<p>Sets the social buttons.</p>
<textarea class="javascript">{
  facebook: true,
  twitter: true,
  googleplus: true,
  reddit: true,
  digg: true,
  delicious: true
}</textarea>

					<p>You can customize buttons in your personal way:</p>
<textarea class="javascript">{
  facebook: {
    URL: "http://example.com/path/",
    text: "Share it on your Timeline"
  },
  twitter: true
}</textarea>

					<p>And also you can add another custom button:</p>
<textarea class="javascript">{
  custom_button: {
    source: "http://example.com/share?url={URL}",
    text: "Share on Custom Button",
    width: 720,
    height: 420
  }
}</textarea>
					
					<h4>Ajax <div class="types"><span class="type type_object">object</span></div></h4>
					<p>Allows extra options to be set when using ajax as your media type. For get more information about this option refer to <a href="http://api.jquery.com/jQuery.ajax/" target="_blank">jQuery.ajax()</a>.</p>
<textarea class="javascript">{
  type: 'post',
  data: { id: 14, page: 7 }
}</textarea>
<textarea class="javascript">{ data: 'id=14&page=7' }</textarea>

					<h4>HTML5 Video <div class="types"><span class="type type_object">object</span></div></h4>
					<p>Allows extra options to be set when using HTML5 Video.</p>
<textarea class="javascript">{
  h264: '/path/video.mp4',
  webm: '/path/video.webm',
  ogg: '/path/video.ogg',
  poster: '/path/video-poster.jpg',
  controls: false,
  autoplay: true,
  preload: 'auto'
}</textarea>
					
					<h4>Flashvars <div class="types"><span class="type type_object">object</span></div></h4>
					<p>Sets flashvars on a flash movie using key/value pairs.</p>
<textarea class="javascript">{
  file: 'video.mp4',
  autostart: true
}</textarea>
					
					<h4>HTML <div class="types"><span class="type type_htmlelement">HTMLElement</span></div></h4>
					<p>Sets HTML Contents when you choose HTML type.</p>
<textarea class="html"><div class="center">
  <h2>
    <img src="http://iprodev.com/ilightbox/assets/img/smile.gif">
    It's time to upgrade.
  </h2>
  <hr>
  <p>iLightBox supports DOM elements created on the fly.</p>
</div></textarea>
					
					<h4>onAfterLoad <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the content loads.</p>
<textarea class="javascript">function(api) {
  $(api.element).css({ opacity: .5 });
  alert("You've reached position " + api.position);
}</textarea>
					
					<h4>onBeforeLoad <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call before the content loads.</p>
<textarea class="javascript">function(api) {
  alert('Event "onBeforeLoad" fired for item '+api.position+'.');
}</textarea>
					
					<h4>onRender <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the content renders.</p>
<textarea class="javascript">function(api) {
  alert('Event "onRender" fired for item '+api.position+'.');
}</textarea>
					
					<h4>onShow <div class="types"><span class="type type_function">function</span></div></h4>
					<p>A function to call when the window comes into view.</p>
<textarea class="javascript">function(api) {
  $(api.element).css({ 'background': '#C00' });
  alert('Event "onShow" fired for item '+api.position+'.');
}</textarea>

				</div>
				
				
				<h1 id="faq">FAQ</h1>
				
				<ol class="ol">
					<li>
						<strong>Can I use this script on my client's website?</strong>
						<p>Yes. Your license includes the rights to use the script on a website (commercial, personal, client), or intranet site project.</p>
						<hr>
					</li>
					<li>
						<strong>Can I make modifications to this script?</strong>
						<p>Feel free to make any modifications you need. Also feel free to blog about it and show your friends, but please do not redistribute the script with your changes.</p>
						<hr>
					</li>
					<li>
						<strong>Why the script doesn't work?</strong>
						<p>If you get javascript error, similiar to - <code>Object [object Object] has no method iLightBox</code>, so very likely you've got two or more jQuery scripts on one page, one of your plugins or theme itself is adding it incorrectly. jQuery in WordPress should be added only with <code>wp_enqueue_script('jquery');</code>.</p>
						<hr>
					</li>
					<li>
						<strong>iLightBox is positioned incorrectly or behaving strangely in Internet Explorer</strong>
						<p>This is likely a doctype issue. This plugin requires a valid doctype and rendering in quirks mode is not supported.
						Make sure you are using the full doctype declaration to insure rendering in standards mode.</p>
						
						<p>This abbreviated doctype renders the document in quirks mode for Internet Explorer:</p>
						
						<textarea class="html">&lt;!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"&gt;</textarea>
						
						<p>The doctype with URI renders in standards mode for all browsers:</p>
						
						<textarea class="html">&lt;!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"&gt;</textarea>
						
						<p>I recommend using the <a href="http://dev.w3.org/html5/spec/syntax.html#the-doctype" target="_blank">HTML5 doctype</a>.</p>
						<hr>
					</li>
					<li>
						<strong>How I can use JW Player to play MP4 files?</strong>
						<p>Upload and select the player SWF file in new slide then use this code in <code>Flashvars</code>:</p>
						
						<textarea class="javascript">{ file: 'movie.mp4', image: 'preview.jpg', stretching: 'exactfit' }</textarea>
						
						<p>Where:</p>
						
<textarea class="html">movie.mp4 = URL of the movie file
preview.jpg = URL of the movie preview image file</textarea>
						<hr>
					</li>
					<li>
						<strong>How I can create HTML5 Video Cross-Browser Support?</strong>
						<p>Upload and select the movie MP4 file in new slide then use this code in <code>HTML5 Video</code> field:</p>
						
						<textarea class="javascript">{ webm: 'movie.webm', poster: 'poster.jpg' }</textarea>
						
						<p>Where:</p>
						
<textarea class="html">movie.webm = URL of the webm format of the movie file
poster.jpg = URL of the movie poster image file</textarea>
						<hr>
					</li>
					<li>
						<strong>Why image gallery shows only 45 images?</strong>
						<p>You need increase <code>max_input_vars</code> in your php configuration at least to 10000.</p>
					</li>
					<li>
						<strong>Why when the iLighBox opens, the page moves to right?</strong>
						<p>It's because iLightBox will remove the scrollbar when its opens. If you want to disable this feature you need to go to ilightbox plugin folder in your WP plugins folder and open <code>css/src/css/ilightbox.css</code> file then remove below code:</p>

<textarea class="css">.ilightbox-noscroll {
    overflow: hidden;
}</textarea>
					</li>
					<li>
						<strong>How can i group image links that i added to posts?</strong>
						<p>You need to use <code>rel="ilightbox[groupname]"</code> attribute. You need to use unique group name for each lightbox group. e.g.</p>
						
<textarea class="html"><a href="IMAGE.JPG" rel="ilightbox[GROUPNAME]">Image 1</a>
<a href="IMAGE.JPG" rel="ilightbox[GROUPNAME]">Image 2</a></textarea>
						
						<p>Where:</p>
						
<textarea class="html">IMAGE.JPG = The URL of the image file
GROUPNAME = The name of grouped lightboxes</textarea>
					</li>
				</ol>
				
				
				<h1 id="changelog">Changelog</h1>
				
				<ul class="noBull clearfix">
					<li class="clearfix">
						<span class="counter">1.5.3:</span>
						<span class="description">
							<strong>Fixed:</strong> Uninstalling function.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.5.2:</span>
						<span class="description">
							<strong>Fixed:</strong> Multiple file upload.<br>
							<strong>Fixed:</strong> Errors in debug mode.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.5.1:</span>
						<span class="description">
							<strong>Added:</strong> NextGEN Gallery compatibility.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.5.0:</span>
						<span class="description">
							<strong>Optimized:</strong> Ajax actions.<br>
							<strong>Optimized:</strong> Multiple file upload and insert media.<br>
							<strong>Added:</strong> iLightBox jQuery version 2.1.5.<br>
							<strong>Added:</strong> Jetpack compatibility.<br>
							<strong>Added:</strong> Multisite compatibility.<br>
							<strong>Added:</strong> <code>Use Configuration Options</code> to galleries to use options from configurations page as default options for galleries.<br>
							<strong>Fixed:</strong> Some bugs behaviour server configurations.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.4.0:</span>
						<span class="description">
							<strong>Added:</strong> iLightBox jQuery version 2.1.0.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.3.7:</span>
						<span class="description">
							<strong>Added:</strong> iLightBox jQuery version 2.0.2.<br>
							<strong>Added:</strong> <code>Fullscreen One Slide</code> option.<br>
							<strong>Fixed:</strong> Configurations page saving settings.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.3.6:</span>
						<span class="description">
							<strong>Fixed:</strong> Inline gallery shortcode.<br>
							<strong>Fixed:</strong> Inline gallery shortcode binder.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.3.5:</span>
						<span class="description">
							<strong>Optimized:</strong> Mobile & Tablet Optimizations.<br>
							<strong>Added:</strong> iLightBox jQuery version 2.0.<br>
							<strong>Added:</strong> <code>Custom Class</code> option.<br>
							<strong>Added:</strong> <code>ids</code> attribute for shortcode to insert multiple galleries.<br>
							<strong>Fixed:</strong> ADDITIONAL STYLES option.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.3.3:</span>
						<span class="description">
							<strong>Added:</strong> <code>Mobile Optimization</code> option.<br>
							<strong>Added:</strong> Shortcode accept in HTML field.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.3.2:</span>
						<span class="description">
							<strong>Added:</strong> iLightBox jQuery version 1.4.1.<br>
							<strong>Fixed:</strong> Import media bug.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.3.1:</span>
						<span class="description">
							<strong>Optimized:</strong> UTF-8 Globalization.<br>
							<strong>Added:</strong> iLightBox jQuery version 1.4.0.<br>
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.3.0:</span>
						<span class="description">
							<strong>Optimized:</strong> Creating new gallery.<br>
							<strong>Optimized:</strong> Native gallery shortcode.<br>
							<strong>Fixed:</strong> Insert new slide.
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.2.9:</span>
						<span class="description">
							<strong>Optimized:</strong> Some security essentials.<br>
							<strong>Added:</strong> Multiple file uploader.<br>
							<strong>Added:</strong> Admin bar menu.<br>
							<strong>Added:</strong> Native support for Gallery Shortcode.<br>
							<strong>Added:</strong> Live preview button for thumbnails.<br>
							<strong>Added:</strong> <code>Enable on Videos Links</code> option.<br>
							<strong>Added:</strong> <code>Enable on Video Pages Links</code> option.<br>
							<strong>Added:</strong> <code>Enable on Gallery Shortcode</code> option.<br>
							<strong>Fixed:</strong> Conflict scripts and styles with other plugins.<br>
							<strong>Fixed:</strong> Some bugs in jQuery 1.7.x.<br>
							<strong>Fixed:</strong> Some bugs in Configurations.<br>
							<strong>Fixed:</strong> Gallery in feed page.<br>
							
							<hr>
						</span>
					</li>
					<li class="clearfix">
						<span class="counter">1.0:</span>
						<span class="description">Initial release of iLightBox WordPress.</span>
					</li>
				</ul>
				
				<h1 id="credits">Credits</h1>
				
				<ul class="noBull2 clearfix">
					<li class="clearfix">
						<span class="name">jQuery</span>
						<span class="description">jQuery is a fast, small, and feature-rich JavaScript library. Here is the official site: <a href="http://jquery.com/" target="_blank">http://jquery.com/</a>.<hr></span>
					</li>
					<li class="clearfix">
						<span class="name">jQuery UI</span>
						<span class="description">jQuery UI is a curated set of user interface interactions, effects, widgets, and themes built on top of the jQuery JavaScript Library. Here is the official site: <a href="http://jqueryui.com/" target="_blank">http://jqueryui.com/</a>.<hr></span>
					</li>
					<li class="clearfix">
						<span class="name">jQuery Easing Plugin</span>
						<span class="description">A jQuery plugin from <a class="notag" href="http://gsgd.co.uk/" target="_blank">GSGD</a> to give advanced easing options. Here is the official site: <a href="http://gsgd.co.uk/sandbox/jquery/easing/" target="_blank">http://gsgd.co.uk/sandbox/jquery/easing/</a>. Consider a donation please<hr></span>
					</li>
					<li class="clearfix">
						<span class="name">CodeMirror</span>
						<span class="description">CodeMirror is a JavaScript component that provides a code editor in the browser. Here is the official site: <a href="http://codemirror.net/" target="_blank">http://codemirror.net/</a>. Consider a donation please<hr></span>
					</li>
					<li class="clearfix">
						<span class="name">Fine Uploader</span>
						<span class="description">The Fine Uploader attempts to achieve a user-friendly file-uploading experience over the web.. Here is the official site: <a href="http://fineuploader.com/" target="_blank">http://fineuploader.com/</a>. Consider a donation please<hr></span>
					</li>
					<li class="clearfix">
						<span class="name">URI.js</span>
						<span class="description">URI.js is a javascript library for working with URLs. Here is the official site: <a href="http://medialize.github.com/URI.js/" target="_blank">http://medialize.github.com/URI.js/</a>.<hr></span>
					</li>
					<li class="clearfix">
						<span class="name">$.serializeObject</span>
						<span class="description"><code>$.serializeObject</code> is a variant of existing <code>$.serialize</code> method which, instead of encoding form elements to string, converts form elements to a valid JSON object which can be used in your JavaScript application. Here is the official site: <a href="https://github.com/hongymagic/jQuery.serializeObject" target="_blank">https://github.com/hongymagic/jQuery.serializeObject</a>.</span>
					</li>
					<li class="clearfix">
						<span class="name">PHP Mobile Detect</span>
						<span class="description"><code>PHP Mobile Detect</code> The lightweight PHP class for detecting mobile devices. Here is the official site: <a href="http://mobiledetect.net/" target="_blank">http://mobiledetect.net/</a>.</span>
					</li>
				</ul>
				
				<br><br><br>
				
				
				</div>
			</div>
		</div>
	</div>
</div><!-- #ilightbox_admin_wrap -->