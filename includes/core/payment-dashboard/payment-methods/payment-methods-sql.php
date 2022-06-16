<?php
global $wpdb, $payment_methods, $payment_accounts,$payment_accounts_meta;
define("MYSQL_TABLE_PAYMENT_ACCOUNTS",$wpdb->prefix . "aw_payment_accounts");
define("MYSQL_TABLE_PAYMENT_ACCOUNTS_META",$wpdb->prefix . "aw_payment_accounts_meta");

$payment_methods = [
    ["name"=>"pago movil","key"=>"mobile_payment"],
    ["name" =>"transferencia","key"=>"bank_transfer"],
    ["name" =>"binance","key"=>"binance"],
    ["name" =>"airtm","key"=>"airtm"]
];

//creamos la tabla 
function create_payment_table(){

    $sql = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_ACCOUNTS." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `bank_name` TEXT,
        `country_code` TEXT,
        `payment_method` TEXT,
        `type_dni` TEXT,
        `dni` INT(19),
        `titular` TEXT,
        `status` BOOLEAN,
        UNIQUE KEY id (id)
    );";

    $sql_meta = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_ACCOUNTS_META." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `key` TEXT,
        `value` TEXT,
        `payment_account` INT(11),
        UNIQUE KEY id (id)
    );";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql_meta);
}
add_action('init','create_payment_table');
//queries payment methods
function insert_payment_account($data){
    global $wpdb ;

    $insert = $wpdb->insert(MYSQL_TABLE_PAYMENT_ACCOUNTS,$data);
    if($insert == 1):
        $id = $wpdb->get_var("SELECT id FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS." ORDER BY id DESC");
        return $id;
    else:
        return $insert;
    endif;
}

function insert_payment_account_metadata($data){
    global $wpdb ;
    $insert = $wpdb->insert(MYSQL_TABLE_PAYMENT_ACCOUNTS_META,$data);
    if($insert == 1):
        $id = $wpdb->get_var("SELECT id FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS." ORDER BY id DESC");
        return $id;
    else:
        return $insert;
    endif;
}
function select_payment_accounts($method,$country_code=false){
    global $wpdb ;
  
    $location_filter = "AND country_code = '{$country_code}'";
    
    $results = $wpdb->get_results("SELECT * FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS." WHERE payment_method='$method' ".($country_code!=''?$location_filter:'')." ");
    foreach($results as $key => $account):
        $rs_metas = select_payment_accounts_meta($account->id);
        $results[$key]->metas = $rs_metas;
    endforeach;

    return $results;
}
function select_payment_accounts_meta($account_id){
    global $wpdb ;
    $results = $wpdb->get_results("SELECT * FROM ".MYSQL_TABLE_PAYMENT_ACCOUNTS_META." WHERE payment_account='$account_id'");
    
    return $results;
}
function delete_payment_account($id){
    global $wpdb ;
    $deleted = $wpdb->delete(MYSQL_TABLE_PAYMENT_ACCOUNTS,["id"=>$id]);
    if(!is_wp_error( $delete )){
        $array_metas = select_payment_accounts_meta($id);
        foreach($array_metas as $meta){
            delete_payment_account_meta($meta->id);
        }
    }
    return $deleted;
}
function delete_payment_account_meta($id){
    global $wpdb ;
    $deleted = $wpdb->delete(MYSQL_TABLE_PAYMENT_ACCOUNTS_META,["id"=>$id]);
    return $deleted;
}
function get_payment_methods(){
    global $payment_methods;
    return $payment_methods;
}
function get_payment_method($key){
    global $payment_methods;
    return $payment_methods[$key];
}
?>