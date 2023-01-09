<?php

function aw_register_new_payment(WP_REST_Request $request){
    $params = $request->get_json_params();
    $sql_data=[];
    //Rellenamos los datos para payment history
    $sql_data["payment_method"] = $params["method_name"];
    $sql_data["payment_account_id"] = $params["payment_selected"];
    $sql_data["membership_id"] = $params["lid"];
    $sql_data["username"] = $params["user_login"];
    $sql_data["payment_date"] = date("Y-m-d h:i:s");
    $sql_data["status"] = "pending";

    $insert_history_id = insert_payment_history($sql_data);

    if(!is_wp_error( $insert_history_id )){
        $response["status"] = "ok";
        $response["data"] = $insert_history_id;
        foreach($params["register"] as $data){
            $data["payment_history_id"] = $insert_history_id;
            insert_payment_history_meta($data);
        }
        return $response;
    }
    
    $response["status"] = "fail";
    $response["data"] = "";
    return $response;
        
    
}

function aw_get_payment_history_metas(WP_REST_Request $request){
    $params = $request->get_json_params();
    global $wpdb ;
    $table = $wpdb->prefix . "aw_payment_history";
    $sql_ = "SELECT * FROM $table WHERE id = '{$params["payment_id"]}' ";    
    $payment_history = $wpdb->get_row($sql_);

    $metas = select_payment_history_meta($params["payment_id"]);
    $response = [];
    $response["payment"] = $payment_history;
    $response["metas"] = $metas;
    return $response;
}
?>