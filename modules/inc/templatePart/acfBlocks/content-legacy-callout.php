<?php
/**
 * Block: Legacy Callout
 * Description: Gradient CTA/statement with optional button.
 */
defined('ABSPATH') || exit;

$block_id = 'legacy-callout-' . wp_unique_id();

// Fields
$width      = get_field('width') ?: 'full';         // 'full' | 'half'
$start      = get_field('gradient_start') ?: '#0f8a8b';
$end        = get_field('gradient_end')   ?: '#1fb0a5';
$angle      = (int) (get_field('gradient_angle') ?: 135);
$content    = get_field('content');                 // WYSIWYG (allow strong, br, etc.)
$link       = get_field('button_link');             // ACF link (array or empty)

// Button bits
$btn_url = $btn_title = $btn_target = '';
if (is_array($link)) {
  $btn_url    = isset($link['url']) ? esc_url($link['url']) : '';
  $btn_title  = isset($link['title']) && $link['title'] !== '' ? $link['title'] : 'Donate Now';
  $btn_target = !empty($link['target']) ? esc_attr($link['target']) : '_self';
}

// CSS vars for gradient
$style = sprintf(
  '--grad-start:%s;--grad-end:%s;--grad-angle:%sdeg;',
  esc_attr($start), esc_attr($end), esc_attr($angle)
);

// width class
$width_class = $width === 'half' ? 'is-half-md' : 'is-full';
?>
<div class="gutenberg__wrap">
  <section
    id="<?php echo esc_attr($block_id); ?>"
    class="legacy-callout"
    
    style="<?php echo $style; ?>"
  >
    <div class="legacy-callout__inner <?php echo esc_attr($width_class); ?>">
      <?php if ($content): ?>
        <div class="legacy-callout__content">
          <?php echo wp_kses_post($content); ?>
        </div>
      <?php endif; ?>

      <?php if ($btn_url): ?>
        <p class="legacy-callout__cta">
          <a class="btn-cta" href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
            <span class="btn-cta__icon" aria-hidden="true">❤</span>
            <span class="btn-cta__label"><?php echo esc_html($btn_title); ?></span>
          </a>
        </p>
      <?php endif; ?>
    </div>
  </section>
</div>
