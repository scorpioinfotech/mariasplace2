<?php

class PremioThemes_ComingSoon_Admin {

    function __construct() {
        /**
            ReduxFramework Sample Config File
            For full documentation, please visit http://reduxframework.com/docs/
        **/


        /**

            Most of your editing will be done in this section.

            Here you can override default values, uncomment args and change their values.
            No $args are required, but they can be overridden if needed.

        **/

        global $minigo_path;
        global $minigo_url;
        global $minigo_version;

        $args = array();


        // For use with a tab example below
        $tabs = array();

        // $sampleHTML = '';
        // if( file_exists( dirname(__FILE__).'/info-html.html' )) {
        // 	/** @global WP_Filesystem_Direct $wp_filesystem  */
        // 	global $wp_filesystem;
        // 	if (empty($wp_filesystem)) {
        // 		require_once(ABSPATH .'/wp-admin/includes/file.php');
        // 		WP_Filesystem();
        // 	}
        // 	$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
        // }

        // BEGIN Sample Config

        // Setting dev mode to true allows you to view the class settings/info in the panel.
        // Default: true
        $args['dev_mode'] = false;

        // Set the icon for the dev mode tab.
        // If $args['icon_type'] = 'image', this should be the path to the icon.
        // If $args['icon_type'] = 'iconfont', this should be the icon name.
        // Default: info-sign
        //$args['dev_mode_icon'] = 'info-sign';

        // Set the class for the dev mode tab icon.
        // This is ignored unless $args['icon_type'] = 'iconfont'
        // Default: null
        $args['dev_mode_icon_class'] = 'icon-large';

        // Set a custom option name. Don't forget to replace spaces with underscores!
        $args['opt_name'] = 'premiothemes_comingsoon_minigo';

        // Setting system info to true allows you to view info useful for debugging.
        // Default: false
        //$args['system_info'] = true;


        // Set the icon for the system info tab.
        // If $args['icon_type'] = 'image', this should be the path to the icon.
        // If $args['icon_type'] = 'iconfont', this should be the icon name.
        // Default: info-sign
        //$args['system_info_icon'] = 'info-sign';

        // Set the class for the system info tab icon.
        // This is ignored unless $args['icon_type'] = 'iconfont'
        // Default: null
        $args['system_info_icon_class'] = 'icon-large';


        $args['display_name'] = '<img width="96" height="96" src="'.plugins_url( 'img/logo.png' , __FILE__ ).'"><a href="http://www.premiothemes.com/" target="_blank" style="display: none;" class="premiothemes-logo"><img width="150" height="30" src="'.plugins_url( 'img/premiothemes-logo.png' , __FILE__ ).'"></a>';
        //$args['database'] = "theme_mods_expanded";
        $args['display_version'] = '<h3>MiniGO WP Plugin<small>Version : '.$minigo_version.'</small></h3>';

        // If you want to use Google Webfonts, you MUST define the api key.
        $args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

        $args['admin_bar'] = false; // Show the panel pages on the admin bar

        // Define the starting tab for the option panel.
        // Default: '0';
        //$args['last_tab'] = '0';

        // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
        // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
        // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
        // Default: 'standard'
        //$args['admin_stylesheet'] = 'standard';

        // Setup custom links in the footer for share icons
        // $args['share_icons']['twitter'] = array(
        //     'link' => 'http://twitter.com/ghost1227',
        //     'title' => 'Follow me on Twitter',
        //     'img' => ReduxFramework::$_url . 'assets/img/social/Twitter.png'
        // );
        // $args['share_icons']['linked_in'] = array(
        //     'link' => 'http://www.linkedin.com/profile/view?id=52559281',
        //     'title' => 'Find me on LinkedIn',
        //     'img' => ReduxFramework::$_url . 'assets/img/social/LinkedIn.png'
        // );

        // Enable the import/export feature.
        // Default: true
        //$args['show_import_export'] = false;

        // Set the icon for the import/export tab.
        // If $args['icon_type'] = 'image', this should be the path to the icon.
        // If $args['icon_type'] = 'iconfont', this should be the icon name.
        // Default: refresh
        //$args['import_icon'] = 'refresh';

        // Set the class for the import/export tab icon.
        // This is ignored unless $args['icon_type'] = 'iconfont'
        // Default: null
        $args['import_icon_class'] = 'icon-large';

        /**
        * Set default icon class for all sections and tabs
        * @since 3.0.9
        */
        $args['default_icon_class'] = 'icon-large';


        // Set a custom menu icon.
        if ( version_compare( get_bloginfo( 'version' ), '3.8', '>=' ) ) {
            $args['menu_icon'] = 'dashicons-marker';
        }

        // Set a custom title for the options page.
        // Default: Options
        $args['menu_title'] = __('MiniGO Options', 'premiothemes-comingsoon-minigo');

        // Set a custom page title for the options page.
        // Default: Options
        $args['page_title'] = __('MiniGO Options', 'premiothemes-comingsoon-minigo');

        // Set a custom page slug for options page (wp-admin/themes.php?page=***).
        // Default: redux_options
        $args['page_slug'] = 'minigo_options';

        $args['default_show'] = false;
        $args['default_mark'] = '*';

        // Set a custom page capability.
        // Default: manage_options
        //$args['page_cap'] = 'manage_options';

        // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
        // Default: menu
        //$args['page_type'] = 'submenu';

        // Set the parent menu.
        // Default: themes.php
        // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        //$args['page_parent'] = 'options_general.php';

        // Set a custom page location. This allows you to place your menu where you want in the menu order.
        // Must be unique or it will override other items!
        // Default: null
        //$args['page_position'] = null;

        // Set a custom page icon class (used to override the page icon next to heading)
        //$args['page_icon'] = 'icon-themes';

        // Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
        // Redux no longer ships with standard icons!
        // Default: iconfont
        //$args['icon_type'] = 'image';

        // Disable the panel sections showing as submenu items.
        // Default: true
        //$args['allow_sub_menu'] = false;

        // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
        // $args['help_tabs'][] = array(
        //     'id' => 'redux-opts-1',
        //     'title' => __('Theme Information 1', 'premiothemes-comingsoon-minigo'),
        //     'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'premiothemes-comingsoon-minigo')
        // );
        // $args['help_tabs'][] = array(
        //     'id' => 'redux-opts-2',
        //     'title' => __('Theme Information 2', 'premiothemes-comingsoon-minigo'),
        //     'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'premiothemes-comingsoon-minigo')
        // );

        // Set the help sidebar for the options page.
        //$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'premiothemes-comingsoon-minigo');


        // Add HTML before the form.
        if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
            if (!empty($args['global_variable'])) {
                $v = $args['global_variable'];
            } else {
                $v = str_replace("-", "_", $args['opt_name']);
            }
            $args['intro_text'] = '<a href="http://www.premiothemes.com/help/minigo-wp/" target="_blank" class="button">Online Documentation</a><a href="'.site_url().'?cs_preview'.'" target="_blank" class="button">Preview</a>';
        } else {
            //$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'premiothemes-comingsoon-minigo');
        }

        // Add content after the form.
        //$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'premiothemes-comingsoon-minigo');

        // Set footer/credit line.
        $args['footer_credit'] = '&nbsp;';


        $sections = array();

        //Background Patterns Reader
        $patterns_path = $minigo_path . 'template/images/patterns/';
        $patterns_url  = $minigo_url . 'template/images/patterns/';
        $patterns      = array();

        if ( is_dir( $patterns_path ) ) :

        if ( $patterns_dir = opendir( $patterns_path ) ) :
            $patterns = array();

            while ( ( $patterns_file = readdir( $patterns_dir ) ) !== false ) {

            if( stristr( $patterns_file, '.png' ) !== false || stristr( $patterns_file, '.jpg' ) !== false ) {
                $name = explode(".", $patterns_file);
                $name = str_replace('.'.end($name), '', $patterns_file);
                $patterns[] = array( 'alt'=>$name,'img' => $patterns_url . $patterns_file );
            }
            }
        endif;
        endif;

        $sections[] = array(
            'title' => __('Main Settings', 'premiothemes-comingsoon-minigo'),
            // 'header' => __('jjjjjjj', 'premiothemes-comingsoon-minigo'),
            // 'desc' => __('In this section you can edit theme ', 'premiothemes-comingsoon-minigo'),
            'icon_class' => 'icon-large',
            'icon' => 'el-icon-wrench',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                array(
                    'id'=>'comingsoon-enabled',
                    'type' => 'select',
                    'select2' => array(
                        'allowClear' => false,
                        'minimumResultsForSearch' => 10
                    ),
                    'options' => array(
                            0 => 'Off',
                            'coming_soon' => 'Coming Soon Mode',
                            'maintenance_mode' => 'Maintenance Mode (HTTP 503)'
                        ),
                    'title' => __('Plugin Mode', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Choose the mode in which you want the plugin to operate in. <strong>Note that, when enabled, the plugin will only be visible to visitors that aren\'t logged in.</strong>', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('<ul><li><strong>Off</strong> - MiniGO will only be displayed in the preview mode.</li><li><strong>Coming Soon Mode</strong> - Visitors will see MiniGO while you work on your theme. HTTP codes will be normal so search bots will index MiniGO.</li><li><strong>Maintenance Mode</strong> - Use whenever you\'re doing work on an existing website. This keeps the search engine bots from indexing MiniGO by sending an HTTP 503 header.</li></ul>', 'premiothemes-comingsoon-minigo'),
                    'default' => 0,
                    ),
                array(
                    'id'=>'site-title',
                    'type' => 'text',
                    'title' => __('Site Title', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Used as the window/tab title.'),
                    "default" 		=> 'MiniGO - Uber Minimal Flat Coming Soon WP Plugin',
                    ),
                array(
                    'id'=>'logo',
                    'type' => 'media',
                    'preview' => true,
                    'url'=> false,
                    'title' => __('Logo', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('Use the <em>Logo Width</em> and <em>Logo Height</em> settings below if you want to force a certain size. For example, set it to half the actual logo size to make it look sharper on Retina displays.', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('This can be accessed by using the <strong>[minigo-logo]</strong> shortcode in your pages.', 'premiothemes-comingsoon-minigo'),
                    'default' => array('url' => 'http://premiothemes.com/demos/minigo-html/images/logo.png')
                    ),
                array(
                    'id'=>'logo-width',
                    'type' => 'text',
                    'title' => __('Logo Width', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Maximum width in pixels.'),
                    "default" 		=> '141',
                    "validate" => 'numeric'
                    ),
                array(
                    'id'=>'logo-height',
                    'type' => 'text',
                    'title' => __('Logo Height', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Maximum height in pixels.'),
                    "default" 		=> '141',
                    "validate" => 'numeric'
                    ),
                array(
                    'id'=>'favicon',
                    'type' => 'media',
                    'preview' => true,
                    'url'=> false,
                    'title' => __('Favicon', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('Use a 16x16 .ico or .png file.', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('This is the icon displayed in the browser title bar.', 'premiothemes-comingsoon-minigo'),
                    'default' => array('url' => $minigo_url . 'template/favicon.ico')
                    ),
                array(
                    'id'=>'contentBackground',
                    'type' => 'switch',
                    'title' => __('Content Background', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Choose whether or not you want your content sections to have a translucent background.', 'premiothemes-comingsoon-minigo'),
                    "default" 		=> 0,
                    ),
                array(
                    'id'=>'custom-css',
                    'type' => 'ace_editor',
                    'title' => __('Custom CSS', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Paste your CSS code here.', 'premiothemes-comingsoon-minigo'),
                    'mode' => 'css',
                    //'theme' => 'monokai',
                    'desc' => 'Use this field to customize the layout or style of your MiniGO install.',
                    'default' => ''
                    ),
                array(
                    'id'=>'custom-html',
                    'type' => 'ace_editor',
                    'title' => __('Custom HTML', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Paste your HTML code here.', 'premiothemes-comingsoon-minigo'),
                    'mode' => 'html',
                    //'theme' => 'monokai',
                    'desc' => 'Inserts HTML before the closing &lt;/body&gt; tag. For example, it can be used to add your Google Analytics code.',
                    'default' => ''
                    ),
            )
        );

        $sections[] = array(
            'title' => __('Page Content', 'premiothemes-comingsoon-minigo'),
            //'header' => __('jjjjjjj', 'premiothemes-comingsoon-minigo'),
            'desc' => __('

                <p>In this section you can edit the content of your pages.</p>
                <p>The following shortcodes are available:</p>
                <ul>
                <li><strong>[minigo-logo]</strong> : Displays the logo as configured in the Main Settings section.</li>
                <li><strong>[minigo-countdown]</strong> : Displays the countdown timer as configured in the Countdown Settings section.</li>
                <li><strong>[minigo-subscribe-form]</strong> : Displays the "Get Notified" subscription form as configured in the Contact Settings section.</li>
                <li><strong>[minigo-contact-info]</strong> : Displays the contact info (phone, e-mail, etc.) as configured in the Contact Settings section.</li>
                <li><strong>[minigo-contact-form]</strong> : Displays the contact form as configured in the Contact Settings section.</li>
                </ul>

                ', 'premiothemes-comingsoon-minigo'),
            'icon_class' => 'icon-large',
            'icon' => 'el-icon-file-edit',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                array(
                    'id'=>'front-page-content',
                    'type' => 'editor',
                    'editor_options' => array(
                        'teeny' => false,
                        'textarea_rows' => 20
                    ),
                    'title' => __('Front Page Content', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => "[minigo-logo]\n\n<h3>Welcome to MiniGO, a clean, modern coming soon template.</h3>\n\n[minigo-countdown]\n\n[minigo-subscribe-form]",
                    ),
                array(
                    'id'=>'close-button-label',
                    'type' => 'text',
                    'title' => __('Close Button Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The label of the button that appears when navigating away front the front page.', 'premiothemes-comingsoon-minigo'),
                    'default' => 'CLOSE',
                    ),
                array(
                    'id'=>'close-button-icon',
                    'type' => 'select',
                    'title' => __('Close Button Icon', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The icon of the button that appears when navigating away front the front page.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('The icons are from <a href="http://fontawesome.io/" target="_blank">Font Awesome</a>', 'premiothemes-comingsoon-minigo'),
                    'options' => minigo_get_font_awesome_icons(),
                    'class' => 'font-awesome-icons',
                    'default' => 'fa-times-circle'
                    ),
                array(
                    'id'=>'left-page',
                    'type' => 'section',
                    'indent' => true,
                    'title' => __('Left Page', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('The content of the page that slides in from the left.', 'premiothemes-comingsoon-minigo')
                    ),
                array(
                    'id'=>'left-page-enabled',
                    'type' => 'switch',
                    'title' => __('Enabled', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Choose whether or not you want the left hand side page and button to be displayed.', 'premiothemes-comingsoon-minigo'),
                    "default" 		=> 1,
                    ),
                array(
                    'id'=>'left-page-label',
                    'type' => 'text',
                    'required' => array('left-page-enabled','=','1'),
                    'title' => __('Link Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The label of the left hand side button.', 'premiothemes-comingsoon-minigo'),
                    'default' => 'ABOUT',
                    ),
                array(
                    'id'=>'left-page-icon',
                    'type' => 'select',
                    'required' => array('left-page-enabled','=','1'),
                    'title' => __('Icon', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The icon of the left hand side button.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('The icons are from <a href="http://fontawesome.io/" target="_blank">Font Awesome</a>', 'premiothemes-comingsoon-minigo'),
                    'options' => minigo_get_font_awesome_icons(),
                    'class' => 'font-awesome-icons',
                    'default' => 'fa-info-circle'
                    ),
                array(
                    'id'=>'left-page-title',
                    'type' => 'text',
                    'required' => array('left-page-enabled','=','1'),
                    'title' => __('Title', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Who we are',
                    ),
                array(
                    'id'=>'left-page-content',
                    'type' => 'editor',
                    'editor_options' => array(
                        'teeny' => false,
                        'textarea_rows' => 20
                    ),
                    'required' => array('left-page-enabled','=','1'),
                    'title' => __('Content', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eget nibh at libero fringilla adipiscing nec ut leo. Etiam nec purus arcu. Morbi sollicitudin at risus id malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam sed tincidunt arcu. Donec molestie ante sapien, sed molestie est euismod eget. Maecenas ac metus accumsan, scelerisque massa sed, porta est. Aliquam ut mollis mi. Cras id vulputate purus, ac sollicitudin ante.\n\nInteger condimentum eu lectus quis semper. Sed id metus magna. Morbi ultrices magna id euismod hendrerit. Pellentesque nec mattis odio, vitae laoreet metus. Sed eget sollicitudin est, vitae accumsan nisi. Fusce consequat imperdiet venenatis. Integer mollis hendrerit facilisis. Praesent vel mattis enim. Integer fringilla et urna vitae rutrum.",
                    ),

                array(
                    'id'=>'right-page',
                    'type' => 'section',
                    'indent' => true,
                    'title' => __('Right Page', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('The content of the page that slides in from the right.', 'premiothemes-comingsoon-minigo')
                    ),
                array(
                    'id'=>'right-page-enabled',
                    'type' => 'switch',
                    'title' => __('Enabled', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Choose whether or not you want the right hand side page and button to be displayed.', 'premiothemes-comingsoon-minigo'),
                    "default" 		=> 1,
                    ),
                array(
                    'id'=>'right-page-label',
                    'type' => 'text',
                    'required' => array('right-page-enabled','=','1'),
                    'title' => __('Link Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The text label of the right hand side button.', 'premiothemes-comingsoon-minigo'),
                    'default' => 'CONTACT',
                    ),
                array(
                    'id'=>'right-page-icon',
                    'type' => 'select',
                    'required' => array('right-page-enabled','=','1'),
                    'title' => __('Icon', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The icon of the right hand side button.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('The icons are from <a href="http://fontawesome.io/" target="_blank">Font Awesome</a>', 'premiothemes-comingsoon-minigo'),
                    'options' => minigo_get_font_awesome_icons(),
                    'class' => 'font-awesome-icons',
                    'default' => 'fa-envelope'
                    ),
                array(
                    'id'=>'right-page-title',
                    'type' => 'text',
                    'required' => array('right-page-enabled','=','1'),
                    'title' => __('Title', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Get in touch',
                    ),
                array(
                    'id'=>'right-page-content',
                    'type' => 'editor',
                    'editor_options' => array(
                        'teeny' => false,
                        'textarea_rows' => 20
                    ),
                    'required' => array('right-page-enabled','=','1'),
                    'title' => __('Content', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => "[minigo-contact-info]\n\n[minigo-contact-form]",
                    ),
            )
        );

        $sections[] = array(
            'title' => __('Countdown Settings', 'premiothemes-comingsoon-minigo'),
            // 'header' => __('jjjjjjj', 'premiothemes-comingsoon-minigo'),
            'desc' => __('This can be accessed by using the <strong>[minigo-countdown]</strong> shortcode in your pages.', 'premiothemes-comingsoon-minigo'),
            'icon_class' => 'icon-large',
            'icon' => 'el-icon-time',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                array(
                    'id'=>'countdown-enabled',
                    'type' => 'switch',
                    'title' => __('Enable Countdown', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Choose whether or not you want the countdown timer to be displayed.', 'premiothemes-comingsoon-minigo'),
                    "default" 		=> 1,
                    ),
                array(
                    'id'=>'countdown-type',
                    'type' => 'select',
                    'select2' => array(
                        'allowClear' => false,
                        'minimumResultsForSearch' => 10
                    ),
                    'required' => array('countdown-enabled','=','1'),
                    'options' => array(
                            'default' => 'Default',
                            'piechart' => 'Pie Chart'
                        ),
                    'title' => __('Countdown Type', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Choose between two different countdown styles.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'default',
                    ),
                array(
                    'id'=>'countdown-startDate',
                    'type' => 'date',
                    'required' => array('countdown-enabled','=','1'),
                    'title' => __('Countdown Start - Date', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Date when the countdown started. Needed for the countdown progress bar.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => date('m/d/Y', time() - 7 * 24 * 60 * 60)
                    ),
                array(
                    'id'=>'countdown-startHour',
                    'type' => 'spinner',
                    'required' => array('countdown-enabled','=','1'),
                    'title' => __('Countdown Start - Hour', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Time when the countdown started. 24 hour format (00 to 23).', 'premiothemes-comingsoon-minigo'),
                    "default" 	=> "23",
                    "min" 		=> "00",
                    "step"		=> "1",
                    "max" 		=> "23",
                    ),
                array(
                    'id'=>'countdown-startMinutes',
                    'type' => 'spinner',
                    'required' => array('countdown-enabled','=','1'),
                    'title' => __('Countdown Start - Minutes', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('', 'premiothemes-comingsoon-minigo'),
                    "default" 	=> "59",
                    "min" 		=> "00",
                    "step"		=> "1",
                    "max" 		=> "59",
                    ),
                array(
                    'id'=>'countdown-targetDate',
                    'type' => 'date',
                    'required' => array('countdown-enabled','=','1'),
                    'title' => __('Countdown End - Date', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Date that we\'re counting down to.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => date('m/d/Y', time() + 7 * 24 * 60 * 60)
                    ),
                array(
                    'id'=>'countdown-targetHour',
                    'type' => 'spinner',
                    'required' => array('countdown-enabled','=','1'),
                    'title' => __('Countdown End - Hour', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Time that we\'re counting down to. 24 hour format (00 to 23).', 'premiothemes-comingsoon-minigo'),
                    "default" 	=> "23",
                    "min" 		=> "00",
                    "step"		=> "1",
                    "max" 		=> "23",
                    ),
                array(
                    'id'=>'countdown-targetMinutes',
                    'type' => 'spinner',
                    'required' => array('countdown-enabled','=','1'),
                    'title' => __('Countdown End - Minutes', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('', 'premiothemes-comingsoon-minigo'),
                    "default" 	=> "59",
                    "min" 		=> "00",
                    "step"		=> "1",
                    "max" 		=> "59",
                    ),
                array(
                    'id'=>'countdown-labels',
                    'type' => 'text',
                    'required' => array('countdown-enabled','=','1'),
                    'title' => __('Labels', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('The labels of the individual countdown items. Comma separated list.', 'premiothemes-comingsoon-minigo'),
                    "default" 	=> "Days,Hours,Minutes,Seconds",
                    ),
            )
        );

        $sections[] = array(
            'title' => __('Background Settings', 'premiothemes-comingsoon-minigo'),
            // 'header' => __('jjjjjjj', 'premiothemes-comingsoon-minigo'),
            // 'desc' => __('In this section you can edit theme ', 'premiothemes-comingsoon-minigo'),
            'icon_class' => 'icon-large',
            'icon' => 'el-icon-picture',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                array(
                    'id'=>'background-color',
                    'type' => 'color',
                    'title' => __('Background Color', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('The main background color.', 'premiothemes-comingsoon-minigo'),
                    "default" => '#000000',
                    'validate' => 'color'
                    ),

                array(
                    'id'=>'background-type',
                    'type' => 'radio',
                    'title' => __('Background Type', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('<p>Choose whether you want a solid background, a slideshow or a video as background.</p><p>There are 3 types of slideshow transition effects.</p><p>The Video type uses your own video files, while YouTube allows you to use any YouTube video or playlist.</p>', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('<p><strong>Important notice : </strong> Videos don\'t auto-play on iOS devices (iPhone, iPad, iPod). Apple disabled this on purpose. Also, videos will not be loaded on slow network connections on touch devices.</p>', 'premiothemes-comingsoon-minigo'),
                    'options' => array(
                        'color' => 'Solid Color',
                        'slideshow-kenburns' => 'Slideshow - Ken Burns',
                        'slideshow-fade' => 'Slideshow - Fade',
                        'slideshow-continuousFade' => 'Slideshow - Continuous Fade',
                        'video' => 'Video',
                        'youtube' => 'YouTube'
                    ),
                    'default' => 'color'
                    ),

                array(
                    'id'=>'background-slideshow-duration',
                    'type' => 'text',
                    'required' => array('background-type','contains','slideshow'),
                    'title' => __('Time between slides', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Number of seconds each slide is visible for.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 10,
                    'class' => 'small-text'
                    ),
                array(
                    'id'=>'background-slideshow-kenburns-minScale',
                    'type' => 'text',
                    'required' => array('background-type','equals','slideshow-kenburns'),
                    'title' => __('Ken Burns - Minimum Scale', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Minimum scale of the image. The value will be randomized for every slide within the min/max limits.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('Use a minimum of 1.0', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 1.2,
                    'class' => 'small-text'
                    ),
                array(
                    'id'=>'background-slideshow-kenburns-maxScale',
                    'type' => 'text',
                    'required' => array('background-type','equals','slideshow-kenburns'),
                    'title' => __('Ken Burns - Maximum Scale', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Maximum scale of the image. This value will be randomized for every slide within the min/max limits.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('This needs to be higher than Minimum Scale.', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 1.7,
                    'class' => 'small-text'
                    ),
                array(
                    'id'=>'background-slideshow-kenburns-minMove',
                    'type' => 'text',
                    'required' => array('background-type','equals','slideshow-kenburns'),
                    'title' => __('Ken Burns - Minimum Movement', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Minimum movement of the image, in percentages. The actual value will be randomized for every slide, all within the min/max limits. Note that this is also limited by the scale because the image needs to stay within the viewport bounds.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('Use a minimum of 0', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 5,
                    'class' => 'small-text'
                    ),
                array(
                    'id'=>'background-slideshow-kenburns-maxMove',
                    'type' => 'text',
                    'required' => array('background-type','equals','slideshow-kenburns'),
                    'title' => __('Ken Burns - Maximum Movement', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Maximum movement of the image, in percentages. The actual value will be randomized for every slide, all within the min/max limits. Note that this is also limited by the scale because the image needs to stay within the viewport bounds.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('This needs to be higher than Minimum Movement.', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 15,
                    'class' => 'small-text'
                    ),
                array(
                    'id' => 'background-slideshow-gallery',
                    'type' => 'gallery',
                    'required' => array('background-type','contains','slideshow'),
                    'title' => __('Slideshow Images', 'so-panels'),
                    'subtitle' => __('Select the images you want in the slideshow.', 'so-panels'),
                    ),

                array(
                    'id'=>'background-video-imageFallback',
                    'type' => 'media',
                    'preview' => true,
                    'url'=> false,
                    'required' => array('background-type','equals', array('video', 'youtube')),
                    'title' => __('Video Fallback Image', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Fallback image for browsers that can\'t play video (such as mobile devices).', 'premiothemes-comingsoon-minigo'),
                    'default' => array('url' => '')
                    ),

                array(
                    'id'=>'background-video-volume',
                    'type' => 'slider',
                    'required' => array('background-type','equals', array('video', 'youtube')),
                    'title' => __('Video Volume', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('<p>Sets the audio volume of the video. Value range 0 to 100.</p><p>Note that the volume setting doesn\'t work on Phones and Tablets', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    "default" 		=> 0,
                    "min" 		=> 0,
                    "step"		=> 1,
                    "max" 		=> 100
                    ),
                array(
                    'id'=>'background-video-mp4',
                    'type' => 'media',
                    'mode' => 'video',
                    'url'=> true,
                    'preview' => false,
                    'required' => array('background-type','equals', 'video'),
                    'title' => __('Video File - MP4', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('H.264 (mp4) video format file. This one is required because we use it to fall back to Flash playback when HTML5 video support is missing. For example, Firefox only supports this format natively on Windows so on other systems it will fallback to Flash playback which is a bit slower.', 'premiothemes-comingsoon-minigo'),
                    'default' => array('url' => '')
                    ),
                array(
                    'id'=>'background-video-webm',
                    'type' => 'media',
                    'mode' => 'video',
                    'url'=> true,
                    'preview' => false,
                    'required' => array('background-type','equals', 'video'),
                    'title' => __('Video File - WebM', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Optional WebM format. WebM files are generally smaller and faster than H.264 and are played by Chrome, Firefox, Opera and Android browsers (which also support H.264).', 'premiothemes-comingsoon-minigo'),
                    'default' => array('url' => '')
                    ),
                array(
                    'id'=>'background-video-ogg',
                    'type' => 'media',
                    'mode' => 'video',
                    'url'=> true,
                    'preview' => false,
                    'required' => array('background-type','equals', 'video'),
                    'title' => __('Video File - OGG', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __('', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Optional OGG format. OGG Video is optional but useful because it’s played natively by Firefox on OSX and Linux.', 'premiothemes-comingsoon-minigo'),
                    'default' => array('url' => '')
                    ),

                array(
                    'id'=>'background-youtube-url',
                    'type' => 'text',
                    'required' => array('background-type','equals', 'youtube'),
                    'title' => __('YouTube URL', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The URL of the Youtube Video or Playlist.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'url',
                    'default' => 'http://www.youtube.com/watch?v=ab0TSkLe-E0',
                    'class' => 'small-text'
                    ),
                array(
                    'id'=>'background-youtube-startAt',
                    'type' => 'text',
                    'required' => array('background-type','equals', 'youtube'),
                    'title' => __('YouTube Video - Start at', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('If you dont’t want the video to start from the very beginning, enter the time offset in seconds.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 0,
                    'class' => 'small-text'
                    ),
                array(
                    'id'=>'background-youtube-endAt',
                    'type' => 'text',
                    'required' => array('background-type','equals', 'youtube'),
                    'title' => __('YouTube Video - End at', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('If you dont’t want the video to end at the very end, enter the time offset <strong>FROM THE BEGINNING</strong> of the video, in seconds. Otherwise leave it at 0.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 0,
                    'class' => 'small-text'
                    ),

                array(
                    'id'=>'background-pattern',
                    'type' => 'button_set',
                    'title' => __('Pattern Overlay', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('You can use a pattern image as overlay over the background slideshow/video. Choose a preset or select Custom to upload your own.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'options' => array(
                        'off' => 'Off',
                        'preset' => 'Preset',
                        'custom' => 'Custom'
                    ),
                    'default' => 'off'
                    ),
                array(
                    'id'=>'background-patternPreset',
                    'type' => 'image_select',
                    'tiles' => true,
                    'required' => array('background-pattern','equals','preset'),
                    'title' => __('Pattern Preset', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Select a background pattern.', 'premiothemes-comingsoon-minigo'),
                    'default' 		=> $patterns[0]['img'],
                    'options' => $patterns
                    ),
                array(
                    'id'=>'background-patternCustom',
                    'type' => 'media',
                    'preview' => true,
                    'url'=> false,
                    'required' => array('background-pattern','equals','custom'),
                    'title' => __('Custom Pattern', 'premiothemes-comingsoon-minigo'),
                    'desc'=> __(''),
                    'subtitle' => __('Upload your pattern using the WordPress uploader', 'premiothemes-comingsoon-minigo'),
                    'default' => array('url' => '')
                    ),
                array(
                    'id'=>'background-pattern-opacity',
                    'type' => 'text',
                    'required' => array('background-pattern','not','off'),
                    'title' => __('Pattern Opacity', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Sets the opacity of the pattern overlay. 0 is completely transparent, 1.0 is fully opaque.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'validate' => 'numeric',
                    'default' => 0.2,
                    'class' => 'small-text'
                    ),
                )

        );

        $sections[] = array(
            'title' => __('Contact Settings', 'premiothemes-comingsoon-minigo'),
            // 'header' => __('jjjjjjj', 'premiothemes-comingsoon-minigo'),
            // 'desc' => __('In this section you can edit theme ', 'premiothemes-comingsoon-minigo'),
            'icon_class' => 'icon-large',
            'icon' => 'el-icon-envelope',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                    array(
                        'id'=>'contact_info',
                        'type' => 'contact_info',
                        'title' => __('Contact Info', 'premiothemes-comingsoon-minigo'),
                        'subtitle'=> __('These settings affect the subscription and contact forms.', 'premiothemes-comingsoon-minigo'),
                        'desc' => __(''),
                        'options' => minigo_get_font_awesome_icons(),
                        'default_show' => false,
                        'default' => array(
                                0 => array(
                                    'title' => '+1 555 85952',
                                    'select' => 'fa-phone',
                                    'sort' => 0
                                    ),
                                1 => array(
                                    'title' => 'mail@website.web',
                                    'url' => 'mailto:mail@website.web',
                                    'select' => 'fa-envelope-o',
                                    'sort' => 1
                                    ),
                                2 => array(
                                    'title' => '345 Rodeo Drive San Jose, CA 95111, USA',
                                    'select' => 'fa-map-marker',
                                    'force_row' => 1,
                                    'sort' => 2
                                    ),
                            )
                    ),
                    array(
                    'id'=>'contact-form',
                    'type' => 'section',
                    'indent' => true,
                    'title' => __('Contact Form Settings', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Settings for the Contact Form. It can be displayed anywhere by using the <strong>[minigo-contact-form]</strong> shortcode.', 'premiothemes-comingsoon-minigo')
                    ),
                    array(
                    'id'=>'contact-target-address',
                    'type' => 'text',
                    'title' => __('Target E-mail Address', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('This is the email address where you’ll receive the contact form messages.', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => get_option( 'admin_email' ),
                    ),
                    array(
                    'id'=>'contact-from-address',
                    'type' => 'text',
                    'title' => __('FROM E-mail Address', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('<p>By default, the Contact form FROM email is the same as the Target E-mail Address. However, some hosting providers won\'t allow email being sent from an address that isn\'t configured on the host\'s Mail service.</p><p>If you are not getting emails from the form try setting this to an address that is properly configured on your host.</p>', 'premiothemes-comingsoon-minigo'),
                    'default' => '',
                    ),
                    array(
                    'id'=>'contact-subject-prefix',
                    'type' => 'text',
                    'title' => __('E-mail Subject Prefix', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Prefix for the email subject. Useful for filtering mail.'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'MiniGO message from - ',
                    ),
                    array(
                    'id'=>'contact-form-name-label',
                    'type' => 'text',
                    'title' => __('Name Field Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Your name',
                    ),
                    array(
                    'id'=>'contact-form-email-label',
                    'type' => 'text',
                    'title' => __('Email Field Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Your e-mail address',
                    ),
                    array(
                    'id'=>'contact-form-message-label',
                    'type' => 'text',
                    'title' => __('Message Field Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Message',
                    ),
                    array(
                    'id'=>'contact-form-button-label',
                    'type' => 'text',
                    'title' => __('Button Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'SEND MESSAGE',
                    ),
                    array(
                    'id'=>'contact-form-success-message',
                    'type' => 'text',
                    'title' => __('Success Message', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The message displayed after the form is successfully submitted.', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Message sent!',
                    ),

                    array(
                    'id'=>'subscribe-form',
                    'type' => 'section',
                    'indent' => true,
                    'title' => __('Subscribe Form Settings', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('Settings for the Subscribe Form (titled "Get Notified" by default). It can be displayed anywhere by using the <strong>[minigo-subscribe-form]</strong> shortcode.', 'premiothemes-comingsoon-minigo')
                    ),
                    array(
                    'id'=>'subscribe-form-title',
                    'type' => 'text',
                    'title' => __('Title', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Get Notified',
                    ),
                    array(
                    'id'=>'subscribe-form-email-label',
                    'type' => 'text',
                    'title' => __('Email Field Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Your e-mail address',
                    ),
                    array(
                    'id'=>'subscribe-form-button-label',
                    'type' => 'text',
                    'title' => __('Button Label', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'GO',
                    ),
                    array(
                    'id'=>'subscribe-form-success-message',
                    'type' => 'text',
                    'title' => __('Success Message', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The message displayed after the form is successfully submitted.', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Got it, thank you',
                    ),
                    array(
                    'id'=>'subscribe-use_Mailchimp',
                    'type' => 'switch',
                    'title' => __('Use MailChimp', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Set to Yes if you want to use MailChimp to manage subscribers. If set to No the email addresses will be added to a simple text string.', 'premiothemes-comingsoon-minigo'),
                    'on' => 'Yes',
                    'off' => 'No',
                    'default' => 0,
                    ),
                    array(
                    'id'=>'subscribe-Mailchimp_API_Key',
                    'type' => 'text',
                    'required' => array('subscribe-use_Mailchimp','=','1'),
                    'title' => __('MailChimp API Key', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('In order to use MailChimp you’ll need an API Key. You can generate API Keys by going to <a href="https://admin.mailchimp.com/account/api/" target="_blank">Account settings -> Extras -> API keys</a>', 'premiothemes-comingsoon-minigo'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'abc123abc123abc123abc123abc123-us1',
                    ),
                    array(
                    'id'=>'subscribe-Mailchimp_list_ID',
                    'type' => 'text',
                    'required' => array('subscribe-use_Mailchimp','=','1'),
                    'title' => __('MailChimp List ID', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('Next you need to create a List in MailChimp and paste it’s ID here. The List ID can be found in the List’s Settings, on the right hand side.'),
                    'desc' => __('', 'premiothemes-comingsoon-minigo'),
                    'default' => 'b1234346',
                    ),
                    array(
                    'id'=>'subscribe-Mailchimp_double_optin',
                    'type' => 'switch',
                    'required' => array('subscribe-use_Mailchimp','=','1'),
                    'title' => __('Use MailChimp Double Opt-in', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('If set to Yes, it enables Double Opt-in. See the <a target="_blank" href="http://kb.mailchimp.com/article/how-does-confirmed-optin-or-double-optin-work/">this link</a> for reference on how it works.', 'premiothemes-comingsoon-minigo'),
                    'on' => 'Yes',
                    'off' => 'No',
                    'default' => 0,
                    ),
                    array(
                    'id'=>'subscribe-Mailchimp_send_welcome',
                    'type' => 'switch',
                    'required' => array('subscribe-use_Mailchimp','=','1'),
                    'title' => __('Send Welcome email from MailChimp', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('If Double Opt-in is disabled, you can still send a Welcome message by setting the following to true.<br> The option is ignored if Double Opt-in is on.', 'premiothemes-comingsoon-minigo'),
                    'on' => 'Yes',
                    'off' => 'No',
                    'default' => 0,
                    ),
                    array(
                    'id'=>'raw_info',
                    'type' => 'info',
                    'required' => array('subscribe-use_Mailchimp','=','0'),
                    'raw_html'=>true,
                    'desc' => '
<table class="form-table form-table-section no-border form-table-section-indented">
<tr valign="top">
    <th scope="row">
        <div class="redux_field_th">
            Subscribers<span style="font-weight: normal;" class="description">The list of subscribed e-mail addresses.</span>
        </div>
    </th>
    <td>
            <fieldset class="minigo_subscriber_list_form redux-field-container redux-field redux-container-text">
                <textarea placeholder="" class="noUpdate large-text" rows="6">'.htmlspecialchars(get_option( 'minigo_subscriber_list' )).'</textarea>
                <div class="description field-desc"><p>The e-mail addresses submited using the \'Get Notified\' form are added to this field when the MailChimp mode is disabled.<br>You can edit or clear the contents and Save the result.</p></div>
                <input style="margin-top: 10px;" type="submit" class="noUpdate button" value="Save">
            </fieldset>
    </td>
</tr>
</table>
                    ',
                    ),

                    array(
                    'id'=>'global-form',
                    'type' => 'section',
                    'indent' => true,
                    'title' => __('Global Form Settings', 'premiothemes-comingsoon-minigo'),
                    'subtitle'=> __('These settings apply to both the subscription and contact forms.')
                    ),
                    array(
                    'id'=>'form-validation-required',
                    'type' => 'text',
                    'title' => __('Required Field Validation Message', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The message displayed when a required form field is left blank.', 'premiothemes-comingsoon-minigo'),
                    'default' => 'This field is required.',
                    ),
                    array(
                    'id'=>'form-validation-email',
                    'type' => 'text',
                    'title' => __('Email Field Validation Message', 'premiothemes-comingsoon-minigo'),
                    'subtitle' => __('The message displayed when an incorrect e-mail address is entered in any of the e-mail form fields.', 'premiothemes-comingsoon-minigo'),
                    'default' => 'Please enter a valid email address.',
                    ),

                )
        );

        $sections[] = array(
            'title' => __('Footer Menu', 'premiothemes-comingsoon-minigo'),
            // 'header' => __('jjjjjjj', 'premiothemes-comingsoon-minigo'),
            'desc' => __('Here you can edit and sort the links displayed in the footer.', 'premiothemes-comingsoon-minigo'),
            'icon_class' => 'icon-large',
            'icon' => 'el-icon-link',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                    array(
                        'id'=>'footer_links',
                        'type' => 'footer_links',
                        'title' => __('Links', 'premiothemes-comingsoon-minigo'),
                        'subtitle'=> __('', 'premiothemes-comingsoon-minigo'),
                        'desc' => __(''),
                        'options' => minigo_get_font_awesome_icons(),
                        'default_show' => false,
                        'default' => array(
                                0 => array(
                                    'title' => 'Follow us on Twitter',
                                    'select' => 'fa-twitter',
                                    'url' => '#',
                                    'sort' => 0
                                    ),
                                1 => array(
                                    'title' => 'Like us on Facebook',
                                    'url' => '#',
                                    'select' => 'fa-facebook',
                                    'sort' => 1
                                    ),
                                2 => array(
                                    'title' => 'Join us on LinkedIn',
                                    'url' => '#',
                                    'select' => 'fa-linkedin',
                                    'sort' => 2
                                    ),
                                3 => array(
                                    'title' => 'Pinterest Pinboard',
                                    'url' => '#',
                                    'select' => 'fa-pinterest',
                                    'sort' => 3
                                    ),
                                4 => array(
                                    'title' => 'Our works on Dribbble',
                                    'url' => '#',
                                    'select' => 'fa-dribbble',
                                    'sort' => 4
                                    ),
                            )
                    ),
                )
            );

            $sections[] = array(
                'title' => __('Advanced Settings', 'premiothemes-comingsoon-minigo'),
                'icon_class' => 'icon-large',
                'icon' => 'el-icon-lock',
                'fields' => array(
                    array(
                        'id'=>'load-other-assets',
                        'type' => 'switch',
                        'title' => __('Load Styles and Scripts from other Plugins', 'premiothemes-comingsoon-minigo'),
                        'subtitle'=> __('<p>Choose whether or not to load CSS and Javascript files enqueued by the active theme and other active plugins.</p><p>This will allow you to use any shortcodes that other plugins provide but <strong>may break MiniGO.</strong></p>', 'premiothemes-comingsoon-minigo'),
                        "default"       => 0,
                        ),
                    array(
                        'id'=>'strip-theme-assets',
                        'type' => 'switch',
                        'required' => array('load-other-assets','=','1'),
                        'title' => __('Attempt to remove Theme Styles and Scripts', 'premiothemes-comingsoon-minigo'),
                        'subtitle'=> __('<p>If enabled, the plugin will attempt to remove any styling and scripts loaded by the active theme.</p><p>Set this to On to keep your theme from breaking MiniGO.</p><p>There\'s no way to ensure that the cleanup was successful so the theme\'s styles may still be able to break MiniGO\'s layout.', 'premiothemes-comingsoon-minigo'),
                        "default"       => 1,
                        ),
                    array(
                        'id'=>'whitelist-ips',
                        'type'=>'textarea',
                        'title' => __('Whitelist IPs', 'premiothemes-comingsoon-minigo'),
                        'subtitle'=> __('A list of client IPs that will view your theme regardless if MiniGO is disabled or not and the visitor using the IP is logged in or not.', 'premiothemes-comingsoon-minigo'),
                        'desc'=> __('One IP per line.', 'premiothemes-comingsoon-minigo')
                        )

                    )
            );

        global $MiniGOReduxFramework;
        $MiniGOReduxFramework = new ReduxFramework($sections, $args, $tabs);

        // END Sample Config
    }

}