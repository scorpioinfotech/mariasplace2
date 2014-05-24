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
class TDP_Latest_Listings extends Empty_Widget_Abstract
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
		'name' => '[TDP] - Latest Listings',
 
		// this description will display within the administrative widgets area
		// when a user is deciding which widget to use.
		'description' => 'Use the following widget to display latest listings in a list.',
 
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
				'default' => 'Featured Listings'
			),
			array(
				'name' => '',
				'desc' => '',
				'id' => 'display_images',
				'type' => 'checkbox',
				'options' => array( 
				    '1' => 'Display Featured Image', 
				)
			),
			array(
				'name' => 'Total Listings',
				'desc' => 'Set how many listings you would like to display',
				'id' => 'total',
				'type' => 'text',
				'default' => '6'
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

		$args = array( 

			'post_type' => 'listing', 
			'posts_per_page' => $params['total'], 

		);
		
		$loop_latest_listings = new WP_Query( $args );

		if($params['display_images']) {

			$widget_class = null;

		} else {

			$widget_class = 'widget_categories widget-num';

		}

		?>

		<div class="<?php echo $widget_class; ?>">
			
			<ul>
				
				<?php if($loop_latest_listings->have_posts()) :

					while ( $loop_latest_listings->have_posts() ) : $loop_latest_listings->the_post(); { ?>

					<?php if($params['display_images']) { ?>

					<li>
						
						<div class="one_third">
							<?php

							$thumb = get_post_thumbnail_id();
							$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
							$image = aq_resize( $img_url, get_field('single_listing_image_width','option'), get_field('single_listing_image_height','option'), true ); //resize & crop the image

							?>
								<img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
						</div>

						<div class="two_third last">
							<a href="<?php the_permalink();?>"><?php the_title();?></a>
							<p><?php $single_location = get_field('location'); 

								echo $single_location['address'];

							?></p>
						</div>

						<div class="clear"></div>

					</li>

					<?php } else { ?>
					<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
					<?php } ?>

					<?php } endwhile;

					else :

						_e('No Listings Found','hangar');

					endif;

				?>

			</ul>

		</div>

		<?php 
	}
	
}