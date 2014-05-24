<?php 
// Tab 4
?>
<div class="tab-lister">

				<i class="icon-mail-alt"></i>

					<?php echo do_shortcode( '[divider title="'.__('Send To A Friend','atlas').'" style="right-stripes" length="long" alignment="center" contenttype="text" heading="h4" icon="" iconfont="" fontsize="24" fontcolor="" marginbottom="" margintop=""]' ); ?>

					<?php if(isset($f_email_sent) && $f_email_sent == true){ ?>
			
						<div class="alert-message success"><?php _e('Message Successfully Sent','atlas');?></div>

					<?php } ?>

					<div id="contact-form">
											            
						<form action="<?php the_permalink(); ?>" id="fcontactform" method="post" class="fcontactsubmit">
											                
							<div class="form-row">

								<input type="text" name="f_name" id="f_name" size="22" tabindex="1" class="required" placeholder="<?php _e('Your Name', 'atlas'); ?>" />
								<?php if($f_name_error != '') { ?>
									<p><?php echo $f_name_error;?></p>
								<?php } ?>

							</div>

							<div class="form-row">

								<input type="text" name="f_email" id="f_email" size="22" tabindex="1" class="required email" placeholder="<?php _e('Friend Email Address', 'atlas');?>" />
									<?php if($f_email_error != '') { ?>
										<p><?php echo $f_email_error;?></p>
									<?php } ?>

							</div>

							<div class="clearfix"></div>

							<label for="f_message"><?php _e('Message For Your Friend','atlas');?></label>
							<textarea name="f_message" id="f_message" rows="8" tabindex="3" class="required"><?php _e('Hey check this out: ','atlas'); echo get_permalink(); ?></textarea>
							<?php if($f_message_error != '') { ?>
								<p><?php echo $f_message_error;?></p>
							<?php } ?>

							<p>
								<label for="f_submit"></label>
								<input type="submit" name="f_submit" id="f_submit" class="button medium black" value="<?php _e('Send Message', 'atlas'); ?>"/>
							</p>
							<input type="hidden" name="f_submitted" id="f_submitted" value="true" />
											                			                
						</form>

					</div>

			</div>