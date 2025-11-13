<?php
/**
 * Block: Two-Up Hero (2-in-1) — popup only if donation_projects set
 */
defined('ABSPATH') || exit;

$block_id   = 'two-up-hero-' . wp_unique_id();
$layout     = get_field('layout') ?: 'single';
$accent     = get_field('accent_color') ?: '#18a6a5';
$text_color = get_field('text_color') ?: '#111';

/** Background image fields (optional) */
$bg_id    = (int) (get_field('background_image') ?: 0);
$bg_m_id  = (int) (get_field('background_image_mobile') ?: 0);
$bg_url   = $bg_id   ? wp_get_attachment_image_url($bg_id,   'full') : '';
$bg_m_url = $bg_m_id ? wp_get_attachment_image_url($bg_m_id, 'full') : ($bg_url ?: '');
$bg_pos   = (string) (get_field('background_focal') ?: 'center center'); // e.g. "center top"

/** Has BG? */
$has_bg = !empty($bg_url);

/** Image position + heart */
$img_pos_raw = (string) get_field('image_position');
$show_heart  = (bool) get_field('show_heart_button');

/** Button/link */
$btn        = get_field('button_link');
$btn_url    = (is_array($btn) && !empty($btn['url']))           ? esc_url($btn['url']) : '';
$btn_label  = (is_array($btn) && ($btn['title'] ?? '') !== '' ) ? $btn['title']        : 'Donate Now';
$btn_target = (is_array($btn) && !empty($btn['target']))        ? esc_attr($btn['target']) : '_self';

/** Headings + body */
$h_top      = (string) get_field('heading_top');
$h_main     = (string) get_field('heading_main');
$h_accent   = (string) get_field('heading_accent');
$body       = get_field('body');

/** Popup product ID */
$popup_product_id = 0;
$rel = get_field('donation_projects');
if (is_array($rel) && !empty($rel)) {
  $first = $rel[0];
  if (is_object($first) && isset($first->ID))       $popup_product_id = (int) $first->ID;
  elseif (is_array($first) && !empty($first['ID'])) $popup_product_id = (int) $first['ID'];
  elseif (is_numeric($first))                       $popup_product_id = (int) $first;
}

/** Inline vars — if BG is set, force white text */
$vars = sprintf(
  '--accent:%s;--text:%s;%s%s%s',
  esc_attr($accent),
  esc_attr($has_bg ? '#fff' : $text_color),
  $has_bg ? '--bg:url(' . esc_url($bg_url) . ');' : '',
  $has_bg ? '--bg-m:url(' . esc_url($bg_m_url ?: $bg_url) . ');' : '',
  $has_bg ? '--bg-pos:' . esc_attr($bg_pos) . ';' : ''
);
?>
<section id="<?php echo esc_attr($block_id); ?>"
         class="two-up-hero two-up-hero--<?php echo esc_attr($layout); ?> two-up-hero--img-<?php echo esc_attr($img_pos_raw); ?><?php echo $has_bg ? ' has-bg' : ''; ?>"
         style="<?php echo $vars; ?>">

  <?php if ($has_bg): ?>
    <div class="two-up-hero__bg" aria-hidden="true"></div>
  <?php endif; ?>

  <div class="two-up-hero__grid">
    <div class="two-up-hero__media">
      <?php if ($layout === 'single'): ?>
        <?php
          $img_id   = (int) (get_field('image_main') ?: 0);
          $shape    = get_field('image_shape') ?: 'circle';
          $img_url  = $img_id ? wp_get_attachment_image_url($img_id, 'large') : '';
          $shape_cls = 'is-' . $shape;
        ?>
        <?php if ($img_url): ?>
          <div class="two-up-hero__photo <?php echo esc_attr($shape_cls); ?>">
            <img src="<?php echo esc_url($img_url); ?>" alt="" loading="lazy">
          </div>
        <?php endif; ?>
      <?php else: ?>
        <?php
          $g = get_field('collage');
          $g = is_array($g) ? array_slice(array_values(array_filter($g)), 0, 4) : [];
        ?>
        <?php if (!empty($g)): ?>
          <div class="two-up-hero__collage">
            <?php foreach ($g as $i => $id):
              $u = wp_get_attachment_image_url((int)$id, 'large');
              if (!$u) continue; ?>
              <div class="two-up-hero__tile two-up-hero__tile--<?php echo (int)$i+1; ?>">
                <img src="<?php echo esc_url($u); ?>" alt="" loading="lazy">
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <div class="two-up-hero__content">
      <?php if ($h_top || $h_main || $h_accent): ?>
        <h2 class="two-up-hero__heading">
          <?php if ($h_top):    ?><span class="h-top"><?php echo esc_html($h_top); ?></span><?php endif; ?>
          <?php if ($h_main):   ?><span class="h-main"><?php echo esc_html($h_main); ?></span><?php endif; ?>
          <?php if ($h_accent): ?><span class="h-accent"><?php echo esc_html($h_accent); ?></span><?php endif; ?>
        </h2>
      <?php endif; ?>

      <?php if ($body): ?>
        <div class="two-up-hero__body"><?php echo wp_kses_post($body); ?></div>
      <?php endif; ?>

      <?php if ($btn_label && ($popup_product_id || $btn_url)): ?>
        <p class="two-up-hero__cta">
          <?php if ($popup_product_id): ?>
            <a href="#"
               class="btn-cta js-donate-popup"
               data-project-id="<?php echo (int) $popup_product_id; ?>"
               aria-haspopup="dialog"
               aria-controls="continue_shopping_popup">
              <?php if ($show_heart): ?><span class="btn-cta__icon" aria-hidden="true">❤</span><?php endif; ?>
              <span class="btn-cta__label"><?php echo esc_html($btn_label); ?></span>
            </a>
          <?php else: ?>
            <a class="btn-cta" href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
              <?php if ($show_heart): ?><span class="btn-cta__icon" aria-hidden="true">❤</span><?php endif; ?>
              <span class="btn-cta__label"><?php echo esc_html($btn_label); ?></span>
            </a>
          <?php endif; ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
</section>
