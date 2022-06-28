<?php
global $wpdb;
define("MYSQL_TABLE_PAYMENT_METHODS",$wpdb->prefix . "aw_payment_methods");
define("MYSQL_TABLE_PAYMENT_METHODS_RECEIVED_INPUTS",$wpdb->prefix . "aw_payment_methods_received_inputs");
define("MYSQL_TABLE_PAYMENT_METHODS_REGISTER_INPUTS",$wpdb->prefix . "aw_payment_methods_register_inputs");

//creamos la tabla 
function create_sql_payment_methods_tables(){
    
    $sql_methods = "CREATE TABLE ".MYSQL_TABLE_PAYMENT_METHODS." (
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

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($sql_methods);
    dbDelta($sql_received_inputs);
    dbDelta($sql_register_inputs);
}
add_action('init','create_sql_payment_methods_tables');

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
    function aw_select_payment_method($id=false,$status=false,$payment_method=false,$limit=false,$order=false){
        global $wpdb;
        $query = false;
        $sql = "SELECT * FROM ".MYSQL_TABLE_PAYMENT_METHODS." WHERE status=$status ";
        if($status == 'any'):
            $sql = "SELECT * FROM ".MYSQL_TABLE_PAYMENT_METHODS." WHERE 1 ";
        endif;
        if($id){
            $sql .= "AND id = $id ";
        }
        if($payment_method){
            $sql .= "AND payment_method = '$payment_method' ";
        }
        
        if($order){
            $sql .= "ORDER BY {$order['key']} {$order['order']} ";
        }
        if($limit){
            $sql .= "LIMIT $limit ";
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
    function aw_select_payment_method_received_inputs($method_id){
        global $wpdb;
        $query = $wpdb->get_results("select * from ".MYSQL_TABLE_PAYMENT_METHODS_RECEIVED_INPUTS." WHERE payment_method_id = $method_id");
        if(!is_wp_error( $query )){
            return $query;
        }
        return [];
    }
}else{
    var_dump("la funcion ya existe");
    die ;
}
if(!function_exists('aw_select_payment_method_register_inputs')){
    function aw_select_payment_method_register_inputs($method_id){
        global $wpdb;
        $query = $wpdb->get_results("select * from ".MYSQL_TABLE_PAYMENT_METHODS_REGISTER_INPUTS." WHERE payment_method_id = $method_id");
        if(!is_wp_error( $query )){
            return $query;
        }
        return [];
    }
}else{
    var_dump("la funcion aw_select_payment_method_register_inputs ya existe");
    die ;
}
if(!function_exists('aw_update_payment_method')):
    function aw_update_payment_method($data=false,$id=false){
        global $wpdb;
        $update = $wpdb->update(MYSQL_TABLE_PAYMENT_METHODS,$data,$id);
    }
else:
    echo 'la funcion aw_update_payment_method ya existe';
endif;
if(!function_exists('aw_delete_payment_method')):
    function aw_delete_payment_method($id){
        global $wpdb;
        $delete = $wpdb->delete(MYSQL_TABLE_PAYMENT_METHODS,["id"=>$id]);
    }
else:
    echo 'la funcion aw_delete_payment_method ya existe';
endif;
if(!function_exists('aw_delete_payment_method_received_inputs')):
    function aw_delete_payment_method_received_inputs($data){
        global $wpdb;
        $delete_register = $wpdb->delete(MYSQL_TABLE_PAYMENT_METHODS_RECEIVED_INPUTS,$data);
    }
else:
    echo 'la funcion aw_delete_payment_method_received_inputs ya existe';
endif;
if(!function_exists('aw_delete_payment_method_register_inputs')):
    function aw_delete_payment_method_register_inputs($data){
        global $wpdb;
        $delete_register = $wpdb->delete(MYSQL_TABLE_PAYMENT_METHODS_REGISTER_INPUTS,$data);
    }
else:
    echo 'la funcion aw_delete_payment_method_register_inputs ya existe';
endif;