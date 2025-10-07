<?php
/**
 * Block: Impact Stats (animated) — with optional background image
 */
defined('ABSPATH') || exit;

$block_id = 'impact-stats-' . wp_unique_id();

/** Headline & copy */
$headline      = get_field('headline');
$lede_top      = get_field('lede_top');
$lede_bottom   = get_field('lede_bottom');

/** Gradient (fallback) */
$start = get_field('gradient_start') ?: '#0f8a8b';
$end   = get_field('gradient_end')   ?: '#1fb0a5';
$angle = (int) (get_field('gradient_angle') ?: 90);

/** Optional background image */
$bg_id      = (int) (get_field('background_image') ?: 0);
$bg_m_id    = (int) (get_field('background_image_mobile') ?: 0);
$bg_url     = $bg_id   ? wp_get_attachment_image_url($bg_id, 'full') : '';
$bg_m_url   = $bg_m_id ? wp_get_attachment_image_url($bg_m_id, 'full') : '';
$bg_pos     = (string) (get_field('bg_focal') ?: 'center center');
$bg_overlay = (string) (get_field('bg_overlay') ?: 'rgba(0,0,0,.35)');

$has_image  = (bool) $bg_url;

/** Numbers */
$items         = get_field('stats');
$cols_desktop  = (int) (get_field('columns_desktop') ?: 3);
$duration_ms   = (int) (get_field('anim_duration') ?: 1200);

/** CSS vars */
$style = sprintf(
  '--grad-start:%s;--grad-end:%s;--grad-angle:%sdeg;--anim-duration:%sms;%s%s%s%s',
  esc_attr($start),
  esc_attr($end),
  esc_attr($angle),
  esc_attr($duration_ms),
  $has_image ? '--bg:' . sprintf('url(%s);', esc_url($bg_url)) : '',
  $has_image && $bg_m_url ? '--bg-mobile:' . sprintf('url(%s);', esc_url($bg_m_url)) : '',
  $has_image ? '--bg-pos:' . esc_attr($bg_pos) . ';' : '',
  $has_image ? '--bg-overlay:' . esc_attr($bg_overlay) . ';' : ''
);
?>
<section
  id="<?php echo esc_attr($block_id); ?>"
  class="impact-stats<?php echo $has_image ? ' has-image' : ''; ?>"
  style="<?php echo $style; ?>"
>
  <?php if ($has_image): ?>
    <div class="impact-stats__bg" aria-hidden="true"></div>
    <!-- <div class="impact-stats__overlay" aria-hidden="true"></div> -->
  <?php endif; ?>

  <div class="impact-stats__inner">
    <?php if ($headline): ?>
      <h2 class="impact-stats__headline"><?php echo esc_html($headline); ?></h2>
    <?php endif; ?>

    <?php if ($lede_top): ?>
      <div class="impact-stats__lede impact-stats__lede--top"><?php echo wp_kses_post($lede_top); ?></div>
    <?php endif; ?>

    <?php if ($lede_bottom): ?>
      <div class="impact-stats__lede impact-stats__lede--bottom"><?php echo wp_kses_post($lede_bottom); ?></div>
    <?php endif; ?>

    <?php if (is_array($items) && $items): ?>
      <ul class="impact-stats__grid impact-stats__grid--cols-<?php echo (int) $cols_desktop; ?>" role="list">
        <?php foreach ($items as $row):
          $prefix  = trim((string)($row['prefix'] ?? ''));
          $number  = (int) ($row['number'] ?? 0);
          $suffix  = trim((string)($row['suffix'] ?? ''));
          $use_sep = !empty($row['thousands_sep']);
          $label1  = $row['label_line_1'] ?? '';
          $label2  = $row['label_line_2'] ?? '';
        ?>
          <li class="impact-stats__item">
            <div class="impact-stats__value"
                 data-target="<?php echo esc_attr($number); ?>"
                 data-prefix="<?php echo esc_attr($prefix); ?>"
                 data-suffix="<?php echo esc_attr($suffix); ?>"
                 data-sep="<?php echo $use_sep ? '1' : '0'; ?>">
              <?php echo esc_html($prefix . ($use_sep ? number_format($number) : $number) . $suffix); ?>
            </div>
            <div class="impact-stats__label">
              <?php if ($label1): ?><div class="l1"><?php echo esc_html($label1); ?></div><?php endif; ?>
              <?php if ($label2): ?><div class="l2"><?php echo esc_html($label2); ?></div><?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</section>

<script>
(function () {
  const easeOutQuad = t => t * (2 - t);
  const format = (n, sep) => sep ? Number(n).toLocaleString() : String(n);

  function animateCount(el, duration) {
    const target = parseFloat(el.getAttribute('data-target') || '0') || 0;
    const prefix = el.getAttribute('data-prefix') || '';
    const suffix = el.getAttribute('data-suffix') || '';
    const useSep = el.getAttribute('data-sep') === '1';

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      el.textContent = prefix + format(Math.round(target), useSep) + suffix;
      return;
    }

    let startTs;
    function step(ts) {
      if (!startTs) startTs = ts;
      const p = Math.min(1, (ts - startTs) / duration);
      const val = Math.round(easeOutQuad(p) * target);
      el.textContent = prefix + format(val, useSep) + suffix;
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  function initCountUps(root = document, opts = {}) {
    const values = root.querySelectorAll('.impact-stats__value');
    if (!values.length) return;
    const defaultDur = opts.duration || 1200;

    if (!('IntersectionObserver' in window)) {
      values.forEach(el => {
        const dur = parseInt(getComputedStyle(el).getPropertyValue('--anim-duration')) || defaultDur;
        animateCount(el, dur);
      });
      return;
    }

    const io = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        const el = entry.target;
        if (!entry.isIntersecting || el.__counted) return;
        el.__counted = true;
        const dur = parseInt(getComputedStyle(el).getPropertyValue('--anim-duration')) || defaultDur;
        animateCount(el, dur);
        io.unobserve(el);
      });
    }, { threshold: 0.25, rootMargin: '0px 0px -10% 0px' });

    values.forEach(el => io.observe(el));
  }

  if (document.readyState !== 'loading') initCountUps();
  else document.addEventListener('DOMContentLoaded', () => initCountUps());
})();
</script>
