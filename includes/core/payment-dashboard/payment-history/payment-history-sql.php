<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb, $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
define("MYSQL_PAYMENT_HISTORY",$wpdb->prefix . "aw_payment_history");
define("MYSQL_PAYMENT_HISTORY_METAS",$wpdb->prefix . "aw_payment_history_metas");


//creamos la tabla 

function create_payment_control_table(){
    global $charset_collate;
    $table_1 = MYSQL_PAYMENT_HISTORY;

    $sql = "CREATE TABLE IF NOT EXISTS $table_1 (
        id bigint(50) NOT NULL auto_increment,
        payment_method TEXT,
        payment_account_id bigint(50),
        membership_id bigint(50),
        username TEXT,
        payment_date DATETIME,
        status TEXT,
        UNIQUE KEY id (id)
    ) $charset_collate;";

    dbDelta($sql);
}

function create_payment_control_table_2(){
  global $charset_collate;
  $table_2 = MYSQL_PAYMENT_HISTORY_METAS;
  $refer = MYSQL_PAYMENT_HISTORY;

  $sql_meta = "CREATE TABLE IF NOT EXISTS $table_2 (
      id bigint(50) NOT NULL auto_increment,
      meta_key TEXT,
      meta_value TEXT,
      payment_history_id bigint(50),
      UNIQUE KEY id (id)
  ) $charset_collate; ";
  
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

function select_payment_history($params=["status"=>"pending"]){
    global $wpdb ;
    $sql_ = "SELECT * FROM ".MYSQL_PAYMENT_HISTORY." WHERE status = '{$params['status']}' ";

    /* if($date and !$text){

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
    } */
    
    
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
    
    $update = $wpdb->update(MYSQL_PAYMENT_HISTORY,$data,$id);
    
    return $update;
}
function aw_get_history_insert_data($level_id,$payment_account_id,$username,$status){
    global $wpdb;
    $payment_method = aw_get_method_name($payment_account_id);
    $table = $wpdb->prefix."ihc_memberships";
    $level_data = $wpdb->get_row("SELECT payment_type,short_description, label, price FROM $table WHERE id=$level_id");
    $status = "pending";
    if($status or $level_data->payment_type == 'free'):
        $status = 'complete';
    endif;
    $sql_data["payment_method"] = $payment_method;
    $sql_data["payment_account_id"] = $payment_account_id;
    $sql_data["membership_id"] = $level_id;
    $sql_data["username"] = $username;
    $sql_data["payment_date"] = date("Y-m-d h:i:s");
    $sql_data["status"] = $status;
    return $sql_data;
}
add_action('init','create_payment_control_table');
add_action('init','create_payment_control_table_2');

?>