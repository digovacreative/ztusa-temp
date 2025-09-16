<?php 
/**
 * Block Name: Stats Carousel
 */ 
global $post;
global $location_block;
?>

<div class="gutenberg__wrap">
  <section class="stats__slider_carousel">

    <div class="stats__carousel medium_box" id="carousel__stats_scroller">

    <?php while(has_sub_field('stats_slider')): ?>	
      <div class="item_box aos-item" data-aos="fade-up">
          <h2><?php the_sub_field('stat_heading'); ?></h2>
          <p><?php the_sub_field('stat_content'); ?></p>
      </div>
    <?php endwhile; ?>
    
    </div><!-- end first carousel sync -->
    
  </section>
</div>

<script type="text/javascript">
jQuery('#carousel__stats_scroller').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  dots: true,
  //infinite: true,
  centerMode: true,
  centerPadding: '0',
  arrows: true,
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
        slidesToShow: 2,
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
</script>
