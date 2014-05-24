<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class plugin_website_tour {
	var $id 				= 'jwt';
	var $plugin_code 		= 'JWT';
	var $options_varname 	= 'jwt-options';
	var $capability			= 'manage_options';
	function plugin_website_tour($args=array()){
		//------------
		$defaults = array(
			'capability'=>'manage_options',
			'options_varname'	=> 'jwt-options',
			'options_panel_version'	=> '2.0.2'			
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------	
		add_action('after_setup_theme',array(&$this,'plugins_loaded'));
		add_action('wp_footer', array(&$this,'wp_footer'));
		add_action('login_footer',array(&$this,'wp_footer'));
		add_action('admin_footer',array(&$this,'wp_footer'));
		add_action('login_head',array(&$this,'login_head'));		
		add_action('init',array(&$this,'admin_init'));
		
		if(is_admin()){
			require_once JWT_PATH.'options-panel/load.pop.php';
			rh_register_php('options-panel',JWT_PATH.'options-panel/class.PluginOptionsPanelModule.php', $this->options_panel_version);
		}		
	}
	
	function admin_init(){
	
		if(is_admin()){
			wp_register_script( 'eyecon-colorpicker', JWT_URL.'colorpicker/js/colorpicker.js', array(),'1.0.0');
			wp_register_script( 'jquery-tools-rangeinput', JWT_URL.'js/jquery.tools.rangeinput.min.js', array(),'1.0.0');
			wp_register_script( 'jquery-scrollto', JWT_URL.'js/jquery.scrollTo-min.js', array('jquery-easing'),'1.4.2');
			wp_register_style( 'eyecon-colorpicker', JWT_URL.'colorpicker/css/colorpicker.css', array(),'1.0.0');
			wp_register_style( 'post-meta-boxes', JWT_URL.'css/post_meta_boxes.css', array(),'1.0.0');
			//wp_register_style( 'jwt-options', JWT_URL.'css/pop.css', array(),'1.0.0');
			wp_register_style( 'smoothness', JWT_URL.'css/smoothness/jquery-ui-1.8.11.custom.css', array(),'1.0.0');	
			wp_register_style( 'jwt-editor', JWT_URL.'css/jwt_editor.css', array(),'1.0.0');		
			wp_register_script( 'jwt-editor', JWT_URL.'js/jwt_editor.js', array(),'1.0.0');
		}
		
		if(is_rtl()){
			wp_register_style( 'jwt-control', JWT_URL.'WebsiteTour/css/control.rtl.css', array(),'1.0.1');
		}else{
			wp_register_style( 'jwt-control', JWT_URL.'WebsiteTour/css/control.css', array(),'1.0.1');	
		}
		
		wp_enqueue_script( 'jquery-easing', JWT_URL.'js/jquery.easing.1.3.js', array('jquery'),'1.3');
		wp_register_style( 'jwt', JWT_URL.'WebsiteTour/css/jquerytour.css', array('jwt-control'),'1.0.1');		
		wp_enqueue_style('jwt');
		wp_enqueue_script( 'jquery-cookie', JWT_URL.'js/cookie.js', array('jquery'),'1.0.1');
		wp_register_script( 'jwt', JWT_URL.'js/jquery_website_tour.js', array(),'1.0.1');
		wp_enqueue_script('jwt');		
	}
	
	function plugins_loaded(){
		require_once JWT_PATH.'includes/class.jquery_website_tour.php';
		new jquery_website_tour(array('capability'=>$this->capability));
		
		if(is_admin()){
			require_once JWT_PATH.'includes/class.jwt_settings.php';new jwt_settings();
			/*
			if(!class_exists('plugin_registration')){require_once JWT_PATH.'includes/class.plugin_registration.php';}
			new plugin_registration(array('plugin_id'=>$this->id,'tdom'=>'jwt','plugin_code'=>$this->plugin_code,'options_varname'=>$this->options_varname));
			if(!class_exists('PluginOptionsPanel')){require_once JWT_PATH.'includes/class.PluginOptionsPanel.php';}
			*/
			$settings = array(				
				'id'					=> $this->id,
				'plugin_id'				=> $this->id,
				'capability'			=> $this->capability,
				'options_varname'		=> $this->options_varname,
				'menu_id'				=> 'jwt-options',
				'page_title'			=> __('Options','jwt'),
				'menu_text'				=> __('Options','jwt'),
				'option_menu_parent'	=> 'edit.php?post_type=jwt',
				'notification'			=> (object)array(
					'plugin_version'=> JWT_VERSION,
					'plugin_code' 	=> $this->plugin_code,
					'message'		=> __('jQuery Website Tour update %s is available! <a href=\"%s\">Please update now</a>','jwt')
				),
				'theme'					=> false,
				'stylesheet'			=> 'jwt-options',
				'rangeinput'			=> false,
				'colorpicker'			=> false,
				'path'			=> JWT_PATH.'options-panel/',
				'url'			=> JWT_URL.'options-panel/'										
			);
			do_action('rh-php-commons');	
			new PluginOptionsPanelModule($settings);
			//----------
			
			
			require_once JWT_PATH.'includes/class.jwt_editor.php';
			new jwt_editor(array(
				'capability'=>$this->capability
			));
		}
		
		require_once JWT_PATH.'includes/class.jwt_frontend.php';
		new jwt_frontend();
	}
	function login_head(){
		wp_print_styles('jwt');
		wp_print_scripts('jwt');
	}
	function wp_footer(){
?>
<form style="display:none;">
<input id="admin_jwt_request_uri" type="text" name="admin_jwt_request_uri" value="<?php echo $_SERVER['REQUEST_URI']?>" />
</form>
<?php
	}	
}






?>