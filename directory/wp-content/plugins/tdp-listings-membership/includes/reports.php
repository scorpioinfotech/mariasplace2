<?php
/*
	Load All Reports
*/
$tdp_reports_dir = dirname(__FILE__) . "/../adminpages/reports/";
$cwd = getcwd();
chdir($tdp_reports_dir);
foreach (glob("*.php") as $filename) 
{
	require_once($filename);
}
chdir($cwd);

/*
	Load Reports From Theme
*/
$tdp_reports_theme_dir = get_stylesheet_directory() . "/tdp-listings-membership/reports/";
if(is_dir($tdp_reports_theme_dir))
{
	$cwd = getcwd();
	chdir($tdp_reports_theme_dir);
	foreach (glob("*.php") as $filename) 
	{
		require_once($filename);
	}
	chdir($cwd);
}