		<div class="left_side">
			<div>
				<div>
					<a href="?page=ilightbox_general" class="load_page ilightbox<?php if ($_GET['page']=='ilightbox_general') {?> active<?php } ?>" title="iLightBox"><em></em></a>
					<a href="?page=ilightbox_create" class="load_page new<?php if ($_GET['page']=='ilightbox_create') {?> active<?php } ?>" title="Create New Gallery"><em></em></a>
					<a href="?page=ilightbox_configurations" class="load_page cog<?php if ($_GET['page']=='ilightbox_configurations') {?> active<?php } ?>" title="Configurations"><em></em></a>
					<a href="?page=ilightbox_documentation" class="load_page book<?php if ($_GET['page']=='ilightbox_documentation') {?> active<?php } ?>" title="Documentation"><em></em></a>
				</div>
			</div>
			<h2><?php echo $this->ILIGHTBOX_NAME; ?> <sup style="font-weight:bold">v<?php echo $this->VERSION; ?></sup></h2>
			<ul>
				<li><a href="http://facebook.com/iprofessionaldev" class="facebook" title="Become a fan on facebook" target="_blank"></a></li>
				<li><a href="http://twitter.com/chawroka" class="twitter" title="Follow author on twitter" target="_blank"></a></li>
				<li><a href="http://iprodev.com/" class="link" title="Visit author homepage" target="_blank"></a></li>
			</ul>
		</div>
		<div class="right_side">