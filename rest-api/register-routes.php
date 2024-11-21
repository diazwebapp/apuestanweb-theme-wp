<?php
function register_routes(){
    
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
    register_rest_route('aw-parley','/parley/vip',[
        'methods' => 'GET',
        'callback' => 'aw_get_parleys_vip',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);

    //NOTIFICACIONES
    register_rest_route('aw-notificaciones','/clear-all',[
        'methods' => 'POST',
        'callback' => 'aw_delete_notifications',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
    register_rest_route('aw-notificaciones','/clear-one',[
        'methods' => 'POST',
        'callback' => 'aw_delete_notification',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);

    //IMAGEN DESTACADA
    register_rest_route('aw-imagen-destacada','/generate-apply',[
        'methods' => 'POST',
        'callback' => 'aw_imagen_destacada_controller',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);

    //FORECASTER DATA
    register_rest_route('forecaster','/forecasts',[
        'methods' => 'GET',
        'callback' => 'aw_get_forecaster_data',
        'permission_callback' => function () {
            return '__return_true';
          }
    ]);
}
add_action( 'rest_api_init', 'register_routes', 10, 0 );

