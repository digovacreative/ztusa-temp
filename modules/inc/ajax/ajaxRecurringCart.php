<?php
// Turn on all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

/**
 * Return the cart data array (or empty array if the cookie is missing/invalid).
 */
function get_recurring_cart_data() {
    if ( isset($_COOKIE['shopping_cart']) ) {
        $json = stripslashes($_COOKIE['shopping_cart']);
        $arr  = json_decode($json, true);
        if ( is_array($arr) ) {
            return $arr;
        }
    }
    return [];
}

/**
 * Count how many items are in the cart.
 */
function check_recurring_cart() {
    $data = get_recurring_cart_data();
    return count($data);
}

// 1) Handle a “delete” request (unconditionally, even if count goes down to zero)
if ( isset($_POST['method']) && $_POST['method'] === 'delete' && ! empty($_POST['id']) ) {
    $cart_data  = get_recurring_cart_data();
    $clicked_id = $_POST['id'];

    foreach ( $cart_data as $index => $item ) {
        if ( isset($item['cart_key_id']) && $item['cart_key_id'] == $clicked_id ) {
            unset($cart_data[$index]);
            break; // stop after removing one match
        }
    }

    // Re-index so JSON doesn’t have “holes”
    $cart_data = array_values($cart_data);
    $new_json  = json_encode($cart_data);

    // Overwrite the cookie (30-day expiration, path = "/")
    setcookie('shopping_cart', $new_json, time() + (86400 * 30), '/');

    // Immediately trigger a reload on the front-end
    ?>
    <script>
      // Pass back “load” so that the JS reloads this same file and re-renders the cart
      load_the_recurring_cart_data('load', false, '<?php echo htmlspecialchars($_POST['url'], ENT_QUOTES, 'UTF-8'); ?>');
    </script>
    <?php
}

// 2) Now re-read the (possibly modified) cart and display it
$cart_data = get_recurring_cart_data();
$count     = count($cart_data);

if ( $count > 0 ) {
    // Show header
    echo '<h3>Regular Donations</h3>';
    ?>
    <ul class="woocommerce-mini-cart cart_list product_list_widget recurring_cart">
    <?php
    // Initialize subtotal as float
    $total_recurring = 0.0;

    foreach ( $cart_data as $item ) {
        // Use native PHP escaping instead of esc_html()/esc_attr()
        $product_title = isset( $item['product_title'] ) 
            ? htmlspecialchars( $item['product_title'], ENT_QUOTES, 'UTF-8' ) 
            : '';
        $product_id = isset( $item['product_id'] ) 
            ? htmlspecialchars( $item['product_id'], ENT_QUOTES, 'UTF-8' ) 
            : '';
        $cart_key_id = isset( $item['cart_key_id'] ) 
            ? htmlspecialchars( $item['cart_key_id'], ENT_QUOTES, 'UTF-8' ) 
            : '';
        $raw_price = isset( $item['item_price'] ) 
            ? $item['item_price'] 
            : '';

        // Render each line item
        ?>
        <li class="woocommerce-mini-cart-item mini_cart_item">
            <a href="#"
               class="remove remove_from_cart_button_recurring"
               aria-label="Remove this item"
               data-product_id="<?php echo $product_id; ?>"
               data-cart_item_key="<?php echo $cart_key_id; ?>">
               ×
            </a>
            <?php echo $product_title; ?>
            <span class="quantity">1 × $<?php echo htmlspecialchars($raw_price, ENT_QUOTES, 'UTF-8'); ?></span>
        </li>
        <?php

        // Cast the price to a float. If raw_price is empty or non-numeric, floatval(...) yields 0.0
        $price = floatval( $raw_price );
        $total_recurring += $price;
    }
    ?>
    </ul>

    <p class="woocommerce-mini-cart__total total">
      <strong>Subtotal:</strong>
      <span class="woocommerce-Price-amount amount">
        <span class="woocommerce-Price-currencySymbol">$</span>
        <?php echo number_format( $total_recurring, 2 ); ?>
      </span>
    </p>

    <?php
    // If after deletion the cart_data is now empty, show “No Regular Donations…”
    if ( empty($cart_data) ) {
        echo '<p class="woocommerce-mini-cart__empty-message">No Regular Donations in your cart</p>';
    }

} else {
    // Cart was already empty (e.g. user never added anything). Show empty message.
    echo '<p class="woocommerce-mini-cart__empty-message">No Regular Donations in your cart</p>';
}
?>

<script>
// 3) JavaScript to wire up “Remove (×)” buttons and AJAX reload
jQuery(document).on("click", ".remove_from_cart_button_recurring", function(event) {
    event.preventDefault();
    var click_method = 'delete';
    var cart_item_key = jQuery(this).data('cart_item_key');
    load_the_recurring_cart_data(click_method, cart_item_key, '<?php echo htmlspecialchars($_POST['url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>');
});

function load_the_recurring_cart_data(method = false, id = false, url = false) {
    jQuery.ajax({
        url: url + '/modules/inc/ajax/ajaxRecurringCart.php',
        data: 'action=load_recurring_cart&method=' + method + '&id=' + id + '&url=' + url,
        type: 'POST',
        beforeSend: function(xhr) {
            jQuery('.recurring_cart').addClass('loading');
        },
        success: function(data) {
            jQuery('.recurring_cart').removeClass('loading');
            jQuery('#recurring_cart_content').html(data);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    return false;
}
</script>

<?php
die();
