<?php
function load_project_function() {
    $product_id = isset($_POST['project_id']) ? (int) $_POST['project_id'] : 0;
    $currency   = get_woocommerce_currency_symbol();

    // presets (tweak as needed or pull from ACF)
    $single_presets    = [5, 10, 50];
    $recurring_presets = [5, 10, 20];

    // If no product, show disabled state (same behaviour as your old overlay)
    $no_id = $product_id ? '' : 'no_id';
    ?>
    <div class="donate-card <?= esc_attr($no_id); ?>"
         data-product-id="<?= esc_attr($product_id); ?>"
         data-currency="<?= esc_attr($currency); ?>">
      <div class="donate-tabs">
        <button class="donate-tab active" data-tab="single" aria-selected="true">Single Donation</button>
        <button class="donate-tab" data-tab="recurring" aria-selected="false">Regular Donation</button>
      </div>

      <!-- SINGLE -->
      <div class="donate-panel" data-panel="single">
        <ul class="donate-options">
          <?php foreach ($single_presets as $i=>$amt): ?>
            <li class="donate-option <?= $i===0?'active':''; ?>" data-amount="<?= esc_attr($amt); ?>">
              <span class="dot"></span><strong><?= esc_html($currency.$amt); ?></strong>
            </li>
          <?php endforeach; ?>
        </ul>
        <label class="custom-row">
          <span class="dot"></span><span>Custom Donation: <?= esc_html($currency); ?></span>
        </label>
        <input type="number" min="1" step="1" class="donate-input" inputmode="numeric"
               value="<?= esc_attr($single_presets[0]); ?>">
        <button class="donate-submit">DONATE NOW</button>
      </div>

      <!-- RECURRING -->
      <div class="donate-panel" data-panel="recurring" hidden>
        <ul class="donate-options">
          <?php foreach ($recurring_presets as $i=>$amt): ?>
            <li class="donate-option <?= $i===0?'active':''; ?>" data-amount="<?= esc_attr($amt); ?>">
              <span class="dot"></span><strong><?= esc_html($currency.$amt); ?></strong>
            </li>
          <?php endforeach; ?>
        </ul>
        <label class="custom-row">
          <span class="dot"></span><span>Custom Donation: <?= esc_html($currency); ?></span>
        </label>
        <input type="number" min="1" step="1" class="donate-input" inputmode="numeric"
               value="<?= esc_attr($recurring_presets[0]); ?>">
        <button class="donate-submit">DONATE NOW</button>
      </div>
    </div>

    <style>
      /* minimal styles to match your screenshot; adjust in theme CSS if you prefer */
      .donate-card{background:#fff;border-radius:10px;padding:16px;max-width:380px}
      .donate-tabs{display:flex;gap:10px;margin-bottom:12px}
      .donate-tab{flex:1;border:1px solid #21c2a2;background:#fff;border-radius:8px;padding:10px;font-weight:600}
      .donate-tab.active{background:#21c2a2;color:#fff}
      .donate-options{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:10px 0 6px;padding:0;list-style:none}
      .donate-option{display:flex;align-items:center;gap:10px;border:1px solid #e5e7eb;border-radius:8px;padding:10px}
      .donate-option.active{border-color:#21c2a2;box-shadow:0 0 0 2px rgba(33,194,162,.15)}
      .dot{width:10px;height:10px;border-radius:50%;background:#21c2a2;display:inline-block}
      .custom-row{display:flex;align-items:center;gap:10px;margin:6px 0}
      .donate-input{width:120px;padding:8px;border:1px solid #e5e7eb;border-radius:6px}
      .donate-submit{width:100%;margin-top:12px;border:0;border-radius:10px;padding:12px 16px;color:#fff;
        background:linear-gradient(90deg,#ff2d9b,#ff6537);font-weight:700}
      .donate-card.no_id{opacity:.6;pointer-events:none}
    </style>

    <script>
    (function($){
      const CUSTOM_AJAX = "<?= esc_js(get_stylesheet_directory_uri().'/modules/inc/customajax.php'); ?>";

      function switchTab($card, name){
        $card.find('.donate-tab').removeClass('active').attr('aria-selected','false');
        $card.find('.donate-tab[data-tab="'+name+'"]').addClass('active').attr('aria-selected','true');
        $card.find('.donate-panel').attr('hidden', true);
        $card.find('.donate-panel[data-panel="'+name+'"]').removeAttr('hidden');
      }
      // init
      $('.donate-card').each(function(){ switchTab($(this), 'single'); });

      // tab click
      $(document).off('click.donateTab').on('click.donateTab', '.donate-card .donate-tab', function(e){
        e.preventDefault(); switchTab($(this).closest('.donate-card'), $(this).data('tab'));
      });

      // presets
      $(document).off('click.donateOpt').on('click.donateOpt', '.donate-card .donate-option', function(){
        const $p = $(this).closest('.donate-panel');
        $p.find('.donate-option').removeClass('active');
        $(this).addClass('active');
        $p.find('.donate-input').val( parseFloat($(this).data('amount')) || 0 );
      });
      $(document).off('input.donateInput').on('input.donateInput', '.donate-card .donate-input', function(){
        $(this).closest('.donate-panel').find('.donate-option').removeClass('active');
      });

      // submit
      $(document).off('click.donateSubmit').on('click.donateSubmit', '.donate-card .donate-submit', function(e){
        e.preventDefault();
        const $card  = $(this).closest('.donate-card');
        const pid    = parseInt($card.data('product-id'), 10);
        const $panel = $(this).closest('.donate-panel');
        const mode   = $panel.data('panel'); // single | recurring
        const amount = parseFloat($panel.find('.donate-input').val());
        if(!pid){ alert('Please select a fund.'); return; }
        if(!amount || amount < 1){ alert('Please enter a valid amount.'); return; }

        const $btn = $(this).prop('disabled', true).text('Adding…');
        $.post(CUSTOM_AJAX, {
          action: (mode === 'single' ? 'donate_single' : 'donate_recurring'),
          product_id: pid,
          amount: amount
        }).done(function(resp){
          try{ resp = (typeof resp === 'string') ? JSON.parse(resp) : resp; }catch(e){}
          if(resp && resp.success){
            if(resp.fragments){
              $.each(resp.fragments, function(sel, html){ $(sel).replaceWith(html); });
              $(document.body).trigger('wc_fragments_refreshed');
            }
            $btn.text('Added!'); setTimeout(()=> $btn.prop('disabled',false).text('DONATE NOW'), 900);
          }else{
            alert(resp && resp.message ? resp.message : 'Unable to add to cart.');
            $btn.prop('disabled', false).text('DONATE NOW');
          }
        }).fail(function(){
          alert('Network error. Please try again.');
          $btn.prop('disabled', false).text('DONATE NOW');
        });
      });
    })(jQuery);
    </script>
    <?php
    die();
}
add_action('ZTRUST_AJAX_loadproject', 'load_project_function');
add_action('ZTRUST_AJAX_nopriv_loadproject', 'load_project_function');

if (isset($_POST['action']) && $_POST['action'] === 'donate_single') {
  $pid = (int) ($_POST['product_id'] ?? 0);
  $amt = (float) ($_POST['amount'] ?? 0);
  if (!$pid || $amt <= 0) { echo wp_json_encode(['success'=>false,'message'=>'Invalid product/amount']); exit; }

  if (function_exists('WC') && WC()->cart) {
      // Support Name Your Price style fields
      $data  = ['nyp' => $amt, 'pay_your_price' => $amt];
      $added = WC()->cart->add_to_cart($pid, 1, 0, [], $data);
      if ($added) {
          ob_start();
          WC_AJAX::get_refreshed_fragments(); // echoes JSON: { success: true, fragments: {...}, cart_hash: ... }
          $json = ob_get_clean();
          echo $json; exit;
      }
  }
  echo wp_json_encode(['success'=>false,'message'=>'Could not add to cart']); exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'donate_recurring') {
  $pid = (int) ($_POST['product_id'] ?? 0);
  $amt = (float) ($_POST['amount'] ?? 0);
  if (!$pid || $amt <= 0) { echo wp_json_encode(['success'=>false,'message'=>'Invalid product/amount']); exit; }

  // Flag for downstream subscription/recurring logic
  $data  = ['is_recurring_donation' => true, 'recurring_amount' => $amt];
  $added = WC()->cart->add_to_cart($pid, 1, 0, [], $data);
  if ($added) {
      ob_start();
      WC_AJAX::get_refreshed_fragments();
      $json = ob_get_clean();
      echo $json; exit;
  }
  echo wp_json_encode(['success'=>false,'message'=>'Could not add recurring item']); exit;
}

// Add-to-cart: one-time donation
if (isset($_POST['action']) && $_POST['action'] === 'donate_single') {
  $pid = (int) ($_POST['product_id'] ?? 0);
  $amt = (float) ($_POST['amount'] ?? 0);
  if (!$pid || $amt <= 0) { echo wp_json_encode(['success'=>false,'message'=>'Invalid product/amount']); exit; }

  if (function_exists('WC') && WC()->cart) {
      // support NYP style fields
      $cart_item_data = ['nyp' => $amt, 'pay_your_price' => $amt];
      $added = WC()->cart->add_to_cart($pid, 1, 0, [], $cart_item_data);
      if ($added) {
          ob_start();
          WC_AJAX::get_refreshed_fragments(); // echoes JSON with fragments
          $json = ob_get_clean();
          echo $json; exit;
      }
  }
  echo wp_json_encode(['success'=>false,'message'=>'Could not add to cart']); exit;
}

// Add-to-cart: recurring donation (re-use your cart logic or call your existing files)
if (isset($_POST['action']) && $_POST['action'] === 'donate_recurring') {
  $pid = (int) ($_POST['product_id'] ?? 0);
  $amt = (float) ($_POST['amount'] ?? 0);
  if (!$pid || $amt <= 0) { echo wp_json_encode(['success'=>false,'message'=>'Invalid product/amount']); exit; }

  // If you must go through ajaxRecurringCartAdd.php, include/require it here and return its output.
  if (function_exists('WC') && WC()->cart) {
      $cart_item_data = ['is_recurring_donation' => true, 'recurring_amount' => $amt];
      $added = WC()->cart->add_to_cart($pid, 1, 0, [], $cart_item_data);
      if ($added) {
          ob_start();
          WC_AJAX::get_refreshed_fragments();
          $json = ob_get_clean();
          echo $json; exit;
      }
  }
  echo wp_json_encode(['success'=>false,'message'=>'Could not add recurring item']); exit;
}

// --- One-time / single donation ---
add_action('ZTRUST_AJAX_donate_single',        'ztrust_ajax_donate_single');
add_action('ZTRUST_AJAX_nopriv_donate_single', 'ztrust_ajax_donate_single');

function ztrust_ajax_donate_single() {
    $pid = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
    $amt = isset($_POST['amount']) ? (float) $_POST['amount'] : 0;

    if (!$pid || $amt <= 0) {
        wp_send_json_error(['message' => 'Invalid product/amount']);
    }

    if (!function_exists('WC') || !WC()->cart) {
        wp_send_json_error(['message' => 'Cart unavailable']);
    }

    // Support Name Your Price style inputs
    $added = WC()->cart->add_to_cart($pid, 1, 0, [], ['nyp' => $amt, 'pay_your_price' => $amt]);

    if (!$added) {
        wp_send_json_error(['message' => 'Could not add to cart']);
    }

    // Return Woo fragments so mini-cart updates
    if ( ! class_exists('WC_AJAX') ) {
        include_once WC()->plugin_path() . '/includes/class-wc-ajax.php';
    }
    ob_start();
    WC_AJAX::get_refreshed_fragments(); // echoes JSON { success:true, fragments:{}, cart_hash:"" }
    $json = ob_get_clean();

    header('Content-Type: application/json; charset=utf-8');
    echo $json;
    exit;
}

// --- Recurring donation ---
add_action('ZTRUST_AJAX_donate_recurring',        'ztrust_ajax_donate_recurring');
add_action('ZTRUST_AJAX_nopriv_donate_recurring', 'ztrust_ajax_donate_recurring');

function ztrust_ajax_donate_recurring() {
    $pid = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
    $amt = isset($_POST['amount']) ? (float) $_POST['amount'] : 0;

    if (!$pid || $amt <= 0) {
        wp_send_json_error(['message' => 'Invalid product/amount']);
    }
    if (!function_exists('WC') || !WC()->cart) {
        wp_send_json_error(['message' => 'Cart unavailable']);
    }

    // If you have custom subscription logic, tag the cart item so your checkout hooks can pick it up.
    $added = WC()->cart->add_to_cart($pid, 1, 0, [], [
        'is_recurring_donation' => true,
        'recurring_amount'      => $amt,
    ]);

    if (!$added) {
        wp_send_json_error(['message' => 'Could not add recurring item']);
    }

    if ( ! class_exists('WC_AJAX') ) {
        include_once WC()->plugin_path() . '/includes/class-wc-ajax.php';
    }
    ob_start();
    WC_AJAX::get_refreshed_fragments();
    $json = ob_get_clean();

    header('Content-Type: application/json; charset=utf-8');
    echo $json;
    exit;
}
