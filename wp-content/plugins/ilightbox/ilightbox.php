<?php 

class iLightBox {
	/**
	* iLightBox version
	*
	* @var string
	*/
	var $VERSION = '1.5.3';

	/**
	* iLightBox name
	*
	* @var string
	*/
	var $ILIGHTBOX_NAME = 'iLightBox';

	/**
	* iLightBox jQuery version
	*
	* @var string
	*/
	var $JQUERY_VERSION = '2.1.5';

	/**
	* iLightBox Main file
	*
	* @var string
	*/
	var $MAIN;

	/**
	* iLightBox Main Options
	*
	* @var string
	*/
	var $OPTIONS;

	/**
	* iLightBox URL
	*
	* @var string
	*/
	var $ILIGHTBOX_URL;

	/**
	* iLightBox path
	*
	* @var string
	*/
	var $ILIGHTBOX_PATH;


	function __construct($file) {
		$this->MAIN = $file;
		$this->ILIGHTBOX_URL = plugin_dir_url( $this->MAIN );
		$this->ILIGHTBOX_PATH = plugin_dir_path( $this->MAIN );
		$this->init();
		return $this;
	}
	
	function init() {
		register_activation_hook( $this->MAIN , array($this, 'activate') );
		register_deactivation_hook( $this->MAIN , array($this, 'uninstall') );

		add_action('init', array($this, 'ilightbox_register_scripts'));

		if ( is_admin() ) {
			add_action('admin_print_styles', array($this, 'ilightbox_admin_styles'));
			add_action('admin_enqueue_scripts', array($this, 'ilightbox_admin_enqueue_scripts'));
			add_action('admin_head', array($this, 'admin_head'));
			add_filter( 'tiny_mce_version', array($this, 'ilightbox_refresh_mce'));
			add_action('admin_menu', array($this, 'ilightbox_add_menu'));
			//add_action('network_admin_menu', array($this, 'ilightbox_add_menu'));
			add_action( 'wp_before_admin_bar_render', array($this, 'ilightbox_admin_bar_render') );
			add_action( 'admin_head', array($this, 'ilightbox_menu_style') );
			add_action('wp_ajax_ilightbox_actions', array($this, 'ajax_handler'));
			add_action('init', array($this, 'ilightbox_sc_button'));
		} else {
			add_shortcode("ilightbox", array($this, 'ilightbox_shortcode'));
			if($this->ilightbox_get_option('ilightbox_gallery_shortcode') == "true") {
				add_filter('gallery_style', array($this, 'ilightbox_gallery_style_filter'), 10);
			}
			add_action('wp_head', array($this, 'ilightbox_enqueue_head'));
			add_action('wp_footer', array($this, 'ilightbox_bindeds_footer'));
		}
	}


	/**
	* Check the WordPress version
	*/
	function is_version( $version = '3.5' ) {
		global $wp_version;
		return version_compare( $wp_version, $version, '>=' );
	}

	/**
	* Check the Multisite
	*/
	function is_multisite() {
		global $wpmu_version;
		if (function_exists('is_multisite'))
		if (is_multisite()) return true;
		if (!empty($wpmu_version)) return true;
		return false;
	}


	/**
	* Activate iLightBox
	*/
	function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . "ilightbox";
		$charset_collate = '';
		if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}

		if( !$wpdb->get_var( "SHOW TABLES LIKE '" . $table_name . "'" ) ) {
		  
			$sql = "CREATE TABLE " . $table_name . " (
			name VARCHAR(255) NOT NULL ,
			value LONGTEXT
			) $charset_collate;";

		   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		   dbDelta($sql);
		}

		$this->OPTIONS = array (
			array( "id" => "ilightbox_added_galleries",
			"std" => array()),
			array( "id" => "ilightbox_jetpack",
			"std" => 'true'),
			array( "id" => "ilightbox_nextgen",
			"std" => 'true'),
			array( "id" => "ilightbox_bindeds",
			"std" => array()),
			array( "id" => "ilightbox_auto_enable",
			"std" => 'true'),
			array( "id" => "ilightbox_auto_enable_videos",
			"std" => 'true'),
			array( "id" => "ilightbox_auto_enable_video_sites",
			"std" => 'true'),
			array( "id" => "ilightbox_gallery_shortcode",
			"std" => 'true'),
			array( "id" => "ilightbox_global_options",
			"std" => array(
				'keepAspectRatio' => "on",
				'mobileOptimizer' => "on",
				'overlayBlur' => "on",
				'toolbar' => "on",
				'fullscreen' => "on",
				'thumbnail' => "on",
				'keyboard' => "on",
				'mousewheel' => "on",
				'swipe' => "on",
				'left' => "on",
				'right' => "on",
				'up' => "on",
				'down' => "on",
				'esc' => "on",
				'shift_enter' => "on",
				'show_effect' => "on",
				'hide_effect' => "on",
				'reposition' => "on",
				'startPaused' => "on"
			)),
			array( "id" => "ilightbox_styles",
			"std" => '/*iLightBox additional styles*/'),
			array( "id" => "ilightbox_delete_table",
			"std" => 'false')
		);

		$this->ilightbox_add_general();

		if(get_option( "thumbnail_size_w" ) < 200) update_option( "thumbnail_size_w", 200 );
		if(get_option( "thumbnail_size_h" ) < 200) update_option( "thumbnail_size_h", 200 );

		return true;
	}


	/**
	* Uninstall iLightBox
	*/
	function uninstall() {
		global $wpdb;
		$table_name = $wpdb->prefix . "ilightbox";

		if ($this->ilightbox_get_option('ilightbox_delete_table')=='true'){
			$wpdb->query("DROP TABLE IF EXISTS " . $table_name );
		}
	}
	
	function ilightbox_add_option($name, $value) {
		global $wpdb;
		$wpdb->ilightbox = $wpdb->prefix . 'ilightbox';
		$value = maybe_serialize( $value );
		$wpdb->insert( $wpdb->ilightbox, array('name'=>$name,'value'=>$value) );
	}

	function ilightbox_get_option($name) {
		global $wpdb;
		$wpdb->ilightbox = $wpdb->prefix . 'ilightbox';
		$row = $wpdb->get_row("SELECT * FROM $wpdb->ilightbox WHERE name = '$name'", ARRAY_A);

		require (ABSPATH . WPINC . '/pluggable.php');
		global $current_user, $display_name;
		get_currentuserinfo();
			
		if($row['name']=='') {
			return false;
		} else {
			$results = $wpdb->get_results("SELECT value FROM $wpdb->ilightbox WHERE name = '$name'");
			foreach ( $results as $result ) 
			{
				$return = maybe_unserialize($result->value);
			}


			return $return;
		}
		
	}

	function ilightbox_update_option($name, $value) {
		global $wpdb;
		$wpdb->ilightbox = $wpdb->prefix . 'ilightbox';
		$value = maybe_serialize( $value );
		$wpdb->update( $wpdb->ilightbox, array( 'value' => $value ), array( 'name' => $name ) );
	}

	function ilightbox_delete_option($name) {
		global $wpdb;
		$wpdb->ilightbox = $wpdb->prefix . 'ilightbox';
		$wpdb->query( "DELETE FROM $wpdb->ilightbox WHERE name = '$name'" );
	}

	/*=========================================================================================*/

	function ilightbox_admin_styles() {
		$plugin_version = $this->ilightbox_plugin_get_version();
		if(isset($_GET['page']) && strpos($_GET['page'], 'ilightbox')!==false){
		
			$deregister_styles = "fineuploader,codemirror,jquery-ui";
			$explode = explode(",", $deregister_styles);
			$wp_version = get_bloginfo( 'version' );
			
			foreach ($explode as $key => $value) {
				wp_deregister_style( $value );
				if($wp_version >= 3.1) wp_dequeue_style( $value );
			}
		
			if($_SERVER['HTTP_HOST'] != 'localhost') wp_enqueue_style("open-sans-font", "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700");
			if($_SERVER['HTTP_HOST'] != 'localhost') wp_enqueue_style("open-sans-font", "https://fonts.googleapis.com/css?family=Droid+Serif:400italic");
			wp_enqueue_style("ilightbox-css", $this->ILIGHTBOX_URL."css/ilightbox.css", false, $plugin_version, "all");
			wp_enqueue_style("fineuploader", $this->ILIGHTBOX_URL."css/fineuploader.css", false, '3.2', "all");
			wp_enqueue_style("ilightbox", $this->ILIGHTBOX_URL."css/src/css/ilightbox.css", false, $this->JQUERY_VERSION, "all");
			wp_enqueue_style("codemirror", $this->ILIGHTBOX_URL."css/codemirror.css", false, $plugin_version, "all");
			wp_enqueue_style("jquery-ui", $this->ILIGHTBOX_URL."css/jquery-ui.css", false, '1.9.2', "all");
		}
	}

	/*=========================================================================================*/

	function ilightbox_admin_enqueue_scripts() {
		if(isset($_GET['page']) && strpos($_GET['page'], 'ilightbox')!==false){
		
			$deregister_styles = "jquery.livequery,jquery.migrate,modernizer,codemirror,codemirror-matchbrackets,codemirror-closetag,codemirror-xml,codemirror-javascript,codemirror-css,codemirror-clike,codemirror-php,codemirror-htmlmixed,jquery-ui,jquery.placeholder,fineuploader";
			$explode = explode(",", $deregister_styles);
			$wp_version = get_bloginfo( 'version' );
			
			foreach ($explode as $key => $value) {
				wp_deregister_script( $value );
				if($wp_version >= 3.1) wp_dequeue_script( $value );
			}
			
			
			// This function loads in the required media files for the media manager.
			if ($this->is_version()) {
				wp_enqueue_media();
			}
			
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery.migrate', plugins_url( '/scripts/jquery.migrate.min.js', $this->MAIN ), array('jquery'), '1.2.1');
			wp_enqueue_script('jquery.livequery', plugins_url( '/scripts/jquery.livequery.js', $this->MAIN ), array('jquery'), '1.0.3');
			wp_enqueue_script('modernizer', plugins_url( '/scripts/modernizr.js', $this->MAIN ), array('jquery'));
			wp_enqueue_script('codemirror', plugins_url( '/scripts/codemirror/codemirror.js', $this->MAIN ), array('jquery'));
			wp_enqueue_script('codemirror-matchbrackets', plugins_url( '/scripts/codemirror/matchbrackets.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('codemirror-closetag', plugins_url( '/scripts/codemirror/closetag.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('codemirror-xml', plugins_url( '/scripts/codemirror/xml.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('codemirror-javascript', plugins_url( '/scripts/codemirror/javascript.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('codemirror-css', plugins_url( '/scripts/codemirror/css.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('codemirror-clike', plugins_url( '/scripts/codemirror/clike.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('codemirror-php', plugins_url( '/scripts/codemirror/php.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('codemirror-htmlmixed', plugins_url( '/scripts/codemirror/htmlmixed.js', $this->MAIN ), array('codemirror'));
			wp_enqueue_script('ilightbox');
			wp_enqueue_script('jquery-ui', plugins_url( '/scripts/jquery-ui.min.js', $this->MAIN ), array('jquery'), '1.9.2');
			wp_enqueue_script('jquery.placeholder', plugins_url( 'scripts/jquery.placeholder.min.js', $this->MAIN ), array('jquery'), '2.1.0');
			wp_enqueue_script('fineuploader', plugins_url( '/scripts/fineuploader.min.js', $this->MAIN ), array('jquery'), '3.2');
			wp_enqueue_script('ilightbox-admin', plugins_url( '/scripts/admin.js', $this->MAIN ), array('jquery'), $this->VERSION);
		
			global $blog_id;

			$max_upload = (int)(ini_get('upload_max_filesize'));
			$max_post = (int)(ini_get('post_max_size'));
			$memory_limit = (int)(ini_get('memory_limit'));
			$upload_mb = min($max_upload, $max_post, $memory_limit);
			
			wp_localize_script( 'ilightbox-admin', 'ILIGHTBOX', array(					
								'uploadLimit' => ($upload_mb * 1024 * 1024),
								'regularGallery' => $this->ilightbox_get_option('ilightbox_gallery_shortcode'),
								'pluginURL' => $this->ILIGHTBOX_URL,
								'blogURL' => get_bloginfo('url'),
								'ajaxURL' => admin_url( 'admin-ajax.php' ),
								'wpMedia' => $this->is_version()
			));
		} else {
			wp_enqueue_script('jquery.migrate');
		}
	}

	/*=========================================================================================*/

	function admin_head() {
		echo '<script type="text/javascript">var ILIGHTBOX_DIR = "'.$this->ILIGHTBOX_URL.'";</script>';

		if(isset($_GET['page']) && strpos($_GET['page'], 'ilightbox')!==false){
			echo '<link id="site_url" data-url="'.site_url().'" />';
			echo '<link id="admin_url" data-url="'.get_admin_url().'" />';
		}
	}
				
	/*=========================================================================================*/

	function ilightbox_attachment_id_from_src($image_src) {
		global $wpdb;
		$query = "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value='$image_src'";
		$id = $wpdb->get_var($query);
		return $id;
	}

	/*=========================================================================================*/

	function _get_ilightbox( $atts, $content = null ) {

		extract(shortcode_atts(array(
			'id'		=> 0,
			'ids'		=> '',
			'class'		=> '',
			'columns'	=> 3
		), $atts));
		
		$galleries = $this->ilightbox_get_option('ilightbox_added_galleries');
		$out = "";
		
		if($content){
			$gallery = $galleries[$id];
			$slides = $gallery['slides'];
			
			if(!is_feed() && $slides){
				$slides_out = $this->ilightbox_generate_slides($gallery);
				$options_out = $this->ilightbox_generate_options($gallery);
				$options_out = ($options_out) ? ' data-options="'.base64_encode(rawurlencode($options_out)).'"' : '';
				$out .= '<a class="ilightbox_inline_gallery'. (($class) ? ' '.$class : '') .'" id="ilightbox_inline_'.$id.'" data-slides="'.base64_encode(rawurlencode($slides_out)).'"'.$options_out.'>';
				$out .= $content;
				$out .= '</a><!-- .ilightbox_inline_gallery -->';
			} else $out = $content;
		} else {

			if($ids) {
				if ( !is_feed() ) {
					$ids = $this->ilightbox_plugin_array_filter(array_map('trim', explode(",", $ids)));
					if( !empty($ids) ){
						$out .= '<div class="ilightbox_clear"></div><!-- .ilightbox_clear -->
						<div id="ilightbox_'.$id.'" class="ilightbox_wrap ilightbox_gallery'. (($class) ? ' '.$class : '') .'"><ul>';
						
						$columns = intval($columns);
						$itemwidth = ($columns > 0 ? floor(100/$columns) : 100) - 3.3;
						$float = is_rtl() ? 'right' : 'left';
				
						foreach($ids as $key => $id){
							$gallery = @$galleries[$id];
							
							if( empty($gallery) ) continue;
							
							$slide = $gallery['slides']['0'];
							$slides_out = $this->ilightbox_generate_slides($gallery);
							$options_out = $this->ilightbox_generate_options($gallery);
							$options_out = ($options_out) ? ' data-options="'.base64_encode(rawurlencode($options_out)).'"' : '';

							$out .= '<li style="width: '.$itemwidth.'%; float: '.$float.'"><a class="ilightbox_inline_gallery" id="ilightbox_inline_'.$id.'" data-slides="'.base64_encode(rawurlencode($slides_out)).'"'.$options_out.'>';
							$out .= '<img src="'.$slide['thumbnail'].'" />';
							$out .= '</a></li>';

						}

						$out .= '</ul><div class="ilightbox_clear"></div><!-- .ilightbox_clear -->
						</div><!-- .ilightbox_wrap -->';
					} else return '';
				}
				else return '';
			} else {
				$gallery = $galleries[$id];
				$options = $this->ilightbox_generate_options($gallery, "global", true);
				$opts = $options ? ' data-options="'.$options.'"' : "";
				$slides = $gallery['slides'];
			
				if ( is_feed() ) {
					foreach($slides as $key => $slide){
						$att_id = ilightbox_attachment_id_from_src(str_replace(site_url("/wp-content/uploads/"), "", $slide['source']));
						$out .= wp_get_attachment_link($att_id, 'thumbnail', true) . "\n";
					}
					return $out;
				}
				
				$columns = intval($columns);
				$itemwidth = ($columns > 0 ? floor(100/$columns) : 100) - 3.3;
				$float = is_rtl() ? 'right' : 'left';
				
				if($slides){
					$out .= '<div class="ilightbox_clear"></div><!-- .ilightbox_clear -->
					<div id="ilightbox_'.$id.'" class="ilightbox_wrap ilightbox_gallery'. (($class) ? ' '.$class : '') .'"'.$opts.'><ul>';

					foreach($slides as $key => $slide){

						$source = @$slide['source'];
						$link = (@$slide['link']) ? $slide['link'] : $source;
						$caption = (@$slide['caption']) ? " data-caption='".htmlentities(stripslashes($slide['caption']), ENT_QUOTES, 'UTF-8')."'" : "";
						$title = (@$slide['title']) ? " data-title='".htmlentities(stripslashes($slide['title']), ENT_QUOTES, 'UTF-8')."'" : "";
						$type = (@$slide['type']) ? " data-type='".$slide['type']."'" : "";
						$custom_class = trim(@$slide['class']);
						$options = $this->ilightbox_generate_options($slide, "inline", true);
						$opts = ($options) ? ' data-options="'.substr($options, 1, -1).'"' : "";
						$out .= '<li style="width: '.$itemwidth.'%; float: '.$float.'"'. (($custom_class) ? '  class="'.$custom_class.'"' : '') .'><a href="'.$link.'" source="'.$source.'"'.$caption.''.$title.''.$type.''.$opts.'>';
						$out .= '<img src="'.@$slide['thumbnail'].'" />';
						$out .= '</a></li>';

					}


					$out .= '</ul><div class="ilightbox_clear"></div><!-- .ilightbox_clear -->
					</div><!-- .ilightbox_wrap -->';
				}
			}
		}
		
	   return $out;
	}



	function ilightbox_shortcode( $atts, $content = null ) {
		return $this->_get_ilightbox( $atts, $content );
	}



	function ilightbox_attachment_link_filter($val, $id, $size) {
		$id = intval( $id );
		$_post = get_post( $id );
			
		$attach_url = wp_get_attachment_url( $_post->ID );
		
		$thumbnail = wp_get_attachment_image_src( $id, 'thumbnail' );
		
		$xml = new DOMDocument();
		$xml->loadXML($val); 
		$first = $xml->firstChild;
		$sourceAttribute = $xml->createAttribute('source');
		$sourceAttribute->value = $attach_url;
		$optionsAttribute = $xml->createAttribute('data-options');
		$optionsAttribute->value = "thumbnail: '" . $thumbnail['0'] . "'";
		
		$first->appendChild($sourceAttribute);
		$first->appendChild($optionsAttribute);
		
		if($_post->post_excerpt){
			$captionAttribute = $xml->createAttribute('data-caption');
			$captionAttribute->value = esc_attr( $_post->post_excerpt );
			$first->appendChild($captionAttribute);
		}
		return $xml->saveHTML(); 
	}



	function ilightbox_gallery_style_filter($val) {

		$options = $this->ilightbox_generate_options($this->ilightbox_get_option('ilightbox_global_options'), "global", true);
		$search = array(
			"gallery-size-thumbnail'>",
			"gallery-size-medium'>",
			"gallery-size-large'>",
			"gallery-size-full'>",
		);
		$replace = array(
			"gallery-size-thumbnail ilightbox_gallery' data-options=\"$options\">",
			"gallery-size-medium ilightbox_gallery' data-options=\"$options\">",
			"gallery-size-large ilightbox_gallery' data-options=\"$options\">",
			"gallery-size-full ilightbox_gallery' data-options=\"$options\">",
		);
		$val = str_replace($search, $replace, $val);

		add_filter('wp_get_attachment_link', array($this, 'ilightbox_attachment_link_filter'), 10, 3);

		return $val; 
	}


	/*=========================================================================================*/

	function ilightbox_sc_button() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
		if ( get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array($this, 'add_ilightbox_sc'));
			add_filter('mce_buttons', array($this, 'register_ilightbox_sc'));
		}
	}


	function register_ilightbox_sc($buttons) {
		array_push($buttons, "ilightbox_sc");
		return $buttons;
	}


	function add_ilightbox_sc($plugin_array) {
		$plugin_array['ilightbox_sc'] = $this->ILIGHTBOX_URL.'scripts/shortcodes.js';
		return $plugin_array;
	}

	function ilightbox_refresh_mce($ver) {
	  $ver += 3;
	  return $ver;
	}



	/*=========================================================================================*/


	function ilightbox_register_scripts(){
		wp_register_script('jquery', plugins_url( '/scripts/jquery.min.js', $this->MAIN ), false, '1.9.0');
		wp_register_script('jquery.migrate', plugins_url( '/scripts/jquery.migrate.min.js', $this->MAIN ), array('jquery'), '1.2.1');
		wp_register_script('jquery.requestAnimationFrame', plugins_url( '/scripts/jquery.requestAnimationFrame.js', $this->MAIN ), array('jquery'), '1.0.0');
		wp_register_script('jquery.mousewheel', plugins_url( '/scripts/jquery.mousewheel.js', $this->MAIN ), array('jquery'), '3.0.6');
		wp_register_script('ilightbox', plugins_url( '/scripts/ilightbox.packed.js', $this->MAIN ), array('jquery','jquery.requestAnimationFrame','jquery.mousewheel'), $this->JQUERY_VERSION);
		wp_register_script('ilightbox.init', plugins_url( '/scripts/ilightbox.init.js', $this->MAIN ), array('jquery','ilightbox'));
		wp_register_style("ilightbox", plugins_url( '/css/src/css/ilightbox.css', $this->MAIN ), false, $this->JQUERY_VERSION, "all");
		wp_register_style('ilightbox-css-front', plugins_url( '/css/ilightbox_front.css', $this->MAIN ), false, $this->VERSION, 'all');
	}


	function ilightbox_enqueue_head(){
		$bindeds = $this->ilightbox_get_option('ilightbox_bindeds');
			
		wp_localize_script( 'ilightbox.init', 'ILIGHTBOX', array(
			'options' => rawurlencode($this->ilightbox_generate_options($this->ilightbox_get_option('ilightbox_global_options'))),
			'jetPack' => $this->ilightbox_get_option('ilightbox_jetpack') == 'true' ? true : false,
			'nextGEN' => $this->ilightbox_get_option('ilightbox_nextgen') == 'true' ? true : false
		));
		
		wp_print_scripts('jquery');
		wp_print_scripts('jquery.mousewheel');
		wp_print_scripts('ilightbox');
		wp_print_scripts('ilightbox.init');
		wp_print_styles('ilightbox');
		wp_print_styles('ilightbox-css-front');

		$styles = trim(stripslashes(html_entity_decode($this->ilightbox_get_option('ilightbox_styles'))));
		$out = '';
		if($styles!='' && $styles!='/*iLightBox additional styles*/'){
			$out = '<style>';
			$out .= $styles;
			$out .= '</style>' ;
		}
		
		echo  $out;
	}

	function ilightbox_bindeds_footer(){
		$bindeds = $this->ilightbox_get_option('ilightbox_bindeds');
		if(!empty($bindeds)) {
			$galleries = $this->ilightbox_get_option( 'ilightbox_added_galleries' );
			$str = "<script type='text/javascript'>";
			$str .= "jQuery(function(a){var b=a(document);";
			foreach($bindeds as $key => $value){
				$gallery = $galleries[$value['id']];
				$slides = $this->ilightbox_generate_slides($gallery);
				if($slides){
					$options = $this->ilightbox_generate_options($gallery);
					$query = stripslashes($value['query']);
					$event = $value['event'];
					$return = $value['return'];
					$starter = (preg_match("/^\'/u", $query)) ? "b.on('".$event."',".$query.",function(){" : "a(".strtolower($query).").bind('".$event."',function(){";
					$str .= $starter;
					
					$str .= "a.iLightBox(";
					$str .= $slides;
					if($options) $str .= ",".$options;
					$str .= ");";
					$str .= ($return) ? "return!1" : "";
					$str .= "});";
				}
			}
			$str .= "});";
			$str .= "</script>";
			echo $str;
		}
		
		$globals = $this->ilightbox_generate_options($this->ilightbox_get_option('ilightbox_global_options'));
		$str = "<script type='text/javascript'>";
		$str .= "jQuery(function(a){";
		if($this->ilightbox_get_option('ilightbox_auto_enable') == "true" && $this->ilightbox_get_option('ilightbox_auto_enable_videos') == "true") {
			$str .= "a('a[href*=\".jpg\"],a[href*=\".jpeg\"],a[href*=\".jpe\"],a[href*=\".jfif\"],a[href*=\".gif\"],a[href*=\".png\"],a[href*=\".tif\"],a[href*=\".tiff\"],a[href*=\".avi\"],a[href*=\".mov\"],a[href*=\".mpg\"],a[href*=\".mpeg\"],a[href*=\".mp4\"],a[href*=\".webm\"],a[href*=\".ogg\"],a[href*=\".ogv\"],a[href*=\".3gp\"],a[href*=\".m4v\"],a[href*=\".swf\"],[rel=\"ilightbox\"]').not('[rel^=\"ilightbox[\"]').each(function(){";
		} elseif($this->ilightbox_get_option('ilightbox_auto_enable') == "true") {
			$str .= "a('a[href*=\".jpg\"],a[href*=\".jpeg\"],a[href*=\".jpe\"],a[href*=\".jfif\"],a[href*=\".gif\"],a[href*=\".png\"],a[href*=\".tif\"],a[href*=\".tiff\"],[rel=\"ilightbox\"]').not('[rel^=\"ilightbox[\"]').each(function(){";
		} elseif($this->ilightbox_get_option('ilightbox_auto_enable_videos') == "true") {
			$str .= "a[href*=\".avi\"],a[href*=\".mov\"],a[href*=\".mpg\"],a[href*=\".mpeg\"],a[href*=\".mp4\"],a[href*=\".webm\"],a[href*=\".ogg\"],a[href*=\".ogv\"],a[href*=\".3gp\"],a[href*=\".m4v\"],a[href*=\".swf\"],[rel=\"ilightbox\"]').not('[rel^=\"ilightbox[\"]').each(function(){";
		} else {
			$str .= "a('[rel=\"ilightbox\"]').each(function(){";
		}
		
		$str .= "var b=a(this),c=".(($globals) ? $globals : "{}").";";
		$str .= "(b.parents('.ilightbox_gallery').length || b.parents('.tiled-gallery').length || b.parents('.ngg-galleryoverview').length)||b.iLightBox(c)";
		$str .= "});";
		
		$str .= "var b=[],d=".(($globals) ? $globals : "{}").";a('[rel^=\"ilightbox[\"]').each(function(){a.inArray(a(this).attr(\"rel\"),b)&&b.push(a(this).attr(\"rel\"))});a.each(b,function(b,c){a('[rel=\"'+c+'\"]').iLightBox(d)});";
		
		$new_globals = $this->ilightbox_generate_options(array_merge($this->ilightbox_get_option('ilightbox_global_options'), array(
			"smartRecognition" => "on"
		)));
		
		if($this->ilightbox_get_option('ilightbox_auto_enable_video_sites') == "true"){
			$str .= "a('a[href*=\"youtu.be/\"],a[href*=\"youtube.com/watch\"],a[href*=\"vimeo.com\"],a[href*=\"metacafe.com/watch\"],a[href*=\"dailymotion.com/video\"],a[href*=\"hulu.com/watch\"]').not('[rel*=\"ilightbox\"]').each(function(){";
			$str .= "var b=a(this),c=".(($new_globals) ? $new_globals : "{}").";";
			$str .= "(b.parents('.ilightbox_gallery').length || b.parents('.tiled-gallery').length || b.parents('.ngg-galleryoverview').length)||b.iLightBox(c)";
			$str .= "});";
		}
		
		$str .= "});";
		$str .= "</script>";
		echo $str;
	}

	function ilightbox_generate_slides($gallery){
		$slides = $gallery['slides'];
		$str = "";
		if($slides) {
			$str .= "[";
			foreach($slides as $i => $slide){
				if($i != 0) $str .= ",";
				$str .= $this->ilightbox_generate_options($slide, "inline");
			}
			$str .= "]";
		}
		return $str;
	}

	function ilightbox_generate_options($arr, $type = "global", $attr = false){

		if($type == "global") {
			if (@$arr['useConfiguration']) {
				$arr = $this->ilightbox_get_option('ilightbox_global_options');
			}

			if(@isset($arr['mobileOptimize']) || @isset($arr['tabletOptimize'])) {
				require_once($this->ILIGHTBOX_PATH . 'lib/classes/Mobile_Detect.php');
				$detect = new Mobile_Detect();
				$isMobile = ($detect->isMobile() && !$detect->isTablet()) ? true : false;
				$isTablet = $detect->isTablet();
				$arrayname = ($isMobile) ? 'mobileOpts' : 'tabletOpts';
			}
			
			if(@$isMobile || @$isTablet){
				$newArr = array(
					"maxScale" => $arr[$arrayname]['maxScale'],
					"minScale" => $arr[$arrayname]['minScale'],
					"show_title" => $arr[$arrayname]['show_title'],
					"thumbnail" => $arr[$arrayname]['thumbnail'],
					"thumbnails_maxWidth" => $arr[$arrayname]['thumbnails_maxWidth'],
					"thumbnails_maxHeight" => $arr[$arrayname]['thumbnails_maxHeight'],
					"nextOffsetX" => $arr[$arrayname]['nextOffsetX'],
					"nextOffsetY" => $arr[$arrayname]['nextOffsetY'],
					"prevOffsetX" => $arr[$arrayname]['prevOffsetX'],
					"prevOffsetY" => $arr[$arrayname]['prevOffsetY'],
					"captionStart" => $arr[$arrayname]['captionStart'],
					"captionShow" => $arr[$arrayname]['captionShow'],
					"captionHide" => $arr[$arrayname]['captionHide'],
					"socialStart" => $arr[$arrayname]['socialStart'],
					"socialShow" => $arr[$arrayname]['socialShow'],
					"socialHide" => $arr[$arrayname]['socialHide']
				);
			}
			
			if(@$arr['mobileOptimize'] && $isMobile) $arr = array_merge($arr, $newArr);
			elseif(@$arr['tabletOptimize'] && $isTablet) $arr = array_merge($arr, $newArr);
			
			unset($arr['mobileOpts']);
			unset($arr['tabletOpts']);
			
			$array = @array(
				"attr" => ($attr) ? 'source' : null,
				"path" => $arr['path'],
				"skin" => $arr['skin'],
				"startFrom" => $arr['startFrom'],
				"infinite" => ($arr['infinite']) ? 1 : false,
				"linkId" => trim($arr['linkId']),
				"randomStart" => ($arr['randomStart']) ? 1 : false,
				"keepAspectRatio" => ($arr['keepAspectRatio']) ? false : 0,
				"mobileOptimizer" => ($arr['mobileOptimizer']) ? false : 0,
				"maxScale" => $arr['maxScale'],
				"minScale" => $arr['minScale'],
				"innerToolbar" => ($arr['innerToolbar']) ? 1 : false,
				"smartRecognition" => ($arr['smartRecognition']) ? 1 : false,
				"fullAlone" => ($arr['fullAlone']) ? false : 0,
				"fullViewPort" => $arr['fullViewPort'],
				"fullStretchTypes" => $arr['fullStretchTypes'],
				"overlay" => array(
					"opacity" => $arr['overlayOpacity'],
					"blur" => ($arr['overlayBlur']) ? false : 0
				),
				"controls" => array(
					"arrows" => ($arr['arrows']) ? 1 : false,
					"slideshow" => ($arr['slideshow']) ? 1 : false,
					"toolbar" => ($arr['toolbar']) ? false : 0,
					"fullscreen" => ($arr['fullscreen']) ? false : 0,
					"thumbnail" => ($arr['thumbnail']) ? false : 0,
					"keyboard" => ($arr['keyboard']) ? false : 0,
					"mousewheel" => ($arr['mousewheel']) ? false : 0,
					"swipe" => ($arr['swipe']) ? false : 0
				),
				"keyboard" => array(
					"left" => ($arr['left']) ? false : 0,
					"right" => ($arr['right']) ? false : 0,
					"up" => ($arr['up']) ? false : 0,
					"down" => ($arr['down']) ? false : 0,
					"esc" => ($arr['esc']) ? false : 0,
					"shift_enter" => ($arr['shift_enter']) ? false : 0
				),
				"show" => array(
					"effect" => ($arr['show_effect']) ? false : 0,
					"speed" => $arr['show_speed'],
					"title" => ($arr['show_title']) ? false : 0
				),
				"hide" => array(
					"effect" => ($arr['hide_effect']) ? false : 0,
					"speed" => $arr['hide_speed']
				),
				"caption" => array(
					"start" => ($arr['captionStart']) ? false : 0,
					"show" => ($arr['captionShow'] == 'mouseenter') ? false : $arr['captionShow'],
					"hide" => ($arr['captionHide'] == 'mouseleave') ? false : $arr['captionHide']
				),
				"social" => array(
					"start" => ($arr['socialStart']) ? false : 0,
					"show" => ($arr['socialShow'] == 'mouseenter') ? false : $arr['socialShow'],
					"hide" => ($arr['socialHide'] == 'mouseleave') ? false : $arr['socialHide'],
					"buttons" => trim(stripslashes($arr['socialButtons']))
				),
				"slideshow" => array(
					"pauseTime" => $arr['pauseTime'],
					"pauseOnHover" => ($arr['slideshow']) ? 1 : false,
					"startPaused" => ($arr['startPaused']) ? false : 0
				),
				"styles" => array(
					"pageOffsetX" => $arr['pageOffsetX'],
					"pageOffsetY" => $arr['pageOffsetY'],
					"nextOffsetX" => $arr['nextOffsetX'],
					"nextOffsetY" => $arr['nextOffsetY'],
					"nextOpacity" => $arr['nextOpacity'],
					"nextScale" => $arr['nextScale'],
					"prevOffsetX" => $arr['prevOffsetX'],
					"prevOffsetY" => $arr['prevOffsetY'],
					"prevOpacity" => $arr['prevOpacity'],
					"prevScale" => $arr['prevScale']
				),
				"thumbnails" => array(
					"maxWidth" => $arr['thumbnails_maxWidth'],
					"maxHeight" => $arr['thumbnails_maxHeight'],
					"normalOpacity" => $arr['thumbnails_normalOpacity'],
					"activeOpacity" => $arr['thumbnails_activeOpacity']
				),
				"effects" => array(
					"reposition" => ($arr['reposition']) ? false : 0,
					"repositionSpeed" => $arr['repositionSpeed'],
					"switchSpeed" => $arr['switchSpeed'],
					"loadedFadeSpeed" => $arr['loadedFadeSpeed'],
					"fadeSpeed" => $arr['fadeSpeed']
				),
				"text" => array(
					"close" => (stripslashes($arr['close']) == "Close") ? false : $arr['close'],
					"enterFullscreen" => (stripslashes($arr['enterFullscreen']) == "Enter Fullscreen (Shift+Enter)" || stripslashes($arr['enterFullscreen']) == "Enter Fullscreen (Shift Enter)") ? false : $arr['enterFullscreen'],
					"exitFullscreen" => (stripslashes($arr['exitFullscreen']) == "Exit Fullscreen (Shift+Enter)" || stripslashes($arr['exitFullscreen']) == "Exit Fullscreen (Shift Enter)") ? false : $arr['exitFullscreen'],
					"slideShow" => (stripslashes($arr['slideShowLabel']) == "Slideshow") ? false : $arr['slideShowLabel'],
					"next" => (stripslashes($arr['nextLabel']) == "Next") ? false : $arr['nextLabel'],
					"previous" => (stripslashes($arr['previousLabel']) == "Previous") ? false : $arr['previousLabel']
				),
				"errors" => array(
					"loadImage" => (stripslashes($arr['loadImage']) == "An error occurred when trying to load photo.") ? false : $arr['loadImage'],
					"loadContents" => (stripslashes($arr['loadContents']) == "An error occurred when trying to load contents.") ? false : $arr['loadContents'],
					"missingPlugin" => (stripslashes($arr['missingPlugin']) == "The content your are attempting to view requires the <a href='{pluginspage}' target='_blank'>{type} plugin</a>.") ? false : $arr['missingPlugin']
				),
				"callback" => array(
					"onAfterChange" => trim(stripslashes($arr['onAfterChange'])),
					"onAfterLoad" => trim(stripslashes($arr['onAfterLoad'])),
					"onBeforeChange" => trim(stripslashes($arr['onBeforeChange'])),
					"onBeforeLoad" => trim(stripslashes($arr['onBeforeLoad'])),
					"onEnterFullScreen" => trim(stripslashes($arr['onEnterFullScreen'])),
					"onExitFullScreen" => trim(stripslashes($arr['onExitFullScreen'])),
					"onHide" => trim(stripslashes($arr['onHide'])),
					"onOpen" => trim(stripslashes($arr['onOpen'])),
					"onRender" => trim(stripslashes($arr['onRender'])),
					"onShow" => trim(stripslashes($arr['onShow']))
				)
			);
		} else $array = @array(
			"url" => ($arr['type'] == "html" && $arr['html']) ? "jQuery('".str_replace(array("\n\r", "\n", "\r"), "\\n", addslashes(do_shortcode(stripslashes(trim($arr['html'])))))."')" : $arr['source'],
			"type" => $arr['type'],
			"caption" => $arr['caption'],
			"title" => $arr['title'],
			"options" => array(
				"skin" => $arr['skin'],
				"thumbnail" => $arr['thumbnail'],
				"icon" => $arr['icon'],
				"width" => $arr['width'],
				"height" => $arr['height'],
				"fullViewPort" => $arr['fullViewPort'],
				"mousewheel" => ($arr['mousewheel']) ? false : 0,
				"swipe" => ($arr['swipe']) ? false : 0,
				"smartRecognition" => ($arr['smartRecognition']) ? 1 : false,
				"html5video" => trim(stripslashes($arr['html5video'])),
				"ajax" => trim(stripslashes($arr['ajax'])),
				"flashvars" => trim(stripslashes($arr['flashvars'])),
				"onAfterLoad" => trim(stripslashes($arr['onAfterLoad'])),
				"onBeforeLoad" => trim(stripslashes($arr['onBeforeLoad'])),
				"onRender" => trim(stripslashes($arr['onRender'])),
				"onShow" => trim(stripslashes($arr['onShow']))
			)
		);
		
		if($type == "inline" && $attr) $array = $array['options'];
		
		$str = $this->ilightbox_generate_object($array);
		return trim(trim($str, "}"), "{") ? $str : false;
	}

	function ilightbox_generate_object($arr) {
		$arr = $this->ilightbox_plugin_array_filter($arr);
		$str = "{";
		$i = 0;
		foreach($arr as $key => $val){
			if($i != 0) $str .= ",";
			if(is_array($val)) $str .= $key.":".$this->ilightbox_generate_object($val);
			else $str .= (is_numeric($val) || preg_match("/^\{/u", trim($val)) || preg_match("/^jQuery/u", trim($val)) || preg_match("/^on/u", $key)) ? $key.":".$val : $key.":'".$val."'";
			$i++;
		}
		$str .= "}";
		return $str;
	}


	/*=========================================================================================*/

	function ilightbox_plugin_get_version() {
		$plugin_data = get_plugin_data($this->ILIGHTBOX_PATH.'index.php');
		$plugin_version = $plugin_data['Version'];
		return $plugin_version;
	}

	function ilightbox_add_admin_footer() {
		$plugin_data = get_plugin_data($this->ILIGHTBOX_PATH.'index.php');
		printf('<p align="center">%s by %s.</p><div class="clear"></div>', $plugin_data['Title'].' '.$plugin_data['Version'], $plugin_data['Author']);
	}

	/*=========================================================================================*/

	function ilightbox_plugin_array_filter($arr) {
		$array = array();
		foreach ($arr as $key => $value) {
			if (is_array($value)) {
				$val = $this->ilightbox_plugin_array_filter($value);
				if($val) $array[$key] = $val;
			} else {
				if(trim($arr[$key]) || is_numeric($arr[$key])) $array[$key] = $value;
			}
		}
		return $array;
	}


	function ilightbox_add_general() {

		global $wpdb;
		$this->ilightbox_init();
		foreach ($this->OPTIONS as $value) :
			$return = $this->ilightbox_get_option($value['id']);
			if(empty($return) && !is_array($return)){
				$this->ilightbox_add_option($value['id'], $value['std']);
			}
		endforeach;
	}


	function ilightbox_init(){
		$page = $_GET['page'];

		add_action('in_admin_footer', array($this, 'ilightbox_add_admin_footer'));

		if ($page == 'ilightbox_general') {
			include_once($this->ILIGHTBOX_PATH . "lib/admin/ilightbox_general.php");
		}
		elseif ($page == 'ilightbox_create'){
			include_once($this->ILIGHTBOX_PATH . "lib/admin/ilightbox_create.php");
		}
		elseif ($page == 'ilightbox_configurations'){
			include_once($this->ILIGHTBOX_PATH . "lib/admin/ilightbox_configurations.php");
		}
		elseif ($page == 'ilightbox_documentation'){
			include_once($this->ILIGHTBOX_PATH . "lib/admin/ilightbox_documentation.php");
		}
	}
	
	
	function ilightbox_add_menu()
	{
		if (function_exists('add_options_page')) {
			add_menu_page($this->ILIGHTBOX_NAME, $this->ILIGHTBOX_NAME, 'manage_options', 'ilightbox_general', array($this, 'ilightbox_init'), $this->ILIGHTBOX_URL . 'css/images/blank.gif');
			add_submenu_page('ilightbox_general', 'Create New Gallery &lsaquo; '.$this->ILIGHTBOX_NAME, 'Create New Gallery', 'manage_options', 'ilightbox_create',array($this, 'ilightbox_init'));
			add_submenu_page('ilightbox_general', 'Configurations &lsaquo; '.$this->ILIGHTBOX_NAME, 'Configurations', 'manage_options', 'ilightbox_configurations',array($this, 'ilightbox_init'));
			add_submenu_page('ilightbox_general', 'Documentation &lsaquo; '.$this->ILIGHTBOX_NAME, 'Documentation', 'manage_options', 'ilightbox_documentation',array($this, 'ilightbox_init'));
		}
	}


	function ilightbox_admin_bar_render() {
		global $wp_admin_bar;
		
		$wp_admin_bar->add_menu( array(
			'parent' => false,
			'id' => 'ilightbox_general',
			'title' => '<span class="ab-icon"></span><span class="ab-label">iLightBox</span>',
			'href' => admin_url( 'admin.php?page=ilightbox_general')
		) );
		
		$wp_admin_bar->add_menu( array(
			'parent' => 'ilightbox_general',
			'id' => 'ilightbox_create',
			'title' => 'Create New Gallery',
			'href' => admin_url( 'admin.php?page=ilightbox_create')
		) );
		
		$wp_admin_bar->add_menu( array(
			'parent' => 'ilightbox_general',
			'id' => 'ilightbox_configurations',
			'title' => 'Configurations',
			'href' => admin_url( 'admin.php?page=ilightbox_configurations')
		) );
		
		$wp_admin_bar->add_menu( array(
			'parent' => 'ilightbox_general',
			'id' => 'ilightbox_documentation',
			'title' => 'Documentation',
			'href' => admin_url( 'admin.php?page=ilightbox_documentation')
		) );
	}


	function ilightbox_menu_style() {
		?>
		<style type="text/css" media="screen">
			#toplevel_page_ilightbox_general .wp-menu-image {
				background: url(<?php echo $this->ILIGHTBOX_URL; ?>css/images/menu_icon.png) no-repeat 0 0 !important;
				opacity: .7;
				filter: alpha(opacity=70);
			}
			#toplevel_page_ilightbox_general:hover .wp-menu-image, #toplevel_page_ilightbox_general.current .wp-menu-image, #toplevel_page_ilightbox_general.wp-menu-open .wp-menu-image {
				background-position: 0 0!important;
				opacity: 1;
				filter: alpha(opacity=100);
			}
			#wp-admin-bar-ilightbox_general .ab-icon {
				background: url(<?php echo $this->ILIGHTBOX_URL; ?>css/images/menu_icon.png) no-repeat 50% 50% !important;
				margin-right: 5px;
			}
			
		</style>
	<?php }

	function ajax_handler(){
		$result = array();
		$p = @$_POST;
		$form = @$p['form'];
		if ($form) {
			parse_str($form, $p);
		}
		$action = @$p['_action'];


		// check for rights
		if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') ) $result = array(
			'status' => 403,
			'message' => __("You are not allowed to be here")
		);

		else if(strtolower(@$_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $action) {

			if($action == "saveConfigurations") {
				$ticks = "ilightbox_auto_enable,ilightbox_auto_enable_videos,ilightbox_auto_enable_video_sites,ilightbox_gallery_shortcode,ilightbox_delete_table,ilightbox_jetpack,ilightbox_nextgen";
				$explode = explode(",", $ticks);

				foreach ($p as $key => $value) {
					if(!stristr($ticks, $key)) $this->ilightbox_update_option($key, (is_array($value)) ? $this->ilightbox_plugin_array_filter($value) : $value);
				}
				foreach ($explode as $key => $value) {
					$val = ($p[$value]) ? 'true': 'false';
					$this->ilightbox_update_option($value, $val);
				}
				
				$result = array(
					'status' => 200,
					'message' => "Configurations saved."
				);
			}
			
			

			elseif($action == "createGallery") {
				unset($p['action']);
				$gallery = $this->ilightbox_plugin_array_filter($p);
				$uid = get_current_user_id();
				$galleries = $this->ilightbox_get_option( 'ilightbox_added_galleries' );
				
				$gallery['uid'] = $uid;
				$gallery['lastEdit'] = time();
				
				$galleries[] = $gallery;
				$message = "Gallery created.";
				$last = end(array_keys($galleries));
					
				$this->ilightbox_update_option('ilightbox_added_galleries', $galleries);
				
				$result = array(
					'status' => 200,
					'gid' => $last,
					'message' => $message
				);
			}
			
			

			elseif($action == "editGallery") {
				unset($p['action']);
				$id = @$p['gid'];
				$uid = get_current_user_id();
				$galleries = $this->ilightbox_get_option( 'ilightbox_added_galleries' );
				$gallery = $this->ilightbox_plugin_array_filter($p);
				
				if(current_user_can('manage_options')){
					$gallery['uid'] = $uid;
					$gallery['lastEdit'] = time();
					
					if($id >= 0) {
						$galleries[$id] = $gallery;
						$message = "Changes saved.";
					}
						
					$this->ilightbox_update_option('ilightbox_added_galleries', $galleries);
					
					$result = array(
						'status' => 200,
						'gid' => $id,
						'message' => $message
					);
				} else $result = array(
					'status' => 403,
					'message' => "You are not allowed to edit this gallery."
				);
			}
			
			
			
			elseif($action == "getAttachmentUrl") {
				$id = (@$p['id']) ? $p['id'] : $this->ilightbox_attachment_id_from_src($p['path']);
				
				if($id == '') {
					$image_src = $p['path'];
					if(strpos(substr( $image_src, -10 ), 'x') && strpos(substr( $image_src, -15 ), '-')) {
						$pos = strrpos($image_src, '-');
						$image_src = substr($image_src, 0, $pos) . substr($image_src, -4);
					}
					$id = $this->ilightbox_attachment_id_from_src($image_src);  
				}
				
				$url = wp_get_attachment_url( $id );
				$thumb = wp_get_attachment_image_src( $id, 'thumbnail' );
				
				$result = array(
					'status' => 200,
					'url' => $url,
					'thumb' => $thumb['0']
				);
			}
			
			
			
			elseif($action == "removeGallery") {
				$id = @$p['id'];
				
				
				if(current_user_can('manage_options')){
					if($id >= 0) {
						
						$galleries = $this->ilightbox_get_option( 'ilightbox_added_galleries' );
						$bindeds = $this->ilightbox_get_option( 'ilightbox_bindeds' );
						
						unset($galleries[$id]); 
						
						foreach($bindeds as $key => $value){
							if($value['id'] == $id) unset($bindeds[$key]);
						}
						
						$this->ilightbox_update_option('ilightbox_added_galleries', $galleries);
						$this->ilightbox_update_option('ilightbox_bindeds', $bindeds);
					}
					
					$result = array(
						'status' => 200,
						'message' => "Gallery removed."
					);
				} else $result = array(
					'status' => 403,
					'message' => "You are not allowed to remove this gallery."
				);
			}
			
			
			
			elseif($action == "bindGallery" || $action == "rebindGallery") {
				$id = $p['bid'];
				unset($p['action']);
				unset($p['bid']);
				$bind = $this->ilightbox_plugin_array_filter($p);
				$uid = get_current_user_id();
				$bindeds = $this->ilightbox_get_option( 'ilightbox_bindeds' );
				
				$bind['uid'] = $uid;
				$bind['lastEdit'] = time();
				
				if($bind['query']) {
					if($action == "rebindGallery") $bindeds[$id] = $bind;
					else $bindeds[] = $bind;
					
					$this->ilightbox_update_option('ilightbox_bindeds', $bindeds);
					
					$result = array(
						'status' => 200,
						'message' => ($action == "rebindGallery") ? "Gallery rebinded." : "Gallery binded."
					);
				} else $result = array(
					'status' => 400,
					'message' => 'Please write the CSS DOM Selector Query!'
				);
			}
			
			
			
			elseif($action == "unbindGallery") {
				$id = @$p['id'];
				
				if($id >= 0) {
					
					$bindeds = $this->ilightbox_get_option( 'ilightbox_bindeds' );
					
					unset($bindeds[$id]);
					
					$this->ilightbox_update_option('ilightbox_bindeds', $bindeds); 
				}
				
				$result = array(
					'status' => 200,
					'message' => 'Gallery unbinded.'
				);
			}
			
			
			
			elseif($action == "previewGallery") {
				$id = @$p['id'];
				
				if($id >= 0) {
					$galleries = $this->ilightbox_get_option( 'ilightbox_added_galleries' );
					$gallery = $galleries[$id];
				}
				
				if(!isset($gallery)) $gallery = $this->ilightbox_plugin_array_filter($p);
				
				$slides = $this->ilightbox_generate_slides($gallery);
				$options = $this->ilightbox_generate_options($gallery);
				
				if($slides) $result = array(
					'status' => 200,
					'slides' => $slides,
					'options' => $options,
				);
				else $result = array(
					'status' => 400,
					'message' => "Please add slides to preview."
				);
			}



			else $result = array(
				'status' => 400,
				'message' => "Bad Request"
			);
			
		} else {
			$result = array(
				'status' => 403,
				'message' => __("You are not allowed to be here")
			);
		}

		ob_clean();
		echo json_encode($result);
		die();
	}
}

?>
