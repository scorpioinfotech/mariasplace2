<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class jwt_editor {
	var $post_meta_boxes;
	function jwt_editor($args=array()){
		$defaults = array(
			'capability'			=> 'jwt_manage'
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}			
		//---
		add_action('admin_head-post.php', array(&$this, 'admin_head') );
		add_action('admin_head-post-new.php', array(&$this, 'admin_head') );	
		if(!class_exists('post_meta_boxes'))require_once('class.post_meta_boxes.php');		
		$this->post_meta_boxes = new post_meta_boxes(array(
			'post_type'=>'jwt',
			'options'=>$this->metaboxes(),
			'styles'=>array('post-meta-boxes','smoothness'),
			'scripts'=>array('jquery-ui-droppable','jquery-ui-draggable','jquery-ui-tabs'),
			'pluginpath'=>JWT_PATH
		));
		
		add_action('wp_ajax_jwt_load_attachments', array(&$this,'jwt_load_attachments'));
		add_action('wp_ajax_jwt_add_attachment', array(&$this,'jwt_add_attachment'));
		add_action('wp_ajax_jwt_save_attachment_field', array(&$this,'jwt_save_attachment_field'));
		add_action('wp_ajax_jwt_delete_attachments', array(&$this,'jwt_delete_attachments'));
		add_action('wp_ajax_jwt_save_order', array(&$this,'jwt_save_order'));
	}
	/* START ajax */
	function check_ajax(){
		if(current_user_can('manage_options')||current_user_can($this->capability)){
			return true;
		}else{
			return false;
		}
	}	
	
	function remove_actions(){
		remove_all_actions('save_post');
		remove_all_actions('new_to_publish');
	}		
	
	function jwt_save_attachment_field(){
		if(!$this->check_ajax()){
			die(json_encode(array("R"=>"ERR",'MSG'=>'No access')));
		}
		$post_id = isset($_REQUEST['post_id'])?intval($_REQUEST['post_id']):0;
		$name = isset($_REQUEST['name'])?$_REQUEST['name']:0;
		$value= isset($_REQUEST['value'])?$_REQUEST['value']:0;
		
		$parts = explode("_",$name);
		$attachment_id = array_pop($parts);
		
		$meta_name = implode("_",$parts);
		//die(json_encode(array("R"=>"ERR",'MSG'=>"POSTID $post_id NAME $name $attachment_id")));
		//die(json_encode(array("R"=>"ERR",'MSG'=>"meta $meta_name")));
		$post_fields = $this->get_post_fields();
		$meta_fields = $this->get_meta_fields();
		if(in_array($meta_name,$post_fields)){
			$post = array(
				'ID'=>$attachment_id,
				"$meta_name"=>$value
			);
			$result = wp_update_post($post);
			if(0==$result){
				die(json_encode(array("R"=>"OK",'MSG'=>'Error updating main attachment field.')));
			}
		}else if(in_array($meta_name,$meta_fields)){
			update_post_meta($attachment_id,$meta_name,$value);
		}else{
			die(json_encode(array("R"=>"OK",'MSG'=>'Field name is not valid. '.$name)));
		}
		die(json_encode(array("R"=>"OK",'MSG'=>'')));
	}
	
	function jwt_load_attachments(){
		if(!$this->check_ajax()){
			die('No access');	
		}	
		//-------------------------
		$post_id = isset($_REQUEST['post_id'])?intval($_REQUEST['post_id']):0;		
		if($post_id<=0){
			die('Missing paramenter, post_id');
		}

		$args = array(
			'numberposts'	=> -1,
			'post_type'		=>'jwt-slide',
			'post_parent' 	=> $post_id,
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC'
		);
		$attachments = get_children($args);
		if (is_array($attachments)&&count($attachments)>0) {
			foreach ($attachments as $attachment) {
?>
<div id="jwt-settings-<?php echo $attachment->ID?>" class="settings-cont" rel="<?php echo $attachment->ID?>">
	<div class='jwt-settings'>
		<?php $this->get_attachment_form($attachment)?>
	</div>
</div>
<?php				
			}
		}	
		die();
	}

	function jwt_add_attachment(){
		if(!$this->check_ajax()){
			die(json_encode(array("R"=>"ERR",'MSG'=>'No access')));
		}
		$post_id = isset($_REQUEST['post_id'])?intval($_REQUEST['post_id']):0;
		$selector = isset($_REQUEST['selector'])?$_REQUEST['selector']:false;
		$position = isset($_REQUEST['position'])&&''!=trim($_REQUEST['position'])?$_REQUEST['position']:false;
		if(!current_user_can('edit_post',$post_id)){
			die(json_encode(array("R"=>"ERR",'MSG'=>'No access')));
		}	
		$attachment = array(
		   'post_title' 	=> 'Tour slide',
		   'post_content' 	=> '',
		   'post_status' 	=> 'inherit',
		   'post_type'		=>'jwt-slide',
		   'post_parent'	=> $post_id,
		   'menu_order'		=> $this->_last_menu_order($post_id)
		);
		
		$this->remove_actions();
		$attach_id = wp_insert_post( $attachment );

		if($attach_id>0){
			if(false!==$selector){
				update_post_meta($attach_id,'selector',$selector);
			}
			if(false!==$position){
				update_post_meta($attach_id,'position',$position);
			}
			die(json_encode(array(
				"R" 		=> "OK",
				"MSG"		=> "",
				"ID"		=> $attach_id
			)));			
		}else{
			die(json_encode(array("R"=>"ERR",'MSG'=>'Error Creating Attachment.'.($attach_id))));
		}
	}	
	
	function _last_menu_order($post_id){
		$args = array(
			'numberposts'	=> 1,
			'post_type'=>'jwt-slide',
			'post_parent' => $post_id,
			'orderby'	=> 'menu_order',
			'order'=>'DESC'
		);

		$attachments = get_children($args);			
		if ($attachments) {
			foreach($attachments as $a){
				return ($a->menu_order + 1);
			}
		}else{
			return 0;
		}		
	}
	
	function jwt_delete_attachments(){
		if(!$this->check_ajax()){
			die(json_encode(array("R"=>"ERR",'MSG'=>'No access')));
		}
		$attach_id = isset($_REQUEST['attach_id'])?intval($_REQUEST['attach_id']):0;
		global $wpdb;
		if(!in_array( $wpdb->get_var("SELECT post_type FROM $wpdb->posts WHERE ID=$attach_id",0,0) ,array('jwt-slide'))){
			die(json_encode(array("R"=>"ERR",'MSG'=>'Post type is not deletable.')));
		}		
		
		if($attach_id>0){
			wp_delete_post( $attach_id,true);
		}
		//-------------------------
		die(json_encode(array("R"=>"OK",'MSG'=>'')));
	}
	
	function jwt_save_order(){
		global $wpdb;
		
		if(!$this->check_ajax()){
			die(json_encode(array("R"=>"ERR",'MSG'=>'No access')));	
		}	
		
		foreach(array('post_id','ids') as $field){
			$$field = isset($_REQUEST[$field])?$_REQUEST[$field]:false;
			if(false===$$field){
				die(json_encode(array("R"=>"ERR",'MSG'=>'Missing parameter.')));
			}
		}		
		
		if(!current_user_can('edit_post',$post_id)){
			die(json_encode(array("R"=>"ERR",'MSG'=>'No access(2)')));
		}	
	
		$ids = is_array($ids)&&count($ids)>0?$ids:false;
		if(false===$ids){
			die(json_encode(array("R"=>"ERR",'MSG'=>'Settings error, empty sorting ids.')));
		}
		
		$args = array(
			'post_type'	=> 'jwt-slide',
			'post_parent' => $post_id,
			'orderby'	=> 'menu_order',
			'order'=>'ASC'
		);
		
		$attachments = get_children($args);		
		foreach ($attachments as $attachment) {
			$new_position = array_search($attachment->ID,$ids);
			$new_position = false===$new_position?999:$new_position;
			$attachment->menu_order = $new_position;
			wp_update_post( $attachment );
		}	
		
		die(json_encode(array("R"=>"OK",'MSG'=>'')));
	}
	/* end ajax */
	function tour_slides($tab,$i,$o,&$save_fields){
		//$save_fields[]='sample';
?>

<?php	
	}
		
	function get_attachment_form($post){
		$tips = array(
			'TL'=>'Top Left',
			'TR'=>'Top Right',
			'BL'=>'Bottom Left',
			'BR'=>'Bottom Right',
			'LT'=>'Left Top',
			'LB'=>'Left Bottom',
			'RT'=>'Right Top',
			'RB'=>'Right Bottom',
			'T'=>'Top',
			'R'=>'Right',
			'B'=>'Bottom',
			'L'=>'Left'
		);
		
		$position = get_post_meta($post->ID,'position',true);
		$time = get_post_meta($post->ID,'time',true);
		$time = ''==$time?5000:$time;
?>
<div class="meta-tabs tour-slide-tab" rel="<?php echo $post->ID?>">
	<ul>
		<li class="meta-tab-settings"><a href="#meta-tab-settings-<?php echo $post->ID ?>">Settings</a></li>
		<li class="meta-tab-css"><a href="#meta-tab-css-<?php echo $post->ID ?>">Tooltip</a></li>
		<li class="meta-tab-selector"><a href="#meta-tab-selector-<?php echo $post->ID ?>">Advanced</a></li>
	</ul>
	<div id="meta-tab-settings-<?php echo $post->ID ?>">	
		<div class="tab-status"></div>
		<div class="tab-fieldset">
			<input type="button" class="btn-show-slide button-secondary" value="Show" />
			<input type="button" class="ico-close btn-show-slide button-primary" value="Delete" rel='<?php echo $post->ID?>' />
			<input type="button" value="Save" name="save-attachments" class="button-primary save-attachments">
		</div>	
		<div class="tab-fieldset">
			<label for="content">Content:&nbsp;</label>
			<textarea class='slide-content' rel="<?php echo $post->ID ?>" name="post_content_<?php echo $post->ID ?>"><?php echo $post->post_content?></textarea>
			<div class="clear"></div>
		</div>
	</div>
	<div id="meta-tab-css-<?php echo $post->ID ?>">	
		<div class="tab-status"></div>
		<div class="tab-fieldset">
			<input type="button" class="btn-show-slide button-secondary" value="Show" />
			<input type="button" class="ico-close btn-show-slide button-primary" value="Delete" rel='<?php echo $post->ID?>' />
			<input type="button" value="Save" name="save-attachments" class="button-primary save-attachments">
		</div>		
		<div class="tab-fieldset">
			<label for="position">Tip position</label>
			<select class="slide-tip-position" rel="<?php echo $post->ID ?>" name="position_<?php echo $post->ID ?>">
<?php foreach($tips as $value => $label):?>
				<option <?php echo $value==$position?'selected="selected"':''?> value="<?php echo $value?>"><?php echo $label?></option>
<?php endforeach;?>
			</select>		
			<div class="clear"></div>
		</div>		
		
		<div class="tab-fieldset">
			<label for='width'>Width</label>
			<input type="range" min="20" max="1000" step="1" rel="<?php echo $post->ID ?>"  class="slide-width rangeinput-slider" name="width_<?php echo $post->ID ?>" value="<?php echo ''==get_post_meta($post->ID,'width',true)?250:get_post_meta($post->ID,'width',true)?>" />		
			<div class="clear"></div>
		</div>		
		
		<div class="tab-fieldset">
			<label for='v-offset'>Vertical offset</label>
			<input type="range" min="-100" max="100" step="1" rel="<?php echo $post->ID ?>"  class="slide-v-offset rangeinput-slider" name="v_offset_<?php echo $post->ID ?>" value="<?php echo ''==get_post_meta($post->ID,'v_offset',true)?0:get_post_meta($post->ID,'v_offset',true)?>" />		
			<div class="clear"></div>
		</div>	
		
		<div class="tab-fieldset">
			<label for='h-offset'>Horizontal offset</label>
			<input type="range" min="-100" max="100" step="1" rel="<?php echo $post->ID ?>"  class="slide-h-offset rangeinput-slider" name="h_offset_<?php echo $post->ID ?>" value="<?php echo ''==get_post_meta($post->ID,'h_offset',true)?0:get_post_meta($post->ID,'h_offset',true)?>" />		
			<div class="clear"></div>
		</div>	
		
		<div class="tab-fieldset" style="display:none;">
			<label for='color'>Color</label>
			<input id="color_<?php echo $post->ID ?>" rel="<?php echo $post->ID ?>" type="text" class="slide-color jwt-colorpicker" name="color_<?php echo $post->ID ?>" value="<?php echo get_post_meta($post->ID,'color',true)?>" />	
			<div class="clear"></div>
		</div>
		<div class="tab-fieldset" style="display:none;">
				<label for='bgcolor'>BgColor</label>
				<input id="bgcolor_<?php echo $post->ID ?>" rel="<?php echo $post->ID ?>" type="text" class="slide-bgcolor jwt-colorpicker" name="bgcolor_<?php echo $post->ID ?>" value="<?php echo get_post_meta($post->ID,'bgcolor',true)?>" />						
			<div class="clear"></div>
		</div>	
	</div>
	<div id="meta-tab-selector-<?php echo $post->ID ?>">	
		<div class="tab-status"></div>
		<div class="tab-fieldset">
			<input type="button" class="btn-show-slide button-secondary" value="Show" />
			<input type="button" class="ico-close btn-show-slide button-primary" value="Delete" rel='<?php echo $post->ID?>' />
			<input type="button" value="Save" name="save-attachments" class="button-primary save-attachments">
		</div>		
		<div class="tab-fieldset">
			<label>Transition delay(milliseconds)</label>
			<input type="range" min="0" max="30000" step="100" rel="<?php echo $post->ID ?>"  class="slide-time rangeinput-slider" name="time_<?php echo $post->ID ?>" value="<?php echo $time?>" />		
			<div class="clear"></div>
		</div>		
		<div class="tab-fieldset">
			<label>Selector</label>
			<input type="button" class="button-secondary change-selector" value="Change" rel="selector_<?php echo $post->ID ?>" />
			<div id="msg_selector_<?php echo $post->ID ?>" class="msg_selector"></div>
			<input class="slide-selector" rel="<?php echo $post->ID ?>" type="text" id="selector_<?php echo $post->ID ?>" name="selector_<?php echo $post->ID ?>" value="<?php echo get_post_meta($post->ID,'selector',true)?>" />		
			<div class="clear"></div>
		</div>			
	</div>	
</div>
<?php
	}
	
	function get_post_fields(){
		$attachment_fields = array('post_title','post_content');
		return apply_filters('jwt_post_fields',$attachment_fields);
	}
	
	function get_meta_fields(){
		$attachment_fields = array('position','width','color','bgcolor','time','selector','v_offset','h_offset');
		return apply_filters('jwt_meta_fields',$attachment_fields);
	}
	
	function admin_head(){
		global $post;
		if($post->post_type!='jwt')
			return;	
			
		add_action('admin_footer',array(&$this,'admin_footer'));
		wp_print_styles('jwt-editor');
		wp_print_styles('eyecon-colorpicker');
		wp_print_scripts('eyecon-colorpicker');
		wp_print_scripts('jquery-tools-rangeinput');
		wp_print_scripts('jquery-scrollto');
?>
<script type='text/javascript'>
var post_id = '<?php echo $post->ID?>';
var jwt_settings;
var jwt_change_selector=false;
jwt_settings = {
	sel: '#list-of-attachments',
	save_action: 'jwt_save_attachment_field',
	load_action: 'jwt_load_attachments',
	delete_action: 'jwt_delete_attachments',
	add_action: 'jwt_add_attachment',
	save_order_action: 'jwt_save_order'
};

jQuery(document).ready(function($){
	$(".wrap h2").html("");
	$(".wrap h2").html("<?php _e('jQuery Website Tour','jwt') ?>");
	
	$('.save-attachments').live('click',function(){
		load_attachments(jwt_settings);	
	});
	
	load_attachments(jwt_settings);
	
	$('#btn-search-uri').click(function(){	
		var settings = {
			start_url: '<?php echo site_url()?>',
			start_frame_url: '<?php echo JWT_URL.'helper_selector.php'?>',
			sync_fields: [ ['tour_uri','helper_tour_uri'],['tour_url','helper_url'] ]
		};
		if( $('#tour-url').val()!='' ){
			settings.start_url = $('#tour-url').val();
		}
		$('#helper-uri-selector').helper_browser(settings);
	});
	
	$('.btn-show-slide').live('click',function(){
		if('undefined'!=typeof(window.frames.helper_frame.admin_displayTooltip)){
			var tab = $(this).closest('.meta-tabs');
			var sel = $(tab).find('.slide-selector').val();			
			if( $('#helper_frame').contents().find(sel).length > 0 ){
				settings = {
					elem:		$('#helper_frame').contents().find(sel),
					position: 	$(tab).find('.slide-tip-position').val(),
					content: 	$(tab).find('.slide-content').val(),
					v_offset:	$(tab).find('.slide-v-offset').val(),
					h_offset:	$(tab).find('.slide-h-offset').val(),
					skin:	$('#skin').val()
				};
				if(''!=$(tab).find('.slide-width').val()){
					settings.width = $(tab).find('.slide-width').val();
					settings.width = ''==settings.width?250:settings.width;
				}
				if(''!=$(tab).find('.slide-color').val()){
					settings.color = $(tab).find('.slide-color').val();
					settings.color = ''==settings.color?'white':'#'+settings.color;
				}
				if(''!=$(tab).find('.slide-bgcolor').val()){
					settings.bgcolor = $(tab).find('.slide-bgcolor').val();
					settings.bgcolor = ''==settings.bgcolor?'black':'#'+settings.bgcolor;
				}				
				window.frames.helper_frame.admin_displayTooltip(settings);
			}
		}
	});
	
	$('.change-selector').live('click',function(e){
		if( $(this).hasClass('active') ){
			jwt_change_selector=false;
			$('.change-selector').removeClass('active').addClass('inactive').val('Change');
			$('.msg_selector').html('');
		}else{
			$('.change-selector').removeClass('active').addClass('inactive').val('Change');
			$('.msg_selector').html('');
			
			jwt_change_selector=$(this).attr('rel');
			$(this).removeClass('inactive').addClass('active').val('Cancel');
			$('#msg_'+$(this).attr('rel')).html('<strong>Click on the new location.</strong>');			
		}
	});
});

</script>
<?php
		wp_print_scripts('jwt-editor');
	}
	
	function admin_footer(){
?>
<div id="helper-uri-selector">
		<div class="helper-top">
			<div class="">
				<label>URL:</label>
				<input type="text" class="helper-url" name="helper_url" value="" />
				<input class="btn_go button-secondary" type="button" value="Go" />&nbsp;&nbsp;
			</div>
			<div class="">
				<label>Uri:</label>
				<input class="helper-tour-uri" type="text" name="helper_tour_uri" value="" />
				<input class="btn_accept button-secondary" type="button" value="Accept" />
				<input class="btn_close button-secondary" type="button" value="Back" />
				<div class="helper-status">Type the url of the page where you want to apply this Website Tour and press on "Go"</div>
			</div>
		</div>
		<div class="helper-body">
			<div class="left-tool-cont">
				<div id="list-of-attachments"></div>
				<div class="left-filler"></div>
			</div>		
			<div class="frame-cont">
				<iframe id="helper_frame" name="helper_frame" class="helper-frame" src=""></iframe>
			</div>		
		</div>
		<div class="helper-clear"></div>
</div>
<?php	
	}
	
	function tour_uri($tab,$i,$o,&$save_fields){
		//$save_fields[]='tour_uri';//Bug #17309 pass by reference in call_user_func
		$this->post_meta_boxes->save_fields[]='tour_url';
		$this->post_meta_boxes->save_fields[]='tour_uri';
?>
<label><?php echo $o->label?> </label>
<input id="tour-url" type="hidden" name="tour_url" value="<?php echo get_post_meta($o->post->ID,'tour_url',true)?>" />
<input id="tour-uri" type="text" name="tour_uri" value="<?php echo $o->value?>" />
<input id="btn-search-uri" class="button-secondary" type="button" name="search-uri" value="Search" />
<?php	
	}
	
	function tour_link($tab,$i,$o,&$save_fields){
		$this->post_meta_boxes->save_fields[]='tour_link';
		$args = array(
			'post_type'		=> 'jwt',
			'posts_per_page'=> -1,
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC',
			'numberposts'	=> -1,
			'exclude'		=> array($o->post->ID)
		);
		$tours = get_posts($args);
?>
<label><?php echo $o->label?> </label>
<select name="tour_link">
<option value="">--not applicable--</option>
<?php if(is_array($tours)&&count($tours)>0):foreach($tours as $t):?>
<option <?php echo $t->ID==get_post_meta($o->post->ID,'tour_link',true)?'selected="selected"':'' ?> value="<?PHP echo $t->ID?>"><?php echo $t->post_title ?></option>
<?php endforeach;endif;?>
</select>
<?php	
	}
	
	function metaboxes($t=array()){
		$i = count($t);
		//------------------------------
		$i++;
		$t[$i] = (object)array();
		$t[$i]->id 			= 'jwt-settings'; 
		$t[$i]->label 		= __('General Settings','jwt');
		$t[$i]->right_label	= __('Skin','jwt');
		$t[$i]->page_title	= __('General Settings','jwt');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'=>'skin',
				'type'=>'select',
				'options'=>array(
					'default'=>'Grey',
					'black'=>'Black',
					'blue'=>'Blue',
					'green'=>'Green',
					'purple'=>'Purple',
					'red'=>'Red'
				),
				'label'=>__('Skin','jwt'),
				'description'=> __("Choose a default skin for the website tour",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'=>'tour_uri',
				'type'=>'callback',
				'callback'=>array(&$this,'tour_uri'),
				'label'=>__('Tour URI','jwt'),
				'description'=> __("This is identifies where you want the tour to be triggered.  Click on search and browse to the page where you want the tour to be displayed.  Then click on accept.",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'=>'tour_link',
				'type'=>'callback',
				'callback'=>array(&$this,'tour_link'),
				'label'=>__('Tour Link','jwt'),
				'description'=> __("Optional.  If you are creating a tour that is taking place on multiple pages you must link the tours together by choosing the next tour from the dropdown.",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'=>'gotouri',
				'type'=>'yesno',
				
				'label'=>__('Redirect to URI','jwt'),
				'default'=>'1',
				'description'=> sprintf("<strong>%s</strong> %s<br /><strong>%s</strong> %s", __("Yes (default):","jwt"), __("On tour activation the browser will be redirected to the tour URI","jwt"), __("No:","jwt"), __("The page will not be redirected to the tour URI","jwt") ),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'=>'autostart',
				'type'=>'yesno',
				
				'label'=>__('Show control on load','jwt'),
				'default'=>'1',
				'description'=> sprintf("<strong>%s</strong> %s<br /><strong>%s</strong> %s", __("Yes (default):","jwt"), __("Tour control is loaded when the tour uri loads.","jwt"), __("No:","jwt"), __("Tour control does not loads when the tour uri is loaded.","jwt") ),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'=>'autoplay',
				'type'=>'yesno',
				
				'label'=>__('Autoplay','jwt'),
				'description'=> __("Choose yes to go through the tour slides without pressing the Next button.  Transition speed is controlled per slide.",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'=>'overlay',
				'type'=>'yesno',
				
				'label'=>__('Overlay','jwt'),
				'default'=>'1',
				'description'=> __("Choose yes to show an overlay when a tour is active.  If you want to allow the user to interact with the website with an active tour, choose no.",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'type'=>'clear'
			)
		);
		//------------------------------
		$i++;
		$t[$i] = (object)array();
		$t[$i]->id 			= 'jwt-control'; 
		$t[$i]->label 		= __('Tour Control','jwt');
		$t[$i]->right_label	= __('Tour Control','jwt');
		$t[$i]->page_title	= __('Tour Control','jwt');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'=>'intro',
				'type'=>'textarea',
				'label'=>__('Tour control text','jwt'),
				'description'=> __("If this is the first option in the tours list, the text will be displayed on the tour control as an introductory text.",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			)
		);		
		//--------------------------------		
		return $t;
	}	
}
?>