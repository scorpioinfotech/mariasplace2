<?php 
// Listing Tab 3

$rows = get_field('custom_fields_builder');

?>
<div class="tab-lister">

				<i class="icon-info"></i>

					<?php echo do_shortcode( '[divider title="'.__('Other Information','atlas').'" style="right-stripes" length="long" alignment="center" contenttype="text" heading="h4" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' ); ?>

					<ul class="item-address opening-time">

						<?php foreach($rows as $row) : ?>

						<li><span><?php echo $row['field_title']; ?></span> <?php echo $row['field_content'];?></li>

						<?php endforeach; ?>

					</ul>
			

			</div>