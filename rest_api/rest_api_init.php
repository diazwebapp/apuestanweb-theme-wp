<?php
//End point para crear promos
require 'controllers/create.promo.php';

add_action("rest_api_init",function(){

    register_rest_route('aw_rest_api/v1',
    '/create_promo',
    array(
        'methods'=>'POST',
        'callback'=>'aw_create_promo'
    ));
});
//End point para obtener promos
require 'controllers/get.promos.php';
add_action("rest_api_init",function(){

    register_rest_route('aw_rest_api/v1',
    '/get_promos',
    array(
        'methods'=>'GET',
        'callback'=>'aw_get_promos'
    ));
});
//End point para activar una promo (solo cambia el status)
require 'controllers/activate.promo.php';
add_action("rest_api_init",function(){

    register_rest_route('aw_rest_api/v1','/activate_promo',
    array(
        'methods'=>'PUT',
        'callback'=>'aw_activate_promo'
    ));
});
//End point para eliminar una promo 
require 'controllers/delete.promo.php';
add_action("rest_api_init",function(){

    register_rest_route('aw_rest_api/v1','/delete_promo',
    array(
        'methods'=>'delete',
        'callback'=>'aw_delete_promo'
    ));
});