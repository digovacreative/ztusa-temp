<?php
/**
 * Block: Project Cards Grid (Products / Links / Donation Projects)
 */
defined('ABSPATH') || exit;

// Helpers
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
if (!function_exists('dm_try_product_id_from_url')) {
  function dm_try_product_id_from_url(?string $url) : int {
    if (!$url || !function_exists('url_to_postid')) return 0;
    $pid = url_to_postid($url);
    return ($pid && get_post_type($pid) === 'product') ? (int)$pid : 0;
  }
}

// Bail if ACF missing
if (!function_exists('get_field') || !function_exists('have_rows')) {
  if (is_admin()) echo '<section class="project-cards-grid"><p><em>ACF not available.</em></p></section>';
  return;
}

$block_id    = 'cards-grid-' . (function_exists('wp_unique_id') ? wp_unique_id() : uniqid('', true));
$section_h   = get_field('section_title');
$default_cta = get_field('default_button_label') ?: 'Select Package';
$cards       = get_field('cards');

if (!$cards || !is_array($cards)) { if (is_admin()) echo '<p><em>Add some cards.</em></p>'; return; }
?>
<section id="<?php echo esc_attr($block_id); ?>" class="project-cards-grid">
  <?php if ($section_h): ?>
    <header class="project-cards-grid__header"><h2><?php echo esc_html($section_h); ?></h2></header>
  <?php endif; ?>

  <ul class="project-cards-grid__list" role="list">
<?php
$idx = 0;
if ( have_rows('cards') ):
  while ( have_rows('cards') ): the_row(); $idx++;

    $type         = strtolower(trim((string) get_sub_field('type'))); // product | link | projects
    $acf_product  = (int) get_sub_field('product');
    $acf_link     = (array) get_sub_field('link');
    $acf_projects = (array) get_sub_field('donation_projects');

    $page_projects = (array) get_field('donation_projects', get_the_ID());
    $page_fallback = !empty($page_projects[0]) ? (int) $page_projects[0] : 0;

    $title     = get_sub_field('title') ?: '';
    $href      = '#';
    $target    = '_self';
    $note      = '';
    $icon_url  = dm_media_to_url(get_sub_field('icon'),  'thumbnail');
    $image_url = dm_media_to_url(get_sub_field('image'), 'large');

    $popup_product_id = 0;
    $card_product_id  = 0;

    if ($type === 'product' && function_exists('wc_get_product')) {
      if ($acf_product) {
        $card_product_id = (int) $acf_product;
        $title  = get_sub_field('title_override') ?: get_the_title($card_product_id);
        $href   = get_permalink($card_product_id);
        $target = '_self';
        if (!$image_url) {
          $thumb_id  = get_post_thumbnail_id($card_product_id);
          $image_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : '';
        }
      } else {
        $note  = 'fallback: missing/invalid product';
        $title = get_sub_field('title_override') ?: ($title ?: 'Untitled');
      }
    } elseif ($type === 'projects' || !$type) {
      $title = $title ?: 'Untitled';
      if (!empty($acf_projects[0])) {
        $popup_product_id = (int) $acf_projects[0];
      } elseif ($acf_product) {
        $popup_product_id = (int) $acf_product;
      } elseif ($page_fallback) {
        $popup_product_id = $page_fallback;
      } else {
        $note = 'fallback: empty donation_projects';
      }
      $href = '#';
    } else { // link
      $raw_url = !empty($acf_link['url']) ? $acf_link['url'] : '';
      if ($raw_url) {
        $title  = $title ?: (!empty($acf_link['title']) ? $acf_link['title'] : $raw_url);
        $target = !empty($acf_link['target']) ? $acf_link['target'] : '_self';
        $maybe  = dm_try_product_id_from_url($raw_url);
        if ($maybe) {
          $popup_product_id = $maybe;
          $href = '#';
          $target = '_self';
        } else {
          $href = esc_url($raw_url);
        }
      } else {
        $note  = 'fallback: missing link.url';
        $title = $title ?: 'Untitled';
      }
    }

    if (!$popup_product_id && $card_product_id) $popup_product_id = $card_product_id;
    $cta_label = get_sub_field('button_label') ?: ($default_cta ?? 'Select Package');

    echo "\n<!-- card {$idx}: type={$type}" . ($note ? " ({$note})" : "") . " | popup_product_id={$popup_product_id} -->\n";
    ?>
    <li class="project-card">
      <a class="project-card__link<?php echo $popup_product_id ? ' has-popup' : ''; ?>"
         href="<?php echo esc_url($href); ?>"
         target="<?php echo esc_attr($target); ?>"
         <?php if ($popup_product_id): ?>data-project-id="<?php echo (int) $popup_product_id; ?>"<?php endif; ?>>
        <div class="project-card__media">
          <?php if ($image_url): ?><img src="<?php echo esc_url($image_url); ?>" alt="" loading="lazy" /><?php endif; ?>
          <?php if ($icon_url): ?><span class="project-card__icon"><img src="<?php echo esc_url($icon_url); ?>" alt="" loading="lazy" /></span><?php endif; ?>
        </div>
        <div class="project-card__body">
          <h3 class="project-card__title"><?php echo esc_html($title ?: 'Untitled'); ?></h3>
          <?php if ($cta_label): ?>
            <?php if ($popup_product_id): ?>
              <button type="button" class="project-card__cta js-donate-popup"
                data-project-id="<?php echo (int) $popup_product_id; ?>"
                aria-haspopup="dialog" aria-controls="product_details_box">
                <?php echo esc_html($cta_label); ?>
              </button>
            <?php else: ?>
              <span class="project-card__cta" aria-disabled="true"><?php echo esc_html($cta_label); ?></span>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </a>
    </li>
  <?php endwhile; ?>
<?php else: ?>
  <!-- no cards rows -->
<?php endif; ?>
  </ul>
</section>

<script>
(function($){
  if (typeof window.$ajaxurl === 'undefined' || !window.$ajaxurl) {
    window.$ajaxurl = "<?php echo esc_url( admin_url('admin-ajax.php') ); ?>";
  }

  // Trigger via button
  $(document).on('click', '.js-donate-popup', function(e){
    e.preventDefault();
    var pid = parseInt($(this).data('project-id'), 10);
    if (pid && typeof load_the_project === 'function') {
      $('body').addClass('popup_active');
      load_the_project(pid);
    }
  });

  // Trigger via whole card
  $(document).on('click', '.project-card__link.has-popup', function(e){
    if ($(e.target).closest('.js-donate-popup').length) return;
    e.preventDefault();
    var pid = parseInt($(this).data('project-id'), 10);
    if (pid && typeof load_the_project === 'function') {
      $('body').addClass('popup_active');
      load_the_project(pid);
    }
  });
})(jQuery);
   
</script>
