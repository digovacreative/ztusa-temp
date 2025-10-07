<?php
/**
 * Block: Legacy Callout (popup-aware) — with background image support
 */
defined('ABSPATH') || exit;

/* Helpers */
if (!function_exists('dm_try_product_id_from_url')) {
  function dm_try_product_id_from_url(?string $url) : int {
    if (!$url) return 0;
    if (!function_exists('url_to_postid')) return 0;
    $pid = url_to_postid($url);
    return ($pid && get_post_type($pid) === 'product') ? (int)$pid : 0;
  }
}
if (!function_exists('dm_first_post_id')) {
  function dm_first_post_id($rel) : int {
    if (!is_array($rel) || empty($rel)) return 0;
    $first = $rel[0];
    if (is_object($first) && isset($first->ID)) return (int)$first->ID;
    if (is_array($first)  && !empty($first['ID'])) return (int)$first['ID'];
    if (is_numeric($first)) return (int)$first;
    return 0;
  }
}

$block_id = 'legacy-callout-' . wp_unique_id();

/* Width + gradient fallbacks (kept for no-image case) */
$width      = get_field('width') ?: 'full';          // 'full' | 'half'
$start      = get_field('gradient_start') ?: '#0f8a8b';
$end        = get_field('gradient_end')   ?: '#1fb0a5';
$angle      = (int) (get_field('gradient_angle') ?: 135);

/* NEW: Background image fields */
$bg_id      = (int) (get_field('background_image') ?: 0);
$bg_m_id    = (int) (get_field('background_image_mobile') ?: 0);
$bg_url     = $bg_id   ? wp_get_attachment_image_url($bg_id, 'full')   : '';
$bg_m_url   = $bg_m_id ? wp_get_attachment_image_url($bg_m_id,'full') : $bg_url; // fallback to desktop
$bg_focal   = (string) (get_field('background_focal') ?: 'center center');
$overlay    = (string) (get_field('overlay_color') ?: 'rgba(0,0,0,.35)'); // optional dark overlay

$content    = get_field('content');
$link       = get_field('button_link');

/* Button */
$btn_url = $btn_title = $btn_target = '';
if (is_array($link)) {
  $btn_url    = !empty($link['url'])   ? esc_url($link['url'])   : '';
  $btn_title  = ($link['title'] ?? '') !== '' ? $link['title'] : 'Donate Now';
  $btn_target = !empty($link['target']) ? esc_attr($link['target']) : '_self';
}

/* Popup target product */
$popup_product_id = dm_first_post_id( (array) get_field('donation_projects') );
if (!$popup_product_id && $btn_url) {
  $maybe = dm_try_product_id_from_url($btn_url);
  if ($maybe) $popup_product_id = $maybe;
}

/* Build inline vars:
   - If image present → use --bg/--bg-mobile/--bg-pos/--bg-overlay
   - Else → keep gradient vars so existing CSS still works */
$style = $bg_url
  ? sprintf(
      '--bg:url(%s);--bg-mobile:url(%s);--bg-pos:%s;--bg-overlay:%s;',
      esc_url($bg_url),
      esc_url($bg_m_url ?: $bg_url),
      esc_attr($bg_focal),
      esc_attr($overlay)
    )
  : sprintf(
      '--grad-start:%s;--grad-end:%s;--grad-angle:%sdeg;',
      esc_attr($start), esc_attr($end), esc_attr($angle)
    );

$width_class = $width === 'half' ? 'is-half-md' : 'is-full';
?>
<div class="gutenberg__wrap">
  <section
    id="<?php echo esc_attr($block_id); ?>"
    class="legacy-callout<?php echo $bg_url ? ' has-image' : ' has-gradient'; ?>"
    style="<?php echo $style; ?>"
  >
    <?php if ($bg_url): ?>
      <!-- background image layer + overlay -->
      <div class="legacy-callout__bg" aria-hidden="true"></div>
      <!-- <div class="legacy-callout__overlay" aria-hidden="true"></div> -->
    <?php endif; ?>

    <div class="legacy-callout__inner <?php echo esc_attr($width_class); ?>">
      <?php if ($content): ?>
        <div class="legacy-callout__content">
          <?php echo wp_kses_post($content); ?>
        </div>
      <?php endif; ?>

      <?php if ($btn_title && ($btn_url || $popup_product_id)): ?>
        <p class="legacy-callout__cta">
          <?php if ($popup_product_id): ?>
            <a href="#"
               class="btn-cta js-donate-popup"
               data-project-id="<?php echo (int) $popup_product_id; ?>"
               aria-haspopup="dialog"
               aria-controls="continue_shopping_popup">
              <span class="btn-cta__icon" aria-hidden="true">❤</span>
              <span class="btn-cta__label"><?php echo esc_html($btn_title); ?></span>
            </a>
          <?php else: ?>
            <a class="btn-cta" href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
              <span class="btn-cta__icon" aria-hidden="true">❤</span>
              <span class="btn-cta__label"><?php echo esc_html($btn_title); ?></span>
            </a>
          <?php endif; ?>
        </p>
      <?php endif; ?>
    </div>
  </section>
</div>
