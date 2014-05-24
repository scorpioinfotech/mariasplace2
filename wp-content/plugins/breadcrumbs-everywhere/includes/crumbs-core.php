<?php
/**
 *
 * Breadcrumbs Everywhere Notes & Knowns:
 *
 * - Trails to Level 5 Actions (i.e. Home > Members > Admin > Messages > Sent) are in commented code. 
 * - The current item is not linked by default. However, you are welcome to change that.
 * - The current item is not styled (bold, italics, etc.) by default. You can change that, too.
 *
 * ---- HOW TO USE ----
 * 
 * Add this function anywhere in your BuddyPress template, typically in header.php:
 * <?php if (function_exists('breadcrumbs_everywhere')) breadcrumbs_everywhere(); ?>
 * That's it!
 * 
 * Theme developers: You may adapt this plugin as needed. However, if you modify the core files your 
 * changes will be overwritten by future plugin updates. Instead, copy the entire function here, paste it 
 * into your theme's function.php file, and make your edits. Then, reference the function as in Step 1 above.  	
 *
 * JUST BE HAPPY IT WORKS
*/

/**
 * Exit if accessed directly.
 */
if ( !defined( 'ABSPATH' ) ) exit;

// Begin...	if you customize copy everything below this line
//------------------------------------------------------------	  
function breadcrumbs_everywhere() {

	global $bp; // we're outside the loop!
		
	// Assign some variables here		
	$page1 = $bp->members->root_slug; // slug for the Members page. The BuddyPress default is 'members'. 
	$page2 = $bp->groups->root_slug; // slug for the Groups page. The BuddyPress default is 'groups'.	
	$page3 = $bp->activity->root_slug; // slug for the Activity page. The BuddyPress default is 'activity'.	
	$page4 = $bp->forums->root_slug; // slug for the Forums page. The BuddyPress default is 'forums'.
	$page5 = isset($bp->achievements->root_slug); // slug for the Achievements page. The BuddyPress default is 'achievements'.
	$divider_sub = '&nbsp;&gt;&nbsp;';
	$homeurl = get_bloginfo('url');
	$schema1 = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
	$schema2 = '<span itemprop="title">';
	$title = get_the_title();
	
	// Get the text for the Home link. Matches $setting_one in crumbs-admin.php
	$home = get_option('crumbs-setting-one');
	if ( '' == $home && option_value!= null ) {
					$home =  __( 'Home', 'breadcrumbs-everywhere' ); // if this is not set in Plugin Settings then default
					}
					
	// Get the text for the Blog link. Matches $setting_two in crumbs-admin.php 				
	$blog = get_option('crumbs-setting-two');
	if ( '' == $blog && option_value!= null ) {
					$blog =  __( 'Blog', 'breadcrumbs-everywhere' ); // if this is not set in Plugin Settings then default
					}				
		
	// Get the entity for the divider. Matches $setting_three in crumbs-admin.php
	// @since 1.5 add divider spaces here 
	$divider = '&nbsp;' . get_option('crumbs-setting-three') . '&nbsp;';	
	if ( '' == $divider && option_value!= null ) {
					$divider =  __( '&raquo;', 'breadcrumbs-everywhere' ); // if this is not set in Plugin Settings then default
					}
							
	// @since 1.2
	// Set starting links for posts on home vs static home page		
	$startpages = $schema1 . '<a href="' . $homeurl . '" title="' . $home . '" itemprop="url">' . $schema2 . $home . '</span></a></span>'; // all pages
	$front = get_option('show_on_front'); 
	if ( $front == "page" ) { // page on home					
		$startchain = $startpages . $divider . $schema1 . '<a href="' . get_permalink( get_option('page_for_posts') ) . '" title="' . $blog . '" itemprop="url">' . $schema2 . $blog . '</span></a></span>';		
	} else { // posts on home			
		$startchain = $startpages;
	}
		
// ==================== First, some crumbs for BuddyPress ====================
 
		/**
		* Show on BuddyPress Home page. If you want breadcrumbs on your Home page, uncomment this section.
		*
		* if ( is_front_page() ) :
		* echo $startpages;
		* endif;
		*/

		/**
		* Show breadcrumbs on all profile components.
		*
		* @since 1.6 - added $title attr, $fullname var
		* @since 1.5 - added microdata 
		* @since 1.4 - added ucwords() for title case. 
		* @since 1.3 - changed bp_has_profile() to bp_is_user()
		* @since 1.2 - added !bp_is_register_page()
		*/
		if ( bp_is_user() && !bp_is_register_page() ) :
		$fullname = ucwords( $bp->displayed_user->fullname );
		echo $startpages . $divider . $schema1 . '<a href="' . $homeurl . '/' . $page1 . '" title="' . $title . '" itemprop="url">' . $schema2 . ucwords( $page1 ) . '</span></a></span>' . $divider . $schema1 . '<a href="' . $bp->displayed_user->domain . '" title="' . $fullname . '" itemprop="url">' . $schema2 . $fullname . '</span></a></span>' . $divider . $schema1 . $schema2 . ucwords( $bp->current_component ) . '</span></span>';		
		endif;
		
		/**
		* For Level 5. If you want Action breadcrumbs, uncomment and use this section instead. 
		*
		* if ( bp_is_user() && !bp_is_register_page() ) :
		* echo $startpages . $divider . $schema1 . '<a href="' . $homeurl . '/' . $page1 . '" title="' . $title . '" itemprop="url">' . $schema2 . ucwords( $page1 ) . '</span></a></span>' . $divider . $schema1 . '<a href="' . $bp->displayed_user->domain . '" title="' . $fullname . '" itemprop="url">' . $schema2 . $fullname . '</span></a></span>' . $divider . $schema1 . '<a href="' . $bp->displayed_user->domain . $bp->current_component . '" title="' . ucwords( $bp->current_component ) . '" itemprop="url">' . $schema2 . ucwords( $bp->current_component )  . '</span></a></span>' . $divider_sub . $schema1 . $schema2 . ucwords( $bp->current_action ) . '</span></span>';
		* endif;
		*/
		
		/**
		* Show on all pages to catch top-level add-ons.
		* 
		* Explanation from @boone:					
		* - Since BP 1.5, BuddyPress uses WP Pages to display content. 
		* - To exclude BP content: is_page() && !bp_is_blog_page()
		* - Show on BP content except on user pages: is_page() && !bp_is_user()
		* @link http://wordpress.stackexchange.com/a/45438
		* 
		* @since 1.3
		*   - changed bp_has_profile() to bp_is_user()
		*   - added !bp_is_register_page()
		* @since 1.2 
		*   - added is_page() 
		*/						
		if ( !bp_is_blog_page() && ( is_page() || is_page( $page1 ) || is_page( $page2 ) || is_page( $page3 ) || is_page( $page4 ) || is_page( $page5 ) ) && !bp_is_user() && !bp_is_single_item() && !bp_is_register_page() ) :
		echo $startpages . $divider . $schema1 . '<a href="' . get_permalink() . '" title="' . $title . '" itemprop="url">' . $schema2 . $title . '</span></a></span>';
		endif;
		
		/**
		* Show on Register page.
		* 
		* @since 1.2
		*/
		if ( bp_is_register_page() ) :
		echo $startpages . $divider . $schema1 . $schema2 . $title . '</span></span>';
		endif;

		/**
		* Show on Blog page (but don't show if Blog is Home Page).
		* 
		* @since 1.2
		*/
		if ( bp_is_blog_page() && is_home() && $front == "page" ) :
		echo $startpages . $divider . $schema1 . '<a href="' . get_permalink( get_option('page_for_posts') ) . '" title="' . $blog . '" itemprop="url">' . $schema2 . $blog . '</span></a></span>';
		endif;
		
		/**
		* Is it paged AND a BuddyPress blog?
		* 
		* @since 1.1
		*/
    	if ( get_query_var('paged') ) {
				if ( bp_is_blog_page() && !(is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) )
				echo ' (' . __( 'Page', 'breadcrumbs-everywhere' ) . ' ' . get_query_var('paged') . ')';
				}
		
		/**
		* Show on Group Directory & Sub Pages.
		* 
		* There's always more than one way to do something. Here are some alts if you customize:
		* - alt use bp_groups_directory_permalink() or bp_get_groups_slug()
		* - alt use $bp->groups->current_group->slug or $bp->groups->current_group->name
		* - alt use if ( bp_is_group() && bp_is_single_item() )
		* - $bp->current_component is tricky, test well!	
		* 
		*/
		if ( !bp_is_blog_page() && ( is_page( $page1 ) || is_page( $page2 ) || is_page( $page3 ) || is_page( $page4 ) || is_page( $page5 ) ) && bp_is_single_item() ) :	
			
			//get Level 5 Group actions, break the array
			$groupaction = $bp->action_variables;
			foreach ( $groupaction as $groupactions ) {
			}
			
			// @since 1.1
			// Add BP Group Hierarchy compatibility  --------------------------
			
			//get group parents
			$the_post_id = $bp->groups->current_group->id;
			$groupname = $bp->groups->current_group->name;
			$myparent = $bp->groups->current_group->parent_id;

				// Let's set up a function to convert the WP url 
				function ucwords_custom( $str, $separator ){
      				$str = str_replace( $separator, " ", $str ); 
      				$str = ucwords( strtolower( $str ) ); // change to sentence case
      				return $str;
					}
					
			// parse the URL to get the group hierarchy
			$url = $_SERVER['REQUEST_URI'];
			$parsed_url = parse_url( $url );
			$folder = explode( '/',$parsed_url['path'] );
			$lastaction = $bp->current_action; // what's the current BP action?
			$end = basename( $parsed_url['path'] ); // what's the last folder?
			$domain = $homeurl;
			$crumbs = array_filter( $folder );
			$sep = $divider;
			$result = array(); 
			$chain = '';
			$count = count( $crumbs );
			$endofchain = ( strtolower( $end ) !== strtolower( $lastaction ) ) &&  null == $groupaction;
			foreach( $crumbs as $key => $crumb ){
     				$chain .= '/' . $crumb;
     				$subfolder = ucwords_custom( $crumb, "-" );
     			if( $key != $count ){
         			$result[] = $schema1 . '<a href="' . $domain . $chain . '" title="' . $subfolder . '" itemprop="url">' . $schema2 . $subfolder . '</span></a></span>';
				} elseif ( $endofchain ) {
					$result[] = $schema1 . '<a href="' . $domain . $chain . '" title="' . $subfolder . '" itemprop="url">' . $schema2 . $subfolder . '</span></a></span>';						
     			} else {
         			$result[] = $subfolder;
     			}
			}
							
				if ( $endofchain ) { // then we're at the last group in the chain
				/* Explanation: 					
					* need to add the default BP action "Home" to the end of the chain
					* but NOT if Home has been clicked in the sub-nav 
					* and NOT on Level 5 actions since they're part of the chain
					*
					* @since 1.5 ucwords_custom on $lastaction
					*/	
				
					echo $startpages . $divider . implode( $sep , $result ) .  $divider . $schema1 . $schema2 . ucwords_custom( $lastaction, "" ) . '</span></span>';
				
				} else { // then we're somewhere else in the chain or this is a base BP install
					
					//** For Level 5 
					echo $startpages . $divider . implode( $sep , $result );
				}
						
			endif;
			// -----------------------------------------			
		
		
// ==================== Second, some crumbs for WordPress ====================		

		// Show on WordPress

 		if ( !(function_exists('bp_is_blog_page') && !bp_is_blog_page()) ) { // this line excludes content from BuddyPress pages 
		
		global $post;   // we're outside the loop!
		$id = get_the_ID(); // @since 1.6
	
		/**
		* Show on WordPress Home page. If you want breadcrumbs on your Home page, uncomment this section.
		*
		* if ( is_front_page() ) :
		* echo $startpages;
		* endif;
		*/
			
		// Show on Blog posts	
		if ( is_single() && !is_attachment() ) :
			if ( get_post_type() != 'post' ) {
			echo $startchain . $divider . $schema1 . $schema2 . $title . '</span></span>';
			} else {
			$cat = get_the_category();
			$cat = $cat[0];
			echo $startchain . $divider . $schema1 . $schema2 . get_category_parents( $cat, true, $divider ) . '</span></span>'. $schema1 . $schema2 . $title . '</span></span>'; // shows post title, edit as needed
			}	
		endif;		
		
		/**
		* Show on attachments.
		* 
		* @since 1.1
		*/
		if ( is_attachment() && !is_page() ) { // for posts
			$parent = get_post( $post->post_parent );
			$cat = get_the_category( $parent->ID );
			$cat = $cat[0];
			$parent_link = get_permalink( $parent );
			$parent_title = $parent->post_title;
			echo $startchain . $divider . $schema1 . $schema2 . get_category_parents( $cat, true, $divider ) . '</span></span>' . $schema1 . '<a href="' . $parent_link . '" title="' . $parent_title . '" itemprop="url">' . $schema2 . $parent_title . '</span></a></span>' . $divider . $schema1 . $schema2 . $title . '</span></span>';
		} elseif ( is_attachment() && is_page() ){ // for pages
				$ancestors = array_reverse( get_post_ancestors( $post ) ); // reverse the display order
				echo $startpages . $divider;
					foreach( $ancestors as $id ) {
                		echo $schema1 . '<a href="' . get_permalink( $id ) . '" title="' . $title . '" itemprop="url">' . $schema2 . $title . '</span></a></span>' . $divider;
					}	
				echo $schema1 . $schema2 . $title . '</span></span>';
		}
			
		
		// begin conditionals
		
		// v1.1 added !is_attachment()		
		if ( !is_home() && !is_front_page() && !is_attachment() || is_paged() ) {
		
			// Show on Pages

			if ( is_page() && $post->post_parent ) {
   		 		// This is a subpage
				$parent_id = get_post( $id );
				$parent_title = get_the_title( $parent_id->post_parent );
			 	echo $startpages . $divider . $schema1 . '<a href="' . get_permalink( get_page_by_title( $parent_title ) ) . '" title="' . $parent_title . '" itemprop="url">' . $schema2 . $parent_title . '</span></a></span>' . $divider . $schema1 . '<a href="' . get_permalink() . '" title="' . $title . '" itemprop="url">' . $schema2 . $title . '</span></a></span>';

				} elseif ( is_page() ) {
   	 			// This is not a subpage
	 			echo $startpages . $divider . $schema1 . '<a href="' . get_permalink() . '" title="' . $title . '" itemprop="url">' . $schema2. $title . '</span></a></span>';
			}
	

			// Show on Archive pages for Categories and Tags
						
			function crumb_get_category_parents( $id, $link = false, $divider = ' ' ) {
			// This function is modified from wp-includes\category-template.php
					$chain = ' ';
					$parent = &get_category( $id );
					if ( is_wp_error( $parent ) )

						return $parent;
						$name = $parent->name;
					
					if ( $parent->parent && ( $parent->parent != $parent->term_id ) ) {
						$chain .= get_category_parents( $parent->parent, true, $divider );
					}

					if ( $link )
						$chain .= $name . " ";
					else
						$chain .= $name.$divider;
					return $chain;			
				}
				
					if ( is_category() || is_tag() ) {
						// attempt to get the category ancestors
						$cat = get_query_var('cat');
						$termcat = get_term($cat,'category');
						$parent = &get_category( $id );
						$termid = get_term_by('id', $parent, 'category');
						$parent_name = get_category_link( $termid);
					if ( $termid == 0 ) {
							// This category is a parent
							echo $startchain . $divider . $schema1 . $schema2 . ucwords( single_cat_title( "", false ) ) . '</span></span>';
					} else {
							// This is a sub-category and it does have a parent						
							echo $startchain . $divider . crumb_get_category_parents( $cat, true, $divider );
						}
					unset($termcat);
 					 		
 
    			} elseif ( is_day() ) {
     			echo $startchain . $divider . $schema1 . '<a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '" itemprop="url">' . $schema2 . get_the_time('Y') . '</span></a></span>' . $divider;
      			echo $startchain . $divider . $schema1 . '<a href="' . get_month_link( get_the_time('Y'),get_the_time('m') ) . '" title="' . get_the_time('F') . '" itemprop="url">' . $schema2 . get_the_time('F') . '</span></a></span>' . $divider;
      			echo $schema1 . $schema2 . get_the_time('d') . '</span></span>';
 
    			} elseif ( is_month() ) {
      			echo $startchain . $divider . $schema1 . '<a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '" itemprop="url">' . $schema2 . get_the_time('Y') . '</span></a></span>' . $divider;
      			echo $schema1 . $schema2 . get_the_time('F') . '</span></span>';
 
    			} elseif ( is_year() ) {
     	 		echo $startchain . $divider . $schema1 . $schema2 . get_the_time('Y') . '</span></span>';

	    		} else { 
    		}
			
				/**
				* Is it paged?
				* 
				* @since 1.1
				*/
    			if ( get_query_var('paged') ) {
     				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo ' (' . __( 'Page', 'breadcrumbs-everywhere' ) . ' ' . get_query_var('paged') . ')';
					}
 
  		} // end conditionals

	} // end bp_is_blog_page

} // end breadcrumbs_everywhere() 
?>