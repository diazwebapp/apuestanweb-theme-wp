<?php
function register_routes(){
    //Routes Payments methods
    register_rest_route('aw-admin','/payment-methods',[
        'methods' => 'POST',
        'callback' => 'aw_new_payment_method'
    ]);
    //Routes Payments accounts
    register_rest_route('aw-admin','/payment-accounts',[
        'methods' => 'POST',
        'callback' => 'aw_new_payment_account'
    ]);
    
    //register form shortcode
    register_rest_route('aw-register-form','/register-user',[
        'methods' => 'GET',
        'callback' => 'aw_register_form_checket_user'
    ]);
    register_rest_route('aw-register-form','/register-user',[
        'methods' => 'POST',
        'callback' => 'aw_register_user'
    ]);
    register_rest_route('aw-register-form','/register-payment',[
        'methods' => 'POST',
        'callback' => 'aw_register_new_payment'
    ]);
}
add_action( 'rest_api_init', 'register_routes', 10, 0 );