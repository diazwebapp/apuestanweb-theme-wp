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

//front handlers

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

        $username = $params['username'];
        $email = $params['email'];
        $password = $params['password'];
    
        $user_id = wp_create_user( $username, $password, $email );
        
        $user['user_login'] = $username;
        $user['user_password'] = $password;
        $user['renember'] = true;

        if(!is_wp_error( $user_id )){
            $user = wp_signon( $user, false );
        }
        
        $insert_data = false;
        if(!is_wp_error( $user) and $user){
            $prepare_membership_data["username"] = $params['username'];
            $prepare_membership_data["lid"] = $params['membership_id'];

            $membership_assign_result = aw_generate_new_membership_data($prepare_membership_data);
            global $wpdb;
            $table_level = $wpdb->prefix."ihc_user_levels";
            $insert_data = $wpdb->insert($table_level,$membership_assign_result);
            $checkout_page = get_option('ihc_checkout_page');
            if ($checkout_page){
                $resp["redirect_url"] = get_permalink($checkout_page) . "?lid={$params['membership_id']}";
            }
        }

        if(!is_wp_error( $insert_data ) and $insert_data){
            /////////////AÑADIMOS LA TRANSACCIÓN AL HISTORY
            //Rellenamos los datos para payment history
            $sql_data["payment_method"] = '';
            $sql_data["payment_account_id"] = 0;
            $sql_data["membership_id"] = $params['membership_id'];
            $sql_data["username"] = $params["username"];
            $sql_data["select_country_code"] = $params["country"];
            $sql_data["detected_country_code"] = $location->country_code;
            $sql_data["payment_date"] = date("Y-m-d h:i:s");
            $sql_data["status"] = "pending";
        
            $insert_history_id = insert_payment_history($sql_data);

            if($params['membership_paid'] == 'free'):
                $thanks_page = get_option('ihc_thank_you_page');
                if ($checkout_page){
                    $resp["redirect_url"] = get_permalink($thanks_page);
                }
                $activate_sql_params = aw_generate_activation_membership_data($prepare_membership_data);
                $activated = aw_activate_membership($activate_sql_params);

                $array_id['id'] = $insert_history_id;
                $array_data["status"] = "completed";
                $array_data["payment_method"] = '';
                $array_data["payment_account_id"] = 0;
                $update = update_payment_history($array_data,$array_id);

            endif;
            
            $resp["status"] = "ok";
        }
        
        return $resp;
    }
else:
    echo 'la funcion aw_register_user ya existe';
    die;
endif;

if(!function_exists('aw_generate_new_membership_data')):
    function aw_generate_new_membership_data($prepare_membership_data){
        $activate_data = aw_generate_activation_membership_data($prepare_membership_data);

        $assing_data["user_id"] = intval($activate_data['where']['user_id']);
        $assing_data["level_id"] = intval($activate_data['where']['level_id']);
        $assing_data["start_time"] = date("Y-m-d h:i:s", strtotime($activate_data['update']['update_time']));
        $assing_data["update_time"] = date("Y-m-d h:i:s", strtotime($activate_data['update']['update_time']));
        $assing_data["expire_time"] = "0000-00-00 00:00:00";
        $assing_data["notification"] = 0;
        $assing_data["status"] = 1;        
        
        return $assing_data;
    }
else:
    echo('la funcion aw_generate_new_membership_data');
    die;
endif;