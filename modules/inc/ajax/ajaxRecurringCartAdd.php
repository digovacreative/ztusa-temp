<?php ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); ob_start();
$message = '';
$product_id = $_POST['project_id'];
$product_amount = $_POST['amount'];
$product_title = $_POST['title'];

// print_r($_POST);

if(isset($_POST['sayed_option'])):
$product_sayed = $_POST['sayed_option'];
else:
$product_sayed = '';   
endif;

//print_r($_POST);
if(isset($_POST["action"]) && $_POST['action'] === 'add_recurring_to_cart'){
    if(isset($_COOKIE['shopping_cart'])) {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
    }else {
        $cart_data = array();
    }    
    $item_array = array(
        'cart_key_id'  => rand(80, 1300),
        'product_title' => $product_title,
        'product_id'   => $product_id,
        'item_price'  => $product_amount,
        'sayed_option' => $product_sayed
    );
    $cart_data[] = $item_array;
    $json = json_encode($cart_data, true);
    setcookie('shopping_cart', $json, time() + (86400 * 7), '/');
    ?>
    <script>
        jQuery('#product_details_box').removeClass('active');
        jQuery('.product__listing').removeClass('active');
        $status = 'added';
        jQuery('body').addClass('added_to_cart');
        load_the_cart($status);
    </script>
    <?php
}

die();
// }
// add_action('wp_ajax_add_recurring_to_cart', 'load_recurring_add_function');
// add_action('wp_ajax_nopriv_add_recurring_to_cart', 'load_recurring_add_function');
?>