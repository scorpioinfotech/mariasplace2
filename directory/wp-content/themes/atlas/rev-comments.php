<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to openestate_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Atlas
 */
?>

<div class="spacer"></div>

<?php 

	echo do_shortcode( '[divider title="" style="dotted-lines2" length="long" alignment="center" contenttype="default" heading="span" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' );
	
	?>

<div id="comments" class="reviews-comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'atlas' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comment-title" class="icon-edit">
		<?php
			printf( _n( 'There is 1 review.', 'There are %1$s reviews.', get_comments_number(), 'atlas' ),
				number_format_i18n( get_comments_number() ));
			?>
		<a href="#respond" id="add-comment-link"><?php _e( 'Add your review &raquo;', 'atlas' ); ?></a>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<div class="navigation navigation-top clearfix">
			<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&laquo;</span> Older Comments', 'atlas' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&raquo;</span>', 'atlas' ) ); ?></div>
		</div> <!-- .navigation -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use dp_comment() to format the comments. */
				wp_list_comments( array( 'callback' => 'tdp_custom_comments_display' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<div class="navigation navigation-bottom clearfix">
			<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&laquo;</span> Older Comments', 'atlas' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&raquo;</span>', 'atlas' ) ); ?></div>
		</div><!-- .navigation -->
		<?php endif; // check for comment navigation ?>

	<?php endif; ?>

<?php 
$defaults = array(
	'title_reply'          => __( 'Submit A Review', 'atlas' ),
	'title_reply_to'       => __( 'Leave a Reply to %s', 'atlas' ),
	'cancel_reply_link'    => __( 'Cancel reply', 'atlas' ),
	'label_submit'         => __( 'Post Your Review', 'atlas' )
);

comment_form( $defaults ); ?>

</div><!-- #comments -->
