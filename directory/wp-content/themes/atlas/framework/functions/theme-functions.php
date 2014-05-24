<?php
/*--------------------------------------------------------------------*/            							
/*  CLEAN UP THE <HEAD>						                   							
/*--------------------------------------------------------------------*/
remove_action('wp_head','wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version

/*--------------------------------------------------------------------*/         							
/*  FIX FOR CATEGORY REL TAG (PRODUCES INVALID HTML5 CODE)									 					
/*--------------------------------------------------------------------*/
if ( !function_exists('dp_add_nofollow_cat') ) {
	 
	function dp_add_nofollow_cat( $text ) {
	
		$text = str_replace('rel="category tag"', "", $text); 
		
		return $text;
		
	}
	add_filter( 'the_category', 'dp_add_nofollow_cat' ); 
}

/* 	Add support for a variety of post formats
 *	--------------------------------------------------------------------------- */
	add_theme_support('post-formats', array('gallery', 'video', 'link', 'image') );

	add_editor_style( TEMPLATEPATH . 'editor-style.css');

	/*	Add site favicon
 *	--------------------------------------------------------------------------- */	
	function dp_favicon() {
		if ( get_field('custom_favicon','option') )
		echo '<link rel="shortcut icon" href="'. get_field('custom_favicon','option').'">';
	}
	
	add_action('wp_head', 'dp_favicon');


/* 	Register WP nav menu locations
 *	--------------------------------------------------------------------------- */
	if ( function_exists('register_nav_menus') ) { 
		register_nav_menus(
			array(
				'primary_menu' => __('Primary Menu', 'atlas'), 
				'footer_menu' => __('Footer Menu', 'atlas'),
                'responsive-menu' => __('Responsive Menu', 'atlas'),
			)
		);
	}

/* 	Clean active menus
 *	--------------------------------------------------------------------------- */
	add_filter('nav_menu_css_class', 'dp_clean_active_menu', 10, 2);

	function dp_clean_active_menu($active, $item) {
		$active = str_replace('current_page_item', 'active', $active);
		$active = str_replace('current-menu-item', 'active', $active);
		// $active = str_replace('current_page_parent', 'active', $active);
		$active = str_replace('current-page-ancestor', 'active', $active);
		// $active = str_replace('current-menu-parent', 'active', $active);
		// $active = str_replace('current-menu-ancestor', 'active', $active);
		
		return $active;
	}

/* 	Print post format badge
 * 	----------------------------------------------------- */
	function dp_print_entry_badge($format){
		$out = '';
		$out .= '<div class="entry-badge"><a href="'.get_permalink().'">';
		switch ($format) {
			case 'gallery': $out .= '<i class="icon-picture"></i>'; break;
			case 'video': $out .= '<i class="icon-film"></i>'; break;
			case 'link': $out .= '<i class="icon-link"></i>'; break;
			case 'image': $out .= '<i class="icon-camera-retro"></i>'; break;
			case 'quote': $out .= '<i class="icon-quote-right"></i>'; break;
			case 'status': $out .= '<i class="icon-info-sign"></i>'; break;
			case 'audio': $out .= '<i class="icon-volume-up"></i>'; break;
			default: $out .= '<i class="icon-pencil"></i>'; break;
		}
		$out .= '</a></div>';

		return $out;
	}

/* 
 * Header Common Elements
 */
if(!function_exists('dp_head_common')){
    function dp_head_common(){ ?>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <?php              
            echo '<title>';
            global $page, $paged;
            wp_title( '|', true, 'right' );
            // Add the blog name.
            bloginfo( 'name' );
            // Add the blog description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";
            // Add a page number if necessary:
            if ( $paged >= 2 || $page >= 2 )
                echo ' | ' . sprintf( __( 'Page %s', 'atlas' ), max( $paged, $page ) );
            echo '</title>';
            echo ( !apply_filters( 'invent_xfn', '' ) )  ? "\r\n<link rel=\"profile\" href=\"http://gmpg.org/xfn/11\" />\r\n" : '';
        
    }
}
if(!function_exists('dp_logo'))
{
    /**
     * return the logo of the theme. if a logo was uploaded and set at the backend options panel display it
     * otherwise display the logo file linked in the css file for the .bg-logo class
     * @return string the logo + url
     */
    function dp_logo($use_image = "", $sub = "")
    {
        $use_image = apply_filters('dp_logo_filter', $use_image);
        if($sub) $sub = "<span class='subtext'>$sub</span>";
        
        
        if($logo = get_field('custom_logo','option'))
        {
             $logo = "<img src=".$logo." alt='' />";
             $logo = "<a href='".home_url('/')."'>".$logo."$sub</a>";
        }
        else
        {
            $logo = get_bloginfo('name');
            if($use_image) $logo = "<img src=".$use_image." alt='' title='$logo'/>";
            $logo = "<a href='".home_url('/')."'>".$logo."$sub</a>";
        }
    
        return $logo;
    }
}


/**
 * Changes the default HTML structure of the author, email and url comment form fields to better suite the design
 */
function dp_comment_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    $fields = array(
        'author' => '<div id="form-section-author" class="form-section"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" /><label for="author">' . __( 'Name', 'atlas' ) . '</label></div>',
        'email'  => '<div id="form-section-email" class="form-section"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" /><label for="email">' . __( 'Email', 'atlas' ) . '</label></div>',
        'url'    => '<div id="form-section-url" class="form-section"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /><label for="url">' . __( 'Website', 'atlas' ) . '</label></div>',
    );
    return $fields;
}
add_filter('comment_form_default_fields','dp_comment_fields');


/**
 * Changes the default HTML structure of the comment form field to better suite the design
 */
function dp_comment_form_field_comment( $args ) {    
    return '<div id="form-section-comment" class="form-section"><textarea id="comment" name="comment" cols="65" rows="10"></textarea></div>';
}
add_filter('comment_form_field_comment','dp_comment_form_field_comment');


/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function dp_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case '' :
    ?>      
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="single-comment">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 60 ); ?>
                <cite class="commenter"><?php echo get_comment_author_link(); ?></cite>
            </div><!-- .comment-author .vcard -->
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-not-approved"><?php _e( 'Your comment is awaiting moderation.', 'atlas' ); ?></em>
            <?php endif; ?>
    
            <div class="comment-meta commentmetadata">
                <?php
                    /* translators: 1: date, 2: time */
                    printf( __( '%1$s at %2$s', 'atlas' ), get_comment_date(),  get_comment_time() );
                ?>
            </div><!-- .comment-meta .commentmetadata -->
    
            <div class="comment-content"><?php comment_text(); ?></div>

        </div><!-- #comment-##  -->    

        <div class="comment-reply">
            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div><!-- .comment-reply -->

    <?php
            break;
        case 'pingback'  :
        case 'trackback' :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="single-comment">
            <?php _e( 'Pingback:', 'atlas' ); ?> <?php comment_author_link(); ?>
        </div>
    <?php
            break;
    endswitch;
}

/**
 * Renders Social Icons
 */

if(!function_exists('dp_social_icon'))
{
    function dp_social_icon() {

        if(get_field('social_links','option')) {

            $out = '';
            $out .= '<ul class="social-nav-list">';

            while(has_sub_field('social_links','option')) {

                $out .= '<li class="social-icon"><a class="tip-me" href="' . get_sub_field('profile_url','option') . '" data-toggle="tooltip" data-animation="true" title="'.get_sub_field('tooltip_text','option').'"><span class="' . get_sub_field('social_platform','option') . '"></span></a></li>';

            }

            $out .= "</ul>";

            return $out;


        }

    }

}

/**
 * Breadcrumb
 */

function tdp_breadcrumbs() {

    if(get_field('display_breadcrumb','option')) {

    if(function_exists('bcn_display')) {
                
            echo '<i class="icon-location"></i>';
            bcn_display();
            
        } else  { 

                /* === OPTIONS === */
                $text['home']     = __('Home','atlas'); // text for the 'Home' link
                $text['category'] = __('Archive by Category "%s"','atlas'); // text for a category page
                $text['search']   = __('Search Results for "%s" Query','atlas'); // text for a search results page
                $text['tag']      = __('Posts Tagged "%s"','atlas'); // text for a tag page
                $text['author']   = __('Articles Posted by %s','atlas'); // text for an author page
                $text['404']      = __('Error 404','atlas'); // text for the 404 page

                $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
                $showOnHome  = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
                $delimiter   = ' &raquo; '; // delimiter between crumbs
                $before      = '<span class="current">'; // tag before the current crumb
                $after       = '</span>'; // tag after the current crumb
                /* === END OF OPTIONS === */

                global $post;
                $homeLink = get_bloginfo('url') . '/';
                $linkBefore = '<span typeof="v:Breadcrumb">';
                $linkAfter = '</span>';
                $linkAttr = ' rel="v:url" property="v:title"';
                $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

                if (is_home() || is_front_page()) {

                    if ($showOnHome == 1) echo '<div id="crumbs"><span class="icon-location"></span><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

                } else {

                    echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#"><span class="icon-location"></span>' . sprintf($link, $homeLink, $text['home']) . $delimiter;

                    if ( is_category() ) {
                        $thisCat = get_category(get_query_var('cat'), false);
                        if ($thisCat->parent != 0) {
                            $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                            echo $cats;
                        }
                        echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

                    } elseif ( is_search() ) {
                        echo $before . sprintf($text['search'], get_search_query()) . $after;

                    } elseif ( is_day() ) {
                        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                        echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
                        echo $before . get_the_time('d') . $after;

                    } elseif ( is_month() ) {
                        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                        echo $before . get_the_time('F') . $after;

                    } elseif ( is_year() ) {
                        echo $before . get_the_time('Y') . $after;

                    } elseif ( is_single() && !is_attachment() ) {
                        if ( get_post_type() != 'post' ) {
                            $post_type = get_post_type_object(get_post_type());
                            $slug = $post_type->rewrite;
                            printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
                        } else {
                            $cat = get_the_category(); $cat = $cat[0];
                            $cats = get_category_parents($cat, TRUE, $delimiter);
                            if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                            echo $cats;
                            if ($showCurrent == 1) echo $before . get_the_title() . $after;
                        }

                    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                        $post_type = get_post_type_object(get_post_type());
                        echo $before . $post_type->labels->singular_name . $after;

                    } elseif ( is_attachment() ) {
                        $parent = get_post($post->post_parent);
                        $cat = get_the_category($parent->ID); $cat = $cat[0];
                        $cats = get_category_parents($cat, TRUE, $delimiter);
                        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                        echo $cats;
                        printf($link, get_permalink($parent), $parent->post_title);
                        if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

                    } elseif ( is_page() && !$post->post_parent ) {
                        if ($showCurrent == 1) echo $before . get_the_title() . $after;

                    } elseif ( is_page() && $post->post_parent ) {
                        $parent_id  = $post->post_parent;
                        $breadcrumbs = array();
                        while ($parent_id) {
                            $page = get_page($parent_id);
                            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                            $parent_id  = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        for ($i = 0; $i < count($breadcrumbs); $i++) {
                            echo $breadcrumbs[$i];
                            if ($i != count($breadcrumbs)-1) echo $delimiter;
                        }
                        if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

                    } elseif ( is_tag() ) {
                        echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

                    } elseif ( is_author() ) {
                        global $author;
                        $userdata = get_userdata($author);
                        echo $before . sprintf($text['author'], $userdata->display_name) . $after;

                    } elseif ( is_404() ) {
                        echo $before . $text['404'] . $after;
                    }

                    if ( get_query_var('paged') ) {
                        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                        echo __('Page','atlas') . ' ' . get_query_var('paged');
                        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
                    }

                    echo '</div>';

                }

        }
    
    }

} // end dimox_breadcrumbs()

function limit_words($string, $word_limit)
{
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}


add_filter('wp_get_attachment_link', 'add_gallery_id_rel');
function add_gallery_id_rel($link) {
    global $post;
    return str_replace('<a href', '<a class="tdp-gallery" href', $link);
}

if ( !function_exists('framework_pagination') ) {

    function framework_pagination( $pages = '', $range = 2 ) {

        $showitems = ( $range * 2 ) + 1;

        global $paged, $wp_query;

        if( empty( $paged ) )
            $paged = 1;

        if( $pages == '' ) {

            $pages = $wp_query->max_num_pages;

            if( !$pages )
                $pages = 1;

        }

        if( 1 != $pages ) {

            $output = '<nav class="pagination">';

            // if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
                // $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'framework') . '</a>';

            if( $paged > 1 /*&& $showitems < $pages*/ )
                $output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Next Entries', 'framework') . '</a>';

            for ( $i = 1; $i <= $pages; $i++ )  {

                if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
                    $output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

            }

            if ( $paged < $pages /*&& $showitems < $pages*/ )
                $output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Previous Entries', 'framework') . ' &rarr;</a>';

            // if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
                // $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'framework') . ' &raquo;</a>';

            $output .= '</nav>';

            return $output;

        }

    }

}




// useless without this
if ( function_exists( 'wp_nav_menu' ) && ! function_exists( 'dropdown_menu' ) ) {

/**
 * Tack on the blank option for urls not in the menu
 */
add_filter( 'wp_nav_menu_items', 'dropdown_add_blank_item', 10, 2 );
function dropdown_add_blank_item( $items, $args ) {
    if ( isset( $args->walker ) && is_object( $args->walker ) && method_exists( $args->walker, 'is_dropdown' ) ) {
        if ( ( ! isset( $args->menu ) || empty( $args->menu ) ) && isset( $args->theme_location ) ) {
            $theme_locations = get_nav_menu_locations();
            $args->menu = wp_get_nav_menu_object( $theme_locations[ $args->theme_location ] );
        }
        $title = isset( $args->dropdown_title ) ? wptexturize( $args->dropdown_title ) : '&mdash; ' . $args->menu->name . ' &mdash;';
        if ( ! empty( $title ) )
            $items = '<option value="" class="blank">' . apply_filters( 'dropdown_blank_item_text', $title, $args ) . '</option>' . $items;
    }
    return $items;
}


/**
 * Remove empty options created in the sub levels output
 */
add_filter( 'wp_nav_menu_items', 'dropdown_remove_empty_items', 10, 2 );
function dropdown_remove_empty_items( $items, $args ) {
    if ( isset( $args->walker ) && is_object( $args->walker ) && method_exists( $args->walker, 'is_dropdown' ) )
        $items = str_replace( "<option></option>", "", $items );
    return $items;
}


/**
 * Script to make it go (no jquery! (for once))
 */
add_action( 'wp_footer', 'dropdown_javascript' );
function dropdown_javascript() {
    if ( is_admin() ) return; ?>
    <script>
        var getElementsByClassName=function(a,b,c){if(document.getElementsByClassName){getElementsByClassName=function(a,b,c){c=c||document;var d=c.getElementsByClassName(a),e=b?new RegExp("\\b"+b+"\\b","i"):null,f=[],g;for(var h=0,i=d.length;h<i;h+=1){g=d[h];if(!e||e.test(g.nodeName)){f.push(g)}}return f}}else if(document.evaluate){getElementsByClassName=function(a,b,c){b=b||"*";c=c||document;var d=a.split(" "),e="",f="http://www.w3.org/1999/xhtml",g=document.documentElement.namespaceURI===f?f:null,h=[],i,j;for(var k=0,l=d.length;k<l;k+=1){e+="[contains(concat(' ', @class, ' '), ' "+d[k]+" ')]"}try{i=document.evaluate(".//"+b+e,c,g,0,null)}catch(m){i=document.evaluate(".//"+b+e,c,null,0,null)}while(j=i.iterateNext()){h.push(j)}return h}}else{getElementsByClassName=function(a,b,c){b=b||"*";c=c||document;var d=a.split(" "),e=[],f=b==="*"&&c.all?c.all:c.getElementsByTagName(b),g,h=[],i;for(var j=0,k=d.length;j<k;j+=1){e.push(new RegExp("(^|\\s)"+d[j]+"(\\s|$)"))}for(var l=0,m=f.length;l<m;l+=1){g=f[l];i=false;for(var n=0,o=e.length;n<o;n+=1){i=e[n].test(g.className);if(!i){break}}if(i){h.push(g)}}return h}}return getElementsByClassName(a,b,c)},
            dropdowns = document.getElementsByTagName( 'select' );
        for ( i=0; i<dropdowns.length; i++ )
            if ( dropdowns[i].className.match( '<?php echo apply_filters( 'dropdown_menus_class', 'dropdown-menu' ); ?>' ) ) dropdowns[i].onchange = function(){ if ( this.value != '' ) window.location.href = this.value; }
    </script>
    <?php
}


/**
 * Overrides the walker argument and container argument then calls wp_nav_menu
 */
function dropdown_menu( $args ) {
    // if non array supplied use as theme location
    if ( ! is_array( $args ) )
        $args = array( 'menu' => $args );

    // enforce these arguments so it actually works
    $args[ 'walker' ] = new DropDown_Nav_Menu();
    $args[ 'items_wrap' ] = '<select id="%1$s" class="%2$s ' . apply_filters( 'dropdown_menus_class', 'dropdown-menu' ) . '">%3$s</select>';

    // custom args for controlling indentation of sub menu items
    $args[ 'indent_string' ] = isset( $args[ 'indent_string' ] ) ? $args[ 'indent_string' ] : '&ndash;&nbsp;';
    $args[ 'indent_after' ] =  isset( $args[ 'indent_after' ] ) ? $args[ 'indent_after' ] : '';

    return wp_nav_menu( $args );
}


class DropDown_Nav_Menu extends Walker_Nav_Menu {

    // easy way to check it's this walker we're using to mod the output
    function is_dropdown() {
        return true;
    }

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth ) {
        $output .= "</option>";
    }

    /**
     * @see Walker::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function end_lvl( &$output, $depth ) {
        $output .= "<option>";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    function start_el( &$output, $item, $depth, $args ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'menu-item-depth-' . $depth;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_unique( array_filter( $classes ) ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        // select current item
        if ( apply_filters( 'dropdown_menus_select_current', true ) )
            $selected = in_array( 'current-menu-item', $classes ) ? ' selected="selected"' : '';

        $output .= $indent . '<option' . $class_names .' value="'. $item->url .'"'. $selected .'>';

        // push sub-menu items in as we can't nest optgroups
        $indent_string = str_repeat( apply_filters( 'dropdown_menus_indent_string', $args->indent_string, $item, $depth, $args ), ( $depth ) ? $depth : 0 );
        $indent_string .= !empty( $indent_string ) ? apply_filters( 'dropdown_menus_indent_after', $args->indent_after, $item, $depth, $args ) : '';

        $item_output = $args->before . $indent_string;
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_dropdown_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * @see Walker::end_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     */
    function end_el( &$output, $item, $depth ) {
        $output .= apply_filters( 'walker_nav_menu_dropdown_end_el', "</option>\n", $item, $depth);
    }
}

}


/**
 * Check if shortcodes are enabled
 * @todo check if is not hangar page
 */
function tdp_hangar_shortcodes_check() {
    if(!function_exists('hangar_accordion')) {
    ?>
    <div class="updated">
        <p><?php _e( 'The theme requires the "Hangar Shortcodes Pack" module to be enabled. Please navigate to <a href="'.admin_url('admin.php?page=hangar').'">Hangar"</a> and enable the shortcodes pack module.', 'framework' ); ?></p>
    </div>
    <?php }
}
add_action( 'admin_notices', 'tdp_hangar_shortcodes_check' );

?>