<?php

global $wpdb;
define("MYSQL_PAYMENT_HISTORY",$wpdb->prefix . "aw_payment_history");
define("MYSQL_PAYMENT_HISTORY_METAS",$wpdb->prefix . "aw_payment_history_metas");


//creamos la tabla 
function create_payment_control_table(){

    $sql = "CREATE TABLE ".MYSQL_PAYMENT_HISTORY." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `payment_method` TEXT,
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

function select_payment_history($date=false,$text=false){
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
    $update = $wpdb->update(MYSQL_PAYMENT_HISTORY,$data,$id);
    
    return $update;
}

add_action('init','create_payment_control_table');
?>