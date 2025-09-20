<?php
/**
 * Block Name: Landing Hero (no slider)
 * Safe/robust version — same classes/fields as Homepage Carousel, but single hero
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

$ajaxurl   = get_stylesheet_directory_uri() . '/modules/inc/customajax.php'; // keep your existing endpoint
$is_mobile = function_exists('isMobile') ? (bool) isMobile() : wp_is_mobile();

// Pull first banner item (if any)
$first = null;
if ( have_rows('banner_items') ) {
    the_row(); // move pointer to first row
    $first = [
        'img_mobile' => get_sub_field('banner_image_mobile'),
        'img_desktop'=> get_sub_field('banner_image'),
        'small'      => (string) get_sub_field('banner_small_heading'),
        'head'       => (string) get_sub_field('banner_heading'),
        'text'       => (string) get_sub_field('banner_text'),
        'pos'        => (string) ( get_sub_field('text_position') ?: '' ),
        'link_raw'   => get_sub_field('button_link'),
        'link_text'  => (string) get_sub_field('button_label'),
    ];
    // Reset the_rows pointer so other code using the repeater later won’t be affected
    reset_rows();
}

// Derive hero values
$banner_url = '';
$link_url   = '';
$link_text  = '';
$small = $head = $text = $pos = '';
if ($first) {
    $chosen     = ($is_mobile && $first['img_mobile']) ? $first['img_mobile'] : $first['img_desktop'];
    $banner_url = dm_media_to_url($chosen, 'full');

    $pos   = $first['pos'];
    $small = $first['small'];
    $head  = $first['head'];
    $text  = $first['text'];

    $link_raw  = $first['link_raw'];
    $link_text = $first['link_text'];

    if (is_array($link_raw)) {
        $link_url  = isset($link_raw['url']) ? $link_raw['url'] : '';
        if (!$link_text && !empty($link_raw['title'])) $link_text = (string) $link_raw['title'];
    } elseif (is_string($link_raw)) {
        $link_url = $link_raw;
    }
    $link_url = esc_url($link_url);
}

// Donation box (safe count/array checks)
$proj = get_field('project_select');
$proj = is_array($proj) ? array_values(array_filter($proj)) : [];
$proj_count = count($proj);
?>

<style>
/* Keep your original class names. Slightly trim the slider-only CSS. */
.gutenberg__wrap .homepage__slider_carousel.medium .main__carousel,
.gutenberg__wrap .homepage__slider_carousel.medium,
.gutenberg__wrap .homepage__slider_carousel.medium .main__carousel .item_box {
  height: auto !important;
  width: 100% !important;
  min-height: auto !important;
}
/* Remove the old before overlay if it existed */
.gutenberg__wrap .homepage__slider_carousel .main__carousel .item_box:before { display: none; }
</style>

<div class="gutenberg__wrap">
  <section class="homepage__slider_carousel medium <?php echo esc_attr( get_field('banner_style') ?: '' ); ?>">

    <div class="main__carousel" id="carousel__main_scroller">
      <div class="item_wrap">
        <?php if ( $link_url ) : ?><a href="<?php echo $link_url; ?>"><?php endif; ?>

          <div
            class="item_box <?php echo ($small || $head || $text) ? 'has_overlay' : ''; ?> <?php echo empty($link_text) ? 'no_button' : ''; ?>"
            <?php if ($banner_url): ?>
              style="background-image:url('<?php echo esc_url($banner_url); ?>'); background-size:contain!important; background-position:top center!important; background-repeat:no-repeat!important;"
            <?php endif; ?>
          >
            <div class="caption__bg <?php echo esc_attr($pos); ?>"></div>
            <div class="large_box">
              <div class="caption <?php echo esc_attr($pos); ?>" style="top:0;">
                <?php if ($small): ?><h4><?php echo esc_html($small); ?></h4><?php endif; ?>
                <?php if ($head) : ?><h1><?php echo esc_html($head); ?></h1><?php endif; ?>
                <?php if ($text) : ?><h3><?php echo esc_html($text); ?></h3><?php endif; ?>

                <?php if ($link_text && $link_url): ?>
                  <a href="<?php echo $link_url; ?>" class="button border white">
                    <?php echo esc_html($link_text); ?>
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                      <g><rect fill="none" height="32" width="32"/></g>
                      <g><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16"/></g>
                    </svg>
                  </a>
                <?php endif; ?>

                <?php if ( get_field('enable_donation_box') ) : ?>
    <div class="banner_quick_donation_banner_box">  
      <div class="donation__box">
        <div class="quick_donation_banner_container">
          <?php if ($v = get_field('homepage_donation_heading')): ?>
            <h3><?php echo esc_html($v); ?></h3>
          <?php endif; ?>

          <?php if ($v = get_field('mobile_text')): if ($is_mobile): ?>
            <p><?php echo wp_kses_post($v); ?></p>
          <?php endif; endif; ?>

          <?php if ( $proj_count !== 1 ): ?>
            <select class="select_project_name_banner">
              <option value=""><?php esc_html_e('Select a fund', 'textdomain'); ?></option>
              <?php foreach ( $proj as $project_id ): ?>
                <option value="<?php echo esc_attr($project_id); ?>" data-project-id="<?php echo esc_attr($project_id); ?>">
                  <?php echo esc_html( get_the_title($project_id) ); ?>
                </option>
              <?php endforeach; ?>
            </select>
          <?php endif; ?>

          <div id="quick_donation_banner">
            <p>
              <span aria-hidden="true">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g><rect fill="none" height="32" width="32"></rect></g><g><polygon points="16,2.001 16,10 2,10 2,22 16,22 16,30 30,16"></polygon></g></svg>
              </span>
              <?php esc_html_e('Select a fund', 'textdomain'); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  <?php endif; // donation box ?>

              </div>
            </div>
          </div>

          <?php if ($banner_url): ?>
            <img src="<?php echo esc_url($banner_url); ?>" alt="" loading="lazy" />
          <?php endif; ?>

        <?php if ( $link_url ) : ?></a><?php endif; ?>
      </div>
    </div><!-- /#carousel__main_scroller -->

  </section>


</div>

<script type="text/javascript">
(function($){
  // If exactly one project, auto-load it into banner
  <?php if ( !empty($proj) && $proj_count === 1 ) : ?>
    load_the_banner_project_quickdonate(<?php echo (int) $proj[0]; ?>);
  <?php endif; ?>

  // Wire up selector
  $(document).on('change', '.select_project_name_banner', function(e){
    var productID = $(this).val();
    if (productID) {
      load_the_banner_project_quickdonate(productID);
    }
    e.preventDefault();
  });

  function load_the_banner_project_quickdonate(project_id){
    if (!project_id) return false;
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
