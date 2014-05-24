<?php 
/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

//Lets load default fields so then we can add additional fields through the options panel.

//check if currently viewing admin or front-end - this is needed to decide whether we should load taxonomies or not

$load_taxonomies = null;

if(is_admin()) { $load_taxonomies = 0; } else { $load_taxonomies = 1; };

$default_fields_array = array (
			array (
				'key' => 'field_51dd70856b62e',
				'label' => __('Main Information','atlas'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_message_admin',
				'label' => 'Message',
				'name' => '',
				'type' => 'message',
				'message' => '<h1>This tab has been hidden.</h1>
					<h2>This tab is not used on the backend. This tab is used only on the frontend submission form.</h2>',
			),
			array (
				'key' => 'field_522f30035c85b',
				'label' => __('Listing Title','atlas'),
				'name' => 'listing_title',
				'type' => 'text',
				'instructions' => __('Enter the title of the listing.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_522f30035c81i',
				'label' => __('Listing Tags','atlas'),
				'name' => 'listing_tags',
				'type' => 'text',
				'instructions' => __('Enter the tags for this listing. Separate Each Tag with a comma. Ex: tag1, tag2, etc','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_522f34f7bdc18',
				'label' => __('Select Listing Category','atlas'),
				'name' => 'tdp_select_listing_category',
				'type' => 'taxonomy',
				'instructions' => __('Select a category for this listing.','atlas'),
				'taxonomy' => 'listings_categories',
				'field_type' => 'select',
				'allow_null' => 0,
				'load_save_terms' => $load_taxonomies,
				'return_format' => 'id',
				'multiple' => 0,
			),

			array (
				'key' => 'field_5230848453094',
				'label' => __('Listing Description','atlas'),
				'name' => 'testing_the_editor_field',
				'type' => 'wysiwyg',
				'instructions' => __('Enter the description for this listing.','atlas'),
				'required' => 0,
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
			),	
			
			array (
				'key' => 'field_51dd70946b62f',
				'label' => __('Other Information','atlas'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_522f34f7cccc',
				'label' => __('Select Listing Location Area','atlas'),
				'name' => 'tdp_select_listing_location_area',
				'type' => 'taxonomy',
				'instructions' => __('Select the location area for this listing.','atlas'),
				'taxonomy' => 'listings_location',
				'field_type' => 'select',
				'allow_null' => 0,
				'load_save_terms' => $load_taxonomies,
				'return_format' => 'id',
				'multiple' => 0,
			),
			array (
				'key' => 'field_51dd6e7c52b8a',
				'label' => __('Location','atlas'),
				'name' => 'location',
				'type' => 'location-field',
				'instructions' => __('Enter the location of this listing. <strong>Press the enter button to update the address, or simply double click on the map to set the pin location.</strong>','atlas'),
				'required' => 1,
				'val' => 'address',
				'center' => '48.856614,2.3522219000000177',
				'zoom' => 16,
				'scrollwheel' => 1,
			),
			array (
				'key' => 'field_51dd70a46b63c',
				'label' => __('Coordinates Override','atlas'),
				'name' => 'coordinates_override',
				'type' => 'text',
				'instructions' => __('If your location does not have an exact address please enter the coordinates here. Note: coordinates must be formatted in this way lat,lng example 48.856614,2.3522219000000177','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd70a46b630',
				'label' => __('Telephone','atlas'),
				'name' => 'telephone',
				'type' => 'text',
				'instructions' => __('Inser the phone number for contact information.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd70eb6b631',
				'label' => __('Mobile Phone Number','atlas'),
				'name' => 'mobile_phone_number',
				'type' => 'text',
				'instructions' => __('Inser the phone number for contact information.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd71216b633',
				'label' => __('Alternative Email Address','atlas'),
				'name' => 'alternative_email_address',
				'type' => 'email',
				'instructions' => __('By default, the email address is grabbed by the post author, if you wish to change the email address into something else, please insert the email here, otherwise leave this field blank.','atlas'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_51dd70fc6b632',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_51dd716b6b634',
				'label' => __('Website','atlas'),
				'name' => 'website',
				'type' => 'text',
				'instructions' => __('Insert the listing website if available.','atlas'),
				'default_value' => 'http://',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_fb',
				'label' => __('Facebook Profile','atlas'),
				'name' => 'facebook',
				'type' => 'text',
				'instructions' => __('Insert a facebook profile/page url if available.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_twitter',
				'label' => __('Twitter Profile','atlas'),
				'name' => 'twitter',
				'type' => 'text',
				'instructions' => __('Insert a twitter url if available.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_gplus',
				'label' => __('Google Plus Profile','atlas'),
				'name' => 'gplus',
				'type' => 'text',
				'instructions' => __('Insert a Google Plus url if available.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_instagram',
				'label' => __('Instagram Profile','atlas'),
				'name' => 'instagram',
				'type' => 'text',
				'instructions' => __('Insert a Instagram url if available.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_foursquare',
				'label' => __('Foursquare Profile','atlas'),
				'name' => 'foursquare',
				'type' => 'text',
				'instructions' => __('Insert a foursquare url if available.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_522cbda8dd790',
				'label' => __('Custom Fields Builder','atlas'),
				'name' => 'custom_fields_builder',
				'type' => 'repeater',
				'instructions' => __('Here you can specify additional information about your listing.','atlas'),
				'sub_fields' => array (
					array (
						'key' => 'field_522cbddcdd791',
						'label' => __('Field Title','atlas'),
						'name' => 'field_title',
						'type' => 'text',
						'instructions' => __('Please enter the name of this field.','atlas'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_522cbdf4dd792',
						'label' => __('Field Content','atlas'),
						'name' => 'field_content',
						'type' => 'textarea',
						'instructions' => __('Please enter the content of this field.','atlas'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'formatting' => 'br',
					),
				),
				'row_min' => 0,
				'row_limit' => 5,
				'layout' => 'row',
				'button_label' => __('Add New Information','atlas'),
			),
			array (
				'key' => 'field_51dd71bd6b635',
				'label' => __('Opening Times','atlas'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_51dd71c96b636',
				'label' => __('Monday','atlas'),
				'name' => 'monday',
				'type' => 'text',
				'instructions' => __('If available you can set opening times here.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd72036b637',
				'label' => __('Tuesday','atlas'),
				'name' => 'tuesday',
				'type' => 'text',
				'instructions' => __('If available you can set opening times here.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd720b6b638',
				'label' => __('Wednesday','atlas'),
				'name' => 'wednesday',
				'type' => 'text',
				'instructions' => __('If available you can set opening times here.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd72236b639',
				'label' => __('Thursday','atlas'),
				'name' => 'thursday',
				'type' => 'text',
				'instructions' => __('If available you can set opening times here.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd722a6b63a',
				'label' => __('Friday','atlas'),
				'name' => 'friday',
				'type' => 'text',
				'instructions' => __('If available you can set opening times here.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd72316b63b',
				'label' => __('Saturday','atlas'),
				'name' => 'saturday',
				'type' => 'text',
				'instructions' => __('If available you can set opening times here.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_51dd72376b63c',
				'label' => __('Sunday','atlas'),
				'name' => 'sunday',
				'type' => 'text',
				'instructions' => __('If available you can set opening times here.','atlas'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_tab_images',
				'label' => __('Media','atlas'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_523174a834225',
				'label' => __('Featured Image','atlas'),
				'name' => 'featured_image',
				'type' => 'image',
				'instructions' => __('Insert the featured image for this listing. This will be the first image of your listing. <strong class="note-admin">Note: this field can be used as an alternative to the normal featured image. The reason why you have this alternative is because to submit a listing from the frontend you need this field. However if you added a featured image it will display normally before this image. For more information please refer to the documentation.</strong>','atlas'),
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),
			array (
				'key' => 'field_listing_image2',
				'label' => __('Additional Image','atlas'),
				'name' => 'listing_image_2',
				'type' => 'image',
				'instructions' => __('Upload a picture. This image will be displayed after the featured image inside the gallery.','atlas'),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),
			array (
				'key' => 'field_listing_image3',
				'label' => __('Additional Image','atlas'),
				'name' => 'listing_image_3',
				'type' => 'image',
				'instructions' => __('Upload a picture. This image will be displayed after the featured image inside the gallery.','atlas'),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),
			array (
				'key' => 'field_listing_image4',
				'label' => __('Additional Image','atlas'),
				'name' => 'listing_image_4',
				'type' => 'image',
				'instructions' => __('Upload a picture. This image will be displayed after the featured image inside the gallery.','atlas'),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),
			array (
				'key' => 'field_listing_image5',
				'label' => __('Additional Image','atlas'),
				'name' => 'listing_image_5',
				'type' => 'image',
				'instructions' => __('Upload a picture. This image will be displayed after the featured image inside the gallery.','atlas'),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),

			array (
				'key' => 'field_isvideo',
				'label' => __('Insert Video ?','atlas'),
				'name' => 'insert_video',
				'type' => 'select',
				'instructions' => __('Select the video provider form the list and then type the video ID into the field below.','atlas'),
				'choices' => array (
					'novideo' => 'I do not need to upload a video',
					'youtube' => 'YouTube',
					'vimeo' => 'Vimeo',
					'dailymotion' => 'DailyMotion',
				),
				'default_value' => 'novideo',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_thisvideo',
				'label' => __('Enter the video ID','atlas'),
				'name' => 'enter_the_video_id',
				'type' => 'text',
				'instructions' => __('Enter the video ID of a video hosted on Youtube, Vimeo or DailyMotion e.g INmtQXUXez8','atlas'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_isvideo',
							'operator' => '!=',
							'value' => 'novideo',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			
			array (
				'key' => 'field_52a1bb4da9f8a',
				'label' => __('Promotions'),
				'name' => 'tab_prom',
				'type' => 'tab',
			),
			array (
				'key' => 'field_52a1bb5ea9f8b',
				'label' => __('Add Promotions To Your Listing','atlas'),
				'name' => 'add_promotions_to_your_listing',
				'type' => 'repeater',
				'instructions' => __('Press the add new promotion button to start adding promotions.','atlas'),
				'sub_fields' => array (
					array (
						'key' => 'field_52a1bb8aa9f8c',
						'label' => __('Promotion Image'),
						'name' => 'promotion_image',
						'type' => 'image',
						'instructions' => __('Upload an image for this promotion, recommended image width is 660px.','atlas'),
						'column_width' => '',
						'save_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'uploadedTo',
					),
					array (
						'key' => 'field_52a1bbb7a9f8d',
						'label' => __('Promotion Description'),
						'name' => 'promotion_description',
						'type' => 'textarea',
						'instructions' => __('Enter a description for this promotion','atlas'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'formatting' => 'html',
					),
					array (
						'key' => 'field_52a1bbd8a9f8e',
						'label' => __('Get Promotion Button'),
						'name' => 'get_promotion_button',
						'type' => 'text',
						'instructions' => __('Use this field to add a button that will link to the promotion. If blank, no button will be added.','atlas'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_52a1bc0ba9f8f',
						'label' => __('Get Promotion URL'),
						'name' => 'get_promotion_url',
						'type' => 'text',
						'instructions' => __('Enter the url of the promotion button.','atlas'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add New Promotion',
			),

		);

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_listing-is-featured',
		'title' => 'Listing Is Featured',
		'fields' => array (
			array (
				'key' => 'field_522cbbdbdf1fe',
				'label' => 'Listing Is Featured',
				'name' => 'listing_is_featured',
				'type' => 'true_false',
				'instructions' => 'Enable this option if this listing is featured. You should enable this option if the membership you purchased allows you to do so.',
				'message' => '',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'listing',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_listing-settings',
		'title' => 'Listing Settings',
		'fields' => $default_fields_array,
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'listing',
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
}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_listing-settings-override',
		'title' => 'Listing Settings Override',
		'fields' => array (
			array (
				'key' => 'field_52fe599f74423',
				'label' => 'Override Generated Address',
				'name' => 'override_generated_address',
				'type' => 'text',
				'instructions' => 'Use this field to enter your custom address for this listing. When this field is filled, it\'s content is used instead of the address generated by the google map, this is useful if the generated address is incorrect.
	<br/><br/>
	Note: the generated address is retrieved from the google map api and not by the theme itself, you will still need to fill in the address since the coordinates are needed to display the listing on the map.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'listing',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

if(!function_exists("tdp_listings_insert_listing")) {

function tdp_listings_insert_listing( $post_id ) {

	global $current_user;
	get_currentuserinfo();

    // check if this is to be a new post
    if( $post_id != 'new_listing' )
    {
        return $post_id;
    }
 
    // Create a new post
    $post = array(
        'post_status'  => get_field('default_listing_submission_status','option') ,
        'post_title'  => $_POST["fields"]['field_522f30035c85b'],
        'post_content' => $_POST["fields"]['field_5230848453094'],
        //'tags_input' => $_POST["fields"]['field_522f30035c81i'],
        'post_type'  => 'listing' ,
    );

    // decrease post count
    if( $post_id = 'new_listing' ) {
    	$minus_one = $current_user->allowance_limit - 1;
    	update_user_meta( $current_user->ID, 'allowance_limit', $minus_one );
    }

    /**
	 *  Send an email to admin
	 */
    if( $post_id = 'new_listing' && get_field('receive_email_on_submission','option') ) {

    	//define email information
	    $listing_title = stripslashes($_POST["fields"]['field_522f30035c85b']);
	    $listing_author = stripslashes($current_user->user_login);
	    //$adminurl = get_option('siteurl').'/wp-admin/post.php?action=edit&post='.$post_id;

	    //prepare email settings
	    $mailto = get_option('admin_email');
	    $subject = __('New Listing Submission','atlas');
	    $headers = 'From: '. __('Atlas Admin', 'atlas') .' <'. get_option('admin_email') .'>' . "\r\n";
	    
	    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
	    // we want to reverse this for the plain text arena of emails.
	    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	    $message  = __('Dear Admin,', 'atlas') . "\r\n\r\n";
	    $message .= sprintf(__('The following listing has just been submitted on your %s website.', 'atlas'), $blogname) . "\r\n\r\n";
	    $message .= __('Listing Details', 'atlas') . "\r\n";
	    $message .= __('-----------------', 'atlas') . "\r\n";
	    $message .= __('Title: ', 'atlas') . $listing_title . "\r\n";
	    $message .= __('Author: ', 'atlas') . $listing_author . "\r\n\r\n";
	    //$message .= __('-----------------', 'atlas') . "\r\n\r\n";
	    //$message .= sprintf(__('Review Listing: %s', 'atlas'), $adminurl) . "\r\n\r\n\r\n";
	    // ok let's send the email
	    wp_mail($mailto, $subject, $message, $headers);

    }

    /**
	 *  Process Listing
	 */
    $post_id = wp_insert_post( $post );

    // Add tags to listings
    $str=$_POST["fields"]['field_522f30035c81i'];
	$arr=explode(",",$str);
	wp_set_post_terms( $post_id, $arr, 'listings_tags' );

    //lets check if user is allowed to feature listings
    $featured_ids = get_field('automatically_set_featured_listing_for_these_memberships','option');
	$featured_array=explode(",",$featured_ids);
    
    if(tdp_hasMembershipLevel($featured_array)){
    	update_field( 'field_522cbbdbdf1fe', 1, $post_id );
	} else {
		update_field( 'field_522cbbdbdf1fe', 0, $post_id );
	}

	//lets use a custom field to set the featured thumbnail
    set_post_thumbnail( $post_id, $_POST["fields"]['field_523174a834225'] );

    /**
	 *  Send an email to users
	 */
    if( get_field('send_email_on_submission','option') ) {

    	$the_listing = get_post($post_id);
	    $listing_title = stripslashes($the_listing->post_title);
	    $listing_status = stripslashes($the_listing->post_status);
	    $listing_author = stripslashes(get_the_author_meta('user_login', $the_listing->post_author));
	    $listing_author_email = stripslashes(get_the_author_meta('user_email', $the_listing->post_author));
	    $dashurl = get_field('listings_management_page','option');

	    $siteurl = trailingslashit(home_url( ));
	    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
	    // we want to reverse this for the plain text arena of emails.
	    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	    $mailto = $listing_author_email;

	    $subject = sprintf(__('Your Listing Submission on %s','atlas'), $blogname);
	    $headers = 'From: '. sprintf(__('%s Admin', 'atlas'), $blogname) .' <'. get_option('admin_email') .'>' . "\r\n";
	    $message  = sprintf(__('Hi %s,', 'atlas'), $listing_author) . "\r\n\r\n";
	    $message .= sprintf(__('Thank you for your recent submission! Your ad listing has been submitted for review and will not appear live on our site until it has been approved. Below you will find a summary of your ad listing on the %s website.', 'atlas'), $blogname) . "\r\n\r\n";
	    $message .= __('Listing Details', 'atlas') . "\r\n";
	    $message .= __('-----------------', 'atlas') . "\r\n";
	    $message .= __('Title: ', 'atlas') . $listing_title . "\r\n";
	    $message .= __('Status: ', 'atlas') . $listing_status . "\r\n";
	    $message .= __('-----------------', 'atlas') . "\r\n\r\n";
	    $message .= __('You may check the status of your listing(s) at anytime by logging into your dashboard.', 'atlas') . "\r\n";
	    $message .= $dashurl . "\r\n\r\n\r\n\r\n";
	    $message .= __('Regards,', 'atlas') . "\r\n\r\n";
	    $message .= sprintf(__('Your %s Team', 'atlas'), $blogname) . "\r\n";
	    $message .= $siteurl . "\r\n\r\n\r\n\r\n";
	    // ok let's send the email
	    wp_mail($mailto, $subject, $message, $headers);

    }

    // update $_POST['return']
    $_POST['return'] = add_query_arg( array('submitted' => 'true'), $_POST['return'] ); 

    // return the new ID
    return $post_id;
}

}

add_filter('acf/pre_save_post' , 'tdp_listings_insert_listing' );

if(!function_exists("tdp_listings_update_listing")) {

function tdp_listings_update_listing( $post_id ) {
  	
  	global $wpdb;

  	$page_url_front = get_field('redirect_edit_listings_page','option');
  	$edit_page_front = url_to_postid( $page_url_front );

  	if ( 'listing' == get_post_type() || is_page($edit_page_front) ) {
 
  	//get new title
  	$title = $_POST["fields"]['field_522f30035c85b'];
  	$content = $_POST["fields"]['field_5230848453094'];
  	$edit_status = get_field('default_listing_edit_status','option');

 	}

	//get edit page id
	$page_url = get_field('redirect_edit_listings_page','option');
	$edit_page_id = url_to_postid( $page_url );

  	if( $post_id != 'new_listing' && !is_admin() && is_page($edit_page_id) ) {
 
  		$wpdb->query("UPDATE $wpdb->posts SET post_title = '".$title."' WHERE ID = '".$post_id."'");
  		$wpdb->query("UPDATE $wpdb->posts SET post_content = '".$content."' WHERE ID = '".$post_id."'");
  		$wpdb->query("UPDATE $wpdb->posts SET post_status = '".$edit_status."' WHERE ID = '".$post_id."'");

  		set_post_thumbnail( $post_id, $_POST["fields"]['field_523174a834225'] );

  		if(get_field('receive_email_on_listing_modification','option')) { 

	  		/**
			 *  Send an email to admin
			 */
		    //define email information
		    $listing_title = stripslashes($title);
		    $adminurl = get_option('siteurl').'/wp-admin/post.php?action=edit&post='.$post_id;

		    //prepare email settings
		    $mailto = get_option('admin_email');
		    $subject = __('Review Listing Modification','atlas');
		    $headers = 'From: '. __('Atlas Admin', 'atlas') .' <'. get_option('admin_email') .'>' . "\r\n";
		    
		    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
		    // we want to reverse this for the plain text arena of emails.
		    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		    $message  = __('Dear Admin,', 'atlas') . "\r\n\r\n";
		    $message .= sprintf(__('The following listing has just been re-submitted and or modified on your %s website.', 'atlas'), $blogname) . "\r\n\r\n";
		    $message .= __('Listing Details', 'atlas') . "\r\n";
		    $message .= __('-----------------', 'atlas') . "\r\n";
		    $message .= __('Title: ', 'atlas') . $listing_title . "\r\n";
		    $message .= __('-----------------', 'atlas') . "\r\n\r\n";
		    $message .= sprintf(__('Review Listing: %s', 'atlas'), $adminurl) . "\r\n\r\n\r\n";
		    // ok let's send the email
		    wp_mail($mailto, $subject, $message, $headers);

		}

		if(get_field('send_email_on_listing_modification','option')) { 

	  		/**
			 *  Send an email to user
			 */
		    $the_listing = get_post($post_id);
		    $listing_title = stripslashes($the_listing->post_title);
		    $listing_status = stripslashes($the_listing->post_status);
		    $listing_author = stripslashes(get_the_author_meta('user_login', $the_listing->post_author));
		    $listing_author_email = stripslashes(get_the_author_meta('user_email', $the_listing->post_author));

		    $siteurl = trailingslashit(home_url( ));
		    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
		    // we want to reverse this for the plain text arena of emails.
		    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		    $mailto = $listing_author_email;

		    $subject = sprintf(__('Your Listing Modification on %s','atlas'), $blogname);
		    $headers = 'From: '. sprintf(__('%s Admin', 'atlas'), $blogname) .' <'. get_option('admin_email') .'>' . "\r\n";
		    $message  = sprintf(__('Hi %s,', 'atlas'), $listing_author) . "\r\n\r\n";
		    $message .= sprintf(__('Thank you for your recent modification! Your listing modification has been submitted for review and will not appear live on our site until it has been approved. Below you will find a summary of your ad listing on the %s website.', 'atlas'), $blogname) . "\r\n\r\n";
		    $message .= __('Listing Details', 'atlas') . "\r\n";
		    $message .= __('-----------------', 'atlas') . "\r\n";
		    $message .= __('Title: ', 'atlas') . $listing_title . "\r\n";
		    $message .= __('Status: ', 'atlas') . $listing_status . "\r\n";
		    $message .= __('-----------------', 'atlas') . "\r\n\r\n";
		    $message .= __('You may check the status of your listing(s) at anytime by logging into your dashboard.', 'atlas') . "\r\n";
		    $message .= $dashurl . "\r\n\r\n\r\n\r\n";
		    $message .= __('Regards,', 'atlas') . "\r\n\r\n";
		    $message .= sprintf(__('Your %s Team', 'atlas'), $blogname) . "\r\n";
		    $message .= $siteurl . "\r\n\r\n\r\n\r\n";
		    // ok let's send the email
		    wp_mail($mailto, $subject, $message, $headers);


		}


	}

}
}
add_filter('acf/save_post' , 'tdp_listings_update_listing', 20 );

if(!function_exists("my_deregister_styles")) {

add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

function my_deregister_styles() {
	wp_deregister_style( 'wp-admin' );
}				

}