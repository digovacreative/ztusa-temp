<?php
function load_carttotal_function(){ 

    $cart_total_single = WC()->cart->get_cart_contents_count();

    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    $recurring_total = count($cart_data);

    $total = $cart_total_single+$recurring_total;
    echo $total;
    die();
}
add_action('ZTRUST_AJAX_loadcarttotal', 'load_carttotal_function');
add_action('ZTRUST_AJAX_nopriv_loadcarttotal', 'load_carttotal_function');
?>