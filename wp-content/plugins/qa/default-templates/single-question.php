<?php
global $user_ID, $post;
get_header( 'question' );
?>



<div class="qa-left-side">
<?php
global $qa_general_settings;

if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
	get_sidebar( 'buddypress-4' );
?>
</div>

<div class="qa-right-side">
<div id="qa-page-wrapper">
	<div id="qa-content-wrapper">
<!--div id="qa-menu">
<div class="create-post"><span class="icon-plus"></span><a href="http://mariasplace.com/questions/ask/">Ask Question</a></div>
</div-->
	<?php do_action( 'qa_before_content', 'single-question' ); ?>

	<?php the_qa_menu(); ?>

	<?php if ( ($user_ID == 0 && qa_visitor_can('read_questions')) || current_user_can( 'read_questions' ) ) { ?>
	<?php wp_reset_postdata(); ?>
	<div id="single-question">
		
		<div id="single-question-container">
			<!--?php the_question_voting(); ? -->
			<?php the_qa_author_box( get_the_ID() ); ?>
			<div id="question-body">
			<h1><?php the_title(); ?></h1>
				<div id="question-content"><?php echo the_content(); ?></div>
				<!-- ?php the_question_category(  __( 'Category:', QA_TEXTDOMAIN ) . ' <span class="question-category">', '', '</span>' ); ? -->
				<!-- ?php the_question_tags( __( 'Tags:', QA_TEXTDOMAIN ) . ' <span class="question-tags">', ' ', '</span>' ); ? -->
				<div class="question-started">
							<?php the_qa_time( get_the_ID() ); ?>
							by <?php the_qa_user_link( $post->post_author ); ?>
						</div>

				<div class="question-meta">
<div class="qa-voting-wrap">
						<?php the_question_voting();
    do_action( 'qa_before_question_meta' ); ?>
    <div class="qa-voting-box"><span class="span <?php echo get_the_ID(); ?>"></span></div></div>
    <div class="commentshow">Comment</div>
    <div class="question-share"><a class="reshare-button1 bp-secondary-action" rel="905" id="bp-reshare" title="Shared" href="http://mariasplace.com/activity/reshare/add/905/?_wpnonce=ba68aef136"><span class="bp-reshare-img reshared">Shared</span></a> </div>
<?php the_qa_action_links( get_the_ID() ); ?>


					<?php do_action( 'qa_after_question_meta' ); ?>

				</div>
					<div id="edit-answer">
		<?php do_action( 'qa_before_edit_answer' ); ?>

		<h2><?php // _e( 'Your Answer', QA_TEXTDOMAIN ); ?></h2>
		<?php the_answer_form(); ?>

		<?php do_action( 'qa_after_edit_answer' ); ?>
	</div>



			</div>
		</div>
	</div>
	<?php } ?>
<div id="answer-list" class="hide-ans" style="display:none;"> 
		<?php do_action( 'qa_before_answers' ); ?>

		<h2><?php the_answer_count(); ?></h2>
		<?php the_answer_list(); ?>
			
		<?php do_action( 'qa_after_answers' ); ?>
	</div>
	<?php if ( (( ($user_ID == 0 && qa_visitor_can('read_answers')) || current_user_can( 'read_answers' )) ) && is_question_answered() ) { ?>
	<div id="answer-list">
		<?php do_action( 'qa_before_answers' ); ?>

		<h2><?php the_answer_count(); ?></h2>
		<?php the_answer_list(); ?>
			
		<?php do_action( 'qa_after_answers' ); ?>
	</div>
	<?php } ?>
	<?php if ( ($user_ID == 0 && qa_visitor_can('publish_answers')) || current_user_can( 'publish_answers' ) ) { ?>
	<div id="edit-answer">
		<?php do_action( 'qa_before_edit_answer' ); ?>

		<h2><?php // _e( 'Your Answer', QA_TEXTDOMAIN ); ?></h2>
		<?php the_answer_form(); ?>

		<?php do_action( 'qa_after_edit_answer' ); ?>
	</div>
	<?php } ?>

	<p><?php //the_question_subscription(); ?></p>

	<?php do_action( 'qa_after_content', 'single-question' ); ?>
	</div>

</div><!--#qa-page-wrapper-->

</div>


<?php get_footer( 'question' ); ?>
