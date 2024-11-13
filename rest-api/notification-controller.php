<?php

function aw_delete_notifications(WP_REST_Request $request){
    $params = $request->get_json_params();
    $user_id = username_exists($params["username"]);
    $result = insert_multi_notificacions_views(['id_user'=>$user_id]);
    if(!is_wp_error( $result )){

        $rs["status"] = "ok";
    
        return json_decode(json_encode($rs));
    }else{
        $rs["status"] = "error";
    }
}

function aw_delete_notification(WP_REST_Request $request){
    $params = $request->get_json_params();
    $id_user = username_exists($params["username"]);
    $id_post = $params["post_id"];
    
    $result = insert_notification_view(["id_pronostico"=>$id_post,"id_user"=>$id_user]);
    if(!is_wp_error( $result )){

        $rs["status"] = "ok";
        $rs["redirect"] = esc_url(  get_the_permalink($id_post) );
    
        return json_decode(json_encode($rs));
    }else{
        $rs["status"] = "error";
    }
}