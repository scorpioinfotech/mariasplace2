<section id="listing-brief">

	<div class="wrapper">

		<div class="two_third">

			<div class="animated fadeInDown">
			
			<?php if(get_field('inner_hero_content') == 'Custom Content') { ?>

				<?php the_field('custom_content'); ?>

			<?php } else { ?>

				<h1><?php the_title();?></h1>

			<?php } ?>

			</div>

		</div>

		<div class="one_third last" id="right-counter">

		</div>

		<div class="clearboth"></div>

	</div><!-- end wrapper -->

</section> <!-- end listing brief -->