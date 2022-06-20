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
    register_rest_route('aw-register-form','/payment-methods',[
        'methods' => 'GET',
        'callback' => 'register_form_payment_methods'
    ]);
    
}
add_action( 'rest_api_init', 'register_routes', 10, 0 );