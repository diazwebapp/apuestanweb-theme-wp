<?php
global $wpdb;
define("MYSQL_TABLE_PAYMENT_METHODS",$wpdb->prefix . "aw_payment_methods");
define("MYSQL_TABLE_PAYMENT_METHODS_RECEIVED_INPUTS",$wpdb->prefix . "aw_payment_methods_received_inputs");
define("MYSQL_TABLE_PAYMENT_METHODS_REGISTER_INPUTS",$wpdb->prefix . "aw_payment_methods_register_inputs");
define("MYSQL_TABLE_PAYMENT_ACCOUNTS",$wpdb->prefix . "aw_payment_accounts");
define("MYSQL_TABLE_PAYMENT_ACCOUNTS_META",$wpdb->prefix . "aw_payment_accounts_meta");

//creamos la tabla 
function create_payment_tables(){
    
    $sql = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_METHODS." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `payment_method` TEXT,
        `icon_service` TEXT,
        `icon_class` TEXT(19),
        `status` BOOLEAN,
        UNIQUE KEY id (id)
    );";

    $sql_received_inputs = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_METHODS_RECEIVED_INPUTS." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `type` TEXT,
        `name` TEXT,
        `show_ui` BOOLEAN,
        `payment_method_id` INT(11),
        UNIQUE KEY id (id)
    );";

    $sql_register_inputs = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_METHODS_REGISTER_INPUTS." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `type` TEXT,
        `name` TEXT,
        `payment_method_id` INT(11),
        UNIQUE KEY id (id)
    );";

    $sql_payment_accounts = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_ACCOUNTS." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `payment_method` TEXT,
        `country_code` TEXT,
        `payment_method_id` INT(11),
        `status` BOOLEAN,
        UNIQUE KEY id (id)
    );";
    $sql_payment_accounts_metas = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_ACCOUNTS_METAS." (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `key` TEXT,
        `value` TEXT,
        `status` BOOLEAN,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql_received_inputs);
    dbDelta($sql_register_inputs);
    dbDelta($sql_payment_accounts);
}
add_action('init','create_payment_tables');

//querys payment methods
function aw_insert_new_payment_method($method_data){
    global $wpdb ;
    $exists = $wpdb->get_var("SELECT id FROM ".MYSQL_TABLE_PAYMENT_METHODS." WHERE payment_method = '{$method_data["payment_method"]}' ");
    if($exists and !is_wp_error( $exists )):
        return ["status"=>"fail","msg"=>"el metodo de pago ya existe"];
    endif;
    $insert = $wpdb->insert(MYSQL_TABLE_PAYMENT_METHODS,$method_data);
    if($insert == 1 and !is_wp_error( $insert )):
        $id = $wpdb->get_var("SELECT id FROM ".MYSQL_TABLE_PAYMENT_METHODS." ORDER BY id DESC");
        return ["status"=>"ok","msg"=>"Dato insertado correctamente","id"=>$id];
    endif;
    return ["status"=>"fail","msg"=>"no fue posible insertar el dato"];
}
function aw_insert_new_payment_method_received_inputs($method_received){
    global $wpdb ;
    
    $insert = $wpdb->insert(MYSQL_TABLE_PAYMENT_METHODS_RECEIVED_INPUTS,$method_received);
    if($insert == 1 and !is_wp_error( $insert )):
        return ["status"=>"ok","msg"=>"input insertado correctamente"];
    endif;

    return ["status"=>"fail","msg"=>"no fue posible insertar el input para recibir pagos"];
}
function aw_insert_new_payment_method_register_inputs($method_register){
    global $wpdb ;
    
    $insert = $wpdb->insert(MYSQL_TABLE_PAYMENT_METHODS_REGISTER_INPUTS,$method_register);
    if($insert == 1 and !is_wp_error( $insert )):
        return ["status"=>"ok","msg"=>"input insertado correctamente"];
    endif;

    return ["status"=>"fail","msg"=>"no fue posible insertar el input para registrar pagos"];
}
if(!function_exists('aw_select_payment_method')){
    function aw_select_payment_method($id=false,$limit=10){
        global $wpdb;
        $sql = "select * from ".MYSQL_TABLE_PAYMENT_METHODS." limit $limit ";
        $query = false;
        if($id){
            $sql = "select * from ".MYSQL_TABLE_PAYMENT_METHODS." WHERE id = $id";
        }
        $query = $wpdb->get_results($sql);
        if(!is_wp_error( $query )){
            return $query;
        }
        return [];
    }
}else{
    var_dump("la funcion ya existe");
    die;
}
if(!function_exists('aw_select_payment_method_received_inputs')){
    function aw_select_payment_method_received_inputs($id){
        global $wpdb;
        $query = $wpdb->get_results("select * from ".MYSQL_TABLE_PAYMENT_METHODS_RECEIVED_INPUTS." WHERE payment_method_id = $id");
        if(!is_wp_error( $query )){
            return $query;
        }
        return [];
    }
}else{
    var_dump("la funcion ya existe");
    die ;
}
?>