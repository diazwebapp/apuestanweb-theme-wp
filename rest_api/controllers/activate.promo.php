<?php 
function aw_activate_promo(WP_REST_Request $request){
    global $wpdb;
    $params = json_decode($request->get_body());
    
    $query_promos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts where post_type='promos'");
    if(count($query_promos) == 0){
        $resp = json_encode(
            ['status'=>'error','msg'=>'no promos']
        );
        return json_decode($resp);
    }
    foreach($query_promos as $key => $promo):
        if($promo->post_status !='trash'):
            wp_update_post([
                'ID' => $promo->ID,
                'post_status' => 'pending',
                'post_type' => 'promos'
            ]);
        endif;
        if($promo->ID == $params->id):
            wp_update_post([
                'ID' => $params->id,
                'post_status' => 'publish',
                'post_type' => 'promos'
            ]);
        endif;
    endforeach;
    $resp = json_encode(
        ['status'=>'success','msg'=> $params->id .' activated']
    );
    return json_decode($resp);
}
