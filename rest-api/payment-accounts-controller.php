<?php
//Admin handlers
if(!function_exists('get_payment_accounts')):
    function get_payment_accounts(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_params();
        $accounts = [];

        return ["status"=>"ok","data"=>$accounts];
    }
else:
    echo 'la funcion get_payment_accounts ya existe';
endif;
if(!function_exists("aw_new_payment_account")):
    function aw_new_payment_account(WP_REST_Request $request){
        $params = $request->get_params();
        $account_data = (array)$params["account_data"];
        $account_metas = $params["metadata"];
        $insert_account = aw_insert_new_payment_account($account_data);
        if($insert_account["status"]=="ok"){
            foreach($account_metas as $meta){
                $account_meta = (array)$meta;
                $account_meta["account_id"] = $insert_account["id"];
                aw_insert_new_payment_account_metas($account_meta);
            }
        }
        return $params;
    }
else:
    echo "la funcion aw_new_payment_account ya existe";
endif;