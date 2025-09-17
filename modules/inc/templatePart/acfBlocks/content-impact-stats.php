<?php
/**
 * Block: Impact Stats (animated)
 */
defined('ABSPATH') || exit;

$block_id = 'impact-stats-' . wp_unique_id();

/** Headline & copy */
$headline      = get_field('headline');             // e.g. A MOVEMENT BIGGER THAN ANY ONE GIFT
$lede_top      = get_field('lede_top');             // WYSIWYG or text
$lede_bottom   = get_field('lede_bottom');          // WYSIWYG or text

/** Gradient (same fields as before) */
$start = get_field('gradient_start') ?: '#0f8a8b';
$end   = get_field('gradient_end')   ?: '#1fb0a5';
$angle = (int) (get_field('gradient_angle') ?: 90); // 90deg = left→right

/** Numbers */
$items         = get_field('stats');                // repeater rows
$cols_desktop  = (int) (get_field('columns_desktop') ?: 3);
$duration_ms   = (int) (get_field('anim_duration') ?: 1200);

$style = sprintf(
  '--grad-start:%s;--grad-end:%s;--grad-angle:%sdeg;--anim-duration:%sms;',
  esc_attr($start), esc_attr($end), esc_attr($angle), esc_attr($duration_ms)
);
?>
<section id="<?php echo esc_attr($block_id); ?>" class="impact-stats" style="<?php echo $style; ?>">
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
          $use_sep = !empty($row['thousands_sep']); // true/false
          $label1  = $row['label_line_1'] ?? '';
          $label2  = $row['label_line_2'] ?? '';
        ?>
          <li class="impact-stats__item">
            <div class="impact-stats__value"
                 data-target="<?php echo esc_attr($number); ?>"
                 data-prefix="<?php echo esc_attr($prefix); ?>"
                 data-suffix="<?php echo esc_attr($suffix); ?>"
                 data-sep="<?php echo $use_sep ? '1' : '0'; ?>">
              <?php
                // initial (non-animated) fallback for no-JS
                echo esc_html($prefix . ($use_sep ? number_format($number) : $number) . $suffix);
              ?>
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
  // EASING + HELPERS
  const easeOutQuad = t => t * (2 - t);
  const format = (n, sep) => sep ? Number(n).toLocaleString() : String(n);

  function animateCount(el, duration) {
    const target = parseFloat(el.getAttribute('data-target') || '0') || 0;
    const prefix = el.getAttribute('data-prefix') || '';
    const suffix = el.getAttribute('data-suffix') || '';
    const useSep = el.getAttribute('data-sep') === '1';

    // Respect reduced motion
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

    // Default duration (ms); element can override via CSS var: --anim-duration
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

  // Init on page load
  if (document.readyState !== 'loading') initCountUps();
  else document.addEventListener('DOMContentLoaded', () => initCountUps());

  // Re-init inside ACF editor previews
  if (window.acf && window.acf.addAction) {
    window.acf.addAction('render_block_preview', $el => {
      if ($el && $el[0]) initCountUps($el[0]);
    });
  }
})();
</script>
