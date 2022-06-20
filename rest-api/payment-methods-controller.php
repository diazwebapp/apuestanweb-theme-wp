<?php
//Admin handlers

if(!function_exists('aw_new_payment_method')):
    function aw_new_payment_method(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_json_params();
        $payment_method_data = $params["payment_method_data"];
        $received_inputs = $params["received_inputs"];
        $register_inputs = $params["register_inputs"];

        $payment_method["icon_class"] = $payment_method_data["icon_class"];
        $payment_method["icon_service"] = $payment_method_data["icon_service"];
        $payment_method["payment_method"] = $payment_method_data["payment_method"];
        $payment_method["status"] = $payment_method_data["status"];

        $response = ["status"=>true,"msg"=>"ok"];
        $insert = aw_insert_new_payment_method($payment_method);

        if(is_wp_error( $insert ) or $insert["status"] == "fail"){
            $response["status"] = false;
            $response["msg"] = $insert["msg"];
            return $response;
        }

        if($insert["status"] == "ok"):
            foreach($received_inputs as $method_received){
                $input_received["type"] = $method_received["type"];
                $input_received["name"] = $method_received["name"];
                $input_received["show_ui"] = $method_received["show_ui"];
                $input_received["payment_method_id"] = $insert["id"];
                $insert_input_status = aw_insert_new_payment_method_received_inputs($input_received);
                if(is_wp_error( $insert_input_status ) or $insert_input_status["status"] == "fail"){
                    $response["status"] = false;
                    $response["msg"] = $insert_input_status["msg"];
                    return $response;
                }
            }
            foreach($register_inputs as $method_register){
                $input_register["type"] = $method_register["type"];
                $input_register["name"] = $method_register["name"];
                $input_register["payment_method_id"] = $insert["id"];
                $insert_input_status = aw_insert_new_payment_method_register_inputs($input_register);
                if(is_wp_error( $insert_input_status ) or $insert_input_status["status"] == "fail"){
                    $response["status"] = false;
                    $response["msg"] = $insert_input_status["msg"];
                    return $response;
                }
            }
        endif;
        return $response;
    }
else:
    echo 'la funcion aw_new_payment_method ya existe';
    die;
endif;

//frond handlers

if(!function_exists('register_form_payment_methods')):
    function register_form_payment_methods(WP_REST_Request $request){

        $payment_methods = aw_select_payment_method();
        return ["data"=>$payment_methods];
    }
else:
    echo 'la funcion register_form_payment_methods ya existe';
    die;
endif;