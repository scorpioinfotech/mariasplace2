<?php
/**
 * Dashboard class
 * This class handles the shortcode to display the user dashboard on the frontend
 * The dashboard will display submitted posts with a few other options.
 */
class EFE_Frontend_Dashboard {
    function __construct() {
        add_shortcode( 'efe_dashboard', array($this, 'shortcode') );
    }
    /**
     * Handle's user dashboard functionality
     *
     * Insert shortcode [efe_dashboard] in a page to
     * show the user dashboard
     * add the post_type parameter to select from which post type the dashboard should grab the posts.
     */
    function shortcode( $atts ) {
        extract( shortcode_atts( array('post_type' => 'post'), $atts ) );
        ob_start();
        //Let's check if the user is logged in
        if ( is_user_logged_in() ) {
            $this->display_posts_table( $post_type );
        } else {
            $message = get_field( 'efe_dashboard_restricted_access_message', 'option' );
            echo '<div class="efe-message">'.$message.'</div>';
        }
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    /**
     * Displays The Dashboard With a list of posts and options to manage them
     *
     * @global object $wpdb
     * @global object $userdata
     */
    function display_posts_table( $post_type ) {
        global $wpdb, $userdata, $post;
        $userdata = get_userdata( $userdata->ID );
        $efe_pagination = isset( $_GET['efe_pagination'] ) ? intval( $_GET['efe_pagination'] ) : 1;
        //delete post action
        if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "delete_post" ) {
            $this->efe_delete_post();
        }
        if ( isset( $_GET['order'] ) && $_GET['order'] == 'ASC' ) {
            $asc_or_desc = 'ASC';
        } else {
            $asc_or_desc = 'DESC';
        }
        if ( isset( $_GET['order_by'] ) && $_GET['order_by'] == 'title' ) {
            $order_by = 'title';
        } else {
            $order_by = 'date';
        }
        $args = array(
            'author' => get_current_user_id(),
            'post_status' => array('draft', 'future', 'pending', 'publish', 'private' ),
            'post_type' => $post_type,
            'orderby' =>    $order_by,
            'order'  => $asc_or_desc,
            'posts_per_page' => get_field('efe_posts_per_page','option'),
            'paged' => $efe_pagination
        );
        $dashboard_query = new WP_Query( apply_filters( 'efe_dashboard_query', $args ) );
        $post_type_obj = get_post_type_object( $post_type );
        ?>
        <section id="efe-dashboard-wrapper">
        <?php if( in_array( 'Display Page Head', get_field('efe_dashboard_display_settings','option') ) ) { ?>
            <h2 class="efe-page-head ">
                <span><?php printf( __( "Welcome To Your Dashboard %s", 'atlas' ), $userdata->user_login ); ?></span>
            </h2>
        <?php } ?>

        <?php if( in_array( 'Display Post Count', get_field('efe_dashboard_display_settings','option') ) ) { ?>
            <div class="efe-post-count"><?php printf( __( 'You have added a total of <span>%d</span> %s', 'atlas' ), $dashboard_query->found_posts, $post_type_obj->label ); ?></div>
        <?php } ?>

        <?php do_action('before_dashboard');?>

        <?php if ( $dashboard_query->have_posts() ) { ?>
        <div class="styled-table">
            <table id="dashboard-table" class="efe-table <?php echo $post_type; ?>" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <?php
                        if( in_array( 'Display Featured Images', get_field('efe_dashboard_display_settings','option') ) ) {
                            echo '<th>' . __( 'Featured Image', 'atlas' ) . '</th>';
                        }
                        ?>
                        <?php if( in_array( 'Display Post Title', get_field('efe_dashboard_display_settings','option') ) ){ ?>
                            <th><?php printf( __( '%s Title', 'atlas' ), $post_type_obj->label ); ?></th>
                        <?php } ?>
                        <?php if( in_array( 'Display Post Status', get_field('efe_dashboard_display_settings','option') ) ){ ?>
                            <th class="set-center"><?php printf( __( '%s Status', 'atlas' ), $post_type_obj->label ); ?></th>
                        <?php } ?>
                        <?php do_action( 'efe_dashboard_head_col', $args ) ?>
                        <?php
                        if(get_field('efe_charge_user_for_posts_submission','option')) {
                            echo '<th>' . __( 'Payment', 'atlas' ) . '</th>';
                        }
                        ?>
                        <?php if( in_array( 'Display Options', get_field('efe_dashboard_display_settings','option') ) ){ ?>
                            <th class="set-center"><?php printf( __( 'Manage %s', 'atlas' ), $post_type_obj->label ); ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dashboard_query->have_posts()) {
                        $dashboard_query->the_post();
                        //Lets make sure the post is published before showing the link
                        $show_link = !in_array( $post->post_status, array('draft', 'future', 'pending') );
                        ?>
                        <tr>
                            <?php if( in_array( 'Display Featured Images', get_field('efe_dashboard_display_settings','option') ) ) { ?>
                                <td>
                                    <?php
                                    echo $show_link ? '<a href="' . get_permalink( $post->ID ) . '">' : '';
                                    if ( has_post_thumbnail() ) {
                                        the_post_thumbnail('thumbnail');
                                    } else {
                                        printf( '<img src="%1$s" class="attachment-thumbnail wp-post-image" alt="%2$s" title="%2$s" />', apply_filters( 'efe_no_image', plugins_url( '/images/no-image.png', dirname( __FILE__ ) ) ), __( 'No Image', 'atlas' ) );
                                    }
                                    echo $show_link ? '</a>' : '';
                                    ?>
                                </td>
                            <?php } ?>
                            <?php if( in_array( 'Display Post Title', get_field('efe_dashboard_display_settings','option') ) ){ ?>
                                <td>
                                    <?php if ( !$show_link ) { ?>
                                        <?php the_title(); ?>
                                    <?php } else { ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'atlas' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                            <?php if( in_array( 'Display Post Status', get_field('efe_dashboard_display_settings','option') ) ){ ?>
                            <td class="set-center">
                                <?php efe_show_post_status( $post->post_status ); ?>
                            </td>
                            <?php } ?>
                            <?php do_action( 'efe_dashboard_row_col', $args, $post ) ?>
                            <?php if( in_array( 'Display Options', get_field('efe_dashboard_display_settings','option') ) ){ ?>
                            <td class="set-center">
                                <?php
                                if( in_array( 'Allow Users To Edit Their Posts', get_field('efe_user_posting_restrictions','option') ) ) {
                                    
                                    $url = add_query_arg( array('pid' => $post->ID), get_field('redirect_edit_listings_page','option') );                        
                                        
                                    ?>
                                    <a class="efe-edit-link" href="<?php echo wp_nonce_url( $url, 'efe_edit' ); ?>"><?php _e( 'Edit', 'atlas' ); ?></a>
                                <?php } ?>
                                <?php
                                if( in_array( 'Allow Users To Delete Their Posts', get_field('efe_user_posting_restrictions','option') ) ) {
                                    $del_url = add_query_arg( array('action' => 'delete_post', 'pid' => $post->ID) );
                                    ?>
                                    <a class="efe-delete-link" href="<?php echo wp_nonce_url( $del_url, 'efe_del' ); ?>" onclick="return confirm('Are you sure you want to delete &quot;<?php the_title();?>&quot; ?');"><?php _e( 'Delete', 'atlas' ); ?></a>
                                <?php } ?>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php
                    }
                    wp_reset_postdata();
                    ?>
                </tbody>
            </table>
        </div>
            <div class="efe-pagination">
                <?php
                $pagination = paginate_links( array(
                    'base' => add_query_arg( 'efe_pagination', '%#%' ),
                    'format' => '',
                    'prev_text' => __( '&laquo;', 'atlas' ),
                    'next_text' => __( '&raquo;', 'atlas' ),
                    'total' => $dashboard_query->max_num_pages,
                    'current' => $efe_pagination
                ) );

                if ( $pagination ) {
                    echo $pagination;
                }
                ?>
            </div>
        </section>
            <?php
        } else {
            printf( __( 'No %s found', 'atlas' ), $post_type_obj->label );
            do_action( 'efe_dashboard_nopost', $userdata->ID, $post_type_obj );
        }
        do_action( 'efe_dashboard_bottom', $userdata->ID, $post_type_obj );

        if(get_field('enable_favorites_system','option')) {

            tdp_fav_list_favorite_posts(); 

        }

    }
    /**
     * Delete a post
     *
     * Only post author and editors has the capability to delete a post
     */
    function efe_delete_post() {
        global $userdata, $current_user;
        get_currentuserinfo();

        $nonce = $_REQUEST['_wpnonce'];
        if ( !wp_verify_nonce( $nonce, 'efe_del' ) ) {
            die( "Just checking here..." );
        }
        //check, if the requested user is the post author
        $maybe_delete = get_post( $_REQUEST['pid'] );
        if ( ($maybe_delete->post_author == $userdata->ID) || current_user_can( 'delete_others_pages' ) ) {
            wp_trash_post( $_REQUEST['pid'] );

            //display message
            $print_success = '<div class="efe-message efe-green success">' . __( 'The selected post has been deleted.', 'atlas' ) . '</div>';
            print($print_success);
        } else {
            echo '<div class="error">' . __( 'You are not allowed to delete this post.', 'atlas' ) . '</div>';
        }
    }
}