<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Atlas
 */

get_header(); ?>

<section id="breadcrumb">

	<div class="wrapper">
		
		<div class="one_half">
	
			<?php if (function_exists('tdp_breadcrumbs')) tdp_breadcrumbs(); ?>
	
		</div>

		<div class="one_half last">
		</div>

		<div class="clearboth"></div>

	</div>

</section>

<section id="page-wrapper">

	<div id="page-content" class="wrapper">

			<div id="content-container" class="error-container">

					<h1 class="entry-title">

						<span class="error-title"><i class="icon-attention"></i> 404</span>

						<?php _e( 'Oops! That page can&rsquo;t be found.', 'atlas' ); ?>

					</h1>


					<p><?php _e( 'It looks like nothing was found at this location. ', 'atlas' ); ?></p>

					<a href="<?php echo home_url();?>" class="dp-button large"><?php _e('Back To The Homepage','atlas');?></a>

			</div>

	</div>

</section>


<?php get_footer(); ?>