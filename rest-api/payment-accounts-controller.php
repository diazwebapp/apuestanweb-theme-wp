<?php

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
