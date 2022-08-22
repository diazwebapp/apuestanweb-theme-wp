<?php

if(!function_exists('aw_register_form_checket_user')):
    function aw_register_form_checket_user(WP_REST_Request $request){
        $params = $request->get_params();

        $resp["status"] = "ok";

        if($params['name'] == 'email'):
            $usermail = email_exists( $params["value"] );
            if($usermail){
                $resp["status"] = "fail";
                $resp["msg"] = "El email yá existe";
            }
        endif;
        if($params['name'] == 'username'):
            $username = username_exists( $params["value"] );
            if($username){
                $resp["status"] = "fail";
                $resp["msg"] = "El username yá existe";
            }
        endif;

        return $resp;
    }
else:
    echo 'la funcion aw_register_form_checket_user ya existe';
    die;
endif;

if(!function_exists('aw_register_user')):
    function aw_register_user(WP_REST_Request $request){
        $params = $request->get_params();
        $location = json_decode(GEOLOCATION);

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
        }
        
        $insert_data = false;
        if(!is_wp_error( $user) and $user){ //Preparamos datos para asignar una membresía
            $set_level_data["username"] = $params['username'];
            $set_level_data["lid"] = $params['membership_id'];

            $insert_data = aw_assign_membership($set_level_data); //Asignamos la membresía
            $checkout_page = get_option('ihc_checkout_page');
            if ($checkout_page){ // Seteamos la url de checkout si por defecto
                $resp["redirect_url"] = get_permalink($checkout_page) . "?lid={$params['membership_id']}";
                $_SESSION["checkout_action"] = 'new';
            }
        }

        if(!is_wp_error( $insert_data ) and $insert_data){
            if($params['membership_paid'] == 'free'): //Detectamos si es una membresía free

                $thanks_page = get_option('ihc_thank_you_page');
                if ($checkout_page){ //Cambiamos la url de checkout si es free
                    $resp["redirect_url"] = get_permalink($thanks_page);
                }
                
                //Rellenamos los datos para payment history
                $sql_data["payment_method"] = '';
                $sql_data["payment_account_id"] = 0;
                $sql_data["membership_id"] = $params['membership_id'];
                $sql_data["username"] = $params["username"];
                $sql_data["payment_date"] = date("Y-m-d h:i:s");
                $sql_data["status"] = "completed";
                /////////////AÑADIMOS LA TRANSACCIÓN AL HISTORY
                $insert_history_id = insert_payment_history($sql_data);
                /////Procesamos datos y activamos membresía
                $activate_sql_params = aw_generate_activation_membership_data($set_level_data);
                $activated = aw_activate_membership($activate_sql_params);
                ////////
            endif;

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
        
        ////Datos para operaciones em membresía en caso que sea free
        $prepare_membership_data['username'] = $_SESSION["current_user"]['user_login']; //nombre de usuario
        $prepare_membership_data['lid'] = $params['lid']; //ID de membresía
        /////////////////
        $thanks_page = get_option('ihc_thank_you_page'); //Pagina de gracias
        $checkout_page = get_option('ihc_checkout_page'); ///PAgina de checkout

        $resp['msg'] = 'no hay usuario logeado'; //Mensaje para mostrar en el frontent
        $resp['status'] = 'ok'; //status
        $resp['redirect'] = get_permalink( $checkout_page ); // url de redirección
        $_SESSION["checkout_action"] = "new"; //seteamos variable de sesión que se usará en el checkout
        if($_SESSION["current_user"]['user_login']):
            
            ////////////////DETECTAR MEMBRESIAS ACTIVAS!!!!!!!!!!!!1
            $user_levels = \Indeed\Ihc\UserSubscriptions::getAllForUserAsList( $_SESSION["current_user"]['ID'], true );
            $user_levels = apply_filters( 'ihc_public_get_user_levels', $user_levels, $_SESSION["current_user"]['ID'] );

            if(!empty($user_levels) and strval($user_levels) == strval($params['lid'])): //Si tiene la misma membresía activa, la renovamos
                $resp['msg'] = 'Yá posee una membresía, desea renovar?';
                $resp['status'] = 'ok';
                $_SESSION["checkout_action"] = "renew"; //seteamos variable de sesión que se usará en el checkout
            endif;

            if(!empty($user_levels) and strval($user_levels) != strval($params['lid'])): //Sí tiene una membresia diferente, eliminamos todas y activamos una nueva
                $resp['msg'] = 'Tine otra membresia, desea reemplazar?';
                $resp['status'] = 'ok';
                $_SESSION["checkout_action"] = "replace"; //seteamos variable de sesión que se usará en el checkout
            endif;

            if(empty($user_levels)): ///Si no tiene membresias activas, eliminamos todas y activamos una nueva
                $resp['msg'] = "no posee ninguna membresia";
                $resp['status'] = 'ok';
                $resp['action'] = 'new';
            endif;
        endif;

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
        
        $params = $request->get_json_params(); //extraemos parametros del request body
        $thanks_page = get_option('ihc_thank_you_page'); //Obtenemos pagina de destino
        $_SESSION["payment_account_id"] = $params["payment_account_id"]; ////GUARDAMOS EN SESIÓN EL ACCOUNT ID

        //////Datos para realizar operaciones en membresias
        /////////////
        $payment_method = aw_get_method_name($_SESSION["payment_account_id"]);

        $resp['msg'] = $_SESSION["checkout_action"];
        $resp['redirect'] = get_permalink( $thanks_page );
        
        if($_SESSION["checkout_action"] == 'renew'):   //Renovar una membresia         
            $activate_sql_params = aw_generate_activation_membership_data(["lid"=>$params["lid"],"username"=>$_SESSION["current_user"]["user_login"]]);
            if(!isset($_SESSION["payment_account_id"])){
                $activated = aw_activate_membership($activate_sql_params);
            }
            
            $sql_data = aw_get_history_insert_data($params['lid'],$_SESSION["payment_account_id"],$_SESSION["current_user"]['user_login'],true);
            /////////////AÑADIMOS LA TRANSACCIÓN AL HISTORY
            $insert_history_id = insert_payment_history($sql_data);

            if($params['payment_history_metas']):
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
                $insert_data = aw_assign_membership(["lid"=>$params["lid"],"username"=>$_SESSION["current_user"]["user_login"]]);
                if(!isset($_SESSION["payment_account_id"])){
                    $activate_sql_params = aw_generate_activation_membership_data(["lid"=>$params["lid"],"username"=>$_SESSION["current_user"]["user_login"]]);
                    $activated = aw_activate_membership($activate_sql_params);
                }
            endif;
            //Rellenamos los datos para payment history
            $sql_data["payment_method"] = $payment_method;
            $sql_data["payment_account_id"] = (isset($_SESSION["payment_account_id"]) ? 0 : $_SESSION["payment_account_id"]);
            $sql_data["membership_id"] = $params['lid'];
            $sql_data["username"] = $_SESSION["current_user"]['user_login'];
            $sql_data["payment_date"] = date("Y-m-d h:i:s");
            $sql_data["status"] = (isset($_SESSION["payment_account_id"]) ? "pending" :"completed");
            /////////////AÑADIMOS LA TRANSACCIÓN AL HISTORY
            $insert_history_id = insert_payment_history($sql_data);
            if($params['payment_history_metas']):
                foreach($params['payment_history_metas'] as $data){
                    $data = array($data);
                    $data[0]['payment_history_id'] = $insert_history_id;
                    $metas = insert_payment_history_meta($data[0]);
                    $resp['metas'] = $data;
                }
            endif;
            $resp['msg'] = $_SESSION["checkout_action"].' completed';
            $resp['history_id'] = $insert_history_id;
        endif;
        ////VACIAMOS LAS SESIONES
        //$_SESSION["checkout_action"] = false;
        //$_SESSION["payment_account_id"] = false;
        //$_SESSION["current_user"] = false;
        
        return $resp;
    }
else:
    echo 'aw_user_level_operations ya existe';
endif;
