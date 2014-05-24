<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class jwt_frontend {
	var $uid=0;
	var $prefix='jwt-trigger-';
	var $max_number_of_tours_per_page = 20;
	var $wildcards = true;
	function jwt_frontend(){
		add_action('login_head',array(&$this,'init_tour'),100);
		add_action('wp_head',array(&$this,'init_tour'),100);
		add_action('admin_head',array(&$this,'init_tour'),100);
		add_shortcode('sitetour', array(&$this,'shortcode_sitetour'));
		add_shortcode('sitetour_button', array(&$this,'shortcode_sitetour_button'));
		add_shortcode('sitetour_trigger', array(&$this,'shortcode_sitetour_trigger'));
		add_action('template_redirect', array(&$this,'template_redirect'));
	}
	
	function init_tour(){
		//if( isset($_COOKIE['jwt_hide']) && $_COOKIE['jwt_hide']==1 )return;
		$args = array(
			'post_type'		=> 'jwt',
			'post_status'	=> 'publish',
			'posts_per_page'=> $this->max_number_of_tours_per_page,
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC',
			'meta_query'	=> array(
				array(
					'key'	=> 'tour_uri',
					'value'	=> strtolower($_SERVER['REQUEST_URI']),
					'compare'=> '=',
					'type'	=> 'CHAR'				
				)
				/*,
				array(
					'key'	=> 'autostart',
					'value'	=> '1',
					'compare'=> '=',
					'type'	=> 'NUMERIC'				
				)*/
			),
			'numberposts'	=> -1
		);

		if(is_user_logged_in()){
			global $userdata;
			$tour_uri = str_replace( strtolower($userdata->user_login),CURRENT_USER_LOGIN_TAG,strtolower($_SERVER['REQUEST_URI']));
			$args['meta_query']['relation']='OR';
			$args['meta_query'][]=array(
					'key'	=> 'tour_uri',
					'value'	=> $tour_uri,
					'compare'=> '=',
					'type'	=> 'CHAR'				
			);
			
			if("/"==substr($tour_uri,-1)){
				$tour_uri=substr($tour_uri,0,-1);
				$args['meta_query'][]=array(
						'key'	=> 'tour_uri',
						'value'	=> $tour_uri,
						'compare'=> '=',
						'type'	=> 'CHAR'				
				);
			}
		}
		
		$tours = get_posts($args);
		if($this->wildcards){
			global $wpdb;
			$sql = $wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='tour_uri' AND %s LIKE meta_value AND meta_value!=%s",$_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
			$include = $wpdb->get_col($sql,0);
			if(is_array($include)&&count($include)>0){
				$args = array(
					'post_type'		=> 'jwt',
					'post_status'	=> 'publish',
					'posts_per_page'=> $this->max_number_of_tours_per_page,
					'orderby'		=> 'menu_order',
					'order'			=> 'ASC',
					'numberposts'	=> -1,
					'post__in'		=> $include
				);
				$more_tours = get_posts($args);
				if(!empty($more_tours)){
					$tours = array_merge($tours,$more_tours);
				}			
			}							
		}	
		$this->start_tour($tours);			
	}

	function pre31_init_tour(){
		$args = array(
			'post_type'		=> 'jwt',
			'post_status'	=> 'publish',
			'posts_per_page'=> $this->max_number_of_tours_per_page,
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC',
			'meta_key'		=> 'tour_uri',
			'meta_value'	=> strtolower($_SERVER['REQUEST_URI']),
			'numberposts'	=> -1
		);

		$tours = get_posts($args);
		$this->start_tour($tours);			
	}
	
	function get_tour_uri($tour_id){
		$tour_uri = get_post_meta($tour_id,'tour_uri',true);
		
		if(false!==strpos(urldecode($tour_uri),'%')){
			$tour_uri = $_SERVER['REQUEST_URI'];
		}
		
		if(is_user_logged_in()){
			global $userdata;
			$tour_uri = str_replace(CURRENT_USER_LOGIN_TAG,$userdata->user_login,$tour_uri);
		}
		
		return $tour_uri;
	}
		
	function tours_settings($tours){
		if(is_array($tours)&&count($tours)>0){
			$autostart = false;
			$settings = array();
			foreach($tours as $t){
				$skin = get_post_meta($t->ID,'skin',true);
				$skin = ''==$skin?'default':$skin;
				$tmp = (object)array(
					'id'		=> $t->ID,
					'title' 	=> $t->post_title,
					'config'	=> array(),
					'tour_uri'	=> $this->get_tour_uri($t->ID),
					'gotouri'	=> get_post_meta($t->ID,'gotouri',true),
					'autostart'	=> intval(get_post_meta($t->ID,'autostart',true)),
					'autoplay'	=> intval(get_post_meta($t->ID,'autoplay',true)),
					'overlay'	=> intval(get_post_meta($t->ID,'overlay',true)),
					'tour_link'	=> '',
					'skin'		=> $skin,
					'intro'		=> get_post_meta($t->ID,'intro',true)
				);
				
				if($tmp->autostart==1){
					$autostart = true;
				}
				
				$next_tour_id = intval(get_post_meta($t->ID,'tour_link',true));
				$next_tour_uri = $this->get_tour_uri($next_tour_id);
				if(''!=trim($next_tour_uri)){
					$tmp->tour_link = site_url( $next_tour_uri.'#tour-'.$next_tour_id );
				}
				
				//get attachments
				$child_args = array(
					'post_type'		=> 'jwt-slide',
					'post_parent'	=> $t->ID,
					'numberposts'	=> -1,
					'orderby'		=> 'menu_order',
					'order'			=> 'ASC'
				);
				$children = get_children($child_args);
				foreach($children as $c){
					$config =(object)array(
						'id'		=> $c->ID,
						'name' 		=> get_post_meta($c->ID,'selector',true),
						'width'		=> get_post_meta($c->ID,'width',true),
						'bgcolor'	=> get_post_meta($c->ID,'bgcolor',true),
						'color'		=> get_post_meta($c->ID,'color',true),
						'v_offset'	=> intval(get_post_meta($c->ID,'v_offset',true)),
						'h_offset'	=> intval(get_post_meta($c->ID,'h_offset',true)),
						'position'	=> get_post_meta($c->ID,'position',true),
						'time'		=> get_post_meta($c->ID,'time',true),
						'text'		=> $c->post_content
					);
					
					$config->width = ''==$config->width?250:$config->width;
					$config->color = ''==$config->color?'white':'#'.$config->color;
					$config->bgcolor = ''==$config->bgcolor?'black':'#'.$config->bgcolor;
					$config->time = ''==$config->time?5000:$config->time;
					
					$tmp->config[]=$config;
				}
				$settings[]=$tmp;
			}
	
			global $jwt_plugin;
			$options = get_option($jwt_plugin->options_varname);
			$options = is_array($options)?$options:array();			
			$more_settings = (object)array(
				'skin'	=> isset($options['skin'])?$options['skin']:'default',
				'donotshow_label'	=> isset($options['donotshow_label'])?$options['donotshow_label']:__('Do not show this again.','jwt'),
				'intro'	=> isset($settings[0]->intro)?$settings[0]->intro:''
			);
			
			$more_settings->autostart = $autostart?1:0;
			
			return (object)array(
				'settings'		=> $settings,
				'more_settings'	=> $more_settings
			);		
		}
		return false;
	}	
	
	function start_tour($tours){
		$r = $this->tours_settings($tours);
		if(false!==$r){
			$this->jwt_init($r->settings,$r->more_settings);
		}
	}
	
	function jwt_init($tours,$settings){
?><script>jQuery(document).ready(function($){try {jwt_init(<?php echo json_encode($tours)?>,<?php echo json_encode($settings)?>);}catch(e){}});</script><?php	
	}
	
	function shortcode_sitetour_button($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'alt'=>'',
			'title'=>'',
			'class'=>''
		), $atts));	
		
		$id = $this->prefix.($this->uid++);
		$atts['selector']="#$id";
		$atts['autostart']=1;
		$content = trim($content)==''?__('Start tour','jwt'):$content;
		$str = sprintf("<input type=\"button\" id=\"%s\" name=\"%s\" href=\"javascript:void(0);\" alt=\"%s\" title=\"%s\" class=\"%s\" value=\"%s\" />",$id,$id,$alt,$title,$class,$content);
		$str .= $this->shortcode_sitetour($atts,$content,$code);
		
		return $str;
	}
	
	function shortcode_sitetour_trigger($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'alt'=>'',
			'title'=>'',
			'class'=>''
		), $atts));	
		
		$id = $this->prefix.($this->uid++);
		$atts['selector']="#$id";
		$atts['autostart']=1;
		$content = trim($content)==''?__('Start tour','jwt'):$content;
		$str = sprintf("<a id=\"%s\" href=\"javascript:void(0);\" alt=\"%s\" title=\"%s\" class=\"%s\">%s</a>",$id,$alt,$title,$class,$content);
		$str .= $this->shortcode_sitetour($atts,$content,$code);
		
		return $str;
	}
	
	function shortcode_sitetour($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'controls' 	=> 'yes',
			'ids'		=> '',
			'start_id'	=> 0,
			'selector'	=> false,
			'intro'		=> false,
			'skin'		=> false,
			'autostart' => 1
		), $atts));

		$tour_ids = $ids==''?array():explode(',',$ids);
		$tour_ids = empty($tour_ids) && intval($start_id)>0 ? array(intval($start_id)):$tour_ids;
		if(is_array($tour_ids)&&count($tour_ids)>0){
			foreach($tour_ids as $i => $id){
				$tour_ids[$i]=intval($id);
			}
			//---
			$args = array(
				'post__in'		=> $tour_ids,
				'post_type'		=> 'jwt',
				'post_status'	=> 'publish',
				'posts_per_page'=> $this->max_number_of_tours_per_page,
				//'orderby'		=> 'menu_order',
				//'order'			=> 'ASC',
				'numberposts'	=> -1
			);
			$tours = get_posts($args);
			//sort in the order they where typed.
			$tmp = array();
			foreach($tour_ids as $id){
				foreach($tours as $t){
					if($t->ID==$id){
						$tmp[]=$t;
					}
				}
			}
			$tours = $tmp;
			//----
			$r = $this->tours_settings($tours);
			if(false!==$r){	
				$r->more_settings->donotshow=0;
				if(intval($start_id)>0){
					$r->more_settings->tour_id = $start_id;
				}
				
				if(false!==$intro){
					$r->more_settings->intro = $intro;
				}
				
				if(false!==$skin){
					$r->more_settings->skin = $skin;
				}
				
				$r->more_settings->controls = strtolower($controls)=='no'?0:1;
				if($r->more_settings->controls==0){
					//force autoplay.
					foreach($r->settings as $i => $t){
						$r->settings[$i]->autoplay = 1;
					}
					if(intval($start_id)==0&&isset($tour_ids[0])){
						$r->more_settings->tour_id = intval($tour_ids[0]);
					}
				}
				
				if(null!=$autostart){
					$r->more_settings->autostart = $autostart?1:0;
				}
				//output.
				if(false===$selector){
					$this->jwt_init($r->settings,$r->more_settings);
				}else{
?><script>jQuery(document).ready(function($){$('<?php echo $selector?>').click(function(){try {jwt_init(<?php echo json_encode($r->settings)?>,<?php echo json_encode($r->more_settings)?>);}catch(e){}});});</script><?php				
				}
			}		
		}
	}	
	
	function template_redirect(){
		global $wp_query;
		$o = $wp_query->get_queried_object();
		if(is_object($o)&&property_exists($o,'post_type')&&$o->post_type=='jwt'){
			$tour_uri = trim( $this->get_tour_uri($o->ID) );
			if(''!=$tour_uri){
				$url = $tour_uri.'#tour-'.$o->ID;
				wp_redirect($url);
				exit();
			}
		}
	}	
}
?>