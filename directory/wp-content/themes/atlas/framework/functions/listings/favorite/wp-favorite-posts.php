<?php
/*
Adds Ability To Favorite
*/

define('TDP_FAV_PATH', get_template_directory_uri() . '/framework/functions/listings/favorite');
define('TDP_FAV_META_KEY', "tdp_fav_favorites");
define('TDP_FAV_USER_OPTION_KEY', "tdp_fav_useroptions");
define('TDP_FAV_COOKIE_KEY', "tdp-fav-listings");

$ajax_mode = 1;

function wp_favorite_posts() {
    if (isset($_REQUEST['tdp_favaction'])):
        global $ajax_mode;
        $ajax_mode = $_REQUEST['ajax'];
        if ($_REQUEST['tdp_favaction'] == 'add') {
            tdp_fav_add_favorite();
        } else if ($_REQUEST['tdp_favaction'] == 'remove') {
            tdp_fav_remove_favorite();
        } else if ($_REQUEST['tdp_favaction'] == 'clear') {
            if (tdp_fav_clear_favorites()) tdp_fav_die_or_go(__('All Favorites Removed','framework'));
            else tdp_fav_die_or_go("ERROR");
        }
    endif;
}
add_action('template_redirect', 'wp_favorite_posts');

function tdp_fav_add_favorite($post_id = "") {
    if ( empty($post_id) ) $post_id = $_REQUEST['postid'];
    if (tdp_fav_get_option('opt_only_registered') && !is_user_logged_in() )
        tdp_fav_die_or_go(tdp_fav_get_option('text_only_registered') );

    if (tdp_fav_do_add_to_list($post_id)) {
        // added, now?
        do_action('tdp_fav_after_add', $post_id);
        if (tdp_fav_get_option('statics')) tdp_fav_update_post_meta($post_id, 1);
            $str = tdp_fav_link(1, "remove", 0, array( 'post_id' => $post_id ) );
            tdp_fav_die_or_go($str);
            tdp_fav_die_or_go(tdp_fav_get_option('added'));
    }
}
function tdp_fav_do_add_to_list($post_id) {
    if (tdp_fav_check_favorited($post_id))
        return false;
    if (is_user_logged_in()) {
        return tdp_fav_add_to_usermeta($post_id);
    } else {
        return tdp_fav_set_cookie($post_id, "added");
    }
}

function tdp_fav_remove_favorite($post_id = "") {
    if (empty($post_id)) $post_id = $_REQUEST['postid'];
    if (tdp_fav_do_remove_favorite($post_id)) {
        // removed, now?
        do_action('tdp_fav_after_remove', $post_id);
        if (tdp_fav_get_option('statics')) tdp_fav_update_post_meta($post_id, -1);
            if ($_REQUEST['page']==1):
                $str = '';
            else:
                $str = tdp_fav_link(1, "add", 0, array( 'post_id' => $post_id ) );
            endif;
            tdp_fav_die_or_go($str);
            tdp_fav_die_or_go(tdp_fav_get_option('removed'));
    }
    else return false;
}

function tdp_fav_die_or_go($str) {
    global $ajax_mode;
    if ($ajax_mode):
        die($str);
    else:
        wp_redirect($_SERVER['HTTP_REFERER']);
    endif;
}

function tdp_fav_add_to_usermeta($post_id) {
    $tdp_fav_favorites = tdp_fav_get_user_meta();
    $tdp_fav_favorites[] = $post_id;
    tdp_fav_update_user_meta($tdp_fav_favorites);
    return true;
}

function tdp_fav_check_favorited($cid) {
    if (is_user_logged_in()) {
        $favorite_post_ids = tdp_fav_get_user_meta();
        if ($favorite_post_ids)
            foreach ($favorite_post_ids as $fpost_id)
                if ($fpost_id == $cid) return true;
	} else {
	    if (tdp_fav_get_cookie()):
	        foreach (tdp_fav_get_cookie() as $fpost_id => $val)
	            if ($fpost_id == $cid) return true;
	    endif;
	}
    return false;
}

function tdp_fav_link( $return = 0, $action = "", $show_span = 1, $args = array() ) {
    global $post;
    $post_id = $post->ID;
    extract($args);
    $str = "";
    if ($show_span)
        $str = "<span class='tdp_fav-span'>";
    if ($action == "remove"):
        $str .= tdp_fav_link_html($post_id, __('Remove Favorite','framework'), "remove");
    elseif ($action == "add"):
        $str .= tdp_fav_link_html($post_id, __('Add To Favorites','framework'), "add");
    elseif (tdp_fav_check_favorited($post_id)):
        $str .= tdp_fav_link_html($post_id, __('Remove Favorite','framework'), "remove");
    else:
        $str .= tdp_fav_link_html($post_id, __('Add To Favorites','framework'), "add");
    endif;
    if ($show_span)
        $str .= "</span>";
    if ($return) { return $str; } else { echo $str; }
}

function tdp_fav_link_html($post_id, $opt, $action) {
    $link = "<a class='button small black tdp_fav-link' href='?tdp_favaction=".$action."&amp;postid=". $post_id . "' title='". $opt ."' rel='nofollow'><i class='icon-star'></i> ". $opt ."</a>";
    $link = apply_filters( 'tdp_fav_link_html', $link );
    return $link;
}

function tdp_fav_get_users_favorites($user = "") {
    $favorite_post_ids = array();

    if (!empty($user)):
        return tdp_fav_get_user_meta($user);
    endif;

    # collect favorites from cookie and if user is logged in from database.
    if (is_user_logged_in()):
        $favorite_post_ids = tdp_fav_get_user_meta();
	else:
	    if (tdp_fav_get_cookie()):
	        foreach (tdp_fav_get_cookie() as $post_id => $post_title) {
	            array_push($favorite_post_ids, $post_id);
	        }
	    endif;
	endif;
    return $favorite_post_ids;
}

function tdp_fav_list_favorite_posts( $args = array() ) {
    $user = $_REQUEST['user'];
    extract($args);
    global $favorite_post_ids;
    if (!empty($user)):
        if (!tdp_fav_is_user_favlist_public($user)):
            $favorite_post_ids = tdp_fav_get_users_favorites($user);
        endif;
    else:
        $favorite_post_ids = tdp_fav_get_users_favorites();
    endif;

	if ( @file_exists(TEMPLATEPATH.'/tdp_fav-page-template.php') || @file_exists(STYLESHEETPATH.'/tdp_fav-page-template.php') ):
        if(@file_exists(TEMPLATEPATH.'/tdp_fav-page-template.php')) :
            include(TEMPLATEPATH.'/tdp_fav-page-template.php');
        else :
            include(STYLESHEETPATH.'/tdp_fav-page-template.php');
        endif;
    else:
        include("tdp_fav-page-template.php");
    endif;
}

function tdp_fav_list_most_favorited($limit=5) {
    global $wpdb;
    $query = "SELECT post_id, meta_value, post_status FROM $wpdb->postmeta";
    $query .= " LEFT JOIN $wpdb->posts ON post_id=$wpdb->posts.ID";
    $query .= " WHERE post_status='publish' AND meta_key='".TDP_FAV_META_KEY."' AND meta_value > 0 ORDER BY ROUND(meta_value) DESC LIMIT 0, $limit";
    $results = $wpdb->get_results($query);
    if ($results) {
        echo "<ul>";
        foreach ($results as $o):
            $p = get_post($o->post_id);
            echo "<li>";
            echo "<a href='".get_permalink($o->post_id)."' title='". $p->post_title ."'>" . $p->post_title . "</a> ($o->meta_value)";
            echo "</li>";
        endforeach;
        echo "</ul>";
    }
}

function tdp_fav_loading_img() {
    return "<img src='".TDP_FAV_PATH."/img/loading.gif' alt='Loading' title='Loading' class='tdp_fav-hide tdp_fav-img' />";
}

function tdp_fav_before_link_img() {
    $options = tdp_fav_get_options();
    $option = $options['before_image'];
    if ($option == '') {
        return "";
    } else if ($option == 'custom') {
        return "<img src='" . $options['custom_before_image'] . "' alt='Favorite' title='Favorite' class='tdp_fav-img' />";
    } else {
        return "<img src='". TDP_FAV_PATH . "/img/" . $option . "' alt='Favorite' title='Favorite' class='tdp_fav-img' />";
    }
}

function tdp_fav_clear_favorites() {
    if (tdp_fav_get_cookie()):
        foreach (tdp_fav_get_cookie() as $post_id => $val) {
            tdp_fav_set_cookie($post_id, "");
            tdp_fav_update_post_meta($post_id, -1);
        }
    endif;
    if (is_user_logged_in()) {
        $favorite_post_ids = tdp_fav_get_user_meta();
        if ($favorite_post_ids):
            foreach ($favorite_post_ids as $post_id) {
                tdp_fav_update_post_meta($post_id, -1);
            }
        endif;
        if (!delete_user_meta(tdp_fav_get_user_id(), TDP_FAV_META_KEY)) {
            return false;
        }
    }
    return true;
}
function tdp_fav_do_remove_favorite($post_id) {
    if (!tdp_fav_check_favorited($post_id))
        return true;

    $a = true;
    if (is_user_logged_in()) {
        $user_favorites = tdp_fav_get_user_meta();
        $user_favorites = array_diff($user_favorites, array($post_id));
        $user_favorites = array_values($user_favorites);
        $a = tdp_fav_update_user_meta($user_favorites);
    }
    if ($a) $a = tdp_fav_set_cookie($_REQUEST['postid'], "");
    return $a;
}

function tdp_fav_add_js_script() {
	if (!tdp_fav_get_option('dont_load_js_file'))
		wp_enqueue_script( "wp-favroite-posts", TDP_FAV_PATH . "/tdp_fav.js", array( 'jquery' ), false, true );
}
add_action('wp_print_scripts', 'tdp_fav_add_js_script');

function tdp_fav_wp_print_styles() {
	if (!tdp_fav_get_option('dont_load_css_file'))
		echo "<link rel='stylesheet' id='tdp_fav-css' href='" . TDP_FAV_PATH . "/tdp_fav.css' type='text/css' />" . "\n";
}
//add_action('wp_print_styles', 'tdp_fav_wp_print_styles');

function tdp_fav_update_user_meta($arr) {
    return update_usermeta(tdp_fav_get_user_id(),TDP_FAV_META_KEY,$arr);
}

function tdp_fav_update_post_meta($post_id, $val) {
	$oldval = tdp_fav_get_post_meta($post_id);
	if ($val == -1 && $oldval == 0) {
    	$val = 0;
	} else {
		$val = $oldval + $val;
	}
    return add_post_meta($post_id, TDP_FAV_META_KEY, $val, true) or update_post_meta($post_id, TDP_FAV_META_KEY, $val);
}

function tdp_fav_delete_post_meta($post_id) {
    return delete_post_meta($post_id, TDP_FAV_META_KEY);
}

function tdp_fav_get_cookie() {
    return $_COOKIE[TDP_FAV_COOKIE_KEY];
}

function tdp_fav_get_options() {
   return get_option('tdp_fav_options');
}

function tdp_fav_get_user_id() {
    global $current_user;
    get_currentuserinfo();
    return $current_user->ID;
}

function tdp_fav_get_user_meta($user = "") {
    if (!empty($user)):
        $userdata = get_userdatabylogin($user);
        $user_id = $userdata->ID;
        return get_usermeta($user_id, TDP_FAV_META_KEY);
    else:
        return get_usermeta(tdp_fav_get_user_id(), TDP_FAV_META_KEY);
    endif;
}

function tdp_fav_get_post_meta($post_id) {
    $val = get_post_meta($post_id, TDP_FAV_META_KEY, true);
    if ($val < 0) $val = 0;
    return $val;
}

function tdp_fav_set_cookie($post_id, $str) {
    $expire = time()+60*60*24*30;
    return setcookie("tdp-fav-listings[$post_id]", $str, $expire, "/");
}

function tdp_fav_is_user_favlist_public($user) {
    $user_opts = tdp_fav_get_user_options($user);
    if ($user_opts['list_is_public'])
        return true;
    else
        return false;
}

function tdp_fav_get_user_options($user) {
    $userdata = get_userdatabylogin($user);
    $user_id = $userdata->ID;
    return get_usermeta($user_id, TDP_FAV_USER_OPTION_KEY);
}
function tdp_fav_is_user_can_edit() {
    if ($_REQUEST['user'])
        return false;
    return true;
}
function tdp_fav_remove_favorite_link($post_id) {
    if (tdp_fav_is_user_can_edit()) {
        $tdp_fav_options = tdp_fav_get_options();
        $class = 'tdp_fav-link remove-parent';
        $link = "<a id='rem_$post_id' class='$class' href='?tdp_favaction=remove&amp;page=1&amp;postid=". $post_id ."' title='".tdp_fav_get_option('rem')."' rel='nofollow'>".__('Remove From Favorites','atlas')."</a>";
        $link = apply_filters( 'tdp_fav_remove_favorite_link', $link );
        echo $link;
    }
}
function tdp_fav_clear_list_link() {
    if (tdp_fav_is_user_can_edit()) {
        $tdp_fav_options = tdp_fav_get_options();
        echo "<a class='btn small  pull-right tdp_fav-link' href='?tdp_favaction=clear' rel='nofollow'>". __('Remove All Favorites','framework') . "</a>";
    }
}
function tdp_fav_cookie_warning() {
    if (!is_user_logged_in() && !isset($_GET['user']) ):
        echo "<p>".tdp_fav_get_option('cookie_warning')."</p>";
    endif;
}

function tdp_fav_get_option($opt) {
    $tdp_fav_options = tdp_fav_get_options();
    return htmlspecialchars_decode( stripslashes ( $tdp_fav_options[$opt] ) );
}