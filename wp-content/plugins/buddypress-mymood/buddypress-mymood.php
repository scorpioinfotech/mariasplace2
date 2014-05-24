<?php
if ( !defined( 'ABSPATH' ) ) exit;

include(BP_MYMOOD_DIR."/install.php");
include(BP_MYMOOD_DIR."/message.php");
require( dirname( __FILE__ ) . '/buddypress-mymood_admin.php' );

if(get_option("bp_mymood_enable") == "yes"): //dont load all code is plugin not enable
	


add_action("wp_head","bp_mymood_head"); 
function bp_mymood_head() {
	echo '<link rel="stylesheet" id="bp-default-main-css""  href="'.BP_MYMOOD_PATH.'/style.css" type="text/css"" media="all"" />';
}

add_action("bp_activity_post_form_options","output_bp_mymood_option");
/* add MyMood option in Post Activty Form */
function output_bp_mymood_option() {
	$moods = get_option("bp_mymood_moods");
	$moods_smiley = get_option("bp_mymood_moods_smiley");
	$html = '<div class="bp-mymood-option" id="bp-mymood-option"> <div class="bp-mymood-mood"><label for="mymood_mood"> '.__("Mood :","buddypress-mymood").' </label> <select name="bp_mymood_mood" id="bp_mymood_mood" class="mymood-moods-input"><option value=""></option>';
	foreach($moods as $m) {
		$rel = (@$moods_smiley[$m] != "")?md5("bp_mymood".$moods_smiley[$m]):'';
		$html = $html.'<option rel="'.$rel.'" value="'.$m.'">'.__($m,"buddypress-mymood").'</option>';
	}
	$html = $html.'</select></div>';
	$html = $html.'<a href="javascript:;" class="bp-mymood-smiley" title="Choose Smiley" id="bp-mymood-smiley"><img src="'.BP_MYMOOD_PATH.'/images/smiley.png" alt="smiley" /></a> 
	<input type="hidden" name="bp_mymood_smiley" id="bp-mymood-smiley-input"" value=""/> 
	
	<div class="clear"></div>
	<div id="bp-mymood-smiley-popup" style="display:none">';
	
	foreach(bp_mymood_get_smiley() as $code => $url) {
		$html = $html.'<img src="'.$url.'" rel="'.$code.'" alt="'.$code.'" id="'.md5("bp_mymood".$code).'" />';
	}
		
	$html = $html.'</div>';
	$html = $html.'<div class="clear"></div>';
	$html = $html.'</div>';
	$html = str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$html), "\0..\37'\\"))); 
	echo '
	<script type="text/javascript">
	<!--
 
	function add_bp_mymood_option() {
	
	if(jQuery(".bp-mymood-option").length != 0) { //1+ fix
		return true;
	}	
		jQuery("#whats-new").first().after("'.$html.'");
	
	jQuery("#bp_mymood_mood").change(function() {
	if(jQuery(this).attr("rel") == "") {
		return false;
	}
	jQuery("#"+jQuery(this).find(":selected").attr("rel")).click();
	jQuery("#bp-mymood-smiley-popup").stop().css("display","none");
	});
	
	jQuery("#bp-mymood-smiley").click(function() {
	jQuery("#bp-mymood-smiley-popup").slideToggle(500);
	});
	jQuery("#bp-mymood-smiley-popup").find("img").each(function() {
	var img_val = jQuery(this).attr("rel");
	var img = jQuery(this).attr("src");
	jQuery(this).click(function(){
	jQuery("#bp-mymood-smiley").find("img").attr("src",img);
	jQuery("#bp-mymood-smiley-input").val(img_val);
	jQuery("#bp-mymood-smiley").click();
	});
	
	});
	}

	function verify_bp_mymood() {
	';
	
	if(get_option("bp_mymood_req") == "yes")  {
	
	echo 'if(jQuery("#bp_mymood_mood").val() == "") {
			 jQuery(".bp_mymood_message").each(function() { jQuery(this).remove(); });  
			jQuery("#bp-mymood-option").append("<div id=\"message\" class=\"error bp_mymood_message\">	<p>'.__("Please choose mood to post.","buddypress-mymood").'</p></div>");
			setTimeout(function() {  jQuery(".bp_mymood_message").each(function() { jQuery(this).remove(); });   },4000);
			return false;
	}';	 
			
	 }
	
	echo '
	return true;
	}
	
	jQuery(document).ready( function() { 
	
	add_bp_mymood_option();
	';
	
	if(BP_MYMOOD_BPFB_ACTIVE) { //Work for buddypress-activity-plus
	
	echo '
	function bp_mymood_func(e) {
	if(jQuery(e).val() != "") {
	jQuery("#bpfb_submit").each(function() { this.disabled = false; });
	}
	}
	jQuery("#bp_mymood_mood").change(function() {  bp_mymood_func(this)	});
	jQuery("#bp_mymood_mood").blur(function() {  bp_mymood_func(this)	});
	
	jQuery("#bpfb_submit").live("mousedown",function() {
	if(!verify_bp_mymood()) {
		jQuery("#bpfb_submit").attr("disabled","disabled");
	} else {
		jQuery("#bpfb_submit").each(function() { this.disabled = false; });
	}
	});
	jQuery("#bpfb_submit").live("mousedown",function() {
		
	_bpfbActiveHandler_clone = _bpfbActiveHandler.get();
	_bpfbActiveHandler_clone.bp_mymood_mood = jQuery("#bp_mymood_mood").val();
	_bpfbActiveHandler_clone.bp_mymood_smiley = jQuery("#bp-mymood-smiley-input").val();
	_bpfbActiveHandler.get = function() {
		return _bpfbActiveHandler_clone;
	}
	});	
	';
	
	}
	
	echo '
	var bp_default_submit_event = function() {	};
	setTimeout(function() { 
	
	bp_default_submit_event = jQuery("input#aw-whats-new-submit").clone(true);
	jQuery("input#aw-whats-new-submit").unbind("click"); 
	jQuery("input#aw-whats-new-submit").click(function() {
	//update data
	jQuery.ajaxSetup({data: {bp_mymood_mood: jQuery("#bp_mymood_mood").val(),	bp_mymood_smiley: jQuery("#bp-mymood-smiley-input").val()}});
	
	if(!verify_bp_mymood()) {
		return false;
	} else {
		bp_default_submit_event.click();
		jQuery("input#aw-whats-new-submit").addClass("loading");
		return false;
	}
	});
	},500); 
	
	
	});
	
	//-->
	</script>
	';
}

//post query of mood
function bp_mymood_mood_post() {
	$mood = @$_POST["bp_mymood_mood"];
	if($mood == "") {
	 	if(@$_POST['data']['bp_mymood_mood']) {
			return $_POST['data']['bp_mymood_mood'];
		}
	 }
	return $mood;
}
//post query of smiley
function bp_mymood_smiley_post() {
	 $smiley = @$_POST["bp_mymood_smiley"];
	 if($smiley == "") {
	 	if(@$_POST['data']['bp_mymood_smiley']) {
			return $_POST['data']['bp_mymood_smiley'];
		}
	 }
	 return $smiley;
}

add_action("bp_activity_before_save","bp_mymood_update_validation");

function bp_mymood_update_validation($p) {

if($p->type != "activity_update") {
	return false;
}

 $mood =  bp_mymood_mood_post();
 $smiley =  bp_mymood_smiley_post();

 if(get_option("bp_mymood_req") != "yes") {
 	if($mood == "" and $smiley == "") {
		return true;
	}
 } 
 
 if(empty($mood)) {
 	bp_core_add_message( __( 'Please choose mood to post.', 'buddypress-mymood' ), 'error' );
	bp_core_redirect( wp_get_referer() );
 	return false;
 }
 $moods = get_option("bp_mymood_moods");
 if(!in_array($mood,$moods)) {
 	bp_core_add_message( __( 'You have selected invalid mood try again.', 'buddypress-mymood' ), 'error' );
	bp_core_redirect( wp_get_referer() );
 	return false;
 }	

 if($smiley != "") {
 if(!is_smiley_exists($smiley)) {
	bp_core_add_message( __( 'Error with moods try again.', 'buddypress-mymood' ), 'error' );
	bp_core_redirect( wp_get_referer() );
	return false;
 }
 }
	
 return true;
			
}



add_action("bp_activity_after_save","bp_mymood_update");

 function bp_mymood_update($p) {

 $mood = bp_mymood_mood_post();
 $smiley =  bp_mymood_smiley_post();
 
bp_activity_update_meta($p->id,"mymood_mood",$mood);
if($smiley != "") {
bp_activity_update_meta($p->id,"mymood_smiley",$smiley);
}

 return true;
			
}

add_action("bp_activity_entry_content","bp_mymood_output_activity_post");
function bp_mymood_output_activity_post() {
	$id = bp_get_activity_id();
	
	if(bp_activity_get_meta($id,"mymood_mood") != ""):
	echo '<div class="bp-mymood-activity-post">
	<span class="mood"><strong>'.__("Mood","buddypress-mymood").'</strong> : '.__(bp_activity_get_meta($id,"mymood_mood"),"buddypress-mymood").'</span>';
	
	if(is_smiley_exists(bp_activity_get_meta($id,"mymood_smiley"))) {
	$get_smileys = bp_mymood_get_smiley();
	$smiley = bp_activity_get_meta($id,"mymood_smiley");
	echo '<img src="'.$get_smileys[$smiley].'" class="smiley"/>';
	} 
	echo '</div>';
	endif;
}
add_filter( 'bp_before_member_header_meta', 'bp_mymood_output_member_meta' );
function bp_mymood_output_member_meta() {

	if(get_option("bp_mymood_header_meta_show") != "yes") {
		return false;
	}
	
	$userId = bp_displayed_user_id();
	$activity = get_usermeta( $userId, 'bp_latest_update' );
	if(empty($activity)) {
		return FALSE;
	}
	if(bp_activity_get_meta($activity["id"],"mymood_mood") != ""):
	
	echo '<span class="bp-mymood-member-meta activity-'.$activity.'">';
	echo '<span class="mood"><strong>'.__("Mood","buddypress-mymood").'</strong> : '.__(bp_activity_get_meta($activity["id"],"mymood_mood"),"buddypress-mymood").'</span>';
	
	if(is_smiley_exists(bp_activity_get_meta($activity["id"],"mymood_smiley"))) {
	$get_smileys = bp_mymood_get_smiley();
		echo '<img src="'.$get_smileys[bp_activity_get_meta($activity["id"],"mymood_smiley")].'" class="smiley"/>';
	} 
	
	echo '</span>';
	
	endif;
}
endif; //if(get_option("bp_mymood_enable") == "yes")

//Common Functions 

function bp_mymood_get_smiley() {
	static $smiley_array;
	if(is_array($smiley_array)) {
		return $smiley_array;
	}
	$smileys = scandir(BP_MYMOOD_DIR."/smileys/".smiley_dir());
	require(BP_MYMOOD_DIR."/smileys/".smiley_dir()."/details.php");
	$smiley_array = array();
	foreach($bp_mymood_smiley as $file => $code) {
	$ext = explode(".",$file);
	$ext = end($ext);
	$ext =  strtoupper($ext);
	if($ext == "PNG" || $ext == "JPG" || $ext == "JPEG" || $ext == "GIF") {
		foreach($code as $c) {
			$smiley_array[$c] = BP_MYMOOD_PATH."/smileys/".smiley_dir()."/".$file;
		}
	}
	}
	return $smiley_array;
}

function is_smiley_exists($smiley) {

	 if(empty($smiley)){
		return false;
	 }
	$get_smileys  = bp_mymood_get_smiley();
	
	if(!array_key_exists($smiley,$get_smileys)) {
		return false;
	}
	
 	return true;
}

function smiley_dir() {
	
	if(get_option("bp_mymood_icon_pack") == "") {
		$smiley_dir = "default";
	} else {
		$smiley_dir = get_option("bp_mymood_icon_pack");
	}
	if(!file_exists(BP_MYMOOD_DIR."/smileys/".$smiley_dir)) {
		$smiley_dir = "default";
	}
 	return $smiley_dir;
}
?>