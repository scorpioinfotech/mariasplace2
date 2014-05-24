<?php
global $premiothemes_comingsoon_minigo;

// if(strlen($premiothemes_comingsoon_minigo['countdown-startDate'])) {
// 	$startDate = explode('/', $premiothemes_comingsoon_minigo['countdown-startDate']);
// 	$startDate =
// $startDate =

//print_r($premiothemes_comingsoon_minigo);


$pattern = '';
if($premiothemes_comingsoon_minigo['background-pattern'] == 'preset' && !empty($premiothemes_comingsoon_minigo['background-patternPreset'])) {
	$pattern = $premiothemes_comingsoon_minigo['background-patternPreset'];
} elseif($premiothemes_comingsoon_minigo['background-pattern'] == 'custom' && !empty($premiothemes_comingsoon_minigo['background-patternCustom']['url'])) {
	$pattern = $premiothemes_comingsoon_minigo['background-patternCustom']['url'];
}

// 'color' => 'Solid Color',
// 'slideshow-kenburns' => 'Slideshow - Ken Burns',
// 'slideshow-fade' => 'Slideshow - Fade',
// 'slideshow-continuousFade' => 'Slideshow - Continuous Fade',
// 'video' => 'Video',
// 'youtube' => 'YouTube'

$backgroundType = 'slideshow';
$slideshowType = 'kenburns';
$videoSource = 'youtube';

switch($premiothemes_comingsoon_minigo['background-type']) {
	case 'color':
		$backgroundType = '';
		break;
	case 'slideshow-kenburns':
		$backgroundType = 'slideshow';
		$slideshowType = 'kenburns';
		break;
	case 'slideshow-fade':
		$backgroundType = 'slideshow';
		$slideshowType = 'fade';
		break;
	case 'slideshow-continuousFade':
		$backgroundType = 'slideshow';
		$slideshowType = 'continuousFade';
		break;
	case 'video':
		$backgroundType = 'video';
		$videoSource = 'local';
		break;
	case 'youtube':
		$backgroundType = 'video';
		$videoSource = 'youtube';
		break;
}

$gallery = array();
if($backgroundType == 'slideshow' && !empty($premiothemes_comingsoon_minigo['background-slideshow-gallery'])) {
	$gallery = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'attachment',
			'orderby' => 'none',
			'include' => $premiothemes_comingsoon_minigo['background-slideshow-gallery']
		));
}

?><!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $premiothemes_comingsoon_minigo['site-title']?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no, maximum-scale=1, initial-scale=1, minimum-scale=1" />

        <link rel="shortcut icon" href="<?php echo $premiothemes_comingsoon_minigo['favicon']['url']?>">

        <link rel="stylesheet" href="<?php echo plugins_url( 'styles/loader.min.css' , __FILE__ )?>"/>

        <?php if($premiothemes_comingsoon_minigo['load-other-assets']) { ?>

        <?php if (!wp_script_is( 'jquery', 'registered')) { ?>
        <!--[if lte IE 8]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><![endif]-->
        <!--[if gt IE 8]><!--><script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script><!--<![endif]-->
        <?php } ?>

        <?php
            if($premiothemes_comingsoon_minigo['strip-theme-assets']) {
                ob_flush();
                ob_start();
                wp_head();

                $minigo_head = preg_replace('/<link.*?href=.*?wp-content\/themes\/.*?\/?>|<script.*?src=.*?wp-content\/themes\/.*?<\/script>/i', '', ob_get_clean());

                $minigo_head = preg_replace('/<style.*?>.*?<\/style>/im', '', $minigo_head);

                echo $minigo_head;
            } else {
                wp_head();
            }
        ?>

        <?php } ?>


        <link rel="stylesheet" href="<?php echo plugins_url( 'styles/main.min.css' , __FILE__ )?>"/>

        <script src="<?php echo plugins_url( 'scripts/modernizr.custom.min.js' , __FILE__ )?>"></script>
        <link href='//fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

        <!--[if lte IE 8]>
        <script src="<?php echo plugins_url( 'scripts/respond.min.js' , __FILE__ )?>"></script>
        <![endif]-->

        <script>
            var miniGoOptions = {
                theme: {
                    // Set to true to add a translucent background behind each page
                    contentBackground: <?php echo $premiothemes_comingsoon_minigo['contentBackground']?>
                },

                countdown: {
                    // Possible options are 'default' or 'piechart'
                    type: '<?php echo $premiothemes_comingsoon_minigo['countdown-type']?>',
                    // The date when the countdown started. Used by the progress bars. 24 Hour format (00 to 23): Month Day, Year Hours:Minutes
                    startDate: new Date(<?php echo strtotime($premiothemes_comingsoon_minigo['countdown-startDate'].' '.$premiothemes_comingsoon_minigo['countdown-startHour'].':'.$premiothemes_comingsoon_minigo['countdown-startMinutes']) * 1000?>),
                    // The target date we're counting down to. 24 Hour format (00 to 23): Month Day, Year Hours:Minutes
                    targetDate:  new Date(<?php echo strtotime($premiothemes_comingsoon_minigo['countdown-targetDate'].' '.$premiothemes_comingsoon_minigo['countdown-targetHour'].':'.$premiothemes_comingsoon_minigo['countdown-targetMinutes']) * 1000?>)
                },

                background: {
                    // Main background color
                    color: '<?php echo $premiothemes_comingsoon_minigo['background-color']?>',
                    // Path to pattern overlay or empty if not needed. Use '' for empty.
                    patternOverlay: '<?php echo $pattern?>',
                    // Sets the opacity of the pattern overlay. 0 is completely transparent, 1.0 is fully opaque.
                    patternOverlayOpacity: <?php echo $premiothemes_comingsoon_minigo['background-pattern-opacity']?>,
                    // Possible options are 'slideshow' or 'video'. Enter '' if no slideshow/video is desired as background.
                    type: '<?php echo $backgroundType?>',

                    slideshow: {
                        // Type of transition effect. Possible options are 'kenburns', 'fade' or 'continuousFade'.
                        type: '<?php echo $slideshowType?>',
                        // Time in seconds between image changes
                        duration: <?php echo $premiothemes_comingsoon_minigo['background-slideshow-duration']?>,

                        // Ken Burns animation settings
                        kenburns: {
                            // Minimum and maximum scale of the image. It will be randomized for every frame.
                            minScale: <?php echo $premiothemes_comingsoon_minigo['background-slideshow-kenburns-minScale']?>,
                            maxScale: <?php echo $premiothemes_comingsoon_minigo['background-slideshow-kenburns-maxScale']?>,
                            // Minimum and maximum movement of the image, in percent. It will be randomized for every frame. Note that this is also limited by the scale because the image needs to stay within the viewport.
                            minMove: <?php echo $premiothemes_comingsoon_minigo['background-slideshow-kenburns-minMove']?>,
                            maxMove: <?php echo $premiothemes_comingsoon_minigo['background-slideshow-kenburns-maxMove']?>
                        }
                    },

                    video: {
                        // Possible options are 'local' or 'youtube'
                        source: '<?php echo $videoSource?>',
                        // Fallback image for browsers that can't play video
                        imageFallback: '<?php echo $premiothemes_comingsoon_minigo['background-video-imageFallback']['url']?>',
                        // Sets the volume of the video. Value range 0 to 100.
                        volume: <?php echo $premiothemes_comingsoon_minigo['background-video-volume']?>,

                        // Configure the video files if you selected 'local' as video source
                        localFiles: {
                            // H.264 (mp4) video format file. This one is required because we use it to fall back to Flash playback when HTML5 video support is missing. For example, Firefox only supports this format on Windows so on other systems it will fallback to Flash playback which is a bit slower.
                            mp4: '<?php echo $premiothemes_comingsoon_minigo['background-video-mp4']['url']?>',
                            // Optional. WebM files are generally smaller and faster than H.264 and are played by Chrome, Firefox, Opera and Android browsers (which also support H.264)
                            webm: '<?php echo $premiothemes_comingsoon_minigo['background-video-webm']['url']?>',
                            // Optional. OGG Video is optional but useful because it's played natively by Firefox on OSX and Linux. Enter '' if you don't have this format.
                            ogg: '<?php echo $premiothemes_comingsoon_minigo['background-video-ogg']['url']?>',
                        },

                        youtube: {
                            // Enter the URL of the Video or Playlist
                            url: '<?php echo $premiothemes_comingsoon_minigo['background-youtube-url']?>',

                            // The options below allow you to play only a part of a video. For playlists it will only work for the first video.
                            // If you dont't want the video to start from the very beginning, enter the time offset in seconds.
                            startAt: <?php echo empty($premiothemes_comingsoon_minigo['background-youtube-startAt']) ? 0 : $premiothemes_comingsoon_minigo['background-youtube-startAt']?>,
                            // If you dont't want the video to end at the very end, enter the time offset FROM THE BEGINNING of the video, in seconds. Otherwise leave it at 0.
                            endAt: <?php echo empty($premiothemes_comingsoon_minigo['background-youtube-endAt']) ? 0 : $premiothemes_comingsoon_minigo['background-youtube-endAt']?>,
                        }
                    }
                }
            }

            var minigoSwfURLPrefix = '<?php echo plugins_url( '' , __FILE__ ).'/'?>';

        </script>

        <style><?php echo $premiothemes_comingsoon_minigo['custom-css']?></style>
    </head>
    <body>
        <div class="loader">
        	<?php if(!empty($premiothemes_comingsoon_minigo['logo']['url'])) { ?>
            <img class="loader-logo" src="<?php echo $premiothemes_comingsoon_minigo['logo']['url']?>" alt="<?php echo htmlspecialchars($premiothemes_comingsoon_minigo['site-title'])?>" width="<?php echo $premiothemes_comingsoon_minigo['logo-width']?>" height="<?php echo $premiothemes_comingsoon_minigo['logo-height']?>">
            <?php } ?>
            <div class="bubblingG">
                <span id="bubblingG_1"></span>
                <span id="bubblingG_2"></span>
                <span id="bubblingG_3"></span>
            </div>
        </div>

        <div class="site-wrapper">
            <div class="site-page site-front site-page--active">
				<?php echo apply_filters( 'the_content', $premiothemes_comingsoon_minigo['front-page-content'])?>
            </div>

			<?php if($premiothemes_comingsoon_minigo['left-page-enabled']) { ?>
            <div id="aboutPage" class="site-page site-page--from-left">
            	<?php if(!empty($premiothemes_comingsoon_minigo['left-page-title'])) { ?>
                <h1><?php echo $premiothemes_comingsoon_minigo['left-page-title']?></h1>
                <?php } ?>
                <?php echo apply_filters( 'the_content', $premiothemes_comingsoon_minigo['left-page-content']);?>
            </div>
            <?php } ?>

			<?php if($premiothemes_comingsoon_minigo['right-page-enabled']) { ?>
            <div id="contactPage" class="site-page site-page--from-right">
                <?php if(!empty($premiothemes_comingsoon_minigo['right-page-title'])) { ?>
                <h1><?php echo $premiothemes_comingsoon_minigo['right-page-title']?></h1>
                <?php } ?>
                <?php echo apply_filters( 'the_content', $premiothemes_comingsoon_minigo['right-page-content']);?>
            </div>
            <?php } ?>
        </div>

		<?php
		function minigo_footer_links() {
			global $premiothemes_comingsoon_minigo;

		    if(empty($premiothemes_comingsoon_minigo['footer_links']) || count($premiothemes_comingsoon_minigo['footer_links']) < 1) {
		        return;
		    }

		    $contact_info = array_values($premiothemes_comingsoon_minigo['footer_links']);

		    if(empty($premiothemes_comingsoon_minigo['footer_links'][0]['title'])) {
		        return;
		    }

		    $html = '<div class="nav-social">';


		    for ($i=0, $cnt = count($contact_info); $i < $cnt; $i++) {
		        $item = $contact_info[$i];

		        $html .= '<a href="'.$item['url'].'" title="'.htmlspecialchars($item['title']).'"><i class="fa '.$item['select'].'"></i></a>'."\n";
		    }

		    return $html.'</div>';
		}
		echo minigo_footer_links();
		?>

		<?php if($premiothemes_comingsoon_minigo['left-page-enabled']) { ?>
        <div class="nav-left">
            <a href="#aboutPage" title="<?php echo htmlspecialchars($premiothemes_comingsoon_minigo['left-page-label'])?>" class="site-page__trigger"><i class="fa <?php echo $premiothemes_comingsoon_minigo['left-page-icon']?>"></i></a>
        </div>
        <?php } ?>
        <?php if($premiothemes_comingsoon_minigo['right-page-enabled']) { ?>
        <div class="nav-right">
            <a href="#contactPage" title="<?php echo htmlspecialchars($premiothemes_comingsoon_minigo['right-page-label'])?>" class="site-page__trigger"><i class="fa <?php echo $premiothemes_comingsoon_minigo['right-page-icon']?>"></i></a>
        </div>
        <?php } ?>
        <?php if($premiothemes_comingsoon_minigo['left-page-enabled'] || $premiothemes_comingsoon_minigo['right-page-enabled']) { ?>
        <div class="nav-close">
            <a href="#" title="<?php echo $premiothemes_comingsoon_minigo['close-button-label']?>" class="site-page__close"><i class="fa <?php echo htmlspecialchars($premiothemes_comingsoon_minigo['close-button-icon'])?>"></i></a>
        </div>
        <?php } ?>

		<?php
		if(!empty($gallery)) {
		echo '<figure class="bg-wrapper">';
			$newGallery = array();
			foreach ($gallery as $key => $img) {
				$newGallery[$img->ID] = $gallery[$key];
			}

			$order = explode(',', $premiothemes_comingsoon_minigo['background-slideshow-gallery']);

			$srcAttr = 'src';
			foreach ($order as $id) {

				$id = intval($id);

				$img = wp_get_attachment_image_src($id, 'full');

				echo '<img '.$srcAttr.'="'.$img[0].'" width="'.$img[1].'" height="'.$img[2].'" alt="'.(!empty($newGallery[$id]->post_excerpt) ? htmlspecialchars($newGallery[$id]->post_excerpt) : htmlspecialchars($newGallery[$id]->post_title)).'">';

				$srcAttr = 'data-src';
			}

        echo '</figure>';
        } ?>

        <?php if(!$premiothemes_comingsoon_minigo['load-other-assets']) { ?>

        <!--[if lte IE 8]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><![endif]-->
        <!--[if gt IE 8]><!--><script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script><!--<![endif]-->

        <?php } ?>

        <script src="<?php echo plugins_url( 'scripts/flipclock.min.js' , __FILE__ )?>"></script>

        <!--[if gt IE 8]><!-->
        <script src="<?php echo plugins_url( 'scripts/jquery.easypiechart.min.js' , __FILE__ )?>"></script>
        <!--<![endif]-->

        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


        <script src="<?php echo plugins_url( 'scripts/main.min.js' , __FILE__ )?>"></script>

        <!--[if lte IE 9]>
        <script src="<?php echo plugins_url( 'scripts/jquery.placeholder.min.js' , __FILE__ )?>"></script>
        <![endif]-->

        <?php if($premiothemes_comingsoon_minigo['load-other-assets']) { ?>

        <?php
            if($premiothemes_comingsoon_minigo['strip-theme-assets']) {
                ob_flush();
                ob_start();
                wp_footer();

                $minigo_footer = preg_replace('/<link.*?href=.*?wp-content\/themes\/.*?\/?>|<script.*?src=.*?wp-content\/themes\/.*?<\/script>/i', '', ob_get_clean());

                $minigo_footer = preg_replace('/<style.*?>.*?<\/style>/im', '', $minigo_footer);

                echo $minigo_footer;
            } else {
                wp_footer();
            }

        }
        ?>

        <?php echo $premiothemes_comingsoon_minigo['custom-html']?>

</body>
</html>