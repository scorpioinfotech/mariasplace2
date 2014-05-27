   <script>
   // Show/Hide Comments
    jQuery(document).ready(function() {
    // Get #comment-section div
    var commentsDiv = jQuery('#commentlist');
    // Only do this work if that div isn't empty
    if (commentsDiv.length) {
    // Hide #comment-section div by default
    jQuery(commentsDiv).hide();
    // Append a link to show/hide

    // When show/hide is clicked
    jQuery('.show-comment').on('click', function(e) {
    e.preventDefault();
    // Show/hide the div using jQuery's toggle()
    jQuery(commentsDiv).toggle('slow', function() {
    // change the text of the anchor
    });
    });
    } // End of commentsDiv.length
    }); // End of Show/Hide Comments
</script>

<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if(post_password_required()) { ?>
		
	<?php
		return;
	}
	
?>

<?php

/*************************** Comment Template ***************************/

function comment_template($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	
	<div id="comment-<?php comment_ID(); ?>" class="comment-box">

		<div class="comment-avatar">
			<?php echo get_avatar($comment, $size='60',$default=get_template_directory_uri().'/lib/images/gravatar.png'); ?>
			<span class="post-author"><?php _e('Author', 'gp_lang'); ?></span>
		</div>
		
		<div class="comment-body">
			
			<div class="comment-author">
				<?php printf(__('%s', 'gp_lang'), comment_author_link()) ?>
			</div>
			
			<div class="comment-date">
				<?php comment_time(get_option('date_format')); ?>, <?php comment_time(get_option('time_format')); ?> &nbsp;&nbsp;/&nbsp; <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'gp_lang'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
				
			</div>	
					
			<div class="comment-text">
				<?php comment_text() ?>
				<?php if($comment->comment_approved == '0') { ?>
					<div class="error">
						<?php _e('Your comment is awaiting moderation.', 'gp_lang'); ?>
					</div>
				<?php } ?>
			</div>
			
		</div>	
		
	</div>

<?php } ?>

<?php if('open' == $post->comment_status OR have_comments()) { ?>	
	<div id="comments">
<?php } 

?>


	<?php if(have_comments()) { // If there are comments ?>
		<?php 
 $num_comments = get_comments_number(); 
 if($num_comments > 0){
?>
		<h3 class="comments show-comment"><?php comments_number(__('No Comments', 'gp_lang'), __('1 Comment', 'gp_lang'), __('% Comments', 'gp_lang')); ?></h3>
		<?php } ?>
		
		<ol id="commentlist">
			<?php wp_list_comments('callback=comment_template'); ?>
		</ol>
							
		<?php $total_pages = get_comment_pages_count(); if($total_pages > 1) { ?>
			<div class="wp-pagenavi comment-navi"><?php paginate_comments_links(); ?></div>
		<?php } ?>	

		<?php if('open' == $post->comment_status) { // If comments are open, but there are no comments yet ?>
		
		<?php } else { // If comments are closed ?>
		
			<h4><?php _e('Comments are now closed on this post.', 'gp_lang'); ?></h4>
	
		<?php } ?>
		
	<?php } else { // If there are no comments yet ?>
	<h3 class="comments"><?php _e('No Comments'); ?></h3>
	
	<?php } ?>

	<?php if('open' == $post->comment_status) { ?>
	
		<!--Begin Comment Form-->
		<div id="commentform">
			
			<!--Begin Respond-->
			<div id="respond">
			
				<h3><?php comment_form_title(__('Leave a Reply', 'gp_lang'), __('Respond to %s', 'gp_lang')); ?> <?php cancel_comment_reply_link(__('Cancel Reply', 'gp_lang')); ?></h3>
			
				<?php if(get_option('comment_registration') && !$user_ID) { ?>
			
					<p><?php _e('You must be logged in to post a comment.', 'gp_lang'); ?></p>
			
				<?php } else { ?>
			
					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
			<div class="comment-left">
					<?php if ($user_ID) { ?>
			
						<p><?php _e('Logged in as', 'gp_lang'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> <a href="<?php echo wp_logout_url(get_permalink()); ?>">(<?php _e('Logout', 'gp_lang'); ?>)</a></p>
			
					<?php } else { ?>
			
						<p><label for="author"><?php _e('Name', 'gp_lang'); ?> <span class="required"><?php if ($req) echo "*"; ?></span></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></p>
			
						<p><label for="email"><?php _e('Email', 'gp_lang'); ?> <span class="required"><?php if ($req) echo "*"; ?></span></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></p>
						
						<!--p><label for="url"><?php // _e('Website', 'gp_lang'); ?></label><input type="text" name="url" id="url" value="<?php // echo $comment_author_url; ?>" size="22" tabindex="3" /></p -->
						
					<?php } ?></div>
						<div class="comment-right"><p><label for="email"><?php _e('Comment', 'gp_lang'); ?> </label><textarea name="comment" id="comment" cols="5" rows="7" tabindex="4"></textarea></p></div>
					
					<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Post', 'gp_lang'); ?>" />
	
					<?php comment_id_fields(); ?>
		
					<?php do_action('comment_form', $post->ID); ?>
			
					</form>
	
				<?php } ?>
	
			</div>
			<!--End Respond-->
		
		</div>
		<!--End Comment Form-->
	
	<?php } ?>


<?php if('open' == $post->comment_status OR have_comments()) { ?>
	</div>
<?php } ?>