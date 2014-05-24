<?php
/**
 * @package Atlas
 */
?>

<div class="last post-content">


		<div class="post-image">

			<?php the_field('video_embed_code');?>

		</div>

	<h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

	<div class="meta-wrapper">

		<ul>
			<li>
				<span class="post-time"><i class="icon-calendar"></i><?php _e('Posted:','atlas'); ?></span> <?php the_time('M'); ?> <?php the_time('d, Y'); ?>
			</li>
			<li>
				<span><i class="icon-user"></i><?php echo __('By: ', 'atlas'); ?></span> <?php the_author_posts_link(); ?>
			</li>
			<li>
				<span><i class="icon-chat"></i><?php echo __('Comments: ','atlas');?></span> <?php comments_popup_link(__('0', 'atlas'), __('1', 'atlas'), '% '.''); ?>
			</li>
		</ul>

	</div>

	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'atlas' ) ); ?>
		
	<?php wp_link_pages( array('before' => '<div class="page-links">' . __( 'Pages:', 'atlas' ), 'after'  => '</div>', ) ); ?>
</div>

