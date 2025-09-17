<?php
/**
 * Block Name: Homepage Carousel
 * Safe/robust version
 */

defined('ABSPATH') || exit;

//
// Helpers
//
if ( ! function_exists('dm_media_to_url') ) {
    /**
     * Accepts ACF image field (array|ID|URL|string) and returns a URL or ''.
     */
    function dm_media_to_url( $val, $size = 'full' ) : string {
        if (empty($val)) return '';
        // ACF image array
        if (is_array($val)) {
            if (!empty($val['url'])) return esc_url($val['url']);
            if (!empty($val['ID']))  return esc_url(wp_get_attachment_image_url((int)$val['ID'], $size) ?: '');
        }
        // Numeric attachment ID
        if (is_numeric($val)) {
            return esc_url(wp_get_attachment_image_url((int)$val, $size) ?: '');
        }
        // Raw URL
        if (is_string($val) && filter_var($val, FILTER_VALIDATE_URL)) {
            return esc_url($val);
        }
        return '';
    }
}

$ajaxurl = get_stylesheet_directory_uri() . '/modules/inc/customajax.php'; // keep your existing endpoint
?>

<style>
/* slider height */
.gutenberg__wrap .homepage__slider_carousel.medium .main__carousel,
.gutenberg__wrap .homepage__slider_carousel.medium,
.gutenberg__wrap .homepage__slider_carousel.medium .main__carousel .item_box {
  height: auto !important;
  width: 100% !important;
  min-height: auto !important;
}

/* arrows */
.gutenberg__wrap .slick-prev, .gutenberg__wrap .slick-next {
  z-index: 999;
  height: auto; width: auto;
  background-color: rgba(0,0,0,.35);
  border-radius: 100%;
  padding: 3px;
}
.gutenberg__wrap .slick-prev { left: 25px; }
.gutenberg__wrap .slick-next { right: 25px; }
.gutenberg__wrap .slick-prev:before { content: "≪"; }
.gutenberg__wrap .slick-next:before { content: "≫"; }
.gutenberg__wrap .slick-next:before, .gutenberg__wrap .slick-prev:before {
  font-family: "slick";
  font-size: 2rem; line-height: 1;
  color: #fff; opacity: .9;
  -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;
  padding: 5px; border-radius: 100%;
}
.gutenberg__wrap .homepage__slider_carousel .main__carousel .item_box:before { display: none; }
</style>

<div class="gutenberg__wrap">
  <section class="homepage__slider_carousel medium <?php echo esc_attr( get_field('banner_style') ?: '' ); ?>">

    <div class="main__carousel" id="carousel__main_scroller">
      <?php if ( have_rows('banner_items') ) : ?>
        <?php while ( have_rows('banner_items') ) : the_row();
          // Prefer mobile image when a function named isMobile exists and returns true
          $use_mobile = function_exists('isMobile') ? (bool) isMobile() : wp_is_mobile();

          $img_mobile = get_sub_field('banner_image_mobile');
          $img_desktop = get_sub_field('banner_image');

          $chosen = $use_mobile && $img_mobile ? $img_mobile : $img_desktop;
          $banner_url = dm_media_to_url($chosen, 'full');

          // Button/link can be ACF Link array or plain URL
          $link_raw  = get_sub_field('button_link');
          $link_url  = '';
          $link_text = get_sub_field('button_label');
          if (is_array($link_raw)) {
              $link_url = isset($link_raw['url']) ? $link_raw['url'] : '';
              if (empty($link_text) && !empty($link_raw['title'])) $link_text = $link_raw['title'];
          } elseif (is_string($link_raw)) {
              $link_url = $link_raw;
          }
          $link_url = esc_url($link_url);

          $has_overlay = ( get_sub_field('banner_small_heading') || get_sub_field('banner_heading') || get_sub_field('banner_text') );
          $text_pos    = get_sub_field('text_position') ?: '';
          ?>
          <div class="item_wrap">
            <?php if ( $link_url ) : ?><a href="<?php echo $link_url; ?>"><?php endif; ?>

              <div
                class="item_box <?php echo $has_overlay ? 'has_overlay' : ''; ?> <?php echo empty($link_text) ? 'no_button' : ''; ?>"
                <?php if ($banner_url): ?>
                  style="background-image:url('<?php echo esc_url($banner_url); ?>'); background-size:contain!important; background-position:top center!important; background-repeat:no-repeat!important;"
                <?php endif; ?>
              >
                <div class="caption__bg <?php echo esc_attr($text_pos); ?>"></div>
                <div class="large_box">
                  <div class="caption <?php echo esc_attr($text_pos); ?>">
                    <?php if ($v = get_sub_field('banner_small_heading')): ?><h4><?php echo esc_html($v); ?></h4><?php endif; ?>
                    <?php if ($v = get_sub_field('banner_heading')):       ?><h1><?php echo esc_html($v); ?></h1><?php endif; ?>
                    <?php if ($v = get_sub_field('banner_text')):          ?><h3><?php echo esc_html($v); ?></h3><?php endif; ?>

                    <?php if ($link_text && $link_url): ?>
                      <a href="<?php echo $link_url; ?>" class="button border white">
                        <?php echo esc_html($link_text); ?>
                        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><g><rect fill="none" height="32" width="32"/></g><g><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16"/></g></svg>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <?php if ($banner_url): ?>
                <img src="<?php echo esc_url($banner_url); ?>" alt="" loading="lazy" />
              <?php endif; ?>

            <?php if ( $link_url ) : ?></a><?php endif; ?>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div><!-- /#carousel__main_scroller -->

  </section>

  <?php
  // Donation box (safe count/array checks)
  if ( get_field('enable_donation_box') ) :
      $proj = get_field('project_select');
      $proj = is_array($proj) ? array_values(array_filter($proj)) : [];
      $proj_count = count($proj);
  ?>
    <div class="banner_quick_donation_banner_box">
      <div class="donation__box">
        <div class="quick_donation_banner_container">
          <?php if ($v = get_field('homepage_donation_heading')): ?>
            <h3><?php echo esc_html($v); ?></h3>
          <?php endif; ?>

          <?php if ($v = get_field('mobile_text')):
              $is_mobile = function_exists('isMobile') ? (bool) isMobile() : wp_is_mobile();
              if ($is_mobile): ?>
                <p><?php echo wp_kses_post($v); ?></p>
          <?php endif; endif; ?>

          <?php if ( $proj_count !== 1 ): ?>
            <select class="select_project_name_banner">
              <option value="">Select a fund</option>
              <?php foreach ( $proj as $project_id ): ?>
                <option value="<?php echo esc_attr($project_id); ?>" data-project-id="<?php echo esc_attr($project_id); ?>">
                  <?php echo esc_html( get_the_title($project_id) ); ?>
                </option>
              <?php endforeach; ?>
            </select>
          <?php endif; ?>

          <div id="quick_donation_banner">
            <p><span><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><g><rect fill="none" height="32" width="32"></rect></g><g><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16"></polygon></g></svg></span> Select a fund</p>
          </div>
        </div>
      </div>
    </div>
  <?php endif; // donation box ?>
</div>

<script type="text/javascript">
(function($){
  console.log("Homepage Slider: loaded");

  $(function(){
    console.log("Homepage Slider: ready");

    // Init Slick (assumes slick JS/CSS already enqueued globally)
    $('#carousel__main_scroller').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      autoplay: false,
      fade: true,
      dots: false,
      centerMode: true,
      centerPadding: '0',
      autoplaySpeed: 4500,
      arrows: true
    });

    // If exactly one project, auto-load it into banner
    <?php
    if ( !empty($proj) && $proj_count === 1 ) {
        echo 'load_the_banner_project_quickdonate(' . (int) $proj[0] . ');';
    }
    ?>

    // Wire up selector
    $(document).on('change', '.select_project_name_banner', function(e){
      var productID = $(this).val();
      if (productID) {
        console.log('Selected project:', productID);
        load_the_banner_project_quickdonate(productID);
      }
      e.preventDefault();
    });
  });

  function load_the_banner_project_quickdonate(project_id){
    if (!project_id) return false;
    console.log("Homepage Slider load project:", project_id);
    $.ajax({
      url: "<?php echo esc_url( $ajaxurl ); ?>",
      type: "POST",
      data: { action: "loadproject", project_id: project_id },
      success: function(html){
        $('#quick_donation_banner').addClass('active').html(html);
      }
    });
    return false;
  }
})(jQuery);
</script>
