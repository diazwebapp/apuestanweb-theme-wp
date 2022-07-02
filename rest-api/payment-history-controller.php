<?php

function aw_register_new_payment(WP_REST_Request $request){
    $params = $request->get_json_params();
    $location = json_decode(GEOLOCATION);
    $sql_data=[];
    $usermail = email_exists( $params["user_email"] );
    $username = username_exists( $params["user_login"] );
    //si el usuario existe nó registramo el pago
    if($username or $usermail):
        $response["status"] = "fail";
        $response["data"] = "usuario o email ya existen";
        return $response; 
    endif;
    if(!$username and !$usermail):
        
        //Rellenamos los datos para payment history
        $sql_data["payment_method"] = $params["method_name"];
        $sql_data["payment_account_id"] = $params["payment_selected"];
        $sql_data["membership_id"] = $params["lid"];
        $sql_data["username"] = $params["user_login"];
        $sql_data["select_country_code"] = $params["ihc_country"];
        $sql_data["detected_country_code"] = $location->country_code;
        $sql_data["payment_date"] = date("Y-m-d h:i:s");
        $sql_data["status"] = "pending";
    
        $insert_history_id = insert_payment_history($sql_data);
    
        if(!is_wp_error( $insert_history_id )){
            $response["status"] = "ok";
            $response["data"] = $insert_history_id;
            foreach($params["register"] as $data){
                $response = (array)$data;
                $data["payment_history_id"] = $insert_history_id;
                insert_payment_history_meta($data);
            }
            return $response;
        }
    endif;
    $response["status"] = "fail";
    $response["data"] = "";
    return $response;
}
?>