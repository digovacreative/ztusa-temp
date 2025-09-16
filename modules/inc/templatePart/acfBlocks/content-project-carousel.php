<?php 
/**
 * Block Name: Featured Carousel
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
  <section class="featured__slider_carousel <?php the_field('fixed_background_colour'); ?>">

    <div class="carousel__wrapper">
          
          <?php 
          $post_types = get_field('fixed_post_type');
          $number_of_items = get_field('fixed_number_of_items_top');
          
          if(get_field('fixed_post_type')==='product'):
              $tags = get_field('fixed_tag');
          else:
              $tags = get_field('fixed_tag_news');
          endif;

          $news_carousel_args = array(
              'post_type' => $post_types, // required
              'orderby' => 'date', 
              'order' => 'DESC', 
              'posts_per_page' => $number_of_items,
              'tax_query' => array(
                  'relation' => 'AND',
                  array(
                      'taxonomy' => (get_field('fixed_post_type')==='product') ? 'product_tag' : 'post_tag',
                      'field'    => 'term_id',
                      'terms'    => $tags,
                      'operator' => 'IN'
                  )
              )
          );
          
          ?>  
              <div class="featured__slider_heading <?php the_field('fixed_post_type'); ?>">
                  <h4 class="watermark__heading"><?php the_field('fixed_second_heading'); ?></h4>
                  <div class="caption__wrap">
                      <h2 class="aos-item" data-aos="fade-up"><?php the_field('fixed_first_heading'); ?></h2>
                  </div>
              </div>
          
              <div class="featured__slider_<?php the_field('fixed_post_type'); ?>" id="carousel_featured__slider">
              <?php
              $news_carousel_query = new WP_Query( $news_carousel_args );
              if ( $news_carousel_query->have_posts() ) {
                  while($news_carousel_query->have_posts()) {
                    
                  $news_carousel_query->the_post();
                  global $post;
                  ?>
                  <div class="item_box aos-item" data-aos="fade-up">
                    
                      <figure>
                          <?php if(get_field('fixed_post_type') === 'product'): ?>  
                          <h3 class="post__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="<?php if(get_field('product_colour',$post->ID)): the_field('product_colour',$post->ID); endif; ?>">
                              <?php the_title(); ?>
                              <svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg>
                              </a>
                          </h3>
                          <?php endif; ?>
                          
                          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                              <?php if(get_post_thumbnail_id($post->ID)):
                              $post_bg_image_id = get_post_thumbnail_id( $post->ID);
                              if(get_field('fixed_post_type') === 'product'):
                                $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true);
                              else:
                                $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 400, true);
                              endif;
                              ?>
                              <img src="<?php echo $post_bg_image['url']; ?>" alt="<?php the_title(); ?>">
                              <?php endif; ?>  
                          </a>
                      </figure>

                      <?php if(get_field('fixed_post_type') === 'post'): ?>  
                      <div class="post__excerpt">
                        <span class="post__date"><?php echo get_the_time("d M Y"); ?></span>
                        <h3 class="post__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="<?php if(get_field('product_colour',$post->ID)): the_field('product_colour',$post->ID); endif; ?>">
                            <?php the_title(); ?>
                        </h3>
                        <a href="<?php the_permalink(); ?>" class="cta__icon">
                          Read More
                          <svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg>
                        </a>
                      </div>
                      <?php endif; ?>  

                  </div>
                  <?php 
                  }
              } wp_reset_query(); ?>
              </div><!-- end first carousel sync -->


    
    </div><!-- end Carousel Wrapper -->
  </section>
</div>

<script type="text/javascript">

<?php if(get_field('fixed_post_type') === 'product'): ?>
  jQuery('.featured__slider_product').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  dots: true, 
  fade: true,
  centerMode: true,
  arrows: false,
  autoplay: true,
  autoplaySpeed: 2000,
  centerPadding: '50',
  mobileFirst:true,
  variableWidth: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});
<?php endif; ?>

<?php if(get_field('fixed_post_type') === 'post'): ?>
  jQuery('.featured__slider_post').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  dots: true,
  centerMode: false,
  centerPadding: '0',
  arrows: false,
  responsive: [
      {
      breakpoint: 1800,
      settings: {
          slidesToShow: 4,
          slidesToScroll: 1
      }
      },
      {
      breakpoint: 1500,
      settings: {
          slidesToShow: 3,
          slidesToScroll: 1
      }
      },
      {
      breakpoint: 1200,
      settings: {
          slidesToShow: 3,
          slidesToScroll: 1
      }
      },
      {
      breakpoint: 768,
      settings: {
          slidesToShow: 1,
          slidesToScroll: 1
      }
      },
      {
      breakpoint: 400,
      settings: {
          slidesToShow: 1,
          slidesToScroll: 1
      }
      },
      
  ]
});
<?php endif; ?>

</script>
