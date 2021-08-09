<?php 
function aw_delete_promo(WP_REST_Request $request){
    global $wpdb;
    $params = json_decode($request->get_body());
    
    //$delete = $wpdb->get_results("DELETE {$wpdb->prefix}posts where ID='$params->id'");
    wp_update_post(
        [
            'ID'=>$params->id,
            'post_type'=>'promos',
            'post_status'=>'trash'
        ]
        );
    $resp = json_encode(
        ['status'=>'success','msg'=> $params->id .' deleted']
    );
    return json_decode($resp);
}
