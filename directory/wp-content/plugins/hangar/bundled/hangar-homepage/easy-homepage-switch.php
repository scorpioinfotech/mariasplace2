<?php 

//Add custom meta field 
add_action( 'add_meta_boxes', 'cd_meta_box_add' );  

function cd_meta_box_add()
{
    add_meta_box( 'front-page-options', 'Front Page Options', 'cd_meta_box_cb', "page", 'side', 'high' );
    
}

function cd_meta_box_cb()  
{  
    // $post is already set, and contains an object: the WordPress post  
    global $post;
    
    $values = get_post_custom( $post->ID );  
    
    // We'll use this nonce field later on when saving.  
    wp_nonce_field( 'my_ic_is_homepage', 'ic_is_homepage_box' ); 
    ?> 
    <p> 
        <label for="ic_is_homepage" ><strong>Set this page as "Front Page"</strong></label> 
        <input type="checkbox" name="ic_is_homepage" id="ic_is_homepage" value="<?php echo $post->ID ?>" <?php echo get_option("page_on_front") == $post->ID ? ' checked="checked" ':'' ?> />
        <p class="howto">Once you save the page, this page will be new Front Page. Changes could be made at <a href="options-reading.php">Settings &gt; Reading</a> any time.<br /><strong>Important :</strong> Current user must have rights to manage settings.</p>
    </p>  
    <?php
}

add_action( 'save_post', 'cd_meta_box_save' );

function cd_meta_box_save( $post_id )  
{  
    $return = false;
    
    // Bail if we're doing an auto save  
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 

    // if our nonce isn't there, or we can't verify it, bail 
    if( !isset( $_POST['ic_is_homepage_box'] ) || !wp_verify_nonce( $_POST['ic_is_homepage_box'], 'my_ic_is_homepage' ) ) $return = true;

    if( $return === true ) return;
 
    // if our current user can't change the settings
    if( !current_user_can( 'manage_options' ) ) return;  
    
    if( isset( $_POST['ic_is_homepage'] ) ) {
        update_option("show_on_front", "page");
        update_option("page_on_front", addslashes( $_POST['ic_is_homepage'] ));
    }else{ //set page options to latest posts
        global $post;
        if($post->ID == get_option("page_on_front")) {      
            update_option("show_on_front", "posts");
            update_option("page_on_front", "0");
        }
    }
}