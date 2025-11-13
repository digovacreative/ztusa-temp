<?php
defined('ABSPATH') || exit;

$block_id = 'fru-split-cta-' . wp_unique_id();

$fru_id   = (string) get_field('fru_container_id'); // required
$heading  = (string) get_field('heading');
$p1       = (string) get_field('para_1');
$p2       = (string) get_field('para_2');
$accent   = (string) (get_field('accent_color') ?: '#c13b5a');
$bg       = (string) (get_field('bg_color') ?: '#fff');
$pad      = (int) (get_field('pad') ?: 24);
$radius   = (int) (get_field('radius') ?: 14);
$shadow   = (bool) get_field('card_shadow');
 

$cls = 'fru-split-cta';
if ($shadow) $cls .= ' has-shadow';

$style_vars = sprintf('--accent:%s;--bg:%s;--pad:%dpx;--radius:%dpx;',
  esc_attr($accent), esc_attr($bg), $pad, $radius
);
?>
<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($cls); ?>" style="<?php echo $style_vars; ?>">
  <div class="fru-split-cta__grid">

    <!-- LEFT: FundraiseUp mount point (FRU JS will replace/size) -->
    <div class="fru-split-cta__widget">
      <div id="<?php echo esc_attr($fru_id); ?>" class="fru-split-cta__card" aria-live="polite"></div>

 
    </div>

    <!-- RIGHT: Copy -->
    <div class="fru-split-cta__copy">
      <?php if ($heading): ?>
        <h2 class="fru-split-cta__heading"><?php echo wp_kses_post(nl2br(esc_html($heading))); ?></h2>
      <?php endif; ?>

      <?php if ($p1): ?>
        <p class="fru-split-cta__p fru-split-cta__p--main"><?php echo wp_kses_post(nl2br(esc_html($p1))); ?></p>
      <?php endif; ?>

      <?php if ($p2): ?>
        <p class="fru-split-cta__p fru-split-cta__p--accent"><?php echo wp_kses_post(nl2br(esc_html($p2))); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
