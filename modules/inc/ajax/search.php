<?php
function tum_search_post_function(){

	$page = $_POST['pageNumber'];
	$ppp = 8*$page;
  	$post_type = $_POST['tum_post_type'];
	$searchQuery = $_POST['s'];

    $argsSearch = array(
			'post_type' => explode(',',$post_type),
            'post_status' => 'publish',
			'order' => 'DESC',
            'orderby' => 'date',
            's' => $searchQuery,
			'posts_per_page' => $ppp
        ); 
        
        // echo '<pre>';
        // print_r($argsSearch);
        // echo '</pre>';    
        
    ?>
    <?php
    $query_listing_search = new WP_Query( $argsSearch ); 
    while($query_listing_search->have_posts()) : $query_listing_search->the_post(); 
    $post = get_post(); ?>

    <div class="search__item">
        <figure>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php if(get_post_thumbnail_id($post->ID)):
                $post_bg_image_id = get_post_thumbnail_id( $post->ID);
                $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true);
                ?>
                <img src="<?php echo $post_bg_image['url']; ?>" alt="<?php the_title(); ?>">
                <?php else: ?>
                <span class="image__placeholder"></span>
                <?php endif; ?>
            </a>
        </figure>
        <div class="search__text">
            <span class="posttype"><?php $postType = get_post_type(); if($postType === 'product'){  echo 'project'; }else{ echo $postType; } ?></span>
            <h3 class="post__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
        </div>
    </div>


    <?php  endwhile; wp_reset_query(); 

    //Get all pages and check if on last page, if on last page disable the load more button
	$current_page = $query_listing_search->get( 'paged' );
	if (! $current_page ) {
			$current_page = 1;
	}
    
    if ( $current_page == $query_listing_search->max_num_pages ) { ?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('#more_articles').addClass('disabledButton');
		});
		</script>
	<?php  }else{ ?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('#more_articles').removeClass('disabledButton');
		});
		</script>
	<?php }

die();

}
add_action('ZTRUST_AJAX_postsearch', 'tum_search_post_function');
add_action('ZTRUST_AJAX_nopriv_postsearch', 'tum_search_post_function');
?>
