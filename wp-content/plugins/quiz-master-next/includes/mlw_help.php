<?php
/*
This page shows the user how-to's for using the plugin
*/
/* 
Copyright 2014, My Local Webstop (email : fpcorso@mylocalwebstop.com)
*/

function mlw_generate_help_page()
{
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
	wp_enqueue_script( 'jquery-effects-blind' );
	wp_enqueue_script( 'jquery-effects-explode' );
	?>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
	<script type="text/javascript">
		var $j = jQuery.noConflict();
		// increase the default animation speed to exaggerate the effect
		$j.fx.speeds._default = 1000;
		$j(function() {
			$j('#dialog').dialog({
				autoOpen: false,
				show: 'blind',
				hide: 'explode',
				buttons: {
				Ok: function() {
					$j(this).dialog('close');
					}
				}
			});
		
			$j('#opener').click(function() {
				$j('#dialog').dialog('open');
				return false;
		}	);
		});
		$j(function() {
			$j("button").button();
		});
  		$j(function() {
			$j("#accordion").accordion({
				heightStyle: "content"
			});

		});
	</script>
	<style>
		label {
	   		display: inline-block;
	    	width: 5em;
		}
	</style>
	<style type="text/css">
		div.mlw_quiz_options input[type='text'] {
			border-color:#000000;
			color:#3300CC; 
			cursor:hand;
		}
	</style>
	<div class="wrap">
	<div class='mlw_quiz_options'>
	<h2>How-To<a id="opener" href="">(?)</a></h2>
	<div id="accordion">
		<h3><a href="#">How To Create A Quiz</a></h3>
		<div>
  		In order to create a quiz, test, or survey you must first click on the Quizzes link from the side menu. Once you are on the page, you will see a Create New Quiz button. Click on this button.
  		Doing so will open a pop-up that will ask for the name of the quiz you would like to create. Once you entered the name in, click on the button that says Create Quiz. You should your
  		new quiz added to the table.
  		</div>
  		<h3><a href="#">How To Add A Question To Your Quiz</a></h3>
  		<div>
  		In order to add a question, you must first click on the Quizzes link from the side menu. Once you are on the page, click the edit link on the quiz you wish to add a question to. Once you are on the
  		Quiz Options page, navigate to the Quiz Questions tab. On the Quiz Questions tab, click on the button that says Add Question. Doing so will open a pop-up that will ask for the question, answers, hint, 
  		correct answer, points, and whether you want a comment box. Once you fill in all the necessary information, click the button that says Create Question. Your question will be added to the list of questions 
  		on the Quiz Questions tab.
  		</div>
  		<h3><a href="#">How To Edit The Text Shown Before A Quiz Or After Quiz Has Been Taken</a></h3>
  		<div>
  		First, go to the Quizzes page. From there, click edit on the quiz you would like to edit.  Once the Quiz Options page loads, click on the Quiz Text tab. This tab is used to edit all the text that can be customized 
  		on the quiz. At the top of the page, you will see a list of variables. If you put a variable in a section of text, it will be replaced by its corresponding values when the quiz is taken by the user.  Go to 
  		the section labeled Message Templates. In this section you will see a text box for the Message Displayed Before Quiz and the text box for the Message Displayed After Quiz. By customizing these boxes, you will 
  		edit the text shown to the user before the quiz and after the quiz has been taken. Once finished, click the Save Templates button.
  		</div>
  		<h3><a href="#">How To Set-Up Your Quiz For A Correct/Incorrect System</a></h3>
		<div>
  		First, go to the Quizzes page. From there, click edit on the quiz you would like to edit.  Once the Quiz Options page loads, click on the Quiz Options tab. Ensure that the "Which system is this quiz graded on?" 
  		option is set to Correct. Now, go back to the Quiz Question tab. When you add or edit a question, fill in the question and the answers. Leave the points fields at 0, and then select the correct answer using 
  		the radio buttons to the right of the answers. Fill out the rest of the question options any way you need to. Your quiz will now be graded on a correct or incorrect system.
  		</div>
  		<h3><a href="#">How To Add Your Quiz To A Post Or Page</a></h3>
		<div>
  		First go to the Quizzes page. Once there, copy the shortcode for your quiz from the Quiz Shortcode column. It should look similar to [mlw_quizmaster quiz=1]. Once you have copied your shortcode, go edit the post or 
  		page you would like to add the quiz to. Once on the edit page, paste the shortcode into the textbox. Then click Update. Now when you visit that post or page, your quiz will appear in place of the shortcode.
  		</div>
  	</div>
	<div id="dialog" title="Help">
	<h3><b>Help</b></h3>
	<p>This page contains numerous how-to's for using the plugin.</p>
	</div>	
	</div>
	</div>	
<?php
}
?>