<?php 
function aw_get_promos(){
    global $wpdb;
    $params = json_decode(json_encode([
        'post_status'=>$_GET['post_status'],
        'limit'=>$_GET['limit']
        ]));

    $sql_options = "";
    if($params->post_status){
        $sql_options .= "AND post_status='{$params->post_status}'";
    }
    
    if($params->limit){
        $sql_options .= "LIMIT {$params->limit}";
    }
    $query_promos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts where post_type='promos' {$sql_options} ORDER BY ID DESC");
    
    if(count($query_promos) == 0):
        $resp = json_encode(
            ['status'=>'error','promos'=> false]
        );
        return json_decode($resp);
    endif;
    $resp = json_encode(
        ['status'=>'success','promos'=> $query_promos]
    );
    return json_decode($resp);
}