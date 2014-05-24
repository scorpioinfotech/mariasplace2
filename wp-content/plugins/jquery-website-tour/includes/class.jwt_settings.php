<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class jwt_settings {
	function jwt_settings(){
		add_filter('pop-options_jwt',array(&$this,'options'),10,1);
	}
	
	function options($t){
		$i = count($t);
		//------------------------------
		$i++;
		$t[$i] = (object)array();
		$t[$i]->id 			= 'jwt-settings'; 
		$t[$i]->label 		= __('General Settings','jwt');
		$t[$i]->right_label	= __('Skin','jwt');
		$t[$i]->page_title	= __('General Settings','cbw');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'=>'skin',
				'type'=>'select',
				'options'=>array(
					'default'=>'Grey',
					'black'=>'Black',
					'blue'=>'Blue',
					'green'=>'Green',
					'purple'=>'Purple',
					'red'=>'Red'
				),
				'label'=>__('Skin','jwt'),
				'description'=> __("Choose the starting skin for the Website Tour.  Each tour can have its own skin; this only affects the style of the control when loading the page and no tour have been selected.",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'=>'donotshow_label',
				'type'=>'textarea',
				'default'=>__('Do not show this again.','jwt'),
				'label'=>__('Label for Do not show option','jwt'),
				'description'=> __("This is the label for the \"Do not show option\" in the tour control.  If you leave this field blank, the option will not be displayed in the tour control.",'jwt'),
				'save_option'=>true,
				'load_option'=>true
			),			
//			(object)array(
//				'id'=>'intro',
//				'type'=>'textarea',
//				'label'=>__('Tour Control Text','jwt'),
//				'description'=> __("This is displayed as default intro text on the top of the tour control.  This is only displayed if the first tour in the tours list was not assigned an introductory text.",'jwt'),
//				'save_option'=>true,
//				'load_option'=>true
//			),
			(object)array(
				'type'=>'clear'
			)
		);
		//--------------------------------		
		return $t;
	}		
}
?>