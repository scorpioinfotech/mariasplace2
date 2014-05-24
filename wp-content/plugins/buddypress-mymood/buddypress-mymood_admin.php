<?php
if ( !defined( 'ABSPATH' ) ) exit;

add_action('admin_menu', 'bp_mymood_admin_option');
function bp_mymood_admin_option() {
  add_submenu_page('bp-general-settings','BuddyPress MyMood Options','BuddyPress MyMood', "manage_options",__FILE__, 'bp_mymood_adminpanel');
}




function bp_mymood_adminpanel() {   ?>

<?php

if( !current_user_can( 'manage_options' ) )  
{ 
echo '<div id="message" class="error fade">
		  <p>
		    <strong>'.__("You have no permission to access this page !","buddypress-mymood").'</strong>
		  </p>
		</div>';
return true; 
}
	

?>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>

<h2>BuddyPress MyMood (<?php echo BP_MYMOOD_VERSION; ?>) <?php _e("Settings","buddypress-mymood"); ?></h2>
<div style="clear:both"></div>
<?php

if(isset($_GET["delete_mood"])) {
$moods = get_option("bp_mymood_moods");
$mood_key = array_keys($moods,$_GET["delete_mood"]);
unset($moods[$mood_key[0]]);
update_option("bp_mymood_moods",$moods);
echo '<div class="updated"><p><b>'.$_GET["delete_mood"].'</b> '.__("has been deleted","buddypress-mymood").', <a href="?page='.$_GET["page"].'">'.__("Click Here","buddypress-mymood").'</a> '.__("to go back","buddypress-mymood").'.</p></div>';
return true;	
} 

if(isset($_POST[Update])) {

if($_POST["bp_mymood_enable"] == "yes") {
	update_option('bp_mymood_enable',"yes");
} else {
	update_option('bp_mymood_enable',"no");
}

if($_POST["bp_mymood_req"] == "yes") {
	update_option('bp_mymood_req',"yes");
} else {
	update_option('bp_mymood_req',"no");
}

if($_POST["bp_mymood_header_meta_show"] == "yes") {
	update_option('bp_mymood_header_meta_show',"yes");
} else {
	update_option('bp_mymood_header_meta_show',"no");
}

update_option("bp_mymood_moods",$_POST["bp_mymood_mood"]);
$moods_smiley = array();
$i = 0;
foreach($_POST["bp_mymood_mood"] as $mood) {
	$moods_smiley[$mood] = $_POST["bp_mymood_mood_smiley"][$i];
	$i++;
}
update_option("bp_mymood_moods_smiley",$moods_smiley);

echo '<div id="message" class="updated fade">
  <p>
    <strong>'.__("Status Saved.","buddypress-mymood").'</strong>
  </p>
</div>';
} 


if(isset($_GET["sort_mood"])) {
	if($_GET["sort_mood"] == "1") {
	    $get_moods = get_option("bp_mymood_moods");
        sort($get_moods);
		update_option("bp_mymood_moods",$get_moods);
		echo '<div id="message" class="updated fade">
		  <p>
		    <strong>'.__("Mood Sorted.","buddypress-mymood").'</strong>
		  </p>
		</div>';
	}
	if($_GET["sort_mood"] == "2") {
	    $get_moods = get_option("bp_mymood_moods");
		rsort($get_moods);
		update_option("bp_mymood_moods",$get_moods);
		echo '<div id="message" class="updated fade">
		  <p>
		    <strong>'.__("Mood Sorted in Reverse Order.","buddypress-mymood").'</strong>
		  </p>
		</div>';
	}	
}
?>

<?php

?>

<div class="postbox-container" style="width:70%">


<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="form-table">

<tr valign="top">
<th scope="row"><?php echo __("Enable :","buddypress-mymood") ?></th>
<td>
<label><input name="bp_mymood_enable" type="checkbox" value="yes" <?php if(get_option("bp_mymood_enable") == "yes"): ?> checked="checked" <?php endif; ?>>&nbsp;<?php echo __("If checked then BuddyPress MyMood will not show anywhere on your site.","buddypress-mymood") ?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php echo __("Mood Requred :","buddypress-mymood"); ?></th>
<td>
<label><input name="bp_mymood_req" type="checkbox" value="yes" <?php if(get_option("bp_mymood_req") == "yes"): ?> checked="checked" <?php endif; ?>>&nbsp;<?php echo __("If checked then member will be forced to updated his/her mood with every status.","buddypress-mymood"); ?> </label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php echo __("Mood on Profile Head :","buddypress-mymood"); ?></th>
<td>
<label><input name="bp_mymood_header_meta_show" type="checkbox" value="yes" <?php if(get_option("bp_mymood_header_meta_show") == "yes"): ?> checked="checked" <?php endif; ?>>&nbsp;<?php echo __("If checked then latest mood (if any) will be shown on member profile header near name.","buddypress-mymood"); ?> </label>
</td>
</tr>
 
<tr valign="top">
<th scope="row"><?php echo __("Manage Moods :","buddypress-mymood"); ?>
<p> <input type="button" name="Update" class="button-primary" value="Add New Mood" id="add_mood" /></p>
<p>  <a href="?page=buddypress-mymood/buddypress-mymood_admin.php&sort_mood=1"><?php echo __("Sort Moods","buddypress-mymood"); ?></a> </p>
<p>  <a href="?page=buddypress-mymood/buddypress-mymood_admin.php&sort_mood=2"><?php echo __("Sort Moods (Reverse Order)","buddypress-mymood"); ?></a> </p>
</th>
<td>
<p><?php echo __("oh yeah! for sorting manually you can drag and drop moods.","buddypress-mymood"); ?></p>
<ul id="bp_moods">
<?php
$get_smiley = bp_mymood_get_smiley();
$moods = get_option("bp_mymood_moods");
$moods_smiley = get_option("bp_mymood_moods_smiley");
foreach($moods as $mood) {
	$smileyimg = "-";
	if(isset($moods_smiley[$mood])) {
	if(is_smiley_exists($moods_smiley[$mood])) {
	$smileyimg = '<img width="20" height="20" src="'.$get_smiley[$moods_smiley[$mood]].'" align="absmiddle" />';	
	}	
	}
	echo '<li class="bp-mymood-mood"> <span>'.$mood.'</span> <a href="javascript:;" title="Set Default Smiley" class="set_mood">'.$smileyimg.'</a><input type="hidden" name="bp_mymood_mood_smiley[]" class="bp_mymood_mood_smiley_input" value="'.$moods_smiley[$mood].'" />  <a href="javascript:;" title="delete this mood" class="delete_mood">x</a><input type="hidden" name="bp_mymood_mood[]" class="bp_mymood_mood_input" value="'.$mood.'" /></li> ';
}
?>
</ul>
<script type="text/javascript" src="<?php echo BP_MYMOOD_PATH."/jquery-ui.js"; ?>"></script>
<script type="text/javascript">
<!--
	jQuery(document).ready(function() {
	jQuery("#bp_moods").sortable();
	jQuery("#add_mood").click(function() {
	var moodname = prompt("Please enter the name of mood :");
	if(moodname != "") {
	var already_exists = false;
	jQuery(".bp_mymood_mood_input").each(function() {
	
	if(jQuery(this).val().toLowerCase() == moodname.toLowerCase()) {
		alert(moodname+" is already exists.!");
		already_exists = true;
	}
	
	});
	if(already_exists) {
		return false;
	}
	jQuery("#bp_moods").prepend('<li class="bp-mymood-mood"> <span>'+moodname+'</span> <a href="javascript:;" title="Set Default Smiley" class="set_mood">-</a><input type="hidden" name="bp_mymood_mood_smiley[]" class="bp_mymood_mood_smiley_input" value="" />  <a href="javascript:;" title="delete this mood" class="delete_mood">x</a><input type="hidden" name="bp_mymood_mood[]" class="bp_mymood_mood_input" value="'+moodname+'" /></li>');
	moods_delete_event();
	bp_mymood_set_event()
	}
	});
	
	moods_delete_event();
	bp_mymood_set_event()
	});
	
	function moods_delete_event() {
		jQuery(".delete_mood").each(function() {
		jQuery(this).click(function() {
		jQuery(this).parent().animate({  width: "0",   opacity: 0.0},"slow",function() { jQuery(this).remove();	});		
		});
		});
	}
	function bp_mymood_set_event() {
		jQuery(".set_mood").each(function() {
		jQuery(this).unbind("click");
		jQuery(this).click(function() {
		ele = jQuery(this);
		jQuery("#show_smiley_box").remove();
		jQuery("body").append("<div id='show_smiley_box'><div>Set Default Smiley For \"<b>"+jQuery(this).parent().find("span").html()+"\"</b></div><br /></div>");
		jQuery("#show_smiley_box")
		<?php foreach($get_smiley as $c => $f): 
		$c = str_replace("
","",$c);	$c = str_replace("\n",'',$c);	$c = str_replace('"','\"',$c);
		?>
		.append("<img src='<?php echo $f; ?>' rel='<?php echo $c; ?>' alt='<?php echo $c; ?>' width='50'/>")
		<?php endforeach; ?>
		.append("<div><a href='javascript:;' class='remove'>Remove Smiley</a><div>")
		.css("top",jQuery(this).position().top+"px")
	    .css("left",(jQuery(window).width() / 2)-(jQuery("#show_smiley_box").width() / 2)+"px")
		.find("img").each(function() {
		jQuery(this).click(function(){ 
		jQuery(ele).find("img").remove();
		jQuery(ele).html('').append('<img width="20" height="20">');
		jQuery(ele).find('img').attr("src",jQuery(this).attr("src")).attr("align","absmiddle");
		jQuery(ele).next("input").val(jQuery(this).attr("rel"));
		jQuery("#show_smiley_box").remove();
		});
		jQuery("#show_smiley_box").find(".remove").click(function() {
		jQuery(ele).html('-');
		jQuery(ele).next("input").val('');
		jQuery("#show_smiley_box").remove();
		});
		});
		});
		});
	}
//-->
</script>
</td>
</tr>

  
  
  <tr>
    <td height="26">&nbsp;</td>
    <td>
      <input type="submit" name="Update" class="button-primary" value="Update" />
    </td>
  </tr>
</table></form>


</div></div>

<style>
#show_smiley_box {
		background:white;
		-webkit-border-radius: 10px;
		border-radius: 10px;
		-webkit-box-shadow:  0px 0px 10px 4px #646464;
        box-shadow:  0px 0px 10px 4px #646464;
		position:absolute;
		z-index:200;
		padding:20px;
		text-align:center;
}
.bp-mymood-mood {
	padding:5px;
	background:#4d7306;
	color:white;
	display:block;
	float:left;
	margin:4px;
		-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
height:20px;
cursor:move
	}
.bp-mymood-mood a {
	padding:5px;
	background:gray;
	color:white;
	text-decoration:none;
		-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
height:20px;
}	
	
</style>



<!-- NEWS -->
<div class="postbox-container" style="width:28%">

 <center>
 <a href="http://webgarb.com/?s=MymoodBuddyPress+MyMood" target="_blank" title="BuddyPress MyMood"><img src="<?php echo BP_MYMOOD_PATH."/logo.png"; ?>" border="0">
 </a> 
 </center>
 <p>
 <?php echo __("Follow WebGarb on twitter.","buddypress-mymood"); ?>
 </p>
 <a href="https://twitter.com/webgarb" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @webgarb</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<p>
 <?php echo __("Tell about this plugin to your followers.","buddypress-mymood"); ?>

</p>
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://webgarb.com/buddypress-mymood/" data-text="BudyyPress MyMood plugin for BuddyPress" data-via="webgarb" data-size="large" data-hashtags="WordPress">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<p>
 <?php echo __("Latest Update.","buddypress-mymood"); ?>

</p>
 <!--Twitter-->
<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 10,
  interval: 30000,
  width: 'auto',
  height: 500,
  theme: {
    shell: {
      background: 'transparent',
      color: '#ba0000'
    },
    tweets: {
      background: 'transparent',
      color: '#878787',
      links: '#0073ff'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    behavior: 'all'
  }
}).render().setUser('webgarb').start();
</script>
<!--End Twitter-->
 
</div>
<div class="clear"></div>

<!-- NEW END -->



<h3> <?php echo __("Need Help ? Visit","buddypress-mymood"); ?> <a href="http://webgarb.com/?s=MymoodBuddyPress+MyMood">BuddyPress MyMood</a> <?php echo __("HomePage","buddypress-mymood"); ?> <a href="http://webgarb.com/?s=BuddyPress+MyMood">http://webgarb.com/?s=BuddyPress+MyMood</a></h3>

<p><?php echo __("Need a  Basic MyMood plugin for WordPress user ? Checkout Basic","buddypress-mymood"); ?> <a href="http://webgarb.com/?s=MyMood">MyMood</a> <?php echo __("plugin visit :","buddypress-mymood"); ?>  <a href="http://webgarb.com/?s=MyMood">http://webgarb.com/?s=MyMood</a></p>

<span class="description"><a href="http://webgarb.com/?s=BuddyPress+MyMood">BuddyPress MyMood</a> &copy; Copyright 2009 - 2012 <a href="http://webgarb.com">Webgarb.com</a>.  <?php echo __("MyMood Contain Graphic Smiley are property of their respective owner.","buddypress-mymood"); ?> <br />
</span>

<?php
} //End admin panel
?>