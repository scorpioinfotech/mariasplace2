<?php

/*
Plugin Name: No Adverts For Master Suite
Description: Disable the advertisements in all My Local Webstop plugins.
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
You understand that you install, operate, and unistall the plugin at your own discretion and risk.
*/

register_activation_hook( __FILE__, 'mlw_ms_adverts_activate');
register_deactivation_hook( __FILE__, 'mlw_ms_adverts_deactivate');
add_action('admin_init', 'mlw_ms_adverts_update');

function mlw_ms_adverts_activate()
{
	if ( ! get_option('mlw_advert_shows'))
	{
		add_option('mlw_advert_shows' , 'false');
	}
	else
	{
		update_option('mlw_advert_shows' , 'false');
	}
}

function mlw_ms_adverts_deactivate()
{
	delete_option('mlw_advert_shows');
}

function mlw_ms_adverts_update()
{
	if ( ! get_option('mlw_advert_shows'))
	{
		add_option('mlw_advert_shows' , 'false');
	}
	elseif (get_option('mlw_advert_shows') != 'false')
	{
		update_option('mlw_advert_shows' , 'false');
	}
}

?>