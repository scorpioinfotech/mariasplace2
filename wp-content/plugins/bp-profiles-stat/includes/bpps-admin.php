<?php
/**
 * The main admin class, holds everything BPPS theme can customize,
 * Initialized right after declaration
 */
class BPPS_Admin_Tabs {

    // Declare Tabs
    private $dash_settings_key      = 'bpps_admin_dashboard';
    private $profiles_settings_key  = 'bpps_admin_profiles';
    private $activity_settings_key  = 'bpps_admin_activity_time';
    private $settings_settings_key  = 'bpps_admin_settings';
    private $info_settings_key      = 'bpps_admin_info';

    private $bpps_options_key       = 'bpps_admin';
    private $bpps_settings_tabs     = array();

    /**
     * Register stat page & tabs
     */
    function __construct() {
        add_action( 'admin_init', array( &$this, 'register_dash_settings' ) );
        add_action( 'admin_init', array( &$this, 'register_profiles_settings' ) );
        add_action( 'admin_init', array( &$this, 'register_activity_settings' ) );
        //add_action( 'admin_init', array( &$this, 'register_settings_settings' ) );
        add_action( 'admin_init', array( &$this, 'register_info_settings' ) );

        if(is_multisite()){
            add_action( 'network_admin_menu', array( &$this, 'add_admin_menu' ) );
        }else{
            add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );
        }

        add_action('bpps_admin_footer', array(&$this, 'bpps_footer'), 99);
    }

    /**
     * Registers Dashboard page via the Settings API,
     * appends the setting to the tabs array of the object.
     */
    function register_dash_settings() {
        $this->bpps_settings_tabs[$this->dash_settings_key] = '<span class="icons icon-dash"></span>'.__('Dashboard', 'bpps');

        register_setting( $this->dash_settings_key, $this->dash_settings_key );
        add_settings_section( 'dashboard_widgets', '', array( &$this, 'dash_out' ), $this->dash_settings_key );

        add_action('bpps_admin_dash_left', array(&$this, 'dash_users_count'));
        add_action('bpps_admin_dash_right', array(&$this, 'dash_users_generic'));
    }

    function dash_out(){ ?>
        <div id="poststuff">
            <div class="dash_top">
                <?php do_action('bpps_admin_dash_top'); ?>
            </div>
            <div class="dash_center clearfix">
                <div class="dash_left">
                    <?php do_action('bpps_admin_dash_left'); ?>
                </div>
                <div class="dash_right">
                    <?php do_action('bpps_admin_dash_right'); ?>
                </div>
            </div>
            <div class="dash_bottom">
                <?php do_action('bpps_admin_dash_bottom'); ?>
            </div>
        </div>
        <?php
    }

    function dash_users_generic(){ ?>
        <div class="postbox users_count">
            <h3><?php _e('Generic content', 'bpps'); ?></h3>
            <div class="inside clearfix generic">
                <p class="nothing"><?php _e('Nothing to display yet. Please use "more" link from the box to the left.', 'bpps'); ?></p>
            </div>
        </div>
        <?php
    }

    function dash_users_count(){
        global $wpdb, $bp;
        $users = array();
        // problematic
        $users['bad']['empty_profiles']['label']  = __('<abbr title="That means the only system required field called *Base* has some content (generated by BuddyPress, not a user)">Empty</abbr> Profiles', 'bpps');
        $users['bad']['empty_profiles']['number'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(`ID`) FROM {$wpdb->users}
                                                        WHERE
                                                            `ID` NOT IN (
                                                                SELECT DISTINCT `user_id`
                                                                FROM {$bp->profile->table_name_data}
                                                                WHERE `field_id` > 1)", array()));

        $users['bad']['not_activated']['label']  = __('Not Activated', 'bpps');
        if(is_multisite()){
            $users['bad']['not_activated']['number'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}signups
                                                            WHERE `active` = 0 AND `activation_key` != ''", false));
        }else{
            $users['bad']['not_activated']['number'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->users}
                                                            WHERE `user_status` = 2", false));
        }

        $users['bad']['not_active']['label']  = __('No Activity <abbr title="Such users created absolutely no content anywhere on your site">at all</abbr>', 'bpps');
        $users['bad']['not_active']['number'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(u.`ID`) FROM {$wpdb->users} AS u
                                        LEFT JOIN {$wpdb->posts} AS p ON p.`post_author` = u.`ID`
                                        LEFT JOIN {$wpdb->comments} AS c ON c.`user_id` = u.`ID`
                                        LEFT JOIN {$bp->messages->table_name_messages} AS m ON m.`sender_id` = u.`ID`
                                        LEFT JOIN {$bp->groups->table_name} AS g ON g.`creator_id` = u.`ID`
                                        LEFT JOIN {$bp->groups->table_name_members} AS gm ON gm.`user_id` = u.`ID`
                                        LEFT JOIN {$bp->friends->table_name} AS f ON f.`initiator_user_id` = u.`ID`
                                        LEFT JOIN {$bp->activity->table_name} AS a ON a.`user_id` = u.`ID`
                                        WHERE
                                            p.`post_author` IS NULL AND
                                            c.`user_id` IS NULL AND
                                            m.`sender_id` IS NULL AND
                                            g.`creator_id` IS NULL AND
                                            gm.`user_id` IS NULL AND
                                            f.`initiator_user_id` IS NULL AND
                                            a.`user_id` IS NULL", false));
        $users['bad']['spam']['label']  = __('Spammy', 'bpps');
        $users['bad']['spam']['number'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->users} WHERE `spam` = 1", false));

        $users['bad']['deleted']['label']  = __('Deleted', 'bpps');
        $users['bad']['deleted']['number'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->users} WHERE `deleted` = 1", false));
        // good
        $users['good']['registered']['label']  = __('Good &amp; Registered', 'bpps');
        $users['good']['registered']['number'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->users}
                                        WHERE `spam` = 0 AND `deleted` = 0 AND `user_status` = 0", false));

        $users = apply_filters('bpps_dash_users_count', $users);
        ?>
        <div class="postbox users_count">
            <h3><?php _e('Users Counts', 'bpps'); ?></h3>
            <div class="inside clearfix">
                <div class="users_bad">
                    <h4><?php _e('"Red-labeled" info', 'bpps'); ?></h4>
                    <ul>
                        <?php foreach($users['bad'] as $type => $value) {
                            $display = ($value['number']!=0)?'':'hide';
                            ?>
                            <li class="<?php echo $display; ?>">
                                <span><?php echo $value['number'];?></span> <?php echo $value['label']; ?>
                                <?php if($type == "empty_profiles" || $type == "not_active" || $type == "not_activated") { ?>
                                    <?php if($type == "not_activated" && is_multisite()) {}else{ ?>
                                        <a href="#" class="more" data-type="<?php echo $type; ?>">more &raquo</a>
                                    <?php } ?>
                                <?php } ?>
                            </li>
                        <?php } ?>

                        <?php do_action('bpps_dash_users_count_list_red', $users); ?>
                    </ul>
                </div>
                <div class="users_good">
                    <h4><?php _e('"Green-labeled" info', 'bpps'); ?></h4>
                    <ul>
                        <?php foreach($users['good'] as $type => $value) {
                            $display = ($value['number']!=0)?'':'hide';
                            ?>
                            <li class="<?php echo $display; ?>">
                                <span><?php echo $value['number'];?></span> <?php echo $value['label']; ?>
                            </li>
                        <?php } ?>
                        <?php do_action('bpps_dash_users_count_list_green', $users); ?>
                    </ul>
                </div>
                <p class="extra_option">
                    <label>
                        <input type="checkbox" name="display_hidden_users_count"/> <?php _e('Do you want to display hidden (empty) values?', 'bpps'); ?>
                    </label>
                </p>
            </div><!--/.inside-->
        </div><!--/.postbox-->
        <?php
    }

    /**
     * Registers Profiles page and appends the key to the theme settings tabs array.
     */
    function register_profiles_settings() {
        $this->bpps_settings_tabs[$this->profiles_settings_key] = '<span class="icons icon-profiles"></span>'.__('Profiles', 'bpps');

        register_setting( $this->profiles_settings_key, $this->profiles_settings_key );
        add_settings_section(
            'profiles_data', // section id
            '', // title
            array( &$this, 'profiles_out' ), // method handler
            $this->profiles_settings_key // slug
        );
    }

    function profiles_out(){ ?>
        <div id="poststuff">
            <div class="first_half">
                <div class="postbox">
                    <h3><?php _e('Profile Fields and Groups', 'bpps'); ?></h3>
                    <div class="inside">
                        <?php bpps_display_groups_n_fields(); ?>
                    </div><!--/.inside-->
                </div><!--/.postbox-->
            </div><!--/.first_half-->
            <?php $this->right_sidebar();?>
        </div>
        <?php
    }

    /**
     * Registers Active time page and appends the key to the theme settings tabs array.
     */
    function register_activity_settings(){
        $this->bpps_settings_tabs[$this->activity_settings_key] = '<span class="icons icon-time"></span>'.__('Activity Time', 'bpps');

        register_setting( $this->activity_settings_key, $this->activity_settings_key );
        add_settings_section(
            'activity_time', // section id
            '', // title
            array( &$this, 'activity_out' ), // method handler
            $this->activity_settings_key // slug
        );
    }

    function activity_out(){ ?>
        <div id="poststuff">
            <div class="first_half">
                <div class="postbox">
                    <h3><?php _e('Options to Choose From', 'bpps'); ?></h3>
                    <div class="inside">
                        <p class="datepicker">
                            <?php _e('By default all the data is taken into account on graphs.', 'bpps'); ?><br />
                            <?php _e('In case it takes <abbr title="This means too many data is processed at a time">an infinity to load</abbr> use date filter below.', 'bpps'); ?><br /><br />
                            <input type="checkbox" id="date_range" name="date_range" />
                            <input type="text" name="date_from" value="<?php echo date('d.m.Y', time() - 2592000)?>" />
                            <input type="text" name="date_to" value="<?php echo date('d.m.Y'); ?>" />
                            <a id="apply_date" class="button" href="#"><?php _e('Apply', 'bpps'); ?></a>
                        </p>

                        <ul class="other">
                            <li>
                                <label>
                                    <input type="radio" name="other_data" class="other_data" value="date_reg" />&nbsp;
                                    <?php _e('Hours your users are registering the most','bpps'); ?>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="other_data" class="other_data" value="date_active" />&nbsp;
                                    <?php _e('Hours your users are active the most (in general)','bpps'); ?>
                                </label>
                                <?php
                                $actions = bpps_get_all_activity_actions();
                                if(!empty($actions)){ ?>
                                    <ul class="actions_by"><li><a href="#" class="by_type button"><?php _e('Show By Type', 'bpps'); ?></a></li></ul>
                                    <ul class="actions">
                                        <?php foreach($actions as $action => $name){ ?>
                                            <li>
                                                <label>
                                                    <input type="radio" name="activity_action" class="other_data" value="<?php echo $action; ?>" />&nbsp;<?php echo $name; ?>
                                                </label>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        </ul>
                    </div><!--/.inside-->
                </div><!--/.postbox-->
            </div><!--/.first_half-->
            <?php $this->right_sidebar(); ?>
        </div>
        <?php
    }

    function register_settings_settings(){
        $this->bpps_settings_tabs[$this->settings_settings_key] = '<span class="icons icon-settings"></span>'.__('Settings', 'bpps');

        register_setting( $this->settings_settings_key, $this->settings_settings_key );
        add_settings_section(
            'settings', // section id
            '', // title
            array( &$this, 'settings_out' ), // method handler
            $this->settings_settings_key // slug
        );
    }

    function settings_out(){
        _e('<p>This page is under development.</p>', 'bbps');
    }

    /**
     * Registers the Info page with some docs and FAQs
     */
    function register_info_settings(){
        $this->bpps_settings_tabs[$this->info_settings_key] = '<span class="icons icon-author"></span>'.__('About Author', 'bpps');

        register_setting( $this->info_settings_key, $this->info_settings_key );
        add_settings_section(
            'info', // section id
            '', // title
            array( &$this, 'info_out' ), // method handler
            $this->info_settings_key // slug
        );
    }

    function info_out(){
        include(dirname(__File__).'/bpps-about.html');
    }

    function right_sidebar(){ ?>
        <div class="second_half">
            <div class="postbox" id="sticky">
                <h3 style="cursor:default"><?php _e('Statistics', 'bpps'); ?></h3>
                <div class="inside">
                    <p class="label"></p>
                    <div id="graph"></div>
                </div><!--/.inside-->
            </div><!--/.postbox-->
        </div><!--/.second_half-->
        <?php
    }

    /**
     * Adds a page with all subpages (tabs)
     */
    function add_admin_menu() {
        $page = add_submenu_page(
                'users.php',
                __('BP Profiles Statistics', 'bpps'),
                __('BP Profiles Statistics', 'bpps'),
                'edit_users',
                $this->bpps_options_key,
                array( &$this, 'bpps_page' )
            );

        bpps_load_assets($page);
    }

    /**
     * BPPS page rendering goes here, checks for active tab.
     */
    function bpps_page() {
        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->dash_settings_key; ?>
        <div id="bpps-admin" class="wrap">
            <?php $this->bpps_header(); ?>
            <form method="post" action="">
                <?php
                wp_nonce_field( 'bpps-update-options' );
                //settings_fields( $tab );
                do_settings_sections( $tab );
                //submit_button();
                ?>
            </form>
            <div class="clearfix"></div>
            <?php $this->bpps_footer(); ?>
        </div>
        <?php
    }

    /**
     * Renders header titles and tabs on the BPPS page.
     */
    function bpps_header() {
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : $this->dash_settings_key;

        screen_icon('users');
        echo '<h2>';
            echo '<span class="divider">';
                _e('BP Profiles Statistics','bpps'); echo ' <em><sup><a href="http://codecanyon.net/item/buddypress-profiles-statistics/2215514" target="_blank">v'. BPPS_VERSION .'</a></sup></em>';
            echo '</span>';
            echo '<em>'. __('Better Understand Your Members','bpps') .'</em>';
        echo '</h2>';

        echo '<h3 class="nav-tab-wrapper">';
        foreach ( $this->bpps_settings_tabs as $tab_key => $tab_caption ) {
            $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
            echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->bpps_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
        }
        echo '</h2>';
    }

    function bpps_footer(){ ?>
        <div id="bottom">
            <a href="http://codecanyon.net/user/slaFFik#from" target="_blank" id="request_feature"><?php _e('New Feature Request', 'bpps'); ?></a>
            <?php /*| <a href="http://ovirium.com/plugins/bpps/docs/" target="_blank"><?php _e('Documentation', 'bpps'); ?></a>*/ ?>
            | <a href="http://twitter.com/slaFFik" target="_blank" title="Twitter">@slaFFik</a>
        </div>
        <?php
    }

};

// Initialize BPPS Options
$bpps_admin = new BPPS_Admin_Tabs;

class BPPS_Dash_Widget {

}

?>