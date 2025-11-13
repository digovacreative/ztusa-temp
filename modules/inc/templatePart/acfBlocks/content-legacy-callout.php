<?php
    /**
     * Block: Legacy Callout (popup-aware) — with background image + stats + countdown
     */
    defined('ABSPATH') || exit;

    /* Helpers (unchanged) */
    if (! function_exists('dm_try_product_id_from_url')) {
        function dm_try_product_id_from_url(?string $url): int
        {
            if (! $url) {
                return 0;
            }

            if (! function_exists('url_to_postid')) {
                return 0;
            }

            $pid = url_to_postid($url);
            return ($pid && get_post_type($pid) === 'product') ? (int) $pid : 0;
        }
    }
    if (! function_exists('dm_first_post_id')) {
        function dm_first_post_id($rel): int
        {
            if (! is_array($rel) || empty($rel)) {
                return 0;
            }

            $first = $rel[0];
            if (is_object($first) && isset($first->ID)) {
                return (int) $first->ID;
            }

            if (is_array($first) && ! empty($first['ID'])) {
                return (int) $first['ID'];
            }

            if (is_numeric($first)) {
                return (int) $first;
            }

            return 0;
        }
    }

    $block_id = 'legacy-callout-' . wp_unique_id();

    /* Width + gradient (fallback) */
    $width = get_field('width') ?: 'full'; // 'full' | 'half'
    $start = get_field('gradient_start') ?: '#0f8a8b';
    $end   = get_field('gradient_end') ?: '#1fb0a5';
    $angle = (int) (get_field('gradient_angle') ?: 135);

    /* Background image fields (existing) */
    $bg_id    = (int) (get_field('background_image') ?: 0);
    $bg_m_id  = (int) (get_field('background_image_mobile') ?: 0);
    $bg_url   = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : '';
    $bg_m_url = $bg_m_id ? wp_get_attachment_image_url($bg_m_id, 'full') : $bg_url;
    $bg_focal = (string) (get_field('background_focal') ?: 'center center');
    $overlay  = (string) (get_field('overlay_color') ?: 'rgba(0,0,0,.35)');

    $content = get_field('content');
    $link    = get_field('button_link');

    /* Button */
    $btn_url = $btn_title = $btn_target = '';
    if (is_array($link)) {
        $btn_url    = ! empty($link['url']) ? esc_url($link['url']) : '';
        $btn_title  = ($link['title'] ?? '') !== '' ? $link['title'] : 'Donate Now';
        $btn_target = ! empty($link['target']) ? esc_attr($link['target']) : '_self';
    }

    /* Popup target product */
    $popup_product_id = dm_first_post_id((array) get_field('donation_projects'));
    if (! $popup_product_id && $btn_url) {
        $maybe = dm_try_product_id_from_url($btn_url);
        if ($maybe) {
            $popup_product_id = $maybe;
        }

    }

    /* NEW FIELDS (add these to ACF):
   - stats_raised (number)           e.g. 3744.70
   - stats_goal   (number)           e.g. 8000
   - stats_text   (text)             e.g. "Help us reach 10,000 families - 6,500 protected so far."
   - side_image   (image)            right-side image under countdown
   - countdown_end (date time picker) ISO "YYYY-MM-DD HH:MM:SS"
*/
    $raised  = (float) (get_field('stats_raised') ?: 0);
    $goal    = (float) (get_field('stats_goal') ?: 0);
    $stats   = (string) (get_field('stats_text') ?: '');
    $percent = ($goal > 0) ? max(0, min(100, round(($raised / $goal) * 100))) : 0;

    // Side image: accept array (Image Array), ID, or URL
    $side_img_raw = get_field('side_image');

    $side_img_id  = 0;
    $side_img_url = '';

    if (is_array($side_img_raw)) {
        // ACF Image Array: try ID first, then url
        if (! empty($side_img_raw['ID'])) {
            $side_img_id = (int) $side_img_raw['ID'];
        } elseif (! empty($side_img_raw['id'])) {
            $side_img_id = (int) $side_img_raw['id'];
        } elseif (! empty($side_img_raw['url'])) {
            $side_img_url = $side_img_raw['url'];
        }
    } elseif (is_numeric($side_img_raw)) {
        $side_img_id = (int) $side_img_raw; // Image ID
    } elseif (is_string($side_img_raw) && $side_img_raw !== '') {
        $side_img_url = $side_img_raw; // Direct URL string
    }

    // Resolve final URL if we have an ID
    if (! $side_img_url && $side_img_id) {
        $side_img_url = wp_get_attachment_image_url($side_img_id, 'large');
    }

    $cd_end_raw  = get_field('countdown_end');               // string or null
    $cd_end_attr = $cd_end_raw ? esc_attr($cd_end_raw) : ''; // pass as data attr
    // What do we actually have?
    $has_stats       = (bool) ($goal || $raised || $stats);
    $has_side_image  = (bool) ($side_img_id || $side_img_url);
    $has_countdown   = ! empty($cd_end_attr);
    $has_image_timer = ($has_side_image || $has_countdown);
    $has_cta         = (bool) ($btn_title && ($btn_url || $popup_product_id));

    /* Build inline style vars */
    $style = $bg_url
        ? sprintf('--bg:url(%s);--bg-mobile:url(%s);--bg-pos:%s;--bg-overlay:%s;',
        esc_url($bg_url),
        esc_url($bg_m_url ?: $bg_url),
        esc_attr($bg_focal),
        esc_attr($overlay)
    )
        : sprintf('--grad-start:%s;--grad-end:%s;--grad-angle:%sdeg;',
        esc_attr($start), esc_attr($end), esc_attr($angle)
    );

    $width_class = $width === 'half' ? 'is-half-md' : 'is-full';
?>
<div class="gutenberg__wrap">
    <section id="<?php echo esc_attr($block_id); ?>"
        class="legacy-callout<?php echo $bg_url ? ' has-image' : ' has-gradient'; ?>" style="<?php echo $style; ?>">
        <?php if ($bg_url): ?>
        <div class="legacy-callout__bg" aria-hidden="true"></div>
        <!-- <div class="legacy-callout__overlay" aria-hidden="true"></div> -->
        <?php endif; ?>

        <div class="legacy-callout__inner                                      <?php echo esc_attr($width_class); ?>">
            <?php if ($content): ?>
            <div class="legacy-callout__content">
                <?php echo wp_kses_post($content); ?>
            </div>
            <?php endif; ?>

            <?php if ($has_stats || $has_image_timer): ?>
            <!-- NEW: two-panel layout -->
            <div
                class="legacy-callout__panels<?php echo ($has_stats && $has_image_timer) ? ' legacy-callout__panels--two' : ' legacy-callout__panels--single'; ?>">

                <!-- LEFT: white stats card (only if stats are set) -->
                <?php if ($has_stats): ?>
                <div class="legacy-callout__stats-card">
                    <?php if ($goal || $raised): ?>
                    <div class="legacy-callout__stats-row">
                        <strong class="legacy-callout__raised">
                            <?php echo esc_html(sprintf('$%s raised', number_format($raised, 2))); ?>
                        </strong>
                        <?php if ($goal): ?>
                        <span class="legacy-callout__goal">
                            <?php echo esc_html(sprintf('$%s goal', number_format($goal, 0))); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <?php if ($stats): ?>
                    <p class="legacy-callout__note"><?php echo esc_html($stats); ?></p>
                    <?php endif; ?>
                    <div class="legacy-callout__bar">
                        <span class="legacy-callout__bar-fill"
                            style="width: <?php echo (int) $percent; ?>%;"></span>
                        <span class="legacy-callout__bar-label"><?php echo (int) $percent; ?>%</span>
                    </div>
                    <?php elseif ($stats): ?>
                    <!-- Text-only stats case -->
                    <p class="legacy-callout__note"><?php echo esc_html($stats); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- RIGHT: image + countdown (only if configured) -->
                <?php if ($has_image_timer): ?>
                <div class="legacy-callout__image-timer">
                    <?php if ($has_side_image): ?>
                    <figure class="legacy-callout__figure">
                        <?php
                        if ($side_img_id) {
                            echo wp_get_attachment_image($side_img_id, 'large', false, ['loading' => 'lazy']);
                        } else {
                            echo '<img src="' . esc_url($side_img_url) . '" alt="" loading="lazy">';
                        }
                        ?>
                    </figure>
                    <?php endif; ?>

                    <?php if ($has_countdown): ?>
                    <div class="legacy-callout__countdown" data-end="<?php echo esc_attr($cd_end_attr); ?>">
                        <div class="cd__cell">
                            <span class="cd__num" data-unit="hours">00</span>
                            <span class="cd__lbl">HOURS</span>
                        </div>
                        <div class="cd__cell">
                            <span class="cd__num" data-unit="mins">00</span>
                            <span class="cd__lbl">MINS</span>
                        </div>
                        <div class="cd__cell">
                            <span class="cd__num" data-unit="secs">00</span>
                            <span class="cd__lbl">SECS</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
            <!-- /two-panel layout -->
            <?php endif; ?>

            <?php if ($has_cta): ?>
            <!-- Full-width, centered donate button -->
            <p class="legacy-callout__cta legacy-callout__cta--center" style="text-align:center;">
                <?php if ($popup_product_id): ?>
                <a href="#" class="btn-cta js-donate-popup"
                    data-project-id="<?php echo (int) $popup_product_id; ?>" aria-haspopup="dialog"
                    aria-controls="continue_shopping_popup">
                    <span class="btn-cta__icon" aria-hidden="true">❤</span>
                    <span class="btn-cta__label"><?php echo esc_html($btn_title); ?></span>
                </a>
                <?php else: ?>
                <a class="btn-cta" href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
                    <span class="btn-cta__label"><?php echo esc_html($btn_title); ?></span>
                </a>
                <?php endif; ?>
            </p>
            <?php endif; ?>

        </div>
    </section>
</div>

<?php
    /* Tiny inline countdown (scoped to this section) */
add_action('wp_footer', function () use ($block_id) {?>
<script>
(function() {
    const root = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!root) return;
    const cd = root.querySelector('.legacy-callout__countdown');
    if (!cd) return;
    const endAttr = cd.getAttribute('data-end');
    if (!endAttr) return;
    const end = new Date(endAttr.replace(' ', 'T')); // tolerate "YYYY-MM-DD HH:MM:SS"
    if (isNaN(end.getTime())) return;

    function pad(n) {
        return String(n).padStart(2, '0');
    }

    function tick() {
        const now = new Date();
        let diff = Math.max(0, end - now);
        const hrs = Math.floor(diff / 36e5);
        diff -= hrs * 36e5;
        const mins = Math.floor(diff / 6e4);
        diff -= mins * 6e4;
        const secs = Math.floor(diff / 1e3);
        cd.querySelector('[data-unit="hours"]').textContent = pad(hrs);
        cd.querySelector('[data-unit="mins"]').textContent = pad(mins);
        cd.querySelector('[data-unit="secs"]').textContent = pad(secs);
        if (end - now <= 0) clearInterval(iv);
    }
    tick();
    const iv = setInterval(tick, 1000);
})();
</script>
<?php }, 99);