<?php get_header(); ?>
<?php while(have_posts()) : the_post(); $post = get_post(); ?>

<div class="gutenberg__wrap">
	<section class="homepage__slider_carousel large white_text">

		<div class="main__carousel" id="carousel__main_scroller">
        
      <?php 
      $post_bg_image_id = get_post_thumbnail_id( $post->ID);
      $banner_image = vt_resize($post_bg_image_id,'' , 2000, 1500, false);
      ?>
			<div class="item_box no_button" style="background:url('<?php echo $banner_image['url']; ?>');">
				<div class="caption__bg left black"></div>
				<div class="large_box">
					<div class="caption left"> 
						<h1 class="aos-item" data-aos="fade-up" data-aos-delay="450"><?php echo get_the_title($post->ID); ?></h1>
						<h3 class="aos-item" data-aos="fade-up" data-aos-delay="550"></h3>						
					</div>
				</div>
            </div>
            
		</div><!-- end first carousel sync -->
		

    </section>
    
    <div class="banner_quick_donation_banner_box">

		<div class="donation__box">
			
			<div class="quick_donation_banner_container">
				<h3>Donate Now</h3>	
        <?php
        // if($post->ID == 7692):
        //   echo '<img style="margin:0 auto;" src="/wp-content/uploads/2020/05/icon-hazara.jpg" />';
        // endif;
        ?>
				<div id="quick_donation_banner">
					<p><span><svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"></rect></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "></polygon></g></svg></span> Select a fund</p>
				</div>

			</div>
		</div>	
	
    </div>
    
</div>


<?php 

/* 
<div class="gutenberg__wrap">
  <section class="featured__slider_carousel till">

    <div class="carousel__wrapper">
          
          <?php 
          $number_of_items = '10';
          
          $terms = wp_get_post_terms( $post->ID, 'product_cat');
          $term_id_related = $terms[0]->term_id;
          // print_r($terms); #displays the output

          // $current_cat_id = $wp_query->get_queried_object()->term_id;
          // echo $current_cat_id;
          // $cate = get_queried_object();
          // $cateID = $cate->term_id;
          // echo $cateID;


          $news_carousel_args = array(
              'post_type' => 'product', // required
              'orderby' => 'date', 
              'order' => 'DESC', 
              'posts_per_page' => $number_of_items,
              'tax_query' => array(
                  'relation' => 'AND',
                  array(
                      'taxonomy' => 'product_cat',
                      'field'    => 'term_id',
                      'terms'    =>  $term_id_related,
                      'operator' => 'IN'
                  )
              )
          );
          
          ?>  
              <div class="featured__slider_heading product">
                  <h4 class="watermark__heading">Related</h4>
                  <div class="caption__wrap">
                      <h2 class="aos-item" data-aos="fade-up">Related Projects</h2>
                  </div>
              </div>
          
              <div class="featured__slider_product" id="carousel_featured__slider">
              <?php
              $news_carousel_query = new WP_Query( $news_carousel_args );
              if ( $news_carousel_query->have_posts() ) {
                  while($news_carousel_query->have_posts()) {
                    
                  $news_carousel_query->the_post();
                  global $post;
                  ?>
                  <div class="item_box aos-item" data-aos="fade-up">
                    
                      <figure>
                          <h3 class="post__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="<?php if(get_field('product_colour',$post->ID)): the_field('product_colour',$post->ID); endif; ?>">
                              <?php the_title(); ?>
                              <svg enable-background="new 0 0 32 32" id="svg2" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="arrow_x5F_full_x5F_right"><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16  "/></g></svg>
                              </a>
                          </h3>
                          
                          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                              <?php if(get_post_thumbnail_id($post->ID)):
                              $post_bg_image_id = get_post_thumbnail_id( $post->ID);
                              $post_bg_image = vt_resize($post_bg_image_id,'' , 500, 500, true);
                              ?>
                              <img src="<?php echo $post_bg_image['url']; ?>" alt="<?php the_title(); ?>">
                              <?php endif; ?>  
                          </a>
                      </figure>

                  </div>
                  <?php 
                  }
              } wp_reset_query(); ?>
              </div><!-- end first carousel sync -->


    
    </div><!-- end Carousel Wrapper -->
  </section>
</div>


*/
?>

<script type="text/javascript">


/*
jQuery('.featured__slider_product').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: true,
    fade: false,
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

*/

jQuery('#carousel__main_scroller').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  fade: false,
  centerMode: true,
  centerPadding: '0',
  arrows: false,
});



function load_the_banner_project_quickdonate($project_id){
	console.log($project_id);
	jQuery.ajax({
		url:  $ajaxurl,
		data: 'action=loadproject&project_id='+$project_id,
		type: 'POST',
		beforeSend:function(xhr){
			// ajax_before();
		},
		success:function(data){
			// ajax_after();
			jQuery('#quick_donation_banner').addClass('active');
			jQuery('#quick_donation_banner').html(data);
		}

	});
	return false;
}

jQuery(function () {
	jQuery("select.select_project_name_banner").change();
});

jQuery('.select_project_name_banner').change( function(event){ 
	var productID = jQuery(this).val();
	console.log(productID);
	load_the_banner_project_quickdonate(productID);
	event.preventDefault();
});

jQuery( document ).ready(function() {
//Onload select the only item
    load_the_banner_project_quickdonate(<?php echo $post->ID; ?>);
});

</script>


<?php 
endwhile;
get_footer(); ?>
