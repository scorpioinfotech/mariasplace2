<?php

/**
 * Template Name: Members Profile Page Template
 *
 * @package BuddyPress
 * @subpackage Theme
 */ ?>



<?php get_header(); ?>

<div class="qa-left-side">
<?php
global $qa_general_settings;

if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
	get_sidebar( 'question' );
?>
</div>


<div class="qa-right-side">

<div id="qa-page-wrapper">
	<div id="qa-content-wrapper">
	<?php if (have_posts()) :
   while (have_posts()) :
      the_post();
         the_content();
   endwhile;
endif; ?>

</div><!--#qa-page-wrapper-->

</div>

</div>

<?php get_footer(); ?>