<?php
function register_routes(){
    //Routes payment accounts
    register_rest_route('aw-admin','/payment-accounts',[
        'methods' => 'GET',
        'callback' => 'get_payment_accounts'
    ]);
    register_rest_route('aw-admin','/payment-accounts',[
        'methods' => 'POST',
        'callback' => 'add_payment_accounts'
    ]);
    register_rest_route('aw-register-form','/payment-methods',[
        'methods' => 'GET',
        'callback' => 'get_register_payment_methods'
    ]);
    //Routes Payments
    register_rest_route('aw-payments','/register-payment',[
        'methods' => 'POST',
        'callback' => 'aw_register_new_payment'
    ]);
}
add_action( 'rest_api_init', 'register_routes', 10, 0 );