<?php

/**
 * Template Name: Test Page Template
 *

 */

?>
<?php get_header( 'question' ); ?>


<div class="qa-left-side">
<?php
global $qa_general_settings;

if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
	get_sidebar( 'question' );
?>
</div>


<div class="qa-right-side">

<div id="qa-page-wrapper">
	<div id="qa-content-wrapper">
		<?php //do_action( 'qa_before_content', 'archive-question' ); ?>

		<?php the_qa_error_notice(); ?>
		<?php the_qa_menu(); ?>

		<?php if ( !have_posts() ) : ?>

			<p><?php $question_ptype = get_post_type_object( 'question' ); echo $question_ptype->labels->not_found; ?></p>

		<?php else: ?>
<?php
global $wp_query;

single_cat_title('Category: ');	   	  			    				 

?>


			<div id="question-list">
			
	
			<?php while ( have_posts() ) : the_post(); 
?>

				<div class="quertion-wrap test">	
				<?php do_action( 'qa_before_question_loop' ); ?>
<?php the_qa_author_box( get_the_ID() ); ?>
				<div class="question">
					<?php do_action( 'qa_before_question' ); 
?>

					
					<div class="question-summary">
						<?php do_action( 'qa_before_question_summary' ); ?>
						<h3><?php the_question_link(); ?></h3>
						<?php the_question_tags( '<div class="question-tags">', ' ', '</div>' ); ?>
						<div class="question-started">
							<?php the_qa_time( get_the_ID() ); ?>
							by <?php the_qa_user_link( $post->post_author ); ?>
						</div>
						<?php do_action( 'qa_after_question_summary' ); ?>
					</div>
<div class="question-stats">
						<?php do_action( 'qa_before_question_stats' ); ?>
						<!--div class="qa-status-icon <?php //echo (is_question_answered())?'qa-answered-icon':'qa-unanswered-icon'; ?>"></div-->
						<?php //the_question_score(); ?>
						<?php the_question_status(); ?>
						<?php do_action( 'qa_after_question_stats' ); ?>
					</div>
<div class="question-meta">
					<?php the_question_voting();
do_action( 'qa_before_question_meta' ); ?>
<div class="commentshow">Comment</div>
<a class="reshare-button1 bp-secondary-action" rel="905" id="bp-reshare" title="Shared" href="http://mariasplace.com/activity/reshare/add/905/?_wpnonce=ba68aef136"><span class="bp-reshare-img reshared">Shared</span></a>
<a title="Report this item" id="like-activity-<?php get_the_ID(); ?>" class="like" href="#">
					<span class="icon-flag"></span>
					</a>

<?php //echo do_shortcode('[social_share url="http://mariasplace.com" title="My Website"/]'); ?>

					<?php the_qa_action_links( get_the_ID() ); ?>
					

					<?php do_action( 'qa_after_question_meta' ); ?>
				</div>
					<?php do_action( 'qa_after_question' ); ?>
<?php if ( ($user_ID == 0 && qa_visitor_can('publish_answers')) || current_user_can( 'publish_answers' ) ) { ?>
	<div id="edit-answer">
		<?php do_action( 'qa_before_edit_answer' ); ?>

		<h2><?php // _e( 'Your Answer', QA_TEXTDOMAIN ); ?></h2>
		<?php the_answer_form(); ?>

		<?php do_action( 'qa_after_edit_answer' ); ?>
	</div>
	<?php } ?>
				</div>

				<?php do_action( 'qa_after_question_loop' ); ?>
				</div><!--#question-list-->
			<?php endwhile; $wp_query->set('posts_per_page', 6); ?>
			
			
			
			
			
</div>
			<?php the_qa_pagination(); ?>

			<?php do_action( 'qa_after_content', 'archive-question' ); ?>

		<?php endif;?>
	</div>
</div><!--#qa-page-wrapper-->

</div>




<?php get_footer( 'question' ); ?>