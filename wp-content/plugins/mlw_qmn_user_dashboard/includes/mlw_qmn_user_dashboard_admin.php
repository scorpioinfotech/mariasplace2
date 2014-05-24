<?php

function mlw_qmn_user_dashboard_admin() {
	if ( is_user_logged_in() )
	{
		global $wpdb;
		$current_user = wp_get_current_user();
		$mlw_qmn_table_limit = 10;
		$mlw_qmn_results_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(result_id) FROM " . $wpdb->prefix . "mlw_results WHERE deleted='0' AND (user=%d OR email='%s')", get_current_user_id(), $current_user->user_email ) );
		
		if( isset($_GET['mlw_result_page'] ) )
		{
		   $mlw_qmn_result_page = $_GET['mlw_result_page'] + 1;
		   $mlw_qmn_result_begin = $mlw_qmn_table_limit * $mlw_qmn_result_page ;
		}
		else
		{
		   $mlw_qmn_result_page = 0;
		   $mlw_qmn_result_begin = 0;
		}
		$mlw_qmn_result_left = $mlw_qmn_results_count - ($mlw_qmn_result_page * $mlw_qmn_table_limit);
		$mlw_quiz_data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "mlw_results WHERE deleted='0' AND  (user=%d OR email='%s') ORDER BY result_id DESC LIMIT %d, %d", get_current_user_id(), $current_user->user_email, $mlw_qmn_result_begin, $mlw_qmn_table_limit ) );
	?>
	<!-- css -->
	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" />
	<!-- jquery scripts -->
	<?php
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_script( 'jquery-ui-button' );
	wp_enqueue_script( 'jquery-ui-accordion' );
	wp_enqueue_script( 'jquery-ui-tooltip' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'jquery-effects-blind' );
	wp_enqueue_script( 'jquery-effects-explode' );
	?>
	<script type="text/javascript">
		var $j = jQuery.noConflict();
		// increase the default animation speed to exaggerate the effect
		$j.fx.speeds._default = 1000;
		$j(function() {
			$j("button, #prev_page, #next_page").button();
		
		});
		function show_results(id)
		{
			jQuery(".mlw_qmn_results_div").hide();
			jQuery('#result_div_'+id).show();
		}
	</script>
	<div class="wrap">
	<div class='mlw_quiz_options'>
	<h2>My Results</h2>
	<?php 
	$quotes_list = "";
	$mlw_qmn_results_list = "";
	$display = "";
	$alternate = "";
	$mlw_qmn_dashboard_options = get_option('mlw_qmn_dashboard_option');
	foreach($mlw_quiz_data as $mlw_quiz_info) {
		if($alternate) $alternate = "";
		else $alternate = " class=\"alternate\"";
		$quotes_list .= "<tr{$alternate}>";
		$quotes_list .= "<td><span style='color:green;font-size:16px;'><a href=\"javascript:show_results(".$mlw_quiz_info->result_id.");\">".$mlw_qmn_dashboard_options['view_text']."</a></span></td>";
		if ( $mlw_qmn_dashboard_options['quiz_name_check'] == 1)
		{
			$quotes_list .= "<td><span style='font-size:16px;'>" . $mlw_quiz_info->quiz_name . "</span></td>";
		}
		if ( $mlw_qmn_dashboard_options['quiz_score_check'] == 1)
		{
			if ($mlw_quiz_info->quiz_system == 0)
			{
				$quotes_list .= "<td class='post-title column-title'><span style='font-size:16px;'>" . $mlw_quiz_info->correct ." out of ".$mlw_quiz_info->total." or ".$mlw_quiz_info->correct_score."%</span></td>";
			}
			if ($mlw_quiz_info->quiz_system == 1)
			{
				$quotes_list .= "<td><span style='font-size:16px;'>" . $mlw_quiz_info->point_score . " Points</span></td>";
			}
			if ($mlw_quiz_info->quiz_system == 2)
			{
				$quotes_list .= "<td><span style='font-size:16px;'>Not Graded</span></td>";
			}
		}
		if ( $mlw_qmn_dashboard_options['quiz_time_check'] == 1)
		{
			$quotes_list .= "<td><span style='font-size:16px;'>" . $mlw_quiz_info->time_taken ."</span></td>";
		}
		$quotes_list .= "</tr>";
		
		$mlw_qmn_question_answers = "";
		$mlw_qmn_comment_section = "";
		$mlw_qmn_timer = 0;
		$mlw_qmn_results_array = @unserialize($mlw_quiz_info->quiz_results);
		if (!is_array($mlw_qmn_results_array)) {
			$mlw_qmn_question_answers = htmlspecialchars_decode($mlw_results_data->quiz_results, ENT_QUOTES);
			$mlw_qmn_comment_section = "";
			$mlw_qmn_timer = 0;
		}
		else
		{
			$mlw_qmn_comment_section = $mlw_qmn_results_array[2];
			$mlw_qmn_timer = $mlw_qmn_results_array[0];
			$mlw_qmn_answer_array = $mlw_qmn_results_array[1];
			foreach( $mlw_qmn_answer_array as $mlw_each )
			{
				$mlw_qmn_question_results = $mlw_qmn_dashboard_options['question_results_template'];
				$mlw_qmn_question_results = str_replace( "%QUESTION%" , htmlspecialchars_decode($mlw_each[0], ENT_QUOTES), $mlw_qmn_question_results);
				$mlw_qmn_question_results = str_replace( "%ANSWER_PROVIDED%" , htmlspecialchars_decode($mlw_each[1], ENT_QUOTES), $mlw_qmn_question_results);
				$mlw_qmn_question_results = str_replace( "%CORRECT_ANSWER%" , htmlspecialchars_decode($mlw_each[2], ENT_QUOTES), $mlw_qmn_question_results);
				$mlw_qmn_question_results = str_replace( "%COMMENTS_PROVIDED%" , htmlspecialchars_decode($mlw_each[3], ENT_QUOTES), $mlw_qmn_question_results);	
				$mlw_qmn_question_results .= "<br /><br />";
				$mlw_qmn_question_answers .= $mlw_qmn_question_results;				
			}
		}
		$mlw_qmn_dashboard_results_template = $mlw_qmn_dashboard_options['results_template'];
		$mlw_qmn_dashboard_results_template = str_replace( "%POINT_SCORE%" , $mlw_quiz_info->point_score, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%AVERAGE_POINT%" , $mlw_quiz_info->point_score/$mlw_quiz_info->total, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%AMOUNT_CORRECT%" , $mlw_quiz_info->correct, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%TOTAL_QUESTIONS%" , $mlw_quiz_info->total, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%CORRECT_SCORE%" , $mlw_quiz_info->correct_score, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%QUIZ_NAME%" , $mlw_quiz_info->quiz_name, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%USER_NAME%" , $mlw_quiz_info->name, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%USER_BUSINESS%" , $mlw_quiz_info->business, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%USER_PHONE%" , $mlw_quiz_info->phone, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%USER_EMAIL%" , $mlw_quiz_info->email, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%QUESTIONS_RESULTS%" , $mlw_qmn_question_answers, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%COMMENT_SECTION%" , $mlw_qmn_comment_section, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "%TIMER%" , $mlw_qmn_timer, $mlw_qmn_dashboard_results_template);
		$mlw_qmn_dashboard_results_template = str_replace( "\n" , "<br>", $mlw_qmn_dashboard_results_template);
		
		$mlw_qmn_results_list .= "<div id='result_div_".$mlw_quiz_info->result_id."' class='mlw_qmn_results_div' style='display:none;'>";
		$mlw_qmn_results_list .= $mlw_qmn_dashboard_results_template;
		$mlw_qmn_results_list .= "</div>";
	}
	
	if( $mlw_qmn_result_page > 0 )
	{
	   	$mlw_qmn_previous_page = $mlw_qmn_result_page - 2;
	   	$display .= "<a id=\"prev_page\" href=\"?page=mlw_qmn_user_dashboard/mlw_qmn_user_dashboard.php&&mlw_result_page=$mlw_qmn_previous_page\">".$mlw_qmn_dashboard_options['previous_button_text']."</a>";
	   	if( $mlw_qmn_result_left > $mlw_qmn_table_limit )
	   	{
			$display .= "<a id=\"next_page\" href=\"?page=mlw_qmn_user_dashboard/mlw_qmn_user_dashboard.php&&mlw_result_page=$mlw_qmn_result_page\">".$mlw_qmn_dashboard_options['next_button_text']."</a>";
	   	}
	}
	else if( $mlw_qmn_result_page == 0 )
	{
	   if( $mlw_qmn_result_left > $mlw_qmn_table_limit )
	   {
			$display .= "<a id=\"next_page\" href=\"?page=mlw_qmn_user_dashboard/mlw_qmn_user_dashboard.php&&mlw_result_page=$mlw_qmn_result_page\">".$mlw_qmn_dashboard_options['next_button_text']."</a>";
	   }
	}
	else if( $mlw_qmn_result_left < $mlw_qmn_table_limit )
	{
	   $mlw_qmn_previous_page = $mlw_qmn_result_page - 2;
	   $display .= "<a id=\"prev_page\" href=\"?page=mlw_qmn_user_dashboard/mlw_qmn_user_dashboard.php&&mlw_result_page=$mlw_qmn_previous_page\">".$mlw_qmn_dashboard_options['previous_button_text']."</a>";
	}

	$display .= "<table class=\"widefat\">";
	$display .= "<thead><tr><th>&nbsp;</th>";
	if ( $mlw_qmn_dashboard_options['quiz_name_check'] == 1)
	{
		$display .= "<th>".$mlw_qmn_dashboard_options['quiz_name_text']."</th>";
	}
	if ( $mlw_qmn_dashboard_options['quiz_score_check'] == 1)
	{
		$display .= "<th>".$mlw_qmn_dashboard_options['quiz_score_text']."</th>";
	}
	if ( $mlw_qmn_dashboard_options['quiz_time_check'] == 1)
	{
		$display .= "<th>".$mlw_qmn_dashboard_options['quiz_time_text']."</th>";
	}
	$display .= "</tr></thead>";
	$display .= "<tbody id=\"the-list\">{$quotes_list}</tbody>";
	$display .= "</table>";
	
	
	echo $display;
	echo "<br />";
	echo $mlw_qmn_results_list;
	?>
	</div>
	</div>
	<?php
	}
}

?>