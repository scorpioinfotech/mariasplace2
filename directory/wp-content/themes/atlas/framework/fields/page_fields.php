<?php

/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_contact-page-options',
		'title' => 'Contact Page Options',
		'fields' => array (
			array (
				'key' => 'field_523ad23e2700a',
				'label' => 'Map Address',
				'name' => 'map_address',
				'type' => 'text',
				'instructions' => 'Use this field to set the address of where the marker will be displayed on the map. For example "New York".',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_523ad27b2700b',
				'label' => 'Info Window Text',
				'name' => 'info_window_text',
				'type' => 'text',
				'instructions' => 'Set the content of the infowindow (the popup of the marker on the map).',
				'default_value' => 'We are here!',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'none',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-contact.php',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_gallery-options',
		'title' => 'Gallery Options',
		'fields' => array (
			array (
				'key' => 'field_51c340a0f8219',
				'label' => 'Upload Images',
				'name' => 'upload_images',
				'type' => 'gallery',
				'instructions' => 'Setup your gallery',
				'required' => 1,
				'preview_size' => 'thumbnail',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'gallery',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_inner-page-options',
		'title' => 'Inner Page Options',
		'fields' => array (
			array (
				'key' => 'field_51c8382e91496',
				'label' => 'Page Layout',
				'name' => 'inner_page_layout',
				'type' => 'select',
				'instructions' => 'Select the layout of the page.',
				'choices' => array (
					'Sidebar Right' => 'Sidebar Right',
					'Sidebar Left' => 'Sidebar Left',
					'Fullwidth' => 'Fullwidth',
				),
				'default_value' => 'Sidebar Right',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_51c8386a91497',
				'label' => 'Inner Page Hero Content',
				'name' => 'inner_hero_content',
				'type' => 'select',
				'instructions' => 'Set the content of the hero area.',
				'choices' => array (
					'Page Title' => 'Page Title',
					'Custom Content' => 'Custom Content',
				),
				'default_value' => 'Page Title',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_51c838e221141',
				'label' => 'Custom Content',
				'name' => 'custom_content',
				'type' => 'wysiwyg',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_51c8386a91497',
							'operator' => '==',
							'value' => 'Custom Content',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_link-options',
		'title' => 'Link Options',
		'fields' => array (
			array (
				'key' => 'field_51c341ca90622',
				'label' => 'Link',
				'name' => 'link',
				'type' => 'text',
				'instructions' => 'Input your link e.g. http://themesdepot.org',
				'required' => 1,
				'default_value' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'link',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_quote-options',
		'title' => 'Quote Options',
		'fields' => array (
			array (
				'key' => 'field_51c34204d3c05',
				'label' => 'Quote Source',
				'name' => 'quote_source',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_51c34216a3606',
				'label' => 'Quote Message',
				'name' => 'quote_message',
				'type' => 'wysiwyg',
				'required' => 1,
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'quote',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_submitter-information',
		'title' => 'Submitter Information',
		'fields' => array (
			array (
				'key' => 'field_522ef10562df4',
				'label' => 'Submitter Full Name',
				'name' => 'user_claimed_name',
				'type' => 'text',
				'instructions' => 'This is the name of the user that submitted the claiming from the frontend',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_522ef12c62df5',
				'label' => 'Submitter Email Address',
				'name' => 'user_claimed_email',
				'type' => 'text',
				'instructions' => 'This is the email address of the user that submitted the claiming from the frontend. You can use this email to contact the user and arrange a change for the claimed listing.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_522ef16862df6',
				'label' => 'Submitter Phone Number',
				'name' => 'user_claimed_phone',
				'type' => 'text',
				'instructions' => 'This is the phone number of the submitter from the frontend.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_522ef18062df7',
				'label' => 'Claimed Listing',
				'name' => 'user_claimed_listing',
				'type' => 'text',
				'instructions' => 'This is the listing that the user claimed from the frontend.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'claimed_listing',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'featured_image',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_video-options',
		'title' => 'Video Options',
		'fields' => array (
			array (
				'key' => 'field_51dbe3436a86d',
				'label' => 'Video Embed Code',
				'name' => 'video_embed_code',
				'type' => 'textarea',
				'instructions' => 'Enter the video embed code here.',
				'default_value' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'placeholder' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'video',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
