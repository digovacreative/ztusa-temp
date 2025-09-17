<?php
/**
 * Block: Project Cards Grid (Products or Manual Links)
 */
defined('ABSPATH') || exit;

$block_id   = 'cards-grid-' . wp_unique_id();
$section_h  = get_field('section_title');
$default_cta= get_field('default_button_label') ?: 'Select Package';

$cards = get_field('cards'); // repeater rows
if (!$cards || !is_array($cards)) { if (is_admin()) echo '<p><em>Add some cards.</em></p>'; return; }

?>
<section id="<?php echo esc_attr($block_id); ?>" class="project-cards-grid">
  <?php if ($section_h): ?>
    <header class="project-cards-grid__header">
      <h2><?php echo esc_html($section_h); ?></h2>
    </header>
  <?php endif; ?>

  <ul class="project-cards-grid__list" role="list">
    <?php foreach ($cards as $row):
      $type = $row['type'] ?? 'product'; // 'product' | 'link'

      // Common fields
      $icon_id   = isset($row['icon']) ? (int)$row['icon'] : 0;
      $icon_url  = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
      $image_id  = isset($row['image']) ? (int)$row['image'] : 0; // optional override
      $cta_label = !empty($row['button_label']) ? $row['button_label'] : $default_cta;

      $title = $href = $target = '';

      if ($type === 'product' && function_exists('wc_get_product')) {
        $product_id = isset($row['product']) ? (int)$row['product'] : 0;
        $product    = $product_id ? wc_get_product($product_id) : null;
        if (!$product) { continue; }

        $title   = !empty($row['title_override']) ? $row['title_override'] : get_the_title($product_id);
        $href    = get_permalink($product_id);
        $target  = '_self';

        // image: override -> product thumbnail
        if (!$image_id) $image_id = get_post_thumbnail_id($product_id);

      } else { // manual link
        $link = $row['link'] ?? null; // ACF link array
        if (!$link || empty($link['url'])) { continue; }
        $title  = !empty($row['title']) ? $row['title'] : ($link['title'] ?: $link['url']);
        $href   = esc_url($link['url']);
        $target = !empty($link['target']) ? $link['target'] : '_self';
      }

      $img_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
      ?>
      <li class="project-card">
        <a class="project-card__link" href="<?php echo esc_url($href); ?>" target="<?php echo esc_attr($target); ?>">
          <div class="project-card__media">
            <?php if ($img_url): ?>
              <img src="<?php echo esc_url($img_url); ?>" alt="" loading="lazy" />
            <?php endif; ?>
            <?php if ($icon_url): ?>
              <span class="project-card__icon"><img src="<?php echo esc_url($icon_url); ?>" alt="" loading="lazy" /></span>
            <?php endif; ?>
          </div>

          <div class="project-card__body">
            <h3 class="project-card__title"><?php echo esc_html($title); ?></h3>
            <?php if ($cta_label): ?>
              <span class="project-card__cta"><?php echo esc_html($cta_label); ?></span>
            <?php endif; ?>
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
