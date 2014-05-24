<?php
add_image_size( 'dashthumb', 100, 100, true );

// function to display number of posts.
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return __("0 View",'atlas');
    }
    return $count.__(' Views','atlas');
}

// function to count views.
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
if ( ! function_exists( 'tdp_get_rating' ) ) :
    function tdp_get_rating() {
        $rating = ( $overall_rating = get_post_meta( get_the_ID(), '_tdp_atlas_comments_rating', true ) ) && '' != $overall_rating ? $overall_rating : 0;

        // if the post has only an author rating
        if ( 0 == $rating ) $rating = (int) get_post_meta( get_the_ID(), '_tdp_author_rating', true );

        return $rating;
    }
endif;
if ( ! function_exists( 'tdp_get_rating_dashboard' ) ) :
    function tdp_get_rating_dashboard() {
        $rating = ( $overall_rating = get_post_meta( $post->ID, '_tdp_atlas_comments_rating', true ) ) && '' != $overall_rating ? $overall_rating : 0;

        // if the post has only an author rating
        if ( 0 == $rating ) $rating = (int) get_post_meta( $post->ID, '_tdp_author_rating', true );

        return $rating;
    }
endif;
if ( ! function_exists( 'tdp_custom_comments_display' ) ) :
function tdp_custom_comments_display($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
            <div class="comment_avatar">
                <?php echo get_avatar( $comment, $size = '60' ); ?>
            </div> <!-- end .comment_avatar -->

            <div class="comment_postinfo clearfix">
                <?php printf('<span class="fn">%s</span>', get_comment_author_link()) ?>
                <span class="comment_date">
                    <?php
                        /* translators: 1: date, 2: time */
                        printf( __( '%1$s', 'atlas' ), get_comment_date() );
                    ?>
                </span>
                <?php edit_comment_link( esc_html__( '(Edit)', 'atlas' ), ' ' ); ?>

                <?php $user_comment_rating = get_comment_meta( get_comment_ID(), 'tdp_comment_rating', true ); ?>

                <?php if($user_comment_rating !== '') { ?>

                    <div class="user-rating">
                        <ul>
                            <?php if($user_comment_rating == '1') { ?>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($user_comment_rating == '2') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($user_comment_rating == '3') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($user_comment_rating == '4') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } else if($user_comment_rating == '5') { ?>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            <?php } ?>
                        </ul>
                    </div>

                <?php } ?>

            </div> <!-- end .comment_postinfo -->

            <div class="comment_area">
                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.','atlas') ?></em>
                    <br />
                <?php endif; ?>

                <div class="comment-content clearfix">
                    <?php comment_text() ?>
                </div> <!-- end comment-content-->
            </div> <!-- end comment_area-->
        </article> <!-- end comment-body -->
<?php }
endif;

add_action( 'comment_post', 'tdp_add_rating_commentmeta', 10, 2 );
function tdp_add_rating_commentmeta( $comment_id, $comment_approved ){
    #when user adds a comment, check if it's approved

    $comment_rating = ( isset( $_POST['tdp_star'] ) ) ? $_POST['tdp_star'] : 0;
    add_comment_meta( $comment_id, 'tdp_comment_rating', $comment_rating );
    if ( $comment_approved == 1 ) {
        $comment_info = get_comment( $comment_id );
        tdp_update_post_user_rating( $comment_info->comment_post_ID );
    }
}

function tdp_get_approved_comments( $post_id ) {
    global $wpdb;
    return $wpdb->get_results( $wpdb->prepare( "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = '1' ORDER BY comment_date", $post_id ) );
}

function tdp_get_post_user_rating( $post_id ){
    #calculates user (comments) + author rating for the post
    $approved_comments = tdp_get_approved_comments( $post_id );

    $user_rating = 0;
    $approved_comments_number = ! empty( $approved_comments ) ? count( $approved_comments ) : 0;

    if ( ! empty( $approved_comments ) ) {
        foreach ( $approved_comments as $comment ) {
            $comment_rating = get_comment_meta( $comment->comment_ID, 'tdp_comment_rating', true ) ? get_comment_meta( $comment->comment_ID, 'tdp_comment_rating', true ) : 0;
            if ( 0 == $comment_rating ) $approved_comments_number--;

            $user_rating += $comment_rating;
        }
    }

    $author_rating = (int) get_post_meta( $post_id, '_tdp_author_rating', true );
    if ( 0 < $author_rating ) {
        $user_rating += $author_rating;
        $approved_comments_number++;
    }

    $result = ( $user_rating <> 0 ) ? round( $user_rating / $approved_comments_number ) : 0;

    # save user and author rating to the post meta
    if ( ! get_post_meta( $post_id, '_tdp_atlas_comments_rating', true ) )
        update_post_meta( $post_id, '_tdp_atlas_comments_rating', intval( $result ) );

    return $result;
}

function tdp_update_post_user_rating( $post_id ){
    #update (recalculate) user (comments) rating for the post
    $new_comments_rating = tdp_get_post_user_rating( $post_id );

    update_post_meta( $post_id, '_tdp_atlas_comments_rating', $new_comments_rating );
}

add_action( 'wp_set_comment_status', 'tdp_comment_status_changed', 10, 2 );
function tdp_comment_status_changed( $comment_id, $comment_status ){
    $comment_info = get_comment( $comment_id );
    if ( $comment_info ) tdp_update_post_user_rating( $comment_info->comment_post_ID );
}

add_filter( 'comment_form_field_comment', 'tdp_comment_form_add_rating' );
function tdp_comment_form_add_rating( $comment_field ){
    
    if(get_field('enable_ratings_system','option')) { $rating_class = 'system-enabled'; } else { $rating_class = 'system-hidden'; }

    if ( 'listing' != get_post_type() ) return $comment_field;

    $rating_field = '<div id="tdp-rating" class="'.$rating_class.'"><div class="clearfix"><div class="clearboth"></div>';

    for ( $increment = 1; $increment <= 5; $increment = $increment+1 )
        $rating_field .= '<input name="tdp_star" type="radio" class="star" value="' . esc_attr( $increment ) . '" />';

    $rating_field .= '</div></div><div class="clearboth"></div>';

    return $rating_field . $comment_field;

}

add_action('admin_head','tdp_iconfont_admin');
function tdp_iconfont_admin() {
    wp_enqueue_style( 'tdp-fontello', get_template_directory_uri().'/css/fontello.css' );

    $data = '';

    echo '<style>.column-rating ul li {display:inline-block !important; } .column-rating ul {color:#FFC345;}</style>';

    wp_add_inline_style( 'tdp-fontello', $data );
}

/*-----------------------------------------------------------------------------------*/
/* Show Post Status in Dashboard */
/*-----------------------------------------------------------------------------------*/

/**
 * Format the post status for user dashboard
 */
function efe_show_post_status( $status ) {

    if ( $status == 'publish' ) {
        $title = __( 'Published', 'efe' );
    } else if ( $status == 'draft' ) {
        $title = __( 'Draft', 'efe' );
    } else if ( $status == 'pending' ) {
        $title = __( 'Awaiting Approval', 'efe' );
    } else if ( $status == 'future' ) {
        $title = __( 'Scheduled', 'efe' );
    } else if ( $status == 'private' ) {
        $title = __( 'Private', 'efe' );
    }

    $show_status = '<span class="efe-status-'.$status.'">' . $title . '</span>';
    echo apply_filters( 'efe_show_post_status', $show_status, $status );
}

/*-----------------------------------------------------------------------------------*/
/* Listings Claimings */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_loaded', 'claim_process_form' );
function claim_process_form(){
    if( isset( $_POST['claim_submit'] ) ):
                    
        /* get all post fields */
        $post_data = array( 
            'post_author' => 1,
            'post_type' => 'claimed_listing',
            'post_title' => 'Listing Claimed From :' . $_POST['name'] . '',
            'post_content' => $_POST['message'],                                
            'post_status' => 'pending',
            'comment_status' => 'closed',
            'ping_status' => 'closed'                           
        );
                                    
        /* insert post */
        $claim_id = wp_insert_post( $post_data, $post_error );

        if ( $_POST['name'] != '' )         { add_post_meta( $claim_id, 'user_claimed_name', $_POST['name'], true);     }
        if ( $_POST['email'] != '' )        { add_post_meta( $claim_id, 'user_claimed_email', $_POST['email'], true);   }
        if ( $_POST['phone'] != '' )        { add_post_meta( $claim_id, 'user_claimed_phone', $_POST['phone'], true);   }
        if ( $_POST['listing_url'] != '' )      { add_post_meta( $claim_id, 'user_claimed_listing', $_POST['listing_url'], true);   }


        /**
         * Send email to admin if claiming has been received
         */
        if(get_field('receive_email_on_claiming_submission','option')) {

            //define email information
            $adminurl = get_option('siteurl').'/wp-admin/edit.php?post_type=claimed_listing';

            //prepare email settings
            $mailto = get_option('admin_email');
            $subject = __('A listing has been claimed.','atlas');
            $headers = 'From: '. __('Atlas Admin', 'atlas') .' <'. get_option('admin_email') .'>' . "\r\n";
            
            // The blogname option is escaped with esc_html on the way into the database in sanitize_option
            // we want to reverse this for the plain text arena of emails.
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            $message  = __('Dear Admin,', 'atlas') . "\r\n\r\n";
            $message .= sprintf(__('A listing has just been claimed on your %s website.', 'atlas'), $blogname) . "\r\n\r\n";
            $message .= sprintf(__('Review Claim: %s', 'atlas'), $adminurl) . "\r\n\r\n\r\n";
            // ok let's send the email
            wp_mail($mailto, $subject, $message, $headers);

        }


        wp_redirect( get_field('successfully_claimed_page','option') );
        exit();
    endif;
}

/*-----------------------------------------------------------------------------------*/
/* Notify users when a listing is approved. */
/*-----------------------------------------------------------------------------------*/

function tdp_authorNotification($post_id) {

       $post = get_post($post_id);
       $author = get_userdata($post->post_author);

       $message = sprintf(__('Hi %s, your listing %s has just been published at %s. Well done!', 'atlas'), $author->display_name, $post->post_title, get_permalink( $post_id ) ) . "\r\n\r\n";
       
       wp_mail($author->user_email, "Your listing is online", $message);

}
add_action('publish_listing', 'tdp_authorNotification');

/*-----------------------------------------------------------------------------------*/
/* Notify admin to setup the map. */
/*-----------------------------------------------------------------------------------*/

function tdp_admin_notice() {
    ?>
    <?php 

    $adminurl = admin_url( 'admin.php?page=acf-options-listings-settings', 'http' );

    if(get_field('map_type_id','option') == '' || !get_field('map_type_id','option') ) { ?>
    <div class="error">
        <p><?php _e( 'Hello admin! Looks like you did not setup the google map type! Please navigate to <a href="'.$adminurl.'"> "Theme Options -> Listings Settings".'."</a>".' and set the option "Map Type ID" to "ROADMAP" (recommended) then press the save button. You will be then ready to use theme ;)', 'atlas' ); ?></p>
    </div>
    <?php } ?>
    <?php
}
add_action( 'admin_notices', 'tdp_admin_notice' );

if (!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}


function tdp_listings_opengraph() {

    if(!is_admin() && is_singular( 'listing' )) { 

        $post_thumbnail_id = get_post_thumbnail_id();
        $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );

        $post_id = get_the_ID();
        $post_object = get_post( $post_id );

        $text_desc = $post_object->post_content; $trimmed_desc = wp_trim_words( $text_desc, $num_words = 25, $more = null ); 

    ?>

    <meta property="og:title" content="<?php echo the_title();?>" />
    <meta property="og:url" content="<?php echo the_permalink();?>" />
    <meta property="og:description" content="<?php echo addslashes($trimmed_desc);  ?>" />
    <meta property="og:image" content="<?php echo $post_thumbnail_url; ?>" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />

   <?php }

}
add_action('wp_head','tdp_listings_opengraph');


function wpse_order_by() {
    global $wpdb;
    return $wpdb->prepare( "$wpdb->postmeta.meta_value+0 DESC, post_date DESC", $id );
}

add_action('pre_get_posts', 'add_custom_taxonomy_query');
function add_custom_taxonomy_query(&$query)
{
    if (!is_admin() && $query->is_main_query() && is_tax('listings_categories') || !is_admin() && $query->is_main_query() && is_tax('listings_location')) {
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'listing_is_featured');
        add_filter( 'posts_orderby', 'wpse_order_by' );
        $query->set('posts_per_page', get_field('listings_per_page','option'));
    }

    if (!is_admin() && !$query->is_main_query() && is_tax('listings_categories') || !is_admin() && !$query->is_main_query() && is_tax('listings_location')) {
        remove_filter( 'posts_orderby', 'wpse_order_by' );
    }

}

/**
 *  Register Field Restrictions
 */

function tdp_restrict_category( $field )
{     

    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_category_selection_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=tdp_select_listing_category', 'tdp_restrict_category');

function tdp_restrict_area( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_location_selection_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=tdp_select_listing_location_area', 'tdp_restrict_area');


function tdp_restrict_telephone( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_telephone_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=telephone', 'tdp_restrict_telephone');

function tdp_restrict_mobile( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_mobile_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=mobile_phone_number', 'tdp_restrict_mobile');

function tdp_restrict_website( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );
    


    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_website_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=website', 'tdp_restrict_website');

function tdp_restrict_custom( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_custom_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=custom_fields_builder', 'tdp_restrict_custom');


function tdp_restrict_op1( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/key=field_51dd71bd6b635', 'tdp_restrict_op1');

function tdp_restrict_op2( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=monday', 'tdp_restrict_op2');

function tdp_restrict_op3( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=tuesday', 'tdp_restrict_op3');

function tdp_restrict_op4( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=wednesday', 'tdp_restrict_op4');

function tdp_restrict_op5( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=thursday', 'tdp_restrict_op5');

function tdp_restrict_op6( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {
        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=friday', 'tdp_restrict_op6');

function tdp_restrict_op7( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=saturday', 'tdp_restrict_op7');


function tdp_restrict_op8( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_opening_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=sunday', 'tdp_restrict_op8');


function tdp_restrict_featured( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_featured_image_field','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=featured_image', 'tdp_restrict_featured');


function tdp_restrict_img1( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_additional_image1','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=listing_image_2', 'tdp_restrict_img1');

function tdp_restrict_img2( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_additional_image_2','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=listing_image_3', 'tdp_restrict_img2');

function tdp_restrict_img3( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_additional_image_3','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=listing_image_4', 'tdp_restrict_img3');

function tdp_restrict_img4( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_additional_image_4','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=listing_image_5', 'tdp_restrict_img4');


function tdp_restrict_video( $field )
{   
   $url = get_field('submit_new_listing_page','option');
   $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_video','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=insert_video', 'tdp_restrict_video');

function tdp_restrict_video2( $field )
{   
    $url = get_field('submit_new_listing_page','option');
    $url2 = get_field('redirect_edit_listings_page','option');
    $postid = url_to_postid( $url ); $postid2 = url_to_postid( $url2 );

    if(!is_admin() && is_page( $postid ) || !is_admin() && is_page($postid2)) {

        $memberships_ids = get_field('restrict_video','option');

        if($memberships_ids !== '') {
            $memberships_array = explode(",",$memberships_ids);
        }

        if( !tdp_hasMembershipLevel($memberships_array) && get_field('enable_fields_restriction_system','option') ) {
            $field = null;
        }
    
    }

    return $field;
}
add_filter('acf/load_field/name=enter_the_video_id', 'tdp_restrict_video2');


function tdp_enable_promotions_field( $field )
{   
    if(get_field('enable_promotions_system','option')) {
        //do nothing
    } else {
        $field = null;
    }

    return $field;
}
add_filter('acf/load_field/name=tab_prom', 'tdp_enable_promotions_field');
add_filter('acf/load_field/name=add_promotions_to_your_listing', 'tdp_enable_promotions_field');

//hide media from other users
add_filter( 'posts_where', 'tdp_hide_media_for_others' );
function tdp_hide_media_for_others( $where ){
    global $current_user;

    if( is_user_logged_in() ){
        if( isset( $_POST['action'] ) ){
            // library query
            if( $_POST['action'] == 'query-attachments' ){
                $where .= ' AND post_author='.$current_user->data->ID;
            }
        }
    }

    return $where;
}

function tdp_remove_dashboard () {
    global $current_user, $menu, $submenu;
    get_currentuserinfo();

    if( ! in_array( 'administrator', $current_user->roles ) ) {
        reset( $menu );
        $page = key( $menu );
        while( ( __( 'Dashboard' ) != $menu[$page][0] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if( __( 'Dashboard' ) == $menu[$page][0] ) {
            unset( $menu[$page] );
        }
        while( ( __( 'Posts' ) != $menu[$page][0] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if( __( 'Posts' ) == $menu[$page][0] ) {
            unset( $menu[$page] );
        }
        while( ( __( 'Listings' ) != $menu[$page][0] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if( __( 'Listings' ) == $menu[$page][0] ) {
            unset( $menu[$page] );
        }
        while( ( __( 'Tools' ) != $menu[$page][0] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if( __( 'Tools' ) == $menu[$page][0] ) {
            unset( $menu[$page] );
        }
        while( ( __( 'Contact' ) != $menu[$page][0] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if( __( 'Contact' ) == $menu[$page][0] ) {
            unset( $menu[$page] );
        }
        while( ( __( 'Media' ) != $menu[$page][0] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if( __( 'Media' ) == $menu[$page][0] ) {
            unset( $menu[$page] );
        }
        reset($menu);
        $page = key($menu);
        while ( ! $current_user->has_cap( $menu[$page][1] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if ( preg_match( '#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI'] ) || preg_match( '#wp-admin/?(post.php)?$#', $_SERVER['REQUEST_URI'] ) && ( 'index.php' != $menu[$page][2] ) ) {
            wp_redirect( home_url() );
        }
    }
}
add_action('admin_menu', 'tdp_remove_dashboard');


function remove_those_menu_items( $menu_order ){
            global $menu;
            global $pagenow;

            // check using the new capability with current_user_can
            if ( current_user_can( 'basic_contributor' ) ) {
             foreach ( $menu as $mkey => $m ) {
                $key = array_search( 'edit.php?post_type=claimed_listing', $m );
                //pages menu
                $keyB = array_search( 'edit-comments.php', $m );
                //posts menu
                $keyC = array_search( 'upload.php', $m );

                $keyD = array_search( 'profile.php', $m );

                if ( $key || $keyB || $keyC || $keyD )
                    unset( $menu[$mkey] );
             }
            }
            if( !current_user_can( 'administrator' ) && $pagenow == 'post.php') {
                wp_redirect( home_url() );
                exit();
            }
            return $menu_order;
}

add_filter( 'menu_order', 'remove_those_menu_items' );


if( function_exists('acf_set_options_page_capability') )
{
    acf_set_options_page_capability( 'manage_options' );
}



// add listings to feeds
function tdp_myfeed_request($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('post', 'listing');
    return $qv;
}
add_filter('request', 'tdp_myfeed_request');


/* 
 * Load graph in dashboard
 */
function tdp_users_dashboard_graph() {

    if( in_array( 'Display Listings Graph', get_field('efe_dashboard_display_settings','option') ) ) {

    get_template_part('includes/theme','graph');

    } 
}
add_action('before_dashboard','tdp_users_dashboard_graph');

function tdp_my_setup_nav() {
      global $bp;

      bp_core_new_nav_item( array( 
            'name' => __( 'Submitted Listings', 'atlas' ), 
            'slug' => 'member-listings', 
            'position' => 30, 
            'screen_function' => 'tdp_single_member_listings', 
      ) );

}

add_action( 'bp_setup_nav', 'tdp_my_setup_nav' );

function tdp_single_member_listings() {
      bp_core_load_template( 'member-listings' );
}

function tdp_bp_listings_button() { ?>
    
    <br/>

    <?php $author_id = get_the_author_meta( 'ID' ); ?>

    <a href="<?php echo bp_core_get_user_domain($author_id);?>member-listings" id="profile-list" class="button"><?php _e('View All Listings From This Author','atlas');?></a>

<?php }

if ( in_array( 'buddypress/bp-loader.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_action('display_user_listings_button','tdp_bp_listings_button');
}

add_filter('wp_dropdown_users', 'tdp_custom_wp_dropdown_users');
function tdp_custom_wp_dropdown_users($output) {
    global $post;
    $users = get_users();
    $output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
    $output .= "<option value=\"1\">Admin</option>";
    foreach($users as $user) {
        $sel = ($post->post_author == $user->ID)?"selected='selected'":'';
        $output .= '<option value="'.$user->ID.'"'.$sel.'>'.$user->user_login.'</option>';
    }
    $output .= "</select>";
    return $output;
}

/**
 *  Extend Shortcodes
 */
function tdp_shortcode_listings_categories_list( $atts, $content=null ) {
    extract( shortcode_atts( array(
        '' => '',
    ), $atts ) );

    ob_start(); ?>

    <div class="type_list">
    
            <?php 

                $terms = get_terms("listings_categories",'hide_empty=0&parent=0');
                 $count = count($terms);
                 if ( $count > 0 ){
                     foreach ( $terms as $term )  {

                        echo '<div class="one_third">';
                            echo '<h4>'.$term->name.'</h4>';
                            echo '<div class="cat-desc">'.get_field('taxonomy_description', 'listings_categories_' . $term->term_id );
                            echo '<a class="button small" href="'. get_term_link( $term ) . '">'.__('View Listings','atlas').'</a>';
                            echo '</div>';
                        echo '</div>';

                     }
                 }
            ?>
            <div class="clearboth"></div>
    </div>

    <?php $html .= ob_get_clean();

    return $html;

    
}
add_shortcode('listings_categories_list', 'tdp_shortcode_listings_categories_list');

/**
 *  Extend body class if ajax map enabled
 */
add_filter('body_class','tdp_add_body_ajax_class');
function tdp_add_body_ajax_class($classes) {

    if(get_field('enable_ajax_map','option')) {
        // add 'map-is-ajax' to the $classes array
        $classes[] = 'map-is-ajax';
    }
    // return the $classes array
    return $classes;
}

/**
 *  Extend body class if category has child items
 */

add_filter('body_class','tdp_add_body_child_class');
function tdp_add_body_child_class($classes) {

    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); // get current term
    $parent = get_term($term->parent, get_query_var('taxonomy') ); // get parent term
    $children = get_term_children($term->term_id, get_query_var('taxonomy')); // get children

    if(($parent->term_id=="") && (sizeof($children)>0) && is_tax()) {
        $classes[] = 'tax-has-child';
    } else {
        $classes[] = 'tax-has-no-child';
    }

    return $classes;

}

/**
 *  Display Subcategories in current taxonomies pages
 */
function tdp_display_sub_categories_in_taxonomies() {

    if(get_field('display_child_items','option') && is_tax('listings_categories') || is_tax('listings_location')) {

        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); // get current term
        $parent = get_term($term->parent, get_query_var('taxonomy') ); // get parent term
        $children = get_term_children($term->term_id, get_query_var('taxonomy')); // get children

        if(($parent->term_id!="" && sizeof($children)>0)) {

            //echo 'parent and child';

        }elseif(($parent->term_id!="") && (sizeof($children)==0)) {

            //echo 'has parent';

        }elseif(($parent->term_id=="") && (sizeof($children)>0)) {

            //first get the current term
            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $term_id = $current_term->term_id;
            $taxonomy_name = $current_term->taxonomy;
            $termchildren = get_term_children( $term_id, $taxonomy_name );

            //layout
            $clear_row = '';
            $clear_row_end = '';

            echo '<div id="child-items">';
            echo '<div class="list-detail">
                        <div class="list-detail">
                            <h2>'.__('Sub Categories','atlas').'</h2>
                            <ul>';

            foreach ( $termchildren as $child ) { 

                $clear_row++; $clear_row_end++;
                $term = get_term_by( 'id', $child, $taxonomy_name );

                echo '<li class="col-md-6">
                        <span class="name"><a href="' . get_term_link( $child, $taxonomy_name ) . '">' . $term->name . '</a></span>
                        <span class="stt"><a class="button small" href="' . get_term_link( $child, $taxonomy_name ) . '">' . __('View Listings','atlas') . '</a></span>
                    </li>';
            }
            echo '</div></div><div class="clear"></div></div>';


        }

    }

}
add_action('after_listing_category_desc','tdp_display_sub_categories_in_taxonomies');

/**
 *  Display Subcategories in current taxonomies pages
 */
add_filter('body_class','tdp_add_bar_class');
function tdp_add_bar_class($classes) {

    if(!get_field('display_topbar','option')) {
        $classes[] = 'top-bar-hidden';
    }

    if(!is_user_logged_in()) {
        $classes[] = 'non-logged-in';
    }

    if(is_admin_bar_showing()) {
        $classes[] = 'admin-bar-showing';
    } else {
        $classes[] = 'admin-bar-not-showing';
    }

    // return the $classes array
    return $classes;
}

/**
 *  Force name fields on checkout
 */
function my_tdp_checkout_boxes_require_address() { ?>
<script>
    var tdp_show_billing_address_fields_timer;
    function showBillingAddressFields()
    {
        jQuery('#tdp_billing_address_fields').show();
        tdp_show_billing_address_fields_timer = setTimeout(function(){showBillingAddressFields();}, 200);
    }
    jQuery(document).ready(function() {
        //show it and keep showing it
        showBillingAddressFields();
        
        <?php
            //remove billing from address title if the level is free
            global $tdp_level;
            if(tdp_isLevelFree($tdp_level))
            {
            ?>
                //change heading
                jQuery('#tdp_billing_address_fields th').html('Address');
            <?php
            }
        ?>
    });
</script>
<?php }
 
//make sure address fields are required
function my_tdp_required_user_fields($fields) {   
    global $bfirstname, $blastname;
    
    $fields["bfirstname"] = $bfirstname;
    $fields["blastname"] = $blastname;
 
    return $fields;
}

if(get_field('force_name_fields','option')) { 
    add_action("tdp_required_user_fields", "my_tdp_required_user_fields");
    add_action("tdp_checkout_boxes", "my_tdp_checkout_boxes_require_address");
}