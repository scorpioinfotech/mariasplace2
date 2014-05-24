<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Atlas
 */



get_header(); ?>


<section id="breadcrumb">

	<div class="wrapper">
		
		<div class="one_half">
		
			<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
				<span class="icon-location"></span>
				<span typeof="v:Breadcrumb">
					<a rel="v:url" property="v:title" href="<?php echo home_url();?>"><?php _e('Home','atlas');?></a>
				</span> » 
				<span class="current"><?php the_title();?></span></div>
	
		</div>

		<div class="one_half last">
		</div>

		<div class="clearboth"></div>

	</div>

</section>

<section id="page-wrapper">

	<div id="page-content" class="wrapper">


		<div id="content-container" class="<?php if(get_field('blog_sidebar_position','option') == 'Sidebar Right' || get_field('blog_sidebar_position','option') == '') { echo 'two_third'; } else {echo "two_third last";} ?>">

			<?php if ( wp_attachment_is_image() ) :
				    $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
				    foreach ( $attachments as $k => $attachment ) {
				        if ( $attachment->ID == $post->ID )
				            break;
				    }
				    $k++;
				    // If there is more than 1 image attachment in a gallery
				    if ( count( $attachments ) > 1 ) {
				        if ( isset( $attachments[ $k ] ) )
				            // get the URL of the next image attachment
				            $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
				        else
				            // or get the URL of the first image attachment
				            $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
				    } else {
				        // or, if there's only 1 image attachment, get the URL of the image
				        $next_attachment_url = wp_get_attachment_url();
				    }
				?>
				                        <div class="attachment">
				                            <!-- <a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"> -->

				                            <?php
				                            $attachment_width  = apply_filters( 'attachment_width', 1068 );
				                            $attachment_height = apply_filters( 'attachment_height', 1068 );
				                            echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); // filterable image width with, essentially, no limit for image height.
				                        ?>
				                            <!-- </a> -->

				                            <div class="nav-previous">
				                                <?php previous_image_link( false, '&nbsp;' ); ?>
				                            </div>
				                            <div class="nav-next">
				                                <?php next_image_link( false, '&nbsp;' ); ?>
				                            </div>

				                        </div>

				<?php endif; ?>

		</div>


		<div class="clearboth"></div>

	</div>

</section>
		
<?php get_footer(); ?>