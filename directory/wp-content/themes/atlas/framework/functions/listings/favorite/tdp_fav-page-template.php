<h2><i class="icon-star"></i> <?php _e('Favorites','atlas');?></h2>

<table class="shop_table sf-table striped_bordered">
    <thead>
        <tr>
            <th scope="col"><?php _e('Listing Name','atlas');?></th>
            <th scope="col"><?php _e('Actions','atlas');?></th>
        </tr>
    </thead>
    <tbody>
        <?php

            if ($favorite_post_ids):
                
                $array = array_reverse($favorite_post_ids);

                $post_per_page = 999;
                $page = intval(get_query_var('paged'));

                query_posts(array('post_type' => 'listing', 'post__in' => $array, 'posts_per_page'=> 999, 'orderby' => 'post__in', 'paged' => $page));

                while ( have_posts() ) : the_post(); ?>
                    
                    <tr>
                        <td>
                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                        </td>
                        <td>
                            <?php tdp_fav_remove_favorite_link(get_the_ID()); ?>
                        </td>
                    </tr>
               <?php endwhile;

                wp_reset_query();
            else:
                echo '<tr><td>'.__('No Favorites Yet','atlas').'</td></tr>';
            endif;

        ?>

    </tbody>
</table>

<?php echo tdp_fav_cookie_warning(); ?>


