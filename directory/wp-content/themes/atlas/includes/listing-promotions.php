<?php 
// Listing promotions
$rows = get_field('add_promotions_to_your_listing');
?>
<div class="tab-lister">

	<i class="icon-tags"></i>

	<?php echo do_shortcode( '[divider title="'.__('Promotions','atlas').'" style="right-stripes" length="long" alignment="center" contenttype="text" heading="h4" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' ); ?>

	<?php foreach($rows as $row) : ?>

		<div class="promotion">
			<img src="<?php echo $row['promotion_image']; ?>"/>
			
			<div class="promotion-desc"><?php echo $row['promotion_description']; ?></div>

			<?php if($row['get_promotion_button'] !== '') { ?>
				<br/><a href="<?php echo $row['get_promotion_url'];?>" class="button normal"><?php echo $row['get_promotion_button']; ?></a>
			<?php } ?> 
		</div>

	<?php endforeach; ?>

</div>