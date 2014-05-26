<?php
      
/**
 * Template Name: Question Page Template
 *

 */

?>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
$( "#tabs" ).tabs();
});
</script>

<?php get_header( 'question' ); ?>



<div id="tabs">
<ul>
<li><a href="#tabs-1">Popular</a></li>
<li><a href="#tabs-2">New</a></li>
<li><a href="#tabs-3">Friends</a></li>
</ul>
<div id="tabs-1">
<?php dynamic_sidebar('Popular Questions' );?>
</div>
<div id="tabs-2">
<?php dynamic_sidebar('New Questions'); ?>
</div>
<div id="tabs-3">
<?php do_action( 'bp_before_members_loop' ); ?>
<?php $count = 0; ?>
<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>
<?php while ( bp_members() ) : bp_the_member(); ?>
<?php global $bp; $friend = BP_Friends_Friendship::check_is_friend( get_current_user_id(), bp_get_member_user_id() ); if  ($friend == 'is_friend') {   $member =  bp_get_member_user_id(); ?>
<?php $args = array( 'post_type' => 'question', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post(); ?>
<?php $author_id = $post->post_author; ?>
<?php if($member == $author_id){?>
<?php $count++ ?>
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
<div class="question-share"><a class="reshare-button1 bp-secondary-action" rel="905" id="bp-reshare" title="Shared" href="http://mariasplace.com/activity/reshare/add/905/?_wpnonce=ba68aef136"><span class="bp-reshare-img reshared">Shared</span></a> </div>


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

<?php
}
endwhile; 
}
endwhile; 
endif; 
if($count == 0){
echo "Sorry, there is no Question from your Friend's";
}
do_action( 'bp_after_members_loop' );	?>	 
</div>
</div>



<?php get_footer( 'question' ); ?>