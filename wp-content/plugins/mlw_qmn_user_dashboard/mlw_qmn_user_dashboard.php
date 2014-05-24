<?php

/*
Plugin Name: QMN User Dashboards
Description: Use this plugin to add a dashboard for users to see and review their results
Version: 1.0
Author: Frank Corso
Author URI: http://www.mylocalwebstop.com/
Plugin URI: http://www.mylocalwebstop.com/
*/

/* 
Copyright 2014, My Local Webstop (email : fpcorso@mylocalwebstop.com)

Disclaimer of Warranties. 

The plugin is provided "as is". My Local Webstop and its suppliers and licensors hereby disclaim all warranties of any kind, 
express or implied, including, without limitation, the warranties of merchantability, fitness for a particular purpose and non-infringement. 
Neither My Local Webstop nor its suppliers and licensors, makes any warranty that the plugin will be error free or that access thereto will be continuous or uninterrupted.
You understand that you install, operate, and uninstall the plugin at your own discretion and risk.
*/


///Files to Include
include("includes/mlw_qmn_user_dashboard_shortcode.php");
include("includes/mlw_qmn_user_dashboard_admin.php");
include("includes/mlw_qmn_user_dashboard_settings.php");

///Activation Actions
add_action('admin_menu', 'mlw_qmn_dashboard_add_admin');
add_action('admin_menu', 'mlw_qmn_dashboard_add_settings', 11);
add_shortcode('mlw_qmn_user_dashboard', 'mlw_qmn_user_dashboard_shortcode');
register_activation_hook( __FILE__, 'mlw_qmn_dashboard_activate');

//Create User Dashboard
function mlw_qmn_dashboard_add_settings()
{
	if (function_exists('add_submenu_page'))
	{
		add_submenu_page('quiz-master-next/mlw_quizmaster2.php', 'User Dashboard Settings', 'User Dashboard Settings', 'moderate_comments', 'mlw_qmn_user_dashboard_settings', 'mlw_qmn_user_dashboard_settings');
	}
}

///Create Admin Pages
function mlw_qmn_dashboard_add_admin()
{
	if (function_exists('add_menu_page'))
	{
		add_menu_page('My Results', 'My Results', 'read', __FILE__, 'mlw_qmn_user_dashboard_admin', 'dashicons-feedback');
	}
}

add_action('admin_init', 'mlw_qmn_dashboard_register_settings' );
function mlw_qmn_dashboard_register_settings(){
    register_setting( 'mlw_qmn_dashboard_settings', 'mlw_qmn_dashboard_option' );
}

function mlw_qmn_dashboard_activate()
{
	$mlw_options = array();
	$mlw_options[quiz_name_check] = 1;
	$mlw_options[quiz_name_text] = "Quiz Name";
	$mlw_options[quiz_score_check] = 1;
	$mlw_options[quiz_score_text] = "Score";
	$mlw_options[quiz_time_check] = 1;
	$mlw_options[quiz_time_text] = "Time Taken";
	$mlw_options[results_template] = "<h1>Quiz Results</h1>
You scored %CORRECT_SCORE%!

Out of %TOTAL_QUESTIONS%, you got %AMOUNT_CORRECT% correct. Here are your answers:

%QUESTIONS_RESULTS%";
	$mlw_options[question_results_template] = "%QUESTION%";

	$mlw_options[next_button_text] = "Next 10 Results";
	$mlw_options[previous_button_text] = "Previous 10 Results";
	$mlw_options[view_text] = "View";
	$mlw_options[not_user_text] = "You must be logged in to see your results.";

	if ( ! get_option('mlw_qmn_dashboard_option'))
	{
		add_option('mlw_qmn_dashboard_option' , $mlw_options);
	}
	
}

/*


*/
?>