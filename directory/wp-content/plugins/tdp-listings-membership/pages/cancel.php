<?php 
	global $tdp_msg, $tdp_msgt, $tdp_confirm;

	if($tdp_msg) 
	{
?>
	<div class="tdp_message <?php echo $tdp_msgt?>"><?php echo $tdp_msg?></div>
<?php
	}
?>

<?php if(!$tdp_confirm) { ?>           

<p><?php _e('Are you sure you want to cancel your membership?', 'tdp');?></p>

<p>
	<a class="tdp_yeslink yeslink" href="<?php echo tdp_url("cancel", "?confirm=true")?>"><?php _e('Yes, cancel my account', 'tdp');?></a>
	|
	<a class="tdp_nolink nolink" href="<?php echo tdp_url("account")?>"><?php _e('No, keep my account', 'tdp');?></a>
</p>
<?php } else { ?>
	<p><a href="<?php echo get_home_url()?>"><?php _e('Click here to go to the home page.', 'tdp');?></a></p>
<?php } ?>