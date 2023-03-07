<?php
///////Genera datos de activación de la membresía
if(!function_exists("aw_generate_activation_membership_data")):
    function aw_generate_activation_membership_data($activation_data){
      global $wpdb;
          $table_leve_metas = $wpdb->prefix."ihc_memberships_meta";        
          $membership_metas = $wpdb->get_results("SELECT * FROM $table_leve_metas WHERE membership_id={$activation_data['lid']} ");
          $type_level=[];
          $user_id = username_exists( $activation_data['username'] );
          
          if($membership_metas and !is_wp_error( $membership_metas ) and $user_id):
              $type = ["D"=>"day","W"=>"week","M"=>"month","Y"=>"year"];
              $date_ = ["dias" => false,"type"=>false];
              $user_activation["update"] = [];
              $user_activation["where"] = ["user_id"=>$user_id,"level_id"=>$activation_data['lid']];
              foreach ($membership_metas as $keymeta => $anclameta) {
                //regular
                  if($anclameta->meta_value === "regular_period"){
                   
                    foreach($membership_metas as $key => $meta):
                      if($meta->meta_key == "access_regular_time_type"):
                        $date_["type"] = $type[$meta->meta_value];
                      endif;
  
                      if($meta->meta_key == "access_regular_time_value"):
                        $date_["dias"] = $meta->meta_value;
                      endif;
                    endforeach;
                    $user_activation["update"]["expire_time"] = date("Y-m-d", strtotime("+{$date_['dias']} {$date_['type']}"));
                    $user_activation["update"]["update_time"] = date("Y-m-d h:i:s");
                    return $user_activation;
                  }
                //limited
                  if($anclameta->meta_value === "limited"){
                   
                    foreach($membership_metas as $key => $meta):
                      if($meta->meta_key == "access_limited_time_type"):
                        $date_["type"] = $type[$meta->meta_value];
                      endif;
  
                      if($meta->meta_key == "access_limited_time_value"):
                        $date_["dias"] = $meta->meta_value;
                      endif;
                    endforeach;
                    $user_activation["update"]["expire_time"] = date("Y-m-d", strtotime("+{$date_['dias']} {$date_['type']}"));
                    $user_activation["update"]["update_time"] = date("Y-m-d h:i:s");
                    return $user_activation;
                  }
                //interval
                  if($anclameta->meta_value === "date_interval"){
                    $start="";
                    $end="";
                    foreach($membership_metas as $key => $meta):
                      if($meta->meta_key == "access_interval_start"):
                        $start = $meta->meta_value;
                      endif;
                      if($meta->meta_key == "access_interval_end"):
                        $end = $meta->meta_value;
                      endif;
                    endforeach;
                    $user_activation["update"]["expire_time"] = date("Y-m-d", strtotime($end));
                    $user_activation["update"]["update_time"] = date("Y-m-d", strtotime($start));
                    
                    return $user_activation;
                  }
                //unlimited
                  if($anclameta->meta_value === "unlimited"){
                    $user_activation["update"]["expire_time"] = "3000-11-11 00:00:00";
                    $user_activation["update"]["update_time"] = date("Y-m-d h:i:s");
                    return $user_activation;
                  }
              }
              return $user_activation;
          endif;
    }
else:
    echo "error";
endif;
/////Generar datos para una nueva membresía
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
//////Asigna la membresía
if(!function_exists('aw_assign_membership')):
    function aw_assign_membership($prepare_membership_data){
        $membership_assign_result = aw_generate_new_membership_data($prepare_membership_data);
        global $wpdb;
        $table_level = $wpdb->prefix."ihc_user_levels";
        $insert_data = $wpdb->insert($table_level,$membership_assign_result);
        return $insert_data;
    }
else:
    echo 'aw_assign_membership ya existe';
    die;
endif;

//////Activa la membresía
if(!function_exists('aw_update_user_membership')):
    function aw_update_user_membership($data){
        global $wpdb;
        $table = $wpdb->prefix."ihc_user_levels";
        
        $update = $wpdb->update($table,$data["update"],$data["where"]);
        
        return $update;
    }
endif;

if(!function_exists('aw_delete_user_memberships')):
    function aw_delete_user_memberships($data=[]){
        global $wpdb;
        $table_level = $wpdb->prefix."ihc_user_levels";
        $result = $wpdb->delete($table_level,$data);
        return $result;
    }
else:
    echo 'aw_delete_user_memberships ya existe';
    die;
endif;

if(!function_exists("aw_get_method_name")):
  function aw_get_method_name($payment_account_id){
    global $wpdb;
    $payment_method = 'free';
    if(isset($payment_account_id)):
      $table_accounts = $wpdb->prefix."aw_payment_accounts";
      $payment_method_id = $wpdb->get_var("SELECT payment_method_id FROM $table_accounts WHERE id=$payment_account_id");

      $table_methods = $wpdb->prefix."aw_payment_methods";
      $payment_method = $wpdb->get_var("SELECT payment_method FROM $table_methods WHERE id=$payment_method_id");
    endif;
    return $payment_method;
  }
else:
  echo "la funcion aw_get_method_name ya existe";
endif;