
<div class="gutenberg__wrap related_items_wrap clearfix">
    <section class="featured__slider_carousel">

        <div class="carousel__wrapper">
            
            <?php 
            $post_types = array('news','video','podcast');
            $number_of_items = '10';
            
            global $postID;

            $product_terms = get_the_terms( $postID, 'post_tag' );
            if($product_terms && !is_wp_error( $product_terms )){
                @usort( $product_terms, function ( $a, $b ){
                return strcasecmp(
                    $a->slug,
                    $b->slug
                );
                });
                $term_list = [];
                foreach ( $product_terms as $term )
                    $term_list[] = esc_html( $term->slug );
                $tags_list = implode( ', ', $term_list );
            }


            $news_carousel_args = array(
                'post_type' => $post_types, // required
                'orderby' => 'date', 
                'order' => 'DESC', 
                'posts_per_page' => $number_of_items,
                'tag' => $tags_list,
                'tax_query' => array(
                    'relation' => 'AND',
                )
            );
            
            // if(get_field('featured_category')){
            //     $taxonomies = get_field('featured_category');
            //     array_push( 
            //         $news_carousel_args['tax_query'],
            //         array(
            //             'taxonomy' => 'category',
            //             'field'    => 'term_id',
            //             'terms'    => $taxonomies,
            //             'operator' => 'IN'
            //         )
            //         );
            // }
            
           
            // array_push( 
            //     $news_carousel_args['tax_query'],
            //     array(
            //         'taxonomy' => 'post_tag',
            //         'field'    => 'term_id',
            //         'terms'    => $tags_list,
            //         'operator' => 'IN'
            //     )
            // );
            ?>  
                <div class="featured__slider_heading">
                    <h4 class="watermark__heading">Related Articles</h4>
                    <div class="caption__wrap">
                        <h2>Related Articles</h2>
                    </div>
                </div>
            
                <div class="featured__slider owl-carousel owl-theme" id="carousel_featured__slider">
                <?php
                $news_carousel_query = new WP_Query( $news_carousel_args );
                if ( $news_carousel_query->have_posts() ) {
                    while($news_carousel_query->have_posts()) {
                    $news_carousel_query->the_post();
                    global $post;
                    ?>
                    <div class="item_box " style="width:320px;">
                        
                    
                            <figure>
                                <h3 class="post__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php if(get_post_thumbnail_id($post->ID)):
                                    $post_bg_image_id = get_post_thumbnail_id( $post->ID);
                                    $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true);
                                    ?>
                                    <img src="<?php echo $post_bg_image['url']; ?>" alt="<?php the_title(); ?>">
                                    <?php else: ?>
                                        <?php if(get_post_type() === 'video'): 
                                            $post_image_url = 'https://img.youtube.com/vi/'.get_field('youtube_id',$post->ID).'/maxresdefault.jpg';
                                            $post_bg_image_id = get_field('blank_image','options');
                                            $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true); ?>
                                            <div class="video__image" style="background:url('<?php echo $post_image_url; ?>') center center;"></div>
                                            <img src="<?php echo $post_image_url; ?>" class="youtube__video_thumb" alt="<?php the_title(); ?>">
                                        <?php endif; ?>
                                    <?php endif; ?>  
                                </a>
                            </figure>
                            <?php if(has_excerpt()){ ?>
                            <div class="post__excerpt">
                                <span class="post__date"><?php echo get_the_time("d M Y"); ?></span>
                                <?php the_excerpt(); ?>
                                <?php 
                                $author_id = get_post_field( 'post_author', $post->ID );
                                $author_first_name = get_the_author_meta('first_name', $author_id);
                                $author_last_name = get_the_author_meta('last_name', $author_id);
                                ?>
                                <!-- <strong class="post__author">By: <?php echo $author_first_name; echo '&nbsp;'; echo $author_last_name; ?></strong> -->
                            </div>
                            <?php } ?>

                    </div>
                    <?php 
                    }
                } wp_reset_query(); ?>
                </div><!-- end first carousel sync -->


        
        </div><!-- end Carousel Wrapper -->

    </section>
</div>

<script type="text/javascript">
  jQuery('.featured__slider').owlCarousel({
      loop:true,
      margin:10,
      //nav:true,
      autoWidth:true,
      dots: false,
      autoHeight:false,
      autoplay: true,
      //navText: ["",""],
      autoplayHoverPause: true,
      autoplayTimeout: 4000,
      autoplaySpeed: 900,
      items: 5,
      animateOut: 'fadeOut',
      stagePadding: -50,
  });
</script>
