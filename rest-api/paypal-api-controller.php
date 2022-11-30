<?php
if(!function_exists('aw_paypal_create_order')):
    function aw_paypal_create_order(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_json_params();
        /*/////////////*/
        $_SESSION["payment_account_id"] = $params["payment_account_id"]; ////GUARDAMOS EN SESIÓN EL ACCOUNT ID
        $table_account_metas = $wpdb->prefix."aw_payment_accounts_metas";
        $get_paypal_credentials = $wpdb->get_results("SELECT meta_key,meta_value FROM $table_account_metas WHERE account_id={$_SESSION["payment_account_id"]}");
       
        foreach($get_paypal_credentials as $meta){
            if($meta->meta_key == "client_id"){
                $paypal_credentials["client_id"] = $meta->meta_value;
            }
            if($meta->meta_key == "secret_id"){
                $paypal_credentials["secret_id"] = $meta->meta_value;
            }
        }
        $token_data = get_paypal_token_data($paypal_credentials);
        $authorization = "Bearer ".$token_data->access_token;
        $table = $wpdb->prefix."ihc_memberships";
        $paid = $wpdb->get_row("SELECT payment_type,short_description, label, price FROM $table WHERE id={$params["lid"]}");
        
        $order = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $params["lid"],
                "amount" => [
                    "value" => $paid->price,
                    "currency_code" => get_option( 'ihc_currency', true )
                ],
                "description" => "Subscripción"
            ]],
            "application_context" => [
                "brand_name" => get_bloginfo( "title" ),
                 "cancel_url" => get_bloginfo( "url" ),
                 "return_url" => get_rest_url( null,"aw-paypal-api/capture-order"),
                 "user_action" => "PAY_NOW"
            ] 
        ];
        $order = json_encode($order);

        $response = wp_remote_post( "https://api-m.sandbox.paypal.com/v2/checkout/orders", array(
            'method'      => 'POST',
            'timeout'     => 45,
            'headers'     => ["Authorization"=>$authorization,"Content-Type"=> 'application/json'],
            'body'        => $order,
            'sslverify'   => false,
            )
        );
        if(is_wp_error( $response )){
            return "error de comunicación con paypal";
        }
        $apiBody = json_decode( wp_remote_retrieve_body( $response ) );
        return $apiBody;
    }
else:
    echo "la funcion aw_paypal_create_order ya existe";
endif;

if(!function_exists("aw_paypal_capture_order")):
    function aw_paypal_capture_order(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_params();

        $table_account_metas = $wpdb->prefix."aw_payment_accounts_metas";
        $get_paypal_credentials = $wpdb->get_results("SELECT meta_key,meta_value FROM $table_account_metas WHERE account_id={$_SESSION["payment_account_id"]}");
       
        foreach($get_paypal_credentials as $meta){
            if($meta->meta_key == "client_id"){
                $paypal_credentials["client_id"] = $meta->meta_value;
            }
            if($meta->meta_key == "secret_id"){
                $paypal_credentials["secret_id"] = $meta->meta_value;
            }
        }
        $token_data = get_paypal_token_data($paypal_credentials);

        $authorization = "Bearer ".$token_data->access_token;
        $response = wp_remote_post( "https://api-m.sandbox.paypal.com/v2/checkout/orders/{$params['token']}/capture", array(
            'method'      => 'POST',
            'timeout'     => 45,
            'headers'     => ["Authorization"=>$authorization,"Content-Type"=> 'application/json'],
            'body'        => [],
            'sslverify'   => false,
            )
        );
        if(is_wp_error( $response )){
            return "error de comunicación con paypal,verifique su estado de cuenta y comuniquese con nosotros";
        }
        $apiBody = json_decode( wp_remote_retrieve_body( $response ) );
        if($apiBody->status == "COMPLETED"){
            $body = [
                "lid" => $apiBody->purchase_units[0]->reference_id,
                "payment_account_id" => $_SESSION["payment_account_id"],
            ];         
           $resp = aw_paypal_user_level_operations($body);                        
            var_dump($body);
            //header("Location: {$resp['redirect']}", TRUE, 301);
            exit();
        }
        return $apiBody->purchase_units;
    }
else:
    echo "la funcion aw_paypal_capture_order yá existe";
    die;
endif;

if(!function_exists("aw_paypal_cancel_order")):
    function aw_paypal_cancel_order(WP_REST_Request $request){
        $params = $request->get_params();
        return $params;
    }
else:
    echo "la funcion aw_paypal_cancel_order yá existe";
    die;
endif;