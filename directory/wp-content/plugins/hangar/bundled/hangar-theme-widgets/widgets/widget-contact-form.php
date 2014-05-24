<?php
/**
 * Actions and Filters
 *
 * Register any and all actions here. Nothing should actually be called
 * directly, the entire system will be based on these actions and hooks.
 */
 
/**
 * This is the class that you'll be working with. Duplicate this class as many times as you want. Make sure
 * to include an add_action call to each class, like the line above.
 *
 * @author tdp
 *
 */
class TDP_Listings_Contact extends Empty_Widget_Abstract
{
	/**
	 * Widget settings
	 *
	 * Simply use the following field examples to create the WordPress Widget options that
	 * will display to administrators. These options can then be found in the $params
	 * variable within the widget method.
	 *
	 *
	 */
	protected $widget = array(
		// you can give it a name here, otherwise it will default
		// to the classes name. BTW, you should change the class
		// name each time you create a new widget. Just use find
		// and replace!
		'name' => '[TDP] - Listing Contact Form',
 
		// this description will display within the administrative widgets area
		// when a user is deciding which widget to use.
		'description' => 'Use the following widget to display a contact form. Note this widget works only into the sidebar of the single listing page and only if you disabled the contact form into the tabbed section of the single listing page.',
 
		// determines whether or not to use the sidebar _before and _after html
		'do_wrapper' => true,
 
		// determines whether or not to display the widgets title on the frontend
		'do_title'	=> true,
 
		// string : if you set a filename here, it will be loaded as the view
		// when using a file the following array will be given to the file :
		// array('widget'=>array(),'params'=>array(),'sidebar'=>array(),
		// alternatively, you can return an html string here that will be used
		'view' => false,
	
		// If you desire to change the size of the widget administrative options
		// area
		'width'	=> 350,
		'height' => 350,
	
		// Shortcode button row
		'buttonrow' => 4,
	
		// The image to use as a representation of your widget.
		// Whatever you place here will be used as the img src
		// so we have opted to use a basencoded image.
		'thumbnail' => '',
	
		/* The field options that you have available to you. Please
		 * contribute additional field options if you create any.
		 *
		 */
		'fields' => array(
			// You should always offer a widget title
			array(
				'name' => 'Title',
				'desc' => '',
				'id' => 'title',
				'type' => 'text',
				'default' => 'Listing Details'
			),

			array(
				'name' => 'Message',
				'desc' => 'Enter a message that will be displayed above the contact form',
				'id' => 'message',
				'type' => 'textarea',
				'default' => 'To inquire about this ad listing, complete the form below to send a message to the ad poster.'
			),

			array(
				'name' => 'Success Message',
				'desc' => 'Enter a message that will be displayed when the form has been successfully submitted.',
				'id' => 'success_message',
				'type' => 'textarea',
				'default' => 'Your Message Has Been Sent.'
			),
			
			
		)
	);
 
	/**
	 * Widget HTML
	 *
	 * If you want to have an all inclusive single widget file, you can do so by
	 * dumping your css styles with base_encoded images along with all of your
	 * html string, right into this method.
	 *
	 * @param array $widget
	 * @param array $params
	 * @param array $sidebar
	 */
	function html($widget = array(), $params = array(), $sidebar = array())
	{

		if (is_singular()) {
    		$author_id = get_queried_object()->post_author;
    		$author_email_address = get_the_author_meta('user_email', $author_id);
		}

		// Contact form processing
			$name_error = '';
			$email_error = '';
			$subject_error = '';
			$message_error = '';
			if (!isset($_REQUEST['c_submitted'])) 
			{
			//If not isset -> set with dumy value 
			$_REQUEST['c_submitted'] = ""; 
			$_REQUEST['c_name'] = "";
			$_REQUEST['c_email'] = "";
			$_REQUEST['c_message'] = "";
			}

			if($_REQUEST['c_submitted']){

				//check name
				if(trim($_REQUEST['c_name'] == "")){
					//it's empty
					
					$name_error = __('You forgot to fill in your name', 'hangar');
					$error = true;
				}else{
					//its ok
					$c_name = trim($_REQUEST['c_name']);
				}

				//check email
				if(trim($_REQUEST['c_email'] === "")){
					//it's empty
					$email_error = __('Your forgot to fill in your email address', 'hangar');
					$error = true;
				}else if(!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_REQUEST['c_email']))){
					//it's wrong format
					$email_error = __('Wrong email format', 'hangar');
					$error = true;
				}else{
					//it's ok
					$c_email = trim($_REQUEST['c_email']);
				}


				//check name
				if(trim($_REQUEST['c_message'] === "")){
					//it's empty
					$message_error = __('You forgot to fill in your message', 'hangar');
					$error = true;
				}else{
					//it's ok
					add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
					function my_mail_from_name( $name ){
    						return trim($_REQUEST['c_name']);
					}
					add_filter( 'wp_mail_from', 'my_mail_from' );
					function my_mail_from( $email ){
						return trim($_REQUEST['c_email']);
					}
					$c_email = trim($_REQUEST['c_email']);
				}

				//if no errors occured
				if($error != true) {

					$email_to =  $author_email_address;
					if (!isset($email_to) || ($email_to == '') ){
						$email_to = get_option('admin_email');
					}
					$c_subject = __('Message from ', 'hangar') . get_bloginfo('name') . ' - Listing: ' . get_the_title();
					$message_body = "Name: $c_name \n\nEmail: $c_email \n\nComments: $c_message";
					$headers = 'From: '.get_bloginfo('name').' <'.$c_email.'>';

					wp_mail($email_to, $c_subject, $message_body, $headers);

					$email_sent = true;
				}

			}

		?>
		
		<?php if(isset($email_sent) && $email_sent == true){ ?>

			<div class="alert-message success"><?php echo  $params['success_message'] ;?><span class="close" href="#"><i class="icon-cancel"></i></span></div>

		<?php } ?>

		<?php echo '<p>' . $params['message'] . '</p>';?>

		<div id="contact-form">
								            
			<form action="<?php the_permalink(); ?>" id="contactform" method="post" class="contactsubmit">
								                
				<div class="form-row">

					<input type="text" name="c_name" id="c_name" size="22" tabindex="1" class="required" placeholder="<?php _e('Name', 'hangar'); ?>" />
					<?php if($name_error != '') { ?>
						<p><?php echo $name_error;?></p>
					<?php } ?>

				</div>

				<div class="form-row">

					<input type="text" name="c_email" id="c_email" size="22" tabindex="1" class="required email" placeholder="<?php _e('Email', 'hangar');?>" />
						<?php if($email_error != '') { ?>
							<p><?php echo $email_error;?></p>
						<?php } ?>

				</div>

				<div class="clearfix"></div>

				<textarea name="c_message" id="c_message" rows="8" tabindex="3" class="required" placeholder="<?php _e('Your Message...','hangar');?>"></textarea>
				<?php if($message_error != '') { ?>
					<p><?php echo $message_error;?></p>
				<?php } ?>

				<p>
					<label for="c_submit"></label>
					<input type="submit" name="c_submit" id="c_submit" class="button medium black" value="<?php _e('Send Message', 'hangar'); ?>"/>
				</p>
				<input type="hidden" name="c_submitted" id="c_submitted" value="true" />
								                			                
			</form>

		</div>

		<?php 
	}
	
}