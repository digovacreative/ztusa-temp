<?php
// function load_checkoutrecurringSubmit_function(){ session_start(); session_unset(); ob_clean();


    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    
    require dirname(__FILE__).'/../gocardless/vendor/autoload.php';
    
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    
    $session_token = generateRandomString();
    $_SESSION['gocardless']['session_token'] = $session_token;
    
    $client = new \GoCardlessPro\Client([
        // We recommend storing your access token in an
        // environment variable for security
        'access_token' => 'sandbox_NCsIPomNGH23V53ENuLJBumTjh07h0bVm8__yAO2',
        // Change me to LIVE when you're ready to go live
        'environment' => \GoCardlessPro\Environment::SANDBOX
    ]);
    
    // $customers = $client->customers()->list()->records;
    // echo '<pre>';
    // print_r($customers);
    // echo '</pre>';
    print_r($_POST);

    $fname = $_POST['billing_first_name'];
    $lname = $_POST['billing_last_name'];
    $email = $_POST['billing_email'];
    $address = $_POST['billing_address_1'];
    $city = $_POST['billing_city'];
    $postal_code = $_POST['billing_postcode'];
    
    $_SESSION['order_data'][] = $_POST['recurring_meta'];

    $redirectFlow = $client->redirectFlows()->create([
        "params" => [
            // This will be shown on the payment pages
            "description" => "Donation",
            // Not the access token
            "session_token" => $session_token,
            "success_redirect_url" => "https://wp2.zahratrust.com/ztrust/wp-content/themes/ztrust/modules/inc/gocardless/success.php",
            // Optionally, prefill customer details on the payment page
            "prefilled_customer" => [
              "given_name" => $fname,
              "family_name" => $lname,
              "email" => $email,
              "address_line1" => $address,
              "city" => $city,
              "postal_code" => $postal_code
            ]
        ]
    ]);
    
    // Hold on to this ID - you'll need it when you
    // "confirm" the redirect flow later
    //print("ID: " . $redirectFlow->id . "<br />");
    
    $_SESSION['gocardless']['redirect_id'] = $redirectFlow->id;
    header("Access-Control-Allow-Origin: https://wp2.zahratrust.com");
    header("Access-Control-Allow-Headers: Content-Type, origin");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

    header("Location: $redirectFlow->redirect_url", true, 301);
    exit();

// die();
// }
// add_action('ZTRUST_AJAX_loadcheckoutRecurringSubmit', 'load_checkoutrecurringSubmit_function');
// add_action('ZTRUST_AJAX_nopriv_loadcheckoutRecurringSubmit', 'load_checkoutrecurringSubmit_function');