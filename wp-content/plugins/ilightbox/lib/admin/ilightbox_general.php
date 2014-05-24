<?php
$galleries = $this->ilightbox_get_option('ilightbox_added_galleries');
$bindeds = $this->ilightbox_get_option('ilightbox_bindeds');
?>
<div class="wrap" id="ilightbox_admin_wrap">
	<div class="ilightbox_admin_content clearfix">
	<?php require_once('ilightbox_menu.php');?>

	<div class="ilightbox_navbar">
		<div>
			<a data-target="#ilightbox_galleries" class="active">Galleries</a>
			<a data-target="#ilightbox_bindeds">Bindeds</a>
		</div>
	</div>
	
	<div class="clear"></div>

	<div id="ilightbox_galleries" class="contents_holder clearfix" style="display: block;">
<?php
if(count($galleries) == 0){
?>
			<div class="empty">No galleries found.</div>
<?php
} else {

	krsort($galleries);
	foreach($galleries as $key => $data){
		$slides = $data['slides'];
		$thumb = "";
		$user_info = get_userdata($data['uid']);
		$i = 0;
		while ($i < count($slides)) {
			if(!$thumb && @$slides[$i]['thumbnail']) {
				$thumb = $slides[$i]['thumbnail'];
				break;
			}
			$i++;
		}
?>
	<div class="ilightbox_gallery_item">
		<div class="actions">
			<a class="bind" data-id="<?php echo $key; ?>">Bind</a>
			<a class="edit load_page" href="?page=ilightbox_create&id=<?php echo $key; ?>">Edit</a>
			<a class="preview" data-id="<?php echo $key; ?>">Preview</a>
			<a class="remove" data-id="<?php echo $key; ?>">Remove</a>
		</div>
		<img src="<?php echo ($thumb) ? $thumb : $this->ILIGHTBOX_URL."css/images/nothumb.png"; ?>" class="ilightbox_gallery_thumb" />
		<div class="ilightbox_gallery_details">
			<div class="user">
				<img src="<?php echo "http://1.gravatar.com/avatar/".md5($user_info->user_email)."?s=30"; ?>" />
				<?php echo $user_info->display_name; ?>
			</div>
			<div class="time">
				<?php echo human_time_diff( $data['lastEdit'] ); ?>
			</div>
			<div class="clear"></div>
			<div class="gallery_name">{id:<?php echo $key; ?>} <?php echo ($data['gallery_name']) ? $data['gallery_name'] : '(no name)'; ?></div>
		</div>
	</div>
<?php
	}
	
}
?>
	</div>
	
	<div id="ilightbox_bindeds" class="contents_holder clearfix">
<?php
if(count($bindeds) == 0){
?>
			<div class="empty">No bindeds found.</div>
<?php
} else {

	krsort($bindeds);
	foreach($bindeds as $key => $value){
		$id = $value['id'];
		$data = $galleries[$id];
		$slides = $data['slides'];
		$thumb = "";
		$user_info = get_userdata($value['uid']);
		$i = 0;
		while ($i < count($slides)) {
			if(!$thumb && @$slides[$i]['thumbnail']) {
				$thumb = $slides[$i]['thumbnail'];
				break;
			}
			$i++;
		}
?>
	<div class="ilightbox_gallery_item">
		<div class="actions">
			<a class="edit_bind" data-info="{ 'id':'<?php echo $key; ?>', 'gid':'<?php echo $id; ?>', 'query':'<?php echo htmlentities($value['query'], ENT_QUOTES); ?>', 'event':'<?php echo $value['event']; ?>', 'return':'<?php echo $value['return']; ?>' }">Edit</a>
			<a class="unbind" data-id="<?php echo $key; ?>">Unbind</a>
		</div>
		<img src="<?php echo ($thumb) ? $thumb : $this->ILIGHTBOX_URL . "css/images/nothumb.png"; ?>" class="ilightbox_gallery_thumb" />
		<div class="ilightbox_gallery_details">
			<div class="user">
				<img src="<?php echo "http://1.gravatar.com/avatar/".md5($user_info->user_email)."?s=30"; ?>" />
				<?php echo $user_info->display_name; ?>
			</div>
			<div class="time">
				<?php echo human_time_diff( $value['lastEdit'] ); ?>
			</div>
			<div class="clear"></div>
			<div class="gallery_name"><?php echo ($data['gallery_name']) ? $data['gallery_name'] : '(no name)'; ?></div>
		</div>
	</div>
<?php
	}
	
}
?>
	</div>
	
			<div class="clear"></div>
		</div>
	</div>
</div><!-- #ilightbox_admin_wrap -->