<?php
// Listing Tab 2
?>
<div class="tab-lister">

				<i class="icon-clock"></i>

					<?php echo do_shortcode( '[divider title="'.__('Opening Times','atlas').'" style="right-stripes" length="long" alignment="center" contenttype="text" heading="h4" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' ); ?>

					<ul class="item-address opening-time">

						<li><span><?php _e('Monday','atlas'); ?></span> <?php the_field('monday');?></li>
						<li><span><?php _e('Tuesday','atlas'); ?></span> <?php the_field('tuesday');?></li>
						<li><span><?php _e('Wednesday','atlas'); ?></span> <?php the_field('wednesday');?></li>
						<li><span><?php _e('Thursday','atlas'); ?></span> <?php the_field('thursday');?></li>
						<li><span><?php _e('Friday','atlas'); ?></span> <?php the_field('friday');?></li>
						<li><span><?php _e('Saturday','atlas'); ?></span> <?php the_field('saturday');?></li>
						<li><span><?php _e('Sunday','atlas'); ?></span> <?php the_field('sunday');?></li>


					</ul>
			

			</div>