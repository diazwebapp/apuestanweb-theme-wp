<?php
function register_routes(){
    //Routes Payments methods
    register_rest_route('aw-admin','/payment-methods',[
        'methods' => 'POST',
        'callback' => 'aw_new_payment_method',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    //Routes Payments accounts
    register_rest_route('aw-admin','/payment-accounts',[
        'methods' => 'POST',
        'callback' => 'aw_new_payment_account',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    
    //register form shortcode
    register_rest_route('aw-register-form','/register-user',[
        'methods' => 'GET',
        'callback' => 'aw_register_form_checket_user',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    register_rest_route('aw-register-form','/register-user',[
        'methods' => 'POST',
        'callback' => 'aw_register_user',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    register_rest_route('aw-register-form','/register-payment',[
        'methods' => 'POST',
        'callback' => 'aw_register_new_payment',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    //shortcode prices
    register_rest_route('aw-user-levels','/check-user-level',[
        'methods' => 'POST',
        'callback' => 'aw_check_user_level',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    register_rest_route('aw-user-levels','/user-level-opeations',[
        'methods' => 'POST',
        'callback' => 'aw_user_level_operations',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    //Paypal checkout
    register_rest_route('aw-paypal-api','/create-order',[
        'methods' => 'POST',
        'callback' => 'aw_paypal_create_order',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    register_rest_route('aw-paypal-api','/capture-order',[
        'methods' => 'GET',
        'callback' => 'aw_paypal_capture_order',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
    register_rest_route('aw-paypal-api','/cancel-order',[
        'methods' => 'GET',
        'callback' => 'aw_paypal_cancel_order',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
          }
    ]);
}
add_action( 'rest_api_init', 'register_routes', 10, 0 );