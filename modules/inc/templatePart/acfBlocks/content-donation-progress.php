<?php
/**
 * Block: Donation Progress
 */
defined('ABSPATH') || exit;

$block_id = 'don-progress-' . wp_unique_id();

/* FIELDS */
$raised      = (float) (get_field('raised_amount') ?: 0);
$goal        = (float) (get_field('goal_amount')   ?: 0);
$currency    = (string) (get_field('currency_symbol') ?: '$');
$show_cents  = (bool)   get_field('show_cents');
$btn         = get_field('button_link');
$btn_label   = (string) (get_field('button_label') ?: 'Donate Now');
$bar_color   = (string) (get_field('bar_color') ?: '#0a61ff');
$track_color = (string) (get_field('track_color') ?: '#ffffff');
$track_border= (string) (get_field('track_border_color') ?: '#0a61ff');
$accent_btn  = (string) (get_field('button_accent') ?: '#c13b5a');

/* FundraiseUp product (optional) – opens popup if set */
$popup_product_id = 0;
$rel = get_field('donation_projects');
if ($rel) {
  $first = is_array($rel) ? reset($rel) : $rel;
  if (is_object($first) && isset($first->ID))       $popup_product_id = (int)$first->ID;
  elseif (is_array($first) && !empty($first['ID'])) $popup_product_id = (int)$first['ID'];
  elseif (is_numeric($first))                       $popup_product_id = (int)$first;
}

/* CALCS */
$percent = ($goal > 0) ? max(0, min(100, round(($raised / $goal) * 100))) : 0;

$fmt = function($n) use ($show_cents) {
  return number_format($n, $show_cents ? 2 : 0);
};

$style_vars = sprintf('--bar:%s;--track:%s;--track-border:%s;--accent:%s;',
  esc_attr($bar_color), esc_attr($track_color), esc_attr($track_border), esc_attr($accent_btn)
);
?>
<section id="<?php echo esc_attr($block_id); ?>" class="donation-progress" style="<?php echo $style_vars; ?>">
  <div class="donation-progress__inner">
    <div class="donation-progress__row">
      <div class="donation-progress__raised">
        <?php echo esc_html("{$currency}{$fmt($raised)} raised"); ?>
      </div>
      <div class="donation-progress__goal">
        <?php echo esc_html("{$currency}{$fmt($goal)} goal"); ?>
      </div>
    </div>

    <div class="donation-progress__barwrap">
      <div
        class="donation-progress__bar"
        role="progressbar"
        aria-valuemin="0"
        aria-valuemax="<?php echo (int) ($goal > 0 ? 100 : 0); ?>"
        aria-valuenow="<?php echo (int) $percent; ?>"
        aria-label="<?php echo esc_attr("{$percent}% of goal"); ?>"
      >
        <span class="donation-progress__fill" style="width: <?php echo (int)$percent; ?>%;"></span>
      </div>
    </div>
    <span class="donation-progress__label"><?php echo (int)$percent; ?>%</span>

    <?php if ($btn_label && ($popup_product_id || (is_array($btn) && !empty($btn['url'])))): ?>
      <p class="donation-progress__cta">
        <?php if ($popup_product_id): ?>
          <a href="#"
             class="btn-cta js-donate-popup"
             data-project-id="<?php echo (int)$popup_product_id; ?>"
             aria-haspopup="dialog"
             aria-controls="continue_shopping_popup">
            <span class="btn-cta__label"><?php echo esc_html($btn_label); ?></span>
          </a>
        <?php else:
          $btn_url    = esc_url($btn['url']);
          $btn_target = !empty($btn['target']) ? esc_attr($btn['target']) : '_self'; ?>
          <a class="btn-cta" href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
            <span class="btn-cta__label"><?php echo esc_html($btn_label); ?></span>
          </a>
        <?php endif; ?>
      </p>
    <?php endif; ?>
  </div>
</section>
