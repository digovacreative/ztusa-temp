<?php
/**
 * Block: Donation Hero (Fundraise Up only) – REST-safe
 */
defined('ABSPATH') || exit;

/** Lightweight editor/REST preview (prevents JSON breakage) */
if (defined('REST_REQUEST') && REST_REQUEST && is_admin()) {
  $h_main   = trim((string) get_field('heading_main'))   ?: 'Every Child Deserves a Chance to';
  $h_accent = trim((string) get_field('heading_accent')) ?: 'Learn';
  $wid      = trim((string) get_field('fu_widget_id'))   ?: 'XTGVSAJV';
  ?>
  <section class="donation-hero donation-hero--preview" style="padding:16px;border:1px dashed #ccd;">
    <h3 style="margin:0 0 .5rem;"><?php echo esc_html("$h_main "); ?><span style="color:#c21f4f;"><?php echo esc_html($h_accent); ?></span></h3>
    <p style="margin:0;opacity:.8"><em>Fundraise Up widget (ID: <?php echo esc_html($wid); ?>) will render on the front-end.</em></p>
  </section>
  <?php
  return;
}

/** Front-end render */
$block_id   = 'donation-hero-' . wp_unique_id();

$bg_id      = (int) (get_field('bg_image') ?: 0);
$bg_m_id    = (int) (get_field('bg_image_mobile') ?: 0);
$bg_url     = $bg_id   ? wp_get_attachment_image_url($bg_id,   'full') : '';
$bg_m_url   = $bg_m_id ? wp_get_attachment_image_url($bg_m_id, 'full') : $bg_url;

$bg_focal   = (string) (get_field('bg_focal') ?: 'center center');
$overlay    = (string) (get_field('overlay_color') ?: 'rgba(0,0,0,.45)');

$h_main     = trim((string) get_field('heading_main'))   ?: 'Every Child Deserves a Chance to';
$h_accent   = trim((string) get_field('heading_accent')) ?: 'Learn';

$widget_id  = trim((string) get_field('fu_widget_id')) ?: 'XVGCLLYQ';
$min_h      = (int) (get_field('min_height') ?: 560);
$content_w  = (int) (get_field('content_width') ?: 560);
$align      = (string) (get_field('content_align') ?: 'left');

$btn        = get_field('mobile_button'); // ACF link (array)
$btn_url    = (is_array($btn) && !empty($btn['url']))   ? esc_url($btn['url'])   : '';
$btn_label  = (is_array($btn) && ($btn['title'] ?? '') !== '' ) ? $btn['title']  : 'Donate and Support';
$btn_target = (is_array($btn) && !empty($btn['target'])) ? esc_attr($btn['target']) : '_self';

/** Inline CSS variables (desktop + mobile bg) */
$vars = sprintf(
  '--dh-bg:url(%s);--dh-bg-mobile:url(%s);--dh-overlay:%s;--dh-min-h:%dpx;--dh-content-w:%dpx;--dh-bg-pos:%s;',
  esc_url($bg_url ?: 'data:image/gif;base64,R0lGODlhAQABAAAAACw='),
  esc_url($bg_m_url ?: $bg_url ?: 'data:image/gif;base64,R0lGODlhAQABAAAAACw='),
  esc_attr($overlay),
  $min_h,
  $content_w,
  esc_attr($bg_focal)
);
?>
<section id="<?php echo esc_attr($block_id); ?>" class="donation-hero donation-hero--<?php echo esc_attr($align); ?>" style="<?php echo $vars; ?>">
  <div class="donation-hero__bg" aria-hidden="true"></div>

  <div class="donation-hero__inner">
    <div class="donation-hero__txt">
      <h1 class="donation-hero__heading">
        <?php echo esc_html($h_main); ?>
        <span class="accent"><?php echo esc_html($h_accent); ?></span>
      </h1>

      <!-- Fundraise Up inline trigger (hidden element; FRU script replaces it) -->
      <div class="donation-hero__box">
        <a href="#<?php echo esc_attr($widget_id); ?>" style="display:none"></a>
        <?php if (is_user_logged_in() && current_user_can('edit_posts')): ?>
          <p style="margin-top:.5rem;opacity:.8"><em>Preview: the Fundraise Up form renders on the public page.</em></p>
        <?php endif; ?>
      </div>
    </div>

    <?php if ($btn_url): ?>
      <p class="donation-hero__mobile-cta">
        <a class="dh-btn" href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
          <?php echo esc_html($btn_label); ?>
        </a>
      </p>
    <?php endif; ?>
  </div>
</section>
