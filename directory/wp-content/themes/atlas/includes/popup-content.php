<?php
echo '<div class="two_third popup-content">';
	
	echo "<ul>";

		echo '<li><span class="icon-direction"></span>';

			if(get_field('map_tooltip_content','option') == 'Listing Address' || get_field('map_tooltip_content','option') == '') {

				if(get_field('override_generated_address')) {
					the_field('override_generated_address');
				} else {
					$listing_address = get_field('location'); echo str_replace("'", "", $listing_address['address']);
				}

			} else if(get_field('map_tooltip_content','option') == 'Listing Excerpt') {

			$text_pop = get_the_content(); $trimmed_pop = wp_trim_words( $text_pop, $num_words = 20, $more = null ); echo addslashes($trimmed_pop);

			}

		echo "</li>";

		if(get_field('telephone')) {

		echo '<li><span class="icon-phone"></span>';

			echo get_field('telephone');

		echo "</li>";

		}

		if(get_field('mobile_phone_number')) {

		echo '<li><span class="icon-mobile"></span>';

			echo get_field('mobile_phone_number');

		echo "</li>";

		} 

		if(get_field('website')) {

		echo '<li><span class="icon-link"></span>';
			
			echo '<a rel="nofollow" target="_blank" href="' . get_field('website') . '">' . get_field('website') . '</a>';

		echo "</li>";

		}

	echo "</ul>";

echo "</div>";
?>