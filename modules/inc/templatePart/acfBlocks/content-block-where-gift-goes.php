<?php
/**
 * Block: Where Your Gift Goes (cards grid + bottom background)
 */
defined('ABSPATH') || exit;

if (!function_exists('dm_wrap_last_words')) {
  /**
   * Wrap last N words of a plain-text heading with a span.is-accent
   */
  function dm_wrap_last_words(string $text, int $n = 1): string {
    $text = trim($text);
    if ($text === '' || $n < 1) return esc_html($text);

    $safe = esc_html($text);                 // work with escaped text
    $n = max(1, (int)$n);
    $pattern = '~(\s+)(\S+(?:\s+\S+){' . ($n - 1) . '})$~u';

    $out = preg_replace($pattern, '$1<span class="is-accent">$2</span>', $safe, 1);
    if ($out === null || $out === $safe) {
      // Fallback split if regex fails
      $parts = preg_split('/\s+/u', $safe);
      if (count($parts) > 1) {
        $head = array_slice($parts, 0, -$n);
        $tail = array_slice($parts, -$n);
        $out  = implode(' ', $head) . ' <span class="is-accent">' . implode(' ', $tail) . '</span>';
      } else {
        $out = '<span class="is-accent">' . $safe . '</span>';
      }
    }
    return $out;
  }
}



$block_id   = 'gift-goes-' . wp_unique_id();
$heading    = (string) get_field('heading');
$accent     = (string) (get_field('accent_color') ?: '#c13b5a');

/* Bottom background images (accept ID or URL) */
$bg_bottom_raw  = get_field('bg_bottom');
$bg_bottom_mraw = get_field('bg_bottom_mobile');

$bg_bottom_url = is_numeric($bg_bottom_raw) ? wp_get_attachment_image_url((int)$bg_bottom_raw, 'full') : (is_string($bg_bottom_raw) ? $bg_bottom_raw : '');
$bg_bottom_m   = is_numeric($bg_bottom_mraw) ? wp_get_attachment_image_url((int)$bg_bottom_mraw, 'full') : (is_string($bg_bottom_mraw) ? $bg_bottom_mraw : '');
if (!$bg_bottom_m) $bg_bottom_m = $bg_bottom_url;

$style_vars = sprintf('--accent:%s;%s%s',
  esc_attr($accent),
  $bg_bottom_url ? '--bg-bottom:url(' . esc_url($bg_bottom_url) . ');' : '',
  $bg_bottom_m   ? '--bg-bottom-m:url(' . esc_url($bg_bottom_m) . ');'   : ''
);
$accent_words = (int) (get_field('accent_last_words') ?: 1);
$heading_html = function_exists('dm_wrap_last_words')
  ? dm_wrap_last_words((string)$heading, $accent_words)
  : esc_html((string)$heading);
?>
<section id="<?php echo esc_attr($block_id); ?>" class="gift-goes" style="<?php echo $style_vars; ?>">
    <?php if ($bg_bottom_url): ?>
    <div class="gift-goes__bg" aria-hidden="true"></div>
    <?php endif; ?>

    <div class="gift-goes__inner">


        <?php if ($heading_html): ?>
        <h2 class="gift-goes__heading"><?php echo $heading_html; // already escaped inside helper ?></h2>
        <?php endif; ?>
        <?php if (have_rows('countries')): ?>
        <div class="gift-goes__grid">
            <?php while (have_rows('countries')): the_row();
          $title      = (string) get_sub_field('title');

          // Map image
          $map_id     = (int) (get_sub_field('map_image') ?: 0);
          $map_img    = $map_id ? wp_get_attachment_image($map_id, 'large', false, ['class' => 'gift-goes__map','loading'=>'lazy','alt'=>'']) : '';

          // Locations
          $locs = [];
          if (have_rows('locations')) {
            while (have_rows('locations')) { the_row();
              $name = trim((string) get_sub_field('name'));
              if ($name !== '') $locs[] = $name;
            }
          }

           // CTA: prefer popup via donation_projects, else link
          $popup_product_id = 0;
          $rel = get_sub_field('donation_projects');
          if ($rel) {
            $first = is_array($rel) ? reset($rel) : $rel;
            if (is_object($first) && isset($first->ID)) {
              $popup_product_id = (int) $first->ID;
            } elseif (is_array($first) && !empty($first['ID'])) {
              $popup_product_id = (int) $first['ID'];
            } elseif (is_numeric($first)) {
              $popup_product_id = (int) $first;
            }
          }

          $link = get_sub_field('button_link');

                    $link             = get_sub_field('button_link');
          $btn_url = $btn_title = $btn_target = '';
          if (is_array($link)) {
            $btn_url    = !empty($link['url'])    ? esc_url($link['url']) : '';
            $btn_title  = ($link['title'] ?? '') !== '' ? $link['title'] : 'Donate Now';
            $btn_target = !empty($link['target']) ? esc_attr($link['target']) : '_self';
          } else {
            $btn_title = 'Donate Now';
          }

          $show_heart = get_sub_field('show_heart_button');
          $show_heart = ($show_heart === null) ? true : (bool)$show_heart;
        ?>
            <article class="gift-goes__card">
                <header class="gift-goes__card-head">
                    <?php if ($title): ?><h3 class="gift-goes__title"><?php echo esc_html($title); ?></h3>
                    <?php endif; ?>
                    <?php if ($map_img): ?><div class="gift-goes__mapwrap"><?php echo $map_img; ?></div><?php endif; ?>
                </header>

                <?php if (!empty($locs)): ?>
                <ul class="gift-goes__list">
                    <?php foreach ($locs as $li): ?>
                    <li><?php echo esc_html($li); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <?php if ($btn_title && ($popup_product_id || $btn_url)): ?>
                <p class="gift-goes__cta">
                    <?php if ($popup_product_id): ?>
                    <a href="#" class="btn-cta js-donate-popup" data-project-id="<?php echo (int)$popup_product_id; ?>"
                        aria-haspopup="dialog" aria-controls="continue_shopping_popup">
                        <?php if ($show_heart): ?><span class="btn-cta__icon" aria-hidden="true">❤</span><?php endif; ?>
                        <span class="btn-cta__label"><?php echo esc_html($btn_title); ?></span>
                    </a>
                    <?php elseif ($btn_url): ?>
                    <a class="btn-cta" href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
                        <?php if ($show_heart): ?><span class="btn-cta__icon" aria-hidden="true">❤</span><?php endif; ?>
                        <span class="btn-cta__label"><?php echo esc_html($btn_title); ?></span>
                    </a>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
            </article>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>