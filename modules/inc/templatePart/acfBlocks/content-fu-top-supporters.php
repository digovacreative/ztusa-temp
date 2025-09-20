<?php
/**
 * Block: Gifts + Top Supporters
 */
defined('ABSPATH') || exit;

$block_id  = 'gifts-supporters-' . wp_unique_id();

$heading_main   = trim((string) get_field('heading_main'))   ?: 'YOUR GIFTS IN';
$heading_accent = trim((string) get_field('heading_accent')) ?: 'ACTION';
$widget_id      = get_field('fu_widget_id') ?: 'XRPGVJBE';

$slides = get_field('slides');
$slide_count = (is_array($slides) ? count(array_filter($slides)) : 0);
?>
<section id="<?php echo esc_attr($block_id); ?>" class="gifts-supporters">
  <div class="gifts-supporters__inner">
    <h2 class="gifts-supporters__heading">
      <?php echo esc_html($heading_main); ?> <span class="accent"><?php echo esc_html($heading_accent); ?></span>
    </h2>

    <div class="gifts-supporters__grid">
      <!-- LEFT: Slider (only slick if >1) -->
      <div class="gifts-supporters__left">
        <?php if ($slide_count): ?>
          <div class="fu-testimonial-slider<?php echo $slide_count > 1 ? '' : ' no-slick'; ?>">
            <?php foreach ($slides as $row):
              if (empty($row)) continue;
              $img_id   = isset($row['image']) ? (int)$row['image'] : 0;
              $img_url  = $img_id ? wp_get_attachment_image_url($img_id, 'large') : '';
              $quote    = $row['quote']   ?? '';
              $name     = $row['name']    ?? '';
              $subline  = $row['subline'] ?? '';
              $flag_id  = isset($row['flag']) ? (int)$row['flag'] : 0;
              $flag_url = $flag_id ? wp_get_attachment_image_url($flag_id, 'thumbnail') : '';
            ?>
              <article class="fu-card">
                <?php if ($img_url): ?>
                  <div class="fu-card__avatar">
                    <img src="<?php echo esc_url($img_url); ?>" alt="" loading="lazy" />
                  </div>
                <?php endif; ?>

                <div class="fu-card__body">
                  <div class="fu-card__quote-mark" aria-hidden="true">“</div>
                  <?php if ($quote): ?>
                    <div class="fu-card__quote"><?php echo wp_kses_post($quote); ?></div>
                  <?php endif; ?>

                  <div class="fu-card__meta">
                    <div class="fu-card__name">
                      <?php echo esc_html($name); ?>
                      <?php if ($subline): ?><div class="fu-card__sub"><?php echo esc_html($subline); ?></div><?php endif; ?>
                    </div>
                    <?php if ($flag_url): ?>
                      <div class="fu-card__flag"><img src="<?php echo esc_url($flag_url); ?>" alt="" loading="lazy" /></div>
                    <?php endif; ?>
                  </div>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <?php if (is_admin()): ?><p><em>Add at least one slide.</em></p><?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- RIGHT: Fundraise Up trigger -->
      <div class="gifts-supporters__right">
        <div class="gifts-supporters__panel">
          <a href="#<?php echo esc_attr($widget_id); ?>" style="display: none"></a>
        </div>
        <?php if (is_admin()): ?>
          <p style="opacity:.75"><em>Preview:</em> Fundraise Up injects the supporters list on the frontend.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script>
(function ($) {
  function initGiftsSupporters(blockId) {
    var $root = $('#' + blockId);
    if (!$root.length) return;

    var $wrap  = $root.find('.fu-testimonial-slider');
    var $panel = $root.find('.gifts-supporters__panel');

    // Bail if no slides
    if (!$wrap.length || $wrap.children().length < 1) return;

    // If already slicked incorrectly, reset
    if ($wrap.hasClass('slick-initialized')) {
      try { $wrap.slick('unslick'); } catch (e) {}
    }

    // Only slick when >1 slide
    if ($wrap.children().length > 1 && $.fn.slick) {
      $wrap.on('init', function () { setPosition(); });
      $wrap.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        autoplay: false,
        adaptiveHeight: false,   // let CSS control height
        arrows: true,
        dots: false,
        centerMode: false,
        variableWidth: false,
        speed: 400,
        prevArrow: '<button type="button" class="slick-prev" aria-label="Previous">‹</button>',
        nextArrow: '<button type="button" class="slick-next" aria-label="Next">›</button>'
      });
    }

    function setPosition() {
      if ($wrap.hasClass('slick-initialized')) $wrap.slick('setPosition');
    }

    // Reflow on images, resize, fonts, and FRU injection
    $wrap.find('img').on('load', setPosition);
    $(window).on('resize', setPosition);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(setPosition);
    if ('ResizeObserver' in window && $panel.length) new ResizeObserver(setPosition).observe($panel[0]);

    // Final nudge after a tick (helps when inside freshly-rendered blocks)
    setTimeout(setPosition, 50);
  }

  // Init this block instance
  $(function () { initGiftsSupporters('<?php echo esc_js($block_id); ?>'); });

  // ACF preview support
  if (window.acf) {
    window.acf.addAction('render_block_preview', function ($el, data) {
      var id = '<?php echo esc_js($block_id); ?>';
      if ($el && $el.find('#' + id).length) initGiftsSupporters(id);
    });
  }
})(jQuery);
</script>

</section>
