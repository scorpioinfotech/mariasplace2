<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>Maria's Place</title>
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/modernizr.custom.49511.js"></script>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/jquery.onebyone.min.js"></script>
<script type='text/javascript' src="<?php bloginfo('template_url'); ?>/js/jquery.touchwipe.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  
  $('#banner').oneByOne({
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
		
		
		// nav dropdown
					  var pull 		= $('#pull');
				menu 		= $('#nav ul');
				menuHeight	= menu.height();

			$(pull).on('click', function(e) {
				e.preventDefault();
				menu.slideToggle();
			});

			$(window).resize(function(){
        		var w = $(window).width();
        		if(w > 320 && menu.is(':hidden')) {
        			menu.removeAttr('style');
        		}
    		});
});
</script>
<?php wp_head(); ?>
</head>
<!--Body start-->
<body>
<!--main wrapper start-->
<div class="main_wrapper">
  <!--header start-->
  <header>
    <!--header wrapper start-->
    <div class="wrapper">
      <!--logo start-->
      <div class="logo_con"><a href="<?php echo get_option('home'); ?>"/><img src="<?php bloginfo('template_url'); ?>/images/logo_maria.png" alt="maria_place_logo" /></a></div>
      <!--logo end-->
      <!--navigation start-->
      <div class="nav_bg">
	  <div id="nav">
		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	  </div>
	<!--<nav id="nav">
        <a href="#" id="pull">Menu</a>
          <ul>
            <li><a href="#">Connect &amp; Learn</a></li>
            <li><a href="#">Health</a></li>
            <li><a href="#">Entertainment</a></li>
            <li><a href="#">Maria&#39;s Corner</a></li>
          </ul>
        </nav>-->
        <div class="ryan_image_con">
          <div class="name_link_main">
            <div class="name_link">HI Ryan</div>
            <div class="drop_arrow">
              <svg class="svg-triangle" fill="white">
                <polygon points="0,0 18,0 10,13"/>
              </svg>
            </div>
          </div>
          <div class="ryan_image"><img src="<?php bloginfo('template_url'); ?>/images/ryan_image.png" alt="image" /> </div>
        </div>
      </div>
      <!---navigation ends-->
    </div>
    <!--header wrapper end-->
  </header>
  <!--header end-->