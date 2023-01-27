<?php
function register_routes(){
    //Routes Payments methods
    register_rest_route('aw-admin','/payment-methods',[
        'methods' => 'POST',
        'callback' => 'aw_new_payment_method',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    //Routes Payments accounts
    register_rest_route('aw-admin','/payment-accounts',[
        'methods' => 'POST',
        'callback' => 'aw_new_payment_account',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    
    //register form shortcode
    register_rest_route('aw-register-form','/check-user-exists',[
        'methods' => 'GET',
        'callback' => 'aw_register_form_checket_user',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    register_rest_route('aw-register-form','/register-user',[
        'methods' => 'POST',
        'callback' => 'aw_register_user',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    register_rest_route('aw-register-form','/register-payment',[
        'methods' => 'POST',
        'callback' => 'aw_register_new_payment',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    //admin payment history
    register_rest_route('aw-payment-history','/payment-history-details',[
        'methods' => 'POST',
        'callback' => 'aw_get_payment_history_metas',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    //shortcode prices
    register_rest_route('aw-user-levels','/check-user-level',[
        'methods' => 'POST',
        'callback' => 'aw_check_user_level',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    register_rest_route('aw-user-levels','/user-level-opeations',[
        'methods' => 'POST',
        'callback' => 'aw_user_level_operations',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    //Paypal checkout
    register_rest_route('aw-paypal-api','/create-order',[
        'methods' => 'POST',
        'callback' => 'aw_paypal_create_order',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    register_rest_route('aw-paypal-api','/capture-order',[
        'methods' => 'GET',
        'callback' => 'aw_paypal_capture_order',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    register_rest_route('aw-paypal-api','/cancel-order',[
        'methods' => 'GET',
        'callback' => 'aw_paypal_cancel_order',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    ////FORECASTS ROUTES
    register_rest_route('aw-forecasts','/forecasts',[
        'methods' => 'GET',
        'callback' => 'aw_get_forecasts',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    //FORECASTS VIP
    register_rest_route('aw-forecasts','/forecasts/vip',[
        'methods' => 'GET',
        'callback' => 'aw_get_forecasts_vip',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);

    //PARLEY
    register_rest_route('aw-parley','/parley',[
        'methods' => 'GET',
        'callback' => 'aw_get_parleys',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);

    //NOTIFICACIONES
    register_rest_route('aw-notificaciones','/all',[
        'methods' => 'GET',
        'callback' => 'aw_get_notifications',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
}
add_action( 'rest_api_init', 'register_routes', 10, 0 );

