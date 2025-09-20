<?php
/**
 * Block: Donation Page (with heading + left/center/right layout)
 */
defined('ABSPATH') || exit;

$block_id  = 'donation-page-' . wp_unique_id();

/** New heading fields **/
$h_main    = trim((string) get_field('heading_main'))   ?: 'Every Child Deserves a Chance to';
$h_accent  = trim((string) get_field('heading_accent')) ?: 'Give';

/** New layout control: left | center | right **/
$align     = (string) (get_field('layout_align') ?: 'left'); // left/center/right

$products  = get_field('donation_projects');
$products  = is_array($products) ? array_filter(array_map('intval', $products)) : [];

/** Your custom endpoint (leave as-is) **/
$ajax_url  = get_stylesheet_directory_uri() . '/modules/inc/customajax.php';

/** Process-state helper (evaluated server-side) **/
$has_recurring = function_exists('check_recurring_cart') ? (int) check_recurring_cart() : 0;
$has_single    = function_exists('check_single_cart')    ? (int) check_single_cart()    : 0;
$process_state = ($has_recurring && $has_single) ? 'both' : ($has_recurring ? 'recurring' : ($has_single ? 'single' : ''));

/** Checkout URL guard **/
$checkout_url  = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '/checkout/';
?>
<div id="<?php echo esc_attr($block_id); ?>"
     class="gutenberg__wrap donation-page-block donation-page--<?php echo esc_attr($align); ?>"
     data-ajax="<?php echo esc_url($ajax_url); ?>"
     data-process="<?php echo esc_attr($process_state); ?>">

  <!-- Heading -->
  <header class="donation-page__header">
    <h1 class="donation-hero__heading">
      <?php echo esc_html($h_main); ?>
      <span class="accent"><?php echo esc_html($h_accent); ?></span>
    </h1>
  </header>

  <!-- Shell that we position left/center/right -->
  <div class="donation-page__shell">
    <div class="donation_box_page medium_box">

      <div class="continue_or_checkout_box" aria-live="polite">
        <span aria-hidden="true">
          <svg viewBox="0 0 512 512" width="24" height="24" role="img" aria-label="Added">
            <path d="M436.7,85.7c-50-50-131-50-181,0l-1.1,1.1c-50-50-130.6-50.5-180-1.1c-49.4,49.4-48.9,130,1.1,180l179.9,182.1 l181-181C486.6,216.8,486.6,135.7,436.7,85.7z M414,244.1L255.6,402.5L119.9,266.7L98.3,243c-37.4-37.4-37.9-97.8-1.1-134.7 C114.9,90.7,138.4,81,163.6,81c25.7,0,50,10.1,68.3,28.4l22.6,22.6l22.6-22.6c19.2-19.2,43.3-29.2,69-29.2 c25.6,0,49.8,10,67.9,28.1C451.4,145.8,451.4,206.7,414,244.1z"/>
            <polygon points="192.7,209.7 176,227.5 247.2,294.1 389,128.9 370.5,112.9 245.2,258.8"/>
          </svg>
        </span>
        <h3>Donation Added</h3>
        <div class="button_wrapper">
          <a href="<?php echo esc_url($checkout_url); ?>" class="button borderStyle till woo_checkout_button">Checkout</a>
          <a href="#" class="button till woo_continue_button">Donate More</a>
        </div>
      </div>

      <section class="donation_listing" style="width:100%;">
        <div id="product_steps_status" aria-live="polite"></div>

        <?php if (!empty($products)) : ?>
          <ul class="product__listing" role="list">
            <?php foreach ($products as $pid) :
              $title = get_the_title($pid);
              $icon  = get_field('product_icon', $pid); // URL expected
            ?>
              <li class="product__item_box trigger__donation_box aos-item"
                  data-project-id="<?php echo esc_attr($pid); ?>"
                  data-aos="fade-up"
                  role="listitem">
                <button type="button" class="product__wrap" aria-label="<?php echo esc_attr($title ? "Select $title" : 'Select project'); ?>">
                  <?php if ($icon) : ?>
                    <figure class="product__figure">
                      <img src="<?php echo esc_url($icon); ?>" class="product__image" alt="" loading="lazy" />
                    </figure>
                  <?php endif; ?>
                  <div class="project__caption">
                    <h3><?php echo esc_html($title ?: 'Untitled Project'); ?></h3>
                  </div>
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <?php if (is_admin()) : ?>
            <p><em>No products selected. Choose items in the block’s “Donation Projects” field.</em></p>
          <?php endif; ?>
        <?php endif; ?>

        <div id="product_details_box" class="donate_page" aria-live="polite"></div>
      </section>

      <?php if (!function_exists('isMobile') || !isMobile()) : ?>
        <aside class="cart_sidebar"></aside>
      <?php endif; ?>

      <div class="continue_shopping_popup" id="continue_shopping_popup" aria-live="polite"></div>

    </div>
  </div>
</div>

<script>
(function($){
  var $root   = $('#<?php echo esc_js($block_id); ?>');
  if (!$root.length) return;

  var ajaxurl = $root.data('ajax');
  var process = ($root.data('process') || '').toString();

  function ajax_before(){ $('body').addClass('loading'); }
  function ajax_after(){  $('body').removeClass('loading'); }

  function load_steps(step, proc){
    $.post(ajaxurl, { action: 'loadstep', step: step, process: proc }, function(html){
      $('#<?php echo esc_js($block_id); ?> #product_steps_status').html(html);
    });
  }

  function load_cart(status){
    ajax_before();
    $.post(ajaxurl, { action: 'loadcart', status: status || '', onepagecart: 'onepage' }, function(html){
      ajax_after();
      $('#<?php echo esc_js($block_id); ?> #continue_shopping_popup').html(html);
      $('body').removeClass('popup_active');
    });
  }

  function load_project(id){
    if (!id) return;
    ajax_before();
    $.post(ajaxurl, { action: 'loadproject', project_id: id, overlay: 'false' }, function(html){
      ajax_after();
      $('#<?php echo esc_js($block_id); ?> #product_details_box').addClass('active').html(html);
      load_steps('2', process);
    });
  }

  // Init
  load_cart();
  load_steps('1', process);

  // Select project
  $root.on('click', '.trigger__donation_box .product__wrap', function(e){
    e.preventDefault();
    var $li = $(this).closest('.trigger__donation_box');
    var id  = $li.data('project-id');
    $root.find('.trigger__donation_box').removeClass('activeProject');
    $li.addClass('activeProject');
    $root.find('.product__listing').addClass('active');
    load_project(id);
  });

  // Continue shopping
  $root.on('click', '.woo_continue_button', function(e){
    e.preventDefault();
    $('body').removeClass('added_to_cart');
    $root.find('.trigger__donation_box').removeClass('activeProject');
    load_steps('1', process);
  });
})(jQuery);
</script>
