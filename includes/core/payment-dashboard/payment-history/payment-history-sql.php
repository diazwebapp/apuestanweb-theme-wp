<?php

global $wpdb;
define("MYSQL_PAYMENT_HISTORY",$wpdb->prefix . "aw_payment_history");
define("MYSQL_PAYMENT_HISTORY_METAS",$wpdb->prefix . "aw_payment_history_metas");


//creamos la tabla 
function create_payment_control_table(){

    $sql = "CREATE TABLE ".MYSQL_PAYMENT_HISTORY." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `payment_method` TEXT,
        `payment_account_id` INT(11),
        `membership_id` INT(11),
        `username` TEXT,
        `select_country_code` TEXT,
        `detected_country_code` TEXT,
        `payment_date` DATETIME,
        `status` TEXT,
        UNIQUE KEY id (id)
    );";

    $sql_meta = "CREATE TABLE ".MYSQL_PAYMENT_HISTORY_METAS." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `key` TEXT,
        `name` TEXT,
        `value` TEXT,
        `payment_history_id` INT(11),
        UNIQUE KEY id (id)
    );";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql_meta);
}
function insert_payment_history($data){
    global $wpdb;
    $insert = $wpdb->insert(MYSQL_PAYMENT_HISTORY,$data);
    if($insert == 1){
        $insert= $wpdb->get_var("SELECT id FROM ".MYSQL_PAYMENT_HISTORY." ORDER BY id DESC");
    }
    return $insert;
}
function insert_payment_history_meta($data){
    global $wpdb;
    $insert = $wpdb->insert(MYSQL_PAYMENT_HISTORY_METAS,$data);
    if($insert == 1){
        $insert= $wpdb->get_var("SELECT id FROM ".MYSQL_PAYMENT_HISTORY_METAS." ORDER BY id DESC");
    }
    return $insert;
}

function select_payment_history($date=false,$text=false, $limit=false){
    global $wpdb ;
    $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY ;

    if($date and !$text){

        if($date["value"] and !$date["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE DATE({$date["key"]}) = '{$date["value"]}' ";
        }

        if(!$date["value"] and $date["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE DATE({$date["key"]}) = '{$date["value2"]}' ";
        }
        if($date["value"] and $date["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE DATE({$date["key"]}) BETWEEN '{$date["value"]}' AND '{$date["value2"]}' ";
        }
    }

    if(!$date and $text){
        if($text["value"] and !$text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key"]}='{$text["value"]}' ";
        }
        if(!$text["value"] and $text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key2"]}='{$text["value2"]}' ";
        }
        if($text["value"] and $text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key"]}='{$text["value"]}' AND {$text["key2"]}='{$text["value2"]}' ";
        }
    }

    if($date and $text){
        if($date["value"] and !$date["value2"] and $text["value"] and !$text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key"]}='{$text["value"]}' AND DATE({$date["key"]}) = '{$date["value"]}' ";
        }

        if(!$date["value"] and $date["value2"] and $text["value"] and !$text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key"]}='{$text["value"]}' AND DATE({$date["key"]}) = '{$date["value2"]}' ";
        }

        if(!$date["value"] and $date["value2"] and !$text["value"] and $text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key2"]}='{$text["value2"]}' AND DATE({$date["key"]}) = '{$date["value2"]}' ";
        }

        if($date["value"] and !$date["value2"] and !$text["value"] and $text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key2"]}='{$text["value2"]}' AND DATE({$date["key"]}) = '{$date["value"]}' ";
        }

        if($date["value"] and $date["value2"] and $text["value"] and !$text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key"]}='{$text["value"]}' AND DATE({$date["key"]}) BETWEEN '{$date["value"]}' AND '{$date["value2"]}' ";
        }
        if($date["value"] and $date["value2"] and !$text["value"] and $text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key2"]}='{$text["value2"]}' AND DATE({$date["key"]}) BETWEEN '{$date["value"]}' AND '{$date["value2"]}' ";
        }
        if($date["value"] and $date["value2"] and $text["value"] and $text["value2"]){
            $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE {$text["key"]}='{$text["value"]}' AND {$text["key2"]}='{$text["value2"]}' AND DATE({$date["key"]}) BETWEEN '{$date["value"]}' AND '{$date["value2"]}' ";
        }
    }
    
    
    $results = $wpdb->get_results($sql_);
    foreach($results as $key => $rs):
        $rs_metas = select_payment_history_meta($rs->id);
        $results[$key]->metas = $rs_metas;
    endforeach;

    return $results;
}

function select_payment_history_meta($account_id){
    global $wpdb ;
    $results = $wpdb->get_results("SELECT * FROM ".MYSQL_PAYMENT_HISTORY_METAS." WHERE payment_history_id='$account_id'");
    
    return $results;
}
function update_payment_history($data,$id){
    global $wpdb;
    if($data["status"] == "completed"):
        //
    endif;
    $update = $wpdb->update(MYSQL_PAYMENT_HISTORY,$data,$id);
    
    return $update;
}

add_action('init','create_payment_control_table');

///////activate membership functions
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

if(!function_exists('aw_activate_membership')):
    function aw_activate_membership($data){
        global $wpdb;
        $table = $wpdb->prefix."ihc_user_levels";
        
        $update = $wpdb->update($table,$data["update"],$data["where"]);
        return $update;
    }
endif;
?>