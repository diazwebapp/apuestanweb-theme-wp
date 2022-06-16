<?php

function aw_register_new_payment(WP_REST_Request $request){
    $params = $request->get_json_params();
    $location = json_decode(GEOLOCATION);
    $sql_metadata = get_a_payment_history_struc_metadata($params["payment_selected"]);
    $sql_data;
    
    for($i = 0; $i<count($sql_metadata); $i++){
        //Primero rellenamos los metadata
        $new_key = $params["payment_selected"].'_'.$sql_metadata[$i]["key"];
        $value_key = $params[$new_key];
        $sql_metadata[$i]["value"] = $value_key;
        //luego rellenamos los datos para payment history
        $sql_data["payment_method"] = $params["payment_selected"];
        $sql_data["membership_id"] = $params["lid"];
        $sql_data["username"] = $params["user_login"];
        $sql_data["select_country_code"] = $params["ihc_country"];
        $sql_data["detected_country_code"] = $location->country_code;
        $sql_data["payment_date"] = date("Y-m-d h:i:s");
        $sql_data["status"] = "pending";
    }

    $insert_history_id = insert_payment_history($sql_data);
    if(!is_wp_error( $insert_history_id )){
        $response["status"] = "ok";
        $response["data"] = $insert_history_id;
        foreach($sql_metadata as $data){
            $data["payment_history_id"] = $insert_history_id;
            insert_payment_history_meta($data);
        }
        return $response;
    }

    $response["status"] = "fail";
    $response["data"] = "";
    return $response;
}
?>