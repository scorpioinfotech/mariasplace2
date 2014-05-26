<!DOCTYPE html>
<!--[if !IE]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<!--[if IE 9]>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js ie9">
<![endif]-->
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js ie8">
<![endif]-->
<head>
<meta charset=<?php bloginfo('charset'); ?> />
<meta id="viewport" name="viewport" content ="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php bloginfo('name'); ?> | <?php is_home() || is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php require(gp_inc . 'options.php'); ?>
<?php require(gp_inc . 'page-styling.php'); ?>
<?php if(get_option($dirname.'_responsive') == "0") { ?><meta name="viewport" content="width=device-width, initial-scale=1"><?php } ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/animate.min.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/jquery.onebyone.css" />

<?php wp_head(); ?>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/modernizr.custom.49511.js"></script>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/jquery.onebyone.min.js"></script>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/jquery.touchwipe.min.js"></script>
<!--link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" -->
<script type="text/javascript">

jQuery( document ).ready( function() {
jQuery(".commentshow").click(function() {
jQuery(this).parent().next("#edit-answer").slideToggle();
});
jQuery(".singlecomment").click(function() {
jQuery("#edit-answer").slideToggle();
});
	jQuery(".fav").click(function(){
if (jQuery(this).hasClass("unfav")){
 if (jQuery(this).hasClass("duplicate-unfav")){
		 jQuery(this).removeClass( "duplicate-unfav" );
	}
	
	  jQuery(this).addClass( "duplicate-fav" );
  	  jQuery(this).html("");
	  //jQuery(this).css('display', 'none');

}else{
	if (jQuery(this).hasClass("duplicate-fav")){
		 jQuery(this).removeClass( "duplicate-fav" );
	}
	   if (jQuery(this).hasClass("duplicate-unfav")){		 
	}else{ jQuery(this).addClass( "duplicate-unfav" );  }

		jQuery(this).html( " Liked" );
     }
   });                

});


jQuery( document ).ready( function() {
			jQuery( 'a.confirm').click( function() {
				if ( confirm( 'Are you sure?' ) )
					return true; else return false;
			});
			
		jQuery('#banner').oneByOne({
			className: 'oneByOne1',
			/* Please provide the width and height in the responsive
			version, for the slider will keep the ratio when resize
			depends on these size. */
			width: 640,
			height: 360,
			easeType: 'random',
			slideShow: false,
			responsive: true,
			minWidth: 260,
			autoHideButton: true
		});

jQuery(".page-inner").css('opacity','1');
   jQuery("ul#menu-header").hover(function() {
      jQuery(".page-inner").stop().animate({ opacity: 0.3 });
   }, function() {
      jQuery(".page-inner").stop().animate({ opacity: 1 }); 
   });


// nav dropdown
 var pull 		= jQuery('#pull');
	menu 		= jQuery('#nav');
	menuHeight	= menu.height();

	jQuery(pull).on('click', function(e) {
	e.preventDefault();
	menu.slideToggle();
	});

	jQuery(window).resize(function(){
        var w = jQuery(window).width();
        if(w > 320 && menu.is(':hidden')) {
        menu.removeAttr('style');
        	}
    });

/* jQuery("input[type='submit']").click(function(){

var id = jQuery(this).closest('form').closest('.qa-voting-box').attr('id');

if(jQuery("."+id).hasClass("vote-up-off")){
jQuery("."+id).removeClass("vote-up-off");
jQuery("."+id).addClass("vote-up-on");
}
else{
jQuery("."+id).removeClass("vote-up-on");
jQuery("."+id).addClass("vote-up-off");
}
	

    
   }); */
});

jQuery(window).load( function() {
//alert("window loaded");
if(jQuery(".qa-voting-box input[type='submit']").hasClass("vote-up-off")) {


jQuery(".span").addClass("vote-up-off");
}

else {
//alert("vote-up-on");
jQuery(".span").addClass("vote-up-on");
}
});

	</script>
<script type="text/javascript">
 var oa = document.createElement('script');
 oa.type = 'text/javascript'; oa.async = true;
 oa.src = '//mariasplace.api.oneall.com/socialize/library.js'
 var s = document.getElementsByTagName('script')[0];
 s.parentNode.insertBefore(oa, s)



</script> 

</head>

<?php global $gp_settings; ?>

<body <?php body_class($gp_settings['layout'].' '.$gp_settings['padding'].' '.$gp_settings['frame'].' '.$gp_settings['skin']); ?>>
 
 
<!-- BEGIN HEADER OUTER -->

<?php if(!is_page_template('blank-page.php')) { ?>


	<div id="header-outer" class="page-outer">
		
		
	<!-- BEGIN PAGE INNER -->
		
		
	
			
			<!-- BEGIN LOGIN/REGISTER LINKS -->
			
			<?php if($theme_bp_links == "0" && function_exists('bp_is_active')) { ?>
			
				<div id="bp-links">
				
					<?php if(is_user_logged_in()) { ?>	
										
						<a href="<?php echo wp_logout_url(esc_url($_SERVER['REQUEST_URI'])); ?>" class="bp-logout-link"><?php _e('Logout', 'gp_lang'); ?></a>
	
					<?php } else { ?>
						
						<a href="<?php if($theme_login_url) { echo $theme_login_url; } else { echo wp_login_url(); } ?>" class="bp-login-link"><?php _e('Login', 'gp_lang'); ?></a>
						
						<?php if(bp_get_signup_allowed()) { ?><a href="<?php echo bp_get_signup_page(false); ?>" class="bp-register-link"><?php _e('Register', 'gp_lang'); ?></a><?php } ?>
						
					<?php } ?>
				
				</div>
				
				<div class="clear"></div>
				
			<?php } ?>
			
			<!-- END LOGIN/REGISTER LINKS -->
			
					
			<!-- BEGIN HEADER INNER -->
			
			<div id="header-inner">		
			
				
				<!-- BEGIN HEADER LEFT -->
				
				<div id="header-left">
				
					
					<!-- BEGIN LOGO -->
					
					<<?php if($gp_settings['title'] == "Show") { ?>div<?php } else { ?>h1<?php } ?> id="logo" style="<?php if($theme_logo_top) { ?> margin-top: <?php echo $theme_logo_top; ?>px;<?php } ?><?php if($theme_logo_left) { ?> margin-left: <?php echo $theme_logo_left; ?>px;<?php } ?><?php if($theme_logo_bottom) { ?> margin-bottom: <?php echo $theme_logo_bottom; ?>px;<?php } ?>">
						
						<span class="logo-details"><?php bloginfo('name'); ?> | <?php is_home() || is_front_page() ? bloginfo('description') : wp_title(''); ?></span>
						
						<?php if($theme_logo) { ?><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"></a><?php } else { ?><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><span class="default-logo"></span></a><?php } ?>
						
					</<?php if($gp_settings['title'] == "Show") { ?>div<?php } else { ?>h1<?php } ?>>
					
					<!-- END LOGO -->
					
				
				</div>
				
				<!-- END HEADER LEFT -->
				
				
				<!-- BEGIN HEADER RIGHT -->
				
				<div id="header-right">
					

					<!-- BEGIN CONTACT INFO -->
									
					<?php if($theme_contact_info) { ?>
						<div id="contact-info">
							<?php echo do_shortcode(stripslashes($theme_contact_info)); ?>
						</div>
					<?php } ?>
					
					<!-- END CONTACT INFO -->
				
									
					<!-- BEGIN NAV -->
					
					<div id="nav">
<a href="#" id="pull">Menu</a>
					
						<?php wp_nav_menu('sort_column=menu_order&container=ul&theme_location=header-nav&fallback_cb=null'); ?>
						
						<?php wp_nav_menu(array('theme_location' => 'header-nav', 'items_wrap' => '<select class="mobile-menu">%3$s</select>', 'container' => '', 'menu_class' => '', 'sort_column' => 'menu_order', 'fallback_cb' => 'null', 'walker' => new gp_mobile_menu)); ?>
								
						
                        
                        
						<!-- BEGIN SOCIAL ICONS -->
                        
                                            

											
						<span id="social-icons">
						
							<?php if($theme_rss_button == "1") {} else { ?><a href="<?php if($theme_rss) { ?><?php echo($theme_rss); ?><?php } else { ?><?php bloginfo('rss2_url'); ?><?php } ?>" class="rss-icon" title="<?php _e('RSS Feed', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_twitter) { ?><a href="<?php echo $theme_twitter; ?>" class="twitter-icon" title="<?php _e('Twitter', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_facebook) { ?><a href="<?php echo $theme_facebook; ?>" class="facebook-icon" title="<?php _e('Facebook', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_digg) { ?><a href="<?php echo $theme_digg; ?>" class="digg-icon" title="<?php _e('Digg', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
						
							<?php if($theme_delicious) { ?><a href="<?php echo $theme_delicious; ?>" class="delicious-icon" title="<?php _e('Delicious', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
				
							<?php if($theme_dribbble) { ?><a href="<?php echo $theme_dribbble; ?>" class="dribbble-icon" title="<?php _e('Dribbble', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_youtube) { ?><a href="<?php echo $theme_youtube; ?>" class="youtube-icon" title="<?php _e('YouTube', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
				
							<?php if($theme_vimeo) { ?><a href="<?php echo $theme_vimeo; ?>" class="vimeo-icon" title="<?php _e('Vimeo', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
		
							<?php if($theme_linkedin) { ?><a href="<?php echo $theme_linkedin; ?>" class="linkedin-icon" title="<?php _e('LinkedIn', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_googleplus) { ?><a href="<?php echo $theme_googleplus; ?>" class="googleplus-icon" title="<?php _e('Google+', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
												
							<?php if($theme_myspace) { ?><a href="<?php echo $theme_myspace; ?>" class="myspace-icon" title="<?php _e('MySpace', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
													
							<?php if($theme_flickr) { ?><a href="<?php echo $theme_flickr; ?>" class="flickr-icon" title="<?php _e('Flickr', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php echo stripslashes($theme_additional_social_icons); ?>
	
						</span>
						
						<!-- END SOCIAL ICONS -->
					
<?php if(is_user_logged_in()) { ?>
<div class="avatar">
	<div class="avatar_name"> HI <?php global $current_user;
        get_currentuserinfo();

echo $current_user->user_login; ?><br>
 <div class="drop_arrow">
             <span class="icon-play"></span>
           



 
            <div class="sub-nav-wrap">
            <ul>
<?php global $current_user;
        get_currentuserinfo(); ?>
                <li><a href="<?php echo get_bloginfo('url') . '/members/'. $current_user->user_login . '/activity/'; ?> ">My Profile</a></li>
                <li><a href="#">My Health test</a></li>
                <li><a href="<?php echo get_bloginfo('url') . '/members/'. $current_user->user_login . '/settings/'; ?> ">Account Settings</a></li>
                <li><a href="#">Order History</a></li>
                <li><a href="<?php echo wp_logout_url( get_permalink() ); ?>">Logout</a></li>
            </ul>
            
            </div>
            
            
            </div><!-- end of drop arrow -->
</div><!-- end of ryan_name -->

 <div class="avatar_image">
<?php
     
        echo get_avatar( $current_user->ID, 64 );
 ?>
<!-- img src="<?php bloginfo('template_url'); ?>/images/ryan_image.png" alt="image" /-->
 </div><!-- end of ryan_image -->

</div><!-- end of ryan -->	
<?php } ?>
                        
                        
					</div>
					
					<!-- END NAV -->
					
				</div>
				
				<!-- BEGIN HEADER RIGHT -->
				
			
				<!-- BEGIN TOP CONTENT -->
				
				<?php if($gp_settings['top_content_panel'] == "Show") { ?>
					
					<div id="top-content" class="<?php if(get_post_meta($post->ID, 'ghostpool_top_content', true)) { ?> top-content-stripes<?php } ?><?php if($gp_settings['title'] == "Show") { ?> page-title-width<?php } ?>">
						
						
						<!-- BEGIN TOP CONTENT LEFT -->
						
						<?php if($gp_settings['title'] == "Show") { ?>
						
						
							<div class="left">
							
							
								<!-- BEGIN TITLE -->
	
								<h1 class="page-title">
									<?php if(is_single() OR is_page()) { ?>
										<?php the_title(); ?>
									<?php } elseif(is_search()) { ?>
										<?php echo $wp_query->found_posts; ?> <?php _e('search results for', 'gp_lang'); ?> "<?php echo esc_html($s); ?>"
									<?php } elseif(is_category()) { ?>
										<?php single_cat_title(); ?>
									<?php } elseif(is_tag()) { ?>
										<?php single_tag_title(); ?>
									<?php } elseif(is_author()) { ?>
										<?php wp_title(''); ?><?php _e('\'s Posts'); ?>
									<?php } elseif(is_404()) { ?>
										<?php _e('Page Not Found', 'gp_lang'); ?>
									<?php } elseif(function_exists('is_bbpress') && is_bbpress()) { ?>
										<?php wp_title(''); ?>									
									<?php } elseif(is_archive()) { ?>
										<?php _e('Archives', 'gp_lang'); ?> <?php wp_title(' / '); ?>			
									<?php } ?>
								</h1>	
								
								<!-- END TITLE -->
												
			
								<!-- BEGIN POST META -->
	
								<?php if(is_singular() && ($gp_settings['meta_date'] == "0" OR $gp_settings['meta_author'] == "0" OR $gp_settings['meta_cats'] == "0" OR $gp_settings['meta_comments'] == "0")) { ?>
									<div class="post-meta">
										<?php if($gp_settings['meta_author'] == "0") { ?><span class="author-icon"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_meta('display_name', $post->post_author); ?></a></span><?php } ?>
										<?php if($gp_settings['meta_date'] == "0") { ?><span class="clock-icon"><?php the_time(get_option('date_format')); ?></span><?php } ?>
										<?php if($gp_settings['meta_cats'] == "0") { ?><span class="folder-icon"><?php the_category(', '); ?></span><?php } ?>
										<?php if($gp_settings['meta_comments'] == "0" && 'open' == $post->comment_status) { ?><span class="speech-icon"><?php comments_popup_link(__('0', 'gp_lang'), __('1', 'gp_lang'), __('%', 'gp_lang'), 'comments-link', ''); ?></span><?php } ?>
									</div>
								<?php } ?>
								
								<!-- END POST META -->
						
						
							</div>
							
						
						<?php } ?>
						
						<!-- END TOP CONTENT LEFT -->
						
						
						<!-- BEGIN TOP CONTENT RIGHT -->
						
						<?php if($gp_settings['search'] == "Show" OR $gp_settings['breadcrumbs'] == "Show") { ?>
						
						
							<div class="right">
								
								
								<!-- BEGIN SEARCH FORM -->
								
								<?php if($gp_settings['search'] == "Show") { ?>
								
									<?php if(function_exists('bp_is_active')) { ?>
		
										<form action="<?php echo bp_search_form_action(); ?>" method="post" id="searchform" class="bp-searchform">
											<input type="text" id="searchbar" name="search-terms" value="<?php echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" />
											<?php echo bp_search_form_type_select(); ?>
											<input type="submit" name="searchsubmit" id="searchsubmit" value="<?php _e( 'Search', 'buddypress' ); ?>" />
											<?php wp_nonce_field( 'bp_search_form' ); ?>
										</form>
										
									<?php } else { ?>
									
										<?php get_search_form(); ?>
									
									<?php } ?>
									
								<?php } ?>
								
								<!-- END SEARCH FORM -->
								
								
								<!-- BEGIN BREADCRUMBS -->
								
								<?php if($gp_settings['breadcrumbs'] == "Show") { ?>
									<div id="breadcrumbs"><?php echo the_breadcrumb(); ?></div>
								<?php } ?>
								
								<!-- END BREADCRUMBS -->
								
							
							</div>
						
						
						<?php } ?>
						
						<!-- END TOP CONTENT RIGHT -->
						
							
						<div class="clear"></div>
						
						
						<?php echo stripslashes(do_shortcode(get_post_meta($post->ID, 'ghostpool_top_content', true))); ?>
						
			
					</div>
				
				<?php } ?>
				
				<!-- END TOP CONTENT -->
				
				
				<div class="clear"></div>
		
			</div>
			
			<!-- BEGIN HEADER INNER -->
			
		
		
	
	
	</div>


	<!-- END HEADER OUTER -->


	<!-- BEGIN PAGE OUTER -->
	
	<div class="page-outer">
	
		
		<!-- BEGIN PAGE INNER -->
		
		<div class="page-inner">
		
			
			<!-- BEGIN CONTENT WRAPPER -->
			
	<div id="content-wrapper">
	<div id="content">
<div class="focus_text">


<?php if((is_post_type_archive() == 'Questions')||is_singular('question')){?>
<cite>Community</cite>

 
<?php } 
else{ ?>
    <cite><?php the_title() ?></cite>
<?php } ?>
<div class="breadcrumb">
<?php if(is_post_type_archive() == 'Questions'){?>

<span itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">
<a itemprop="url" title="Home" href="http://mariasplace.com"><span itemprop="title">Home</span><span class="icon-uniE60F2"></span></a>
</span>
<span itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">
<span itemprop="title">Community</span>
</span>


<?php }
elseif(is_singular('question')){ ?>
<span itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">
<a itemprop="url" title="Home" href="http://mariasplace.com"><span itemprop="title">Home</span><span class="icon-uniE60F2"></span></a>
</span>
<span itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">
<a itemprop="url" title="Community" href="http://mariasplace.com/questions/"><span itemprop="title">Community</span><span class="icon-uniE60F2"></span></a>
</span>


<?php }
 else { ?>
  
<?php breadcrumbs_everywhere(); ?>

<?php } ?>
</div>
    <div class="clear"></div>
</div>






<?php } ?>	