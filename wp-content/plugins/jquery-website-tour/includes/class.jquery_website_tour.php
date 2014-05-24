<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class jquery_website_tour {
	var $show_ui;
	var $capability;
	function jquery_website_tour($args=array()){
		//------------
		$defaults = array(
			'capability' => 'manage_jwt',
			'show_ui'=> true
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//----------
		if(current_user_can('manage_jwt')||current_user_can($this->capability)){
			add_action('init',array(&$this,'init'));
		}
		
//		add_action('admin_footer',array(&$this,'admin_footer'));
		add_action('admin_init',array(&$this,'admin_init'));
		add_action('admin_head', array(&$this,'icon32_style'));	
	}
	
	function icon32_style(){
?>
<style>
.icon32-posts-jwt{
	background: url("<?php echo JWT_URL.'images/jwt32.png'?>") no-repeat scroll 0 1px transparent !important;
}
</style>
<?php	
	}
	
	function admin_init(){
		add_filter( 'manage_edit-jwt_columns', array(&$this,'admin_columns')  );
		add_action('manage_posts_custom_column', array(&$this,'custom_column'),10,2);		
	}
	
	function admin_columns($defaults){
		$new = array();
		foreach($defaults as $key => $title){
			$new[$key]=$title;
			if($key=='title'){
				$new['jwt_id']=__("Tour ID","jwt");
				$new['jwt_uri']=__("URI","jwt");
				$new['jwt_control_on_load']=__("Control On Load","jwt");
			}
		}
		return $new;
	}
	
	function custom_column($field, $post_id=null){
		global $post;
		$post_id = $post_id==null?$post->ID:$post_id;
		if($field=='jwt_uri'){
			$uri = get_post_meta($post_id,'tour_uri',true);
			if(trim($uri)!=''){
				echo "<a href=\"$uri\" target=\"_blank\">$uri</a>";
			}
		}
		if($field=='jwt_id'){
			echo $post_id;
		}
		if($field=='jwt_control_on_load'){
			echo 1==get_post_meta($post_id,'autostart',true)?__('Yes','jwt'):__('No','jwt');
		}
	}
	
	function init($install=false){
		$labels = array(
			'name' 				=> __('Site Tour','jwt'),
			'singular_name' 	=> __('Tour','jwt'),
			'add_new' 			=> __('Add new Website Tour','jwt'),
			'edit_item' 		=> __('Edit Website Tour','jwt'),
			'new_item' 			=> __('New Website Tour','jwt'),
			'view_item'			=> __('View Website Tour','jwt'),
			'search_items'		=> __('Search Website Tour','jwt'),
			'not_found'			=> __('No Website Tours found','jwt'),
			'not_found_in_trash'=> __('No Website Tours found in trash','jwt')
		);
		
		register_post_type('jwt', array(
			'label' => __('Tour'),
			'labels' => $labels,
			'public' => true,
			'show_ui' => ($install)?true:($this->show_ui?true:false),
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => false,
			'supports' => array('title',/*'editor',*/'revisions','page-attributes'),
			'exclude_from_search' => true,
			//'menu_position' => 5,
			'show_in_nav_menus' => false,
			'taxonomies' => array(),
			'menu_icon'=> JWT_URL.'images/jwt.png'
		));
				
		register_post_type('jwt-slide', array(
			'label' => __('Tour slides','cbw'),
			'public' => true,
			'show_ui' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => false,
			'supports' => array('title','content'),
			'exclude_from_search' => true,
			'show_in_nav_menus' => false
		));
	}	
}
?>