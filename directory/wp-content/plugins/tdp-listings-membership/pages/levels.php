<?php 

global $wpdb, $tdp_msg, $tdp_msgt, $tdp_levels, $current_user, $tdp_currency_symbol;
if($tdp_msg){ ?>

<div class="message <?php echo $tdp_msgt?>"><?php echo $tdp_msg?></div>

<?php } ?>


<?php $count = 0;
	
	foreach($tdp_levels as $level) {
	  if(isset($current_user->membership_level->ID))
		  $current_level = ($current_user->membership_level->ID == $level->id);
	  else
		  $current_level = false;
	?>

	<div class="package membership-<?php echo $level->id ?> <?php if($current_level == $level) { ?> active-membership<?php } ?>" id="membership-id-<?php echo $level->id ?>">

		<div class="tdp_two_third">
			<h3><?php echo $current_level ? "{$level->name}" : $level->name?></h3>
			<?php if(!empty($level->description))
						echo apply_filters("the_content", stripslashes($level->description));?>
		</div>

		<div class="tdp_one_third tdp_last">

			<span class="price">
				<?php if(tdp_isLevelFree($level) || $level->initial_payment === "0.00") { ?>
					<?php _e('FREE', 'tdp');?>
				<?php } else { ?>
					<?php echo $tdp_currency_symbol?><?php echo $level->initial_payment?>
				<?php } ?>
			</span>

			<h6 class="price-text"><?php printf(__('Posts allowance is of <strong>%s</strong> listings.', 'tdp'), $level->posts_limit );	 ?></h6>

		</div>


		<div class="tdp_clear"></div>

			<?php
			
			if($level->billing_amount != '0.00')
			{


				echo '<div class="divider" style="margin-top:15px;"></div>';
				echo '<div class="features">';


				if($level->billing_limit > 1)
				{			
					if($level->cycle_number == '1')
					{
						printf(__('%s per %s for %d more %s.', 'Recurring payment in cost text generation. E.g. $5 every month for 2 more payments.', 'tdp'), $tdp_currency_symbol . $level->billing_amount, tdp_translate_billing_period($level->cycle_period), $level->billing_limit, tdp_translate_billing_period($level->cycle_period, $level->billing_limit));					
					}				
					else
					{ 
						printf(__('%s every %d %s for %d more %s.', 'Recurring payment in cost text generation. E.g., $5 every 2 months for 2 more payments.', 'tdp'), $tdp_currency_symbol . $level->billing_amount, $level->cycle_number, tdp_translate_billing_period($level->cycle_period, $level->cycle_number), $level->billing_limit, tdp_translate_billing_period($level->cycle_period, $level->billing_limit));					
					}
				}
				elseif($level->billing_limit == 1)
				{
					printf(__('%s after %d %s.', 'Recurring payment in cost text generation. E.g. $5 after 2 months.', 'tdp'), $tdp_currency_symbol . $level->billing_amount, $level->cycle_number, tdp_translate_billing_period($level->cycle_period, $level->cycle_number));									
				}
				else
				{
					if($level->cycle_number == '1')
					{
						printf(__('%s per %s.', 'Recurring payment in cost text generation. E.g. $5 every month.', 'tdp'), $tdp_currency_symbol . $level->billing_amount, tdp_translate_billing_period($level->cycle_period));					
					}				
					else
					{ 
						printf(__('%s every %d %s.', 'Recurring payment in cost text generation. E.g., $5 every 2 months.', 'tdp'), $tdp_currency_symbol . $level->billing_amount, $level->cycle_number, tdp_translate_billing_period($level->cycle_period, $level->cycle_number));					
					}			
				}

				echo '</div>';
			}			
		
						  
			$expiration_text = tdp_getLevelExpiration($level);
			if($expiration_text)
			{
			?>
				<br /><span class="tdp_level-expiration"><?php echo $expiration_text?></span>
			<?php
			}
		?>

			<?php if(empty($current_user->membership_level->ID)) { ?>
				<a class="sign-up" href="<?php echo tdp_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Sign Up Now', 'Choose a level from levels page', 'tdp');?></a>               
			<?php } elseif ( !$current_level ) { ?>                	
				<a class="sign-up" href="<?php echo tdp_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Sign Up Now', 'Choose a level from levels page', 'tdp');?></a>       			
			<?php } elseif($current_level) { ?>      
				<a class="sign-up" href="<?php echo tdp_url("account")?>"><?php _e('This is your current active membership', 'tdp');?></a>
			<?php } ?>


	</div>


	<?php } ?>


	<?php if(!empty($current_user->membership_level->ID)) { ?>
			<a href="<?php echo tdp_url("account")?>"><?php _e('&larr; Return to Your Account', 'tdp');?></a>
	<?php } else { ?>
			<a href="<?php echo home_url()?>"><?php _e('&larr; Return to Home', 'tdp');?></a>
	<?php } ?>