<?php require(gp_inc . 'options.php'); global $gp_settings; ?>


<?php if($gp_settings['layout'] != "fullwidth") { ?>

	
	<!-- BEGIN SIDEBAR -->
	
	<div id="sidebar">
				
		<?php if(is_post_type_archive() == 'Questions'){?>
<?php if(is_user_logged_in()) { ?>

<?php global $current_user;
        get_currentuserinfo(); ?>
 <div class="avatar_image1">
<?php
     
        echo get_avatar( $current_user->ID, 64 );
 ?>

 </div><!-- end of ryan_image -->

	

	<div class="avatar_name1"> 

<?php echo $current_user->user_login; ?><br>

</div><!-- end of ryan_name -->
<?php } ?>
<?php }  ?>
		<!-- BEGIN BUDDYPRESS SITEWIDE NOTICES -->
				
		<?php if(function_exists('bp_message_get_notices')) { ?>
			<?php bp_message_get_notices(); ?>
		<?php } ?>
		
		<!-- END BUDDYPRESS SITEWIDE NOTICES -->
		
		
		<?php if(is_active_sidebar($gp_settings['sidebar'])) { ?>


			<!-- BEGIN DESIRED WIDGETS -->		

			<?php dynamic_sidebar($gp_settings['sidebar']); ?>

			<!-- END DESIRED WIDGETS -->			


		<?php } else { ?>
		
			
			<!-- BEGIN DEFAULT WIDGETS -->		
					
			<?php the_widget('WP_Widget_Meta'); ?> 
			
			<?php the_widget('WP_Widget_Recent_Posts'); ?> 
			
			<?php the_widget('WP_Widget_Calendar', 'title=Calendar'); ?> 
			
			<?php the_widget('WP_Widget_Text', 'title=Text Widget&text=Globally productivate business web-readiness before excellent internal or "organic" sources. Synergistically cultivate.'); ?> 
			
			<!-- END DEFAULT WIDGETS -->
			
		
		<?php } ?>
		
		
	</div>
	
	<!-- END SIDEBAR -->
	

<?php } ?>