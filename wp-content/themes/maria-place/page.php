<?php get_header(); ?>
  <!---middle start-->
  <div class="wrapper_2">
    <!--main text start-->
    <div class="main_txt">
      <div class="main_work_con">
        <!-- <div class="focus_text">We focus on <span class="red">positive aging </span>for <span class="blue">healthy seniors</span></div> -->
       <?php
if (have_posts()) :
   while (have_posts()) :
      the_post();
         the_content();
   endwhile;
endif;
//get_sidebar();
 
?>
      </div>
      <div class="bottom_background"></div>
    </div>
    <!--main text end-->
  </div>
  <!--middle end-->
<?php get_footer()?>