<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Atlas
 */

$footer_columns = get_field('widgetized_columns','option');

?>



<footer>

	<section id="top-footer">

		<div class="wrapper">

			<div class="one_half">

				<?php wp_nav_menu( array(
								'theme_location' => 'footer_menu',
								'menu_class'      => 'footer-menu',
								)); 
							?>

			</div>

			<div class="one_half last">
				<?php echo dp_social_icon(); ?>
			</div>

		</div>

	</section>

	<section id="bottom-footer">

		<div class="wrapper">

			<?php if($footer_columns == '4') { ?>

				<div class="one_fourth">
							<?php dynamic_sidebar( 'Footer 1' ); ?>
				</div>


				<div class="one_fourth">
							<?php dynamic_sidebar( 'Footer 2' ); ?>
				</div>


				<div class="one_fourth">
							<?php dynamic_sidebar( 'Footer 3' ); ?>
				</div>


				<div class="one_fourth last">
							<?php dynamic_sidebar( 'Footer 4' ); ?>
				</div>

			<?php } else if($footer_columns == '3') { ?>

				<div class="one_third">
							<?php dynamic_sidebar( 'Footer 1' ); ?>
				</div>

				<div class="one_third">
							<?php dynamic_sidebar( 'Footer 2' ); ?>
				</div>

				<div class="one_third last">
							<?php dynamic_sidebar( 'Footer 3' ); ?>
				</div>

			<?php } else if($footer_columns == '2') { ?>

				<div class="one_half">
							<?php dynamic_sidebar( 'Footer 1' ); ?>
				</div>

				<div class="one_half last">
							<?php dynamic_sidebar( 'Footer 2' ); ?>
				</div>

			<?php } ?>

					<div class="clearboth"></div>

			<div id="copyright-holder">

				<?php the_field('copyright_text','option');?>

			</div>

		</div>

	</section>

</footer>

<?php wp_footer(); ?>
</body>
</html>