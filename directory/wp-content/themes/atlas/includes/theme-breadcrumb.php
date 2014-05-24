<section id="breadcrumb">

	<div class="wrapper">
		
		<div class="one_half">
	
			<?php 

			if(function_exists('bcn_display')) {
		        
		        bcn_display();
		    
		    } else  { 

		    	tdp_breadcrumbs(); 

		    }
			
			?>
	
		</div>

		<div class="one_half last">
		</div>

		<div class="clearboth"></div>

	</div>

</section>