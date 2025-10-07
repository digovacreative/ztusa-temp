<?php
/**
 * Block: Impact Map + CTA (popup-aware)
 */
defined('ABSPATH') || exit;

$block_id = 'impact-map-cta-' . wp_unique_id();

/* ---------- Helpers (guarded) ---------- */
if (!function_exists('dm_link_parts')) {
  function dm_link_parts($link){
    if (!is_array($link) || empty($link['url'])) return null;
    return [
      'url'    => esc_url($link['url']),
      'label'  => (isset($link['title']) && $link['title'] !== '') ? $link['title'] : __('Learn more','textdomain'),
      'target' => !empty($link['target']) ? esc_attr($link['target']) : '_self',
    ];
  }
}
if (!function_exists('dm_try_product_id_from_url')) {
  function dm_try_product_id_from_url(?string $url) : int {
    if (!$url || !function_exists('url_to_postid')) return 0;
    $pid = url_to_postid($url);
    return ($pid && get_post_type($pid) === 'product') ? (int)$pid : 0;
  }
}
if (!function_exists('dm_first_post_id')) {
  /** Normalize ACF relationship first item (Post Object|array|id) → int id */
  function dm_first_post_id($rel) : int {
    if (!is_array($rel) || empty($rel)) return 0;
    $first = $rel[0];
    if (is_object($first) && isset($first->ID)) return (int)$first->ID;
    if (is_array($first)  && !empty($first['ID'])) return (int)$first['ID'];
    if (is_numeric($first)) return (int)$first;
    return 0;
  }
}

/* ---------- Fields ---------- */
$widget_id     = get_field('widget_id') ?: 'XTGVSAJV';
$intro_text    = trim((string) get_field('intro_text'));
$title_main    = trim((string) get_field('title_main'));
$title_accent  = trim((string) get_field('title_accent'));
$body_text     = (string) get_field('body_text');

$btn_one       = get_field('btn_one_time');
$btn_monthly   = get_field('btn_monthly');
$one           = dm_link_parts($btn_one);
$mon           = dm_link_parts($btn_monthly);

/* ---------- Popup product resolution ---------- */
// Per-button relationships (optional)
$rel_one    = (array) get_field('donation_projects_one');
$rel_mon    = (array) get_field('donation_projects_monthly');
// Shared relationship (optional)
$rel_shared = (array) get_field('donation_projects');

$one_pid = dm_first_post_id($rel_one)
        ?: dm_first_post_id($rel_shared)
        ?: ($one ? dm_try_product_id_from_url($one['url']) : 0);

$mon_pid = dm_first_post_id($rel_mon)
        ?: dm_first_post_id($rel_shared)
        ?: ($mon ? dm_try_product_id_from_url($mon['url']) : 0);

/* ---------- (Optional) allow iframes/scripts if you output raw embed HTML ---------- */
$allowed = wp_kses_allowed_html('post');
$allowed['iframe'] = ['src'=>[], 'width'=>[], 'height'=>[], 'style'=>[], 'loading'=>[], 'allow'=>[], 'referrerpolicy'=>[], 'frameborder'=>[], 'scrolling'=>[], 'id'=>[], 'title'=>[], 'name'=>[]];
$allowed['script'] = ['type'=>[], 'src'=>[], 'id'=>[], 'async'=>[], 'defer'=>[]];
$allowed['div']    = ['id'=>[], 'class'=>[], 'style'=>[], 'data-lazy'=>[], 'data-src'=>[]];
?>
<section id="<?php echo esc_attr($block_id); ?>" class="map-cta">
  <div class="map-cta__inner">
    <div class="map-cta__grid">

      <div class="map-cta__embed">
        <div class="map-cta__embed-frame">
          <a href="#<?php echo esc_attr($widget_id); ?>" style="display: none"></a>
        </div>
      </div>

      <div class="map-cta__content">
        <?php if ($intro_text): ?>
          <p class="map-cta__intro"><em><?php echo esc_html($intro_text); ?></em></p>
        <?php endif; ?>

        <?php if ($title_main || $title_accent): ?>
          <h3 class="map-cta__title">
            <?php echo esc_html($title_main); ?>
            <?php if ($title_accent): ?><span class="accent"><?php echo esc_html($title_accent); ?></span><?php endif; ?>
          </h3>
        <?php endif; ?>

        <?php if ($body_text): ?>
          <div class="map-cta__body">
            <?php echo wp_kses_post(wpautop($body_text)); ?>
          </div>
        <?php endif; ?>

        <div class="map-cta__buttons">
          <?php if ($one): ?>
            <?php if ($one_pid): ?>
              <a href="#" class="btn btn--teal js-donate-popup"
                 data-project-id="<?php echo (int)$one_pid; ?>"
                 aria-haspopup="dialog" aria-controls="continue_shopping_popup">
                <?php echo esc_html($one['label']); ?>
              </a>
            <?php else: ?>
              <a class="btn btn--teal" href="<?php echo $one['url']; ?>" target="<?php echo $one['target']; ?>">
                <?php echo esc_html($one['label']); ?>
              </a>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($mon): ?>
            <?php if ($mon_pid): ?>
              <a href="#" class="btn btn--rose js-donate-popup"
                 data-project-id="<?php echo (int)$mon_pid; ?>"
                 aria-haspopup="dialog" aria-controls="continue_shopping_popup">
                <?php echo esc_html($mon['label']); ?>
              </a>
            <?php else: ?>
              <a class="btn btn--rose" href="<?php echo $mon['url']; ?>" target="<?php echo $mon['target']; ?>">
                <?php echo esc_html($mon['label']); ?>
              </a>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>
