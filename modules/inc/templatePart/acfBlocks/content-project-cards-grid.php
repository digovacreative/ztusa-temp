<?php
/**
 * Block: Project Cards Grid (Products or Manual Links)
 */
defined('ABSPATH') || exit;

if (!function_exists('dm_media_to_url')) {
  function dm_media_to_url($val, $size = 'full') : string {
    if (empty($val)) return '';
    if (is_array($val)) {
      if (!empty($val['url'])) return esc_url($val['url']);
      if (!empty($val['ID']))  return esc_url(wp_get_attachment_image_url((int)$val['ID'], $size) ?: '');
    }
    if (is_numeric($val)) return esc_url(wp_get_attachment_image_url((int)$val, $size) ?: '');
    if (is_string($val) && filter_var($val, FILTER_VALIDATE_URL)) return esc_url($val);
    return '';
  }
}


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
<?php
$idx = 0;
if ( have_rows('cards') ):
  while ( have_rows('cards') ): the_row();
    $idx++;

    // TYPE: respect sub-field if present; otherwise auto-detect by presence of a link sub-field.
    $type = get_sub_field('type');
    if (!$type) $type = get_sub_field('link') ? 'link' : 'product';

    // Media (accept ID/array/URL)
    $icon_url  = dm_media_to_url(get_sub_field('icon'), 'thumbnail');
    $image_url = dm_media_to_url(get_sub_field('image'), 'large');

    $title  = '';
    $href   = '#';
    $target = '_self';
    $note   = ''; // for an HTML comment so you can see why a fallback happened

    if ($type === 'product' && function_exists('wc_get_product')) {
      $product_id = (int) get_sub_field('product');
      $product    = $product_id ? wc_get_product($product_id) : null;

      if ($product) {
        $title  = get_sub_field('title_override') ?: get_the_title($product_id);
        $href   = get_permalink($product_id);
        $target = '_self';

        if (!$image_url) {
          $thumb_id  = get_post_thumbnail_id($product_id);
          $image_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : '';
        }
      } else {
        $note  = 'fallback: missing/invalid product';
        $title = get_sub_field('title_override') ?: 'Untitled';
        // keep href = "#"
      }

    } else {
      // Manual link (ACF link array)
      $link = get_sub_field('link'); // expects [url,title,target]
      if (!empty($link['url'])) {
        $title  = get_sub_field('title') ?: ($link['title'] ?: $link['url']);
        $href   = esc_url($link['url']);
        $target = !empty($link['target']) ? $link['target'] : '_self';
      } else {
        $note  = 'fallback: missing link.url';
        $title = get_sub_field('title') ?: 'Untitled';
        // keep href = "#"
      }
    }

    $cta_label = get_sub_field('button_label') ?: ($default_cta ?? 'Select Package');

    // Debug breadcrumb in HTML (view source)
    echo "\n<!-- card {$idx}: type={$type}" . ($note ? " ({$note})" : "") . " -->\n";
    ?>
    <li class="project-card">
      <a class="project-card__link" href="<?php echo esc_url($href); ?>" target="<?php echo esc_attr($target); ?>">
        <div class="project-card__media">
          <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="" loading="lazy" />
          <?php endif; ?>

          <?php if ($icon_url): ?>
            <span class="project-card__icon">
              <img src="<?php echo esc_url($icon_url); ?>" alt="" loading="lazy" />
            </span>
          <?php endif; ?>
        </div>

        <div class="project-card__body">
          <h3 class="project-card__title"><?php echo esc_html($title ?: 'Untitled'); ?></h3>
          <?php if ($cta_label): ?>
            <span class="project-card__cta"><?php echo esc_html($cta_label); ?></span>
          <?php endif; ?>
        </div>
      </a>
    </li>
  <?php endwhile;
else:
  echo '<!-- no cards rows -->';
endif; ?>
</ul>

</section>
