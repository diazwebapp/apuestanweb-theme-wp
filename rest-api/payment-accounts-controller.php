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
              <div class="form-group">
                <label for="exampleInputEmail1">
                </label>
                <select class="form-select form-control" aria-label="Default select example" id="ptipo" name="ptipo">
                  
                    <option value="4">
                      
                        E
                      
                    </option>
                  
                    <option value="1" selected="True">
                      
                        V
                      
                    </option>
                  
                    <option value="2">
                      
                        J
                      
                    </option>
                  
                    <option value="3">
                      
                        G
                      
                    </option>
                  
                </select>
              </div>
           
              <div class="form-group">
                <label for="exampleInputEmail1">Documento<font class="text-o-color-1" style="">*</font></label>
                <input type="text" class="form-control" id="pdocument" name="pdocument" aria-describedby="pdocumentHelp" placeholder=" ">
              </div>
        
        
          <div class="form-group">
            <label for="exampleInputEmail1">Fecha de la transferencia<font class="text-o-color-1" style="">*</font></label>
            <input type="date" class="form-control" id="pfecha" name="pfecha" aria-describedby="nombreHelp" placeholder="Nombre">
          </div>
        
          <div class="form-group">
            <label for="exampleInputEmail1">Número de transferencia<font class="text-o-color-1" style="">*</font></label>
            <input type="text" class="form-control" id="pnumero" name="pnumero" aria-describedby="nombreHelp" placeholder="0000">
          </div>
        ';
        foreach($methods as $key => $method):
            $method["accounts"] = select_payment_accounts($method['key']);
            $method["register_paid_inputs"] = $html_register_payment;
            if(count($method["accounts"]) > 0):
                $accounts[$key] = $method; 
            endif;
        endforeach;
        return ["status"=>"ok","data"=>$accounts];
    }
endif;