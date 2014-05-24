<?php

function mlw_qmn_user_dashboard_settings()
{
	?>
	<div class="wrap">
        <h2>User Dashboard Settings</h2>
        <p>For users with access to the dashboard, they can visit their results with the new My Results page. For those without access to the dashboard, create a new post or page and insert the shortcode [mlw_qmn_user_dashboard] into it.</p>
        <h3>Template Variables</h3>
			<table class="form-table">
			<tr>
				<td><strong>%POINT_SCORE%</strong> - Total points user earned when taking quiz</td>
				<td><strong>%AVERAGE_POINT%</strong> - The average amount of points user had per question</td>
			</tr>
	
			<tr>
				<td><strong>%AMOUNT_CORRECT%</strong> - The number of correct answers the user had</td>
				<td><strong>%TOTAL_QUESTIONS%</strong> - The total number of questions in the quiz</td>
			</tr>
			
			<tr>
				<td><strong>%CORRECT_SCORE%</strong> - The percent score for the quiz showing percent of total quetions answered correctly</td>
			</tr>
	
			<tr>
				<td><strong>%USER_NAME%</strong> - The name the user entered before the quiz</td>
				<td><strong>%USER_BUSINESS%</strong> - The business the user entered before the quiz</td>
			</tr>
			
			<tr>
				<td><strong>%USER_PHONE%</strong> - The phone number the user entered before the quiz</td>
				<td><strong>%USER_EMAIL%</strong> - The email the user entered before the quiz</td>
			</tr>
			
			<tr>
				<td><strong>%QUIZ_NAME%</strong> - The name of the quiz</td>
				<td><strong>%QUESTIONS_RESULTS%</strong> - Shows the question, the answer the user provided, and the correct answer</td>
			</tr>
			
			<tr>
				<td><strong>%COMMENT_SECTION%</strong> - The comments the user entered into comment box if enabled</td>
			</tr>
			<tr>
				<td><strong>%TIMER%</strong> - The amount of time user spent of quiz</td>
			</tr>
			</table>
        <form method="post" action="options.php">
            <?php settings_fields('mlw_qmn_dashboard_settings'); ?>
            <?php $options = get_option('mlw_qmn_dashboard_option'); ?>
            <h3>Table Settings</h3>
            <table class="form-table">
                <tr valign="top"><th scope="row">Show Quiz Name?</th>
                    <td><input name="mlw_qmn_dashboard_option[quiz_name_check]" type="checkbox" value="1" <?php checked('1', $options['quiz_name_check']); ?> /></td>
                </tr>
                <tr valign="top"><th scope="row">Text For Quiz Name Column</th>
                    <td><input type="text" name="mlw_qmn_dashboard_option[quiz_name_text]" value="<?php echo $options['quiz_name_text']; ?>" /></td>
                </tr>
                <tr valign="top"><th scope="row">Text For Next Button</th>
                    <td><input type="text" name="mlw_qmn_dashboard_option[next_button_text]" value="<?php echo $options['next_button_text']; ?>" /></td>
                </tr>
                <tr valign="top"><th scope="row">Text For Previous Button</th>
                    <td><input type="text" name="mlw_qmn_dashboard_option[previous_button_text]" value="<?php echo $options['previous_button_text']; ?>" /></td>
                </tr>
                <tr valign="top"><th scope="row">Text For View Link</th>
                    <td><input type="text" name="mlw_qmn_dashboard_option[view_text]" value="<?php echo $options['view_text']; ?>" /></td>
                </tr>
                <tr valign="top"><th scope="row">Text For When User Is Not Logged In</th>
                    <td><input type="text" name="mlw_qmn_dashboard_option[not_user_text]" value="<?php echo $options['not_user_text']; ?>" /></td>
                </tr>
                <tr valign="top">
					<td width="30%">
						<strong>Results Template</strong>
						<br />
						<p>Allowed Variables: </p>
						<p style="margin: 2px 0">- %POINT_SCORE%</p>
						<p style="margin: 2px 0">- %AVERAGE_POINT%</p>
						<p style="margin: 2px 0">- %AMOUNT_CORRECT%</p>
						<p style="margin: 2px 0">- %TOTAL_QUESTIONS%</p>
						<p style="margin: 2px 0">- %CORRECT_SCORE%</p>
						<p style="margin: 2px 0">- %QUIZ_NAME%</p>
						<p style="margin: 2px 0">- %USER_NAME%</p>
						<p style="margin: 2px 0">- %USER_BUSINESS%</p>
						<p style="margin: 2px 0">- %USER_PHONE%</p>
						<p style="margin: 2px 0">- %USER_EMAIL%</p>
						<p style="margin: 2px 0">- %COMMENT_SECTION%</p>
						<p style="margin: 2px 0">- %QUESTIONS_RESULTS%</p>
						<p style="margin: 2px 0">- %TIMER%</p>
					</td>
					<td><textarea cols="80" rows="15" name="mlw_qmn_dashboard_option[results_template]"><?php echo $options['results_template']; ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<td width="30%">
						<strong>%QUESTIONS_RESULTS% Template</strong>
						<br />
						<p>Allowed Variables: </p>
						<p style="margin: 2px 0">- %USER_NAME%</p>
						<p style="margin: 2px 0">- %QUIZ_NAME%</p>
						<p style="margin: 2px 0">- %QUESTION%</p>
						<p style="margin: 2px 0">- %ANSWER_PROVIDED%</p>
					</td>
					<td><textarea cols="80" rows="15" name="mlw_qmn_dashboard_option[question_results_template]"><?php echo $options['question_results_template']; ?></textarea>
					</td>
				</tr>
            </table>
            <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div>
	<?php
}
?>