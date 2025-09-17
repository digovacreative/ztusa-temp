<?php
/**
 * Block: Project Pills (Products OR Links)
 */
defined('ABSPATH') || exit;

$block_id   = 'project-pills-' . wp_unique_id();
$title      = get_field('section_title') ?: "The Zahra(s) Trust Canada Projects";
$source     = get_field('source_type') ?: 'products'; // 'products' | 'links'
$link_mode  = get_field('link_mode') ?: 'product';    // only for products: 'product' | 'add_to_cart'
$new_tab    = (bool) get_field('open_new_tab');       // global toggle (optional)

$vars = sprintf(
  '--pill-text:%s;--pill-bg:%s;--pill-border:%s;--pill-hover-bg:%s;--pill-hover-text:%s;',
  esc_attr(get_field('text_color') ?: '#10979a'),
  esc_attr(get_field('bg_color') ?: '#ffffff'),
  esc_attr(get_field('border_color') ?: '#ececec'),
  esc_attr(get_field('hover_bg_color') ?: '#10979a'),
  esc_attr(get_field('hover_text_color') ?: '#ffffff')
);
$target = $new_tab ? ' target="_blank" rel="noopener"' : '';

?>
<section id="<?php echo esc_attr($block_id); ?>" class="project-pills" style="<?php echo $vars; ?>">
  <div class="project-pills__inner">
    <div class="project-pills__title">
      <h3><?php echo esc_html($title); ?></h3>
    </div>

    <ul class="project-pills__list" role="list">
      <?php if ($source === 'products') : ?>
        <?php
        if (!function_exists('wc_get_product')) {
          if (is_admin()) echo '<li><em>WooCommerce is required for product pills.</em></li>';
        } else {
          $product_ids = get_field('products');
          if (is_array($product_ids)) {
            foreach ($product_ids as $pid) {
              $pid = (int) $pid;
              $product = wc_get_product($pid);
              if (!$product) continue;

              $label = get_the_title($pid);
              $href  = get_permalink($pid);
              $classes = 'project-pill';

              if ($link_mode === 'add_to_cart' && $product->is_purchasable() && $product->is_type('simple')) {
                $href = $product->add_to_cart_url();
                $classes .= ' add_to_cart_button ajax_add_to_cart';
              }
              echo '<li><a class="'.esc_attr($classes).'" href="'.esc_url($href).'"'.$target.' data-product_id="'.esc_attr($pid).'">'.esc_html($label).'</a></li>';
            }
          }
        }
        ?>
      <?php else: // links ?>
        <?php
        $links = get_field('links');
        if (is_array($links) && !empty($links)) {
          foreach ($links as $row) {
            $link = isset($row['link']) ? $row['link'] : null; // ACF link array
            if (!$link || empty($link['url'])) continue;
            $href   = esc_url($link['url']);
            $label  = $link['title'] !== '' ? $link['title'] : $href;
            $t      = !empty($link['target']) ? ' target="'.esc_attr($link['target']).'" rel="noopener"' : $target;
            echo '<li><a class="project-pill" href="'.$href.'"'.$t.'>'.esc_html($label).'</a></li>';
          }
        } elseif (is_admin()) {
          echo '<li><em>Add one or more links.</em></li>';
        }
        ?>
      <?php endif; ?>
    </ul>
  </div>
</section>
