<?php
//mimic the actuall admin-ajax
define('DOING_AJAX', true);


if (!isset( $_POST['action']))
    exit();

//make sure you update this line 
//to the relative location of the wp-load.php
require_once('../../../../../wp-load.php'); 

//Typical headers
header('Content-Type: text/html');
send_nosniff_header();


$action = esc_attr(trim($_POST['action']));


//A bit of security
$allowed_actions = array(
    'loadproject',
    'loadstep',
    'loadcart',
    'loadcheckout',
    'postfilter',
    'postsearch',
    'loadlogin',
    'loadrecurring_checkout',
    'loadcheckoutRecurringSubmit',
    'loadcarttotal' );

if(in_array($action, $allowed_actions)){
    if(is_user_logged_in())
        do_action('ZTRUST_AJAX_'.$action);
    else
        do_action('ZTRUST_AJAX_nopriv_'.$action);
}