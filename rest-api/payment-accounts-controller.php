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

if(!function_exists('add_payment_accounts')):
    function add_payment_accounts(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_json_params();
        
        $id_data = insert_payment_account($params["account_data"]);
        if(!is_wp_error( $id )){

            foreach($params['metadata'] as $metadata){
                $data["key"] = $metadata["key"];
                $data["value"] = $metadata["value"];
                $data["payment_account"] = $id_data;
                insert_payment_account_metadata($data);
            }

            return ["status"=>"ok"];
        }

        return ["status"=>"fail"];
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