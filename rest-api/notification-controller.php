<?php

function aw_get_notifications(WP_REST_Request $request){
    $params = $request->get_json_params();
    $user_id = username_exists($params["username"]);
    $result = add_notification_view(['id_user'=>$user_id]);
    if(!is_wp_error( $result )){

        $rs["status"] = "ok";
    
        return json_decode(json_encode($rs));
    }else{
        $rs["status"] = "error";
    }
}