<?php
function tdp_fav_widget_init() {
    function tdp_fav_widget_view($args) {
        extract($args);
        $options = tdp_fav_get_options();
        if (isset($options['widget_limit'])) {
            $limit = $options['widget_limit'];
        }
        $title = empty($options['widget_title']) ? 'Most Favorited Posts' : $options['widget_title'];
        echo $before_widget;
        echo $before_title
             . $title
             . $after_title;
        tdp_fav_list_most_favorited($limit);
        echo $after_widget;
    }
    function tdp_fav_widget_control() {
        $options = tdp_fav_get_options();
        if (isset($_POST["tdp_fav-widget-submit"])):
            $options['widget_title'] = strip_tags(stripslashes($_POST['tdp_fav-title']));
            $options['widget_limit'] = strip_tags(stripslashes($_POST['tdp_fav-limit']));
            update_option("tdp_fav_options", $options);
        endif;
        $title = $options['widget_title'];
        $limit = $options['widget_limit'];
    ?>
        <p>
            <label for="tdp_fav-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $title; ?>" class="widefat" id="tdp_fav-title" name="tdp_fav-title" />
            </label>
        </p>
        <p>
            <label for="tdp_fav-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $limit; ?>" style="width: 28px; text-align:center;" id="tdp_fav-limit" name="tdp_fav-limit" />
            </label>
        </p>
        <?php if (!$options['statics']) { ?>
        <p>
            You must enable statics from favorite posts <a href="plugins.php?page=tdp-fav-listings" title="Favorite Posts Configuration">configuration page</a>.
        </p>
        <?php } ?>
        <input type="hidden" name="tdp_fav-widget-submit" value="1" />
    <?php
    }
    register_sidebar_widget('Most Favorited Posts', 'tdp_fav_widget_view');
    register_widget_control('Most Favorited Posts', 'tdp_fav_widget_control' );

    //*** users favorites widget ***//
    function tdp_fav_users_favorites_widget_view($args) {
        extract($args);
        $options = tdp_fav_get_options();
        if (isset($options['uf_widget_limit'])) {
            $limit = $options['uf_widget_limit'];
        }
        $title = empty($options['uf_widget_title']) ? 'Users Favorites' : $options['uf_widget_title'];
        echo $before_widget;
        echo $before_title
             . $title
             . $after_title;
        $favorite_post_ids = tdp_fav_get_users_favorites();

		$limit = $options['uf_widget_limit'];
        if (@file_exists(TEMPLATEPATH.'/tdp_fav-your-favs-widget.php')):
            include(TEMPLATEPATH.'/tdp_fav-your-favs-widget.php');
        else:
            include("tdp_fav-your-favs-widget.php");
        endif;
        echo $after_widget;
    }
    function tdp_fav_users_favorites_widget_control() {
        $options = tdp_fav_get_options();
        if (isset($_POST["tdp_fav-uf-widget-submit"])):
            $options['uf_widget_title'] = strip_tags(stripslashes($_POST['tdp_fav-uf-title']));
            $options['uf_widget_limit'] = strip_tags(stripslashes($_POST['tdp_fav-uf-limit']));
            update_option("tdp_fav_options", $options);
        endif;
        $uf_title = $options['uf_widget_title'];
        $uf_limit = $options['uf_widget_limit'];
    ?>
        <p>
            <label for="tdp_fav-uf-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $uf_title; ?>" class="widefat" id="tdp_fav-uf-title" name="tdp_fav-uf-title" />
            </label>
        </p>
        <p>
            <label for="tdp_fav-uf-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $uf_limit; ?>" style="width: 28px; text-align:center;" id="tdp_fav-uf-limit" name="tdp_fav-uf-limit" />
            </label>
        </p>

        <input type="hidden" name="tdp_fav-uf-widget-submit" value="1" />
    <?php
    }
    register_sidebar_widget('User\'s Favorites', 'tdp_fav_users_favorites_widget_view');
    register_widget_control('User\'s Favorites', 'tdp_fav_users_favorites_widget_control' );

}
add_action('widgets_init', 'tdp_fav_widget_init');
