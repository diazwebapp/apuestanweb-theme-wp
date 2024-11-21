<?php

if (!function_exists('aw_register_form_checket_user')) :
    function aw_register_form_checket_user(WP_REST_Request $request) {
        $params = $request->get_params();
        
        // Verificar que se hayan enviado los parámetros necesarios
        if (!isset($params['name']) || !isset($params['value'])) {
            return wp_send_json_error(array('status' => 'fail', 'msg' => 'Parámetros inválidos'));
        }

        $resp = array("status" => "ok");

        // Verificar si el parámetro es 'email'
        if ($params['name'] === 'email') {
            $usermail = email_exists($params["value"]);
            if ($usermail) {
                $resp["status"] = "fail";
                $resp["msg"] = "El email ya existe";
                return wp_send_json_error($resp); // Retornar respuesta de error si ya existe el email
            }
        }

        // Verificar si el parámetro es 'username'
        if ($params['name'] === 'username') {
            $username = username_exists($params["value"]);
            if ($username) {
                $resp["status"] = "fail";
                $resp["msg"] = "El username ya existe";
                return wp_send_json_error($resp); // Retornar respuesta de error si ya existe el username
            }
        }

        // Si no hubo problemas, retornar éxito
        return wp_send_json_success($resp);
    }
else :
    echo 'La función aw_register_form_checket_user ya existe';
    die;
endif;


if(!function_exists('aw_register_user')):
    function aw_register_user(WP_REST_Request $request){
        $params = $request->get_params();
        $location = json_decode($_SESSION["geolocation"]);

        $resp["status"] = "fail";
        //obtenemos valores del request body  desde javascript
        $username = $params['username'];
        $email = $params['email'];
        $password = $params['password'];
        ///Creamos al usuario
        $user_id = wp_create_user( $username, $password, $email );

        if(!is_wp_error( $user_id )){ //añadimos metadatos de geolocalización y lo autologeamos
            update_user_meta( $user_id, 'country_code_detected', $location->country_code );
            update_user_meta( $user_id, 'country_code_selected', $params["country"] );

            $user['user_login'] = $username;
            $user['user_password'] = $password;
            $user['renember'] = true;
            $user = wp_signon( $user, false );
            
            $resp["status"] = "ok";
        }
    
        return $resp;
    }
else:
    echo 'la funcion aw_register_user ya existe';
    die;
endif;

if(!function_exists('aw_check_user_level')):
    function aw_check_user_level(WP_REST_Request $request){
        $params = $request->get_json_params(); //Obtenemos parametros get 
        
        $prepare_membership_data['lid'] = $params['lid']; //ID de membresía
        $resp['msg'] = "deprecated";
        $resp['status'] = 'fail';

        return $resp;
    }
else:
    echo "aw_check_user_level yá existe";
    die;
endif;

if(!function_exists('aw_user_level_operations')):
    function aw_user_level_operations(WP_REST_Request $request){
        /**
         * los datos obligatorios son:
         * current_user (objects)
         * lid (string)
         * payment_history_metas
         */
        
        $resp['msg'] = 'deprecated';
        $resp['status'] = 'fail';
        
        return $resp;
    }
else:
    echo 'aw_user_level_operations ya existe';
endif;
