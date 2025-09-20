<?php
/**
 * Block: Impact Map + CTA
 */
defined('ABSPATH') || exit;

$block_id = 'impact-map-cta-' . wp_unique_id();

// Fields
$widget_id     = get_field('widget_id') ?: 'XTGVSAJV';
$intro_text    = trim((string) get_field('intro_text'));
$title_main    = trim((string) get_field('title_main'));
$title_accent  = trim((string) get_field('title_accent'));
$body_text     = (string) get_field('body_text');

$btn_one       = get_field('btn_one_time');
$btn_monthly   = get_field('btn_monthly');

// Helper (guard against re-declare)
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
$one = dm_link_parts($btn_one);
$mon = dm_link_parts($btn_monthly);

// (Optional) allow iframes/scripts if you ever output raw embed HTML
$allowed = wp_kses_allowed_html('post');
$allowed['iframe'] = [
  'src'=>[], 'width'=>[], 'height'=>[], 'style'=>[], 'loading'=>[], 'allow'=>[],
  'referrerpolicy'=>[], 'frameborder'=>[], 'scrolling'=>[], 'id'=>[], 'title'=>[], 'name'=>[]
];
$allowed['script'] = ['type'=>[], 'src'=>[], 'id'=>[], 'async'=>[], 'defer'=>[]];
$allowed['div']    = ['id'=>[], 'class'=>[], 'style'=>[], 'data-lazy'=>[], 'data-src'=>[]];
?>
<section id="<?php echo esc_attr($block_id); ?>" class="map-cta">
  <div class="map-cta__inner">
    <div class="map-cta__grid">

      <!-- LEFT: Fundraise Up map trigger -->
      <div class="map-cta__embed">
        <div class="map-cta__embed-frame">
          <a href="#<?php echo esc_attr($widget_id); ?>" style="display: none"></a>
        </div>
      </div>

      <!-- RIGHT: content -->
      <div class="map-cta__content">
        <?php if ($intro_text): ?>
          <p class="map-cta__intro"><em><?php echo esc_html($intro_text); ?></em></p>
        <?php endif; ?>

        <?php if ($title_main || $title_accent): ?>
          <h3 class="map-cta__title">
            <?php echo esc_html($title_main); ?>
            <?php if ($title_accent): ?>
              <span class="accent"><?php echo esc_html($title_accent); ?></span>
            <?php endif; ?>
          </h3>
        <?php endif; ?>

        <?php if ($body_text): ?>
          <div class="map-cta__body">
            <?php echo wp_kses_post(wpautop($body_text)); ?>
          </div>
        <?php endif; ?>

        <div class="map-cta__buttons">
          <?php if ($one): ?>
            <a class="btn btn--teal" href="<?php echo $one['url']; ?>" target="<?php echo $one['target']; ?>">
              <?php echo esc_html($one['label']); ?>
            </a>
          <?php endif; ?>
          <?php if ($mon): ?>
            <a class="btn btn--rose" href="<?php echo $mon['url']; ?>" target="<?php echo $mon['target']; ?>">
              <?php echo esc_html($mon['label']); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>
