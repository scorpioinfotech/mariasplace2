<div id="search-popup" class="white-popup mfp-hide animated fadeInLeft">

        <h4><?php _e('Claim This Listing ?','atlas');?></h4>

        <div class="search-content">

        		<?php the_field('claiming_intro_message','option');?>

				<form id="submitform" name="submitform" action="<?php echo get_permalink(); ?>" method="post" enctype="multipart/form-data">

					<div class="form-input field">
						<label for="name"><?php _e('Your Full Name','atlas'); ?></label>
						<span class="field-desc"><?php _e('Enter your full name.','atlas');?></span>									
						<input type="text" name="name" id="name" class="required" value=""/>
					</div>

					<div class="form-input field">
						<label for="email"><?php _e('Your Email Address','atlas'); ?></label>
						<span class="field-desc"><?php _e('Enter your email address, this is where we will send you a response for your claim.','atlas');?></span>									
						<input type="text" name="email" id="email" class="required" value=""/>
					</div>

					<div class="form-input field">
						<label for="phone"><?php _e('Your Phone Number','atlas'); ?></label>
						<span class="field-desc"><?php _e('Enter your phone number (optional)','atlas');?></span>									
						<input type="text" name="phone" id="phone" value=""/>
					</div>

					<div class="form-input field">
						<label for="listing_url"><?php _e('Listing Url','atlas'); ?></label>
						<span class="field-desc"><?php _e('You are currently claiming the following listing','atlas');?></span>									
						<input type="text" name="listing_url" id="listing_url" value="<?php the_title();?> - [<?php the_permalink();?>]"/>
					</div>

					<div class="form-input field">
						<label for="message"><?php _e('Your Message','atlas'); ?></label>
						<span class="field-desc"><?php _e('Please enter a message and provide us more details about your business and why you would like to claim this listing.','atlas');?></span>									
						<textarea name="message" id="message" class="required"></textarea>
					</div>

					<input type="hidden" name="claim_submit" id="claim_submit" value="true" />
					<input type="submit" class="custom-button small black" id="submitButton" name="submitButton" value="<?php _e('Submit Claim &raquo;','atlas'); ?>" />

				</form>

            
        </div>

</div>