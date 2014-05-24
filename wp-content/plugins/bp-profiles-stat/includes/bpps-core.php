<?php

if(!defined('BPPS_URL'))
    define('BPPS_URL', plugins_url('', __FILE__) );

/**
 * Main ajax function that handles everything dynamic
 */
add_action('wp_ajax_bpps_ajax', 'bpps_ajax');
function bpps_ajax(){
    global $bp, $wpdb;
    $data        = $_REQUEST;
    $users_data  = $fields_data = array();
    $date_arr    = false;
    $return      = new Stdclass;
    $users_count = 0;

    $method = (empty($data['method']) || !isset($data['method']))?'get_data':$data['method'];

    switch($method){
        case 'get_field_data':
            if (is_numeric($data['field_id'])){
                $field_id = $data['field_id'];
            }else{
                break;
            }

            // field_id | field_type | field_name
            $return->field_data = $wpdb->get_row($wpdb->prepare(
                                            "SELECT `id` AS `field_id`, `type` AS `field_type`, `name` AS `field_name`
                                            FROM `{$bp->profile->table_name_fields}`
                                            WHERE `id` = %d", $field_id));

            $return->users_data = $wpdb->get_results($wpdb->prepare(
                                            "SELECT DISTINCT pd.`value` AS `label`,
                                                (SELECT COUNT(`user_id`) FROM `{$bp->profile->table_name_data}`
                                                        WHERE `value` = pd.`value`) as `data`
                                            FROM `{$bp->profile->table_name_data}` AS pd
                                            LEFT JOIN `{$wpdb->users}` AS u ON u.`ID` = pd.`user_id`
                                            WHERE pd.`field_id` = %d", $field_id));

            // count users for each value
            foreach($return->users_data as &$field){
                $users_count += $field->data;

                switch ($return->field_data->field_type){
                    case 'datebox':
                        $date_format = get_option('date_format');
                        if(empty($date_format))
                            $date_format = 'M d, Y';
                        $field->label = date($date_format, strtotime($field->label));
                        break;

                    case 'multiselectbox':
                    case 'checkbox':
                        $field->label = implode(', ', maybe_unserialize($field->label));
                        break;
                }

                $field->data = (int)$field->data;
                $field->label .= ' ('. $field->data .')';
            }
            $return->label = __('Below is the generated pie. Numbers in brackets are the actual numbers of users with this field value in their profile.', 'bpps');
            break;

        case 'get_other_data':
            $type = $data['type'];

            if ($type == 'date_reg'){
                //$users_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT('ID') FROM {$wpdb->prefix}users"));
                $counter = array();

                $reg_range = bpps_sql_date_range($data['date'], 'user_registered');

                $response = $wpdb->get_results($wpdb->prepare(
                                        "SELECT `ID`, `user_registered` AS reg_date
                                        FROM `{$wpdb->prefix}users`
                                        WHERE 1=1 {$reg_range}
                                        ORDER BY `ID` ASC", false));

                // key = hours, values = reged users in that hour
                for($i = 0; $i < 24; $i++){
                    $counter[$i] = 0;
                }

                foreach((array)$response as $user){
                    $reg               = new Stdclass;
                    $reg->full         = explode(' ', $user->reg_date);
                    $reg->date         = $reg_date->full[0];
                    // remove seconds and create array(0=>'hh',1=>'mm')
                    $reg->time->raw    = explode(':', substr($reg->full[1], 0, -2));
                    $reg->time->raw[1] = round($reg->time->raw[1] / 60, 2); // i.e.: 0.25
                    // forming data used for graph
                    $user->time        = (float)($reg->time->raw[0] + $reg->time->raw[1]); // i.e.: 17 + 0.8 = 17.8
                    // count that user in appropriate group
                    $counter[floor($user->time)]++;
                }

                $return->label = __('Number of users (ver) registered at some time (hor)', 'bpps');
                //$return->users_data  = $response;
                foreach($counter as $k => $v)
                    $return->fields_data[] = array($k, $v);
            }

            if ($type == 'date_active' || $type == 'activity_action'){
                $return = bpps_get_activity_data($data);
            }

            break;

        case 'get_users':
            $ids = array();
            $error = false;
            $data['page'] = isset($data['page']) && is_numeric($data['page'])?$data['page']:1;

            // get users IDs according to the type
            switch($data['type']){
                case 'empty_profiles':
                    $ids = $wpdb->get_col($wpdb->prepare("SELECT `ID` FROM {$wpdb->users}
                                                        WHERE
                                                            `ID` NOT IN (
                                                                SELECT DISTINCT `user_id`
                                                                FROM {$bp->profile->table_name_data}
                                                                WHERE `field_id` > 1)", false));
                    break;
                case 'not_activated':
                    if(is_multisite()){

                    }else{
                        $ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->users} WHERE `user_status` = 2", false));
                    }
                    break;

                case 'not_active':
                    $ids = $wpdb->get_col($wpdb->prepare("SELECT u.`ID` FROM {$wpdb->users} AS u
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
                    break;

                case 'spam':
                    $ids = $wpdb->get_col($wpdb->prepare("SELECT `ID` FROM `{$wpdb->users}` WHERE `spam` = 1", false));
                    break;

                case 'deleted':
                    $ids = $wpdb->get_col($wpdb->prepare("SELECT `ID` FROM `{$wpdb->users}` WHERE `deleted` = 1", false));
                    break;
            }

            // display the list
            bpps_display_users($ids, $data['type'], $data['page'], $error);

            die;
            break;

        default:

    }

    echo json_encode($return);
    die;
}

function bpps_display_users($ids, $type, $page, $error = false){
    if($error)
        die($error);

    if(!is_array($ids))
        $ids = (array) $ids;

    if ( bp_has_members(array(
                            'include'         => $ids,
                            'type'            => 'alphabetical',
                            'per_page'        => 10,
                            'page'            => $page,
                            'populate_extras' => false
                        ))
        ) : ?>
        <div id="pag-top" class="pagination">
            <div class="pagination-links" id="member-dir-pag-top" data-type="<?php echo $type; ?>">
                <?php bp_members_pagination_links(); ?>
            </div>
        </div>

        <ul id="users-list">
            <?php while ( bp_members() ) : bp_the_member(); ?>
            <li>
                <a href="<?php bp_member_permalink(); ?>" target="_blank" title="<?php _e('Go to BuddyPress Profile Page', 'bpps'); ?>"><?php bp_member_name(); ?></a>
                (ID:<?php bp_member_user_id(); ?>)
                <span class="action">
                    <?php if(is_multisite()){
                        $wp_edit_link = esc_url( network_admin_url( add_query_arg( 'wp_http_referer', urlencode( stripslashes( $_SERVER['REQUEST_URI'] ) ), 'user-edit.php?user_id=' . bp_get_member_user_id() ) ) );
                    }else{
                        $wp_edit_link = esc_url( admin_url( add_query_arg( 'wp_http_referer', urlencode( stripslashes( $_SERVER['REQUEST_URI'] ) ), 'user-edit.php?user_id=' . bp_get_member_user_id() ) ) );
                    }
                    $bp_edit_link = bp_get_member_permalink() . 'profile/edit/';
                    ?>
                    <a href="<?php echo $wp_edit_link; ?>" class="button" target="_blank"><?php _e('WP Edit', 'bpps'); ?></a>
                    <a href="<?php echo $bp_edit_link; ?>" class="button" target="_blank"><?php _e('BP Edit', 'bpps'); ?></a>
                </span>
            </li>
            <?php endwhile; ?>
        </ul>

    <p class="description"><?php _e('Unfortunately, BuddyPress doesn\'t allow to display spammy/deleted users.', 'bpps'); ?></p>

    <?php else: ?>
        <div id="message" class="info">
            <p><?php _e( "Sorry, no members were found.", 'bpps' ); ?></p>
        </div>
    <?php endif;
}

function bpps_sql_date_range($date, $field){
    $str = false;
    $date_arr = ($date!='false')?explode('-', $date):false;

    if($date_arr && count($date_arr) == 2){
        $from = date('Y-m-d H:i:s', strtotime($date_arr[0]));
        $to   = date('Y-m-d H:i:s', strtotime($date_arr[1]));
        $str  = "AND `{$field}` > '{$from}' AND `{$field}` < '{$to}'";
    }

    return $str;
}

function bpps_get_activity_data($data){
    global $wpdb, $bp;
    $users_data = $fields_data = array();
    $return     = new Stdclass;
    $counter    = array();
    $and_type   = '';

    $rec_range = bpps_sql_date_range($data['date'], 'date_recorded');

    if($data['type'] == 'activity_action')
        $and_type = "AND `type` = '{$data['activity']}'";

    $response = $wpdb->get_results($wpdb->prepare(
                            "SELECT `date_recorded` AS active_date
                            FROM  `{$bp->activity->table_name}`
                            WHERE 1=1
                            {$rec_range}
                            {$and_type}
                            ORDER BY `id` ASC", false));

    // key = hours, values = active users in that hour
    for($i = 0; $i < 24; $i++){
        $counter[$i] = 0;
    }

    foreach((array)$response as $activity){
        $act               = new Stdclass;
        $act->full         = explode(' ', $activity->active_date);
        $act->date         = $act->full[0];
        // remove seconds and create array(0=>'hh',1=>'mm')
        $act->time->raw    = explode(':', substr($act->full[1], 0, -2));
        // convert minutes to a portion
        $act->time->raw[1] = round($act->time->raw[1] / 60, 2); // i.e.: 0.25
        // forming data used for graph
        $activity->time    = (float)($act->time->raw[0] + $act->time->raw[1]); // i.e.: 17 + 0.8 = 17.8
        // count that user in appropriate group
        $counter[floor($activity->time)]++;
    }

    $return->label = __('Number of users (ver) active at some time (hor)', 'bpps');

    foreach($counter as $k => $v)
        $return->fields_data[] = array($k, $v);

    return $return;
}

function bpps_get_disabled_fields_types(){
    return array('textarea');
}

function bpps_get_all_activity_actions(){
    global $wpdb, $bp;

    $result = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT `type` FROM `{$bp->activity->table_name}` ORDER BY `type` ASC", false));

    foreach((array)$result as $action){
        $actions[$action] = ucwords(str_replace('_', ' ', $action));
    }

    return $actions;
}

function bpps_display_groups_n_fields(){
    $disabled_fields_types = bpps_get_disabled_fields_types();

    if ( bp_has_profile() ) {
        echo '<ul class="groups">';
        while ( bp_profile_groups() ) {
            bp_the_profile_group();
            echo '<li>';
                echo '<span>';
                    bp_the_profile_group_name();
                echo ':</span>';
                echo '<ul class="fields">';
                while ( bp_profile_fields() ) {
                    bp_the_profile_field();
                    echo '<li>';
                        echo '<label>';
                            $field_type = bp_get_the_profile_field_type();
                            echo '<input type="radio" '.(in_array($field_type, $disabled_fields_types)?'disabled="disabled"':'').' name="use_field" class="use_field" value="'.bp_get_the_profile_field_id().'" /> ';
                            bp_the_profile_field_name();
                            echo '<span class="desc"> &rarr; ' . bp_get_the_profile_field_type() . '</span>';
                        echo '</label>';
                    echo '</li>';
                } // bp_profile_fields
                echo '</ul><!--/.fields-->';
            echo '</li>';
        } // bp_profile_groups
        echo '</ul><!--/.groups-->';
    } // bp_has_profile
}

// for debug
if(!function_exists('print_var')) {
    function print_var($var, $die = false){
        echo '<pre>';
        if ( !empty($var))
            print_r($var);
        else
            var_dump($var);
        echo '</pre>';
        if ($die)
            die;
    }
}

?>