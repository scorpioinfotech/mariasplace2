<?php

class QA_Widget_Helper extends WP_Widget {
	var $default_instance = array();

	function parse_instance( $instance ) {
		return wp_parse_args( $instance, $this->default_instance );
	}

	function widget( $args, $instance ) {
		$instance = $this->parse_instance( $instance );

		extract($args);
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		$this->content( $instance );

		echo $after_widget;
	}

	function title_field( $title ) {
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', QA_TEXTDOMAIN ); ?></label>
			<?php
			echo _qa_html( 'input', array(
				'class' => 'widefat',
				'type' => 'text',
				'id' => $this->get_field_id('title'),
				'name' => $this->get_field_name('title'),
				'value' => $title
			) );
			?>
		</p>
<?php
	}
}

class QA_Widget_Questions extends QA_Widget_Helper {

	var $default_instance = array(
		'title' => '',
		'which' => 'recent',
		'tags' => '',
		'categories' => '',
		'number' => 5
	);

	function QA_Widget_Questions() {
		$widget_ops = array( 'description' => __( 'List of questions selectable from recent, most popular and unanswered ones', QA_TEXTDOMAIN ) );
		$this->WP_Widget( 'questions', __( 'Q&A: Questions', QA_TEXTDOMAIN ), $widget_ops );

	}

	function content( $instance ) {
		global $post, $_qa_core;

		// Check if action is there
		if ( has_action( 'pre_get_posts', array( $_qa_core, 'questions_per_page' ) ) ) {
			$had_action = true;
			// Remove posts per page setting so that widget shows the correct number of items
			remove_action( 'pre_get_posts', array( $_qa_core, 'questions_per_page' ) );
		}
		else
			$had_action = false;

		extract( $instance );

		if ( !isset( $number ) )
			$number = 5;

		switch ( $which ) {
			case 'recent':
				$args = array();
				break;
			case 'popular':
				$args = array( 'meta_key' => '_answer_count', 'orderby' => 'meta_value_num' );
				break;
			case 'unanswered':
				$args = array( 'qa_unanswered' => true );
				break;
		}

		$args = array_merge( $args, array(
			'post_type' => 'question',
			'posts_per_page' => $number,
			'suppress_filters' => false
		) );

		$args = apply_filters( 'qa_question_widget_args', $args, $instance );

		$tag_ids = array();
		if (isset($instance['tags']) && !empty($instance['tags'])) {
			$args['question_tag'] = $instance['tags'];
		}

		$cat_ids = array();
		if (isset($instance['categories']) && !empty($instance['categories'])) {
			$args['question_category'] = $instance['categories'];
		}


		
		foreach ( get_posts( $args ) as $post ) {
			setup_postdata( $post ); ?>

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
					
					<div class="qa-voting-wrap">
					<?php the_question_voting();
do_action( 'qa_before_question_meta' ); ?>
<div class="qa-voting-box"><span class="span <?php echo get_the_ID(); ?>"></span></div></div>
<div class="commentshow">Comment</div>
<a class="reshare-button1 bp-secondary-action" rel="905" id="bp-reshare" title="Shared" href="http://mariasplace.com/activity/reshare/add/905/?_wpnonce=ba68aef136"><span class="bp-reshare-img reshared">Shared</span></a>
 <?php the_qa_action_links( get_the_ID() ); ?>
<!--a title="Report this item" id="like-activity-<?php get_the_ID(); ?>" class="like" href="#">
					<span class="icon-flag"></span>
					</a -->

<?php //echo do_shortcode('[social_share url="http://mariasplace.com" title="My Website"/]'); ?>

					<?php //the_qa_action_links( get_the_ID() ); ?>
					

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
		<?php }
		
		wp_reset_postdata();

		// Add the action back
		if ( $had_action )
			add_action( 'pre_get_posts', array( $_qa_core, 'questions_per_page' ) );
	}

	function form( $instance ) {
		$instance = $this->parse_instance( $instance );
		$this->title_field( $instance['title'] );
?>

		<p>
			<label for="<?php echo $this->get_field_id('which'); ?>"><?php _e( 'Which:', QA_TEXTDOMAIN ); ?></label>
			<select id="<?php echo $this->get_field_id('which'); ?>" name="<?php echo $this->get_field_name('which'); ?>">
				<?php
				$options = array(
					'recent' => __( 'Recent', QA_TEXTDOMAIN ),
					'popular' => __( 'Popular', QA_TEXTDOMAIN ),
					'unanswered' => __( 'Unanswered', QA_TEXTDOMAIN ),
				);

				foreach ( $options as $value => $title ) {
					$attr = compact( 'value' );
					if ( $instance['which'] == $value )
						$attr['selected'] = 'selected';
					echo _qa_html( 'option', $attr, $title );
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e( 'Tags:', QA_TEXTDOMAIN ); ?></label>
			<?php
			echo _qa_html( 'input', array(
				'type' => 'text',
				'size' => 30,
				'id' => $this->get_field_id('tags'),
				'name' => $this->get_field_name('tags'),
				'value' => $instance['tags']
			) );
			?>
			<div class="instructions"><?php _e( 'Comma separated', QA_TEXTDOMAIN ); ?></div>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e( 'Categories:', QA_TEXTDOMAIN ); ?></label>
			<?php
			echo _qa_html( 'input', array(
				'type' => 'text',
				'size' => 30,
				'id' => $this->get_field_id('categories'),
				'name' => $this->get_field_name('categories'),
				'value' => $instance['categories']
			) );
			?>
			<div class="instructions"><?php _e( 'Comma separated', QA_TEXTDOMAIN ); ?></div>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of questions to show:', QA_TEXTDOMAIN ); ?></label>
			<?php
			echo _qa_html( 'input', array(
				'type' => 'text',
				'size' => 2,
				'id' => $this->get_field_id('number'),
				'name' => $this->get_field_name('number'),
				'value' => $instance['number']
			) );
			?>
		</p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = $this->parse_instance( $new_instance );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['which'] = $new_instance['which'];
		$instance['tags'] = $new_instance['tags'];
		$instance['categories'] = $new_instance['categories'];
		$instance['number'] = (int) $new_instance['number'];
		return $instance;
	}
}


class QA_Widget_Tags extends QA_Widget_Helper {

	var $default_instance = array(
		'title' => '',
	);

	function QA_Widget_Tags() {
		$widget_ops = array( 'description' => __( 'The most popular question tags in cloud format', QA_TEXTDOMAIN ) );
		$this->WP_Widget( 'question_tags', __( 'Q&A: Question Tags', QA_TEXTDOMAIN ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract($args);

		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			$tax = get_taxonomy( 'question_tag' );
			$title = $tax->labels->name;
		}
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		echo '<div class="question-tagcloud">';
		wp_tag_cloud( array(
			'taxonomy' => 'question_tag',
			'topic_count_text_callback' => array( $this, 'count_text_callback' ),
		) );
		echo "</div>\n";
		echo $after_widget;
	}

	function count_text_callback( $count ) {
		return sprintf( _n('1 question', '%s questions', $count), number_format_i18n( $count ) );
	}

	function form( $instance ) {
		$instance = $this->parse_instance( $instance );
		$this->title_field( $instance['title'] );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}
}


class QA_Widget_Categories extends QA_Widget_Helper {

	var $default_instance = array(
		'title' => '',
		'count' => false
	);

	function QA_Widget_Categories() {
		$widget_ops = array( 'description' => __( 'A list of question categories', QA_TEXTDOMAIN ) );
		$this->WP_Widget( 'question_categories', __( 'Q&A: Question Categories', QA_TEXTDOMAIN ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			$tax = get_taxonomy( 'question_category' );
			$title = $tax->labels->name;
		}
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$cat_args = array(
			'taxonomy' => 'question_category',
			'orderby' => 'name',
			'hierarchical' => true,
			'show_count' => $instance['count'],
			'title_li' => ''
		);

		$cat_args = apply_filters( 'qa_category_widget_args', $cat_args, $instance );

		echo '<ul>';
		wp_list_categories( $cat_args );
		echo '</ul>';

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = $this->parse_instance( $instance );
		$this->title_field( $instance['title'] );
?>
		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $instance['count'] ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show question counts', QA_TEXTDOMAIN ); ?></label><br />
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = !empty( $new_instance['count'] );

		return $instance;
	}
}

class QA_Widget_Reputation extends QA_Widget_Helper {

	var $default_instance = array(
		'title' => '',
		'number' => 5
	);

	function QA_Widget_Reputation() {
		$widget_ops = array( 'description' => __( 'A list of users having highest reputation points', QA_TEXTDOMAIN ) );
		$this->WP_Widget( 'question_reputation', __( 'Q&A: Users with Highest Reputation', QA_TEXTDOMAIN ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$instance = $this->parse_instance( $instance );

		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		}
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM " . $wpdb->usermeta . " WHERE meta_key='_qa_rep' AND meta_value > 0  ORDER BY CONVERT(meta_value, SIGNED) DESC LIMIT " . (int)$instance['number'] . " " );

		if ( $results ) {
			echo '<ul>';
			do_action( 'qa_reputation_widget_before', $results );
			foreach ( $results as $result ) {
				echo '<li class="qa-user-item">';
				the_qa_user_link( $result->user_id );
				echo " (". $result->meta_value . ")";
				echo '</li>';
			}
			do_action( 'qa_reputation_widget_after', $results );
			echo '</ul>';
		}

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = $this->parse_instance( $instance );
		$this->title_field( $instance['title'] );
?>
		<label for="<?php echo $this->get_field_id('number'); ?>">
		<?php _e( 'Number of users to show:', QA_TEXTDOMAIN ); ?></label>
			<?php
			echo _qa_html( 'input', array(
				'type' => 'text',
				'size' => 2,
				'id' => $this->get_field_id('number'),
				'name' => $this->get_field_name('number'),
				'value' => $instance['number']
			) );
			?>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = !empty( $new_instance['count'] );

		return $instance;
	}
}

function qa_widgets_init() {
	if ( !is_blog_installed() )
		return;

	register_widget( 'QA_Widget_Questions' );

	register_widget( 'QA_Widget_Tags' );

	register_widget( 'QA_Widget_Categories' );

	register_widget( 'QA_Widget_Reputation' );
}

add_action( 'widgets_init', 'qa_widgets_init' );
