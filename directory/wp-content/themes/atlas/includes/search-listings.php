<div id="search-popup" class="white-popup mfp-hide animated flipInX">

        <h4><?php _e('Search For Listings','atlas');?></h4>

        <div class="search-content">

        <?php if(get_field('enable_search_on_map','option')) { ?>

	        <div class="tabset">

	        	<ul class="tabs">
	        		<li class="tab"><a href="#panel1" class="selected"><i class="icon-search"></i> <?php _e('Search Listings','atlas');?></a></li>
	        		<?php if(!is_tax() && !is_page_template('template-search-results.php') && !is_page_template('template-homepage-listings-content.php')) { ?>
					<li class="tab"><a href="#panel2"><i class="icon-location"></i> <?php _e('Search By Address','atlas');?></a></li>
					<?php } ?>
				</ul>

				<div class="panel" id="panel1" style="display: block;">
					
					<?php
		
						$args = tdp_search_fields();
						$my_search = new WP_Advanced_Search($args);
						$my_search->the_form();
									
					?>

				</div>

				<?php if(!is_tax() && !is_page_template('template-search-results.php') && !is_page_template('template-homepage-listings-content.php')) { ?>

				<div class="panel" id="panel2" style="display: none;">
					
					<label><?php _e('Start Typing','atlas');?></label>
					<input id="searchTextField" type="text" placeholder="<?php _e('Enter an address, zipcode or city','atlas');?>"/>

					<br/><br/>

				</div>

				<?php } ?>

			</div>

		<?php } else { ?>

			<?php
		
				$args = tdp_search_fields();
				$my_search = new WP_Advanced_Search($args);
				$my_search->the_form();
									
			?>

		<?php } ?>

        </div>

</div>