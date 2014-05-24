<?php 


class Hangar_Subscribe_Widget extends WP_Widget {
	function Hangar_Subscribe_Widget() {
			
		$widget_ops = array('classname' => 'newsletter','description' => __('Widget display the Subscribe box','hangar'));

	
		$this->WP_Widget('newsletter',__('[TDP] - Newsletter','hangar'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$feed_url = $instance['feed_url'];
		

		echo $before_widget;
		if ( $title )
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>

							
                        	<div class="subscribeBox">
                            	<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feed_url; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" id="subscribe">
                                    <input type="text" id="mail-forum" value="<?php _e('Your Email' , 'hangar') ?>" onfocus="if (this.value=='<?php _e('Your Email' , 'hangar') ?>') this.value       = '';" onblur="if (this.value=='') this.value='<?php _e('Your Email' , 'hangar') ?>';" />
                                    <input type="hidden" name="loc" value="en_US"/>
									<input type="hidden" value="<?php echo $feed_url; ?>" name="uri"/>
                                    <input type="submit" id="mail-submit" class="buttonShadow" value="Submit" />
                                </form>
                            </div><!--End SubscribeBox-->
                      

<?php 
		/* After widget (defined by themes). */
			echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['feed_url'] = $new_instance['feed_url'];
		$instance['title'] = $new_instance['title'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => __('Subscribe to our newsletter', 'hangar'),
			'feed_url' => 'Envato'
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
    	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('title:', 'hangar'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'feed_url' ); ?>"><?php _e('feedburner name: (your name without http://feeds.feedburner.com/) ', 'hangar'); ?></label>
		<input id="<?php echo $this->get_field_id( 'feed_url' ); ?>" name="<?php echo $this->get_field_name( 'feed_url' ); ?>" value="<?php echo $instance['feed_url']; ?>" class="widefat" />
		</p>


   <?php 
}
	} //end class