<?php 
if( has_post_thumbnail() ) {  
	$thumb = get_post_thumbnail_id(); 
	$img_url = wp_get_attachment_url( $thumb,"full" ); 
	$image = aq_resize( $img_url, 100, 100, true ); 

	if(get_field('override_hyperlink','option')) { 

		echo '<div class="one_third last image-wrapper pop-image"><a href="' . get_field('website') . '" title="'. get_the_title() . '"> <img src="' . $image . '" alt="' . get_the_title() . '"/></a></div>' ;

	} else {
	
		echo '<div class="one_third last image-wrapper pop-image"><a href="' . get_permalink() . '" title="'. get_the_title() . '"> <img src="' . $image . '" alt="' . get_the_title() . '"/></a></div>' ;

	}
}

if(get_field('override_hyperlink','option')) {

	echo '<div class="clearboth"></div><div class="linker"><a class="button black medium" href="' . get_field('website') . '">' . __('Read More &raquo;','atlas') .'</a></div>';

} else {

	echo '<div class="clearboth"></div><div class="linker"><a class="button black medium" href="' . get_permalink() . '">' . __('Read More &raquo;','atlas') .'</a></div>';

}

?>