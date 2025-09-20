<?php
/**
 * Block Name: Landing Hero (no slider)
 * Description: Single hero with Fund selector and the new donation box design.
 */
defined('ABSPATH') || exit;

/* ----------------------------
   Helpers
----------------------------- */
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

/** Wrap the last word of a string in a span for the magenta underline */
if (!function_exists('lh_underline_last_word')) {
    function lh_underline_last_word(string $headline) : string {
        $headline = trim($headline);
        if ($headline === '') return '';
        $parts = preg_split('/\s+/', $headline);
        if (!$parts || count($parts) < 2) {
            return '<span class="u-underline">'.esc_html($headline).'</span>';
        }
        $last = array_pop($parts);
        return esc_html(implode(' ', $parts)).' <span class="u-underline">'.esc_html($last).'</span>';
    }
}

$ajaxurl   = get_stylesheet_directory_uri() . '/modules/inc/customajax.php'; // <- keep using your working endpoint
$is_mobile = function_exists('isMobile') ? (bool) isMobile() : wp_is_mobile();
$currency  = get_woocommerce_currency_symbol();

/* ----------------------------
   Hero content (ACF repeater)
----------------------------- */
$first = null;
if (have_rows('banner_items')) {
    the_row();
    $first = [
        'img_mobile'  => get_sub_field('banner_image_mobile'),
        'img_desktop' => get_sub_field('banner_image'),
        'small'       => (string) get_sub_field('banner_small_heading'),
        'head'        => (string) get_sub_field('banner_heading'),
        'text'        => (string) get_sub_field('banner_text'),
        'pos'         => (string) (get_sub_field('text_position') ?: ''),
    ];
    reset_rows();
}
$banner_url = '';
$pos = $small = $head = $text = '';
if ($first) {
    $chosen     = ($is_mobile && $first['img_mobile']) ? $first['img_mobile'] : $first['img_desktop'];
    $banner_url = dm_media_to_url($chosen, 'full');
    $pos   = $first['pos'];
    $small = $first['small'];
    $head  = $first['head'];
    $text  = $first['text'];
}

/* ----------------------------
   Funds / Project select
----------------------------- */
$proj       = get_field('project_select');
$proj       = is_array($proj) ? array_values(array_filter($proj)) : [];
$proj_count = count($proj);

// Preferred default fund
$product_id = $proj_count ? (int) $proj[0] : 0;
if (isset($_GET['fund']) && ctype_digit((string) $_GET['fund'])) {
    $product_id = (int) $_GET['fund'];
}
?>

<section class="landing-hero<?php echo $banner_url ? ' has-bg' : ''; ?>"<?php
  if ($banner_url) echo ' style="--lh-bg:url('.esc_url($banner_url).')"'; ?>>
  <div class="landing-hero__inner <?php echo esc_attr($pos ?: 'left'); ?>">
    <?php if ($small): ?><p class="lh__eyebrow"><?php echo esc_html($small); ?></p><?php endif; ?>

    <?php if ($head): ?>
      <h1 class="lh__title"><?php echo lh_underline_last_word($head); // adds the pink underline ?></h1>
    <?php endif; ?>

    <?php if ($text): ?><p class="lh__lede"><?php echo esc_html($text); ?></p><?php endif; ?>

    <?php if (get_field('enable_donation_box')): ?>
      <div class="lh__donate">
        <?php if ($proj_count > 1): ?>
          <label class="lh__fund-label" for="lh__fund">
            <?php echo esc_html(get_field('homepage_donation_heading') ?: 'Choose a fund'); ?>
          </label>
          <select id="lh__fund" class="lh__fund">
            <option value=""><?php esc_html_e('Select a fund','textdomain'); ?></option>
            <?php foreach ($proj as $pid): ?>
              <option value="<?php echo esc_attr($pid); ?>" <?php selected($pid, $product_id); ?>>
                <?php echo esc_html(get_the_title($pid)); ?>
              </option>
            <?php endforeach; ?>
          </select>
        <?php endif; ?>

        <!-- Where the AJAX donation UI is injected -->
        <div id="lh__donation-ui"
             class="lh__donation-ui"
             data-ajax="<?php echo esc_url($ajaxurl); ?>"
             data-product-id="<?php echo esc_attr($product_id); ?>"
             data-currency="<?php echo esc_attr($currency); ?>">
          <div class="lh__placeholder">
            <svg width="20" height="20" viewBox="0 0 32 32" aria-hidden="true"><polygon points="16,2 16,10 2,10 2,22 16,22 16,30 30,16"></polygon></svg>
            <?php echo $proj_count === 1 ? esc_html__('Loading donation options…','textdomain') : esc_html__('Select a fund','textdomain'); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>


<script>
(function ($) {
  function wireOneCard($card){
    if (!$card.length || $card.data('lh-wired')) return;

    // 1) Remove title & ALL product descriptions in this card
    $card.find('.quickproduct > h3').remove();
    // remove Woo "product heading" (h1 + price wrapper)
$card.find('.product__heading').remove();


    // 2) SINGLE: add "You Decide" and sync to Woo NYP field
    var pid = String($card.find('input[name="add-to-cart"]').val() || '').trim();
    if (!pid) { $card.data('lh-wired', true); return; }

    var $nyp  = $card.find('.pyppledgeamount' + pid);          // hidden NYP input Woo reads
    var $list = $card.find('.singleDonationTab .package__listing');

    if ($list.length && $nyp.length && !$list.find('li.you_pay').length) {
      var activeAmt = parseFloat($list.find('.package__listing_item.active').data('value')) || '';
      var firstAmt  = parseFloat($list.find('.package__listing_item').first().data('value'))  || '';
      var initAmt   = activeAmt || firstAmt || '';

      $list.append(
        '<li class="package__listing_item you_pay" data-project-id="'+pid+'">' +
          '<span class="inactive"></span>' +
          '<strong>' +
            '<small>You Decide</small>' +
            '<input type="number" min="1" step="1" class="single_donation your_price_single_'+pid+'" value="'+(initAmt || '')+'"/>' +
          '</strong>' +
        '</li>'
      );

      // initial NYP value
      $nyp.val(initAmt);
    }

    // Click a preset amount in Single
    $card.off('click.lhSinglePreset', '.singleDonationTab .package__listing_item')
      .on('click.lhSinglePreset', '.singleDonationTab .package__listing_item', function(e){
        if ($(this).hasClass('you_pay')) return;        // handled below
        e.preventDefault();
        var $li = $(this);
        $li.addClass('active').siblings('.package__listing_item').removeClass('active');
        var v = parseFloat($li.data('value')) || '';
        $card.find('.your_price_single_'+pid).val('');  // clear custom when preset chosen
        $nyp.val(v);
      });

    // Click the You Decide row -> activate + focus + sync
    $card.off('click.lhYouPay', '.singleDonationTab .package__listing_item.you_pay')
      .on('click.lhYouPay', '.singleDonationTab .package__listing_item.you_pay', function(e){
        if ($(e.target).is('input')) return;
        e.preventDefault();
        var $li = $(this);
        $li.addClass('active').siblings('.package__listing_item').removeClass('active');
        var $inp = $li.find('input[type="number"]');
        $inp.trigger('focus');
        $nyp.val(parseFloat($inp.val()) || '');
      });

    // Typing in You Decide -> sync NYP and mark active
    $card.off('input.lhYouPayInput', '.your_price_single_'+pid)
      .on('input.lhYouPayInput', '.your_price_single_'+pid, function(){
        var v = parseFloat(this.value) || '';
        $nyp.val(v);
        $(this).closest('.you_pay').addClass('active').siblings('.package__listing_item').removeClass('active');
      });

    // Hide legacy NYP table/qty for Single (belt & braces)
    $card.find('.singleDonationTab .variations.payyourprice_customize_class, .singleDonationTab + table, .singleDonationTab .quantity').hide();

    // Recurring: clicking presets updates the recurring custom input
    $card.off('click.lhRecurring', '.package__listing_item_recurring').on('click.lhRecurring', '.package__listing_item_recurring', function(e){
      if ($(e.target).is('input')) return;
      e.preventDefault();
      var $li = $(this);
      $li.addClass('active').siblings('.package__listing_item_recurring').removeClass('active');
      var pidR = $li.data('project-id');
      var amtR = parseFloat($li.data('value')) || '';
      if (pidR) $card.find('.your_price_recurring_'+pidR).val(amtR);
    });

    $card.data('lh-wired', true);
  }

  // Process any existing cards inside the hero donation UI
  window.lhFixDonationCard = function(rootSel){
    var $root = $(rootSel || '#lh__donation-ui');
    $root.find('.pop-up-product').each(function(){ wireOneCard($(this)); });
  };

  // Observe the container for swaps/reloads and re-wire
  window.lhObserveDonationUI = function(rootSel){
    var root = document.querySelector(rootSel || '#lh__donation-ui');
    if (!root) return;
    var mo = new MutationObserver(function(){
      window.lhFixDonationCard(rootSel);
    });
    mo.observe(root, { childList: true, subtree: true });
    // first pass
    window.lhFixDonationCard(rootSel);
  };
})(jQuery);

// Call this RIGHT AFTER you inject the AJAX html:
lhObserveDonationUI('#lh__donation-ui');
</script>
