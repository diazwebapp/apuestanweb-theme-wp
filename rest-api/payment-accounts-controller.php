<?php
//Admin handlers
if(!function_exists('get_payment_accounts')):
    function get_payment_accounts(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_params();
        $accounts = print_accounts($params["method"]);

        return ["status"=>"ok","data"=>$accounts];
    }
endif;

if(!function_exists('aw_register_new_payment_method')):
    function aw_register_new_payment_method(WP_REST_Request $request){
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
endif;

if(!function_exists('get_register_payment_methods')):
    function get_register_payment_methods(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_params();
        $methods = get_payment_methods();
        $accounts = [];
        $html_register_payment = '
              <section class="form-group">
                <label>Document type</label>
                <select class="form-select form-control" aria-label="Default select" name="type_dni">
                  
                    <option value="4">E</option>
                  
                    <option value="1" selected>V</option>
                  
                    <option value="2">J</option>
                  
                    <option value="3">G</option>
                  
                </select>
              </section>

              <section class="form-group">
              <label>Bank Emitter <i class="required">*</i></label>
              <input required type="text" class="form-control" name="bank_emitter" placeholder="bank of america">
            </section>

              <section class="form-group">
                <label>Document <i class="required">*</i></label>
                <input required type="text" class="form-control" name="client_dni" placeholder="0000000">
              </section>
        
        
          <section class="form-group">
            <label>Date payment <i class="required">*</i></label>
            <input required type="date" class="form-control" name="transaction_date" placeholder="José">
          </section>
        
          <section class="form-group">
            <label>Refer code <i class="required">*</i></label>
            <input required type="text" class="form-control" name="transaction_code" placeholder="0000">
          </section>
        ';
        $location = json_decode(GEOLOCATION);
        foreach($methods as $key => $method):
            $method["accounts"] = select_payment_accounts($method['key'],$location->country_code);
            $new_key = $method["key"]."_inputs";
            
            
            $inputs = str_replace("client_dni","{$method["key"]}_client_dni",$html_register_payment);
            $inputs = str_replace("transaction_code","{$method["key"]}_transaction_code",$inputs);
            $inputs = str_replace("transaction_date","{$method["key"]}_transaction_date",$inputs);
            $inputs = str_replace("bank_emitter","{$method["key"]}_bank_emitter",$inputs);
            $inputs = str_replace("document_type","{$method["key"]}_document_type",$inputs);
            
            $method[$new_key] = $inputs;
            
            if(count($method["accounts"]) > 0):
                $accounts[$key] = $method; 
            endif;
        endforeach;
        return ["status"=>"ok","data"=>$accounts];
    }
endif;