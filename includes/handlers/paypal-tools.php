<?php
function get_paypal_token_data($paypal_credentials){
    $ch = curl_init();
 
        // set path to PayPal API to generate token
        // remove "sandbox" from URL when in live
        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        // write your own client ID and client secret in following format:
        // {client_id}:{client_secret}
        curl_setopt($ch, CURLOPT_USERPWD, "{$paypal_credentials["client_id"]}:{$paypal_credentials["secret_id"]}");
        
        // set headers
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // call the CURL request
        $result = curl_exec($ch);
        
        // check if there is any error in generating token
        if (curl_errno($ch))
        {
            return json_encode([
                "status" => "error",
                "message" => curl_error($ch)
            ]);
        }
        curl_close($ch);
        
        // the response will be a JSON string, so you need to decode it
        $result = json_decode($result);
        return $result;
}

if(!function_exists('aw_paypal_user_level_operations')):
    function aw_paypal_user_level_operations($params){

        $thanks_page = get_option('ihc_thank_you_page'); //Obtenemos pagina de destino
        $_SESSION["payment_account_id"] = $params["payment_account_id"]; ////GUARDAMOS EN SESIÓN EL ACCOUNT ID

        //////Datos para realizar operaciones en membresias       

        $resp['msg'] = $_SESSION["checkout_action"];
        $resp['redirect'] = get_permalink( $thanks_page );
        
        if($_SESSION["checkout_action"] == 'renew'):   //Renovar una membresia         
            $activate_sql_params = aw_generate_activation_membership_data(["lid"=>$params['lid'],"username"=>$_SESSION["current_user"]["user_login"]]);
            $activated = aw_activate_membership($activate_sql_params);
            
            //Rellenamos los datos para payment history
            $sql_data = aw_get_history_insert_data($params['lid'],$_SESSION["payment_account_id"],$_SESSION["current_user"]['user_login'],true);
            /////////////AÑADIMOS LA TRANSACCIÓN AL HISTORY
            $insert_history_id = insert_payment_history($sql_data);
            if(isset($params['payment_history_metas']) and count($params['payment_history_metas']) > 0):
                foreach($params["payment_history_metas"] as $data){
                    $data = (array)$data;
                    $data["payment_history_id"] = $insert_history_id;
                    $metas = insert_payment_history_meta($data);
                }
            endif;
            $resp['msg'] = $_SESSION["checkout_action"].' completed';
            $resp['history_id'] = $insert_history_id;
        endif;

        if($_SESSION["checkout_action"] == 'new' or $_SESSION["checkout_action"] == 'replace'): ///Asignar o reeplazar una membresía
            $deleted = aw_delete_user_memberships(["user_id"=>$_SESSION["current_user"]['ID']]);
            if(!is_wp_error( $deleted )):
                $insert_data = aw_assign_membership(["lid"=>$params['lid'],"username"=>$_SESSION["current_user"]["user_login"]]);                
                $activate_sql_params = aw_generate_activation_membership_data(["lid"=>$params['lid'],"username"=>$_SESSION["current_user"]["user_login"]]);
                $activated = aw_activate_membership($activate_sql_params);                
            endif;
            //Rellenamos los datos para payment history
            $sql_data = aw_get_history_insert_data($params['lid'],$_SESSION["payment_account_id"],$_SESSION["current_user"]['user_login'],true);
            /////////////AÑADIMOS LA TRANSACCIÓN AL HISTORY
            $insert_history_id = insert_payment_history($sql_data);
            if(isset($params['payment_history_metas']) and count($params['payment_history_metas']) > 0):
                foreach($params['payment_history_metas'] as $data){
                    $data = (array)$data;
                    $data['payment_history_id'] = $insert_history_id;
                    $metas = insert_payment_history_meta($data);
                }
            endif;
            
            $resp['msg'] = $_SESSION["checkout_action"].' completed';
        endif;
        
        return $resp;
    }
else:
    echo 'aw_paypal_user_level_operations ya existe';
endif;